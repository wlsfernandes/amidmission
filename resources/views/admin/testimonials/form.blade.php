@extends('admin.layouts.master')

@section('title', isset($testimonial) ? 'Edit Testimonial' : 'Create Testimonial')

@section('content')
    <div class="card border border-primary">
        <div class="card-header">
            <h5>
                <i class="fas fa-comment-dots"></i>
                {{ isset($testimonial) ? 'Edit Testimonial' : 'Create Testimonial' }}
            </h5>
        </div>

        <div class="card-body">
            <x-alert />

            {{-- Helper block --}}
            <div class="bg-info bg-opacity-10 text-info small p-3 rounded mb-4">
                <span class="text-primary fw-semibold">How to manage testimonials:</span><br>
                • Write the testimonial content in <span class="text-dark">English</span> (required).<br>
                • Optionally add a <span class="text-dark">Spanish</span> version.<br>
                • The <span class="text-dark">name and role</span> help identify the author (optional).<br>
                • Use the <span class="text-success">Publish switch</span> to control public visibility.<br>
                • Author photos are managed separately using the image icon on the list page.
            </div>

            <hr />

            <form method="POST"
                action="{{ isset($testimonial) ? route('testimonials.update', $testimonial) : route('testimonials.store') }}">
                @csrf
                @isset($testimonial)
                    @method('PUT')
                @endisset

                {{-- =======================
                Publish Controls
                ======================== --}}
                <div class="form-check form-switch form-switch-lg mb-4">
                    <input type="checkbox" name="is_published" value="1" class="form-check-input" id="is_published"
                        {{ old('is_published', $testimonial->is_published ?? false) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_published">
                        Publish this testimonial on the website
                    </label>
                </div>

                <hr>

                {{-- =======================
                Author Info
                ======================== --}}
                <div class="mb-3">
                    <input type="text" name="name" class="form-control" placeholder="Author name (optional)"
                        value="{{ old('name', $testimonial->name ?? '') }}">
                    <small class="text-muted">
                        Example: John Doe
                    </small>
                </div>

                <div class="mb-3">
                    <input type="text" name="role" class="form-control" placeholder="Author role or title (optional)"
                        value="{{ old('role', $testimonial->role ?? '') }}">
                    <small class="text-muted">
                        Example: Student, Pastor, Partner
                    </small>
                </div>

                <hr>

                {{-- =======================
                Content
                ======================== --}}
                <div class="mb-3">
                    <textarea class="form-control ckeditor" id="content_en" name="content_en" rows="5"
                        placeholder="Write the testimonial in English...">{{ old('content_en', $testimonial->content_en ?? '') }}</textarea>
                    <small class="text-muted">
                        Required. This is the main testimonial text.
                    </small>
                </div>


                <div class="mb-3">
                    <textarea class="form-control ckeditor" id="content_es" name="content_es" rows="5"
                        placeholder="Escriba el testimonio en español...">{{ old('content_es', $testimonial->content_es ?? '') }}</textarea>
                    <small class="text-muted">
                        Optional Spanish version.
                    </small>
                </div>

                <hr>

                {{-- =======================
                Actions
                ======================== --}}
                <div class="d-flex justify-content-between">
                    <a href="{{ route('testimonials.index') }}" class="btn btn-secondary">
                        <i class="uil-arrow-left"></i> Back
                    </a>

                    <button type="submit" class="btn btn-primary">
                        <i class="uil-save"></i>
                        {{ isset($testimonial) ? 'Update Testimonial' : 'Create Testimonial' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
