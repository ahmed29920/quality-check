<?php

namespace App\Http\Controllers\Web\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of users.
     */
    public function index(Request $request)
    {
        $users = $this->userService->getAll($request, 'user');
        return view('dashboard.users.index', compact('users'));
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        return view('dashboard.users.show', compact('user'));
    }

    /**
     * Toggle user active status
     */
    public function toggleStatus(User $user)
    {
        try {
            $this->userService->toggleActiveStatus($user);

            return response()->json([
                'success' => true,
                'message' => 'User status updated successfully',
                'is_active' => $user->fresh()->is_active
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update user status'
            ], 500);
        }
    }

    /**
     * Delete user
     */
    public function destroy(User $user)
    {
        try {
            $this->userService->delete($user);

            return response()->json([
                'success' => true,
                'message' => 'User deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete user'
            ], 500);
        }
    }

    public function filter(Request $request)
    {
        $users = $this->userService->getAll($request, 'user');

        $html = view('dashboard.users._rows', compact('users'))->render();

        return response()->json(['html' => $html]);
    }
}
