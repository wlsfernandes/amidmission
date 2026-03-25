@php
    $layout = $section->layout ?? 'image_left';
@endphp

<section class="py-5">

    <div class="container">

        @if ($layout === 'full')
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    @include('frontend.pages.sections.partials.content')
                </div>
            </div>
        @else
            <div class="row align-items-center g-5">
                @if ($layout === 'image_left')
                    @include('frontend.pages.sections.partials.video')
                @endif
                <div class="col-lg-7">
                    @include('frontend.pages.sections.partials.content')
                </div>
                @if ($layout === 'image_right')
                    @include('frontend.pages.sections.partials.video')
                @endif
            </div>
        @endif
    </div>

</section>
{{-- Cards --}}
@if ($section->cards && $section->cards->count())

    <section class="blog__section pt-80 pb-80 overhid">

        <div class="container">

            <div class="row g-4">

                @foreach ($section->cards as $card)
                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 wow fadeInUp">

                        <div class="blog__items">

                            @if ($card->image_url)
                                <div class="thumb">
                                    <img src="{{ route('admin.images.preview', ['model' => 'section_cards', 'id' => $card->id]) }}"
                                        alt="{{ $card->getTitle() }}">
                                </div>
                            @endif

                            <div class="content">
                                @if ($card->getTitle())
                                    <div class="cms-html">
                                        {!! $card->getTitle() !!}
                                    </div>
                                @endif
                                @if ($card->getContent())
                                    <div class="cms-html">
                                        {!! $card->getContent() !!}
                                    </div>
                                @endif
                                @if ($card->link)
                                    <a href="{{ $card->link }}" class="cmn--btn" target="_blank" rel="noopener">
                                        @lang('pages.read_more')
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif
