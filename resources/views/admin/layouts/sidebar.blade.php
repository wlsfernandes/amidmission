<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    {{-- LOGO --}}
    <div class="navbar-brand-box">

        <a href="{{ url('/') }}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ asset('/assets/admin/images/passion2plant.webp') }}" height="60">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('/assets/admin/images/passion2plant.webp') }}" height="60">
            </span>
        </a>

        <a href="{{ url('/') }}" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ asset('/assets/admin/images/passion2plant.webp') }}" height="60">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('/assets/admin/images/passion2plant.webp') }}" height="60">
            </span>
        </a>

    </div>

    {{-- Toggle --}}
    <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect vertical-menu-btn">
        <i class="fa fa-bars"></i>
    </button>

    <div data-simplebar class="sidebar-menu-scroll">

        <div id="sidebar-menu">

            <ul class="metismenu list-unstyled" id="side-menu">

                {{-- WEBSITE --}}
                @can('access-website-admin')
                    <li>
                        <a href="#" class="has-arrow waves-effect">
                            <i class="dripicons-browser"></i>
                            <span>Website</span>
                        </a>

                        <ul class="sub-menu">
                            <li>
                                <a href="{{ route('pages.index') }}">
                                    <i class="uil uil-parking-square"></i> Pages
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('menus.index') }}">
                                    <i class="uil uil-bars"></i> Menus
                                </a>
                            </li>


                            {{-- FEATURES --}}
                            <li>
                                <a href="#" class="has-arrow waves-effect">
                                    <i class="fas fa-puzzle-piece"></i>
                                    <span>Features</span>
                                </a>

                                <ul class="sub-menu">
                                    <li>
                                        <a href="{{ route('blogs.index') }}">
                                            <i class="uil-blogger-alt"></i> Blog
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('donations.index') }}">
                                            <i class="uil uil-heart"></i> Donate
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('events.index') }}">
                                            <i class="uil uil-ticket"></i> Events
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('media.index') }}">
                                            <i class="uil uil-play-circle"></i> Media
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('partners.index') }}">
                                            <i class="uil uil-users-alt"></i> Partnerships
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('positions.index') }}">
                                            <i class="uil uil-briefcase"></i> Positions
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('resources.index') }}">
                                            <i class="fas fa-folder-open"></i> Resources
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('services.index') }}">
                                            <i class="uil uil-briefcase"></i> Services
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('testimonials.index') }}">
                                            <i class="uil uil-comment-dots"></i> Testimonials
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('teams.index') }}">
                                            <i class="fas fa-users"></i> Team
                                        </a>
                                    </li>


                                </ul>
                            </li>

                            {{-- Configuration --}}
                            <li>
                                <a href="#" class="has-arrow waves-effect">
                                    <i class="fas fa-cog"></i>
                                    <span>Configuration</span>
                                </a>

                                <ul class="sub-menu">

                                    <li>
                                        <a href="{{ route('media-types.index') }}">
                                            <i class="uil uil-layer-group"></i> Media Types
                                        </a>
                                    </li>

                                    <li>
                                        <a href="{{ route('settings.index') }}">
                                            <i class="fas fa-cog"></i> Site Settings
                                        </a>
                                    </li>

                                    <li>
                                        <a href="{{ route('social-links.index') }}">
                                            <i class="fas fa-share-alt"></i> Social Media
                                        </a>
                                    </li>

                                </ul>
                            </li>

                        </ul>
                    </li>

                    {{-- STORE --}}
                    <li>
                        <a href="#" class="has-arrow waves-effect">
                            <i class="uil uil-store"></i>
                            <span>Store</span>
                        </a>

                        <ul class="sub-menu">

                            <li class="menu-title">Catalog</li>

                            <li>
                                <a href="{{ route('donations.index') }}">
                                    <i class="uil uil-heart"></i> Donations
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('products.index') }}">
                                    <i class="uil uil-box"></i> Products
                                </a>
                            </li>

                            <li class="menu-title">Sales</li>

                            <li>
                                <a href="{{ route('orders.index') }}">
                                    <i class="uil uil-box"></i> Orders
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('admin.payments.index') }}">
                                    <i class="uil uil-credit-card"></i> Payments
                                </a>
                            </li>

                        </ul>
                    </li>
                @endcan


                {{-- ADMINISTRATION --}}
                @can('access-admin')
                    <li>
                        <a href="#" class="has-arrow waves-effect">
                            <i class="uil-setting"></i>
                            <span>Administration</span>
                        </a>

                        <ul class="sub-menu">

                            <li>
                                <a href="{{ route('users.index') }}">
                                    <i class="uil-chat-bubble-user"></i> Users
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('roles.index') }}">
                                    <i class="uil-users-alt"></i> Roles
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('audits.index') }}">
                                    <i class="uil-history"></i> Audit Trail
                                </a>
                            </li>

                            <li>
                                <a href="{{ url('system-logs') }}">
                                    <i class="uil uil-bug"></i> System Logs
                                </a>
                            </li>

                        </ul>
                    </li>
                @endcan

            </ul>

        </div>
    </div>
</div>
<!-- Left Sidebar End -->
