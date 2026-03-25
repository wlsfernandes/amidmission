@extends('frontend.layouts.app')

<title>{{ $page->seo_title }} | Amid Mission</title>

<meta name="description" content="{{ $page->seo_description }}">
<meta name="keywords" content="{{ $page->seo_keywords }}">

{{-- Open Graph --}}
<meta property="og:title" content="{{ $page->seo_title }}">
<meta property="og:description" content="{{ $page->seo_description }}">
<meta property="og:image" content="{{ $page->og_image_url }}">
<meta property="og:type" content="website">

{{-- Robots --}}
@if ($page->no_index)
    <meta name="robots" content="noindex, nofollow">
@endif

@section('content')
    @if ($page->banners->count())
        @include('frontend.partials.banner', ['banners' => $page->banners])
    @endif
    @foreach ($page->sections as $section)
        @if ($section->type === 'promo')
            @include('frontend.pages.sections.promo', ['section' => $section])
        @elseif ($section->type === 'cta')
            @include('frontend.pages.sections.cta', ['section' => $section])
        @elseif ($section->type === 'content')
            @include('frontend.pages.sections.content', ['section' => $section])
        @elseif ($section->type === 'feature')
            @include('frontend.pages.sections.feature', ['section' => $section])
        @elseif ($section->type === 'gallery')
            @include('frontend.pages.sections.gallery', ['section' => $section])
        @elseif ($section->type === 'video')
            @include('frontend.pages.sections.video', ['section' => $section])
        @endif
    @endforeach
@endsection
