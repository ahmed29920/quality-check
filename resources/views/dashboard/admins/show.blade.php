@extends('dashboard.layouts.app')

@section('title', 'Admin Details')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-4">
                {{-- User Card --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-transparent">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 text-info fw-bold">User Information</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        {{-- User Avatar --}}
                        <div class="text-center mb-4">
                            @if($user->image)
                                <img src="{{ $user->image }}" alt="{{ $user->name }}"
                                     class="rounded-circle mb-3" style="width: 100px; height: 100px; object-fit: cover;">
                            @else
                                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3"
                                     style="width: 100px; height: 100px;">
                                    <i class="fas fa-user fa-3x text-muted"></i>
                                </div>
                            @endif
                            <h4 class="fw-bold text-info mb-1">{{ $user->name }}</h4>
                            <p class="text-muted mb-0">User ID: {{ $user->id }}</p>
                        </div>

                        {{-- User Details --}}
                        <div class="mb-3">
                            <h6 class="fw-bold text-purple mb-2">Contact Information</h6>

                            @if($user->email)
                                <div class="mb-2">
                                    <i class="fas fa-envelope text-muted me-2"></i>
                                    <strong>Email:</strong> {{ $user->email }}
                                </div>
                            @endif

                            @if($user->phone)
                                <div class="mb-2">
                                    <i class="fas fa-phone text-muted me-2"></i>
                                    <strong>Phone:</strong> {{ $user->phone }}
                                </div>
                            @endif
                        </div>

                        {{-- Verification Status --}}
                        <div class="mb-3">
                            <h6 class="fw-bold text-purple mb-2">Verification Status</h6>

                            <div class="mb-2">
                                @if($user->phone_verified_at)
                                    <span class="badge bg-success">
                                        <i class="fas fa-check"></i> Phone Verified
                                    </span>
                                    <small class="text-muted d-block">Verified: {{ $user->phone_verified_at->format('M d, Y H:i') }}</small>
                                @else
                                    <span class="badge bg-warning">
                                        <i class="fas fa-times"></i> Phone Unverified
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- Account Status --}}
                        <div class="mb-3">
                            <h6 class="fw-bold text-purple mb-2">Account Status</h6>
                            <div class="d-flex align-items-center">
                                <span class="badge bg-{{ $user->is_active ? 'success' : 'danger' }} ms-2">
                                    {{ $user->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                        </div>

                        {{-- Meta Info --}}
                        <div class="border-top pt-3 mt-3">
                            <small class="text-muted">
                                <i class="fas fa-calendar-plus"></i> Joined:
                                {{ $user->created_at->format('M d, Y') }}<br>
                                <i class="fas fa-clock"></i> Last Updated: {{ $user->updated_at->format('M d, Y') }}
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
                            <button class="btn btn-outline-primary" onclick="toggleUserStatus({{ $user->id }})">
                                <i class="fas fa-toggle-{{ $user->is_active ? 'on' : 'off' }}"></i>
                                {{ $user->is_active ? 'Deactivate' : 'Activate' }} Admin
                            </button>

                            {{-- <button class="btn btn-outline-info" onclick="viewUserActivity()">
                                <i class="fas fa-chart-line"></i> View Activity
                            </button>

                            <button class="btn btn-outline-warning" onclick="sendNotification()">
                                <i class="fas fa-bell"></i> Send Notification
                            </button> --}}

                            <button type="button" class="btn btn-outline-danger" onclick="confirmDelete({{ $user->id }})">
                                <i class="fas fa-trash"></i> Delete Admin
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8">

                {{-- User Activity Timeline --}}
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-transparent">
                        <h5 class="mb-0 text-info fw-bold">Account Timeline</h5>
                    </div>
                    <div class="card-body">
                        <div class="timeline">
                            {{-- Account Created --}}
                            <div class="timeline-item">
                                <div class="timeline-marker bg-success"></div>
                                <div class="timeline-content">
                                    <h6 class="fw-bold">Account Created</h6>
                                    <p class="text-muted mb-1">User registered successfully</p>
                                    <small class="text-muted">{{ $user->created_at->format('M d, Y H:i') }}</small>
                                </div>
                            </div>

                            {{-- Phone Verification --}}
                            @if($user->phone_verified_at)
                                <div class="timeline-item">
                                    <div class="timeline-marker bg-info"></div>
                                    <div class="timeline-content">
                                        <h6 class="fw-bold">Phone Verified</h6>
                                        <p class="text-muted mb-1">Phone number {{ $user->phone }} verified</p>
                                        <small class="text-muted">{{ $user->phone_verified_at->format('M d, Y H:i') }}</small>
                                    </div>
                                </div>
                            @endif


                            {{-- Last Update --}}
                            @if($user->updated_at != $user->created_at)
                                <div class="timeline-item">
                                    <div class="timeline-marker bg-warning"></div>
                                    <div class="timeline-content">
                                        <h6 class="fw-bold">Profile Updated</h6>
                                        <p class="text-muted mb-1">Last profile modification</p>
                                        <small class="text-muted">{{ $user->updated_at->format('M d, Y H:i') }}</small>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Additional Information --}}
                <div class="card border-0 shadow-sm mt-4">
                    <div class="card-header bg-transparent">
                        <h5 class="mb-0 text-info fw-bold">Additional Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="fw-bold text-purple">Account Details</h6>
                                <table class="table table-sm">
                                    <tr>
                                        <td><strong>User ID:</strong></td>
                                        <td>{{ $user->id }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Role:</strong></td>
                                        <td>{{ $user->role ?? 'User' }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h6 class="fw-bold text-purple">Timestamps</h6>
                                <table class="table table-sm">
                                    <tr>
                                        <td><strong>Created:</strong></td>
                                        <td>{{ $user->created_at->format('M d, Y H:i:s') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Updated:</strong></td>
                                        <td>{{ $user->updated_at->format('M d, Y H:i:s') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Delete Confirmation Modal --}}
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this user? This action cannot be undone and will permanently remove all user data.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteForm" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete User</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .timeline {
            position: relative;
            padding-left: 30px;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 30px;
        }

        .timeline-marker {
            position: absolute;
            left: -37px;
            top: 0;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            border: 3px solid #fff;
            box-shadow: 0 0 0 3px #e9ecef;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: -31px;
            top: 12px;
            width: 2px;
            height: calc(100% + 18px);
            background: #e9ecef;
        }

        .timeline-item:last-child::before {
            display: none;
        }
    </style>

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
            form.action = '{{ route("admin.users.destroy", ":id") }}'.replace(':id', userId);
            new bootstrap.Modal(document.getElementById('deleteModal')).show();
        }

        function viewUserActivity() {
            alert('User activity feature will be implemented');
        }

        function sendNotification() {
            alert('Send notification feature will be implemented');
        }
    </script>
@endsection
