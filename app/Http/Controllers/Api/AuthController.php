<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Requests\Api\RegisterRequest;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\VerifyPhoneRequest;
use App\Http\Requests\Api\ChangePasswordRequest;
use App\Http\Requests\Api\SendPasswordResetRequest;
use App\Http\Requests\Api\VerifyResetCodeRequest;
use App\Http\Requests\Api\ResetPasswordRequest;
use App\Http\Requests\Api\UpdateProfileRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Register a new user
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $result = $this->authService->register($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'User registered successfully. Please verify your phone number.',
            'data' => [
                'user' => new UserResource($result['user'])
            ]
        ], 201);
    }

    /**
     * Login user with phone and password
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $data = $request->validated();
        $result = $this->authService->login(
            $data['phone'],
            $data['password']
        );

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'data' => [
                'user' => new UserResource($result['user']),
                'token' => $result['token']
            ]
        ], 200);
    }

    /**
     * Verify phone number
     */
    public function verifyPhone(VerifyPhoneRequest $request): JsonResponse
    {
        $data = $request->validated();
        $result = $this->authService->verifyPhone(
            $data['phone'],
            $data['code']
        );

        return response()->json([
            'success' => true,
            'message' => 'Phone number verified successfully',
            'data' => [
                'user' => new UserResource($result['user'])
            ]
        ], 200);
    }

    /**
     * Resend phone verification code
     */
    public function resendPhoneVerification(Request $request): JsonResponse
    {
        $request->validate([
            'phone' => 'required|string|regex:/^[0-9+\-\s()]+$/'
        ]);

        $result = $this->authService->resendPhoneVerificationCode($request->phone);

        return response()->json([
            'success' => true,
            'message' => 'Verification code sent successfully',
            'data' => [
                'user' => new UserResource($result['user']),
                'verification_code' => $result['verification_code'] // Remove in production
            ]
        ], 200);
    }

    /**
     * Logout user
     */
    public function logout(Request $request): JsonResponse
    {
        $this->authService->logout($request->user());

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully'
        ], 200);
    }

    /**
     * Change password
     */
    public function changePassword(ChangePasswordRequest $request): JsonResponse
    {
        $data = $request->validated();
        $this->authService->changePassword(
            $data['user'],
            $data['current_password'],
            $data['password']
        );

        return response()->json([
            'success' => true,
            'message' => 'Password changed successfully'
        ], 200);
    }

    /**
     * Send password reset email
     */
    public function sendPasswordReset(SendPasswordResetRequest $request): JsonResponse
    {
        $data = $request->validated();
        $result = $this->authService->sendPasswordResetEmail($data['email']);

        return response()->json([
            'success' => true,
            'message' => $result['message'],
            'reset_code' => $result['reset_code'] // Remove in production
        ], 200);
    }

    /**
     * Verify password reset code
     */
    public function verifyResetCode(VerifyResetCodeRequest $request): JsonResponse
    {
        $data = $request->validated();
        $isValid = $this->authService->verifyPasswordResetCode(
            $data['email'],
            $data['code']
        );


        if ($isValid) {
            return response()->json([
                'success' => true,
                'message' => 'Reset code is valid'
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired reset code'
            ], 400);
        }
    }

    /**
     * Reset password with code
     */
    public function resetPassword(ResetPasswordRequest $request)
    {
        $data = $request->validated();
        $result = $this->authService->resetPassword(
            $data['email'],
            $data['code'],
            $data['password']
        );

        return response()->json([
            'success' => true,
            'message' => 'Password reset successfully',
            'data' => [
                'user' => new UserResource($result['user'])
            ]
        ], 200);
    }

    /**
     * Update user profile
     */
    public function updateProfile(UpdateProfileRequest $request): JsonResponse
    {
        $user = $this->authService->updateProfile(
            $request->user(),
            $request->validated()
        );

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully',
            'data' => [
                'user' => new UserResource($user)
            ]
        ], 200);
    }

    /**
     * Get authenticated user profile
     */
    public function me(Request $request): JsonResponse
    {
        $user = $this->authService->getAuthenticatedUser();

        return response()->json([
            'success' => true,
            'message' => 'User profile retrieved successfully',
            'data' => [
                'user' => new UserResource($user)
            ]
        ], 200);
    }
}
