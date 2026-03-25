<div class="card border mb-4">

    <div class="card-header bg-light fw-semibold">
        Section Content
    </div>

    <div class="card-body">

        <div class="row g-4">

            <div class="col-md-4">
                <label class="form-label">Title (EN)</label>
                <textarea name="title_en" class="form-control ckeditor-title" rows="3">{{ old('title_en', $section->title_en ?? '') }}</textarea>
                <small class="text-muted d-block mt-1">
                    This is a required title for the section. It can be used to provide a heading or context for the
                    content below.
                    If left blank, the section will simply display the content without a title.
                </small>
            </div>

            <div class="col-md-4">
                <label class="form-label">Title (ES)</label>
                <textarea name="title_es" class="form-control ckeditor-title" rows="3">{{ old('title_es', $section->title_es ?? '') }}</textarea>
                <small class="text-muted d-block mt-1">
                    This is an optional title for the section in Spanish. It can be used to provide a heading or context
                    for the content below.
                    If left blank, the section will simply display the content without a title.
                </small>
            </div>
            <div class="col-md-4">
                <label class="form-label">Title (PT)</label>
                <textarea name="title_pt" class="form-control ckeditor-title" rows="3">{{ old('title_pt', $section->title_pt ?? '') }}</textarea>
                <small class="text-muted d-block mt-1">
                    This is an optional title for the section in Portuguese. It can be used to provide a heading or
                    context
                    for the content below.
                    If left blank, the section will simply display the content without a title.
                </small>
            </div>

        </div>

        <div class="mt-4">
            <label class="form-label">Content (EN)</label>
            <textarea name="content_en" class="form-control ckeditor" rows="6">{{ old('content_en', $section->content_en ?? '') }}</textarea>
            <small class="text-muted d-block mt-1">
                This is the main content area for the section. You can add text, images, links, and other media using
                the rich text editor.
                This content will be displayed on the website as part of this section.
            </small>
        </div>

        <div class="mt-3">
            <label class="form-label">Content (ES)</label>
            <textarea name="content_es" class="form-control ckeditor" rows="6">{{ old('content_es', $section->content_es ?? '') }}</textarea>
            <small class="text-muted d-block mt-1">
                This is the main content area for the section in Spanish. You can add text, images, links, and other
                media using the rich text editor.
                This content will be displayed on the website as part of this section when the Spanish version of the
                page is viewed.
            </small>
        </div>
        <div class="mt-3">
            <label class="form-label">Content (PT)</label>
            <textarea name="content_pt" class="form-control ckeditor" rows="6">{{ old('content_pt', $section->content_pt ?? '') }}</textarea>
            <small class="text-muted d-block mt-1">
                This is the main content area for the section in Portuguese. You can add text, images, links, and other
                media using the rich text editor.
                This content will be displayed on the website as part of this section when the Spanish version of the
                page is viewed.
            </small>
        </div>

    </div>
</div>
