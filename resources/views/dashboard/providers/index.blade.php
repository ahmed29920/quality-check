@extends('dashboard.layouts.app')

@section('title', 'Providers Management')

@section('content')
    <div class="container-fluid py-4">
        {{-- Header Card --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h4 class="mb-0 text-purple fw-bold">Providers Management</h4>
                        <small class="text-muted">Manage service providers and their accounts</small>
                    </div>
                    <div class="col-md-6 text-end">
                        <div class="d-flex gap-2 justify-content-end">
                            <button class="btn btn-outline-info">
                                <i class="fas fa-download"></i> Export
                            </button>
                            <button class="btn btn-outline-success" onclick="refreshProviders()">
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
                        <input type="text" name="search" class="form-control" placeholder="Name, email, or phone">
                    </div>

                    {{-- Category --}}
                    <div class="col-md-2">
                        <label class="form-label fw-bold">Category</label>
                        <select name="category_id" class="form-select">
                            <option value="">All Categories</option>
                            @foreach(\App\Models\Category::active()->get() as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
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

                    {{-- Verification --}}
                    <div class="col-md-2">
                        <label class="form-label fw-bold">Verification</label>
                        <select name="is_verified" class="form-select">
                            <option value="">All</option>
                            <option value="1">Verified</option>
                            <option value="0">Unverified</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-flex gap-2">
                            <button class="btn btn-purple"><i class="fas fa-search"></i> Filter</button>
                            <a href="{{ route('admin.providers.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times"></i> Clear
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Providers Table --}}
        @if ($providers->count() > 0)
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent">
                    <h6 class="mb-0 text-info fw-bold">
                        <i class="fas fa-users"></i> Providers List ({{ $providers->count() }} total)
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0">Provider</th>
                                    <th class="border-0">Category</th>
                                    <th class="border-0">Badge</th>
                                    <th class="border-0">Is Verified</th>
                                    <th class="border-0">Status</th>
                                    <th class="border-0">Joined</th>
                                    <th class="border-0 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @include('dashboard.providers._rows')
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @else
            {{-- Empty State --}}
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center py-5">
                    <i class="fas fa-users fa-4x text-muted mb-4"></i>
                    <h4 class="text-muted mb-3">No Providers Found</h4>
                    <p class="text-muted mb-4">
                        @if (request()->hasAny(['search', 'category_id', 'is_active', 'is_verified']))
                            No providers match your current filters.
                        @else
                            No providers have been registered yet.
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
        function toggleProviderStatus(providerId) {
            fetch(`/admin/providers/${providerId}/toggle-status`, {
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
                        alert('Failed to update provider status');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to update provider status');
                });
        }

        function toggleProviderVerification(providerId) {
            fetch(`/admin/providers/${providerId}/toggle-verification`, {
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
                        alert('Failed to update provider verification');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to update provider verification');
                });
        }

        function exportProviders() {
            // Implement export functionality
            alert('Export functionality will be implemented');
        }

        function refreshProviders() {
            location.reload();
        }
    </script>
    <script>
        document.getElementById('filterForm').addEventListener('submit', function(e) {
            e.preventDefault();

            let formData = new FormData(this);
            let queryString = new URLSearchParams(formData).toString();

            fetch('{{ route("admin.providers.filter") }}?' + queryString, {
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
@endpush
