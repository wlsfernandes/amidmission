@extends('admin.layouts.master')

@section('title', 'Developer Settings')

@section('content')
    <div class="card border border-danger">
        <div class="card-header bg-danger bg-opacity-10">
            <h5 class="text-danger mb-0">
                <i class="fas fa-exclamation-triangle"></i> Developer Settings
            </h5>
        </div>

        <div class="card-body">
            <x-alert />

            {{-- DANGER NOTICE --}}
            <div class="alert alert-danger">
                <strong>⚠️ WARNING – Advanced Configuration</strong><br>
                These settings control payments, email delivery, queues, analytics,
                security, and cloud storage.
                <br><br>
                <strong>Incorrect values may break the website.</strong>
                Only developers or system administrators should modify these fields.
            </div>

            <form method="POST" action="{{ route('developer-settings.update') }}">
                @csrf
                @method('PUT')

                {{-- =======================
                STRIPE
                ======================== --}}
                <h6 class="text-danger mt-4">
                    <i class="fab fa-stripe"></i> Stripe
                </h6>

                <div class="mb-3">
                    <label class="form-label">Stripe Public Key</label>
                    <input type="text"
                           name="stripe_key"
                           class="form-control"
                           placeholder="pk_live_..."
                           value="{{ old('stripe_key', $setting->stripe_key) }}">
                    <small class="text-muted">
                        Used on the frontend to initialize Stripe.
                    </small>
                </div>

                <div class="mb-3">
                    <label class="form-label">Stripe Secret Key</label>
                    <input type="password"
                           name="stripe_secret"
                           class="form-control"
                           placeholder="sk_live_...">
                    <small class="text-muted">
                        Leave blank to keep the current secret.
                    </small>
                </div>

                <div class="mb-3">
                    <label class="form-label">Stripe Product ID</label>
                    <input type="text"
                           name="stripe_product_id"
                           class="form-control"
                           placeholder="prod_..."
                           value="{{ old('stripe_product_id', $setting->stripe_product_id) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Stripe Currency</label>
                    <input type="text"
                           name="stripe_currency"
                           class="form-control"
                           placeholder="usd"
                           value="{{ old('stripe_currency', $setting->stripe_currency) }}">
                </div>
<div class="mt-2">
    <button type="button"
            class="btn btn-outline-danger btn-sm"
            onclick="testStripeConnection()">
        <i class="fab fa-stripe"></i> Test Stripe Connection
    </button>
</div>

                <hr>

                {{-- =======================
                PAYPAL
                ======================== --}}
                <h6 class="text-danger">
                    <i class="fab fa-paypal"></i> PayPal
                </h6>

                <div class="mb-3">
                    <label class="form-label">PayPal Client ID</label>
                    <input type="text"
                           name="paypal_live_client_id"
                           class="form-control"
                           placeholder="AXXXXXXXXXXXXX"
                           value="{{ old('paypal_live_client_id', $setting->paypal_live_client_id) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">PayPal Client Secret</label>
                    <input type="password"
                           name="paypal_live_client_secret"
                           class="form-control"
                           placeholder="••••••••">
                    <small class="text-muted">
                        Leave blank to keep the current secret.
                    </small>
                </div>

                <div class="mb-3">
                    <label class="form-label">PayPal Currency</label>
                    <input type="text"
                           name="paypal_live_currency"
                           class="form-control"
                           placeholder="usd"
                           value="{{ old('paypal_live_currency', $setting->paypal_live_currency) }}">
                </div>

                <hr>

                {{-- =======================
                RECAPTCHA
                ======================== --}}
                <h6 class="text-danger">
                    <i class="fas fa-shield-alt"></i> Google reCAPTCHA
                </h6>

                <div class="mb-3">
                    <label class="form-label">Site Key</label>
                    <input type="text"
                           name="recaptcha_site_key"
                           class="form-control"
                           value="{{ old('recaptcha_site_key', $setting->recaptcha_site_key) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Secret Key</label>
                    <input type="password"
                           name="recaptcha_secret_key"
                           class="form-control"
                           placeholder="••••••••">
                </div>

                <hr>

                {{-- =======================
                ANALYTICS
                ======================== --}}
                <h6 class="text-danger">
                    <i class="fas fa-chart-line"></i> Analytics
                </h6>

                <div class="mb-3">
                    <label class="form-label">Analytics Property ID</label>
                    <input type="text"
                           name="analytics_property_id"
                           class="form-control"
                           placeholder="G-XXXXXXXXXX"
                           value="{{ old('analytics_property_id', $setting->analytics_property_id) }}">
                </div>

                <hr>

                {{-- =======================
                AWS / S3
                ======================== --}}
                <h6 class="text-danger">
                    <i class="fab fa-aws"></i> AWS / S3
                </h6>

                <div class="mb-3">
                    <label class="form-label">Access Key ID</label>
                    <input type="text"
                           name="aws_access_key_id"
                           class="form-control"
                           value="{{ old('aws_access_key_id', $setting->aws_access_key_id) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Secret Access Key</label>
                    <input type="password"
                           name="aws_secret_access_key"
                           class="form-control"
                           placeholder="••••••••">
                </div>

                <div class="mb-3">
                    <label class="form-label">Default Region</label>
                    <input type="text"
                           name="aws_default_region"
                           class="form-control"
                           placeholder="us-east-1"
                           value="{{ old('aws_default_region', $setting->aws_default_region) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Bucket</label>
                    <input type="text"
                           name="aws_bucket"
                           class="form-control"
                           value="{{ old('aws_bucket', $setting->aws_bucket) }}">
                </div>

                <div class="form-check form-switch form-switch-lg mb-4">
                    <input type="checkbox"
                           name="aws_debug"
                           value="1"
                           class="form-check-input"
                           id="aws_debug"
                           {{ old('aws_debug', $setting->aws_debug) ? 'checked' : '' }}>
                    <label class="form-check-label" for="aws_debug">
                        Enable AWS Debug Mode
                    </label>
                </div>

                <hr>

                {{-- =======================
                ACTIONS
                ======================== --}}
                <div class="d-flex justify-content-between">
                    <a href="{{ route('developer-settings.index') }}"
                       class="btn btn-secondary">
                        <i class="uil-arrow-left"></i> Back
                    </a>

                    <button class="btn btn-danger">
                        <i class="uil-save"></i> Save Developer Settings
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
<script>
function testStripeConnection() {
    fetch("{{ route('developer-settings.test-stripe') }}", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "Accept": "application/json"
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert(
                "✅ " + data.message +
                "\nAccount ID: " + data.account_id +
                "\nCountry: " + data.country
            );
        } else {
            alert("❌ " + data.message + "\n" + (data.error ?? ""));
        }
    })
    .catch(() => {
        alert("❌ Unable to reach Stripe.");
    });
}
</script>
@endsection
