@extends('dashboard.layouts.app')

@section('title', 'Service Details')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-4">
                {{-- Service Card --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-transparent">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 text-info fw-bold">Service Information</h5>
                            <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        {{-- Service Image --}}
                        @if ($service->image_url)
                            <img src="{{ $service->image_url }}"
                                alt="{{ $service->getTranslation('name', app()->getLocale()) }}"
                                class="img-fluid rounded mb-3">
                        @else
                            <div class="bg-light rounded p-5 text-center mb-3">
                                <i class="fas fa-cogs fa-3x text-muted"></i>
                            </div>
                        @endif

                        {{-- Service Info --}}
                        <h4 class="fw-bold text-info mb-2">
                            {{ $service->getTranslation('name', app()->getLocale()) }}
                        </h4>

                        @if ($service->getTranslation('description', app()->getLocale()))
                            <p class="text-muted mb-3">
                                {!! strip_tags($service->getTranslation('description', app()->getLocale())) !!}
                            </p>
                        @endif

                        {{-- Status Badges --}}
                        <div class="mb-3">
                            @if ($service->is_active)
                                <span class="badge bg-success me-2">Active</span>
                            @else
                                <span class="badge bg-secondary me-2">Inactive</span>
                            @endif

                            @if ($service->is_pricable)
                                <span class="badge bg-warning">Pricable Service</span>
                            @endif
                        </div>

                        {{-- Pricing Info --}}
                        @if ($service->is_pricable)
                            <div class="border-top pt-3">
                                <h6 class="fw-bold text-success">Pricing</h6>
                                <p class="mb-1">
                                    <i class="fas fa-dollar-sign"></i>
                                    Price:
                                    <strong>${{ number_format($service->price, 2) }}</strong>
                                </p>
                                <p class="mb-0">
                                    <i class="fas fa-clock"></i>
                                    Duration:
                                    <strong>{{ $service->duration }} minutes</strong>
                                </p>
                            </div>
                        @endif

                        {{-- Category Info --}}
                        @if ($service->category)
                            <div class="border-top pt-3 mt-3">
                                <h6 class="fw-bold text-purple">Category</h6>
                                <span class="badge bg-secondary">
                                    {{ $service->category->getTranslation('name', app()->getLocale()) }}
                                </span>
                            </div>
                        @endif

                        {{-- Meta Info --}}
                        <div class="border-top pt-3 mt-3">
                            <small class="text-muted">
                                <i class="fas fa-calendar-plus"></i> Created:
                                {{ $service->created_at->format('M d, Y') }}<br>
                                <i class="fas fa-clock"></i> Updated: {{ $service->updated_at->format('M d, Y') }}
                            </small>
                        </div>
                    </div>
                </div>

                {{-- Quick Actions --}}
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-transparent">
                        <h6 class="mb-0 text-info fw-bold">Quick Actions</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-outline-primary">
                                <i class="fas fa-edit"></i> Edit Service
                            </a>

                            <a href="{{ route('admin.providers.index', ['service_id' => $service->id]) }}"
                                class="btn btn-outline-info">
                                <i class="fas fa-users"></i> Manage Providers
                            </a>

                            <a href="{{ route('admin.providers.create', ['service_id' => $service->id]) }}"
                                class="btn btn-outline-success">
                                <i class="fas fa-plus"></i> Add Provider
                            </a>

                            <form action="{{ route('admin.services.destroy', $service) }}" method="POST"
                                onsubmit="return confirm('Are you sure? This will delete the service and all its providers.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger w-100">
                                    <i class="fas fa-trash"></i> Delete Service
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                {{-- Statistics --}}
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card border-0 shadow-sm text-center">
                            <div class="card-body">
                                <h3 class="text-info fw-bold">{{ $service->providers_count ?? 0 }}</h3>
                                <p class="text-muted mb-0">Total Providers</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-0 shadow-sm text-center">
                            <div class="card-body">
                                <h3 class="text-success fw-bold">${{ number_format($service->price, 2) }}</h3>
                                <p class="text-muted mb-0">Service Price</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-0 shadow-sm text-center">
                            <div class="card-body">
                                <h3 class="text-warning fw-bold">
                                    {{ $service->providers()->where('is_active', true)->count() }}</h3>
                                <p class="text-muted mb-0">Active Providers</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-0 shadow-sm text-center">
                            <div class="card-body">
                                <h3 class="text-primary fw-bold">{{ $service->duration }}</h3>
                                <p class="text-muted mb-0">Duration (min)</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Providers List --}}
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-transparent">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 text-info fw-bold">Service Providers</h5>
                            <a href="{{ route('admin.providers.create', ['service_id' => $service->id]) }}"
                                class="btn btn-info btn-sm">
                                <i class="fas fa-plus"></i> Add Provider
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($service->providers && $service->providers->count() > 0)
                            @foreach ($service->providers as $index => $provider)
                                <div class="provider-item border rounded p-3 mb-3">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <div>
                                                    <h6 class="mb-1 text-info fw-bold">
                                                        Provider {{ $index + 1 }}
                                                        @if (!$provider->is_active)
                                                            <span class="badge bg-secondary ms-2">Inactive</span>
                                                        @endif
                                                    </h6>
                                                    <span class="text-muted small">
                                                        Rating: {{ $provider->rating ?? 'N/A' }}
                                                        | Experience: {{ $provider->experience_years ?? 0 }} years
                                                    </span>
                                                </div>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('admin.providers.edit', $provider) }}"
                                                        class="btn btn-outline-primary btn-sm">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-outline-danger btn-sm"
                                                        onclick="deleteProvider({{ $provider->id }})">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>

                                            <p class="mb-2">{{ $provider->name }}</p>

                                            @if ($provider->specialties)
                                                <div class="specialties-preview">
                                                    <small class="text-muted">Specialties:</small>
                                                    <div class="d-flex flex-wrap gap-1 mt-1">
                                                        @foreach (explode(',', $provider->specialties) as $specialty)
                                                            <span class="badge bg-light text-dark">
                                                                {{ trim($specialty) }}
                                                            </span>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="col-md-4 text-end">
                                            <div class="provider-meta">
                                                @if ($provider->is_verified)
                                                    <span class="badge bg-success mb-1">
                                                        Verified Provider
                                                    </span>
                                                @else
                                                    <span class="badge bg-warning mb-1">Pending Verification</span>
                                                @endif

                                                @if ($provider->location)
                                                    <div class="mt-2">
                                                        <small class="text-muted">
                                                            <i class="fas fa-map-marker-alt"></i> {{ $provider->location }}
                                                        </small>
                                                    </div>
                                                @endif

                                                <div class="mt-2">
                                                    <small class="text-muted">
                                                        Added: {{ $provider->created_at->format('M d, Y') }}
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No Providers Yet</h5>
                                <p class="text-muted">This service doesn't have any providers assigned.</p>
                                <a href="{{ route('admin.providers.create', ['service_id' => $service->id]) }}"
                                    class="btn btn-info">
                                    <i class="fas fa-plus"></i> Add First Provider
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function deleteProvider(providerId) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'This will delete the provider from this service.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Delete Provider',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/admin/providers/${providerId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => {
                            if (response.ok) {
                                Swal.fire(
                                    'Deleted!',
                                    'The provider has been deleted.',
                                    'success'
                                ).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire(
                                    'Error!',
                                    'Something went wrong. Please try again.',
                                    'error'
                                );
                            }
                        })
                        .catch(error => {
                            Swal.fire('Error deleting provider.', error.message, 'error');
                        });
                }
            });
        }
    </script>
@endpush