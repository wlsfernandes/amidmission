<form method="POST" action="{{ route('profile.update') }}">
    @csrf
    @method('PATCH')

    {{-- Name --}}
    <div class="row mb-3 align-items-center">
        <label class="col-lg-3 col-form-label">Name</label>
        <div class="col-lg-7">
            <input name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>
    </div>

    {{-- Email --}}
    <div class="row mb-3 align-items-center">
        <label class="col-lg-3 col-form-label">Email</label>
        <div class="col-lg-7">
            <input name="email" type="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>
    </div>

    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
        <div class="alert alert-warning">
            Your email address is not verified.
        </div>
    @endif

    <button class="btn btn-primary">
        Save Changes
    </button>
</form>