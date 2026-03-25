@extends('admin.layouts.master')

@section('title', 'Settings')

@section('content')
    <div class="card border border-primary">
        <div class="card-header">
            <h5>
                <i class="fas fa-cog"></i> Site Settings
            </h5>
        </div>

        <div class="card-body">
            <x-alert />

            {{-- Helper --}}
            <div class="bg-info bg-opacity-10 text-info small p-3 rounded mb-4">
                <i class="fas fa-info-circle"></i>
                These settings control the <strong>entire website</strong>: branding,
                contact information, footer content, and default SEO.
            </div>

            <form method="POST" action="{{ route('settings.update') }}">
                @csrf
                @method('PUT')

                {{-- =======================
                Site Identity
                ======================== --}}
                <h6 class="text-primary mb-3">
                    <i class="fas fa-globe"></i> Site Identity
                </h6>

                <div class="mb-3">
                    <label class="form-label">Site Name</label>
                    <input type="text" name="site_name" class="form-control" placeholder="Example: Amid Mission"
                        value="{{ old('site_name', $setting->site_name) }}">
                    <small class="text-muted">
                        The public name of your organization or website.
                    </small>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        <i class="fas fa-image"></i> Logo
                    </label><br>
                    <a href="{{ route('admin.images.edit', ['model' => 'settings', 'id' => $setting->id]) }}"
                        class="btn btn-outline-primary btn-sm">
                        <i class="uil-image"></i> Upload Logo
                    </a>

                    @if($setting->image_url)
                        <a href="{{ route('admin.images.preview', ['model' => 'settings', 'id' => $setting->id]) }}"
                            target="_blank" class="ms-2">
                            <i class="fas fa-eye text-primary"></i>
                        </a>
                    @endif

                    <small class="text-muted d-block mt-1">
                        Appears in the website header and branding areas.
                    </small>
                </div>

                <hr>

                {{-- =======================
                Contact Information
                ======================== --}}
                <h6 class="text-primary mb-3">
                    <i class="fas fa-envelope"></i> Contact Information
                </h6>

                <div class="mb-3">
                    <label class="form-label">Contact Email</label>
                    <input type="email" name="contact_email" class="form-control" placeholder="info@example.org"
                        value="{{ old('contact_email', $setting->contact_email) }}">
                    <small class="text-muted">
                        Main email address displayed on the website.
                    </small>
                </div>

                <div class="mb-3">
                    <label class="form-label">Contact Phone</label>
                    <input type="text" name="contact_phone" class="form-control" placeholder="+1 (555) 123-4567"
                        value="{{ old('contact_phone', $setting->contact_phone) }}">
                    <small class="text-muted">
                        Optional phone number shown on contact sections.
                    </small>
                </div>

                <div class="mb-3">
                    <label class="form-label">Address</label>
                    <textarea name="address" class="form-control" rows="2"
                        placeholder="Street, city, state, country">{{ old('address', $setting->address) }}</textarea>
                    <small class="text-muted">
                        Physical or mailing address (optional).
                    </small>
                </div>

                <hr>

                {{-- =======================
                Footer
                ======================== --}}
                <h6 class="text-primary mb-3">
                    <i class="fas fa-align-center"></i> Footer
                </h6>

                <div class="mb-3">
                    <label class="form-label">Footer Text</label>
                    <textarea name="footer_text" class="form-control" rows="2"
                        placeholder="© 2025 Your Organization. All rights reserved.">
                                                                                                                        {{ old('footer_text', $setting->footer_text) }}
                                                                                                                    </textarea>
                    <small class="text-muted">
                        Text displayed at the bottom of every page.
                    </small>
                </div>

                <hr>

                {{-- =======================
                Default SEO
                ======================== --}}
                <h6 class="text-primary mb-3">
                    <i class="fas fa-search"></i> Default SEO
                </h6>

                <div class="mb-3">
                    <label class="form-label">Default SEO Title</label>
                    <input type="text" name="default_seo_title" class="form-control"
                        placeholder="Short descriptive title for search engines"
                        value="{{ old('default_seo_title', $setting->default_seo_title) }}">
                    <small class="text-muted">
                        Used by search engines when a page has no custom SEO title.
                    </small>
                </div>

                <div class="mb-3">
                    <label class="form-label">Default SEO Description</label>
                    <textarea name="default_seo_description" class="form-control" rows="3"
                        placeholder="A brief description of your organization for search engines.">
                                                                                                                        {{ old('default_seo_description', $setting->default_seo_description) }}
                                                                                                                    </textarea>
                    <small class="text-muted">
                        Appears under the title in search engine results.
                    </small>
                </div>

                <hr>

                {{-- =======================
                Actions
                ======================== --}}
                <div class="text-end">
                    <button class="btn btn-primary">
                        <i class="uil-save"></i> Save Settings
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection