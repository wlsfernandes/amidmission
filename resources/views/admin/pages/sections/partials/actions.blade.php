<div class="d-flex justify-content-between">

    <a href="{{ route('pages.sections.index', $page) }}" class="btn btn-light">
        <i class="uil uil-arrow-left"></i>
        Back
    </a>

    <button class="btn btn-primary">
        <i class="uil uil-save"></i>
        {{ isset($section) ? 'Update Section' : 'Create Section' }}
    </button>

</div>
