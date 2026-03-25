@extends('frontend.layouts.app')

@section('title', 'Checkout' . ' | Amid Mission')

@section('content')
    @extends('frontend.layouts.app')

@section('title', 'Thank You | Amid Mission')

@section('content')
    <section class="signup__section pt-130 pb-130">
        <div class="container">
            <div class="row justify-content-center align-items-center g-5">

                {{-- LEFT: MESSAGE --}}
                <div class="col-lg-6">
                    <div class="signup__boxes round16 text-center">

                        <div class="mb-4">
                            <i class="uil uil-check-circle text-success" style="font-size:64px;"></i>
                        </div>

                        <h3 class="title mb-3">
                            Thank You for Your Generosity!
                        </h3>

                        <p class="fz-16 title fw-400 inter mb-30">
                            Your donation has been successfully received.
                            Because of your generosity, lives will be touched and communities strengthened.
                        </p>

                        <p class="fz-16 fw-400 inter mb-40">
                            A confirmation email will be sent to you shortly.
                            Please keep it for your records.
                        </p>

                        <div class="d-flex justify-content-center gap-3">
                            <a href="{{ route('donation.index.public') }}" class="cmn--btn">
                                <span>
                                    Continue Exploring
                                </span>
                            </a>

                            <a href="{{ url('/') }}" class="cmn--btn border-btn">
                                <span>
                                    Back to Home
                                </span>
                            </a>
                        </div>

                        <p class="fz-14 text-muted mt-4">
                            <i class="uil uil-lock"></i>
                            Payments are securely processed by <strong>Stripe</strong>.
                        </p>

                    </div>
                </div>

                {{-- RIGHT: IMAGE --}}
                <div class="col-lg-6">
                    <div class="signup__thumb">
                        <img src="{{ asset('assets/frontend/img/faq/signup-thumb.png') }}" class="w-100"
                            alt="Thank you for supporting our mission">
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection


@endsection
