@extends('admin.layouts.master')

@section('title', 'Order #' . $order->order_number)

@section('content')
    <div class="row">

        {{-- LEFT: ORDER + CUSTOMER --}}
        <div class="col-lg-5">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="uil-receipt"></i> Order Details
                    </h5>
                </div>

                <div class="card-body">
                    <p>
                        <strong>Order #:</strong> {{ $order->order_number }}<br>
                        <strong>Status:</strong>
                        <span
                            class="badge
            @if ($order->status === 'paid') bg-success
            @elseif ($order->status === 'pending') bg-warning
            @elseif ($order->status === 'shipped') bg-info
            @elseif ($order->status === 'delivered') bg-primary
            @else bg-secondary @endif
          ">
                            {{ ucfirst($order->status) }}
                        </span>
                    </p>

                    <hr>

                    <p class="mb-1"><strong>Customer</strong></p>
                    <p class="mb-1">
                        {{ $order->first_name }} {{ $order->last_name }}<br>
                        <small class="text-muted">{{ $order->email }}</small>
                    </p>

                    <hr>

                    <p class="mb-1"><strong>Shipping Address</strong></p>
                    <p class="mb-0">
                        {{ $order->address }}<br>
                        {{ $order->country }}
                    </p>

                    <hr>

                    <p class="mb-0">
                        <strong>Placed on:</strong><br>
                        {{ $order->created_at->format('M d, Y H:i') }}
                    </p>
                </div>
            </div>
        </div>

        {{-- RIGHT: ITEMS + TOTAL --}}
        <div class="col-lg-7">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="uil-box"></i> Products
                    </h5>
                </div>

                <div class="card-body p-0">
                    <table class="table mb-0 table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Product</th>
                                <th class="text-center">Qty</th>
                                <th class="text-end">Price</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($order->items as $item)
                                <tr>
                                    <td>
                                        <strong>{{ $item->product_name }}</strong><br>
                                        <small class="text-muted">
                                            Product ID: {{ $item->product_id }}
                                        </small>
                                    </td>

                                    <td class="text-center">
                                        {{ $item->quantity }}
                                    </td>

                                    <td class="text-end">
                                        $ {{ number_format($item->price / 100, 2) }}
                                    </td>

                                    <td class="text-end">
                                        $ {{ number_format(($item->price * $item->quantity) / 100, 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- TOTALS --}}
            <div class="card">
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Subtotal</span>
                            <span>$ {{ number_format($order->subtotal / 100, 2) }}</span>
                        </li>

                        <li class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Shipping</span>
                            <span>$ {{ number_format($order->shipping / 100, 2) }}</span>
                        </li>

                        <li class="d-flex justify-content-between pt-3 border-top">
                            <strong>Total</strong>
                            <strong class="fs-5">
                                $ {{ number_format($order->total / 100, 2) }}
                            </strong>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
@endsection
