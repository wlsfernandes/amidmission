@extends('admin.layouts.master')

@section('title', isset($media) ? 'Edit Media' : 'Create Media')

@section('content')
  <div class="card border border-primary">
    <div class="card-header">
      <h5 class="mb-0">
        <i class="uil uil-play-circle"></i>
        {{ isset($media) ? 'Edit Media' : 'Create Media' }}
      </h5>
    </div>

    <div class="card-body">
      <x-alert />

      <div class="bg-info bg-opacity-10 text-info small p-3 rounded mb-4">
        <span class="fw-semibold text-primary">How Media works:</span><br>
        • Media items represent external content (videos, articles, podcasts).<br>
        • Choose a Media Type to classify the content.<br>
        • Titles and descriptions are bilingual.<br>
        • External links open in a new tab.
      </div>

      <form method="POST" action="{{ isset($media) ? route('media.update', $media) : route('media.store') }}">

        @csrf
        @if (isset($media))
          @method('PUT')
        @endif

        {{-- Publish --}}
        <div class="form-check form-switch form-switch-lg mb-4">
          <input type="hidden" name="is_published" value="0">
          <input type="checkbox" name="is_published" value="1" class="form-check-input" id="is_published"
            {{ old('is_published', $media->is_published ?? false) ? 'checked' : '' }}>
          <label class="form-check-label" for="is_published">
            Publish this media item
          </label>
        </div>

        {{-- Media Type --}}
        <div class="row">
          {{-- Media Type --}}
          <div class="col-md-8 mb-3">
            <label class="form-label">Media Type</label>
            <select name="media_type_id" class="form-select" required>
              <option value="">Select Media Type</option>
              @foreach ($mediaTypes as $type)
                <option value="{{ $type->id }}"
                  {{ old('media_type_id', $media->media_type_id ?? '') == $type->id ? 'selected' : '' }}>
                  {{ $type->name }}
                </option>
              @endforeach
            </select>
          </div>

          {{-- Published At --}}
          <div class="col-md-4 mb-3">
            <label class="form-label">Published Date</label>
            <input type="date" name="published_at" class="form-control"
              value="{{ old('published_at', isset($media->published_at) ? $media->published_at->format('Y-m-d') : '') }}">
          </div>
        </div>
        {{-- External Link --}}
        <div class="mb-3">
          <label class="form-label">External Link</label>
          <input type="url" name="external_link" class="form-control" placeholder="https://..."
            value="{{ old('external_link', $media->external_link ?? '') }}">
        </div>
        {{-- Title EN --}}
        <div class="mb-3">
          <label class="form-label">Title (English)</label>
          <input type="text" name="title_en" class="form-control" placeholder="Title in English"
            value="{{ old('title_en', $media->title_en ?? '') }}" required>
        </div>

        {{-- Title ES --}}
        <div class="mb-3">
          <label class="form-label">Title (Spanish)</label>
          <input type="text" name="title_es" class="form-control" placeholder="Título en español"
            value="{{ old('title_es', $media->title_es ?? '') }}" required>
        </div>

        {{-- Description EN --}}
        <div class="mb-3">
          <label class="form-label">Description (English)</label>
          <textarea name="description_en" class="form-control" rows="4" placeholder="Description in English">{{ old('description_en', $media->description_en ?? '') }}</textarea>
        </div>

        {{-- Description ES --}}
        <div class="mb-3">
          <label class="form-label">Description (Spanish)</label>
          <textarea name="description_es" class="form-control" rows="4" placeholder="Descripción en español">{{ old('description_es', $media->description_es ?? '') }}</textarea>
        </div>

        {{-- Actions --}}
        <div class="d-flex justify-content-between">
          <a href="{{ route('media.index') }}" class="btn btn-secondary">
            <i class="uil uil-arrow-left"></i> Back
          </a>

          <button type="submit" class="btn btn-primary">
            <i class="uil uil-save"></i>
            {{ isset($media) ? 'Update Media' : 'Create Media' }}
          </button>
        </div>

      </form>
    </div>
  </div>
@endsection
