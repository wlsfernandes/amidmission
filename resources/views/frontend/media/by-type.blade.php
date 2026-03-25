@extends('frontend.layouts.app')

@section('title', $type->name . ' | Amid Mission')

@section('content')

    <section class="blog__section pt-130 pb-130">
        <div class="container">

            {{-- Header --}}
            <div class="row mb-60">
                <div class="col-lg-8 mx-auto text-center">
                    <h2>{{ $type->name }}</h2>

                    @if ($type->description)
                        <p class="text-muted mt-3">
                            {{ $type->description }}
                        </p>
                    @endif
                </div>
            </div>

            {{-- Media List --}}
            <div class="row">
                <div class="col-lg-8 mx-auto">

                    @forelse ($media as $item)
                        <article class="media-list-item mb-50">

                            {{-- Title --}}
                            <h4 class="mb-2">
                                {{ $item->title }}
                            </h4>

                            {{-- Meta --}}
                            <div class="text-muted small mb-2">
                                {{ parse_url($item->external_link, PHP_URL_HOST) }}
                                @if ($item->published_at)
                                    • {{ $item->published_at->format('F Y') }}
                                @endif
                            </div>

                            {{-- Description --}}
                            @if ($item->description)
                                <p class="mb-3">
                                    {{ $item->description }}
                                </p>
                            @endif

                            {{-- Action --}}
                            <a href="{{ $item->external_link }}" target="_blank" rel="noopener" class="cmn--btn">
                                @lang('pages.visit_resource')
                            </a>

                            <hr class="mt-50">
                        </article>
                    @empty
                        <p class="text-center text-muted">
                            @lang('pages.no_media_found')
                        </p>
                    @endforelse

                </div>
            </div>

        </div>
    </section>

@endsection
