@extends('frontend.layouts.app')

@section('title', $event->getTitle() . ' | Amid Mission')

@section('content')
    <section class="details__section pt-130 pb-130 overhid">
        <div class="container">
            <div class="row justify-content-center">

                <div class="col-lg-10">
                    <div class="details__items">

                        <div class="details__thumb mb-4">
                            <img src="{{ route('admin.images.preview', ['model' => 'events', 'id' => $event->id]) }}"
                                alt="{{ $event->getTitle() }}">
                        </div>

                        <div class="details__content">
                            <h2>{{ $event->getTitle() }}</h2>

                            <p class="text-muted mb-4">
                                {{ $event->event_date?->format('F d, Y') }}
                            </p>
                            <div class="cms-html" id="cms-html">{!! $event->getContent() !!}</div>
                        </div>
                        @if ($event->hasDownloadFile())
                            <a href="{{ route('admin.files.download', [
                                'model' => 'events',
                                'id' => $event->id,
                                'lang' => app()->getLocale(),
                            ]) }}"
                                class="cmn--btn mt-4" target="_blank">
                                @lang('pages.download_file')
                            </a>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
