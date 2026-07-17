@extends('frontend.layouts.app')

@section('title', 'Checkout' . ' | Amid Mission')

@section('content')
    <section class="signup__section pt-130 pb-130">
        <div class="container">
            <div class="row justify-content-center align-items-center g-5">

                {{-- LEFT: CHECKOUT FORM --}}
                <div class="col-lg-6">
                    <div class="signup__boxes round16">

                        <h3 class="title mb-3">
                            Support This Mission
                        </h3>

                        <p class="fz-16 title fw-400 inter mb-40">
                            Your generosity helps us continue the work God has entrusted to us.
                        </p>

                        <form method="POST" action="{{ route('donations.start', $donation) }}" class="write__review">
                            @csrf

                            <div class="row g-4">

                                <div class="col-lg-12">
                                    <div class="frm__grp">
                                        <label class="fz-18 fw-500 inter title mb-3">Donation Amount</label>
                                        <input type="number" name="amount" min="1" step="1"
                                            value="{{ $amount ?? $donation->suggested_amount }}" required
                                            placeholder="Enter Amount">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="frm__grp">
                                        <label class="fz-18 fw-500 inter title mb-3">First Name</label>
                                        <input type="text" name="first_name" required>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="frm__grp">
                                        <label class="fz-18 fw-500 inter title mb-3">Last Name</label>
                                        <input type="text" name="last_name" required>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="frm__grp">
                                        <label class="fz-18 fw-500 inter title mb-3">Email</label>
                                        <input type="email" name="email" required>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="frm__grp">
                                        <label class="fz-18 fw-500 inter title mb-3">Country</label>
                                        <input type="text" name="country" placeholder="Country">
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="frm__grp">
                                        <label class="fz-18 fw-500 inter title mb-3">Address</label>
                                        <input type="text" name="address" required>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <button type="submit" class="cmn--btn w-100">
                                        <span>
                                            <i class="uil uil-heart"></i> Give Securely
                                        </span>
                                    </button>

                                    <p class="fz-14 fw-400 text-center mt-3 text-muted">
                                        <i class="uil uil-lock"></i>
                                        Secure payment powered by <strong>Stripe</strong>.
                                    </p>
                                </div>

                            </div>
                        </form>

                    </div>
                </div>

                {{-- RIGHT: IMAGE --}}
                <div class="col-lg-6">
                    <div class="signup__thumb">
                        <img src="{{ asset('assets/frontend/img/faq/signup-thumb.png') }}" class="w-100"
                            alt="Secure Donation">
                    </div>
                </div>

            </div>
        </div>
    </section>


@endsection
