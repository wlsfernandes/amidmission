<!--About Section Here-->
<section class="about__section pt-130 pb-130 overhid">
    <div class="container">
        <div class="row g-4 align-items-center justify-content-between">
            <div class="col-xxl-6 col-xl-6 col-lg-6 wow fadeInLeft" data-wow-duration="3s">
                <div class="about__thumb">
                    <img src="{{ route('admin.images.preview', ['model' => 'about', 'id' => $aboutSections['vision']->id]) }}"
                        alt="about__image">
                    <div class="small__about__one">
                        <img src="{{ asset('assets/frontend/img/about/b4.jpg') }}" alt="about__img">
                    </div>
                    <div class="small__about">
                        <img src="{{ asset('assets/frontend/img/about/b3.jpg') }}" alt="about__img">
                    </div>
                </div>
            </div>
            <div class="col-xxl-6 col-xl-6 col-lg-6 wow fadeInRight" data-wow-duration="5s">
                <div class="about__content">
                    <div class="about__header">
                        <h6>
                            @lang('home.about_us')
                        </h6>
                    </div>
                    <h2 class="mb-4">
                        {{ $aboutSections['vision']->{'title_' . app()->getLocale()} ?? '' }}
                    </h2>
                    <h4>
                        <div class="cms-html" id="cms-html">
                            {!! $aboutSections['vision']->{'subtitle_' . app()->getLocale()} ?? '' !!}
                        </div>
                    </h4>
                    <p style="margin-top: 20px;">
                    <div class="cms-html" id="cms-html">
                        {!! $aboutSections['vision']->{'content_' . app()->getLocale()} ?? '' !!}
                    </div>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
