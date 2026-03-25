{{-- resources/views/frontend/pages/home.blade.php --}}
@extends('frontend.layouts.app')

@section('title', 'Home | Amid Mission')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @include('frontend.partials.about')
    @include('frontend.partials.team-carousel')
    @include('frontend.partials.partners')
    @include('frontend.partials.testimonial')
    @include('frontend.partials.services-carousel')
    @include('frontend.partials.blog-carousel')
    @include('frontend.partials.donate-carousel')
    @include('frontend.partials.event-carousel')
    <!--Involve Section Here-->
    <section class="involve__section pt-130 pb-130 overhid">
        <div class="container">
            <div class="row G-4">
                <div class="col-lg-12">
                    <div class="involve__items center">
                        <h6>
                            GET INVOLVED NOW
                        </h6>
                        <h2>
                            We Have The Power Today To
                            Change Tomorrow
                        </h2>
                        <a href="#0" class="cmn--btn mt-4">
                            join with us
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('frontend.partials.contact')


@endsection
