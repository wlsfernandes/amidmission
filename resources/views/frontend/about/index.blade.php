@extends('frontend.layouts.app')

@section('title', __('pages.about_us') . ' | Amid Mission')

@section('content')
    <section class="breadcumd__banner overhid">
        <div class="container">
            <div class="breadcumd__wrapper">
                <h2 class="left__content">
                    @lang('pages.about_us')
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
                        @lang('pages.about_us')
                    </li>
                </ul>
            </div>
        </div>
    </section>
    @include('frontend.partials.who-we-are')


@endsection
