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
    <section class="product__section pt-130 pb-130 overhid">
        <div class="container">

            {{-- Top Bar --}}
            <div class="top__bar d-flex flex-wrap justify-content-between align-items-center section__bg px-4 py-3 mb-30">
                <span>
                    Showing {{ $products->firstItem() }}–{{ $products->lastItem() }} of {{ $products->total() }} results
                </span>

                <div class="items">
                    <select class="form__select">
                        <option>Sort by latest</option>
                        <option>Sort by price</option>
                        <option>Sort by popularity</option>
                    </select>
                </div>
            </div>

            {{-- Products --}}
            <div class="row g-4">

                @forelse ($products as $product)
                    <div class="col-xxl-3 col-xl-3 col-lg-4 col-md-6 wow fadeInUp">
                        <div class="product__items">

                            {{-- Image --}}
                            <div class="product__thumb">
                                <img src="{{ route('admin.images.preview', ['model' => 'products', 'id' => $product->id]) }}"
                                    alt="{{ $product->name }}" loading="lazy" class="product-thumb">


                                <ul class="product__icon d-flex justify-content-center">
                                    <li>
                                        <a href="{{ route('store.products.show', $product->slug) }}">
                                            <i class="fa-regular fa-eye"></i>
                                        </a>
                                    </li>

                                    <li>
                                        <form method="POST" action="{{ route('cart.add', $product) }}">
                                            @csrf
                                            <input type="hidden" name="quantity" value="1">

                                            <button type="submit" class="cart-icon-btn">
                                                <i class="fa-solid fa-cart-shopping"></i>
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>

                            {{-- Content --}}
                            <div class="product__content center">
                                <h6>
                                    <a href="{{ route('store.products.show', $product->slug) }}">
                                        {{ $product->name }}
                                    </a>
                                </h6>

                                {{-- Stars (static for now) --}}
                                <ul>
                                    @for ($i = 0; $i < 5; $i++)
                                        <li><i class="fa-solid fa-star"></i></li>
                                    @endfor
                                </ul>

                                {{-- Price --}}
                                <div class="product__price d-flex align-items-center justify-content-center">
                                    <h6>
                                        {{ strtoupper($product->currency) }}
                                        {{ number_format($product->price, 2) }}
                                    </h6>
                                </div>
                            </div>

                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <p class="text-muted">No products available.</p>
                    </div>
                @endforelse

            </div>

            {{-- Pagination --}}
            <div class="mt-50 d-flex justify-content-center">
                {{ $products->links() }}
            </div>

        </div>
    </section>
@endsection
