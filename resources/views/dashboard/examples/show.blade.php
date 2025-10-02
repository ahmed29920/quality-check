@extends('dashboard.layouts.app')


@section('content')
    <div class="container-fluid">
        {{-- Action Buttons --}}
        <div class="mb-3">
            @if ($order->status == 'pending')
                <span class="mx-2 text-success cursor-pointer status-action" data-action="invoice">
                    <i class="fa-solid fa-receipt"></i>
                    {{ __('Invoice') }}
                </span>
                <span class="mx-2 text-danger cursor-pointer status-action" data-status="cancelled">
                    <i class="fa-solid fa-ban"></i>
                    {{ __('Cancel') }}
                </span>
            @elseif ($order->status == 'processing')
                <span class="mx-2 text-info cursor-pointer status-action" data-status="shipped">
                    <i class="fa-solid fa-truck"></i>
                    {{ __('Ship') }}
                </span>
                <a class="mx-2 text-success" href="{{ route('admin.orders.download-invoice', $order->id) }}"
                    target="_blank">
                    <i class="fa-solid fa-receipt"></i>
                    {{ __('Download Invoice') }}
                </a>
            @elseif ($order->status == 'shipped')
                <a class="mx-2 text-success" href="{{ route('admin.orders.download-invoice', $order->id) }}"
                    target="_blank">
                    <i class="fa-solid fa-receipt"></i>
                    {{ __('Download Invoice') }}
                </a>
                <span class="mx-2 text-info cursor-pointer status-action" data-status="completed">
                    <i class="fa-solid fa-check"></i>
                    {{ __('Complete') }}
                </span>
            @elseif ($order->status == 'completed')
                <a class="mx-2 text-success" href="{{ route('admin.orders.download-invoice', $order->id) }}"
                    target="_blank">
                    <i class="fa-solid fa-receipt"></i>
                    {{ __('Download Invoice') }}
                </a>
            @endif
        </div>

        <div class="row">
            {{-- Left Side: Order Items --}}
            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-header">Order Items ({{ count($order->items) }})</div>
                    <div class="card-body">
                        @foreach ($order->items as $item)
                            <div class="d-flex align-items-center mb-3">
                                <img src="{{ asset('storage/' . $item->product->images()->first()->path) }}"
                                    class="img-thumbnail me-3" style="width: 80px; height: 80px;">
                                <div>
                                    <h6>{{ $item->product->name }}</h6>
                                    <p>EGP {{ $item->price }} x {{ $item->quantity }}</p>
                                    <small>SKU: {{ $item->product->sku }}</small>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Totals --}}
                <div class="card mb-3">
                    <div class="card-body">
                        <p>Sub Total: EGP {{ $order->total }}</p>
                        <p>Shipping: EGP {{ $order->shipping_cost }}</p>
                        <p>Discount: EGP {{ $order->coupon_discount_value }}</p>
                        <h5>Grand Total: EGP {{ $order->final_total }}</h5>
                    </div>
                </div>

                {{-- Comments --}}
                <div class="card">
                    <div class="card-header">Comments</div>
                    <div class="card-body">
                        @foreach ($order->comments as $comment)
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-auto">
                                        <strong>{{ $comment->user->name }}:</strong>
                                        <br>
                                        <small class="text-muted">{{ $comment->created_at->format('Y-m-d H:i') }} </small>
                                    </div>
                                    <div class="col border p-2 rounded">
                                        <p class="mb-0">{{ $comment->comment }}</p>
                                    </div>
                                </div>
                                <hr class="border border-secondary">
                            </div>
                        @endforeach
                        <!-- Add New Comment -->
                        <form action="{{ route('admin.orders.comments.store', $order) }}" method="POST">
                            @csrf
                            <textarea class="form-control" name="comment" rows="3" placeholder="Write your comment"></textarea>
                            <div class="form-check mt-2">
                                <input type="checkbox" class="form-check-input" value="1" name="notify" id="notify">
                                <label class="form-check-label" for="notify">Notify Customer</label>
                            </div>
                            <button type="submit" class="btn btn-primary mt-2">Submit Comment</button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Right Side: Sidebar --}}
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-header border border-bottom">
                        Customer
                    </div>
                    <div class="card-body">
                        <p>Name : <strong>{{ $order->user->name }}</strong></p>
                        <p>Email : <strong>{{ $order->user->email }}</strong></p>
                        <p>Phone : <strong>{{ $order->user->phone }}</strong></p>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-header  border border-bottom">Order Information</div>
                    <div class="card-body">
                        <p>Order Date: <strong>{{ $order->created_at }}</strong></p>
                        @php
                            $statusClasses = [
                                'pending' => 'warning',
                                'processing' => 'info',
                                'shipped' => 'primary',
                                'completed' => 'success',
                                'cancelled' => 'danger',
                            ];
                        @endphp

                        <p>Status:
                            <span class="badge bg-{{ $statusClasses[$order->status] ?? 'secondary' }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </p>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-header  border border-bottom">Payment and Shipping</div>
                    <div class="card-body">
                        <p>Payment Method: <strong>{{ $order->payment_method }}</strong></p>
                        <p>Payment Status: <span
                                class="badge  @if ($order->payment_status == 'paid') bg-success @elseif($order->payment_status == 'pending') bg-warning @else bg-secondary @endif">{{ $order->payment_status }}</span>
                        </p>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-header border border-bottom">Billing Address</div>
                    <div class="card-body">
                        <p>Name : <strong>{{ $order->billingAddress->name }}</strong></p>
                        <p>Address : <strong>{{ $order->billingAddress->address }}</strong></p>
                        <p>City : <strong>{{ $order->billingAddress->city }}</strong></p>
                        <p>Country : <strong>{{ $order->billingAddress->country }}</strong></p>
                        <p>Contact : <strong>{{ $order->billingAddress->phone }}</strong></p>
                    </div>
                </div>


                <div class="card mb-3">
                    <div class="card-header border border-bottom">Shipping Address</div>
                    <div class="card-body">
                        <p>Name : <strong>{{ $order->shippingAddress->name }}</strong></p>
                        <p>Address : <strong>{{ $order->shippingAddress->address }}</strong></p>
                        <p>City : <strong>{{ $order->shippingAddress->city }}</strong></p>
                        <p>Country : <strong>{{ $order->shippingAddress->country }}</strong></p>
                        <p>Contact : <strong>{{ $order->shippingAddress->phone }}</strong></p>
                    </div>
                </div>


            </div>
        </div>
    </div>
    <!-- Hidden form -->
    <form id="createInvoiceForm" action="{{ route('admin.orders.create-invoice', $order->id) }}" method="POST"
        style="display: none;">
        @csrf
    </form>

    <form id="StatusForm" action="{{ route('admin.orders.update', $order->id) }}" method="POST" style="display: none;">
        <input type="hidden" name="status" id="status_input">
        @method('PUT')
        @csrf
    </form>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const createInvoiceBtn = document.querySelector('#createInvoiceBtn');
        if (createInvoiceBtn) {
            createInvoiceBtn.addEventListener('click', function() {
                Swal.fire({
                    title: "Are you sure?",
                    text: "Do you want to create an invoice and change order status to Processing?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, Create Invoice",
                    cancelButtonText: "Cancel"
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('createInvoiceForm').submit();
                    }
                });
            });
        }


        document.querySelectorAll('.status-action').forEach(btn => {
            btn.addEventListener('click', function() {
                let action = this.dataset.action;
                let status = this.dataset.status;

                if (action === 'invoice') {
                    Swal.fire({
                        title: "Are you sure?",
                        text: "Do you want to create an invoice and change order status to Processing?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: "Yes, Create Invoice",
                        cancelButtonText: "Cancel"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById('createInvoiceForm').submit();
                        }
                    });
                } else if (status) {
                    Swal.fire({
                        title: "Are you sure?",
                        text: `Do you want to change order status to ${status}?`,
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: `Yes, ${status.charAt(0).toUpperCase() + status.slice(1)} Order`,
                        cancelButtonText: "Cancel"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById('status_input').value = status;
                            document.getElementById('StatusForm').submit();
                        }
                    });
                }
            });
        });
    </script>
@endpush
