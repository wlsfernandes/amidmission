<div>
    {{-- ✅ SUCCESS --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-start" role="alert">
            <div class="me-3 fs-4">
                <i class="uil uil-check-circle"></i>
            </div>
            <div>
                <strong>Success!</strong><br>
                <span>{{ session('success') }}</span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- ❌ SYSTEM ERROR (not validation) --}}
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-start" role="alert">
            <div class="me-3 fs-4">
                <i class="uil uil-times-circle"></i>
            </div>
            <div>
                <strong>System error</strong><br>
                <span>{{ session('error') }}</span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- ⚠️ VALIDATION ERRORS --}}
    @if ($errors->any())
        <div class="alert alert-warning alert-dismissible fade show d-flex align-items-start" role="alert">
            <div class="me-3 fs-4">
                <i class="uil uil-exclamation-circle"></i>
            </div>
            <div>
                <strong>Please fix the following fields:</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
</div>