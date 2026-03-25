<div class="card border mb-4">

    <div class="card-header bg-light fw-semibold">
        Section Image
    </div>
    <div class="card-body">
        <div class="col-md-12">
            <label class="form-label">Image Layout</label>

            <select name="layout" class="form-select">

                <option value="image_left"
                    {{ old('layout', $section->layout ?? 'image_left') === 'image_left' ? 'selected' : '' }}>
                    Image Left / Text Right
                </option>

                <option value="image_right"
                    {{ old('layout', $section->layout ?? 'image_left') === 'image_right' ? 'selected' : '' }}>
                    Image Right / Text Left
                </option>

                <option value="full"
                    {{ old('layout', $section->layout ?? 'image_left') === 'full' ? 'selected' : '' }}>
                    Full Width
                </option>

            </select>
            <small class="text-muted d-block mt-1">
                Choose the layout for this section. "Image Left / Text Right" will display the image on the left side
                and text on the right. "Image Right / Text Left" will display the image on the right side and text on
                the left. "Full Width" means just Text.
            </small>
        </div>

    </div>
</div>

</div>
