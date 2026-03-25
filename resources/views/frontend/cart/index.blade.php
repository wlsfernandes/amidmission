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

    <section class="cart__section pt-80 pb-80 overhid">
        <div class="container">
            <div class="main__cart__wrap">
                <div class="row">
                    <div class="col-12">
                        <div class="cart__wrapper">
                            <div class="cart-items-wrapper">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Subtotal</th>
                                            <th>Remove</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @php $subtotal = 0; @endphp

                                        @forelse(session('cart', []) as $item)
                                            @php
                                                $lineTotal = $item['price'] * $item['quantity'];
                                                $subtotal += $lineTotal;
                                            @endphp

                                            <tr class="cart-item">
                                                {{-- PRODUCT --}}
                                                <td class="cart-item-info">
                                                    <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}"
                                                        style="width:80px;height:auto;">
                                                    <div class="ms-2">
                                                        <strong>{{ $item['name'] }}</strong>
                                                    </div>
                                                </td>

                                                {{-- PRICE --}}
                                                <td class="cart-item-price">
                                                    $ {{ number_format($item['price'], 2) }}
                                                </td>
                                                {{-- QUANTITY --}}
                                                <td>
                                                    <div class="cart-item-quantity">
                                                        <span class="fw-semibold">
                                                            {{ (int) $item['quantity'] }}
                                                        </span>
                                                    </div>
                                                </td>

                                                {{-- SUBTOTAL --}}
                                                <td class="cart-item-price">
                                                    $ {{ number_format($lineTotal, 2) }}
                                                </td>

                                                {{-- REMOVE --}}
                                                <td class="cart-item-remove">
                                                    <form method="POST"
                                                        action="{{ route('cart.remove', $item['product_id']) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="border-0 bg-transparent">
                                                            <i class="fa-solid fa-xmark"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>

                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center py-4">
                                                    Your cart is empty.
                                                </td>
                                            </tr>
                                        @endforelse

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- TOTALS --}}
                <div class="row g-5 align-items-start">

                    {{-- LEFT: CHECKOUT FORM --}}
                    <div class="col-lg-7 col-xl-8">
                        <div class="signup__boxes round16">
                            <h3 class="title mb-3">
                                Checkout Details
                            </h3>

                            <form method="POST" action="{{ route('cart.checkout') }}" class="write__review">
                                @csrf

                                <div class="row g-4">

                                    <div class="col-lg-6">
                                        <div class="frm__grp">
                                            <label class="fz-18 fw-500 inter title mb-3">First Name</label>
                                            <input type="text" name="first_name" required>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="frm__grp">
                                            <label class="fz-18 fw-500 inter title mb-3">Last Name</label>
                                            <input type="text" name="last_name" required>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="frm__grp">
                                            <label class="fz-18 fw-500 inter title mb-3">Email</label>
                                            <input type="email" name="email" required>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="frm__grp">
                                            <label class="fz-18 fw-500 inter title mb-3">Country</label>
                                            <input type="text" name="country" required>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="frm__grp">
                                            <label class="fz-18 fw-500 inter title mb-3">Shipping Address</label>
                                            <input type="text" name="address" required>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <button type="submit" class="cmn--btn w-100">
                                            <span>
                                                Proceed to Payment
                                            </span>
                                        </button>

                                        <p class="fz-14 fw-400 text-center mt-3 text-muted">
                                            <i class="uil uil-lock"></i>
                                            Secure checkout powered by <strong>Stripe</strong>
                                        </p>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- RIGHT: CART TOTAL --}}
                    <div class="col-lg-5 col-xl-4">
                        <div class="cart__pragh__box">
                            <div class="cart__graph p-4">

                                <h4 class="mb-4 text-center">Order Summary</h4>

                                <ul class="list-unstyled mb-4">
                                    <li class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Subtotal</span>
                                        <span>$ {{ number_format($subtotal, 2) }}</span>
                                    </li>

                                    <li class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Shipping</span>
                                        <span>$ {{ number_format($shipping, 2) }}</span>
                                    </li>

                                    <li class="d-flex justify-content-between pt-3 mt-3 border-top">
                                        <strong>Total</strong>
                                        <strong class="fs-5">
                                            $ {{ number_format($total, 2) }}
                                        </strong>
                                    </li>
                                </ul>

                            </div>
                        </div>
                    </div>

                </div>



            </div>
        </div>
    </section>


@endsection
