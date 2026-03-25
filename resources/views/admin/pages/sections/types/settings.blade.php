<div class="card border mb-4">

    <div class="card-header bg-light fw-semibold">
        Section Settings
    </div>

    <div class="card-body">

        <div class="row g-4">

            <div class="col-md-6">
                <label class="form-label d-block">Published</label>

                <input type="hidden" name="is_published" value="0">

                <div class="square-switch mt-2">
                    <input type="checkbox" id="is_published" name="is_published" switch="bool" value="1"
                        {{ old('is_published', $section->is_published ?? true) ? 'checked' : '' }}>

                    <label for="is_published" data-on-label="Yes" data-off-label="No"></label>
                    <small class="text-muted d-block mt-1">
                        Toggle to publish or unpublish this section. Unpublished sections will not be visible on the
                        website.
                    </small>
                </div>
            </div>

            <div class="col-md-6">
                <label class="form-label">Sort Order</label>

                <input type="number" name="sort_order" class="form-control"
                    value="{{ old('sort_order', $section->sort_order ?? 0) }}">
                <small class="text-muted d-block mt-1">
                    Determines the order of sections on the page. Sections with lower numbers appear first.
                </small>
            </div>
        </div>

    </div>
</div>
