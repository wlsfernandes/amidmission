<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box" style="margin-top:25px;">
                <a href="{{url('index')}}" class="logo logo-dark">
                    <span class="logo-sm">
                       <img src="{{ asset('/assets/admin/images/passion2plant.webp') }}" alt="" height="60">
                    </span>
                    <span class="logo-lg">
                           <img src="{{ asset('/assets/admin/images/passion2plant.webp') }}" alt="" height="60">
                    </span>
                </a>

                <a href="{{url('index')}}" class="logo logo-light">
                    <span class="logo-sm">
                          <img src="{{ asset('/assets/admin/images/passion2plant.webp') }}" alt="" height="60">
                    </span>
                    <span class="logo-lg">
                          <img src="{{ asset('/assets/admin/images/passion2plant.webp') }}" alt="" height="60">
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>

           
        </div>

        <div class="d-flex">
            <div class="dropdown d-inline-block language-switch">
                <button type="button" class="btn header-item waves-effect" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    @switch(Session::get('lang'))
                    @case('ru')
                    <img src="{{ asset('/assets/admin/images/flags/russia.jpg')}}" alt="Header Language" height="16"> <span class="align-middle"></span>
                    @break
                    @case('it')
                    <img src="{{ asset('/assets/admin/images/flags/italy.jpg')}}" alt="Header Language" height="16"> <span class="align-middle"></span>
                    @break
                    @case('de')
                    <img src="{{ asset('/assets/admin/images/flags/germany.jpg')}}" alt="Header Language" height="16"> <span class="align-middle"></span>
                    @break
                    @case('es')
                    <img src="{{ asset('/assets/admin/images/flags/spain.jpg')}}" alt="Header Language" height="16"> <span class="align-middle"></span>
                    @break
                    @default
                    <img src="{{ asset('/assets/admin/images/flags/us.jpg')}}" alt="Header Language" height="16"> <span class="align-middle"></span>
                    @endswitch
                </button>
                <div class="dropdown-menu dropdown-menu-end">

                    <!-- item-->
                    <a href="{{ url('index/en') }}" class="dropdown-item notify-item">
                        <img src="{{ asset('/assets/admin/images/flags/us.jpg')}}" alt="user-image" class="me-1" height="12"> <span class="align-middle">English</span>
                    </a>

                    <!-- item-->
                    <a href="{{ url('index/es') }}" class="dropdown-item notify-item">
                        <img src="{{ asset('/assets/admin/images/flags/spain.jpg')}}" alt="user-image" class="me-1" height="12"> <span class="align-middle">Spanish</span>
                    </a>

                    <!-- item-->
                    <a href="{{ url('index/de') }}" class="dropdown-item notify-item">
                        <img src="{{ asset('/assets/admin/images/flags/germany.jpg')}}" alt="user-image" class="me-1" height="12"> <span class="align-middle">German</span>
                    </a>

                    <!-- item-->
                    <a href="{{ url('index/it') }}" class="dropdown-item notify-item">
                        <img src="{{ asset('/assets/admin/images/flags/italy.jpg')}}" alt="user-image" class="me-1" height="12"> <span class="align-middle">Italian</span>
                    </a>

                    <!-- item-->
                    <a href="{{ url('index/ru') }}" class="dropdown-item notify-item">
                        <img src="{{ asset('/assets/admin/images/flags/russia.jpg')}}" alt="user-image" class="me-1" height="12"> <span class="align-middle">Russian</span>
                    </a>
                </div>
            </div>
            <div class="dropdown d-inline-block">
              
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="{{ asset('/assets/admin/images/users/user.png') }}" alt="Header Avatar">
                    <span class="d-none d-xl-inline-block ms-1 fw-medium font-size-15">
                    {{Auth::user() ? Str::ucfirst(Auth::user()->name) : ''}}</span>
                    <i class="uil-angle-down d-none d-xl-inline-block font-size-15"></i>
                </button>
            
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <a class="dropdown-item" href="profile"><i class="uil uil-user-circle font-size-18 align-middle text-muted me-1"></i> <span class="align-middle">Profile</span></a>
                    <a class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="uil uil-sign-out-alt font-size-18 align-middle me-1 text-muted"></i> <span class="align-middle">Sign_out</span></a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
               
                </div>
            </div>
            <!--
            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon right-bar-toggle waves-effect">
                    <i class="uil-cog"></i>
                </button>
            </div>
        -->
        </div>
    </div>
</header>