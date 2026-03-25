@php
    use Illuminate\Support\Str;
@endphp

<!-- Service Section Here -->
<section class="service__section section__bg pt-130 pb-130 overhid">
    <div class="container">

        <div class="title__content center">
            <h6>@lang('pages.services')</h6>
        </div>

        <div class="row g-4">
            <h3 class=" wow fadeInUp" data-wow-duration="1.3s"> @lang('pages.services_subtitle')</h3>
            @forelse($featuredServices as $service)
                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 wow fadeInUp"
                    data-wow-duration="{{ 3 + ($loop->index * 2) }}s">

                    <div class="blog__items center">

                        {{-- Image --}}
                        <div class="thumb">
                            <a href="{{ route('services.display', $service->slug) }}">
                                <img src="{{ route('admin.images.preview', ['model' => 'services', 'id' => $service->id]) }}"
                                    alt="{{ $service->getTitle() }}" loading="lazy">
                            </a>
                        </div>

                        {{-- Content --}}
                        <div class="content">
                            <h5>
                                <a href="{{ route('services.display', $service->slug) }}">
                                    {{ $service->getTitle() }}
                                </a>
                            </h5>

                            <p>
                                {{ Str::limit(strip_tags($service->getDescription()), 120) }}
                            </p>

                            <a href="{{ route('services.display', $service->slug) }}" class="btn btn-sm btn-outline-success mt-2">
                                @lang('pages.read_more')
                            </a>
                        </div>

                    </div>
                </div>
            @empty
                <div class="col-12 text-center text-muted">
                    @lang('pages.no_services_available')
                </div>
            @endforelse

        </div>
    </div>
</section>
<!-- Service Section End -->