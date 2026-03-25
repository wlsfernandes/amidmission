<section class="banner__section overhid mb-50 cms-hero">

    @if ($section->image_url)
        <img src="{{ route('admin.images.preview', [
            'model' => 'sections',
            'id' => $section->id,
        ]) }}"
            class="img-fluid w-100 cms-hero-bg">
    @endif

    <div class="cms-hero-content hero-align-{{ $section->button_position ?? 'center' }}">

        <div class="hero-inner">

            @include('frontend.pages.sections.partials.content')

            @include('frontend.pages.sections.partials.button')

        </div>

    </div>

</section>
