@extends('frontend.layouts.app')

@section('title', __('pages.donations') . ' | Amid Mission')

@section('content')

    <section class="hero-wrap">
        <div class="slider-item" style="background-image: url('https://amidmission.com/images/banners/4/preview');">

            <div class="overlay-1"></div>
            <div class="overlay-2"></div>
            <div class="overlay-3"></div>
            <div class="overlay-4"></div>

            <div class="container">
                <div class="row no-gutters slider-text align-items-center">
                    <div class="col-md-10 col-lg-7 ftco-animate">

                        <div class="text w-100">
                            <span class="subheading">
                                @lang('pages.donation_page_title')
                            </span>

                            <h1 class="mb-4">
                                @lang('pages.donate_now')
                            </h1>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- Donation Section -->
    <section class="service__section section__bg pt-130 pb-130 overhid">
        <div class="container">

            <div class="row justify-content-center">
                <div class="col-xl-7 col-lg-8 col-md-10">

                    <div class="service__items text-start p-4 p-md-5">

                        <!-- Donation Icon -->
                        <div class="text-center mb-4">

                            <h4 class="mt-3 mb-2">
                                @lang('pages.make_donation')
                            </h4>

                            <p class="text-muted mb-0">
                                @lang('pages.choose_amount')
                            </p>
                        </div>


                        @if (session('error'))
                            <div class="alert alert-danger mb-4">
                                {{ session('error') }}
                            </div>
                        @endif


                        <form id="donation-form" method="POST" action="{{ route('donations.paypal.checkout') }}">
                            @csrf

                            <div class="row g-4">

                                <!-- Suggested Amounts -->
                                <div class="col-12">
                                    <label class="form-label fw-semibold mb-3">
                                        @lang('pages.select_an_amount')
                                    </label>

                                    <div class="row g-2">

                                        @foreach ([25, 50, 100, 250] as $suggestedAmount)
                                            <div class="col-6 col-sm-3">
                                                <button type="button"
                                                    class="btn btn-outline-success w-100 py-2 donation-amount-button"
                                                    data-amount="{{ $suggestedAmount }}">
                                                    ${{ $suggestedAmount }}
                                                </button>
                                            </div>
                                        @endforeach

                                    </div>
                                </div>


                                <!-- Custom Amount -->
                                <div class="col-12">
                                    <label for="amount" class="form-label fw-semibold">
                                        @lang('pages.donation_amount')
                                    </label>

                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text">
                                            $
                                        </span>

                                        <input type="number" id="amount" name="amount"
                                            class="form-control @error('amount') is-invalid @enderror"
                                            value="{{ old('amount') }}" min="1" step="0.01"
                                            placeholder="@lang('pages.donation_amount_placeholder')" required>

                                        @error('amount')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>


                                <!-- First Name -->
                                <div class="col-md-6">
                                    <label for="first_name" class="form-label fw-semibold">
                                        @lang('pages.first_name')
                                    </label>

                                    <input type="text" id="first_name" name="first_name"
                                        class="form-control form-control-lg @error('first_name') is-invalid @enderror"
                                        value="{{ old('first_name') }}" autocomplete="given-name" required>

                                    @error('first_name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>


                                <!-- Last Name -->
                                <div class="col-md-6">
                                    <label for="last_name" class="form-label fw-semibold">
                                        @lang('pages.last_name')
                                    </label>

                                    <input type="text" id="last_name" name="last_name"
                                        class="form-control form-control-lg @error('last_name') is-invalid @enderror"
                                        value="{{ old('last_name') }}" autocomplete="family-name" required>

                                    @error('last_name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>


                                <!-- Email -->
                                <div class="col-12">
                                    <label for="email" class="form-label fw-semibold">
                                        @lang('pages.email')
                                    </label>

                                    <input type="email" id="email" name="email"
                                        class="form-control form-control-lg @error('email') is-invalid @enderror"
                                        value="{{ old('email') }}" autocomplete="email" required>

                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>


                                <!-- Optional Message -->
                                <div class="col-12">
                                    <label for="message" class="form-label fw-semibold">
                                        @lang('pages.message')
                                        <span class="fw-normal text-muted">
                                            (@lang('pages.optional'))
                                        </span>
                                    </label>

                                    <textarea id="message" name="message" class="form-control @error('message') is-invalid @enderror" rows="4"
                                        placeholder="@lang('pages.leave_an_optional_message')">{{ old('message') }}</textarea>

                                    @error('message')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>


                                <!-- PayPal Buttons -->
                                <div class="col-12">
                                    <hr class="my-3">
                                    <div id="paypal-button-container"></div>
                                    <p class="text-center text-muted small mt-3 mb-0">
                                        <i class="fa-solid fa-lock me-1"></i>
                                        Secure payment via PayPal &mdash; no account required
                                    </p>
                                </div>

                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- Donation Section End -->

@endsection


@push('scripts')
    {{-- PayPal JS SDK --}}
    <script
        src="https://www.paypal.com/sdk/js?client-id={{ config('services.paypal.client_id') }}&currency={{ config('services.paypal.currency', 'USD') }}&intent=capture">
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            /* ── Amount preset buttons ──────────────────────────────── */
            const amountInput = document.getElementById('amount');
            const amountButtons = document.querySelectorAll('.donation-amount-button');

            amountButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    amountInput.value = this.dataset.amount;
                    amountButtons.forEach(function(item) {
                        item.classList.remove('btn-success');
                        item.classList.add('btn-outline-success');
                    });
                    this.classList.remove('btn-outline-success');
                    this.classList.add('btn-success');
                    amountInput.focus();
                });
            });

            amountInput.addEventListener('input', function() {
                amountButtons.forEach(function(button) {
                    var isSelected = Number(button.dataset.amount) === Number(amountInput.value);
                    button.classList.toggle('btn-success', isSelected);
                    button.classList.toggle('btn-outline-success', !isSelected);
                });
            });

            /* ── PayPal buttons ─────────────────────────────────────── */
            var donationForm = document.getElementById('donation-form');
            var donationAmount = 0;

            paypal.Buttons({
                style: {
                    layout: 'vertical',
                    color: 'gold',
                    shape: 'rect',
                    label: 'donate',
                },

                // Step 1 — block popup if required fields are empty
                onClick: function(data, actions) {
                    if (!donationForm.checkValidity()) {
                        donationForm.reportValidity();
                        return actions.reject();
                    }
                    return actions.resolve();
                },

                // Step 2 — validate server-side then open the PayPal order
                createOrder: function(data, actions) {
                    donationAmount = parseFloat(amountInput.value);

                    return fetch('{{ route('donations.paypal.checkout') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .content,
                            },
                            body: JSON.stringify({
                                first_name: document.getElementById('first_name').value,
                                last_name: document.getElementById('last_name').value,
                                email: document.getElementById('email').value,
                                amount: donationAmount,
                                message: document.getElementById('message').value,
                            }),
                        })
                        .then(function(response) {
                            if (!response.ok) {
                                return response.json().then(function(d) {
                                    var msg =
                                        'Please check your information and try again.';
                                    if (d.errors) {
                                        msg = Object.values(d.errors).flat().join('\n');
                                    }
                                    alert(msg);
                                    throw new Error('validation_failed');
                                });
                            }
                            return response.json();
                        })
                        .then(function(res) {
                            if (!res.ok) {
                                throw new Error('checkout_failed');
                            }

                            return actions.order.create({
                                purchase_units: [{
                                    amount: {
                                        value: donationAmount.toFixed(2),
                                        currency_code: '{{ config('services.paypal.currency', 'USD') }}',
                                    },
                                    description: 'Amid Mission Donation',
                                }],
                            });
                        });
                },

                // Step 3 — capture and record the payment
                onApprove: function(data, actions) {
                    return actions.order.capture().then(function() {
                            return fetch('{{ route('donations.paypal.complete') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector(
                                        'meta[name="csrf-token"]').content,
                                },
                                body: JSON.stringify({
                                    paypal_order_id: data.orderID
                                }),
                            });
                        })
                        .then(function(r) {
                            return r.json();
                        })
                        .then(function(res) {
                            if (res.redirect) {
                                window.location.href = res.redirect;
                            }
                        });
                },

                onError: function(err) {
                    if (err && err.message !== 'validation_failed' && err.message !==
                        'checkout_failed') {
                        console.error('PayPal error:', err);
                        alert('PayPal encountered an error. Please try again.');
                    }
                },
            }).render('#paypal-button-container');

        });
    </script>
@endpush
