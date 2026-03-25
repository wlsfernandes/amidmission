@php
    use Illuminate\Support\Str;
@endphp

@extends('frontend.layouts.app')

@section('title', __('pages.events') . ' | Amid Mission')

@section('content')
    <section class="event__section pt-130 pb-130 overhid">
        <div class="container">

            {{-- Title --}}
            <div class="title__content center wow fadeInUp" data-wow-duration="1.3s">
                <h6>@lang('pages.events')</h6>
                <div class="witr_bar_main">
                    <div class="witr_bar_inner witr_bar_innerc center"></div>
                    <p>@lang('pages.events_description')</p>
                </div>
            </div>

            <div class="row g-4">
                @forelse($events as $event)
                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 wow fadeInUp"
                        data-wow-duration="{{ 3 + ($loop->index % 3) * 2 }}s">

                        <div class="event__items">

                            <div class="thumb">
                                <a href="{{ route('events.display', $event->slug) }}">
                                    <img src="{{ route('admin.images.preview', ['model' => 'events', 'id' => $event->id]) }}"
                                        alt="{{ $event->getTitle() }}" loading="lazy">
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
                                <div class="cms-html" id="cms-html">
                                    {!! $event->getContent() !!}
                                </div>
                                </p>

                                <a href="{{ route('events.display', $event->slug) }}" class="btns">
                                    @lang('pages.read_more')
                                </a>
                            </div>

                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center text-muted">
                        @lang('pages.no_events_available')
                    </div>
                @endforelse
            </div>

        </div>
    </section>
@endsection
