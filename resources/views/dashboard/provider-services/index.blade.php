@extends('dashboard.layouts.app')

@section('title', 'Provider Services Management')

@section('content')
    <div class="container-fluid py-4">
        {{-- Header Card --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h4 class="mb-0 text-purple fw-bold">Provider Services Management</h4>
                        <small class="text-muted">Manage services offered by providers</small>
                    </div>
                    <div class="col-md-6 text-end">
                        <div class="d-flex gap-2 justify-content-end">
                            <button class="btn btn-outline-info">
                                <i class="fas fa-download"></i> Export
                            </button>
                            <button class="btn btn-outline-success" onclick="refreshProviderServices()">
                                <i class="fas fa-sync"></i> Refresh
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Filters Card --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent">
                <h6 class="mb-0 text-info fw-bold">
                    <i class="fas fa-filter"></i> Filters
                </h6>
            </div>
            <div class="card-body">
                <form id="filterForm" class="row g-3">
                    {{-- Search --}}
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Search</label>
                        <input type="text" name="search" class="form-control" placeholder="Service name, provider name">
                    </div>

                    {{-- Provider --}}
                    <div class="col-md-2">
                        <label class="form-label fw-bold">Provider</label>
                        <select name="provider_id" class="form-select">
                            <option value="">All Providers</option>
                            @foreach(\App\Models\Provider::active()->get() as $provider)
                                <option value="{{ $provider->id }}">{{ $provider->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Service --}}
                    <div class="col-md-2">
                        <label class="form-label fw-bold">Service</label>
                        <select name="service_id" class="form-select">
                            <option value="">All Services</option>
                            @foreach(\App\Models\Service::active()->get() as $service)
                                <option value="{{ $service->id }}">{{ $service->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Status --}}
                    <div class="col-md-2">
                        <label class="form-label fw-bold">Status</label>
                        <select name="is_active" class="form-select">
                            <option value="">All</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>

                    {{-- Price Range --}}
                    <div class="col-md-2">
                        <label class="form-label fw-bold">Price Range</label>
                        <select name="price_range" class="form-select">
                            <option value="">All Prices</option>
                            <option value="0-50">$0 - $50</option>
                            <option value="50-100">$50 - $100</option>
                            <option value="100-200">$100 - $200</option>
                            <option value="200+">$200+</option>
                        </select>
                    </div>

                    <div class="col-md-1">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-flex gap-2">
                            <button class="btn btn-purple"><i class="fas fa-search"></i> Filter</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Provider Services Table --}}
        @if ($providerServices->count() > 0)
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent">
                    <h6 class="mb-0 text-info fw-bold">
                        <i class="fas fa-list"></i> Provider Services List ({{ $providerServices->count() }} total)
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0">Service</th>
                                    <th class="border-0">Provider</th>
                                    <th class="border-0">Price</th>
                                    <th class="border-0">Status</th>
                                    <th class="border-0">Created</th>
                                    <th class="border-0 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @include('dashboard.provider-services._rows')
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @else
            {{-- Empty State --}}
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center py-5">
                    <i class="fas fa-list fa-4x text-muted mb-4"></i>
                    <h4 class="text-muted mb-3">No Provider Services Found</h4>
                    <p class="text-muted mb-4">
                        @if (request()->hasAny(['search', 'provider_id', 'service_id', 'is_active', 'price_range']))
                            No provider services match your current filters.
                        @else
                            No provider services have been created yet.
                        @endif
                    </p>
                </div>
            </div>
        @endif
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

        function exportProviderServices() {
            // Implement export functionality
            alert('Export functionality will be implemented');
        }

        function refreshProviderServices() {
            location.reload();
        }
    </script>
    <script>
        document.getElementById('filterForm').addEventListener('submit', function(e) {
            e.preventDefault();

            let formData = new FormData(this);
            let queryString = new URLSearchParams(formData).toString();

            fetch('{{ route("admin.provider-services.filter") }}?' + queryString, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(response => response.json())
            .then(data => {
                document.querySelector('tbody').innerHTML = data.html;
            })
            .catch(error => console.error(error));
        });

        function clearFilters() {
            document.getElementById('filterForm').reset();
            document.getElementById('filterForm').dispatchEvent(new Event('submit'));
        }
    </script>
    <script>
        function deleteProviderService(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This will delete the provider service.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/admin/provider-services/${id}`, {
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
                                'The provider service has been deleted.',
                                'success'
                            ).then(() => {
                                // Refresh page or remove row from table
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
                    .catch(() => {
                        Swal.fire(
                            'Error!',
                            'Request failed. Please try again.',
                            'error'
                        );
                    });
                }
            });
        }
    </script>
@endpush

