@extends('admin.layouts.master')

@section('title', isset($store) ? 'Edit Store' : 'Create Store')

@section('content')
    <div class="card border border-primary">
        <div class="card-header">
            <h5>
                <i class="uil-store"></i>
                {{ isset($store) ? 'Edit Store' : 'Create Store' }}
            </h5>
        </div>

        <div class="card-body">
            <x-alert />

            <div class="bg-info bg-opacity-10 text-info small p-3 rounded mb-4">
                <span class="text-primary fw-semibold">How to create or edit a store:</span><br>
                • The <span class="text-dark">store name</span> is used to generate the public URL.<br>
                • A store groups related products (bookstore, digital store, etc.).<br>
                • Use the <span class="text-success">Publish switch</span> to control visibility.<br>
                • You can unpublish a store without deleting it.
            </div>

            <hr />

            <form method="POST" action="{{ isset($store) ? route('stores.update', $store) : route('stores.store') }}">
                @csrf
                @if (isset($store))
                    @method('PUT')
                @endif

                {{-- Publish --}}
                <div class="form-check form-switch form-switch-lg mb-4">
                    <input type="hidden" name="is_published" value="0">
                    <input type="checkbox" name="is_published" value="1" class="form-check-input" id="is_published"
                        {{ old('is_published', $store->is_published ?? false) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_published">
                        Publish this store on the website
                    </label>
                </div>

                {{-- Name --}}
                <div class="mb-3">
                    <input type="text" name="name" class="form-control" placeholder="Store name (e.g. Bookstore)"
                        value="{{ old('name', $store->name ?? '') }}" required>
                    <small class="text-muted">
                        Used to generate the public URL (slug).
                    </small>
                </div>

                {{-- Type --}}
                <div class="mb-3">
                    <input type="text" name="type" class="form-control"
                        placeholder="Type (bookstore, digital, merchandise)" value="{{ old('type', $store->type ?? '') }}">
                </div>

                <hr>

                {{-- Content --}}
                <div class="mb-3">
                    <textarea class="form-control ckeditor" id="content_en" name="content_en" rows="5"
                        placeholder="Store description in English...">{{ old('content_en', $store->content_en ?? '') }}</textarea>
                </div>

                <div class="mb-3">
                    <textarea class="form-control ckeditor" id="content_es" name="content_es" rows="5"
                        placeholder="Descripción de la tienda en español...">{{ old('content_es', $store->content_es ?? '') }}</textarea>
                </div>

                <hr>

                {{-- Actions --}}
                <div class="d-flex justify-content-between">
                    <a href="{{ route('stores.index') }}" class="btn btn-secondary">
                        <i class="uil-arrow-left"></i> Back
                    </a>

                    <button type="submit" class="btn btn-primary">
                        <i class="uil-save"></i>
                        {{ isset($store) ? 'Update Store' : 'Create Store' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        AppEditor.create('#content_en');
        AppEditor.create('#content_es');
    </script>
@endsection
