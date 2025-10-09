@extends('dashboard.layouts.app')

@section('content')
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header">
                <h6>Edit Admin</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.admins.update', $admin->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" name="name" value="{{ $admin->name }}" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" value="{{ $admin->email }}" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Phone</label>
                        <input type="text" name="phone" value="{{ $admin->phone }}" class="form-control" required>
                    </div>

                    <div class="mb-3" id="role_container">
                        <label>User Role</label>
                        <select name="assigned_role" class="form-control">
                            <option value="">Select Role</option>
                            @foreach ($roles as $role)
                                @if ($role->name !== 'user')
                                    <option value="{{ $role->name }}" {{ $admin->hasRole($role->name) ? 'selected' : '' }}>
                                        {{ strtoupper($role->name) }}
                                    </option>
                                @endif
                            @endforeach

                        </select>
                    </div>


                    <div class="mb-3">
                        <label>Profile Image</label>
                        <input type="file" name="image" class="form-control">
                        @if ($admin->image)
                            <img src="{{ asset('storage/' . $admin->image) }}" alt="Profile" class="img-thumbnail mt-2" width="80">
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary">Update Admin</button>
                </form>
            </div>
        </div>
    </div>
@endsection
