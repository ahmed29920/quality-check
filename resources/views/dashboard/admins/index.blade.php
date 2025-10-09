@extends('dashboard.layouts.app')

@section('title', 'Admins Management')

@section('content')
    <div class="container-fluid py-4">
        {{-- Header Card --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h4 class="mb-0 text-purple fw-bold">Admins Management</h4>
                        <small class="text-muted">Manage registered admins and their accounts</small>
                    </div>
                    <div class="col-md-6 text-end">
                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('admin.admins.create')}}" class="btn btn-outline-warning">
                                <i class="fas fa-plus"></i> Create
                            </a>
                            <button class="btn btn-outline-info">
                                <i class="fas fa-download"></i> Export
                            </button>
                            <button class="btn btn-outline-success" onclick="refreshAdmins()">
                                <i class="fas fa-sync"></i> Refresh
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        {{-- Admins Table --}}
        @if ($admins->count() > 0)
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent">
                    <h6 class="mb-0 text-info fw-bold">
                        <i class="fas fa-users"></i> Admins List ({{ $admins->count() }} total)
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0">User</th>
                                    <th class="border-0">Contact Info</th>
                                    <th class="border-0">Role</th>
                                    <th class="border-0">Status</th>
                                    <th class="border-0">Joined</th>
                                    <th class="border-0 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @include('dashboard.admins._rows')
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @else
            {{-- Empty State --}}
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center py-5">
                    <i class="fas fa-admins fa-4x text-muted mb-4"></i>
                    <h4 class="text-muted mb-3">No Admins Found</h4>
                    <p class="text-muted mb-4">
                        @if (request()->hasAny(['search', 'is_active', 'phone_verified', 'email_verified']))
                            No admins match your current filters.
                        @else
                            No admins have been registered yet.
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
            fetch(`/admin/admins/${userId}/toggle-status`, {
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
            form.action = '{{ route('admin.admins.destroy', ':id') }}'.replace(':id', userId);
            new bootstrap.Modal(document.getElementById('deleteModal')).show();
        }

        function exportAdmins() {
            // Implement export functionality
            alert('Export functionality will be implemented');
        }

        function refreshAdmins() {
            location.reload();
        }
    </script>
    <script>
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
                        url: "{{ url('admin/admins') }}/" + userId,
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
