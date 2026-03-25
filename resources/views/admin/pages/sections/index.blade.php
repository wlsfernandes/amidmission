@extends('admin.layouts.master')

@section('title', 'Page Sections')

@section('content')
    <div class="card border border-primary">

        <div class="card-header d-flex justify-content-between align-items-center">

            <div>
                <h5 class="mb-0">
                    <i class="uil uil-layers"></i>
                    Sections for Page
                </h5>

                <small class="text-muted">
                    {{ $page->title }} <br>

                    <a href="{{ route('pages.index') }}" class="btn btn-secondary btn-sm mt-1">
                        <i class="uil uil-arrow-left"></i> Back to Pages
                    </a>
                </small>
            </div>

            <div class="d-flex gap-2">


                <a href="{{ route('pages.sections.create', ['page' => $page->id, 'type' => 'content']) }}"
                    style="display:flex; flex-direction:column; align-items:center; text-decoration:none;">

                    <img src="{{ asset('assets/admin/images/icons/content.png') }}" alt="Content Icon" width="96">

                    <span class="badge bg-info text-uppercase px-3 py-2">+ Content</span>

                </a>

                <a href="{{ route('pages.sections.create', ['page' => $page->id, 'type' => 'promo']) }}"
                    style="display:flex; flex-direction:column; align-items:center; text-decoration:none;">

                    <img src="{{ asset('assets/admin/images/icons/promo.png') }}" alt="Promo Icon" width="96">

                    <span class="badge bg-primary text-uppercase px-3 py-2">+ Promo</span>

                </a>

                <a href="{{ route('pages.sections.create', ['page' => $page->id, 'type' => 'cta']) }}"
                    style="display:flex; flex-direction:column; align-items:center; text-decoration:none;">

                    <img src="{{ asset('assets/admin/images/icons/cta.png') }}" alt="CTA Icon" width="96">

                    <span class="badge bg-success text-uppercase px-3 py-2">+ CTA</span>

                </a>
                <a href="{{ route('pages.sections.create', ['page' => $page->id, 'type' => 'feature']) }}"
                    style="display:flex; flex-direction:column; align-items:center; text-decoration:none;">

                    <img src="{{ asset('assets/admin/images/icons/cards.png') }}" alt="Feature Icon" width="96">

                    <span class="badge bg-warning text-uppercase px-3 py-2">+ Feature</span>
                </a>
                <a href="{{ route('pages.sections.create', ['page' => $page->id, 'type' => 'gallery']) }}"
                    style="display:flex; flex-direction:column; align-items:center; text-decoration:none;">

                    <img src="{{ asset('assets/admin/images/icons/gallery.png') }}" alt="Gallery Icon" width="96">

                    <span class="badge bg-danger text-uppercase px-3 py-2">+ Gallery</span>

                </a>
                <a href="{{ route('pages.sections.create', ['page' => $page->id, 'type' => 'video']) }}"
                    style="display:flex; flex-direction:column; align-items:center; text-decoration:none;">

                    <img src="{{ asset('assets/admin/images/icons/video.png') }}" alt="Video Icon" width="96">

                    <span class="badge bg-info text-uppercase px-3 py-2">+ Video</span>

                </a>


            </div>

        </div>
        <div class="card-body">
            <div class="alert alert-info mb-4">
                <h6 class="mb-2">
                    <i class="uil uil-info-circle"></i> Sections Builder Guide
                </h6>

                <p class="mb-2">
                    Sections are the building blocks of your page. Each section represents a visual block on the website.
                </p>

                <ul class="mb-2">
                    <li><strong>Each section = one block of content</strong></li>
                    <li><strong>Order controls vertical position (top to bottom)</strong></li>
                    <li><strong>You can mix different section types</strong></li>
                </ul>

                <p class="mb-0">
                    <strong>Tip:</strong> Build your page from top to bottom: Intro → Content → CTA → Media.
                </p>
            </div>
            <x-alert />

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">Actions</th>
                        <th class="text-center">Section</th>
                        <th class="text-center">Order</th>
                        <th class="text-center">Title (EN)</th>
                        <th class="text-center">Published</th>
                        <th class="text-center">+ Cards</th>

                    </tr>
                </thead>
                <tbody>
                    @forelse ($sections as $section)
                        <tr>
                            <td class="text-center">

                                <a href="{{ route('pages.sections.edit', [$page, $section]) }}" class="text-warning">
                                    <i class="uil uil-pen font-size-18"></i>
                                </a>

                                <a href="#"
                                    class="text-danger"onclick="event.preventDefault(); if(confirm('Delete this section?')) { document.getElementById('delete-form-{{ $section->id }}').submit();  }">
                                    <i class="uil-trash font-size-18"></i>
                                </a>

                                <form id="delete-form-{{ $section->id }}"
                                    action="{{ route('pages.sections.destroy', [$page, $section]) }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                @if ($page->url)
                                    <a href="{{ $page->url }}" target="_blank" class="text-primary">
                                        <i class="uil uil-external-link-alt font-size-18"></i>
                                    </a>
                                @endif
                            </td>
                            <td class="text-center">

                                @php
                                    $badgeColors = [
                                        'hero' => 'bg-primary',
                                        'content' => 'bg-info',
                                        'cta' => 'bg-success',
                                        'gallery' => 'bg-warning',
                                        'video' => 'bg-danger',
                                    ];

                                    $badge = $badgeColors[$section->type] ?? 'bg-secondary';
                                @endphp

                                <span class="badge {{ $badge }} text-uppercase px-3 py-2">
                                    {{ ucfirst($section->type) }}
                                </span>

                            </td>

                            <td class="text-center">
                                {{ $section->sort_order ?? '—' }}
                            </td>

                            <td>
                                {{ strip_tags($section->title_en ?? '') }}
                            </td>

                            <td class="text-center">
                                <span class="badge {{ $section->is_published ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $section->is_published ? 'Yes' : 'No' }}
                                </span>
                            </td>

                            {{-- Cards column --}}
                            <td class="text-center">
                                @if ($section->type === 'content')
                                    <a href="{{ route('pages.sections.cards.index', [$page, $section]) }}"
                                        class="btn btn-sm btn-primary"> + Cards ({{ $section->cards()->count() }})
                                    </a>
                                @endif
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="6" class="text-center text-muted">
                                No sections created yet.
                            </td>
                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

    </div>
@endsection
