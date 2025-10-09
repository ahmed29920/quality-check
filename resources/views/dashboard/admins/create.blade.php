@extends('dashboard.layouts.app')

@section('content')
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header">
                <h6>Add Admin</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.admins.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Phone</label>
                        <input type="text" name="phone" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <div class="mb-3" id="role_container">
                        <label>Admin Role</label>
                        <select name="assigned_role" class="form-control">
                            <option value="">Select Role</option>
                            @foreach ($roles as $role)
                                @if ($role->name !== 'User')
                                    <option value="{{ $role->name }}">{{ strtoupper($role->name) }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>


                    <div class="mb-3">
                        <label>Profile Image</label>
                        <input type="file" name="image" class="form-control">
                    </div>

                    <button type="submit" class="btn btn-purple">Create Admin</button>
                </form>
            </div>
        </div>
    </div>
@endsection
