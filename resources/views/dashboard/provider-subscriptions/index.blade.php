@extends('dashboard.layouts.app')

@section('title', 'Provider Subscriptions')

@section('content')
    <div class="container-fluid py-4">
        {{-- Header --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-0 text-purple fw-bold">Provider Subscriptions</h4>
                </div>
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

                    <div class="col-md-2">
                        <label class="form-label fw-bold">Status</label>
                        <select name="status" class="form-select">
                            <option value="">All</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                            <option value="pending">Pending</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label fw-bold">Payment Status</label>
                        <select name="payment_status" class="form-select">
                            <option value="">All</option>
                            <option value="paid">Paid</option>
                            <option value="unpaid">Unpaid</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label fw-bold">Provider</label>
                        <select name="provider_id" class="form-select">
                            <option value="">All Providers</option>
                            @foreach (\App\Models\Provider::active()->get() as $provider)
                                <option value="{{ $provider->id }}">{{ $provider->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    {{-- Date Range inputs --}}
                    <div class="col-md-2">
                        <label class="form-label fw-bold">Start Date</label>
                        <input type="date" name="start_date" class="form-control">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-bold">End Date</label>
                        <input type="date" name="end_date" class="form-control">
                    </div>



                    <div class="col-md-2 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-purple mb-0">
                            <i class="fas fa-search"></i> Filter
                        </button>
                        <a href="{{ route('admin.provider-subscriptions.index') }}" class="btn btn-outline-secondary mb-0">
                            <i class="fas fa-times"></i> Clear
                        </a>
                    </div>
                </form>
            </div>
        </div>


        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0" id="providerSubscriptionsTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Provider</th>
                                        <th>Category</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @include('dashboard.provider-subscriptions._rows', [
                                        'providerSubscriptions' => $providerSubscriptions,
                                    ])
                                </tbody>
                            </table>
                        </div>
                    </div>
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
        let table = $('#providerSubscriptionsTable').DataTable();
        // filter with ajax
        $(document).on('submit', '#filterForm', function(e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('admin.provider-subscriptions.filter') }}",
                method: "POST",
                data: $(this).serialize(),
                success: function(res) {
                    table.clear().draw();
                    $('#providerSubscriptionsTable tbody').html(res.html);
                    table.rows.add($('#providerSubscriptionsTable tbody tr')).draw();
                },
                error: function() {
                    Swal.fire('Error!', 'Something went wrong.', 'error');
                }
            });
        });
    </script>
@endpush
