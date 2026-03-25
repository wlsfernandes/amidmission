<div class="card border mb-4">

    <div class="card-header bg-light fw-semibold">
        Section Image
    </div>
    <div class="card-body">
        @isset($section)
            @if ($section->image_url)
                <div class="gallery-card card shadow-sm text-center" style="width:140px;">

                    <div class="p-2">

                        <img src="{{ route('admin.images.preview', [
                            'model' => 'sections',
                            'id' => $section->id,
                        ]) }}"
                            class="img-thumbnail" style="max-width:120px;">

                    </div>

                    <div class="card-body p-2">

                        <button type="button" class="btn btn-sm btn-danger w-100 delete-image"
                            data-url="{{ route('pages.sections.image.destroy', [$page, $section]) }}">

                            <i class="uil uil-trash"></i> Delete

                        </button>

                    </div>

                </div>
            @endif
        @endisset
        <div class="row mb-3">

            <div class="col-md-12">
                <label class="form-label">Image Type</label>

                <select name="image_type" class="form-select">

                    <option value="hero" {{ old('image_type', $type ?? 'hero') === 'hero' ? 'selected' : '' }}>
                        Hero Banner — 1920×600
                    </option>
                    <option value="gallery" {{ old('image_type', $type ?? '') === 'gallery' ? 'selected' : '' }}>
                        Gallery — 1200×1200
                    </option>
                    <option value="video" {{ old('image_type', $type ?? '') === 'video' ? 'selected' : '' }}>
                        Video Thumbnail — 1200×800
                    </option>
                    <option value="content" {{ old('image_type', $type ?? '') === 'content' ? 'selected' : '' }}>
                        Content — 800×800
                    </option>
                    <option value="video" {{ old('image_type', $type ?? '') === 'video' ? 'selected' : '' }}>
                        Video Thumbnail — 1200×800
                    </option>
                    <option value="cta" {{ old('image_type', $type ?? '') === 'cta' ? 'selected' : '' }}>
                        Call to Action — 900×600
                    </option>
                    <option value="card" {{ old('image_type', $type ?? '') === 'card' ? 'selected' : '' }}>
                        Card — 600×400
                    </option>
                    <option value="original_fit"
                        {{ old('image_type', $type ?? '') === 'original_fit' ? 'selected' : '' }}>
                        Original Fit
                    </option>

                </select>
                <small class="text-muted d-block mt-1">
                    Select the type of image you are uploading. This helps the system generate appropriate sizes and
                    optimize display on the website. "Original Fit" will keep the image's original dimensions without
                    cropping or resizing.
                </small>
            </div>

        </div>


        {{-- Upload Image --}}
        <div class="mb-2">
            <label class="form-label">Upload New Image</label>

            <input type="file" name="image_url" class="form-control" accept="image/*">
        </div>

        <div class="mb-2">
            <label class="form-label">Image URL</label>
            <input type="url" name="link_image" class="form-control"
                value="{{ old('link_image', $section->link_image ?? '') }}" placeholder="https://example.com">
        </div>

    </div>

</div>
