@extends('dashboard.layouts.app')

@section('title', 'Provider Subscription Details')

@section('content')
    <div class="container-fluid py-4">
        {{-- Page Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold text-purple mb-0">
                <i class="fas fa-id-card me-2"></i> Provider Subscription Details
            </h4>
            <a href="{{ route('admin.provider-subscriptions.index') }}" class="btn btn-outline-info btn-sm">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
        </div>

        <div class="row">
            {{-- Provider Card --}}
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-header bg-purple bg-opacity-10 border-0 rounded-top-4">
                        <h6 class="mb-0 fw-bold text-white">
                            <i class="fas fa-user-tie me-1"></i> Provider Information
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <a href="{{ route('admin.providers.show', $providerSubscription->provider->slug) }}">
                            <small class="text-muted">Provider Name</small>
                            <p class="fw-bold">{{ $providerSubscription->provider->name }}</p>
                            </a>
                        </div>
                        <div class="mb-3">
                            <a href="{{ route('admin.categories.show', $providerSubscription->provider->category->slug) }}">
                            <small class="text-muted">Category</small>
                            <p class="fw-bold">{{ $providerSubscription->provider->category->name }}</p>
                            </a>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">Badge</small>
                            <span class="badge bg-success fs-6">
                                <i class="fas fa-award me-1"></i>{{ $providerSubscription->provider->badge->name }}
                            </span>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">Phone</small>
                            <p class="fw-bold">{{ $providerSubscription->provider->user->phone }}</p>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">Email</small>
                            <p class="fw-bold">{{ $providerSubscription->provider->user->email }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Subscription Info Card --}}
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-header bg-purple bg-opacity-10 border-0 rounded-top-4">
                        <h6 class="mb-0 fw-bold text-white">
                            <i class="fas fa-calendar-alt me-1"></i> Subscription Details
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <small class="text-muted">Start Date</small>
                            <p class="fw-bold">{{ $providerSubscription->start_date }}</p>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">End Date</small>
                            <p class="fw-bold">{{ $providerSubscription->end_date }}</p>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">Status</small>
                            <p class="fw-bold">
                                <span
                                    class="badge
                                @if ($providerSubscription->status === 'active') bg-success
                                @elseif($providerSubscription->status === 'pending') bg-warning
                                @else bg-danger @endif">
                                    {{ ucfirst($providerSubscription->status) }}
                                </span>
                            </p>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">Amount</small>
                            <p class="fw-bold text-success">{{ number_format($providerSubscription->amount, 2) }} EGP</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Payment Card --}}
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-header bg-purple bg-opacity-10 border-0 rounded-top-4">
                        <h6 class="mb-0 fw-bold text-white">
                            <i class="fas fa-credit-card me-1"></i> Payment Information
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <small class="text-muted">Payment Method</small>
                            <p class="fw-bold">{{ ucfirst($providerSubscription->payment_method) }}</p>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">Payment Status</small>
                            <p class="fw-bold">
                                <span
                                    class="badge
                                @if ($providerSubscription->payment_status === 'paid') bg-success
                                @elseif($providerSubscription->payment_status === 'pending') bg-warning
                                @else bg-danger @endif">
                                    {{ ucfirst($providerSubscription->payment_status) }}
                                </span>
                            </p>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">UUID</small>
                            <p class="fw-bold text-secondary">{{ $providerSubscription->uuid }}</p>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">Created At</small>
                            <p class="fw-bold">{{ $providerSubscription->created_at->format('Y-m-d H:i') }}</p>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">Updated At</small>
                            <p class="fw-bold">{{ $providerSubscription->updated_at->format('Y-m-d H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
