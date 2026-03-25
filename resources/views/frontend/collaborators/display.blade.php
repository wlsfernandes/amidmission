@extends('frontend.layouts.app')
@section('title', 'Amid Mission - ' . $collaborator->title)
@section('content')


    <section class="breadcumd__banner overhid"
        style="background-image: url('{{ $bannerImage }}'); background-size: cover; background-position: center;">

        <div class="container">
            <div class="breadcumd__wrapper">
                <h2 class="left__content">
                    @lang('pages.partnerships')
                </h2>

                <ul class="right__content">
                    <li>
                        <a href="{{ url('/') }}">
                            <i class="fa-solid fa-house"></i>
                            @lang('pages.home')
                        </a>
                    </li>

                    <li>
                        <i class="fa-solid fa-chevron-right"></i>
                    </li>

                    <li>
                        @lang('pages.partnerships')
                    </li>
                </ul>
            </div>
        </div>
    </section>

    <!-- Collaborator Details Section -->
    <section class="details__section event__section overhid pt-130 pb-130">
        <div class="container">
            <div class="title__content center wow fadeInUp" data-wow-duration="1.3s">
                <h3>{{ $collaborator->title }}</h3>
            </div>
            <div class="row">
                <div class="col-lg-12">

                    <div class="details__items">

                        {{-- Project Title --}}
                        <div class="details__content mb-40">
                            <h3></h3>
                            {{-- Optional Dates --}}

                        </div>

                        {{-- Project Description --}}
                        <div class="details__content mb-20">
                            <div class="cms-html" id="cms-html">
                                {!! $collaborator->description !!}
                            </div>
                        </div>

                        {{-- Partner Icons --}}
                        @if ($collaborator->images->count())
                            <div class="partner-cards mt-50">
                                <div class="row g-4 justify-content-center">

                                    @foreach ($collaborator->images as $image)
                                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex">

                                            <a href="{{ $image->external_link ?: '' }}" class="partner-card w-100"
                                                @if (!empty($image->external_link)) target="_blank" rel="noopener noreferrer" @endif>

                                                <div class="partner-card">
                                                    <img src="{{ route('admin.images.preview', ['model' => 'collaborator-images', 'id' => $image->id]) }}"
                                                        alt="{{ $collaborator->title }}" loading="lazy">
                                                </div>

                                            </a>

                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        @endif




                        <div class="d-flex justify-content-center gap-3 mt-4 flex-wrap">

                            @if (!empty($collaborator->external_link))
                                <a href="{{ $collaborator->external_link }}" class="cmn--btn cmn--btn-outline"
                                    target="_blank" rel="noopener noreferrer">
                                    <i class="uil uil-external-link-alt"></i>
                                    @lang('pages.apply_now')
                                </a>
                            @endif

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- Project Details Section End -->

@endsection
