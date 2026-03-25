@php
    use Illuminate\Support\Str;
@endphp

<section class="event__section pt-130 pb-130 overhid">
    <div class="container">

        <div class="title__content center wow fadeInUp" data-wow-duration="1.3s">
            <h6>@lang('pages.events')</h6>
            <div class="witr_bar_main">
                <div class="witr_bar_inner witr_bar_innerc center"></div>
                <h3>@lang('pages.featured_events')</h3>
            </div>
        </div>

        <div class="row g-4">
            @foreach($featuredEvents as $event)
                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 wow fadeInUp">
                    <div class="blog__items">

                        <div class="thumb">
                            <a href="{{ route('events.display', $event->slug) }}">
                                <img src="{{ route('admin.images.preview', ['model' => 'events', 'id' => $event->id]) }}"
                                    alt="{{ $event->getTitle() }}">
                            </a>
                        </div>

                        <div class="content">
                            <h5>
                                <a href="{{ route('events.display', $event->slug) }}">
                                    {{ $event->getTitle() }}
                                </a>
                            </h5>

                            <small class="text-muted d-block mb-2">
                                {{ $event->event_date?->format('F d, Y') }}
                            </small>

                            <p>
                                {{ $event->limitText($event->getContent(), 120) }}
                            </p>

                            <a href="{{ route('events.display', $event->slug) }}" class="btn btn-sm btn-outline-success mt-2">
                                @lang('pages.read_more')
                            </a>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>

    </div>
</section>