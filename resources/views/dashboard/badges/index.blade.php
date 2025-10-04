@extends('dashboard.layouts.app')
@section('title', 'Badges')
@section('content')
    {{-- Header Card --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h4 class="mb-0 text-purple fw-bold">Badges</h4>
                </div>
                <div class="col-md-6 text-end">
                    <button id="create-badge-btn" class="btn btn-purple">
                        <i class="fas fa-plus"></i> Create Badge
                    </button>
                </div>
            </div>
        </div>
    </div>
    {{-- Badges Grid --}}
    @if ($badges->count() > 0)
        <div class="row">
            @foreach ($badges as $badge)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="position-relative card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="position-absolute top-0 end-0 m-2">
                                @if ($badge->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </div>
                            {{-- Badge Name en , ar and min score , max score --}}
                            <h5 class="card-title">{{ $badge->getTranslation('name', 'en') }}</h5>
                            <p class="card-text">{{ $badge->getTranslation('name', 'ar') }}</p>
                            <div class="d-flex justify-content-between">
                                <p class="card-text">Min Score: {{ $badge->min_score }}</p>
                                <p class="card-text">Max Score: {{ $badge->max_score }}</p>
                            </div>
                            {{-- Actions --}}
                            <div class="mt-auto">
                                <div class="btn-group w-100" role="group">
                                    <button type="button" class="btn btn-outline-primary"
                                        onclick="updateBadge({{ $badge->id }})">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-danger"
                                        onclick="deleteBadge({{ $badge->id }})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        {{-- Empty State --}}
        <div class="text-center py-5">
            <div class="card border-0 shadow-sm">
                <div class="card-body py-5">
                    <i class="fas fa-folder-plus fa-4x text-muted mb-4"></i>
                    <h3 class="text-muted mb-3">No Badges Yet</h3>
                    <button id="create-badge-btn" class="btn btn-purple">
                        <i class="fas fa-plus"></i> Create Your First Badge
                    </button>
                </div>
            </div>
        </div>
    @endif

@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            $(document).on("click", "#create-badge-btn", function() {
                Swal.fire({
                    title: 'Create Badge',
                    html: `
                <div class="text-start">
                    <label class="fw-bold">Name (EN)</label>
                    <input id="swal-name-en" type="text" class="form-control mb-3" placeholder="Enter name in English">

                    <label class="fw-bold">Name (AR)</label>
                    <input id="swal-name-ar" type="text" class="form-control mb-3" placeholder="Enter name in Arabic">

                    <label class="fw-bold">Min Score</label>
                    <input id="swal-min-score" type="number" class="form-control mb-3" placeholder="0">

                    <label class="fw-bold">Max Score</label>
                    <input id="swal-max-score" type="number" class="form-control mb-3" placeholder="100">

                    <label class="fw-bold">Active</label>
                    <select id="swal-is-active" class="form-control">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
            `,
                    focusConfirm: false,
                    showCancelButton: true,
                    confirmButtonText: 'Save',
                    cancelButtonText: 'Cancel',
                    preConfirm: () => {
                        return {
                            name_en: document.getElementById('swal-name-en').value,
                            name_ar: document.getElementById('swal-name-ar').value,
                            min_score: document.getElementById('swal-min-score').value,
                            max_score: document.getElementById('swal-max-score').value,
                            is_active: document.getElementById('swal-is-active').value,
                        }
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        let data = result.value;


                        $.ajax({
                            url: "{{ route('admin.badges.store') }}",
                            method: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                "name[en]": data.name_en,
                                "name[ar]": data.name_ar,
                                min_score: data.min_score,
                                max_score: data.max_score,
                                is_active: data.is_active,
                            },
                            success: function(response) {
                                Swal.fire('Success', 'Badge created successfully!',
                                        'success')
                                    .then(() => {
                                        location.reload();
                                    });
                            },
                            error: function(xhr) {
                                if (xhr.status === 422) {
                                    let errors = xhr.responseJSON.errors;
                                    let errorMessages = Object.values(errors).map(err =>
                                        `<li>${err}</li>`).join('');
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Validation Error',
                                        html: `<ul class="text-start text-danger">${errorMessages}</ul>`
                                    });
                                } else {
                                    Swal.fire('Error', 'Something went wrong!',
                                        'error');
                                }
                            }

                        });
                    }
                });
            });
        });

        function deleteBadge(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This will delete the badge.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/admin/badges/${id}`, {
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
                                    'The badge has been deleted.',
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

        function updateBadge(id) {
            $.ajax({
                url: `/admin/badges/${id}`,
                method: 'GET',
                success: function(badge) {
                    Swal.fire({
                        title: 'Update Badge',
                        html: `
                    <div class="text-start">
                        <label class="fw-bold">Name (EN)</label>
                        <input id="swal-name-en" type="text" class="form-control mb-3" value="${badge.name.en}">

                        <label class="fw-bold">Name (AR)</label>
                        <input id="swal-name-ar" type="text" class="form-control mb-3" value="${badge.name.ar}">

                        <label class="fw-bold">Min Score</label>
                        <input id="swal-min-score" type="number" class="form-control mb-3" value="${badge.min_score}">

                        <label class="fw-bold">Max Score</label>
                        <input id="swal-max-score" type="number" class="form-control mb-3" value="${badge.max_score}">

                        <label class="fw-bold">Active</label>
                        <select id="swal-is-active" class="form-control">
                            <option value="1" ${badge.is_active ? 'selected' : ''}>Active</option>
                            <option value="0" ${!badge.is_active ? 'selected' : ''}>Inactive</option>
                        </select>
                    </div>
                `,
                        showCancelButton: true,
                        confirmButtonText: 'Update',
                        cancelButtonText: 'Cancel',
                        preConfirm: () => {
                            return {
                                _token: "{{ csrf_token() }}",
                                _method: "PUT",
                                "name[en]": document.getElementById('swal-name-en').value,
                                "name[ar]": document.getElementById('swal-name-ar').value,
                                min_score: document.getElementById('swal-min-score').value,
                                max_score: document.getElementById('swal-max-score').value,
                                is_active: document.getElementById('swal-is-active').value,
                            }
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: `/admin/badges/${id}`,
                                method: 'POST', // مهم: لازم تستخدم POST مع `_method=PUT`
                                data: result.value,
                                success: function() {
                                    Swal.fire('Updated!', 'Badge updated successfully!',
                                            'success')
                                        .then(() => location.reload());
                                },
                                error: function(xhr) {
                                    if (xhr.status === 422) {
                                        let errors = xhr.responseJSON.errors;
                                        let errorMessages = Object.values(errors).map(err =>
                                            `<li>${err}</li>`).join('');
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Validation Error',
                                            html: `<ul class="text-start text-danger">${errorMessages}</ul>`
                                        });
                                    } else {
                                        Swal.fire('Error', 'Something went wrong!',
                                        'error');
                                    }
                                }
                            });
                        }
                    });
                }
            });
        }
    </script>
@endpush
