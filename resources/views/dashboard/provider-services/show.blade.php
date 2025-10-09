@extends('dashboard.layouts.app')

@section('title', 'Provider Service Details - ' . $providerService->service->name)

@section('content')
    <div class="container-fluid py-4">
        {{-- Header Card --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center">
                            @if ($providerService->image)
                                <img src="{{ $providerService->image_url }}" alt="{{ $providerService->service->name }}" class="rounded me-3"
                                    style="width: 60px; height: 60px; object-fit: cover;">
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center me-3"
                                    style="width: 60px; height: 60px;">
                                    <i class="fas fa-cogs fa-2x text-muted"></i>
                                </div>
                            @endif
                            <div>
                                <h4 class="mb-0 text-info fw-bold">{{ $providerService->service->name }}</h4>
                                <small class="text-muted">Service ID: {{ $providerService->id }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 text-end">
                        <div class="d-flex gap-2 justify-content-end">
                            <button class="btn {{ $providerService->is_active ? 'btn-outline-danger' : 'btn-outline-success' }}"
                                onclick="toggleProviderServiceStatus('{{ $providerService->uuid }}')">
                                <i class="fas fa-toggle-{{ $providerService->is_active ? 'on' : 'off' }}"></i>
                                {{ $providerService->is_active ? 'Deactivate' : 'Activate' }}
                            </button>
                            <a href="{{ route('admin.provider-services.edit', $providerService->uuid) }}" class="btn btn-outline-warning">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabs Navigation --}}
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent p-0">
                <ul class="nav nav-tabs nav-tabs-custom" id="providerServiceTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="information-tab" data-bs-toggle="tab" data-bs-target="#information"
                                type="button" role="tab" aria-controls="information" aria-selected="true">
                            <i class="fas fa-info-circle me-2"></i>Information
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="provider-tab" data-bs-toggle="tab" data-bs-target="#provider"
                                type="button" role="tab" aria-controls="provider" aria-selected="false">
                            <i class="fas fa-user me-2"></i>Provider Details
                        </button>
                    </li>
                </ul>
            </div>

            <div class="card-body">
                <div class="tab-content" id="providerServiceTabsContent">
                    {{-- Information Tab --}}
                    <div class="tab-pane fade show active" id="information" role="tabpanel" aria-labelledby="information-tab">
                        <div class="row">
                            <div class="col-md-8">
                                {{-- Service Information --}}
                                <div class="card border-0 shadow mb-4">
                                    <div class="card-body">
                                        <h5 class="fw-bold text-dark mb-3">
                                            <i class="fas fa-cogs text-info me-2"></i>Service Information
                                        </h5>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <h6 class="fw-bold text-muted mb-1">Service Name</h6>
                                                    <p class="mb-0">{{ $providerService->service->name }}</p>
                                                </div>

                                                <div class="mb-3">
                                                    <h6 class="fw-bold text-muted mb-1">Service Category</h6>
                                                    <p class="mb-0">
                                                        <span class="badge bg-info">{{ $providerService->service->category->name ?? 'No Category' }}</span>
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <h6 class="fw-bold text-muted mb-1">Price</h6>
                                                    <p class="mb-0">
                                                        @if ($providerService->price)
                                                            <span class="badge bg-success fs-6">${{ number_format($providerService->price, 2) }}</span>
                                                        @else
                                                            <span class="text-muted">Not Set</span>
                                                        @endif
                                                    </p>
                                                </div>

                                                <div class="mb-3">
                                                    <h6 class="fw-bold text-muted mb-1">Status</h6>
                                                    <p class="mb-0">
                                                        @if ($providerService->is_active)
                                                            <span class="badge bg-success fs-6">
                                                                <i class="fas fa-check me-1"></i>Active
                                                            </span>
                                                        @else
                                                            <span class="badge bg-danger fs-6">
                                                                <i class="fas fa-times me-1"></i>Inactive
                                                            </span>
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Description --}}
                                @if ($providerService->description)
                                    <div class="card border-0 shadow mb-4">
                                        <div class="card-body">
                                            <h5 class="fw-bold text-dark mb-3">
                                                <i class="fas fa-align-left text-info me-2"></i>Description
                                            </h5>
                                            <p class="mb-0">{!! strip_tags($providerService->getTranslation('description', app()->getLocale())) !!}</p>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-4">
                                {{-- Service Image --}}
                                <div class="card border-0 shadow mb-3">
                                    <div class="card-body text-center">
                                        <h6 class="fw-bold text-dark mb-3">
                                            <i class="fas fa-image text-info me-2"></i>Service Image
                                        </h6>
                                        @if ($providerService->image)
                                            <img src="{{ $providerService->image_url }}" alt="{{ $providerService->service->name }}"
                                                 class="img-fluid rounded mb-3" style="max-height: 200px;">
                                        @else
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center mb-3"
                                                 style="height: 200px;">
                                                <i class="fas fa-image fa-3x text-muted"></i>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                {{-- Meta Information --}}
                                <div class="card border-0 shadow">
                                    <div class="card-body">
                                        <h6 class="fw-bold text-dark mb-3">
                                            <i class="fas fa-info-circle text-info me-2"></i>Meta Information
                                        </h6>

                                        <div class="mb-2">
                                            <small class="text-muted d-block">
                                                <i class="fas fa-calendar-plus me-1"></i>
                                                <strong>Created:</strong> {{ $providerService->created_at->format('M d, Y') }}
                                            </small>
                                        </div>

                                        <div class="mb-2">
                                            <small class="text-muted d-block">
                                                <i class="fas fa-clock me-1"></i>
                                                <strong>Last Updated:</strong> {{ $providerService->updated_at->format('M d, Y') }}
                                            </small>
                                        </div>

                                        <div class="mb-2">
                                            <small class="text-muted d-block">
                                                <i class="fas fa-hashtag me-1"></i>
                                                <strong>Service ID:</strong> {{ $providerService->id }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Provider Details Tab --}}
                    <div class="tab-pane fade" id="provider" role="tabpanel" aria-labelledby="provider-tab">
                        <div class="row">
                            <div class="col-md-12">
                                {{-- Provider Information --}}
                                <div class="card border-0 shadow mb-4">
                                    <div class="card-body">
                                        <div class="row justify-content-between">
                                            <div class="col">
                                                <h5 class="fw-bold text-dark mb-3">
                                                    <i class="fas fa-user text-info me-2"></i>Provider Information
                                                </h5>

                                            </div>
                                            <div class="col text-end">
                                                <a href="{{ route('admin.providers.show', $providerService->provider->slug) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i> View Provider
                                                </a>

                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <h6 class="fw-bold text-muted mb-1">Provider Name</h6>
                                                    <p class="mb-0">{{ $providerService->provider->name }}</p>
                                                </div>

                                                <div class="mb-3">
                                                    <h6 class="fw-bold text-muted mb-1">Category</h6>
                                                    <p class="mb-0">
                                                        <span class="badge bg-info">{{ $providerService->provider->category->name ?? 'No Category' }}</span>
                                                    </p>
                                                </div>

                                                <div class="mb-3">
                                                    <h6 class="fw-bold text-muted mb-1">Badge</h6>
                                                    <p class="mb-0">
                                                        <span class="badge bg-info">{{ $providerService->provider->badge->name ?? 'No Badge' }}</span>
                                                    </p>
                                                </div>

                                            </div>

                                            <div class="col-md-6">
                                                @if ($providerService->provider->website_link)
                                                    <div class="mb-3">
                                                        <h6 class="fw-bold text-muted mb-1">Website</h6>
                                                        <p class="mb-0">
                                                            <a href="{{ $providerService->provider->website_link }}" target="_blank" class="text-decoration-none">
                                                                <i class="fas fa-globe text-primary me-1"></i>
                                                                {{ $providerService->provider->website_link }}
                                                            </a>
                                                        </p>
                                                    </div>
                                                @endif

                                                <div class="mb-3">
                                                    <h6 class="fw-bold text-muted mb-1">Status</h6>
                                                    <p class="mb-0">
                                                        @if ($providerService->provider->is_active)
                                                            <span class="badge bg-success fs-6">
                                                                <i class="fas fa-check me-1"></i>Active
                                                            </span>
                                                        @else
                                                            <span class="badge bg-danger fs-6">
                                                                <i class="fas fa-times me-1"></i>Inactive
                                                            </span>
                                                        @endif
                                                    </p>
                                                </div>

                                                <div class="mb-3">
                                                    <h6 class="fw-bold text-muted mb-1">Verification</h6>
                                                    <p class="mb-0">
                                                        @if ($providerService->provider->is_verified)
                                                            <span class="badge bg-success fs-6">
                                                                <i class="fas fa-check me-1"></i>Verified
                                                            </span>
                                                        @else
                                                            <span class="badge bg-warning fs-6">
                                                                <i class="fas fa-times me-1"></i>Unverified
                                                            </span>
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleProviderServiceStatus(providerServiceId) {
            fetch(`/admin/provider-services/${providerServiceId}/toggle-status`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Failed to update provider service status');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to update provider service status');
            });
        }
    </script>
@endsection

