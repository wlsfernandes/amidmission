<section class="hero-wrap">
    <div class="home-slider owl-carousel">

        @foreach ($banners as $banner)
            <div class="slider-item"
                style="background-image:url('{{ route('admin.images.preview', ['model' => 'banners', 'id' => $banner->id]) }}');">

                {{-- overlays --}}
                <div class="overlay-1"></div>
                <div class="overlay-2"></div>
                <div class="overlay-3"></div>
                <div class="overlay-4"></div>

                <div class="container">
                    <div class="row no-gutters slider-text js-fullheight align-items-center">
                        <div class="col-md-10 col-lg-7 ftco-animate">

                            <div class="text w-100">

                                {{-- Subtitle --}}
                                @if ($banner->subtitle)
                                    {!! $banner->subtitle !!}
                                @endif

                                @if ($banner->title)
                                    {!! $banner->title !!}
                                @endif

                                {{-- CTA --}}
                                <div class="d-flex meta">

                                    @if ($banner->link)
                                        <div>
                                            <p class="mb-0">
                                                <a href="{{ $banner->link }}" class="btn btn-secondary py-3 px-4"
                                                    @if ($banner->open_in_new_tab) target="_blank" @endif>
                                                    {{ __('Learn More') }}
                                                </a>
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        @endforeach

    </div>
</section>
@if (request()->is('/'))
    {{-- Only show on homepage --}}

    <section class="ftco-appointment ftco-section ftco-no-pt ftco-no-pb img">
        <div class="overlay"></div>

        <div class="container">
            <x-alert />

            <div class="row">

                {{-- Donation Call to Action --}}
                <div class="col-md-5 order-md-last d-flex align-items-stretch">
                    <div class="donation-wrap w-100">

                        <div class="total-donate d-flex align-items-center">
                            <span class="fa flaticon-cleaning"></span>

                            <h4>
                                @lang('home.donation_campaign')
                                <br>
                                @lang('home.are_running')
                            </h4>

                            <p class="d-flex align-items-center">
                                <span>$</span>
                                <span class="number" data-number="24781">0</span>
                            </p>
                        </div>

                        <div class="appointment text-center px-4 py-5">

                            <div class="mb-4">
                                <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-white"
                                    style="width: 85px; height: 85px;">
                                    <span class="fa fa-heart" style="font-size: 34px; color: #f86f2d;"></span>
                                </div>
                            </div>

                            <h3 class="mb-3 text-white">
                                Make a Difference Today
                            </h3>

                            <p class="text-white mb-4" style="opacity: 0.9;">
                                Your generosity helps Amid Mission serve communities,
                                support ministry projects, and share hope with people
                                around the world.
                            </p>

                            <a href="{{ url('/donate') }}" class="btn btn-secondary py-3 px-5 w-100">
                                <span class="fa fa-heart mr-2"></span>
                                @lang('home.donate_now')
                            </a>

                            <p class="text-white small mt-3 mb-0" style="opacity: 0.75;">
                                <span class="fa fa-lock mr-1"></span>
                                Secure online donation
                            </p>

                        </div>
                    </div>
                </div>


                {{-- Mission Information --}}
                <div class="col-md-7 wrap-about py-5">
                    <div class="heading-section pr-md-5 pt-md-5">

                        <span class="subheading">
                            Amid Mission International
                        </span>

                        <h2 class="mb-4">
                            @lang('home.mission_title')
                        </h2>

                        <p>
                            @lang('home.mission_text')
                        </p>

                    </div>

                    <div class="row my-md-5">

                        <div class="col-md-6 d-flex counter-wrap">
                            <div class="block-18 d-flex">

                                <div class="icon d-flex align-items-center justify-content-center">
                                    <span class="flaticon-volunteer"></span>
                                </div>

                                <div class="desc">
                                    <div class="text">
                                        <strong class="number" data-number="50">
                                            0
                                        </strong>
                                    </div>

                                    <div class="text">
                                        <span>
                                            @lang('home.volunteers')
                                        </span>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-md-6 d-flex counter-wrap">
                            <div class="block-18 d-flex">

                                <div class="icon d-flex align-items-center justify-content-center">
                                    <span class="flaticon-piggy-bank"></span>
                                </div>

                                <div class="desc">
                                    <div class="text">
                                        <strong class="number" data-number="24400">
                                            0
                                        </strong>
                                    </div>

                                    <div class="text">
                                        <span>
                                            Trusted Funds
                                        </span>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>

                    <p>
                        <a href="{{ url('/contact') }}" class="btn btn-secondary btn-outline-secondary">
                            Become a Volunteer
                        </a>
                    </p>

                </div>

            </div>
        </div>
    </section>
@endif
