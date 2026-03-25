@extends('admin.layouts.master')

@section('title', isset($service) ? 'Edit Service' : 'Create Service')

@section('content')

    <div class="card border border-primary">
        <div class="card-header">
            <h5>
                <i class="uil-briefcase"></i>
                {{ isset($service) ? 'Edit Service' : 'Create Service' }}
            </h5>
        </div>


        <div class="card-body">
            <x-alert />

            {{-- Helper block --}}
            <div class="bg-info bg-opacity-10 text-info small p-3 rounded mb-4">
                <span class="text-primary fw-semibold">How to manage services:</span><br>
                • The <span class="text-dark">English title</span> is the main reference.<br>
                • Use the <span class="text-success">Publish switch</span> to control visibility.<br>
                • Descriptions support <span class="text-info">rich formatting</span>.<br>
                • Images are managed separately using the image icon on the list page.<br>
                • External links open in a new browser tab.
            </div>

            <hr />

            <form method="POST"
                action="{{ isset($service) ? route('services.update', $service) : route('services.store') }}">

                @csrf
                @isset($service)
                    @method('PUT')
                @endisset

                {{-- Publish --}}
                <div class="form-check form-switch form-switch-lg mb-4">
                    <input type="checkbox" name="is_published" value="1" class="form-check-input" id="is_published"
                        {{ old('is_published', $service->is_published ?? false) ? 'checked' : '' }}>

                    <label class="form-check-label" for="is_published">
                        Publish this service on the website
                    </label>
                </div>

                <hr>

                {{-- Titles --}}
                <div class="mb-3">
                    <input type="text" name="title_en" class="form-control" placeholder="Service title in English"
                        value="{{ old('title_en', $service->title_en ?? '') }}" required>

                    <small class="text-muted">
                        Main service title displayed publicly.
                    </small>
                </div>

                <div class="mb-3">
                    <input type="text" name="title_es" class="form-control" placeholder="Título del servicio en español"
                        value="{{ old('title_es', $service->title_es ?? '') }}">
                </div>

                <hr>

                {{-- Description EN --}}
                <div class="mb-3">
                    <textarea class="form-control ckeditor" id="description_en" name="description_en" rows="6"
                        placeholder="Describe the service in English...">{{ old('description_en', $service->description_en ?? '') }}</textarea>

                    <small class="text-muted">
                        Short description shown on the website.
                    </small>
                </div>

                {{-- Description ES --}}
                <div class="mb-3">
                    <textarea class="form-control ckeditor" id="description_es" name="description_es" rows="6"
                        placeholder="Describa el servicio en español...">{{ old('description_es', $service->description_es ?? '') }}</textarea>
                </div>

                <hr>

                {{-- External Link --}}
                <div class="mb-3">
                    <input type="url" name="external_link" class="form-control" placeholder="https://example.com"
                        value="{{ old('external_link', $service->external_link ?? '') }}">

                    <small class="text-muted">
                        Optional link for more information (opens in a new tab).
                    </small>
                </div>

                <hr>

                {{-- Actions --}}
                <div class="d-flex justify-content-between">
                    <a href="{{ route('services.index') }}" class="btn btn-secondary">
                        <i class="uil-arrow-left"></i> Back
                    </a>

                    <button type="submit" class="btn btn-primary">
                        <i class="uil-save"></i>
                        {{ isset($service) ? 'Update Service' : 'Create Service' }}
                    </button>
                </div>

            </form>
        </div>

    </div>
@endsection
