@php
    $layout = $section->layout ?? 'image_left';
@endphp

<section class="py-5">

    <div class="container">

        @if ($layout === 'full')

            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="cms-html mb-3">
                        <div class="cta-content text-{{ $section->button_position ?? 'start' }}">

                            @include('frontend.pages.sections.partials.content')
                            @include('frontend.pages.sections.partials.button')
                        </div>
                    </div>

                </div>
            </div>
        @else
            <div class="row align-items-center g-5">

                @if ($layout === 'image_left')
                    @include('frontend.pages.sections.partials.image', [
                        'imageColClass' => 'col-lg-5 order-2 order-lg-1',
                    ])
                @endif

                <div class="col-lg-7 order-1 {{ $layout === 'image_left' ? 'order-lg-2' : 'order-lg-1' }}">
                    <div class="cms-html mb-3">
                        <div class="cta-content text-{{ $section->button_position ?? 'start' }}">

                            @include('frontend.pages.sections.partials.content')
                            @include('frontend.pages.sections.partials.button')

                        </div>
                    </div>
                </div>

                @if ($layout === 'image_right')
                    @include('frontend.pages.sections.partials.image', [
                        'imageColClass' => 'col-lg-5 order-2 order-lg-2',
                    ])
                @endif

            </div>

        @endif

    </div>

</section>
