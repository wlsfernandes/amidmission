@extends('admin.layouts.master')

@section('title', 'Site Settings')
@section('css')
  <link href="{{ asset('/assets/admin/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
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
                <strong>Site-wide configuration:</strong><br>
                These settings apply to the entire website, including branding,
                contact information, footer text, and default SEO.
            </div>

            <form method="POST" action="{{ route('settings.update') }}">
                @csrf
                @method('PUT')

                {{-- =======================
                Site Identity
                ======================== --}}
                <h6 class="text-primary mb-3">Site Identity</h6>

                <div class="mb-3">
                    <input type="text" name="site_name" class="form-control" placeholder="Site name"
                        value="{{ old('site_name', $setting->site_name) }}">
                </div>

                <div class="row mb-3">
                    {{-- Logo --}}
                    <div class="col-md-6">
                        <label class="form-label">Logo</label>
                        <div class="d-flex align-items-center gap-3">
                            <a href="{{ route('admin.images.edit', ['model' => 'settings', 'id' => $setting->id]) }}"
                                class="btn btn-outline-primary btn-sm">
                                <i class="uil-image"></i> Upload Logo
                            </a>

                            @if($setting->image_url)
                                <a href="{{ route('admin.images.preview', ['model' => 'settings', 'id' => $setting->id]) }}"
                                    target="_blank">
                                    <i class="fas fa-eye text-primary"></i>
                                </a>
                            @endif
                        </div>
                        <small class="text-muted">
                            Used in the header and branding areas.
                        </small>
                    </div>

                    {{-- Favicon --}}
                    <div class="col-md-6">
                        <label class="form-label">Favicon</label>
                        <div class="d-flex align-items-center gap-3">
                            <a href="{{ route('admin.images.edit', ['model' => 'settings', 'id' => $setting->id, 'type' => 'favicon']) }}"
                                class="btn btn-outline-primary btn-sm">
                                <i class="uil-image"></i> Upload Favicon
                            </a>
                        </div>
                        <small class="text-muted">
                            Small icon shown in browser tabs.
                        </small>
                    </div>
                </div>

                <hr>

                {{-- =======================
                Contact Information
                ======================== --}}
                <h6 class="text-primary mb-3">Contact Information</h6>

                <div class="mb-3">
                    <input type="email" name="contact_email" class="form-control" placeholder="Contact email"
                        value="{{ old('contact_email', $setting->contact_email) }}">
                </div>

                <div class="mb-3">
                    <input type="text" name="contact_phone" class="form-control" placeholder="Contact phone"
                        value="{{ old('contact_phone', $setting->contact_phone) }}">
                </div>

                <div class="mb-3">
                    <textarea name="address" class="form-control" rows="2"
                        placeholder="Address">{{ old('address', $setting->address) }}</textarea>
                </div>

                <hr>

                {{-- =======================
                Footer
                ======================== --}}
                <h6 class="text-primary mb-3">Footer</h6>

                <div class="mb-3">
                    <textarea name="footer_text" class="form-control" rows="2"
                        placeholder="Footer text">{{ old('footer_text', $setting->footer_text) }}</textarea>
                    <small class="text-muted">
                        Appears at the bottom of every page.
                    </small>
                </div>

                <hr>

                {{-- =======================
                Default SEO
                ======================== --}}
                <h6 class="text-primary mb-3">Default SEO</h6>

                <div class="mb-3">
                    <input type="text" name="default_seo_title" class="form-control" placeholder="Default SEO title"
                        value="{{ old('default_seo_title', $setting->default_seo_title) }}">
                </div>

                <div class="mb-3">
                    <textarea name="default_seo_description" class="form-control" rows="3"
                        placeholder="Default SEO description">{{ old('default_seo_description', $setting->default_seo_description) }}</textarea>
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
@section('script')
    <script src="{{ asset('/assets/admin/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('/assets/admin/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('/assets/admin/libs/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('/assets/admin/js/pages/datatables.init.js') }}"></script>
@endsection