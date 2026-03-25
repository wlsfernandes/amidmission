@extends('admin.layouts.master')

@section('title', 'Audit Trail')

@section('css')
    <link href="{{ asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card border border-primary">
                <div class="card-header bg-transparent border-primary">
                    <h5 class="my-0 text-primary">
                        <i class="uil-history"></i> Audit Trail
                    </h5>
                </div>

                <div class="card-body">
                    <table class="table table-bordered datatable-buttons">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>User</th>
                                <th>Action</th>
                                <th>Model</th>
                                <th>Record ID</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($audits as $audit)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $audit->created_at->format('Y-m-d H:i:s') }}</td>
                                                        <td>{{ $audit->user->name ?? 'System' }}</td>
                                                        <td>
                                                            <span class="badge bg-{{ match ($audit->action) {
                                    'created' => 'success',
                                    'updated' => 'warning',
                                    'deleted' => 'danger',
                                    default => 'secondary'
                                } }}">
                                                                {{ strtoupper($audit->action) }}
                                                            </span>
                                                        </td>
                                                        <td>{{ class_basename($audit->auditable_type) }}</td>
                                                        <td>{{ $audit->auditable_id }}</td>
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