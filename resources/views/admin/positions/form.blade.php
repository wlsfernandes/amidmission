@extends('admin.layouts.master')

@section('title', isset($position) ? 'Edit Position' : 'Create Position')

@section('content')
    <div class="card border border-primary">
        <div class="card-header">
            <h5>
                <i class="fas fa-briefcase"></i>
                {{ isset($position) ? 'Edit Position' : 'Create Position' }}
            </h5>
        </div>

        <div class="card-body">
            <x-alert />

            {{-- Helper block --}}
            <div class="bg-info bg-opacity-10 text-info small p-3 rounded mb-4">
                <span class="text-primary fw-semibold">How to manage open positions:</span><br>
                • The <span class="text-dark">English title</span> is required and used as the main reference.<br>
                • Use the <span class="text-success">Publish switch</span> to control public visibility.<br>
                • Publish dates define <span class="text-warning">when</span> the position is visible on the website.<br>
                • Job descriptions support <span class="text-info">basic formatting only</span>.<br>
                • Images and files (job descriptions) are managed separately from this form.
            </div>

            <hr />

            <form method="POST"
                action="{{ isset($position) ? route('positions.update', $position) : route('positions.store') }}">
                @csrf
                @isset($position)
                    @method('PUT')
                @endisset

                {{-- =======================
                Publish Controls
                ======================== --}}
                <div class="form-check form-switch form-switch-lg mb-4">
                    <input type="checkbox" name="is_published" value="1" class="form-check-input" id="is_published"
                        {{ old('is_published', $position->is_published ?? false) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_published">
                        Publish this position on the website
                    </label>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <input type="date" name="publish_start_at" class="form-control"
                            value="{{ old('publish_start_at', optional($position->publish_start_at ?? null)->toDateString()) }}">
                        <small class="text-muted">
                            Position becomes visible on the website.
                        </small>
                    </div>

                    <div class="col-md-6 mb-3">
                        <input type="date" name="publish_end_at" class="form-control"
                            value="{{ old('publish_end_at', optional($position->publish_end_at ?? null)->toDateString()) }}">
                        <small class="text-muted">
                            Position is hidden after this date.
                        </small>
                    </div>
                </div>

                <hr>

                {{-- =======================
                Titles
                ======================== --}}
                <div class="mb-3">
                    <input type="text" name="title_en" class="form-control @error('title_en') is-invalid @enderror"
                        placeholder="Position title in English" value="{{ old('title_en', $position->title_en ?? '') }}"
                        required>
                    <small class="text-muted">
                        Required. Displayed as the main position title.
                    </small>

                    @error('title_en')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <input type="text" name="title_es" class="form-control" placeholder="Título del puesto en español"
                        value="{{ old('title_es', $position->title_es ?? '') }}">
                    <small class="text-muted">
                        Optional Spanish version of the title.
                    </small>
                </div>

                <hr>

                {{-- =======================
                Content
                ======================== --}}
                <div class="mb-3">
                    <textarea class="form-control ckeditor" id="content_en" name="content_en" rows="6"
                        placeholder="Write the job description in English...">{{ old('content_en', $position->content_en ?? '') }}</textarea>
                    <small class="text-muted">
                        Main job description shown on the public page.
                    </small>
                </div>

                <div class="mb-3">
                    <textarea class="form-control ckeditor" id="content_es" name="content_es" rows="6"
                        placeholder="Escriba la descripción del puesto en español...">{{ old('content_es', $position->content_es ?? '') }}</textarea>
                    <small class="text-muted">
                        Optional Spanish version of the description.
                    </small>
                </div>

                <hr>

                {{-- =======================
                External Application Link
                ======================== --}}
                <div class="mb-3">
                    <input type="url" name="external_link" class="form-control"
                        placeholder="https://external-application-link.com"
                        value="{{ old('external_link', $position->external_link ?? '') }}">
                    <small class="text-muted">
                        Optional external link for job applications.
                    </small>
                </div>

                <hr>

                {{-- =======================
                Actions
                ======================== --}}
                <div class="d-flex justify-content-between">
                    <a href="{{ route('positions.index') }}" class="btn btn-secondary">
                        <i class="uil-arrow-left"></i> Back
                    </a>

                    <button type="submit" class="btn btn-primary">
                        <i class="uil-save"></i>
                        {{ isset($position) ? 'Update Position' : 'Create Position' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
