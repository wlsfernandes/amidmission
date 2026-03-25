<div class="wrap">
    <div class="container">
        <div class="row">

            {{-- Contact Info --}}
            <div class="col-md-6 d-flex align-items-center">
                <p class="mb-0 phone pl-md-2">

                    @if (!empty($settings->contact_phone))
                        <a href="tel:{{ $settings->contact_phone }}" class="mr-2">
                            <span class="fa fa-phone mr-1"></span>
                            {{ $settings->contact_phone ?? '' }}
                        </a>
                    @endif

                    @if (!empty($settings->contact_email))
                        <a href="mailto:{{ $settings->contact_email }}">
                            <span class="fa fa-paper-plane mr-1"></span>
                            {{ $settings->contact_email ?? '' }}
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
                                <i class="sr-only">{{ $link->label() ?? '' }}</i>
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
            {{ $settings->site_name ?? 'AMID MISSION' }}
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav">
            <span class="oi oi-menu"></span> Menu
        </button>

        <div class="collapse navbar-collapse" id="ftco-nav">
            <ul class="navbar-nav ml-auto">

                @foreach ($menuItems as $item)
                    @if ($item->children->count())
                        <li class="nav-item dropdown">
                            <a href="{{ $item->link ?: '#' }}" class="nav-link dropdown-toggle"
                                id="navbarDropdown{{ $item->id }}" role="button" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                {{ $item->title }}
                            </a>

                            <div class="dropdown-menu" aria-labelledby="navbarDropdown{{ $item->id }}">
                                @foreach ($item->children as $child)
                                    <a class="dropdown-item" href="{{ $child->link }}">
                                        {{ $child->title }}
                                    </a>
                                @endforeach
                            </div>
                        </li>
                    @else
                        <li class="nav-item {{ request()->url() == url($item->link) ? 'active' : '' }}">
                            <a href="{{ $item->link }}" class="nav-link">
                                {{ $item->title }}
                            </a>
                        </li>
                    @endif
                @endforeach
                <li class="nav-item cta"><a href="{{ url('/donate') }}" class="nav-link">@lang('home.donate')</a></li>
                {{-- Language Switcher --}}
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
