@php
    use Illuminate\Support\Str;
@endphp

@extends('frontend.layouts.app')

@section('title', __('pages.blogs') . ' | Amid Mission')

@section('content')
    <section class="blog__section pt-130 pb-130 overhid">
        <div class="container">

            {{-- Title --}}
            <div class="title__content center wow fadeInUp" data-wow-duration="1.3s">
                <h6>@lang('pages.blogs')</h6>
                <div class="witr_bar_main">
                    <div class="witr_bar_inner witr_bar_innerc center"></div>
                    <h3>@lang('pages.blogs_description')</h3>
                </div>
            </div>

            <div class="row g-4">
                @forelse($blogs as $blog)
                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 wow fadeInUp"
                        data-wow-duration="{{ 3 + ($loop->index % 3) * 2 }}s">

                        <div class="blog__items">

                            <div class="thumb">
                                <a href="{{ route('blogs.display', $blog->slug) }}">
                                    <img src="{{ route('admin.images.preview', ['model' => 'blogs', 'id' => $blog->id]) }}"
                                        alt="{{ $blog->getTitle() }}" loading="lazy">
                                </a>
                            </div>

                            <div class="content">
                                <h5>
                                    <a href="{{ route('blogs.display', $blog->slug) }}">
                                        {{ $blog->getTitle() }}
                                    </a>
                                </h5>

                                <p>
                                    {{ Str::limit(strip_tags($blog->getContent()), 140) }}
                                </p>

                                <a href="{{ route('blogs.display', $blog->slug) }}" class="btns">
                                    @lang('pages.read_more')
                                </a>
                            </div>

                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center text-muted">
                        @lang('pages.no_blogs_available')
                    </div>
                @endforelse
            </div>

        </div>
    </section>
@endsection
