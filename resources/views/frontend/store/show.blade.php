@extends('frontend.layouts.app')

@section('title', 'Stores' . ' | Amid Mission')

@section('content')



    <!--Breadcumd Section Here-->
    <section class="breadcumd__banner overhid">
        <div class="container">
            <div class="breadcumd__wrapper">
                <h2 class="left__content">
                    @lang('pages.our_store')
                </h2>
                <ul class="right__content">
                    <li>
                        <a href="{{ url('/') }}">
                            <i class="fa-solid fa-house"></i>
                            @lang('pages.home')
                        </a>
                    </li>
                    <li>
                        <i class="fa-solid fa-chevron-right"></i>
                    </li>
                    <li>
                        @lang('pages.store')
                    </li>
                </ul>
            </div>
        </div>
    </section>
    <!--Breadcumd Section End-->
    <section class="shop__single pt-80 pb-80 overhid">
        <div class="container">
            <div class="row g-5 align-items-start">

                {{-- PRODUCT IMAGE --}}
                <div class="col-xxl-5 col-xl-5 col-lg-5">
                    <div class="product__image text-center">
                        <img src="{{ route('admin.images.preview', ['model' => 'products', 'id' => $product->id]) }}"
                            alt="{{ $product->name }}" class="img-fluid rounded" style="max-width: 100%; height: auto;"
                            loading="lazy">
                    </div>
                </div>

                {{-- PRODUCT CONTENT --}}
                <div class="col-xxl-7 col-xl-7 col-lg-7">
                    <div class="shop__single__content">

                        {{-- TITLE --}}
                        <h3 class="mb-3">
                            {{ $product->name }}
                        </h3>

                        {{-- PRICE --}}
                        <div class="product-pricing mb-4">
                            <h4 class="text-primary">
                                {{ strtoupper($product->currency) }} {{ number_format($product->price, 2) }}
                            </h4>
                        </div>

                        {{-- DESCRIPTION --}}
                        <div class="product-description mb-4">
                            <p>
                            <div class="cms-html" id="cms-html">
                                {!! app()->getLocale() === 'es' ? $product->description_es : $product->description_en !!}
                            </div>
                            </p>
                        </div>

                        {{-- QUANTITY + ACTION --}}
                        <form method="POST" action="{{ route('cart.add', $product) }}">
                            @csrf

                            <div class="d-flex align-items-center gap-3 mb-4">

                                {{-- QUANTITY --}}
                                <div class="product-pricing-single product-pricing-calculator">
                                    <button type="button" class="cart-decre">
                                        <i class="fa-solid fa-minus"></i>
                                    </button>

                                    <input type="number" name="quantity" value="1" min="1"
                                        class="product-quant text-center" style="width:60px;">

                                    <button type="button" class="cart-incre">
                                        <i class="fa-solid fa-plus"></i>
                                    </button>
                                </div>

                                {{-- ADD TO CART --}}
                                <button type="submit" class="cmn--btn">
                                    <span>Add to Cart</span>
                                </button>

                            </div>
                        </form>

                        {{-- DIGITAL NOTE --}}
                        @if ($product->is_digital)
                            <p class="text-muted small">
                                <i class="fa-solid fa-download"></i>
                                This is a digital product. Download will be available after purchase.
                            </p>
                        @endif

                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection
@push('scripts')
    <script>
        // Quantity Increment/Decrement
        document.addEventListener('DOMContentLoaded', function() {

            document.querySelectorAll('.product-pricing-calculator').forEach(function(calculator) {
                const input = calculator.querySelector('.product-quant');
                const incBtn = calculator.querySelector('.cart-incre');
                const decBtn = calculator.querySelector('.cart-decre');

                incBtn.addEventListener('click', function() {
                    input.value = parseInt(input.value || 1) + 1;
                });

                decBtn.addEventListener('click', function() {
                    const current = parseInt(input.value || 1);
                    if (current > 1) {
                        input.value = current - 1;
                    }
                });
            });

        });
    </script>
@endpush
