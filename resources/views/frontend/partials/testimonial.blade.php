@php
    use Illuminate\Support\Str;
    $locale = app()->getLocale();
@endphp

<!--Testimonial Section Here-->
<section class="testimonial__section overhid pt-130 pb-130">
    <div class="container">

        <div class="title__content center wow fadeInUp" data-wow-duration="1.3s">
            <h6>@lang('pages.testimonial')</h6>
            <h3>@lang('pages.testimonial_description')</h3>
        </div>

        <div class="swiper testimonial__wrapper">
            <div class="swiper-wrapper">

                @foreach ($featuredTestimonials as $testimonial)
                    <div class="swiper-slide">
                        <div class="testi__items">

                            <!-- Image -->
                            <div class="testi__thumb text-center mb-3">
                                <img src="{{ route('admin.images.preview', ['model' => 'testimonials', 'id' => $testimonial->id]) }}"
                                    alt="{{ $testimonial->name }}" class="rounded-circle shadow"
                                    style="width:140px;height:140px;object-fit:cover;" loading="lazy">
                            </div>

                            <!-- Name + Role -->
                            <div class="text-center mb-4">
                                <h5 class="mb-1">{{ $testimonial->name }}</h5>
                                <span>
                                    {{ $testimonial->role }}
                                </span>
                            </div>

                            <!-- Content -->
                            <p class="testimonial-content">
                                {{ strip_tags($locale === 'es' ? $testimonial->content_es : $testimonial->content_en) }}
                            </p>

                            <!-- Stars -->
                            <ul class="testimonial-stars mt-4">
                                <li><i class="fas fa-star"></i></li>
                                <li><i class="fas fa-star"></i></li>
                                <li><i class="fas fa-star"></i></li>
                                <li><i class="fas fa-star"></i></li>
                                <li><i class="fas fa-star"></i></li>
                            </ul>

                        </div>
                    </div>
                @endforeach
               
            </div>
             <div class="swiper-dot text-center">
                    <div class="dot"></div>
                </div>
        </div>
    </div>
</section>
<!--Testimonial Section End-->
