@extends('dashboard.layouts.app')

@section('title', 'Users Management')

@section('content')
    <div class="container-fluid py-4">
        {{-- Header Card --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h4 class="mb-0 text-purple fw-bold">Users Management</h4>
                        <small class="text-muted">Manage registered users and their accounts</small>
                    </div>
                    <div class="col-md-6 text-end">
                        <div class="d-flex gap-2 justify-content-end">
                            <button class="btn btn-outline-info">
                                <i class="fas fa-download"></i> Export
                            </button>
                            <button class="btn btn-outline-success" onclick="refreshUsers()">
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
                            <button  class="btn btn-purple"><i class="fas fa-search"></i> Filter</button>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary " >
                                <i class="fas fa-times"></i> Clear
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Users Table --}}
        @if ($users->count() > 0)
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent">
                    <h6 class="mb-0 text-info fw-bold">
                        <i class="fas fa-users"></i> Users List ({{ $users->count() }} total)
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0">User</th>
                                    <th class="border-0">Contact Info</th>
                                    <th class="border-0">Is Verified</th>
                                    <th class="border-0">Status</th>
                                    <th class="border-0">Joined</th>
                                    <th class="border-0 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @include('dashboard.users._rows')
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
                    <h4 class="text-muted mb-3">No Users Found</h4>
                    <p class="text-muted mb-4">
                        @if (request()->hasAny(['search', 'is_active', 'phone_verified', 'email_verified']))
                            No users match your current filters.
                        @else
                            No users have been registered yet.
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
        function toggleUserStatus(userId) {
            fetch(`/admin/users/${userId}/toggle-status`, {
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
                        alert('Failed to update user status');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to update user status');
                });
        }

        function confirmDelete(userId) {
            const form = document.getElementById('deleteForm');
            form.action = '{{ route('admin.users.destroy', ':id') }}'.replace(':id', userId);
            new bootstrap.Modal(document.getElementById('deleteModal')).show();
        }

        function exportUsers() {
            // Implement export functionality
            alert('Export functionality will be implemented');
        }

        function refreshUsers() {
            location.reload();
        }
    </script>
    <script>
        document.getElementById('filterForm').addEventListener('submit', function(e) {
            e.preventDefault();

            let formData = new FormData(this);
            let queryString = new URLSearchParams(formData).toString();

            fetch('{{ route("admin.users.filter") }}?' + queryString, {
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
        // delete with sweetalert
        function deleteUser(userId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This will delete the user!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('admin/users') }}/" + userId,
                        type: "POST",
                        data: {
                            _method: 'DELETE',
                            _token: '{{ csrf_token() }}'
                        },
                        success: function() {
                            Swal.fire('Deleted!', 'User has been deleted.', 'success');
                            location.reload();
                        },
                        error: function() {
                            Swal.fire('Error!', 'Something went wrong.', 'error');
                        }
                    });
                }
            });
        }
    </script>

@endpush
