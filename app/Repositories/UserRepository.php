<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    protected User $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function create(array $data): User
    {
        return $this->model->create($data);
    }

    public function findById($id): ?User
    {
        return $this->model->find($id);
    }

    public function findByPhone($phone): ?User
    {
        return $this->model->where('phone', $phone)->first();
    }

    public function findByEmail($email): ?User
    {
        return $this->model->where('email', $email)->first();
    }

    public function findByPhoneOrEmail($phoneOrEmail): ?User
    {
        return $this->model->where('phone', $phoneOrEmail)
            ->orWhere('email', $phoneOrEmail)
            ->first();
    }

    public function update(array $data, User $user): User
    {
        $user->update($data);
        return $user->fresh();
    }

    public function updatePassword(User $user, string $password): bool
    {
        return $user->update(['password' => Hash::make($password)]);
    }

    public function updatePhoneVerification(User $user, bool $verified = true): bool
    {
        return $user->update(['phone_verified_at' => $verified ? now() : null, 'is_verified' => $verified]);
    }

    public function updateEmailVerification(User $user, bool $verified = true): bool
    {
        return $user->update(['phone_verified_at' => $verified ? now() : null]);
    }

    public function delete(User $user): bool
    {
        return $user->delete();
    }

    public function getQuery()
    {
        return $this->model->query();
    }

    public function createPasswordResetToken(User $user, string $token): void
    {
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            [
                'token' => Hash::make($token),
                'created_at' => now()
            ]
        );
    }

    public function verifyPasswordResetToken(string $email, string $token): bool
    {
        $passwordReset = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->first();

        if (!$passwordReset) {
            return false;
        }

        return Hash::check($token, $passwordReset->token);
    }

    public function deletePasswordResetToken(string $email): void
    {
        DB::table('password_reset_tokens')
            ->where('email', $email)
            ->delete();
    }

    public function createPhoneVerificationCode(User $user, string $code): void
    {
        DB::table('phone_verification_codes')->updateOrInsert(
            ['phone' => $user->phone],
            [
                'code' => $code,
                'expires_at' => now()->addMinutes(5),
                'created_at' => now()
            ]
        );
    }

    public function verifyPhoneVerificationCode(string $phone, string $code): bool
    {
        $verification = DB::table('phone_verification_codes')
            ->where('phone', $phone)
            ->where('code', $code)
            ->where('expires_at', '>', now())
            ->first();

        return $verification !== null;
    }

    public function deletePhoneVerificationCode(string $phone): void
    {
        DB::table('phone_verification_codes')
            ->where('phone', $phone)
            ->delete();
    }
    public function filter(array $filters, $role = null)
    {
        $query = $this->model->query();

        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', "%{$filters['search']}%")
                    ->orWhere('email', 'like', "%{$filters['search']}%")
                    ->orWhere('phone', 'like', "%{$filters['search']}%");
            });
        }

        if (isset($filters['is_active'])) {
            $query->where('is_active', $filters['is_active']);
        }

        if (isset($filters['is_verified'])) {
            $query->where('is_verified', $filters['is_verified']);
        }

        if ($role) {
            $query->where('role', $role);
        }

        return $query->latest();
    }
}
