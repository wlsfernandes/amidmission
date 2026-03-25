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
                                @php
                                    $subtitle =
                                        app()->getLocale() === 'es' ? $banner->subtitle_es : $banner->subtitle_en;

                                    $title = app()->getLocale() === 'es' ? $banner->title_es : $banner->title_en;
                                @endphp

                                @if ($subtitle)
                                    {!! $subtitle !!}
                                @endif

                                {{-- Title --}}
                                @if ($title)
                                    {!! $title !!}
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
@if (request()->is('/') || request()->is('donate'))
    {{-- Only show on homepage --}}

    <section class="ftco-appointment ftco-section ftco-no-pt ftco-no-pb img">
        <div class="overlay"></div>
        <div class="container">
            <x-alert />
            <div class="row">
                <div class="col-md-5 order-md-last d-flex align-items-stretch">
                    <div class="donation-wrap">
                        <div class="total-donate d-flex align-items-center">
                            <span class="fa flaticon-cleaning"></span>
                            <h4>@lang('home.donation_campaign') <br>@lang('home.are_running')</h4>
                            <p class="d-flex align-items-center">
                                <span>$</span>
                                <span class="number" data-number="24781">0</span>
                            </p>
                        </div>
                        <form method="POST" action="{{ route('donations.start') }}" class="appointment">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="first_name">@lang('home.first_name')</label>
                                        <div class="input-wrap">
                                            <div class="icon"><span class="fa fa-user"></span></div>
                                            <input type="text" class="form-control" placeholder="" name="first_name"
                                                id="first_name">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="last_name">@lang('home.last_name')</label>
                                        <div class="input-wrap">
                                            <div class="icon"><span class="fa fa-user"></span></div>
                                            <input type="text" class="form-control" placeholder="" name="last_name"
                                                id="last_name">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="email">@lang('home.email')</label>
                                        <div class="input-wrap">
                                            <div class="icon"><span class="fa fa-paper-plane"></span></div>
                                            <input type="email" class="form-control" placeholder="" name="email"
                                                id="email">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="name">@lang('home.select_causes')</label>
                                        <div class="form-field">
                                            <div class="select-wrap">
                                                <div class="icon"><span class="fa fa-chevron-down"></span></div>
                                                <select name="" id="" class="form-control">
                                                    <option value=""></option>
                                                    <option value="">Amid Mission International</option>
                                                    <option value="">Amid Mission Brasil</option>
                                                    <option value="">Amid Mission Peru</option>
                                                    <option value="">Amid Mission Paraguay</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="name">@lang('home.select_amount')</label>
                                        <div class="input-wrap">
                                            <div class="icon"><span class="fa fa-money"></span></div>
                                            <input type="number" name="amount" class="form-control" value="50"
                                                min="1">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="submit" value="@lang('home.donate_now')"
                                            class="btn btn-secondary py-3 px-4">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-7 wrap-about py-5">
                    <div class="heading-section pr-md-5 pt-md-5">
                        <span class="subheading">Amid Mission International</span>
                        <h2 class="mb-4">@lang('home.mission_title')</h2>
                        <p>@lang('home.mission_text')</p>
                    </div>
                    <div class="row my-md-5">
                        <div class="col-md-6 d-flex counter-wrap">
                            <div class="block-18 d-flex">
                                <div class="icon d-flex align-items-center justify-content-center">
                                    <span class="flaticon-volunteer"></span>
                                </div>
                                <div class="desc">
                                    <div class="text">
                                        <strong class="number" data-number="50">0</strong>
                                    </div>
                                    <div class="text">
                                        <span>@lang('home.volunteers')</span>
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
                                        <strong class="number" data-number="24400">0</strong>
                                    </div>
                                    <div class="text">
                                        <span>Trusted Funds</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <p><a href="" class="btn btn-secondary btn-outline-secondary">Become A Volunteer</a></p>
                </div>
            </div>
        </div>
    </section>
@endif
