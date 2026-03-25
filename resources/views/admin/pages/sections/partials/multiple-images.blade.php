<div class="card border mb-4">

    <div class="card-header bg-light fw-semibold">
        Section Image
    </div>
    <div class="card-body">
        @isset($section)
            @if ($section && $section->images->count())
                <div class="mb-4">
                    <label class="form-label d-block">Gallery Images</label>
                    <div class="d-flex flex-wrap gap-3">
                        @foreach ($section->images as $image)
                            <div class="gallery-card card shadow-sm text-center" style="width:140px;">

                                <div class="p-2">

                                    <img src="{{ route('admin.images.preview', [
                                        'model' => 'section_images',
                                        'id' => $image->id,
                                    ]) }}"
                                        class="img-thumbnail" style="max-width:120px;">

                                    @if ($image->getTitle())
                                        <div class="small text-muted mt-1">
                                            {{ $image->getTitle() }}
                                        </div>
                                    @endif

                                </div>

                                <div class="card-body p-2">

                                    <button type="button" class="btn btn-sm btn-danger w-100 delete-image"
                                        data-url="{{ route('pages.sections.images.destroy', [$page, $section, $image]) }}">

                                        <i class="uil uil-trash"></i> Delete

                                    </button>

                                </div>

                            </div>
                        @endforeach

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
                    <option value="content" {{ old('image_type', $type ?? '') === 'content' ? 'selected' : '' }}>
                        Content — 800×800
                    </option>

                    <option value="cta" {{ old('image_type', $type ?? '') === 'cta' ? 'selected' : '' }}>
                        Call to Action — 900×600
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
            <label class="form-label">Upload Images</label>

            <input type="file" name="gallery_images[]" class="form-control" accept="image/*" multiple>
        </div>

    </div>

</div>
