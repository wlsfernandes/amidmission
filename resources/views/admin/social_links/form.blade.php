@extends('admin.layouts.master')

@section('title', isset($socialLink) ? 'Edit Social Link' : 'Add Social Link')

@section('content')
    <div class="card border border-primary">
        <div class="card-header">
            <h5>
                <i class="fas fa-share-alt"></i>
                {{ isset($socialLink) ? 'Edit Social Media Link' : 'Add Social Media Link' }}
            </h5>
        </div>

        <div class="card-body">
            <x-alert />

            {{-- Helper --}}
            <div class="bg-info bg-opacity-10 text-info small p-3 rounded mb-4">
                <i class="fas fa-info-circle"></i>
                Add links to your organization’s social media profiles.
                These links can appear globally across the website.
            </div>

            <form method="POST"
                  action="{{ isset($socialLink) ? route('social-links.update', $socialLink) : route('social-links.store') }}">
                @csrf
                @isset($socialLink)
                    @method('PUT')
                @endisset

                {{-- =======================
                Platform
                ======================== --}}
                <div class="mb-3">
                    <label class="form-label">Social Platform</label>
                    <select name="platform"
                            class="form-select @error('platform') is-invalid @enderror"
                            {{ isset($socialLink) ? 'disabled' : '' }}>
                        <option value="">— Select platform —</option>

                        @foreach($platforms as $platform)
                            <option value="{{ $platform->value }}"
                                {{ old('platform', $socialLink->platform->value ?? '') === $platform->value ? 'selected' : '' }}>
                                {{ $platform->label() }}
                            </option>
                        @endforeach
                    </select>

                    @error('platform')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                    <small class="text-muted">
                        Each platform can be added only once.
                    </small>

                    @isset($socialLink)
                        <input type="hidden" name="platform" value="{{ $socialLink->platform->value }}">
                    @endisset
                </div>

                {{-- =======================
                URL
                ======================== --}}
                <div class="mb-3">
                    <label class="form-label">Profile URL</label>
                    <input type="url"
                           name="url"
                           class="form-control @error('url') is-invalid @enderror"
                           placeholder="https://www.facebook.com/yourpage"
                           value="{{ old('url', $socialLink->url ?? '') }}"
                           required>

                    @error('url')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                    <small class="text-muted">
                        Full link to your social media profile.
                    </small>
                </div>

                {{-- =======================
                Order
                ======================== --}}
                <div class="mb-3">
                    <label class="form-label">Display Order</label>
                    <input type="number"
                           name="order"
                           class="form-control"
                           placeholder="0"
                           value="{{ old('order', $socialLink->order ?? 0) }}">
                    <small class="text-muted">
                        Lower numbers appear first.
                    </small>
                </div>

                {{-- =======================
                Active
                ======================== --}}
                <div class="form-check form-switch form-switch-lg mb-4">
                    <input type="checkbox"
                           name="is_published"
                           value="1"
                           class="form-check-input"
                           id="is_published"
                           {{ old('is_published', $socialLink->is_published ?? true) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_published">
                        Show this social link on the website
                    </label>
                </div>

                <hr>

                {{-- =======================
                Actions
                ======================== --}}
                <div class="d-flex justify-content-between">
                    <a href="{{ route('social-links.index') }}" class="btn btn-secondary">
                        <i class="uil-arrow-left"></i> Back
                    </a>

                    <button type="submit" class="btn btn-primary">
                        <i class="uil-save"></i>
                        {{ isset($socialLink) ? 'Update Link' : 'Create Link' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
