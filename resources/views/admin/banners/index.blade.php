@extends('admin.layouts.master')

@section('title', 'Banners')
@section('css')
    <link href="{{ asset('/assets/admin/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="card border border-primary">
        <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">

            {{-- LEFT: Back + Page --}}
            <div class="d-flex align-items-center gap-2">

                <a href="{{ route('pages.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="uil uil-arrow-left"></i> Pages
                </a>

                @if (isset($page))
                    <span class="text-muted small">
                        /
                        <a href="{{ route('pages.edit', $page->id) }}" class="text-decoration-none fw-semibold">
                            {{ $page->slug }}
                        </a>
                    </span>
                @endif

            </div>

            {{-- CENTER: Title --}}
            <h5 class="mb-0 text-center flex-grow-1">
                <i class="uil uil-megaphone"></i> Banners
            </h5>

            {{-- RIGHT: Actions --}}
            <div class="d-flex align-items-center gap-2">

                @if (isset($page))
                    <a href="{{ $page->url }}" target="_blank" class="btn btn-outline-primary btn-sm">

                        <i class="uil uil-external-link-alt"></i> View
                    </a>
                @endif

                <a href="{{ isset($page) ? route('banners.create', ['page_id' => $page->id]) : route('banners.create') }}"
                    class="btn btn-success btn-sm">

                    <i class="uil uil-plus"></i> Add
                </a>

            </div>

        </div>

        <div class="card-body">
            <x-alert />

            <table class="table table-bordered datatable-buttons">
                <thead>
                    <tr>
                        <th></th>
                        <th>Title (EN)</th>
                        <th>Published</th>
                        <th>Publication Window</th>
                        <th>Order</th>
                        <th width="140">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($banners as $banner)
                        <tr>
                            {{-- Image --}}
                            <td class="d-flex justify-content-center align-items-center">
                                <div class="d-flex flex-column align-items-center justify-content-center">
                                    @if ($banner->image_url)
                                        <a href="{{ route('admin.images.preview', ['model' => 'banners', 'id' => $banner->id]) }}"
                                            target="_blank" title="View image">
                                            <img src="{{ route('admin.images.preview', ['model' => 'banners', 'id' => $banner->id]) }}"
                                                alt="Banner image" class="rounded-circle mb-1"
                                                style="width:80px;height:80px;object-fit:cover;">
                                        </a>
                                    @endif
                                </div>
                            </td>

                            <td>
                                {{ strip_tags($banner->title_en) }}
                            </td>


                            {{-- Publish toggle (generic controller) --}}
                            <td class="text-center">
                                <form method="POST"
                                    action="{{ route('admin.publish.toggle', [
                                        'model' => Str::snake(class_basename($banner)),
                                        'id' => $banner->id,
                                    ]) }}">
                                    @csrf
                                    @method('PATCH')

                                    <button type="submit"
                                        class="badge border-0 {{ $banner->is_published ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $banner->is_published ? __('Yes') : __('No') }}
                                    </button>
                                </form>
                            </td>

                            {{-- Publication window --}}
                            <td>
                                <small>
                                    From:
                                    {{ $banner->publish_start_at?->format('M d, Y') ?? '-' }}<br>
                                    To:
                                    {{ $banner->publish_end_at?->format('M d, Y') ?? '-' }}
                                </small>
                            </td>

                            {{-- Sort order --}}
                            <td class="text-center">
                                {{ $banner->sort_order }}
                            </td>

                            {{-- Actions --}}
                            <td>
                                <a href="{{ route('banners.edit', $banner) }}" class="btn btn-sm btn-warning">
                                    <i class="uil-pen"></i>
                                </a>

                                <form action="{{ route('banners.destroy', $banner) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Delete this banner?')">
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
