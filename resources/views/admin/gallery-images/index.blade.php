@extends('admin.layouts.master')

@section('title', 'Gallery')

@section('content')
    <div class="card border border-primary">
        <div class="card-header">
            <h5><i class="uil uil-images"></i> Gallery</h5>
        </div>

        <div class="card-body">

            <form method="POST" action="{{ route('gallery-images.store') }}" enctype="multipart/form-data" class="mb-4">
                @csrf

                <input type="file" name="images[]" multiple accept="image/*" required>

                <button class="btn btn-primary btn-sm ms-2">
                    <i class="uil uil-upload"></i> Upload Images
                </button>
            </form>


            <div class="row g-3">
                @foreach ($images as $image)
                    <div class="col-md-3 col-sm-4 col-6">
                        <div class="text-center">

                            <img src="{{ route('admin.images.preview', ['model' => 'gallery-images', 'id' => $image->id]) }}"
                                class="img-fluid rounded mb-2" style="width:120px;height:80px;object-fit:cover;">

                            <form method="POST" action="{{ route('gallery-images.destroy', $image) }}"
                                onsubmit="return confirm('Delete image?')">
                                @csrf
                                @method('DELETE')

                                <button class="btn btn-danger btn-sm">
                                    <i class="uil uil-trash"></i> Delete
                                </button>
                            </form>

                        </div>

                    </div>
                @endforeach
            </div>

        </div>
    </div>
@endsection
@push('scripts')
    <script>
        document.getElementById('gallery-images').addEventListener('change', function() {
            const maxSize = 5 * 1024 * 1024; // 5MB
            const files = this.files;

            for (const file of files) {
                if (!file.type.startsWith('image/')) {
                    alert(`"${file.name}" is not a valid image.`);
                    this.value = '';
                    return;
                }

                if (file.size > maxSize) {
                    alert(`"${file.name}" exceeds the 5MB limit.`);
                    this.value = '';
                    return;
                }
            }
        });
    </script>
@endpush
