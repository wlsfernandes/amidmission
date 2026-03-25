@extends('admin.layouts.master')

@section('title')
    Help
@endsection

@section('css')
    <!-- plugin css -->
    <link href="{{ asset('/assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/assets/libs/spectrum-colorpicker/spectrum-colorpicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/assets/libs/bootstrap-touchspin/bootstrap-touchspin.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('/assets/libs/datepicker/datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/libs/flatpickr/flatpickr.min.css') }}">
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card border border-primary">
                    <div class="card-header bg-transparent border-primary">
                        <h5 class="my-0 text-primary"><i class="dripicons-help"></i> Help</b></h5>
                    </div>
                    <div class="card-body">
                        <x-alert />

                        <form method="POST"
                            action="{{ isset($wikipedia->id) ? route('wikipedias.update', $wikipedia->id) : route('wikipedias.store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            @if (isset($wikipedia->id))
                                @method('PUT')
                            @endif

                            <div class="mb-3 row">
                                <label for="question" class="col-md-2 col-form-label">Question:</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" value="{{ $wikipedia->question ?? '' }}"
                                        id="question" name="question" required>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="form-label">Content (English)</label>
                                <div class="col-md-12">
                                    <textarea class="form-control ckeditor" id="answer" name="answer" rows="6"
                                        placeholder="Write the blog content in English...">{{ old('answer', $wikipedia->answer ?? '') }}</textarea>

                                    <small class="text-muted">
                                        This content will appear on the public blog page.
                                    </small>
                                </div>


                                <div class="mb-3 row">
                                    <div class="col-md-12 text-end">
                                        <button type="submit" class="btn btn-primary">
                                            {{ isset($wikipedia->id) ? 'Update' : 'Create' }}
                                        </button>
                                    </div>
                                </div>
                        </form>

                    </div>
                </div>
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
    @endsection
