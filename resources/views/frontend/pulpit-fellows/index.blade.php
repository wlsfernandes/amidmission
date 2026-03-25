@extends('frontend.layouts.app')

@section('title', __('pages.about_us'))

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
    @if (!empty($aboutSections['header']))
        <section class="section__bg legacy-section p2p-legacy">
            <div class="title__content center wow fadeInUp" data-wow-duration="1.3s">

                <h2 class="heading-gradient-green-black p2p-title">
                    {{ $aboutSections['header']->{'title_' . app()->getLocale()} ?? '' }}
                </h2>

                <h5 class="p2p-subtitle">
                    {{ $aboutSections['header']->{'subtitle_' . app()->getLocale()} ?? '' }}
                </h5>

                <div class="legacy-content p2p-content">
                    <div class="cms-html" id="cms-html">
                        {!! $aboutSections['header']->{'content_' . app()->getLocale()} ?? '' !!}
                    </div>
                </div>

            </div>
        </section>
    @endif

    @if (!empty($aboutSections['new_way']))
        <section class="team__details overhid section-spacing">
            <div class="container">
                <div class="row g-5">
                    <div class="col-xxl-5 col-xl-5 col-lg-8">
                        <div class="team__left">
                            <div class="details__thumb">
                                <!-- <img class="img-fluid w-75 mx-auto d-block" -->
                                <img
                                    src="{{ route('admin.images.preview', ['model' => 'about', 'id' => $aboutSections['new_way']->id]) }}"alt="about__image">
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-7 col-xl-7 col-lg-10">
                        <div class="about__header heading-gradient-green-black">
                            <h2 class="heading-gradient-green-black" data-wow-duration="1.3s">
                                {{ $aboutSections['new_way']->{'title_' . app()->getLocale()} ?? '' }}</h2>
                        </div>
                        <div class="details__cont" style="margin-top: 20px;">
                            <h5>
                                {{ $aboutSections['new_way']->{'subtitle_' . app()->getLocale()} ?? '' }}
                            </h5>
                            <p style="margin-top: 20px;">
                            <div class="cms-html" id="cms-html">
                                {!! $aboutSections['new_way']->{'content_' . app()->getLocale()} ?? '' !!}
                            </div>
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    @endif
    @if (!empty($aboutSections['who_we_are']))
        <section class="team__details overhid section-spacing">
            <div class="container">
                <div class="row g-5">
                    <div class="col-xxl-7 col-xl-7 col-lg-10">
                        <div class="about__header heading-gradient-green-black">
                            <h2 class="heading-gradient-green-black" data-wow-duration="1.3s">
                                {{ $aboutSections['who_we_are']->{'title_' . app()->getLocale()} ?? '' }}</h2>
                        </div>
                        <div class="details__cont" style="margin-top: 20px;">
                            <p style="margin-top: 20px;">
                            <div class="cms-html" id="cms-html">
                                {!! $aboutSections['who_we_are']->{'content_' . app()->getLocale()} ?? '' !!}
                            </div>
                            </p>
                        </div>
                    </div>
                    <div class="col-xxl-5 col-xl-5 col-lg-8">
                        <div class="team__left">
                            <div class="details__thumb">
                                <!-- <img class="img-fluid w-75 mx-auto d-block" -->
                                <img src="{{ route('admin.images.preview', ['model' => 'about', 'id' => $aboutSections['who_we_are']->id]) }}"
                                    alt="about__image">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
    @if (!empty($aboutSections['values']))
        <section class="team__details overhid section-spacing">
            <div class="container">
                <div class="row g-5">
                    <div class="col-xxl-5 col-xl-5 col-lg-8">
                        <div class="team__left">
                            <div class="details__thumb">
                                <!-- <img class="img-fluid w-75 mx-auto d-block" -->
                                <img src="{{ route('admin.images.preview', ['model' => 'about', 'id' => $aboutSections['values']->id]) }}"
                                    alt="about__image">
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-7 col-xl-7 col-lg-10">
                        <div class="about__header heading-gradient-green-black" data-wow-duration="1.3s">
                            <h2 class="heading-gradient-green-black">
                                {{ $aboutSections['values']->{'title_' . app()->getLocale()} ?? '' }}</h2>
                        </div>
                        <div class="details__cont" style="margin-top: 20px;">
                            <p style="margin-top: 20px;">
                            <div class="cms-html" id="cms-html">
                                {!! $aboutSections['values']->{'content_' . app()->getLocale()} ?? '' !!}
                            </div>
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    @endif
    @if (!empty($aboutSections['problem']))
        <section class="team__details overhid section-spacing">
            <div class="container">
                <div class="row g-5">

                    <div class="col-xxl-7 col-xl-7 col-lg-10">
                        <div class="about__header heading-gradient-green-black" data-wow-duration="1.3s">
                            <h2 class="heading-gradient-green-black">
                                {{ $aboutSections['problem']->{'title_' . app()->getLocale()} ?? '' }}</h2>
                        </div>
                        <div class="details__cont" style="margin-top: 20px;">
                            <h5>
                                {{ $aboutSections['problem']->{'subtitle_' . app()->getLocale()} ?? '' }}
                            </h5>
                            <p style="margin-top: 20px;">
                            <div class="cms-html" id="cms-html">
                                {!! $aboutSections['problem']->{'content_' . app()->getLocale()} ?? '' !!}
                            </div>
                            </p>
                        </div>
                    </div>
                    <div class="col-xxl-5 col-xl-5 col-lg-8">
                        <div class="team__left">
                            <div class="details__thumb">
                                <!-- <img class="img-fluid w-75 mx-auto d-block" -->
                                <img
                                    src="{{ route('admin.images.preview', ['model' => 'about', 'id' => $aboutSections['problem']->id]) }}"alt="about__image">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if (!empty($aboutSections['legacy']))
        <section class="team__details overhid section-spacing">
            <div class="container">
                <div class="row g-5">
                    <div class="col-xxl-5 col-xl-5 col-lg-8">
                        <div class="team__left">
                            <div class="details__thumb">
                                <!-- <img class="img-fluid w-75 mx-auto d-block" -->
                                <img
                                    src="{{ route('admin.images.preview', ['model' => 'about', 'id' => $aboutSections['legacy']->id]) }}"alt="about__image">
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-7 col-xl-7 col-lg-10">
                        <div class="about__header heading-gradient-green-black">
                            <h2 class="heading-gradient-green-black" data-wow-duration="1.3s">
                                {{ $aboutSections['legacy']->{'title_' . app()->getLocale()} ?? '' }}</h2>
                        </div>
                        <div class="details__cont" style="margin-top: 20px;">
                            <h5>
                                {{ $aboutSections['legacy']->{'subtitle_' . app()->getLocale()} ?? '' }}
                            </h5>
                            <p style="margin-top: 20px;">
                            <div class="cms-html" id="cms-html">
                                {!! $aboutSections['legacy']->{'content_' . app()->getLocale()} ?? '' !!}
                            </div>
                            </p>
                        </div>
                    </div>



                </div>
            </div>
        </section>
    @endif

    @if (!empty($aboutSections['approach']))
        <section class="team__details overhid section-spacing">
            <div class="container">
                <div class="row g-5">

                    <div class="col-xxl-7 col-xl-7 col-lg-10">
                        <div class="about__header heading-gradient-green-black" data-wow-duration="1.3s">
                            <h2 class="heading-gradient-green-black">
                                {{ $aboutSections['approach']->{'title_' . app()->getLocale()} ?? '' }}</h2>
                        </div>
                        <div class="details__cont" style="margin-top: 20px;">
                            <p style="margin-top: 20px;">
                            <div class="cms-html" id="cms-html">
                                {!! $aboutSections['approach']->{'content_' . app()->getLocale()} ?? '' !!}
                            </div>
                            </p>
                        </div>
                    </div>
                    <div class="col-xxl-5 col-xl-5 col-lg-8">
                        <div class="team__left">
                            <div class="details__thumb">
                                <!-- <img class="img-fluid w-75 mx-auto d-block" -->
                                <img src="{{ route('admin.images.preview', ['model' => 'about', 'id' => $aboutSections['approach']->id]) }}"
                                    alt="about__image">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif


@endsection
