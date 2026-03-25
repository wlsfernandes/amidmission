@extends('frontend.layouts.app')

@section('title', __('pages.resources') . ' | Amid Mission')

@section('content')
    <section class="breadcumd__banner overhid">
        <div class="container">
            <div class="breadcumd__wrapper">
                <h2 class="left__content">
                    @lang('pages.resources')
                </h2>
                <ul class="right__content">
                    <li>
                        <a href="index.html">
                            <i class="fa-solid fa-house"></i>
                            @lang('pages.home')
                        </a>
                    </li>
                    <li>
                        <i class="fa-solid fa-chevron-right"></i>
                    </li>
                    <li>
                        @lang('pages.resources')
                    </li>
                </ul>
            </div>
        </div>
    </section>
    <section class="blog__section pt-130 pb-130">
        <div class="container">

            {{-- Header --}}
            <div class="row mb-60">
                <div class="col-lg-8 mx-auto text-center">
                    <h2>@lang('pages.resources')</h2>
                </div>
            </div>

            {{-- Resource List --}}
            <div class="row">
                <div class="col-lg-8 mx-auto">

                    @forelse ($resources as $resource)
                        <article class="resource-list-item mb-50">

                            {{-- Title --}}
                            <h4 class="mb-2">
                                {{ $resource->title }}
                            </h4>

                            {{-- Description --}}
                            @if ($resource->description)
                                <p class="mb-3">
                                <div class="cms-html" id="cms-html">
                                    {!! $resource->description !!}
                                </div>
                                </p>
                            @endif

                            {{-- Actions --}}
                            <div class="d-flex flex-wrap gap-3 align-items-center">

                                {{-- Download file (localized) --}}
                                @if ($resource->file_url)
                                    <a href="{{ route('admin.files.download', [
                                        'model' => 'resources',
                                        'id' => $resource->id,
                                        'lang' => app()->getLocale(),
                                    ]) }}"
                                        class="cmn--btn" target="_blank">
                                        <i class="uil uil-file-download"></i>
                                        @lang('pages.download_file')
                                    </a>
                                @endif

                                {{-- External link --}}
                                @if ($resource->external_link)
                                    <a href="{{ $resource->external_link }}" class="cmn--btn border-btn" target="_blank"
                                        rel="noopener">
                                        <i class="uil uil-external-link-alt"></i>
                                        @lang('pages.visit_resource')
                                    </a>
                                @endif

                            </div>

                            <hr class="mt-50">
                        </article>
                    @empty
                        <p class="text-center text-muted">
                            @lang('pages.no_resources_available')
                        </p>
                    @endforelse

                </div>
            </div>

        </div>
    </section>

@endsection
