@foreach($admins as $admin)
    <tr>
        <td>
            <div class="d-flex align-items-center">
                <div class="avatar-sm me-3">
                    @if($admin->image)
                        <img src="{{ $admin->image_url }}" alt="{{ $admin->name }}"
                             class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                    @else
                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center"
                             style="width: 40px; height: 40px;">
                            <i class="fas fa-user text-muted"></i>
                        </div>
                    @endif
                </div>
                <div>
                    <h6 class="mb-1 fw-bold">{{ $admin->name }}</h6>
                    <small class="text-muted">ID: {{ $admin->id }}</small>
                </div>
            </div>
        </td>
        <td>
            @if($admin->email)
                <div><i class="fas fa-envelope text-muted me-1"></i><small>{{ $admin->email }}</small></div>
            @endif
            @if($admin->phone)
                <div><i class="fas fa-phone text-muted me-1"></i><small>{{ $admin->phone }}</small></div>
            @endif
        </td>
        <td>
            {{ $admin->getRoleNames()->first() }}
        </td>
        <td>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" {{ $admin->is_active ? 'checked' : '' }}
                    onchange="toggleUserStatus({{ $admin->id }})">
            </div>
        </td>
        <td>
            <small class="text-muted">{{ $admin->created_at->format('M d, Y') }}<br>{{ $admin->created_at->diffForHumans() }}</small>
        </td>
        <td class="text-center">
            <div class="btn-group">
                <a href="{{ route('admin.admins.show', $admin) }}" class="btn btn-sm btn-outline-info"><i class="fas fa-eye"></i></a>
                <a href="{{ route('admin.admins.edit', $admin) }}" class="btn btn-sm btn-outline-warning"><i class="fa fa-edit"></i></a>

                <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteUser({{ $admin->id }})">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </td>
    </tr>
@endforeach

@if($admins->isEmpty())
    <tr>
        <td colspan="6" class="text-center text-muted py-4">
            <i class="fas fa-admins fa-2x mb-2"></i>
            <div>No admins found</div>
        </td>
    </tr>
@endif
