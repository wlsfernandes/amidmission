@extends('admin.layouts.master-without-nav')
@section('title')
    Register
@endsection
@section('content')
    <div class="account-pages my-5 pt-sm-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center">
                        <a href="{{ url('/') }}" class="mb-5 d-block auth-logo">
                            <img src="{{ asset('/assets/admin/images/logos/small.png') }}" alt="" height="66"
                                class="logo logo-dark">
                            <img src="{{ asset('/assets/admin/images/logo-light.png') }}" alt="" height="66"
                                class="logo logo-light">
                        </a>
                    </div>
                </div>
            </div>


            <div class="row align-items-center justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card">

                        <div class="card-body p-4">

                            <div class="text-center mt-2">
                                <h5 style="color:#4a235a">Register Account</h5>
                                <p class="text-muted">devpromaster - Capacity Building</p>
                            </div>
                            <div class="card shadow p-4 rounded-4" style="max-width: 600px;">
                                <div class="text-center">
                                    <h2 class="text-danger mb-3"><i class="bi bi-x-circle-fill"></i> Registration Closed
                                    </h2>
                                    <p class="fs-5">Thank you for your interest in the <strong>Capacity Building
                                            Project!</strong></p>
                                    <p class="text-secondary"><i class="bi bi-clock-fill text-warning"></i> Registration for
                                        this year is now closed.</p>
                                    <p>We appreciate your enthusiasm and encourage you to stay connected.</p>
                                    <p class="mt-3"><i class="bi bi-megaphone-fill text-primary"></i> Follow us at <a
                                            href="https://somosdevpromaster.org"
                                            class="text-decoration-none">https://somosdevpromaster.org</a></p>
                                    <p>to be the first to know when applications open again and to stay updated on all
                                        upcoming opportunities.</p>
                                    <p class="mt-4"><strong>We look forward to welcoming you in the next cycle!</strong>
                                    </p>
                                </div>
                            </div>
                            <!--                            <div class="p-2 mt-4">
                                                                                    <form method="POST" action="{{ route('register') }}">
                                                                                        @csrf

                                                                                        <div class="mb-3">
                                                                                            <label class="form-label" for="email">Email</label>
                                                                                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                                                                                name="email" value="{{ old('email') }}" id="email" placeholder="Enter email">
                                                                                            @error('email')
        <span class="invalid-feedback" role="alert">
                                                                                                        <strong>{{ $message }}</strong>
                                                                                                    </span>
    @enderror
                                                                                        </div>

                                                                                        <div class="mb-3">
                                                                                            <label class="form-label" for="username">Username</label>
                                                                                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                                                                name="name" value="{{ old('name') }}" id="username"
                                                                                                placeholder="Enter username">
                                                                                            @error('name')
        <span class="invalid-feedback" role="alert">
                                                                                                        <strong>{{ $message }}</strong>
                                                                                                    </span>
    @enderror
                                                                                        </div>

                                                                                        <div class="mb-3">
                                                                                            <label class="form-label" for="userpassword">Password</label>
                                                                                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                                                                                name="password" id="userpassword" placeholder="Enter password">
                                                                                            @error('password')
        <span class="invalid-feedback" role="alert">
                                                                                                        <strong>{{ $message }}</strong>
                                                                                                    </span>
    @enderror
                                                                                        </div>

                                                                                        <div class="mb-3">
                                                                                            <label class="form-label" for="password_confirmation">Confirm Password</label>
                                                                                            <input type="password"
                                                                                                class="form-control @error('password_confirmation') is-invalid @enderror"
                                                                                                name="password_confirmation" id="password_confirmation"
                                                                                                placeholder="Enter confirm password">
                                                                                            @error('password_confirmation')
        <span class="invalid-feedback" role="alert">
                                                                                                        <strong>{{ $message }}</strong>
                                                                                                    </span>
    @enderror
                                                                                        </div>


                                                                                        <div class="form-check">
                                                                                            <input type="checkbox" class="form-check-input" id="auth-terms-condition-check"
                                                                                                required>
                                                                                            <label class="form-check-label" for="auth-terms-condition-check">I accept <a
                                                                                                    href="javascript: void(0);" class="text-dark">Terms and
                                                                                                    Conditions</a></label>
                                                                                        </div>

                                                                                        <div class="mt-3 text-end">
                                                                                            <button class="btn btn-primary w-sm waves-effect waves-light"
                                                                                                style="background: linear-gradient(to right,#4a235a, #a569bd, #e8daef); border-color: #4a235a; color: #fff;"
                                                                                                type="submit">Register</button>
                                                                                        </div>



                                                                                        <div class="mt-4 text-center">
                                                                                            <p class="text-muted mb-0">Already have an account ? <a href="{{ url('login') }}"
                                                                                                    class="fw-medium text-primary"> Login</a></p>
                                                                                        </div>
                                                                                    </form>
                                                                                </div>
                                                    -->
                        </div>
                    </div>
                    <div class="mt-5 text-center">
                        <p>© devpromaster
                            <script>
                                document.write(new Date().getFullYear())
                            </script> Porque nosotros <i class="mdi mdi-heart text-danger"></i><a
                                href="https://devpromaster.org" target="_blank" class="text-reset"> devpromaster</a>
                    </div>

                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
@endsection
