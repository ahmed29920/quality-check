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

                            {{-- مؤقتاً نشيل إدارة البروفايدرز --}}
                            {{-- <a href="{{ route('admin.providers.index', ['service_id' => $service->id]) }}"
                                class="btn btn-outline-info">
                                <i class="fas fa-users"></i> Manage Providers
                            </a>

                            <a href="{{ route('admin.providers.create', ['service_id' => $service->id]) }}"
                                class="btn btn-outline-success">
                                <i class="fas fa-plus"></i> Add Provider
                            </a> --}}

                            <form action="{{ route('admin.services.destroy', $service) }}" method="POST"
                                onsubmit="return confirm('Are you sure? This will delete the service.')">
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
                
            </div>
        </div>
    </div>
@endsection
