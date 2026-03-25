@extends('admin.layouts.master')

@section('title', 'Payments')

@section('css')
    <link href="{{ asset('/assets/admin/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="card border border-primary">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="uil-credit-card"></i> Payments
            </h5>
        </div>

        <div class="card-body">
            <x-alert />

            <table class="table table-bordered datatable-buttons align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Type</th>
                        <th>Reference</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Amount</th>
                        <th>Currency</th>
                        <th>Paid At</th>
                        <th width="120">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($payments as $payment)
                        <tr>
                            {{-- ID --}}
                            <td>
                                <strong>#{{ $payment->id }}</strong>
                            </td>

                            {{-- Type --}}
                            <td>
                                <span class="badge bg-info">
                                    {{ class_basename($payment->payable_type) }}
                                </span>
                            </td>

                            {{-- Reference --}}
                            <td>
                                @if ($payment->payable_type === \App\Models\Order::class && $payment->order)
                                    <a href="{{ route('orders.show', $payment->order) }}">
                                        Order #{{ $payment->order->order_number }}
                                    </a>
                                @elseif ($payment->payable_type === \App\Models\Donation::class)
                                    Donation #{{ $payment->payable_id }}
                                @else
                                    —
                                @endif
                            </td>

                            {{-- Email --}}
                            <td>
                                {{ $payment->email }}
                            </td>

                            {{-- Status --}}
                            <td class="text-center">
                                <span
                                    class="badge
                @if ($payment->status === 'completed') bg-success
                @elseif ($payment->status === 'pending') bg-warning
                @else bg-secondary @endif
              ">
                                    {{ ucfirst($payment->status) }}
                                </span>
                            </td>

                            {{-- Amount --}}
                            <td class="text-end">
                                $ {{ number_format($payment->amount / 100, 2) }}
                            </td>

                            {{-- Currency --}}
                            <td class="text-center">
                                {{ strtoupper($payment->currency) }}
                            </td>

                            {{-- Paid At --}}
                            <td>
                                {{ $payment->paid_at?->format('M d, Y H:i') ?? '-' }}
                            </td>

                            {{-- Actions --}}
                            <td class="text-center">
                                <a href="{{ route('admin.payments.show', $payment) }}" class="btn btn-sm btn-primary"
                                    title="View payment">
                                    <i class="fas fa-eye text-white"></i>
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
