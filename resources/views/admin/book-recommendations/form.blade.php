@extends('admin.layouts.master')

@section('title', isset($book) ? 'Edit Book Recommendation' : 'Add Book Recommendation')

@section('content')
  <div class="card border border-primary">
    <div class="card-header">
      <h5 class="mb-0">
        <i class="uil uil-book-open"></i>
        {{ isset($book) ? 'Edit Book Recommendation' : 'Add Book Recommendation' }}
      </h5>
    </div>

    <div class="card-body">
      <x-alert />

      {{-- Helper --}}
      <div class="bg-info bg-opacity-10 text-info small p-3 rounded mb-4">
        <strong>How this works:</strong><br>
        • Books are always visible (no publish toggle).<br>
        • Titles and descriptions are bilingual.<br>
        • Cover image is optional but recommended.
      </div>

      <form method="POST"
        action="{{ isset($book) ? route('book-recommendations.update', $book) : route('book-recommendations.store') }}">
        @csrf
        @if (isset($book))
          @method('PUT')
        @endif

        {{-- Title EN --}}
        <div class="mb-3">
          <label class="form-label">Title (English)</label>
          <input type="text" name="title_en" class="form-control" required
            value="{{ old('title_en', $book->title_en ?? '') }}">
        </div>

        <div class="mb-3">
          <label class="form-label">External Link</label>
          <input type="url" name="external_link" class="form-control" required
            value="{{ old('external_link', $book->external_link ?? '') }}">
        </div>

        {{-- Title ES --}}
        <div class="mb-3">
          <label class="form-label">Title (Spanish)</label>
          <input type="text" name="title_es" class="form-control" value="{{ old('title_es', $book->title_es ?? '') }}">
        </div>

        <hr>

        {{-- Description EN --}}
        <div class="mb-3">
          <label class="form-label">Description (English)</label>
          <textarea name="description_en" class="form-control" rows="4" placeholder="Optional description in English">{{ old('description_en', $book->description_en ?? '') }}</textarea>
        </div>

        {{-- Description ES --}}
        <div class="mb-3">
          <label class="form-label">Description (Spanish)</label>
          <textarea name="description_es" class="form-control" rows="4" placeholder="Descripción opcional en español">{{ old('description_es', $book->description_es ?? '') }}</textarea>
        </div>

        <hr>

        {{-- Cover Image --}}
        <div class="mb-4">
          <label class="form-label">Book Cover Image</label>

          @if (isset($book) && $book->image_url)
            <div class="mb-2">
              <a href="{{ route('admin.images.preview', [
                  'model' => 'book-recommendations',
                  'id' => $book->id,
              ]) }}"
                target="_blank">
                <img
                  src="{{ route('admin.images.preview', [
                      'model' => 'book-recommendations',
                      'id' => $book->id,
                  ]) }}"
                  alt="Book cover" class="rounded" style="width:80px;height:120px;object-fit:cover;">
              </a>
            </div>
          @endif

          <a href="{{ isset($book) ? route('admin.images.edit', ['model' => 'book-recommendations', 'id' => $book->id]) : '#' }}"
            class="btn btn-outline-primary btn-sm {{ isset($book) ? '' : 'disabled' }}">
            <i class="uil uil-image"></i> Upload / Change Cover
          </a>

          @unless (isset($book))
            <div class="small text-muted mt-1">
              Save the book first to upload an image.
            </div>
          @endunless
        </div>

        {{-- Actions --}}
        <div class="d-flex justify-content-between">
          <a href="{{ route('book-recommendations.index') }}" class="btn btn-secondary">
            <i class="uil uil-arrow-left"></i> Back
          </a>

          <button type="submit" class="btn btn-primary">
            <i class="uil uil-save"></i>
            {{ isset($book) ? 'Update Book' : 'Create Book' }}
          </button>
        </div>

      </form>
    </div>
  </div>
@endsection
