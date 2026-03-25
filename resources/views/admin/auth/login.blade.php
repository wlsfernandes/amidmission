@extends('frontend.layouts.app')

@section('title', __('auth.sign_in'))

@section('content')

    <section class="ftco-section bg-light">
        <div class="container">
            <div class="row justify-content-center align-items-center">

                {{-- LOGIN FORM --}}
                <div class="col-md-6">
                    <div class="bg-white p-5 shadow-sm rounded">

                        <h3 class="mb-3 text-center">
                            {{ __('auth.welcome_back') }}
                        </h3>

                        <p class="text-center mb-4">
                            {{ __('auth.signin_subtitle') }}
                        </p>

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            {{-- EMAIL --}}
                            <div class="form-group mb-3">
                                <label>{{ __('auth.email_label') }}</label>

                                <input type="email" name="email" value="{{ old('email') }}"
                                    class="form-control @error('email') is-invalid @enderror"
                                    placeholder="{{ __('auth.email_placeholder') }}" required autofocus>

                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- PASSWORD --}}
                            <div class="form-group mb-3">
                                <label>{{ __('auth.password_label') }}</label>

                                <input type="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="{{ __('auth.password_placeholder') }}" required>

                                @error('password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- REMEMBER + FORGOT --}}
                            <div class="d-flex justify-content-between align-items-center mb-3">

                                <div>
                                    <input type="checkbox" name="remember" id="remember">
                                    <label for="remember" class="mb-0">
                                        {{ __('auth.remember_me') }}
                                    </label>
                                </div>

                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}">
                                        {{ __('auth.forgot_password') }}
                                    </a>
                                @endif

                            </div>

                            {{-- SUBMIT --}}
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary w-100">
                                    {{ __('auth.sign_in') }}
                                </button>
                            </div>

                            {{-- REGISTER --}}
                            <div class="text-center mt-3">
                                <p>
                                    {{ __('auth.no_account') }}
                                    <a href="{{ route('register') }}">
                                        {{ __('auth.signup') }}
                                    </a>
                                </p>
                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection
