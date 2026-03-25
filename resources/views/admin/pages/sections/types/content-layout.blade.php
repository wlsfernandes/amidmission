<div class="card border mb-4">

    <div class="card-header bg-light fw-semibold">
        Content Layout
    </div>

    <div class="card-body">

        <label class="form-label">Image Position</label>

        <select name="layout" class="form-select">

            <option value="image_left"
                {{ old('layout', $section->layout ?? 'image_left') === 'image_left' ? 'selected' : '' }}>
                Image Left / Text Right
            </option>

            <option value="image_right"
                {{ old('layout', $section->layout ?? 'image_left') === 'image_right' ? 'selected' : '' }}>
                Image Right / Text Left
            </option>

            <option value="full" {{ old('layout', $section->layout ?? 'image_left') === 'full' ? 'selected' : '' }}>
                Full Width
            </option>

        </select>

    </div>
</div>
