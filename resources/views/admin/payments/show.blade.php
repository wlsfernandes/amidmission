@extends('admin.layouts.master')

@section('title', 'Payment Details')

@section('content')
    <div class="card border border-primary">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5>
                <i class="fa-solid fa-credit-card"></i> Payment Details
            </h5>
            <a href="{{ route('admin.payments.index') }}" class="btn btn-sm btn-secondary">
                <i class="fa-solid fa-arrow-left"></i> Back
            </a>
        </div>

        <div class="card-body">
            <x-alert />

            {{-- BASIC INFO --}}
            <div class="row mb-4">
                <div class="col-md-6">
                    <h6 class="text-muted">Payment Info</h6>
                    <table class="table table-sm table-borderless">
                        <tr>
                            <th>ID</th>
                            <td>#{{ $payment->id }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                <span class="badge bg-success">
                                    {{ ucfirst($payment->status) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Type</th>
                            <td>{{ ucfirst(str_replace('_', ' ', $payment->payment_type)) }}</td>
                        </tr>
                        <tr>
                            <th>Amount</th>
                            <td>
                                <strong>
                                    $ {{ number_format($payment->amount / 100, 2) }}
                                </strong>
                                <small class="text-muted">
                                    ({{ strtoupper($payment->currency) }})
                                </small>
                            </td>
                        </tr>
                        <tr>
                            <th>Paid At</th>
                            <td>{{ $payment->paid_at?->format('M d, Y H:i') }}</td>
                        </tr>
                    </table>
                </div>

                <div class="col-md-6">
                    <h6 class="text-muted">Stripe References</h6>
                    <table class="table table-sm table-borderless">
                        <tr>
                            <th>Session ID</th>
                            <td class="text-break">{{ $payment->stripe_session_id }}</td>
                        </tr>
                        <tr>
                            <th>Payment Intent</th>
                            <td class="text-break">{{ $payment->stripe_payment_intent_id }}</td>
                        </tr>
                        <tr>
                            <th>Customer ID</th>
                            <td>{{ $payment->stripe_customer_id ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <hr>

            {{-- CUSTOMER --}}
            <div class="row mb-4">
                <div class="col-md-6">
                    <h6 class="text-muted">Customer</h6>
                    <table class="table table-sm table-borderless">
                        <tr>
                            <th>Name</th>
                            <td>
                                {{ $payment->first_name }} {{ $payment->last_name }}
                            </td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $payment->email }}</td>
                        </tr>
                        <tr>
                            <th>Country</th>
                            <td>{{ $payment->country ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Address</th>
                            <td>{{ $payment->address ?? '-' }}</td>
                        </tr>
                    </table>
                </div>

                {{-- RELATED ORDER --}}
                <div class="col-md-6">
                    <h6 class="text-muted">Related Order</h6>

                    @if ($payment->order)
                        <table class="table table-sm table-borderless">
                            <tr>
                                <th>Order #</th>
                                <td>
                                    <a href="{{ route('orders.show', $payment->order) }}">
                                        {{ $payment->order->order_number }}
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>{{ ucfirst($payment->order->status) }}</td>
                            </tr>
                            <tr>
                                <th>Total</th>
                                <td>
                                    $ {{ number_format($payment->order->total / 100, 2) }}
                                </td>
                            </tr>
                        </table>
                    @else
                        <p class="text-muted small">No order attached.</p>
                    @endif
                </div>
            </div>

            <hr>

            {{-- METADATA --}}
            <div class="row">
                <div class="col-12">
                    <h6 class="text-muted">Metadata</h6>
                    <pre class="bg-light p-3 rounded small">
{{ json_encode($payment->metadata, JSON_PRETTY_PRINT) }}
                </pre>
                </div>
            </div>
        </div>
    </div>
@endsection
