@extends('admin.layouts.master')

@section('title', isset($sessionCard) ? 'Edit Card' : 'Add Card')
@section('content')

    <div class="card border border-primary">

        <div class="card-header">
            <h5 class="mb-0">
                <i class="uil uil-apps"></i>
                {{ isset($sessionCard) ? 'Edit Card' : 'Create Card' }}
            </h5>


        </div>

        <div class="card-body">

            <x-alert />

            <form method="POST"
                action="{{ isset($sessionCard) ? route('pages.sections.cards.update', [$page, $section, $sessionCard]) : route('pages.sections.cards.store', [$page, $section]) }}"
                enctype="multipart/form-data">
                @csrf
                @if (isset($sessionCard))
                    @method('PUT')
                @endif
                {{-- ORDER --}}
                <div class="card border mb-4">

                    <div class="card-header bg-light fw-semibold">
                        Card Settings
                    </div>

                    <div class="card-body">

                        <div class="row g-4">

                            <div class="col-md-3">

                                <label class="form-label">Sort Order</label>

                                <input type="number" name="sort_order" class="form-control"
                                    value="{{ old('sort_order', $sessionCard->sort_order ?? 0) }}">

                                <small class="text-muted">
                                    Lower numbers appear first.
                                </small>

                            </div>

                            <div class="col-md-9">

                                <label class="form-label">Link (optional)</label>

                                <input type="url" name="link" class="form-control"
                                    value="{{ old('link', $sessionCard->link ?? '') }}" placeholder="https://example.com">

                                <small class="text-muted">
                                    If provided, the card can link to another page.
                                </small>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- IMAGE --}}
                <div class="card border mb-4">

                    <div class="card-header bg-light fw-semibold">
                        Card Image
                    </div>

                    <div class="card-body">

                        @isset($sessionCard)
                            @if ($sessionCard->image_url)
                                <div class="mb-3">
                                    <img src="{{ route('admin.images.preview', [
                                        'model' => 'section_cards',
                                        'id' => $sessionCard->id,
                                    ]) }}"
                                        class="img-thumbnail" style="max-width:200px">
                                </div>
                            @endif
                        @endisset

                        <label class="form-label">Select Image</label>

                        <input type="file" name="image_url" class="form-control" accept="image/*">

                        <small class="text-muted">
                            JPG, PNG or WebP recommended. Attention use images size <code>280x220</code> and centralize for
                            best results.
                        </small>

                    </div>

                </div>


                {{-- ENGLISH --}}
                <div class="card border mb-4">

                    <div class="card-header bg-light fw-semibold">
                        English Content
                    </div>

                    <div class="card-body">

                        <div class="mb-3">

                            <label class="form-label">Title</label>

                            <textarea name="title_en" class="form-control ckeditor-title" rows="1">{{ old('title_en', $sessionCard->title_en ?? '') }}</textarea>


                        </div>


                        <div>

                            <label class="form-label">Content</label>

                            <textarea name="content_en" class="form-control ckeditor" rows="5">{{ old('content_en', $sessionCard->content_en ?? '') }}</textarea>

                        </div>

                    </div>

                </div>


                {{-- SPANISH --}}
                <div class="card border mb-4">

                    <div class="card-header bg-light fw-semibold">
                        Spanish Content
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <textarea name="title_es" class="form-control ckeditor-title" rows="5">{{ old('title_es', $sessionCard->title_es ?? '') }}</textarea>
                        </div>
                        <div>
                            <label class="form-label">Content</label>
                            <textarea name="content_es" class="form-control ckeditor" rows="5">{{ old('content_es', $sessionCard->content_es ?? '') }}</textarea>
                        </div>
                    </div>

                </div>


                {{-- ACTIONS --}}
                <div class="d-flex justify-content-between">

                    <a href="{{ route('pages.sections.cards.index', [$page, $section]) }}" class="btn btn-light">

                        <i class="uil uil-arrow-left"></i>
                        Back

                    </a>

                    <button class="btn btn-primary">

                        <i class="uil uil-save"></i>

                        {{ isset($sessionCard) ? 'Update Card' : 'Create Card' }}

                    </button>

                </div>


            </form>

        </div>

    </div>

@endsection
