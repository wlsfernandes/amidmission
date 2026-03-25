@extends('admin.layouts.master')

@section('title', 'Upload Image')

@section('css')
  <link href="{{ asset('/assets/admin/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
  <div class="card border border-primary">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">
        <i class="uil uil-image-upload"></i>
        Upload Image
      </h5>

      <span class="badge bg-primary">
        {{ strtoupper($modelKey) }}
      </span>
    </div>

    <div class="card-body">
      <x-alert />

      {{-- Guidelines (User-friendly + clear) --}}
      <div class="bg-info bg-opacity-10 text-info small p-3 rounded mb-4">
        <strong>Image upload guidelines</strong><br>
        • Your image will be automatically converted to <strong>WebP</strong> and optimized for faster loading.<br>
        • Choose an <strong>Image Type</strong> below. This tells the system whether to <strong>crop</strong> (for banners/cards)
        or <strong>fit</strong> (for regular images) to avoid stretching.<br>
        • To keep your content safe: for cropped types (like banners), keep important text/faces <strong>centered</strong>.
      </div>

      {{-- Current image preview --}}
      @if ($image)
        <div class="mb-4 text-center">
          <div class="mb-2 fw-semibold">Current image</div>

          <img
            src="{{ route('admin.images.preview', ['model' => $modelKey, 'id' => $model->id]) }}"
            class="img-thumbnail mb-3"
            style="max-height: 220px;"
            alt="Current image"
          >

          <form
            method="POST"
            action="{{ route('admin.images.destroy', ['model' => $modelKey, 'id' => $model->id]) }}"
            onsubmit="return confirm('Are you sure you want to delete this image?')"
          >
            @csrf
            @method('DELETE')

            <button type="submit" class="btn btn-sm btn-danger">
              <i class="uil uil-trash"></i> Delete Image
            </button>
          </form>
        </div>
      @endif

      {{-- Upload form --}}
      <form method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Image Type --}}
        <div class="mb-3">
          <label class="form-label fw-semibold">
            Image Type <span class="text-danger">*</span>
          </label>

          <select name="image_type" class="form-select" required>
            {{-- Smart defaults based on modelKey --}}
            @php
              $defaultType = match($modelKey) {
                'banners' => 'banner',
                'blogs'   => 'blog_social',
                'event'   => 'event_header',
                default   => 'original_fit',
              };
            @endphp

            <option value="banner" {{ old('image_type', $defaultType) === 'banner' ? 'selected' : '' }}>
              Banner (Crop) — 1920 × 600
            </option>

            <option value="blog_social" {{ old('image_type', $defaultType) === 'blog_social' ? 'selected' : '' }}>
              Blog / Social (Crop) — 1200 × 630
            </option>

            <option value="event_header" {{ old('image_type', $defaultType) === 'event_header' ? 'selected' : '' }}>
              Event Header (Crop) — 1200 × 500
            </option>

            <option value="card" {{ old('image_type', $defaultType) === 'card' ? 'selected' : '' }}>
              Card (Crop) — 900 × 600
            </option>

            <option value="square" {{ old('image_type', $defaultType) === 'square' ? 'selected' : '' }}>
              Square / Avatar (Crop) — 800 × 800
            </option>

            <option value="original_fit" {{ old('image_type', $defaultType) === 'original_fit' ? 'selected' : '' }}>
              Original Fit (No Crop) — Max 1600px (keeps full image)
            </option>
          </select>

          <small class="text-muted d-block mt-1">
            <strong>Crop</strong> types keep layout perfect (banner/card) but may cut edges.
            <strong>Original Fit</strong> keeps the full image without cropping.
          </small>
        </div>

        {{-- Explanation box that matches the chosen type (simple server-side default + clear text) --}}
        <div class="bg-light border rounded p-3 mb-4 small">
          <div class="fw-semibold mb-2">
            What will happen to your image?
          </div>

          @php
            $selectedType = old('image_type', $defaultType);
          @endphp

          @if ($selectedType === 'banner')
            • We will create a <strong>1920×600</strong> banner and <strong>crop</strong> to a wide ratio (no stretching).<br>
            • Keep important content in the <strong>center</strong> to avoid losing it on crop.
          @elseif ($selectedType === 'blog_social')
            • We will create a <strong>1200×630</strong> image and <strong>crop</strong> to a social-friendly ratio.<br>
            • Great for blog headers and sharing previews.
          @elseif ($selectedType === 'event_header')
            • We will create a <strong>1200×500</strong> header and <strong>crop</strong> to fit the event layout.<br>
            • Choose a horizontal image with good contrast.
          @elseif ($selectedType === 'card')
            • We will create a <strong>900×600</strong> image and <strong>crop</strong> for card layouts.<br>
            • Keeps cards consistent across the site.
          @elseif ($selectedType === 'square')
            • We will create an <strong>800×800</strong> image and <strong>crop</strong> to a perfect square.<br>
            • Best for avatars, icons, and small profile images.
          @else
            • We will <strong>not crop</strong>. The image will be resized to a maximum of <strong>1600px</strong> on the longest side.<br>
            • Best when you want to keep the entire image visible.
          @endif

          <div class="mt-2 text-muted">
            Tip: if your image looks “cut”, upload a wider version or keep the main subject centered.
          </div>
        </div>

        {{-- File input --}}
        <div class="mb-3">
          <label class="form-label fw-semibold">
            Select Image <span class="text-danger">*</span>
          </label>
          <input type="file" name="image" class="form-control" accept="image/*" required>

          <small class="text-muted">
            Allowed: JPG, PNG, WebP. Max 5MB.
          </small>
        </div>

        {{-- Actions --}}
        <div class="d-flex justify-content-between">
          <a href="{{ url()->previous() }}" class="btn btn-secondary">
            Back
          </a>

          <button class="btn btn-primary">
            <i class="uil uil-upload"></i> Upload Image
          </button>
        </div>
      </form>
    </div>
  </div>
@endsection