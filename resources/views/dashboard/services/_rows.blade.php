@foreach ($services as $key => $service)
    <tr class="{{ $service->trashed() ? 'table-secondary' : '' }}">
        <td>{{ $key + 1 }}</td>
        <td>
            @if ($service->image_url)
                <img src="{{ $service->image_url }}" class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
            @else
                <div class="bg-light rounded d-flex align-items-center justify-content-center"
                    style="width: 50px; height: 50px;">
                    <i class="fas fa-cogs text-muted"></i>
                </div>
            @endif
        </td>
        <td>
            <h6 class="mb-1">
                {{ $service->getTranslation('name', app()->getLocale()) }}
            </h6>
        </td>
        <td>
            @if ($service->category)
                <a href="{{ route('admin.categories.show', $service->category) }}" class="text-purple">
                    {{ $service->category->getTranslation('name', app()->getLocale()) }}

                </a>
            @else
                <span class="text-muted">No Category</span>
            @endif
        </td>
        <td>
            @if ($service->trashed())
                <span class="badge bg-danger">Deleted</span>
            @elseif($service->is_active)
                <span class="badge bg-success">Active</span>
            @else
                <span class="badge bg-secondary">Inactive</span>
            @endif
        </td>
        <td>
            @if ($service->is_pricable)
                <span class="badge bg-success">Yes</span>
            @else
                <span class="badge bg-danger">No</span>
            @endif
        </td>
        <td class="text-center">
            @if (!$service->trashed())
                <div class="btn-group">
                    <a href="{{ route('admin.services.show', $service) }}" class="btn btn-sm btn-outline-info">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-edit"></i>
                    </a>
                    <button type="button" class="btn btn-sm btn-outline-danger"
                        onclick="deleteService('{{ $service->slug }}')">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            @else
                <div class="btn-group">
                    {{-- restore --}}
                    <button type="button" class="btn btn-sm btn-outline-success"
                        onclick="restoreService('{{ $service->slug }}')">
                        <i class="fas fa-undo"></i>
                    </button>
                    {{-- force delete --}}
                    <button type="button" class="btn btn-sm btn-outline-danger"
                        onclick="forceDeleteService('{{ $service->slug }}')">
                        <i class="fas fa-times"></i>
                    </button>

                </div>
            @endif
        </td>
    </tr>
@endforeach
