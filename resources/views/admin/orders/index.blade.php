@extends('admin.layouts.master')

@section('title', 'Orders')

@section('css')
    <link href="{{ asset('/assets/admin/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="card border border-primary">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="uil-shopping-cart"></i> Orders
            </h5>
        </div>

        <div class="card-body">
            <x-alert />

            <table class="table table-bordered datatable-buttons">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Customer</th>
                        <th>Status</th>
                        <th>Total</th>
                        <th>Currency</th>
                        <th>Date</th>
                        <th width="120">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            {{-- Order Number --}}
                            <td>
                                <strong>#{{ $order->order_number }}</strong>
                            </td>

                            {{-- Customer --}}
                            <td>
                                <strong>{{ $order->first_name }} {{ $order->last_name }}</strong><br>
                                <small class="text-muted">{{ $order->email }}</small>
                            </td>

                            {{-- Status --}}
                            <td class="text-center">
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
                            </td>

                            {{-- Total --}}
                            <td>
                                $ {{ number_format($order->total / 100, 2) }}
                            </td>

                            {{-- Currency --}}
                            <td class="text-uppercase">
                                {{ $order->currency }}
                            </td>

                            {{-- Date --}}
                            <td>
                                {{ $order->created_at->format('M d, Y') }}<br>
                                <small class="text-muted">{{ $order->created_at->format('H:i') }}</small>
                            </td>

                            {{-- Actions --}}
                            <td>
                                <a href="{{ route('orders.show', $order) }}">
                                    <i class="fas fa-eye text-primary"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('/assets/admin/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('/assets/admin/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('/assets/admin/libs/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('/assets/admin/js/pages/datatables.init.js') }}"></script>
@endsection
