<section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="wrapper">

                    {{-- CONTACT INFO --}}
                    <div class="row mb-5">

                        {{-- ADDRESS --}}
                        <div class="col-md-3">
                            <div class="dbox w-100 text-center">
                                <div class="icon bg-primary d-flex align-items-center justify-content-center">
                                    <span class="fa fa-map-marker"></span>
                                </div>
                                <div class="text">
                                    <p>
                                        <span>@lang('pages.address'):</span>
                                        {{ $settings->address ?? '-' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- PHONE --}}
                        <div class="col-md-3">
                            <div class="dbox w-100 text-center">
                                <div class="icon bg-secondary d-flex align-items-center justify-content-center">
                                    <span class="fa fa-phone"></span>
                                </div>
                                <div class="text">
                                    <p>
                                        <span>@lang('pages.phone'):</span>
                                        <a href="tel:{{ $settings->contact_phone }}">
                                            {{ $settings->contact_phone ?? '-' }}
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- EMAIL --}}
                        <div class="col-md-3">
                            <div class="dbox w-100 text-center">
                                <div class="icon bg-tertiary d-flex align-items-center justify-content-center">
                                    <span class="fa fa-paper-plane"></span>
                                </div>
                                <div class="text">
                                    <p>
                                        <span>@lang('pages.email'):</span>
                                        <a href="mailto:{{ $settings->contact_email }}">
                                            {{ $settings->contact_email ?? '-' }}
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- WEBSITE --}}
                        <div class="col-md-3">
                            <div class="dbox w-100 text-center">
                                <div class="icon bg-quarternary d-flex align-items-center justify-content-center">
                                    <span class="fa fa-globe"></span>
                                </div>
                                <div class="text">
                                    <p>
                                        <span>@lang('pages.website'):</span>
                                        <a href="{{ url('/') }}">
                                            {{ $settings->site_name ?? config('app.name') }}
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- FORM --}}
                    <div class="row no-gutters">
                        <div class="col-md-7">
                            <div class="contact-wrap w-100 p-md-5 p-4">

                                <h3 class="mb-4">@lang('pages.contact_us')</h3>

                                <form method="POST" action="{{ route('contact.send') }}" class="contactForm">
                                    @csrf

                                    <div class="row">

                                        {{-- NAME --}}
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="label">@lang('pages.full_name')</label>
                                                <input type="text" name="name" class="form-control"
                                                    placeholder="@lang('pages.your_name')">
                                            </div>
                                        </div>

                                        {{-- EMAIL --}}
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="label">@lang('pages.email')</label>
                                                <input type="email" name="email" class="form-control"
                                                    placeholder="@lang('pages.your_email')">
                                            </div>
                                        </div>

                                        {{-- SUBJECT --}}
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="label">@lang('pages.subject')</label>
                                                <input type="text" name="subject" class="form-control"
                                                    placeholder="@lang('pages.subject')">
                                            </div>
                                        </div>

                                        {{-- MESSAGE --}}
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="label">@lang('pages.message')</label>
                                                <textarea name="message" class="form-control" rows="4" placeholder="@lang('pages.your_message')"></textarea>
                                            </div>
                                        </div>

                                        {{-- BUTTON --}}
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary">
                                                    @lang('pages.send_message')
                                                </button>
                                            </div>
                                        </div>

                                    </div>
                                </form>

                            </div>
                        </div>

                        {{-- IMAGE --}}
                        <div class="col-md-5 d-flex align-items-stretch">
                            <div class="info-wrap w-100 p-5 img"
                                style="background-image: url('{{ asset('assets/frontend/images/about-3.jpg') }}');">
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            {{-- MAP --}}
            <div class="col-md-12">
                <div id="map" class="map"></div>
            </div>

        </div>
    </div>
</section>
