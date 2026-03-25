@extends('frontend.layouts.app')

@section('title', __('Donation Success'))

@section('content')

    <section class="ftco-section bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 text-center">

                    <div class="bg-white p-5 shadow-sm rounded">

                        {{-- ICON --}}
                        <div class="mb-4">
                            <span class="fa fa-check-circle text-success" style="font-size: 60px;"></span>
                        </div>

                        {{-- TITLE --}}
                        <h2 class="mb-3">
                            {{ __('Thank You!') }}
                        </h2>

                        {{-- MESSAGE --}}
                        <p class="mb-4">
                            {{ __('Your donation has been successfully processed.') }}
                        </p>

                        {{-- OPTIONAL SESSION --}}
                        @if (!empty($session_id))
                            <p class="text-muted small">
                                {{ __('Reference') }}: {{ $session_id }}
                            </p>
                        @endif

                        {{-- BUTTON --}}
                        <a href="{{ url('/') }}" class="btn btn-primary mt-3">
                            {{ __('Back to Donate') }}
                        </a>

                    </div>

                </div>
            </div>
        </div>
    </section>

@endsection
