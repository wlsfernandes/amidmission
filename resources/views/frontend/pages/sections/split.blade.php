@php
    $imageLeft = $loop->index % 2 === 0;
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
                                alt="{!! $section->getTitle() !!}" class="img-fluid">
                        </div>
                    @endif
                </div>
            @endif

            {{-- TEXT --}}
            <div class="col-xxl-7 col-xl-7 col-lg-10">

                <div class="about__header heading-gradient-green-black">
                    <h2 class="heading-gradient-green-black wow fadeInUp">
                        {!! $section->getTitle() !!}
                    </h2>
                </div>

                <div class="details__cont mt-3">
                    <div class="cms-html">
                        {!! $section->getContent() !!}
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
                                alt="{!! $section->getTitle() !!}" class="img-fluid">
                        </div>
                    @endif
                </div>
            @endif

        </div>

        @if ($section->external_link)
            <div class="text-center mt-4">
                <a href="{{ $section->external_link }}" target="_blank" class="cmn--btn">
                    {{ $section->getButtonText() ?? __('pages.learn_more') }}
                </a>
            </div>
        @endif

    </div>
</section>
