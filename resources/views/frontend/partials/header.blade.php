<div class="wrap">
    <div class="container">
        <div class="row">

            {{-- Contact Info --}}
            <div class="col-md-6 d-flex align-items-center">
                <p class="mb-0 phone pl-md-2">

                    @if ($settings->contact_phone)
                        <a href="tel:{{ $settings->contact_phone }}" class="mr-2">
                            <span class="fa fa-phone mr-1"></span>
                            {{ $settings->contact_phone }}
                        </a>
                    @endif

                    @if ($settings->contact_email)
                        <a href="mailto:{{ $settings->contact_email }}">
                            <span class="fa fa-paper-plane mr-1"></span>
                            {{ $settings->contact_email }}
                        </a>
                    @endif

                </p>
            </div>

            {{-- Social Media --}}
            <div class="social-media">
                <p class="mb-0 d-flex">

                    @foreach ($socialLinks as $link)
                        <a href="{{ $link->url }}" target="_blank"
                            class="d-flex align-items-center justify-content-center" title="{{ $link->label() }}">

                            <span class="fa {{ $link->icon() }}">
                                <i class="sr-only">{{ $link->label() }}</i>
                            </span>

                        </a>
                    @endforeach

                </p>
            </div>

        </div>
    </div>
</div>

{{-- NAVBAR --}}
<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
    <div class="container">

        {{-- Logo or Site Name --}}
        <a class="navbar-brand" href="{{ url('/') }}">
            @if ($settings->image_url)
                <img src="{{ $settings->image_url }}" alt="{{ $settings->site_name }}" height="40">
            @else
                {{ $settings->site_name ?? 'AmidMission' }}
            @endif
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav">
            <span class="oi oi-menu"></span> Menu
        </button>

        <div class="collapse navbar-collapse" id="ftco-nav">
            <ul class="navbar-nav ml-auto">

                <li class="nav-item active">
                    <a href="{{ url('/') }}" class="nav-link">Home</a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('/about') }}" class="nav-link">@lang('home.about')</a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('/missions') }}" class="nav-link">@lang('home.missions')</a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('/blog') }}" class="nav-link">@lang('home.blog')</a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('/contact') }}" class="nav-link">@lang('home.contact')</a>
                </li>

                {{-- CTA --}}
                <li class="nav-item cta">
                    <a href="{{ url('/donate') }}" class="nav-link">@lang('home.donate')</a>
                </li>
                <li class="nav-item lang-switcher d-flex align-items-center">
                    <a href="{{ url('/lang/en') }}" class="{{ app()->getLocale() === 'en' ? 'active' : '' }}">
                        <img src="{{ asset('/assets/admin/images/flags/us.jpg') }}" height="16">
                    </a>

                    <a href="{{ url('/lang/es') }}" class="{{ app()->getLocale() === 'es' ? 'active' : '' }}">
                        <img src="{{ asset('/assets/admin/images/flags/spain.jpg') }}" height="16">
                    </a>

                    <a href="{{ url('/lang/pt') }}" class="{{ app()->getLocale() === 'pt' ? 'active' : '' }}">
                        <img src="{{ asset('/assets/admin/images/flags/brazil.jpg') }}" height="16">
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
