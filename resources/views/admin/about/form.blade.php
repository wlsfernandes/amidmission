@extends('admin.layouts.master')

@section('title', isset($about) ? 'Edit About Page' : 'Create About Page')

@section('content')
    <div class="card border border-primary">
        <div class="card-header">
            <h5>
                <i class="uil-file-alt"></i>
                {{ isset($about) ? 'Edit About Page' : 'Create About Page' }}
            </h5>
        </div>

        <div class="card-body">
            <x-alert />

            {{-- Helper block --}}
            <div class="bg-info bg-opacity-10 text-info small p-3 rounded mb-4">
                <span class="text-primary fw-semibold">How to manage the About page:</span><br>
                • The <span class="text-dark">English title</span> is the main reference for this page.<br>
                • Use the <span class="text-success">Publish switch</span> to control public visibility.<br>
                • Publish dates define <span class="text-warning">when</span> the page appears or disappears.<br>
                • Content supports <span class="text-info">basic formatting only</span>.<br>
                • Images are managed separately using the image icon on the list page.
            </div>

            <hr />

            <form method="POST" action="{{ isset($about) ? route('abouts.update', $about) : route('abouts.store') }}">
                @csrf
                @isset($about)
                    @method('PUT')
                @endisset

                {{-- =======================
                Publish Controls
                ======================== --}}
                <div class="form-check form-switch form-switch-lg mb-4">
                    <input type="checkbox" name="is_published" value="1" class="form-check-input" id="is_published"
                        {{ old('is_published', $about->is_published ?? false) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_published">
                        Publish this page on the website
                    </label>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <input type="date" name="publish_start_at" class="form-control"
                            value="{{ old('publish_start_at', optional($about->publish_start_at ?? null)->toDateString()) }}">
                        <small class="text-muted">
                            Page becomes visible on the website.
                        </small>
                    </div>

                    <div class="col-md-6 mb-3">
                        <input type="date" name="publish_end_at" class="form-control"
                            value="{{ old('publish_end_at', optional($about->publish_end_at ?? null)->toDateString()) }}">
                        <small class="text-muted">
                            Page is hidden after this date.
                        </small>
                    </div>
                </div>

                <hr>
                <div class="mb-3">
                    <label for="section" class="form-label fw-semibold">
                        About Section
                    </label>

                    <select name="section" id="section" class="form-select" required>
                        <option value="">-- Select section --</option>

                        @foreach (\App\Enums\AboutSection::cases() as $section)
                            <option value="{{ $section->value }}"
                                {{ old('section', $about->section?->value ?? ($about->section ?? '')) === $section->value ? 'selected' : '' }}>
                                {{ $section->label() }}
                            </option>
                        @endforeach
                    </select>


                    <small class="text-muted">
                        Each section appears as a distinct block on the About page.
                    </small>
                </div>
                {{-- =======================
                Titles & Subtitles
                ======================== --}}
                <div class="mb-3">
                    <input type="text" name="title_en" class="form-control" placeholder="Title in English"
                        value="{{ old('title_en', $about->title_en ?? '') }}" required>
                    <small class="text-muted">
                        Main title used on the About page.
                    </small>
                </div>

                <div class="mb-3">
                    <input type="text" name="title_es" class="form-control" placeholder="Título en español"
                        value="{{ old('title_es', $about->title_es ?? '') }}">
                </div>

                <div class="mb-3">
                    <input type="text" name="subtitle_en" class="form-control" placeholder="Subtitle in English"
                        value="{{ old('subtitle_en', $about->subtitle_en ?? '') }}">
                </div>

                <div class="mb-3">
                    <input type="text" name="subtitle_es" class="form-control" placeholder="Subtítulo en español"
                        value="{{ old('subtitle_es', $about->subtitle_es ?? '') }}">
                </div>

                <hr>

                {{-- =======================
                Content
                ======================== --}}
                <div class="mb-3">
                    <label class="form-label">Content (English)</label>

                    <textarea class="form-control ckeditor" id="content_en" name="content_en" rows="6"
                        placeholder="Write the About page content in English...">{{ old('content_en', $about->content_en ?? '') }}</textarea>

                    <small class="text-muted">
                        Main content displayed on the public About page.
                    </small>
                </div>


                <div class="mb-3">
                    <label class="form-label">Contenido (Español)</label>

                    <textarea class="form-control ckeditor" id="content_es" name="content_es" rows="6"
                        placeholder="Escriba el contenido en español...">{{ old('content_es', $about->content_es ?? '') }}</textarea>

                </div>

                <hr>

                {{-- =======================
                Actions
                ======================== --}}
                <div class="d-flex justify-content-between">
                    <a href="{{ route('abouts.index') }}" class="btn btn-secondary">
                        <i class="uil-arrow-left"></i> Back
                    </a>

                    <button type="submit" class="btn btn-primary">
                        <i class="uil-save"></i>
                        {{ isset($about) ? 'Update Page' : 'Create Page' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
