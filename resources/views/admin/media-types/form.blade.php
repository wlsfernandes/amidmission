@extends('admin.layouts.master')

@section('title', isset($mediaType) ? 'Edit Media Type' : 'Create Media Type')

@section('content')
  <div class="card border border-primary">
    <div class="card-header">
      <h5 class="mb-0">
        <i class="uil uil-list-ul"></i>
        {{ isset($mediaType) ? 'Edit Media Type' : 'Create Media Type' }}
      </h5>
    </div>

    <div class="card-body">
      <x-alert />

      <div class="bg-info bg-opacity-10 text-info small p-3 rounded mb-4">
        <span class="fw-semibold text-primary">How Media Types work:</span><br>
        • Media Types classify content (Video, Article, Podcast, etc.).<br>
        • Slugs are generated automatically.<br>
        • You can deactivate a type without deleting it.
      </div>

      <form method="POST"
        action="{{ isset($mediaType) ? route('media-types.update', $mediaType) : route('media-types.store') }}">

        @csrf
        @if (isset($mediaType))
          @method('PUT')
        @endif

        {{-- Active --}}
        <div class="form-check form-switch form-switch-lg mb-4">
          <input type="hidden" name="is_active" value="0">
          <input type="checkbox" name="is_active" value="1" class="form-check-input" id="is_active"
            {{ old('is_active', $mediaType->is_active ?? true) ? 'checked' : '' }}>
          <label class="form-check-label" for="is_active">
            Active
          </label>
        </div>

        {{-- Name --}}
        <div class="mb-3">
          <label class="form-label">Name</label>
          <input type="text" name="name" class="form-control" placeholder="e.g. Video, Article, Podcast"
            value="{{ old('name', $mediaType->name ?? '') }}" required>
        </div>
        {{-- Description EN --}}
        <div class="mb-3">
          <label class="form-label">Description (English)</label>
          <textarea name="description_en" class="form-control" rows="3" placeholder="Short description for this media type">
    {{ old('description_en', $mediaType->description_en ?? '') }}
  </textarea>
        </div>

        {{-- Description ES --}}
        <div class="mb-3">
          <label class="form-label">Description (Spanish)</label>
          <textarea name="description_es" class="form-control" rows="3"
            placeholder="Descripción corta para este tipo de contenido">
    {{ old('description_es', $mediaType->description_es ?? '') }}
  </textarea>
        </div>

        {{-- Actions --}}
        <div class="d-flex justify-content-between mt-4">
          <a href="{{ route('media-types.index') }}" class="btn btn-secondary">
            <i class="uil uil-arrow-left"></i> Back
          </a>

          <button type="submit" class="btn btn-primary">
            <i class="uil uil-save"></i>
            {{ isset($mediaType) ? 'Update Media Type' : 'Create Media Type' }}
          </button>
        </div>

      </form>
    </div>
  </div>
@endsection
