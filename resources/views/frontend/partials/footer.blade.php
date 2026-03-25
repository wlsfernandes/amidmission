<footer class="footer">
    <div class="container">
        <div class="row">

            {{-- ABOUT / BRAND --}}
            <div class="col-md-6 col-lg-3 mb-4 mb-md-0">
                <h2 class="footer-heading">
                    {{ $settings->site_name ?? 'AmidMission' }}
                </h2>

                <p>
                    {{ $settings->footer_text ?? 'Preaching the Gospel. Equipping leaders. Reaching nations.' }}
                </p>

                {{-- Social Links --}}
                <ul class="ftco-footer-social p-0">
                    @foreach ($socialLinks as $link)
                        <li class="ftco-animate">
                            <a href="{{ $link->url }}" target="_blank" title="{{ $link->label() }}">
                                <span class="fa {{ $link->icon() }}"></span>
                            </a>
                        </li>
                    @endforeach
                </ul>

                {{-- CTA --}}
                <p>
                    <a href="{{ url('/donate') }}" class="btn btn-quarternary">
                        Donate Now
                    </a>
                </p>
            </div>

            {{-- LATEST NEWS (Optional Dynamic Later) --}}
            <div class="col-md-6 col-lg-3 mb-4 mb-md-0">
                <h2 class="footer-heading">Latest News</h2>

                {{-- You can later loop posts here --}}
                <p class="text-muted small">
                    Stay connected with our latest mission updates and gospel outreach across nations.
                </p>
            </div>

            {{-- QUICK LINKS --}}
            <div class="col-md-6 col-lg-3 pl-lg-5 mb-4 mb-md-0">
                <h2 class="footer-heading">Quick Links</h2>

                <ul class="list-unstyled">
                    <li><a href="{{ url('/') }}" class="py-2 d-block">Home</a></li>
                    <li><a href="{{ url('/about') }}" class="py-2 d-block">About</a></li>
                    <li><a href="{{ url('/missions') }}" class="py-2 d-block">Missions</a></li>
                    <li><a href="{{ url('/blog') }}" class="py-2 d-block">Blog</a></li>
                    <li><a href="{{ url('/contact') }}" class="py-2 d-block">Contact</a></li>
                </ul>
            </div>

            {{-- CONTACT --}}
            <div class="col-md-6 col-lg-3 mb-4 mb-md-0">
                <h2 class="footer-heading">Have a Question?</h2>

                <div class="block-23 mb-3">
                    <ul>

                        @if ($settings->address)
                            <li>
                                <span class="icon fa fa-map"></span>
                                <span class="text">{{ $settings->address }}</span>
                            </li>
                        @endif

                        @if ($settings->contact_phone)
                            <li>
                                <a href="tel:{{ $settings->contact_phone }}">
                                    <span class="icon fa fa-phone"></span>
                                    <span class="text">{{ $settings->contact_phone }}</span>
                                </a>
                            </li>
                        @endif

                        @if ($settings->contact_email)
                            <li>
                                <a href="mailto:{{ $settings->contact_email }}">
                                    <span class="icon fa fa-paper-plane"></span>
                                    <span class="text">{{ $settings->contact_email }}</span>
                                </a>
                            </li>
                        @endif

                    </ul>
                </div>
            </div>

        </div>

        {{-- COPYRIGHT --}}
        <div class="row mt-5">
            <div class="col-md-12 text-center">

                <p class="copyright">
                    &copy;
                    <script>
                        document.write(new Date().getFullYear());
                    </script>
                    {{ $settings->site_name ?? 'AmidMission' }}.
                    All rights reserved.
                </p>

            </div>
        </div>
    </div>
</footer>
