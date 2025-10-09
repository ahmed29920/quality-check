@foreach ($providers as $provider)
    <tr>
        <td>
            <div class="d-flex align-items-center">
                <div class="avatar-sm me-3">
                    @if ($provider->image)
                        <img src="{{ $provider->image_url }}" alt="{{ $provider->name }}" class="rounded-circle"
                            style="width: 40px; height: 40px; object-fit: cover;">
                    @else
                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center"
                            style="width: 40px; height: 40px;">
                            <i class="fas fa-user text-muted"></i>
                        </div>
                    @endif
                </div>
                <div>
                    <h6 class="mb-1 fw-bold">{{ $provider->name }}</h6>
                    <small class="text-muted">ID: {{ $provider->id }}</small>
                </div>
            </div>
        </td>
        <td>
            @if ($provider->category)
                <span class="badge bg-info">{{ $provider->category->name }}</span>
            @else
                <span class="text-muted">No Category</span>
            @endif
        </td>
        <td>
            @if ($provider->badge)
                <span class="badge bg-primary">{{ $provider->badge->name }}</span>
            @else
                <span class="text-muted">No Badge</span>
            @endif
        </td>
        <td>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" {{ $provider->is_verified ? 'checked' : '' }}
                    onchange="toggleProviderVerification({{ $provider->id }})">
            </div>
        </td>
        <td>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" {{ $provider->is_active ? 'checked' : '' }}
                    onchange="toggleProviderStatus({{ $provider->id }})">
            </div>
        </td>
        <td>
            <small
                class="text-muted">{{ $provider->created_at->format('M d, Y') }}<br>{{ $provider->created_at->diffForHumans() }}</small>
        </td>
        <td class="text-center">
            <div class="btn-group">
                <a href="{{ route('admin.providers.show', $provider) }}" class="btn btn-sm btn-outline-info"><i
                        class="fas fa-eye"></i></a>
                <a href="{{ route('admin.providers.edit', $provider) }}" class="btn btn-sm btn-outline-warning"><i
                        class="fas fa-edit"></i></a>
            </div>
        </td>
    </tr>
@endforeach

@if ($providers->isEmpty())
    <tr>
        <td colspan="7" class="text-center text-muted py-4">
            <i class="fas fa-users fa-2x mb-2"></i>
            <div>No providers found</div>
        </td>
    </tr>
@endif
