<div class="card border mb-4">

    <div class="card-header bg-light fw-semibold">
        Buttons
    </div>

    <div class="card-body">

        <div class="row g-4">

            <div class="col-md-6">
                <label class="form-label">Button Text</label>

                <input type="text" name="button_text" class="form-control"
                    value="{{ old('button_text', $section->button_text ?? '') }}">
                <small class="text-muted d-block mt-1">
                    This is the text that will appear on the button. Keep it concise and action-oriented (e.g., "Learn
                    More", "Buy Now", "Contact Us").
                </small>
            </div>

            <div class="col-md-6">
                <label class="form-label">Button Link</label>

                <input type="url" name="external_link" class="form-control"
                    value="{{ old('external_link', $section->external_link ?? '') }}">
                <small class="text-muted d-block mt-1">
                    This is the URL that the button will link to. It can be an internal path (e.g., "/about-us") or an
                    external URL (e.g., "https://example.com").
                </small>
            </div>

            <div class="col-md-6">
                <label class="form-label">Button Position</label>

                <select name="button_position" class="form-select">

                    <option value="left"
                        {{ old('button_position', $section->button_position ?? 'left') === 'left' ? 'selected' : '' }}>
                        Left
                    </option>

                    <option value="center"
                        {{ old('button_position', $section->button_position ?? '') === 'center' ? 'selected' : '' }}>
                        Center
                    </option>

                    <option value="right"
                        {{ old('button_position', $section->button_position ?? '') === 'right' ? 'selected' : '' }}>
                        Right
                    </option>

                </select>
                <small class="text-muted d-block mt-1">
                    Choose the alignment of the button within the section. Left, Center, or Right.
                </small>
            </div>

            <div class="col-md-6">
                <label class="form-label">Button Color</label>

                <select name="button_color" class="form-select">

                    <option value="primary"
                        {{ old('button_color', $section->button_color ?? 'primary') === 'primary' ? 'selected' : '' }}>
                        Primary
                    </option>

                    <option value="secondary"
                        {{ old('button_color', $section->button_color ?? '') === 'secondary' ? 'selected' : '' }}>
                        Secondary
                    </option>

                    <option value="success"
                        {{ old('button_color', $section->button_color ?? '') === 'success' ? 'selected' : '' }}>
                        Success
                    </option>

                    <option value="danger"
                        {{ old('button_color', $section->button_color ?? '') === 'danger' ? 'selected' : '' }}>
                        Danger
                    </option>

                    <option value="dark"
                        {{ old('button_color', $section->button_color ?? '') === 'dark' ? 'selected' : '' }}>
                        Dark
                    </option>

                </select>
                <small class="text-muted d-block mt-1">
                    Choose the color of the button. Options include Primary, Secondary, Success, Danger, and Dark.
                </small>
            </div>

        </div>

    </div>

</div>
