<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AuthService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Register a new user
     */
    public function register(array $data): array
    {
        // Check if user already exists
        $existingUser = $this->userRepository->findByPhone($data['phone']);
        if ($existingUser) {
            throw new \Exception('User with this phone number already exists');
        }

        // Create user
        $userData = [
            'name' => $data['name'],
            'phone' => $data['phone'],
            'password' => Hash::make($data['password']),
            'is_active' => true,
        ];

        // Add email if provided
        if (isset($data['email']) && !empty($data['email'])) {
            $userData['email'] = $data['email'];
        }

        $user = $this->userRepository->create($userData);

        // Create phone verification code
        $verificationCode = $this->generateVerificationCode();
        $this->userRepository->createPhoneVerificationCode($user, $verificationCode);

        return [
            'user' => $user,
            'verification_code' => $verificationCode // Only for testing, remove in production
        ];
    }

    /**
     * Login user with phone and password
     */
    public function login(string $phone, string $password): array
    {
        $user = $this->userRepository->findByPhone($phone);
        
        if (!$user || !Hash::check($password, $user->password)) {
            throw new \Exception('Invalid credentials');
        }

        if (!$user->is_active) {
            throw new \Exception('Account is deactivated');
        }

        // Create token
        $token = $user->createToken('auth-token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token
        ];
    }

    /**
     * Verify phone number
     */
    public function verifyPhone(string $phone, string $code): array
    {
        $user = $this->userRepository->findByPhone($phone);
        
        if (!$user) {
            throw new \Exception('User not found');
        }

        if ($user->phone_verified_at) {
            throw new \Exception('Phone number already verified');
        }

        if (!$this->userRepository->verifyPhoneVerificationCode($phone, $code)) {
            throw new \Exception('Invalid or expired verification code');
        }

        // Update phone verification status
        $this->userRepository->updatePhoneVerification($user, true);
        $this->userRepository->deletePhoneVerificationCode($phone);

        return ['user' => $user];
    }

    /**
     * Resend phone verification code
     */
    public function resendPhoneVerificationCode(string $phone): array
    {
        $user = $this->userRepository->findByPhone($phone);
        
        if (!$user) {
            throw new \Exception('User not found');
        }

        if ($user->phone_verified_at) {
            throw new \Exception('Phone number already verified');
        }

        $verificationCode = $this->generateVerificationCode();
        $this->userRepository->createPhoneVerificationCode($user, $verificationCode);

        return [
            'user' => $user,
            'verification_code' => $verificationCode // Only for testing, remove in production
        ];
    }

    /**
     * Logout user
     */
    public function logout(User $user): bool
    {
        // Delete current access token
        $user->currentAccessToken()->delete();
        return true;
    }

    /**
     * Change password
     */
    public function changePassword(User $user, string $currentPassword, string $newPassword): bool
    {
        if (!Hash::check($currentPassword, $user->password)) {
            throw new \Exception('Current password is incorrect');
        }

        return $this->userRepository->updatePassword($user, $newPassword);
    }

    /**
     * Send password reset email
     */
    public function sendPasswordResetEmail(string $email): array
    {
        $user = $this->userRepository->findByEmail($email);
        
        if (!$user) {
            throw new \Exception('User with this email not found');
        }

        $resetCode = $this->generateVerificationCode();
        $this->userRepository->createPasswordResetToken($user, $resetCode);

        // Send email with reset code
        Mail::send('emails.password-reset', [
            'user' => $user,
            'resetCode' => $resetCode
        ], function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('Password Reset Code');
        });

        return [
            'message' => 'Password reset code sent to your email',
            'reset_code' => $resetCode // Only for testing, remove in production
        ];
    }

    /**
     * Verify password reset code
     */
    public function verifyPasswordResetCode(string $email, string $code)
    {
        return $this->userRepository->verifyPasswordResetToken($email, $code);
    }

    /**
     * Reset password with code
     */
    public function resetPassword(string $email, string $code, string $newPassword): array
    {
        if (!$this->verifyPasswordResetCode($email, $code)) {
            throw new \Exception('Invalid or expired reset code');
        }

        $user = $this->userRepository->findByEmail($email);
        if (!$user) {
            throw new \Exception('User not found');
        }

        $this->userRepository->updatePassword($user, $newPassword);
        $this->userRepository->deletePasswordResetToken($email);

        return ['user' => $user];
    }

    /**
     * Update user profile
     */
    public function updateProfile(User $user, array $data): User
    {
        $allowedFields = ['name', 'email','phone'];
        $updateData = array_intersect_key($data, array_flip($allowedFields));

        if (empty($updateData)) {
            throw new \Exception('No valid fields to update');
        }

        // If phone is being changed, mark it as unverified
        if (isset($updateData['phone']) && $updateData['phone'] !== $user->phone) {
            $updateData['phone_verified_at'] = null;
        }

        return $this->userRepository->update($updateData, $user);
    }

    /**
     * Get authenticated user
     */
    public function getAuthenticatedUser(): User
    {
        return Auth::user();
    }

    /**
     * Generate verification code
     */
    private function generateVerificationCode(): string
    {
        return 123456;
        // return str_pad(random_int(100000, 999999), 6, '0', STR_PAD_LEFT);
    }
}
