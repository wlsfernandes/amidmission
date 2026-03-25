@extends('admin.layouts.master')

@section('title', 'Pages')
@section('css')
    <link href="{{ asset('/assets/admin/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="card border border-primary">
        <div class="card-header d-flex justify-content-between">
            <h5>
                <i class="fas fa-file-alt"></i> Pages
            </h5>

            <a href="{{ route('pages.create') }}" class="btn btn-success">
                <i class="uil-plus"></i> Add Page
            </a>
        </div>

        <div class="card-body">
            <div class="alert alert-info mb-4">
                <h6 class="mb-2">
                    <i class="uil uil-info-circle"></i> Pages Manager Guide
                </h6>

                <p class="mb-2">
                    Pages are the main building blocks of your website. Each page represents a full screen or route
                    (for example: Home, About, Programs, Contact).
                </p>

                <ul class="mb-2">
                    <li><strong>Slug:</strong> The URL of the page (e.g., <code>/about-us</code>)</li>
                    <li><strong>Banners:</strong> Top visual section (hero area)</li>
                    <li><strong>Sections:</strong> The content blocks inside the page (text, CTA, gallery, etc.)</li>
                    <li><strong>Published:</strong> Controls if the page is visible on the website</li>
                </ul>

                <p class="mb-0">
                    <strong>Tip:</strong> Build pages using sections. Keep a clear structure: Banner → Content → CTA →
                    Gallery.
                </p>
            </div>
            <x-alert />

            <table class="table table-bordered datatable-buttons">
                <thead>
                    <tr>
                        <th>Title (EN)</th>
                        <th>Slug</th>
                        <th>Banners</th>
                        <th>Sections</th>
                        <th>Published</th>
                        <th width="140">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($pages as $page)
                        <tr>
                            {{-- Title --}}
                            <td>
                                <strong>{{ $page->title_en }}</strong><br>
                                <small class="text-muted">
                                    {{ $page->title_es ?? '-' }}
                                </small>
                            </td>

                            {{-- Slug --}}
                            <td>
                                <a href="{{ $page->url }}" target="_blank" class="text-decoration-none">
                                    <code>/{{ $page->slug }}</code>
                                </a>
                            </td>
                            <td class="text-center align-middle">
                                <a href="{{ route('banners.index', ['page_id' => $page->id]) }}"
                                    class="btn btn-sm btn-outline-info" title="Manage banners">
                                    <i class="uil uil-image"></i>
                                </a>

                                <div class="small text-muted mt-1">
                                    {{ $page->banners_count }}
                                    banner{{ $page->banners_count === 1 ? '' : 's' }}
                                </div>
                            </td>
                            <td class="text-center align-middle">
                                <a href="{{ route('pages.sections.index', $page) }}" class="btn btn-sm btn-outline-primary"
                                    title="Manage sections">
                                    <i class="uil uil-layers"></i>
                                </a>

                                <div class="small text-muted mt-1">
                                    {{ $page->sections->count() }}
                                    section{{ $page->sections->count() === 1 ? '' : 's' }}
                                </div>
                            </td>


                            {{-- Published --}}
                            <td class="text-center">
                                <form method="POST"
                                    action="{{ route('admin.publish.toggle', ['model' => 'pages', 'id' => $page->id]) }}">
                                    @csrf
                                    @method('PATCH')

                                    <button type="submit"
                                        class="badge border-0 {{ $page->is_published ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $page->is_published ? __('Yes') : __('No') }}
                                    </button>
                                </form>
                            </td>

                            {{-- Actions --}}
                            <td>
                                <a href="{{ route('pages.edit', $page) }}" class="btn btn-sm btn-warning">
                                    <i class="uil-pen"></i>
                                </a>

                                <form action="{{ route('pages.destroy', $page) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Delete this page?')">
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-sm btn-danger">
                                        <i class="uil-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('/assets/admin/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('/assets/admin/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('/assets/admin/libs/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('/assets/admin/js/pages/datatables.init.js') }}"></script>
@endsection
