@extends('frontend.layouts.app')

@section('title', 'Services')

@section('content')

<section class="signup__section pt-130 pb-130">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <!-- FORM -->
            <div class="col-lg-6">
                <div class="signup__boxes round16">
    <h3 class="title mb-3">
        {{ __('auth.welcome_back') }}
    </h3>

    <p class="fz-16 title fw-400 inter mb-4">
        {{ __('auth.signin_subtitle') }}
    </p>

    <form method="POST" action="{{ route('login') }}" class="write__review">
        @csrf

        <div class="row g-4">
            {{-- EMAIL --}}
            <div class="col-lg-12">
                <div class="frm__grp">
                    <label for="email" class="fz-18 fw-500 inter title mb-3">
                        {{ __('auth.email_label') }}
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="{{ __('auth.email_placeholder') }}"
                        class="@error('email') is-invalid @enderror"
                        required
                        autofocus
                    >

                    @error('email')
                        <span class="text-danger fz-14">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
            </div>

            {{-- PASSWORD --}}
            <div class="col-lg-12">
                <div class="frm__grp">
                    <label for="password" class="fz-18 fw-500 inter title mb-3">
                        {{ __('auth.password_label') }}
                    </label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="{{ __('auth.password_placeholder') }}"
                        class="@error('password') is-invalid @enderror"
                        required
                    >

                    @error('password')
                        <span class="text-danger fz-14">
                            {{ $message }}
                        </span>
                    @enderror

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                           class="base fz-14 inter d-flex justify-content-end mt-2">
                            {{ __('auth.forgot_password') }}
                        </a>
                    @endif
                </div>
            </div>

            {{-- REGISTER LINK --}}
            <p class="fz-16 fw-400 title inter">
                {{ __('auth.no_account') }}
                <a href="{{ route('register') }}" class="base">
                    {{ __('auth.signup') }}
                </a>
            </p>

            {{-- SUBMIT --}}
            <div class="col-lg-6">
                <div class="frm__grp">
                    <button type="submit" class="cmn--btn">
                        <span>{{ __('auth.sign_in') }}</span>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

            </div>

            <!-- IMAGE -->
            <div class="col-lg-6">
                <div class="signup__thumb">
                    <img src="{{ asset('/assets/frontend/img/faq/signup-thumb.png') }}" class="w-100" alt="Login">
                </div>
            </div>
        </div>
    </div>
</section>


@endsection