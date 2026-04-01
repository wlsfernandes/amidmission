@extends('admin.layouts.master')

@section('title', isset($banner) ? 'Edit Banner' : 'Create Banner')

@section('content')
    <div class="card border border-primary">
        <div class="card-header">
            <h5>
                <i class="uil-megaphone"></i>
                {{ isset($banner) ? 'Edit Banner' : 'Create Banner' }}
            </h5>
        </div>

        <div class="card-body">
            <x-alert />

            {{-- Helper --}}
            <div class="bg-info bg-opacity-10 text-info small p-3 rounded mb-4">
                <span class="text-primary fw-semibold">How to create or edit a banner:</span><br>
                • The <span class="text-dark">English title</span> is required and used internally.<br>
                • Use the <span class="text-success">Publish switch</span> to control banner visibility.<br>
                • Publish dates control <span class="text-warning">when</span> the banner appears on the website.<br>
                • Banners are usually short and direct — subtitles are optional.<br>
                • You can unpublish a banner at any time without deleting it.
            </div>

            <hr />

            <form method="POST" action="{{ isset($banner) ? route('banners.update', $banner) : route('banners.store') }}"
                enctype="multipart/form-data">
                @csrf
                @if (isset($banner))
                    @method('PUT')
                @endif
                <input type="hidden" name="page_id" value="{{ $pageId ?? ($banner->page_id ?? '') }}">

                <div class="d-flex align-items-center gap-4 mb-4">

                    {{-- Publish switch --}}
                    <div class="form-check form-switch form-switch-lg">
                        <input type="checkbox" name="is_published" value="1" class="form-check-input" id="is_published"
                            {{ old('is_published', $banner->is_published ?? false) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_published">
                            Publish this banner on the website
                        </label>
                    </div>

                    {{-- Open in new tab switch --}}
                    <div class="form-check form-switch form-switch-lg">
                        <input type="checkbox" name="open_in_new_tab" value="1" class="form-check-input"
                            id="open_in_new_tab"
                            {{ old('open_in_new_tab', $banner->open_in_new_tab ?? false) ? 'checked' : '' }}>
                        <label class="form-check-label" for="open_in_new_tab">
                            Open link in a new tab
                        </label>
                    </div>

                </div>


                <div class="row">
                    <div class="col-md-6 mb-3">
                        <input type="date" name="publish_start_at" class="form-control"
                            value="{{ old('publish_start_at', optional($banner->publish_start_at ?? null)->toDateString()) }}">
                        <small class="text-muted">
                            Banner becomes visible on this date.
                        </small>
                    </div>

                    <div class="col-md-6 mb-3">
                        <input type="date" name="publish_end_at" class="form-control"
                            value="{{ old('publish_end_at', optional($banner->publish_end_at ?? null)->toDateString()) }}">
                        <small class="text-muted">
                            Banner is hidden after this date.
                        </small>
                    </div>
                </div>

                <hr>

                {{-- =======================
                Titles
                ======================== --}}
                <div class="row g-4">

                    <div class="col-md-4">
                        <label class="form-label">Title (EN)</label>
                        <textarea name="title_en" class="form-control ckeditor-title" rows="3">{{ old('title_en', $banner->title_en ?? '') }}</textarea>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Title (ES)</label>
                        <textarea name="title_es" class="form-control ckeditor-title" rows="3">{{ old('title_es', $banner->title_es ?? '') }}</textarea>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Title (PT)</label>
                        <textarea name="title_pt" class="form-control ckeditor-title" rows="3">{{ old('title_pt', $banner->title_pt ?? '') }}</textarea>
                    </div>
                </div>
                <hr>

                {{-- =======================
                Subtitles (Optional)
                ======================== --}}
                <div class="row g-4">

                    <div class="col-md-4">
                        <label class="form-label">Subtitle (EN)</label>
                        <textarea name="subtitle_en" class="form-control ckeditor" rows="3">{{ old('subtitle_en', $banner->subtitle_en ?? '') }}</textarea>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Subtitle (ES)</label>
                        <textarea name="subtitle_es" class="form-control ckeditor" rows="3">{{ old('subtitle_es', $banner->subtitle_es ?? '') }}</textarea>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Subtitle (PT)</label>
                        <textarea name="subtitle_pt" class="form-control ckeditor" rows="3">{{ old('subtitle_pt', $banner->subtitle_pt ?? '') }}</textarea>
                    </div>
                </div>
                <hr>

                {{-- =======================
                External Link
                ======================== --}}
                <div class="mb-3">
                    <input type="url" name="link" class="form-control" placeholder="https://example.com"
                        value="{{ old('link', $banner->link ?? '') }}">
                    <small class="text-muted">
                        Optional link when the banner is clicked.
                    </small>
                </div>

                <hr>

                {{-- =======================
                Sort Order
                ======================== --}}
                <div class="mb-4">
                    <input type="number" name="sort_order" class="form-control"
                        value="{{ old('sort_order', $banner->sort_order ?? 0) }}">
                    <small class="text-muted">
                        Lower numbers appear first.
                    </small>
                </div>

                <hr>

                @if (isset($banner) && $banner->image_url)
                    <div class="mb-4 text-center">
                        <div class="mb-2 fw-semibold">Current image</div>
                        <img src="{{ route('admin.images.preview', ['model' => 'banners', 'id' => $banner->id]) }}"
                            class="img-thumbnail mb-3" style="max-height: 220px;" alt="Current image">
                    </div>
                @endif
                <div class="mb-3">
                    <input type="file" name="image_url" class="form-control mt-3" accept="image/*">
                    <small class="text-muted">
                        Recommended: 1920x720px (or similar ratio)
                    </small>
                </div>
                {{-- =======================
                Actions
                ======================== --}}
                <div class="d-flex justify-content-between">
                    <a href="{{ route('banners.index') }}" class="btn btn-secondary">
                        <i class="uil-arrow-left"></i> Back
                    </a>

                    <button type="submit" class="btn btn-primary">
                        <i class="uil-save"></i>
                        {{ isset($banner) ? 'Update Banner' : 'Create Banner' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
