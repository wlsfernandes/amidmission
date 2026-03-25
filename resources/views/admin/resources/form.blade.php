@extends('admin.layouts.master')

@section('title', isset($resource) ? 'Edit Resource' : 'Create Resource')

@section('content')
    <div class="card border border-primary">
        <div class="card-header">
            <h5>
                <i class="fas fa-folder-open"></i>
                {{ isset($resource) ? 'Edit Resource' : 'Create Resource' }}
            </h5>
        </div>

        <div class="card-body">
            <x-alert />

            {{-- Helper block --}}
            <div class="bg-info bg-opacity-10 text-info small p-3 rounded mb-4">
                <span class="text-primary fw-semibold">How resources work:</span><br>
                • Resources are <span class="text-dark">downloadable materials</span> such as PDFs, guides, or reports.<br>
                • You may upload files in <span class="text-dark">English and Spanish</span> separately.<br>
                • Alternatively, you can provide an <span class="text-dark">external link</span> (Google Drive, partner site,
                etc.).<br>
                • Use the <span class="text-success">Publish switch</span> to control public visibility.
            </div>

            <hr />

            <form method="POST"
                action="{{ isset($resource) ? route('resources.update', $resource) : route('resources.store') }}">
                @csrf
                @isset($resource)
                    @method('PUT')
                @endisset

                {{-- =======================
                Publish Controls
                ======================== --}}
                <div class="form-check form-switch form-switch-lg mb-4">
                    <input type="checkbox" name="is_published" value="1" class="form-check-input" id="is_published"
                        {{ old('is_published', $resource->is_published ?? false) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_published">
                        Publish this resource on the website
                    </label>
                </div>

                <hr>

                {{-- =======================
                Titles
                ======================== --}}
                <div class="mb-3">
                    <input type="text" name="title_en" class="form-control @error('title_en') is-invalid @enderror"
                        placeholder="Resource title in English" value="{{ old('title_en', $resource->title_en ?? '') }}"
                        required>

                    <small class="text-muted">
                        Required. Displayed as the main resource title.
                    </small>

                    @error('title_en')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <input type="text" name="title_es" class="form-control" placeholder="Título del recurso en español"
                        value="{{ old('title_es', $resource->title_es ?? '') }}">
                    <small class="text-muted">
                        Optional Spanish version.
                    </small>
                </div>

                <hr>

                {{-- =======================
                Descriptions
                ======================== --}}
                <div class="mb-3">
                    <textarea class="form-control ckeditor" name="description_en" rows="3"
                        placeholder="Short description in English...">{{ old('description_en', $resource->description_en ?? '') }}</textarea>
                    <small class="text-muted">
                        Brief description shown next to the resource.
                    </small>
                </div>

                <div class="mb-3">
                    <textarea class="form-control ckeditor" name="description_es" rows="3"
                        placeholder="Descripción corta en español...">{{ old('description_es', $resource->description_es ?? '') }}</textarea>
                </div>

                <hr>

                {{-- =======================
                External Link
                ======================== --}}
                <div class="mb-3">
                    <input type="url" name="external_link" class="form-control"
                        placeholder="https://external-resource-link.com"
                        value="{{ old('external_link', $resource->external_link ?? '') }}">
                    <small class="text-muted">
                        Optional. Use if the resource is hosted externally.
                    </small>
                </div>

                <hr>

                {{-- =======================
                Actions
                ======================== --}}
                <div class="d-flex justify-content-between">
                    <a href="{{ route('resources.index') }}" class="btn btn-secondary">
                        <i class="uil-arrow-left"></i> Back
                    </a>

                    <button type="submit" class="btn btn-primary">
                        <i class="uil-save"></i>
                        {{ isset($resource) ? 'Update Resource' : 'Create Resource' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
