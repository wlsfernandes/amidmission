@extends('frontend.layouts.app')

@section('title', __('pages.open_positions') . ' | Amid Mission')

@section('content')

<!-- Breadcrumb -->
<section class="breadcumd__banner overhid">
    <div class="container">
        <div class="breadcumd__wrapper">
            <h2 class="left__content">
                @lang('pages.open_positions')
            </h2>
            <ul class="right__content">
                <li>
                    <a href="{{ url('/') }}">
                        <i class="fa-solid fa-house"></i>
                        @lang('pages.home')
                    </a>
                </li>
                <li><i class="fa-solid fa-chevron-right"></i></li>
                <li>@lang('pages.open_positions')</li>
            </ul>
        </div>
    </div>
</section>
<!-- End Breadcrumb -->

@php use Illuminate\Support\Str; @endphp

<section class="details__section pt-130 pb-130 overhid">
    <div class="container">
        <div class="row justify-content-center g-4">

            @forelse($positions as $position)

                <div class="col-12 col-sm-6 col-lg-4 d-flex">

                    <div class="details__items text-center w-100 d-flex flex-column">

                        {{-- Image --}}
                        <div class="details__thumb mb-3">
                            <a href="{{ route('positions.display', $position->slug) }}">
                                <img
                                    src="{{ route('admin.images.preview', ['model' => 'positions', 'id' => $position->id]) }}"
                                    alt="{{ $position->getTitle() }}"
                                    class="img-fluid w-100"
                                    loading="lazy">
                            </a>
                        </div>

                        {{-- Content --}}
                        <div class="details__content px-3 d-flex flex-column flex-grow-1">

                            <h5 class="mb-2">
                                <a href="{{ route('positions.display', $position->slug) }}">
                                    {{ $position->getTitle() }}
                                </a>
                            </h5>

                            <p class="flex-grow-1">
                                {{ Str::limit(strip_tags($position->getDescription()), 120) }}
                            </p>

                            <a href="{{ route('positions.display', $position->slug) }}"
                               class="cmn--btn mt-3">
                                @lang('pages.view_position')
                            </a>

                        </div>

                    </div>

                </div>

            @empty
                <div class="col-12 text-center text-muted">
                    @lang('pages.no_open_positions')
                </div>
            @endforelse

        </div>
    </div>
</section>

@endsection
