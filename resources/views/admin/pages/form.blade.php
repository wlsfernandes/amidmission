@extends('admin.layouts.master')

@section('title', isset($page) ? 'Edit Page' : 'Create Page')

@section('content')
    <div class="card border border-primary">
        <div class="card-header">
            <h5>
                <i class="fas fa-file-alt"></i>
                {{ isset($page) ? 'Edit Page' : 'Create Page' }}
            </h5>
        </div>

        <div class="card-body">
            <x-alert />

            <form method="POST" action="{{ isset($page) ? route('pages.update', $page) : route('pages.store') }}">
                @csrf
                @isset($page)
                    @method('PUT')
                @endisset

                {{-- =======================
                Publish Controls
                ======================== --}}
                <div class="form-check form-switch form-switch-lg mb-4">
                    <input type="checkbox" name="is_published" value="1" class="form-check-input" id="is_published"
                        {{ old('is_published', $page->is_published ?? false) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_published">
                        Publish this page on the website
                    </label>
                </div>

                <hr>

                {{-- =======================
                Titles
                ======================== --}}
                <div class="mb-3">
                    <input type="text" name="title_en" class="form-control @error('title_en') is-invalid @enderror"
                        placeholder="Page title in English" value="{{ old('title_en', $page->title_en ?? '') }}" required>

                    <small class="text-muted">
                        Required. Used to generate the public URL.
                    </small>

                    @error('title_en')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <input type="text" name="title_es" class="form-control" placeholder="Título de la página en español"
                        value="{{ old('title_es', $page->title_es ?? '') }}">
                    <small class="text-muted">
                        Optional Spanish version.
                    </small>
                </div>

                <div class="mb-3">
                    <input type="text" name="title_pt" class="form-control" placeholder="Título da página em português"
                        value="{{ old('title_pt', $page->title_pt ?? '') }}">
                    <small class="text-muted">
                        Optional Portuguese version.
                    </small>
                </div>

                @isset($page)
                    <div class="mb-3">
                        <input type="text" class="form-control" value="{{ $page->slug }}" readonly>
                        <small class="text-muted">
                            Public page URL slug (auto-generated).
                        </small>
                    </div>
                @endisset

                <hr>

                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="mb-0">SEO & Social Sharing</h5>
                        <small class="text-muted">
                            These settings help your page appear correctly on Google, ChatGPT, and social media.
                        </small>
                    </div>

                    <div class="card-body">

                        {{-- SEO TITLE --}}
                        <div class="mb-3">
                            <label class="form-label">SEO Title (English)</label>
                            <input type="text" name="seo_title_en"
                                class="form-control @error('seo_title_en') is-invalid @enderror"
                                value="{{ old('seo_title_en', $page->seo_title_en ?? '') }}"
                                placeholder="Example: Leadership Training for Christian Ministers">

                            <p class="text-muted mb-1">
                                Optional. This is the title shown on Google search results.
                            </p>
                            <p class="text-muted">
                                Keep it under 60 characters. If empty, the page title will be used automatically.
                            </p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">SEO Title (Spanish)</label>
                            <input type="text" name="seo_title_es" class="form-control"
                                value="{{ old('seo_title_es', $page->seo_title_es ?? '') }}"
                                placeholder="Ejemplo: Formación de Liderazgo Cristiano">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">SEO Title (Portuguese)</label>
                            <input type="text" name="seo_title_pt" class="form-control"
                                value="{{ old('seo_title_pt', $page->seo_title_pt ?? '') }}"
                                placeholder="Exemplo: Formação de Liderança Cristã">
                        </div>


                        {{-- SEO DESCRIPTION --}}
                        <div class="mb-3">
                            <label class="form-label">SEO Description (English)</label>
                            <textarea name="seo_description_en" rows="3"
                                class="form-control @error('seo_description_en') is-invalid @enderror" placeholder="Describe this page clearly...">{{ old('seo_description_en', $page->seo_description_en ?? '') }}</textarea>

                            <p class="text-muted mb-1">
                                This is the description shown on Google.
                            </p>
                            <p class="text-muted">
                                Keep it between 140–160 characters. Write naturally, like a sentence someone would search
                                for.
                            </p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">SEO Description (Spanish)</label>
                            <textarea name="seo_description_es" rows="3" class="form-control" placeholder="Describe esta página...">{{ old('seo_description_es', $page->seo_description_es ?? '') }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">SEO Description (Portuguese)</label>
                            <textarea name="seo_description_pt" rows="3" class="form-control"
                                placeholder="Descreva esta página claramente...">{{ old('seo_description_pt', $page->seo_description_pt ?? '') }}</textarea>
                        </div>

                        {{-- KEYWORDS --}}
                        <div class="mb-3">
                            <label class="form-label">SEO Keywords</label>
                            <input type="text" name="seo_keywords" class="form-control"
                                value="{{ old('seo_keywords', $page->seo_keywords ?? '') }}"
                                placeholder="leadership, ministry training, christian education">

                            <p class="text-muted mb-1">
                                Optional. Separate keywords with commas.
                            </p>
                            <p class="text-muted">
                                Focus on real search terms people would use. Do not overstuff.
                            </p>
                        </div>

                        <hr>

                        {{-- OPEN GRAPH --}}
                        <h6 class="mb-3">Social Sharing (Open Graph)</h6>

                        <div class="mb-3">
                            <label class="form-label">Social Title (English)</label>
                            <input type="text" name="og_title_en" class="form-control"
                                value="{{ old('og_title_en', $page->og_title_en ?? '') }}"
                                placeholder="Title when shared on Facebook or WhatsApp">

                            <p class="text-muted">
                                If empty, SEO title will be used automatically.
                            </p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Social Description (English)</label>
                            <textarea name="og_description_en" rows="2" class="form-control"
                                placeholder="Short description for social media">{{ old('og_description_en', $page->og_description_en ?? '') }}</textarea>

                            <p class="text-muted">
                                Keep it short and engaging. Think: “Why should someone click this?”
                            </p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Social Description (Spanish)</label>
                            <textarea name="og_description_es" rows="2" class="form-control"
                                placeholder="Descripción corta para redes sociales">{{ old('og_description_es', $page->og_description_es ?? '') }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Social Description (Portuguese)</label>
                            <textarea name="og_description_pt" rows="2" class="form-control"
                                placeholder="Descrição curta para redes sociais">{{ old('og_description_pt', $page->og_description_pt ?? '') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Social Image</label>
                            <input type="text" name="og_image_url" class="form-control"
                                value="{{ old('og_image_url', $page->og_image_url ?? '') }}"
                                placeholder="https://yourdomain.com/image.jpg">

                            <p class="text-muted mb-1">
                                Recommended size: 1200x630 pixels.
                            </p>
                            <p class="text-muted">
                                This image appears when the page is shared on WhatsApp, Facebook, and LinkedIn.
                            </p>
                        </div>

                        <hr>

                        {{-- NO INDEX --}}
                        <div class="form-check form-switch form-switch-lg">
                            <input type="checkbox" name="no_index" value="1" class="form-check-input"
                                id="no_index" {{ old('no_index', $page->no_index ?? false) ? 'checked' : '' }}>

                            <label class="form-check-label" for="no_index">
                                Hide this page from search engines
                            </label>

                            <p class="text-muted mb-0">
                                Enable this for private, draft, or internal pages. Google will not index this page.
                            </p>
                        </div>

                    </div>
                </div>

                <hr>
                <div class="d-flex justify-content-between">
                    <a href="{{ route('pages.index') }}" class="btn btn-secondary">
                        <i class="uil-arrow-left"></i> Back
                    </a>

                    <button type="submit" class="btn btn-primary">
                        <i class="uil-save"></i>
                        {{ isset($page) ? 'Update Page' : 'Create Page' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
