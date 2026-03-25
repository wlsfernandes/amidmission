@extends('admin.layouts.master')

@section('title', isset($partner) ? 'Edit Partner' : 'Create Partner')

@section('content')
    <div class="card border border-primary">
        <div class="card-header">
            <h5>
                <i class="fas fa-handshake"></i>
                {{ isset($partner) ? 'Edit Partner' : 'Create Partner' }}
            </h5>
        </div>

        <div class="card-body">
            <x-alert />

            {{-- Helper block --}}
            <div class="bg-info bg-opacity-10 text-info small p-3 rounded mb-4">
                <span class="text-primary fw-semibold">How to manage partners:</span><br>
                • Add a <span class="text-dark">partner name</span> for internal reference (optional).<br>
                • Upload the <span class="text-dark">partner logo</span> using the image icon on the list page.<br>
                • Provide an <span class="text-dark">external link</span> to redirect users to the partner’s website.<br>
                • Use the <span class="text-success">Publish switch</span> to control visibility on the public site.
            </div>

            <hr />

            <form method="POST"
                  action="{{ isset($partner) ? route('partners.update', $partner) : route('partners.store') }}">
                @csrf
                @isset($partner)
                    @method('PUT')
                @endisset

                {{-- =======================
                Publish Controls
                ======================== --}}
                <div class="form-check form-switch form-switch-lg mb-4">
                    <input type="checkbox"
                           name="is_published"
                           value="1"
                           class="form-check-input"
                           id="is_published"
                           {{ old('is_published', $partner->is_published ?? false) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_published">
                        Publish this partner on the website
                    </label>
                </div>

                <hr>

                {{-- =======================
                Partner Name
                ======================== --}}
                <div class="mb-3">
                    <input type="text"
                           name="name"
                           class="form-control"
                           placeholder="Partner name (optional)"
                           value="{{ old('name', $partner->name ?? '') }}">
                    <small class="text-muted">
                        Used for internal identification only.
                    </small>
                </div>

                {{-- =======================
                External Link
                ======================== --}}
                <div class="mb-3">
                    <input type="url"
                           name="external_link"
                           class="form-control"
                           placeholder="https://partner-website.com"
                           value="{{ old('external_link', $partner->external_link ?? '') }}">
                    <small class="text-muted">
                        Users will be redirected to this link when clicking the partner logo.
                    </small>
                </div>

                <hr>

                {{-- =======================
                Actions
                ======================== --}}
                <div class="d-flex justify-content-between">
                    <a href="{{ route('partners.index') }}" class="btn btn-secondary">
                        <i class="uil-arrow-left"></i> Back
                    </a>

                    <button type="submit" class="btn btn-primary">
                        <i class="uil-save"></i>
                        {{ isset($partner) ? 'Update Partner' : 'Create Partner' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
