@extends('admin.layouts.master')

@section('title', 'System Logs')
@section('css')
    <link href="{{ asset('/assets/admin/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('css')
    <link href="{{ asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" />
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card border border-primary">
                <div class="card-header bg-transparent border-primary">
                    <h5 class="my-0 text-primary">
                        <i class="uil uil-bug"></i> System Logs
                    </h5>
                </div>

                <div class="card-body">
                    <x-alert />

                    <table class="table table-bordered datatable-buttons">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>User</th>
                                <th>Level</th>
                                <th>Action</th>
                                <th>Message</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($logs as $log)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $log->created_at->format('Y-m-d H:i') }}</td>
                                    <td>{{ $log->user->name ?? 'System' }}</td>
                                    <td>
                                        <span
                                            class="badge bg-{{ match ($log->level) {
                                                'critical' => 'danger',
                                                'error' => 'danger',
                                                'warning' => 'warning',
                                                default => 'secondary',
                                            } }}">
                                            {{ strtoupper($log->level) }}
                                        </span>
                                    </td>
                                    <td>{{ $log->action ?? '-' }}</td>

                                    <td>
                                        <small>
                                            <strong>{{ $log->message }}</strong><br>

                                            @foreach ($log->context as $key => $value)
                                                <div>
                                                    <span class="text-muted">{{ $key }}:</span>
                                                    <span>
                                                        {{ is_scalar($value) ? $value : json_encode($value) }}
                                                    </span>
                                                </div>
                                            @endforeach
                                        </small>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('/assets/admin/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('/assets/admin/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('/assets/admin/libs/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('/assets/admin/js/pages/datatables.init.js') }}"></script>
@endsection
