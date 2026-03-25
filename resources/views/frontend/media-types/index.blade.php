@extends('frontend.layouts.app')

@section('title', __('pages.media') . ' | Amid Mission')

@section('content')

@php use Illuminate\Support\Str; @endphp

<section class="details__section pt-130 pb-130 overhid">
    <div class="container">
        <div class="row justify-content-center g-4">

            @forelse ($mediaTypes as $type)

                <div class="col-12 col-sm-6 col-lg-4 d-flex">

                    <div class="details__items text-center w-100 d-flex flex-column">

                        {{-- Image --}}
                        <div class="details__thumb mb-3">
                            <a href="{{ route('media.byType', $type->slug) }}">

                                @if ($type->image_url)
                                    <img
                                        src="{{ route('admin.images.preview', [
                                            'model' => 'media-types',
                                            'id' => $type->id,
                                        ]) }}"
                                        alt="{{ $type->name }}"
                                        class="img-fluid w-100"
                                        loading="lazy">
                                @else
                                    <div class="d-flex align-items-center justify-content-center media-placeholder">
                                        <i class="uil uil-play-circle text-muted"></i>
                                    </div>
                                @endif

                            </a>
                        </div>

                        {{-- Content --}}
                        <div class="details__content px-3 d-flex flex-column flex-grow-1">

                            <h5 class="mb-2">
                                <a href="{{ route('media.byType', $type->slug) }}">
                                    {{ $type->name }}
                                </a>
                            </h5>

                            @if ($type->description)
                                <p class="flex-grow-1">
                                    {{ Str::limit(strip_tags($type->description), 120) }}
                                </p>
                            @else
                                <p class="flex-grow-1"></p>
                            @endif

                            <a href="{{ route('media.byType', $type->slug) }}"
                               class="cmn--btn mt-3">
                                @lang('pages.explore')
                            </a>

                        </div>

                    </div>

                </div>

            @empty
                <div class="col-12 text-center text-muted">
                    @lang('pages.no_media_available')
                </div>
            @endforelse

        </div>
    </div>
</section>

@endsection
