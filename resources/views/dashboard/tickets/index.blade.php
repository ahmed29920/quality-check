@extends('dashboard.layouts.app')

@section('title', 'Support Tickets')

@section('content')
<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-0 text-purple fw-bold">{{ __('Support Tickets') }}</h4>
                <small class="text-muted">{{ __('Manage and respond to support tickets') }}</small>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-transparent">
            <h6 class="mb-0 text-info fw-bold">
                <i class="fas fa-filter"></i> {{ __('Filters') }}
            </h6>
        </div>
        <div class="card-body">
            <form id="filterForm" method="GET" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label fw-bold">{{ __('Search') }}</label>
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search by subject...">
                </div>

                <div class="col-md-2">
                    <label class="form-label fw-bold">{{ __('Status') }}</label>
                    <select name="status" class="form-select">
                        <option value="">{{ __('All Statuses') }}</option>
                        <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Open</option>
                        <option value="hold" {{ request('status') == 'hold' ? 'selected' : '' }}>On Hold</option>
                        <option value="solved" {{ request('status') == 'solved' ? 'selected' : '' }}>Solved</option>
                        <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button  class="btn btn-purple"><i class="fas fa-search"></i> Filter</button>
                        <a href="{{ route('admin.tickets.index') }}" class="btn btn-outline-secondary " >
                            <i class="fas fa-times"></i> Clear
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Tickets List --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
            <h6 class="mb-0 text-info fw-bold">
                <i class="fas fa-ticket-alt"></i> {{ __('Tickets List') }} ({{ $tickets->total() }} total)
            </h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-items-center mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th>#</th>
                            <th>{{ __('Subject') }}</th>
                            <th>{{ __('From') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Last Update') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody id="ticketTableBody">
                        @include('dashboard.tickets._rows', ['tickets' => $tickets])
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            {{ $tickets->links() }}
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $('#filterForm').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: "{{ route('admin.tickets.filter') }}",
            method: "GET",
            data: $(this).serialize(),
            beforeSend: function() {
                $('#ticketTableBody').html('<tr><td colspan="6" class="text-center py-4 text-muted">Loading...</td></tr>');
            },
            success: function(response) {
                $('#ticketTableBody').html(response.html);
            },
            error: function() {
                alert('Failed to load filtered data');
            }
        });
    });
</script>
@endsection
