@foreach ($providerServices as $providerService)
    <tr>
        <td>
            <div class="d-flex align-items-center">
                <div class="avatar-sm me-3">
                    @if ($providerService->image)
                        <img src="{{ $providerService->image_url }}" alt="{{ $providerService->service->name }}" class="rounded"
                            style="width: 40px; height: 40px; object-fit: cover;">
                    @else
                        <div class="bg-light rounded d-flex align-items-center justify-content-center"
                            style="width: 40px; height: 40px;">
                            <i class="fas fa-cogs text-muted"></i>
                        </div>
                    @endif
                </div>
                <div>
                    <a href="{{ route('admin.services.show', $providerService->service->slug) }}">
                        <h6 class="mb-1 fw-bold">{{ $providerService->service->name }}</h6>
                    </a>
                    <small class="text-muted">ID: {{ $providerService->id }}</small>
                </div>
            </div>
        </td>
        <td>
            <div class="d-flex align-items-center">
                <a href="{{ route('admin.providers.show', $providerService->provider->slug) }}">
                @if ($providerService->provider->image)
                    <img src="{{ $providerService->provider->image_url }}" alt="{{ $providerService->provider->name }}"
                         class="rounded-circle me-2" style="width: 30px; height: 30px; object-fit: cover;">
                @else
                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-2"
                         style="width: 30px; height: 30px;">
                        <i class="fas fa-user text-muted" style="font-size: 12px;"></i>
                    </div>
                @endif
                <div>
                    <small class="fw-bold">{{ $providerService->provider->name }}</small>
                    <br>
                    <small class="text-muted">{{ $providerService->provider->category->name ?? 'No Category' }}</small>
                </div>
                </a>
            </div>
        </td>
        <td>
            @if ($providerService->price)
                <span class="badge bg-success">${{ number_format($providerService->price, 2) }}</span>
            @else
                <span class="text-muted">Not Set</span>
            @endif
        </td>
        <td>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" {{ $providerService->is_active ? 'checked' : '' }}
                    onchange="toggleProviderServiceStatus({{ $providerService->id }})">
            </div>
        </td>
        <td>
            <small class="text-muted">{{ $providerService->created_at->format('M d, Y') }}<br>{{ $providerService->created_at->diffForHumans() }}</small>
        </td>
        <td class="text-center">
            <div class="btn-group">
                <a href="{{ route('admin.provider-services.show', $providerService) }}" class="btn btn-sm btn-outline-info"><i class="fas fa-eye"></i></a>
                <a href="{{ route('admin.provider-services.edit', $providerService) }}" class="btn btn-sm btn-outline-warning"><i class="fas fa-edit"></i></a>
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteProviderService('{{ $providerService->uuid }}')">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </td>
    </tr>
@endforeach

@if ($providerServices->isEmpty())
    <tr>
        <td colspan="6" class="text-center text-muted py-4">
            <i class="fas fa-list fa-2x mb-2"></i>
            <div>No provider services found</div>
        </td>
    </tr>
@endif

