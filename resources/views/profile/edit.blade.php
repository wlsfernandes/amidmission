@extends('admin.layouts.master')

@section('title', 'My Profile')

@section('content')
    <div class="row">
        <div class="col-lg-8">

            {{-- Profile Info --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Profile Information</h5>
                </div>
                <div class="card-body">
                    <x-alert />
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            {{-- Change Password --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Change Password</h5>
                </div>
                <div class="card-body">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- Delete Account --}}
            <div class="card border-danger">
                <div class="card-header text-danger">
                    <h5>Delete Account</h5>
                </div>
                <div class="card-body">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
@endsection