@extends('admin.layouts.master')

@section('title', 'Upload File')

@section('content')
    <div class="card border border-primary">
        <div class="card-header">
            <h5>
                <i class="uil-upload"></i>
                Upload File ({{ strtoupper($lang) }})
            </h5>
        </div>

        <div class="card-body">
            <x-alert />

            {{-- Small info helper --}}
            <div class="bg-info bg-opacity-10 text-info small p-3 rounded mb-4">
                Upload the <strong>{{ strtoupper($lang) }}</strong> version of the file.
                If a file already exists, it will be replaced.
            </div>

            <form method="POST" enctype="multipart/form-data">
                @csrf

                {{-- File input --}}
                <div class="mb-3">
                    <input type="file" name="file" class="form-control" required>
                    <small class="text-muted">
                        Supported files: PDF, DOCX, images, or other documents.
                    </small>
                </div>

                {{-- Actions --}}
                <div class="d-flex justify-content-between">
                    <a href="{{ url()->previous() }}" class="btn btn-secondary">
                        <i class="uil-arrow-left"></i> Back
                    </a>

                    <button type="submit" class="btn btn-primary">
                        <i class="uil-upload"></i> Upload File
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection