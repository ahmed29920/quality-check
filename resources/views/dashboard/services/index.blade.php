@extends('dashboard.layouts.app')

@section('title', 'Services')

@section('content')
    <div class="container-fluid py-4">
        {{-- Header --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-0 text-purple fw-bold">Services</h4>
                    <small class="text-muted">Manage services and their MCQ questions</small>
                </div>
                <a href="{{ route('admin.services.create') }}" class="btn btn-purple">
                    <i class="fas fa-plus"></i> Create Service
                </a>
            </div>
        </div>

        {{-- Filters --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent pb-0">
                <h6 class="fw-bold text-info"><i class="fas fa-filter"></i> Filters</h6>
            </div>
            <div class="card-body">
                <form id="filterForm" class="row g-3">
                    @csrf
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Category</label>
                        <select name="category_id" class="form-select">
                            <option value="">All Categories</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">
                                    {{ $category->getTranslation('name', app()->getLocale()) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label fw-bold">Status</label>
                        <select name="is_active" class="form-select">
                            <option value="">All</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label fw-bold">Pricable</label>
                        <select name="is_pricable" class="form-select">
                            <option value="">All</option>
                            <option value="1">Pricable</option>
                            <option value="0">Not Pricable</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label fw-bold">Show Deleted</label>
                        <select name="show_deleted" class="form-select">
                            <option value="0">Active Only</option>
                            <option value="1">Include Deleted</option>
                            <option value="2">Deleted Only</option>
                        </select>
                    </div>

                    <div class="col-md-3 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-purple mb-0">
                            <i class="fas fa-search"></i> Filter
                        </button>
                        <a href="{{ route('admin.services.index') }}" class="btn btn-outline-secondary mb-0">
                            <i class="fas fa-times"></i> Clear
                        </a>
                    </div>
                </form>
            </div>
        </div>

        {{-- Services Table --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table mb-0" id="servicesTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Service Name</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Pricable</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @include('dashboard.services._rows')
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // init datatable
        let table = $('#servicesTable').DataTable();

        // filter with ajax
        $(document).on('submit', '#filterForm', function(e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('admin.services.filter') }}",
                method: "POST",
                data: $(this).serialize(),
                success: function(res) {
                    table.clear().draw();
                    $('#servicesTable tbody').html(res.html);
                    table.rows.add($('#servicesTable tbody tr')).draw();
                },
                error: function() {
                    Swal.fire('Error!', 'Something went wrong.', 'error');
                }
            });
        });

        // delete with sweetalert
        function deleteService(serviceId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This will delete the service!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('admin/services') }}/" + serviceId,
                        type: "POST",
                        data: {
                            _method: 'DELETE',
                            _token: '{{ csrf_token() }}'
                        },
                        success: function() {
                            Swal.fire('Deleted!', 'Service has been deleted.', 'success');
                            $('#filterForm').submit(); // refresh
                        },
                        error: function() {
                            Swal.fire('Error!', 'Something went wrong.', 'error');
                        }
                    });
                }
            });
        }
        // 🟢 استرجاع الخدمة
        function restoreService(serviceId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This will restore the service!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#147638',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, restore it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('admin/services') }}/" + serviceId + "/restore",
                        type: "PUT",
                        data: {
                            _method: 'PUT',
                            _token: '{{ csrf_token() }}'
                        },
                        success: function() {
                            Swal.fire('Restored!', 'Service has been restored.', 'success');
                            $('#filterForm').submit(); // refresh table
                        },
                        error: function() {
                            Swal.fire('Error!', 'Something went wrong.', 'error');
                        }
                    });
                }
            });
        }

        // 🔴 حذف نهائي
        function forceDeleteService(serviceId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This will permanently delete the service!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('admin/services') }}/" + serviceId + "/force-delete",
                        type: "POST",
                        data: {
                            _method: 'DELETE',
                            _token: '{{ csrf_token() }}'
                        },
                        success: function() {
                            Swal.fire('Deleted!', 'Service has been permanently deleted.', 'success');
                            $('#filterForm').submit(); // refresh table
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
