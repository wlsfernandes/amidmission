@extends('frontend.layouts.app')

@section('title', __('pages.recommended_books' . ' | Amid Mission'))

@section('content')

    <section class="breadcumd__banner overhid">
        <div class="container">
            <div class="breadcumd__wrapper">
                <h2 class="left__content">
                    @lang('pages.book_recommendations')
                </h2>
                <ul class="right__content">
                    <li>
                        <a href="index.html">
                            <i class="fa-solid fa-house"></i>
                            @lang('pages.home')
                        </a>
                    </li>
                    <li>
                        <i class="fa-solid fa-chevron-right"></i>
                    </li>
                    <li>
                        @lang('pages.book_recommendations')
                    </li>
                </ul>
            </div>
        </div>
    </section>
    <section class="service__section section__bg pt-130 pb-130 overhid">



        <div class="container">

            <div class="row mb-50">
                <div class="col-lg-8 mx-auto text-center">
                    <h2 class="heading-gradient-green-black">@lang('pages.recommended_books')</h2>
                </div>
            </div>

            <div class="row g-4 justify-content-center" style="margin-top: 30px;">

                @forelse ($books as $book)
                    <div class="col-xxl-3 col-xl-3 col-lg-4 col-md-6 wow fadeInUp"
                        data-wow-duration="{{ 2 + ($loop->index % 3) }}s">

                        <a href="{{ $book->external_link }}" target="_blank" rel="noopener" class="text-decoration-none">

                            <div class="service__items center book-card">

                                {{-- Cover --}}
                                <div class="thumb standard-thumb">
                                    @if ($book->image_url)
                                        <img src="{{ route('admin.images.preview', [
                                            'model' => 'book-recommendations',
                                            'id' => $book->id,
                                        ]) }}"
                                            alt="{{ $book->title }}" loading="lazy">
                                    @else
                                        <div class="book-placeholder">
                                            <i class="uil uil-book-open"></i>
                                        </div>
                                    @endif
                                </div>

                                {{-- Title --}}
                                <div class="content p-3">
                                    <h6 class="book-title">
                                        {{ $book->title }}
                                    </h6>
                                </div>

                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-12 text-center text-muted">
                        @lang('pages.no_books_available')
                    </div>
                @endforelse

            </div>
        </div>
    </section>

@endsection
