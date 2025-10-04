<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Models\User;
use Illuminate\Http\Request;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Get all users with filtering and pagination
     */
    public function getAll(Request $request, $role)
    {
        return $this->userRepository->filter($request->all(), $role)->get();
    }


    /**
     * Get user by ID
     */
    public function findById($id): ?User
    {
        return $this->userRepository->findById($id);
    }

    /**
     * Get user statistics
     */
    public function getStatistics(): array
    {
        $totalUsers = $this->userRepository->getQuery()->count();
        $activeUsers = $this->userRepository->getQuery()->where('is_active', true)->count();
        $verifiedUsers = $this->userRepository->getQuery()->where('is_verified', true)->count();
        $phoneVerifiedUsers = $this->userRepository->getQuery()->whereNotNull('phone_verified_at')->count();
        $emailVerifiedUsers = $this->userRepository->getQuery()->whereNotNull('phone_verified_at')->count();

        return [
            'total_users' => $totalUsers,
            'active_users' => $activeUsers,
            'verified_users' => $verifiedUsers,
            'phone_verified_users' => $phoneVerifiedUsers,
            'email_verified_users' => $emailVerifiedUsers,
            'inactive_users' => $totalUsers - $activeUsers,
            'unverified_users' => $totalUsers - $verifiedUsers,
        ];
    }

    /**
     * Toggle user active status
     */
    public function toggleActiveStatus(User $user): bool
    {
        return $user->update(['is_active' => !$user->is_active]);
    }

    /**
     * Delete user
     */
    public function delete(User $user): bool
    {
        return $this->userRepository->delete($user);
    }
}
