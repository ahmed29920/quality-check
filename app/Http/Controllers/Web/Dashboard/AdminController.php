<?php

namespace App\Http\Controllers\Web\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\CreateAdminRequest;
use App\Http\Requests\Web\UpdateAdminRequest;
use App\Services\UserService;
use App\Services\RoleService;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    protected $userService, $roleService;

    public function __construct(UserService $userService, RoleService $roleService)
    {
        $this->userService = $userService;
        $this->roleService = $roleService;
    }

    /**
     * Display a listing of users.
     */
    public function index(Request $request)
    {
        $admins = $this->userService->getAll($request, 'admin');
        return view('dashboard.admins.index', compact('admins'));
    }

    /**
     * Display the specified user.
     */
    public function show($id)
    {
        $user = $this->userService->findById($id);
        return view('dashboard.admins.show', compact('user'));
    }

    public function create()
    {
        $roles = $this->roleService->all();
        return view('dashboard.admins.create',compact('roles'));
    }

    public function store(CreateAdminRequest $request)
    {
        $data = $request->validated();

        $this->userService->store($data);

        return redirect()->route('admin.admins.index')->with('success', 'Admin created!');
    }

    public function edit($id){
        $admin = $this->userService->findById($id);
        $roles = $this->roleService->all();
        return view('dashboard.admins.edit',compact('admin','roles'));
    }

    public function update(UpdateAdminRequest $request , $id){
        $user = $this->userService->findById($id);

        $data = $request->validated();

        $this->userService->update($user,$data);

        return redirect()->route('admin.admins.index')->with('success', 'Admin created!');
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

        $html = view('dashboard.admins._rows', compact('users'))->render();

        return response()->json(['html' => $html]);
    }
}
