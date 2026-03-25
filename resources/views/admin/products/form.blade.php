@extends('admin.layouts.master')

@section('title', isset($product) ? 'Edit Product' : 'Create Product')

@section('content')
    <div class="card border border-primary">
        <div class="card-header">
            <h5>
                <i class="uil-box"></i>
                {{ isset($product) ? 'Edit Product' : 'Create Product' }}
            </h5>
        </div>

        <div class="card-body">
            <x-alert />

            <div class="bg-info bg-opacity-10 text-info small p-3 rounded mb-4">
                <span class="text-primary fw-semibold">How to create or edit a product:</span><br>
                • Products belong to a <span class="text-dark">store</span>.<br>
                • Price and currency define how the product is sold.<br>
                • Digital products can include downloadable files (S3).<br>
                • Use the <span class="text-success">Publish switch</span> to control visibility.
            </div>

            <hr />

            <form method="POST"
                action="{{ isset($product) ? route('products.update', $product) : route('products.store') }}">
                @csrf
                @if (isset($product))
                    @method('PUT')
                @endif

                {{-- Publish --}}
                <div class="form-check form-switch form-switch-lg mb-4">
                    <input type="hidden" name="is_published" value="0">
                    <input type="checkbox" name="is_published" value="1" class="form-check-input" id="is_published"
                        {{ old('is_published', $product->is_published ?? false) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_published">
                        Publish this product on the website
                    </label>
                </div>

                {{-- Store --}}
                <div class="mb-3">
                    <select name="store_id" class="form-select" required>
                        <option value="">Select Store</option>
                        @foreach ($stores as $store)
                            <option value="{{ $store->id }}"
                                {{ old('store_id', $product->store_id ?? '') == $store->id ? 'selected' : '' }}>
                                {{ $store->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Name --}}
                <div class="mb-3">
                    <input type="text" name="name" class="form-control" placeholder="Product name"
                        value="{{ old('name', $product->name ?? '') }}" required>
                </div>

                {{-- Type --}}
                <div class="mb-3">
                    <input type="text" name="type" class="form-control" placeholder="Type (book, ebook, service)"
                        value="{{ old('type', $product->type ?? '') }}">
                </div>

                {{-- Price --}}
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <input type="number" step="0.01" name="price" class="form-control" placeholder="Price"
                            value="{{ old('price', $product->price ?? '') }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <input type="text" name="currency" class="form-control" placeholder="Currency (USD)"
                            value="{{ old('currency', $product->currency ?? 'USD') }}">
                    </div>
                </div>

                <hr>

                {{-- Description --}}
                <div class="mb-3">
                    <textarea class="form-control ckeditor" id="description_en" name="description_en" rows="5"
                        placeholder="Product description in English...">{{ old('description_en', $product->description_en ?? '') }}</textarea>
                </div>

                <div class="mb-3">
                    <textarea class="form-control ckeditor" id="description_es" name="description_es" rows="5"
                        placeholder="Descripción del producto en español...">{{ old('description_es', $product->description_es ?? '') }}</textarea>
                </div>

                <hr>

                {{-- Digital --}}
                <div class="form-check mb-3">
                    <input type="hidden" name="is_digital" value="0">
                    <input type="checkbox" name="is_digital" value="1" class="form-check-input" id="is_digital"
                        {{ old('is_digital', $product->is_digital ?? false) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_digital">
                        This is a digital product
                    </label>
                </div>

                <hr>

                {{-- Actions --}}
                <div class="d-flex justify-content-between">
                    <a href="{{ route('products.index') }}" class="btn btn-secondary">
                        <i class="uil-arrow-left"></i> Back
                    </a>

                    <button type="submit" class="btn btn-primary">
                        <i class="uil-save"></i>
                        {{ isset($product) ? 'Update Product' : 'Create Product' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
