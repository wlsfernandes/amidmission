@extends('admin.layouts.master')

@section('title', 'Project Images')

@section('content')
  <div class="card border border-primary">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">
        <i class="uil uil-images"></i>
        Project Gallery
      </h5>

      <a href="{{ route('projects.edit', $project) }}" class="btn btn-secondary btn-sm">
        <i class="uil uil-arrow-left"></i> Back to Project
      </a>
    </div>

    <div class="card-body">
      <x-alert />

      {{-- Upload --}}
      <form method="POST" action="{{ route('projects.images.store', $project) }}" enctype="multipart/form-data"
        class="mb-4">
        @csrf
 <div class="mb-3">
          <input type="url" name="external_link" class="form-control" value="{{ old('external_link', $project->image->external_link ?? '') }}" placeholder="External Link (Optional)">
        </div>  
        <div class="row g-2 align-items-center">
          <div class="col-md-8">
            <input type="file" name="image" class="form-control" accept="image/*" required>
          </div>

          <div class="col-md-4">
            <button class="btn btn-primary w-100">
              <i class="uil uil-upload"></i> Upload Image
            </button>
          </div>
        </div>

        <p class="small text-muted mt-2 mb-0">
          Images are automatically optimized and stored as WebP.
        </p>
      </form>

      <hr>

      {{-- Gallery --}}
      @if ($project->images->count())
        <div class="row g-3">
          @foreach ($project->images as $image)
            <div class="col-md-3 col-sm-4 col-6">
              <div class="card h-100">
                <img
                  src="{{ route('admin.images.preview', [
                      'model' => 'project-images',
                      'id' => $image->id,
                  ]) }}"
                  class="card-img-top" style="height:160px;object-fit:cover;" alt="Project image">

                <div class="card-body p-2 text-center">
                  <form action="{{ route('projects.images.destroy', [$project, $image]) }}" method="POST"
                    onsubmit="return confirm('Delete this image?')">
                    @csrf
                    @method('DELETE')

                    <button class="btn btn-sm btn-danger w-100">
                      <i class="uil uil-trash"></i> Delete
                    </button>
                  </form>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      @else
        <div class="alert alert-info">
          No images uploaded yet.
        </div>
      @endif
    </div>
  </div>
@endsection
