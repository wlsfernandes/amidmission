@extends('admin.layouts.master')

@section('title', isset($team) ? 'Edit Team Member' : 'Create Team Member')

@section('content')
    <div class="card border border-primary">
        <div class="card-header">
            <h5>
                <i class="fas fa-users"></i>
                {{ isset($team) ? 'Edit Team Member' : 'Create Team Member' }}
            </h5>
        </div>

        <div class="card-body">
            <x-alert />

            {{-- Helper block --}}
            <div class="bg-info bg-opacity-10 text-info small p-3 rounded mb-4">
                <span class="text-primary fw-semibold">How to manage team members:</span><br>
                • The <span class="text-dark">name</span> is required and used to generate the public profile URL.<br>
                • The <span class="text-dark">slug</span> is generated automatically and updates if the name changes.<br>
                • Add a <span class="text-dark">role or title</span> to describe the team member’s position.<br>
                • Use the <span class="text-success">Publish switch</span> to control public visibility.<br>
                • Profile photos are managed separately using the image icon on the list page.
            </div>

            <hr />

            <form method="POST" action="{{ isset($team) ? route('teams.update', $team) : route('teams.store') }}">
                @csrf
                @isset($team)
                    @method('PUT')
                @endisset

                {{-- =======================
                Publish Controls
                ======================== --}}
                <div class="form-check form-switch form-switch-lg mb-4">
                    <input type="checkbox" name="is_published" value="1" class="form-check-input" id="is_published"
                        {{ old('is_published', $team->is_published ?? false) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_published">
                        Publish this team member on the website
                    </label>
                </div>

                <hr>

                {{-- =======================
                Identity
                ======================== --}}
                <div class="mb-3">
                    <label class="form-label d-block">Sectors</label>

                    <div class="row">
                        @foreach ($sectors as $sector)
                            <div class="col-md-3 col-lg-3">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="sectors[]"
                                        id="sector_{{ $sector->id }}" value="{{ $sector->id }}"
                                        {{ isset($team) && $team->sectors->contains($sector->id) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="sector_{{ $sector->id }}">
                                        {{ $sector->name }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <small class="text-muted d-block mt-2">
                        Required. Determines where this person appears on the public team page.
                    </small>

                    @error('sectors')
                        <div class="text-danger small mt-1">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                <div class="mb-3">
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                        placeholder="Full name" value="{{ old('name', $team->name ?? '') }}" required>
                    <small class="text-muted">
                        Required. Used to generate the public profile URL.
                    </small>

                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                @isset($team)
                    <div class="mb-3">
                        <input type="text" class="form-control" value="{{ $team->slug }}" readonly>
                        <small class="text-muted">
                            Public profile URL slug (auto-generated).
                        </small>
                    </div>
                @endisset

                <div class="mb-3">
                    <input type="text" name="role" class="form-control" placeholder="Role or title (optional)"
                        value="{{ old('role', $team->role ?? '') }}">
                    <small class="text-muted">
                        Example: Executive Director, Program Manager
                    </small>
                </div>

                <hr>

                {{-- =======================
                Bio Content
                ======================== --}}
                <div class="mb-3">
                    <textarea class="form-control ckeditor" id="content_en" name="content_en" rows="5"
                        placeholder="Write the biography in English...">{{ old('content_en', $team->content_en ?? '') }}</textarea>
                    <small class="text-muted">
                        English biography shown on the public profile.
                    </small>
                </div>

                <div class="mb-3">
                    <textarea class="form-control ckeditor" id="content_es" name="content_es" rows="5"
                        placeholder="Escriba la biografía en español...">{{ old('content_es', $team->content_es ?? '') }}</textarea>
                    <small class="text-muted">
                        Optional Spanish version.
                    </small>
                </div>

                <hr>

                {{-- =======================
                Actions
                ======================== --}}
                <div class="d-flex justify-content-between">
                    <a href="{{ route('teams.index') }}" class="btn btn-secondary">
                        <i class="uil-arrow-left"></i> Back
                    </a>

                    <button type="submit" class="btn btn-primary">
                        <i class="uil-save"></i>
                        {{ isset($team) ? 'Update Team Member' : 'Create Team Member' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
