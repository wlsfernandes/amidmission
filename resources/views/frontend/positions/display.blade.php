@extends('frontend.layouts.app')

@section('title', $position->getTitle() . ' | Amid Mission')

@section('content')

    {{-- MAIN CONTENT --}}
    <section class="details__section overhid pt-130 pb-130">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="details__items">
                        <div class="details__content">
                            <h2>{{ $position->getTitle() }}</h2>
                            <div class="cms-html" id="cms-html">
                                {!! $position->getDescription() !!}
                            </div>

                            {{-- APPLY / EXTERNAL LINK --}}

                            @if ($position->getFileUrl())
                                <div class="text-center mt-5">
                                    <a href="{{ route('admin.files.download', [
                                        'model' => 'positions',
                                        'lang' => app()->getLocale(),
                                        'id' => $position->id,
                                    ]) }}"
                                        target="_blank" rel="noopener noreferrer" class="cmn--btn">
                                        @lang('pages.download_details')
                                    </a>
                                </div>
                            @endif

                            @if ($position->external_link)
                                <div class="text-center mt-5">
                                    <a href="{{ $position->external_link }}" target="_blank" rel="noopener noreferrer"
                                        class="cmn--btn">
                                        @lang('pages.apply_now')
                                    </a>
                                </div>
                            @endif

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>


    {{-- OPTIONAL SECTIONS --}}
    @if ($position->sections && $position->sections->count())
        @foreach ($position->sections as $index => $section)
            @php
                $imageLeft = $index % 2 === 0;
            @endphp

            <section class="team__details overhid section-spacing">
                <div class="container">
                    <div class="row g-5 align-items-center">

                        {{-- IMAGE LEFT --}}
                        @if ($imageLeft)
                            <div class="col-xxl-5 col-xl-5 col-lg-8">
                                @if ($section->image_url)
                                    <div class="details__thumb text-center">
                                        <img src="{{ route('admin.images.preview', [
                                            'model' => 'sections',
                                            'id' => $section->id,
                                        ]) }}"
                                            alt="{{ $section->title }}" class="img-fluid">
                                    </div>
                                @endif
                            </div>
                        @endif

                        {{-- TEXT --}}
                        <div class="col-xxl-7 col-xl-7 col-lg-10">
                            <div class="about__header heading-gradient-green-black">
                                <h2 class="heading-gradient-green-black">
                                    {{ $section->title }}
                                </h2>
                            </div>

                            <div class="details__cont mt-3">
                                <div class="cms-html" id="cms-html">
                                    {!! $section->content !!}
                                </div>
                            </div>
                        </div>

                        {{-- IMAGE RIGHT --}}
                        @if (!$imageLeft)
                            <div class="col-xxl-5 col-xl-5 col-lg-8">
                                @if ($section->image_url)
                                    <div class="details__thumb text-center">
                                        <img src="{{ route('admin.images.preview', [
                                            'model' => 'sections',
                                            'id' => $section->id,
                                        ]) }}"
                                            alt="{{ $section->title }}" class="img-fluid">
                                    </div>
                                @endif
                            </div>
                        @endif

                    </div>

                    {{-- Section Button --}}
                    @if ($section->external_link)
                        <div class="text-center mt-4">
                            <a href="{{ $section->external_link }}" target="_blank" class="cmn--btn">
                                {{ $section->button_text ?? __('pages.learn_more') }}
                            </a>
                        </div>
                    @endif

                </div>
            </section>
        @endforeach
    @endif

@endsection
