@extends('admin.layouts.master')

@section('title', isset($section) ? 'Edit Page Section' : 'Add Page Section')

@section('content')

    @php
        $type = old('type', $section->type ?? request('type', 'content'));
    @endphp

    <div class="card border border-primary">

        <div class="card-header">
            @switch($type)
                @case('content')
                    <img src="{{ asset('assets/admin/images/icons/content.png') }}" alt="Content Icon" width="96">
                @break

                @case('cta')
                    <img src="{{ asset('assets/admin/images/icons/cta.png') }}" alt="CTA Icon" width="96">
                @break

                @case('promo')
                    <img src="{{ asset('assets/admin/images/icons/promo.png') }}" alt="Promo Icon" width="96">
                @break

                @case('gallery')
                    <img src="{{ asset('assets/admin/images/icons/gallery.png') }}" alt="Gallery Icon" width="96">
                @break

                @case('hero')
                    <img src="{{ asset('assets/admin/images/icons/header.png') }}" alt="Banner Icon" width="96">
                @break

                @case('video')
                    <img src="{{ asset('assets/admin/images/icons/video.png') }}" alt="Video Icon" width="96">
                @break

                @default
            @endswitch
            <h5 class="mb-0">
                <i class="uil uil-layers"></i>
                {{ isset($section) ? 'Edit Section ' . ucfirst($type) : 'Create Section' . ' ' . ucfirst($type) }}
            </h5>
            <small class="text-muted">
                Page: {{ $page->title }}
            </small>
        </div>

        <div class="card-body">

            <x-alert />

            <form method="POST"
                action="{{ isset($section) ? route('pages.sections.update', [$page, $section]) : route('pages.sections.store', $page) }}"
                enctype="multipart/form-data">

                @csrf
                @isset($section)
                    @method('PUT')
                @endisset
                <input type="hidden" name="type" value="{{ $type }}">
                @include('admin.pages.sections.types.settings', ['type' => $type])

                @if ($type === 'promo')
                    @include('admin.pages.sections.partials.button')
                    @include('admin.pages.sections.types.content')
                    @include('admin.pages.sections.partials.image')
                @endif

                @if ($type === 'content')
                    @include('admin.pages.sections.types.content')
                    @include('admin.pages.sections.partials.image')
                    @include('admin.pages.sections.partials.image-layout')
                @endif

                @if ($type === 'cta')
                    @include('admin.pages.sections.partials.button')
                    @include('admin.pages.sections.types.content')
                    @include('admin.pages.sections.partials.image')
                    @include('admin.pages.sections.partials.image-layout')
                @endif
                @if ($type === 'feature')
                    @include('admin.pages.sections.types.feature')
                @endif
                @if ($type === 'gallery')
                    @include('admin.pages.sections.types.content')
                    @include('admin.pages.sections.partials.multiple-images')
                @endif

                @if ($type === 'video')
                    @include('admin.pages.sections.partials.button')
                    @include('admin.pages.sections.types.content')
                    @include('admin.pages.sections.partials.image')
                    @include('admin.pages.sections.partials.image-layout')
                @endif





                @include('admin.pages.sections.partials.actions')

            </form>

        </div>
    </div>

@endsection
@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            document.querySelectorAll('.delete-image').forEach(function(button) {

                button.addEventListener('click', function(e) {

                    e.preventDefault();

                    if (!confirm('Delete this image?')) {
                        return;
                    }

                    const url = this.getAttribute('data-url');

                    fetch(url, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                _method: 'DELETE'
                            })
                        })
                        .then(response => response.json())
                        .then(data => {

                            if (data.success) {
                                this.closest('.gallery-card').remove();
                            } else {
                                alert('Failed to delete image');
                            }

                        })
                        .catch(function(error) {
                            console.error(error);
                            alert('Server error');
                        });

                });

            });

        });
    </script>
@endsection
