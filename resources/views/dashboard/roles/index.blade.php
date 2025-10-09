@extends('dashboard.layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h6>Roles</h6>
            <a href="{{ route('admin.roles.create') }}" class="btn btn-purple btn-sm">Add Role</a>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Permissions</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($roles as $role)
                    <tr>
                        <td>{{ $role->id }}</td>
                        <td>{{ $role->name }}</td>
                        <td>{{ $role->permissions->pluck('name')->join(', ') }}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-outline-warning btn-sm">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this role?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </div>

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
