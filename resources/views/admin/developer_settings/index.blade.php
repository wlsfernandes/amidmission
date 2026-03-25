@extends('admin.layouts.master')

@section('title', 'Developer Settings')
@section('css')
  <link href="{{ asset('/assets/admin/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="card border border-danger">
        <div class="card-header bg-danger bg-opacity-10">
            <h5 class="text-danger mb-0">
                <i class="fas fa-exclamation-triangle"></i> Developer Settings
            </h5>
        </div>

        <div class="card-body">
            <x-alert />

            <div class="alert alert-danger">
                <strong>⚠️ Warning:</strong><br>
                These settings control critical infrastructure such as payments, email delivery,
                cloud storage, queues, and security services.
                <br><br>
                <strong>Changing values here may break the website.</strong>
                Only users with technical knowledge should proceed.
            </div>

            <div class="mt-4">
                <a href="{{ route('developer-settings.edit') }}" class="btn btn-danger">
                    <i class="fas fa-cogs"></i> Edit Developer Settings
                </a>

                <a href="{{ url()->previous() }}" class="btn btn-secondary ms-2">
                    <i class="uil-arrow-left"></i> Back
                </a>
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