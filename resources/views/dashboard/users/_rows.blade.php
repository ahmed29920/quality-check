@foreach($users as $user)
    <tr>
        <td>
            <div class="d-flex align-items-center">
                <div class="avatar-sm me-3">
                    @if($user->image)
                        <img src="{{ $user->image_url }}" alt="{{ $user->name }}" 
                             class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                    @else
                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center" 
                             style="width: 40px; height: 40px;">
                            <i class="fas fa-user text-muted"></i>
                        </div>
                    @endif
                </div>
                <div>
                    <h6 class="mb-1 fw-bold">{{ $user->name }}</h6>
                    <small class="text-muted">ID: {{ $user->id }}</small>
                </div>
            </div>
        </td>
        <td>
            @if($user->email)
                <div><i class="fas fa-envelope text-muted me-1"></i><small>{{ $user->email }}</small></div>
            @endif
            @if($user->phone)
                <div><i class="fas fa-phone text-muted me-1"></i><small>{{ $user->phone }}</small></div>
            @endif
        </td>
        <td>
            @if($user->is_verified)
                <span class="badge bg-success"><i class="fas fa-check"></i> Verified</span>
            @else
                <span class="badge bg-warning"><i class="fas fa-times"></i> Unverified</span>
            @endif
        </td>
        <td>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" {{ $user->is_active ? 'checked' : '' }}
                    onchange="toggleUserStatus({{ $user->id }})">
            </div>
        </td>
        <td>
            <small class="text-muted">{{ $user->created_at->format('M d, Y') }}<br>{{ $user->created_at->diffForHumans() }}</small>
        </td>
        <td class="text-center">
            <div class="btn-group">
                <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-outline-info"><i class="fas fa-eye"></i></a>
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteUser({{ $user->id }})">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </td>
    </tr>
@endforeach

@if($users->isEmpty())
    <tr>
        <td colspan="6" class="text-center text-muted py-4">
            <i class="fas fa-users fa-2x mb-2"></i>
            <div>No users found</div>
        </td>
    </tr>
@endif
