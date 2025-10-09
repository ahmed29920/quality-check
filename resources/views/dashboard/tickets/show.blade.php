@extends('dashboard.layouts.app')

@section('title', 'Ticket Details')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-8 mx-auto">

            {{-- Ticket Info --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Ticket #{{ $ticket->id }} — {{ $ticket->subject }}</h5>
                    <span class="badge bg-info text-uppercase">{{ $ticket->ticket_from }}</span>
                </div>
                <div class="card-body">
                    <p><strong>Status:</strong>
                        <span class="badge
                            @if($ticket->status == 'open') bg-success
                            @elseif($ticket->status == 'hold') bg-warning
                            @elseif($ticket->status == 'solved') bg-primary
                            @else bg-secondary @endif">
                            {{ ucfirst($ticket->status) }}
                        </span>
                    </p>
                    <p><strong>Created by:</strong> {{ $ticket->user->name ?? 'N/A' }}</p>
                    <p><strong>Created at:</strong> {{ $ticket->created_at->format('d M Y, h:i A') }}</p>
                </div>
            </div>

            {{-- Messages --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">Conversation</h6>
                    <button class="btn btn-sm btn-primary" id="replyBtn">
                        <i class="fas fa-reply me-1"></i> Reply
                    </button>
                </div>
                <div class="card-body" style="max-height: 500px; overflow-y: auto;">
                    @forelse($ticket->messages as $message)
                        <div class="mb-3">
                            <div class="d-flex justify-content-between">
                                <strong>{{ $message->sender->name }} - <small>{{ ucfirst($message->sender_type) }}</small></strong>
                                <small class="text-muted">{{ $message->created_at->diffForHumans() }}</small>
                            </div>
                            <div class="p-3 rounded bg-light mt-2">{{ $message->message }}</div>
                        </div>
                    @empty
                        <p class="text-muted text-center my-4">No messages yet.</p>
                    @endforelse
                </div>
            </div>

            {{-- Status Change --}}
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.tickets.changeStatus', $ticket->id) }}">
                        @csrf
                        @method('PATCH')
                        <div class="row align-items-center">
                            <div class="col-md-4">
                                <select name="status" class="form-select">
                                    <option value="open" {{ $ticket->status == 'open' ? 'selected' : '' }}>Open</option>
                                    <option value="hold" {{ $ticket->status == 'hold' ? 'selected' : '' }}>On Hold</option>
                                    <option value="solved" {{ $ticket->status == 'solved' ? 'selected' : '' }}>Solved</option>
                                    <option value="closed" {{ $ticket->status == 'closed' ? 'selected' : '' }}>Closed</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-purple mb-0">Update Status</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.getElementById('replyBtn').addEventListener('click', function() {
    Swal.fire({
        title: 'Reply to Ticket',
        input: 'textarea',
        inputLabel: 'Your Message',
        inputPlaceholder: 'Type your reply...',
        inputAttributes: { 'aria-label': 'Type your message here' },
        showCancelButton: true,
        confirmButtonText: 'Send',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#0d6efd',
        showLoaderOnConfirm: true,
        preConfirm: (message) => {
            if (!message) {
                Swal.showValidationMessage('Message cannot be empty');
                return false;
            }

            return fetch("{{ route('admin.tickets.reply', $ticket->id) }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ message })
            })
            .then(response => {
                if (!response.ok) throw new Error(response.statusText);
                return response.json();
            })
            .catch(error => {
                Swal.showValidationMessage(`Request failed: ${error}`);
                console.log(error)
            });
        },
        allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                icon: 'success',
                title: 'Reply Sent!',
                timer: 1500,
                showConfirmButton: false
            }).then(() => location.reload());
        }
    });
});
</script>
@endpush
