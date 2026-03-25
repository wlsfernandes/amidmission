@extends('admin.layouts.master')

@section('title', isset($role) ? 'Edit Role' : 'Create Role')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card border border-primary">
            <div class="card-header">
                <h5>
                    <i class="uil-users-alt"></i>
                    {{ isset($role) ? 'Edit Role' : 'Create Role' }}
                </h5>
            </div>

            <div class="card-body">
                <x-alert />

                <form method="POST"
                      action="{{ isset($role)
                        ? route('roles.update', $role)
                        : route('roles.store') }}">

                    @csrf
                    @isset($role)
                        @method('PUT')
                    @endisset

                    {{-- Role Name --}}
                    <div class="row mb-3 align-items-center">
                        <label class="col-lg-3 col-form-label">Role Name</label>
                        <div class="col-lg-6">
                            <input
                                type="text"
                                name="name"
                                class="form-control"
                                value="{{ old('name', $role->name ?? '') }}"
                                required
                                {{ isset($role) && $role->name === 'Admin' ? 'readonly' : '' }}
                            >

                            @if(isset($role) && $role->name === 'Admin')
                                <small class="text-muted">
                                    The Admin role cannot be modified.
                                </small>
                            @endif
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="row mt-4">
                        <div class="col-lg-9 offset-lg-3">
                            <button class="btn btn-primary">
                                {{ isset($role) ? 'Update Role' : 'Create Role' }}
                            </button>

                            <a href="{{ route('roles.index') }}"
                               class="btn btn-light ms-2">
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
