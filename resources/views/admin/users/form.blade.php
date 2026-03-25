@extends('admin.layouts.master')

@section('title', isset($user) ? 'Edit User' : 'Create User')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5>{{ isset($user) ? 'Edit User' : 'Create User' }}</h5>
            </div>

            <div class="card-body">
                <x-alert />

                <form method="POST"
                      action="{{ isset($user)
                        ? route('users.update', $user)
                        : route('users.store') }}">

                    @csrf
                    @isset($user)
                        @method('PUT')
                    @endisset

                    {{-- Name --}}
                    <div class="row mb-3 align-items-center">
                        <label class="col-lg-2 col-form-label">Name</label>
                        <div class="col-lg-6">
                            <input name="name"
                                   class="form-control"
                                   value="{{ old('name', $user->name ?? '') }}"
                                   required>
                        </div>
                    </div>

                    {{-- Email --}}
                    <div class="row mb-3 align-items-center">
                        <label class="col-lg-2 col-form-label">Email</label>
                        <div class="col-lg-6">
                            <input name="email"
                                   type="email"
                                   class="form-control"
                                   value="{{ old('email', $user->email ?? '') }}"
                                   required>
                        </div>
                    </div>

                    {{-- Roles --}}
                    <div class="row mb-3">
                        <label class="col-lg-2 col-form-label">Roles</label>
                        <div class="col-lg-6">
                            @foreach ($roles as $role)
                                <div class="form-check mb-1">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        name="roles[]"
                                        value="{{ $role->id }}"
                                        id="role_{{ $role->id }}"
                                        {{ isset($user) && $user->roles->contains($role->id) ? 'checked' : '' }}
                                    >
                                    <label class="form-check-label" for="role_{{ $role->id }}">
                                        {{ $role->name }}
                                    </label>
                                </div>
                            @endforeach

                            <small class="text-muted">
                                Select one or more roles for this user.
                            </small>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="row mt-4">
                        <div class="col-lg-8 offset-lg-2">
                            <button class="btn btn-primary">
                                {{ isset($user) ? 'Update User' : 'Create User' }}
                            </button>

                            <a href="{{ route('users.index') }}" class="btn btn-light ms-2">
                                Cancel
                            </a>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection
