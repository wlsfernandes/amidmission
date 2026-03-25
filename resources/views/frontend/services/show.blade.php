@extends('frontend.layouts.app')

@section('title', $service->getTitle() . ' | Amid Mission')

@section('content')
    <section class="details__section overhid pt-130 pb-130">
        <div class="container">
            <div class="row g-4">

                {{-- SIDEBAR --}}
                <div class="col-xxl-4 col-xl-4 col-lg-4">
                    <div class="sidebar__right">

                        {{-- Services list --}}
                        <div class="sidebar__widget mb-5">
                            <ul class="service__list">

                                <li class="mb-3">
                                    <a href="{{ route('services.index.public') }}">
                                        <span>@lang('pages.all_services')</span>
                                        <i class="fa fa-chevron-right"></i>
                                    </a>
                                </li>

                                @foreach ($services as $item)
                                    <li class="mb-3 {{ $item->id === $service->id ? 'active' : '' }}">
                                        <a href="{{ route('services.display', $item->slug) }}">
                                            <span>{{ $item->getTitle() }}</span>
                                            <i class="fa fa-chevron-right"></i>
                                        </a>
                                    </li>
                                @endforeach

                            </ul>
                        </div>

                        {{-- Help box (static for now) --}}
                        <div class="sidebar__widget">
                            <div class="service__helping">
                                <div class="thumb">
                                    <img src="{{ asset('assets/frontend/img/service/details-img-1.jpg') }}" alt="service">
                                </div>
                                <div class="helping__content">
                                    <h4>@lang('pages.need_help')</h4>
                                    <p>@lang('pages.contact_us_description')</p>

                                    <a href="{{ route('contact') }}" class="cmn--btn mt-4">
                                        @lang('pages.contact_us')
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- MAIN CONTENT --}}
                <div class="col-xxl-8 col-xl-8 col-lg-8">
                    <div class="details__items service__details">

                        {{-- Main image --}}
                        <div class="details__thumb">
                            <img src="{{ route('admin.images.preview', ['model' => 'services', 'id' => $service->id]) }}"
                                alt="{{ $service->getTitle() }}">
                        </div>

                        {{-- Content --}}
                        <div class="details__content">
                            <h3>{{ $service->getTitle() }}</h3>

                            <div class="cms-html" id="cms-html">
                                {!! $service->getDescription() !!}
                            </div>
                        </div>
                        {{-- External link (optional) --}}
                        @if ($service->external_link)
                            <a href="{{ $service->external_link }}" target="_blank" class="cmn--btn mt-4">
                                @lang('pages.learn_more')
                            </a>
                        @endif

                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
