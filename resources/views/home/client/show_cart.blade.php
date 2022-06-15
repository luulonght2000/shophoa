@extends('layouts.app')

@section('content')

<section class="featured spad">
        <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="img/breadcrumb.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>Shopping Cart</h2>
                        <div class="breadcrumb__option">
                            <a href="./index.html">Home</a>
                            <span>Shopping Cart</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Shoping Cart Section Begin -->
    <section class="shoping-cart spad">
        <div class="container">
            @if(session()->has('error'))
            <div class="alert alert-danger">
            {{ session()->get('error') }}
            </div>
            @endif
            @if(session()->has('success'))
            <div class="alert alert-success">
            {{ session()->get('success') }}
            </div>
            @endif

            <div class="row">
                <div class="col-lg-12">
                    <div class="shoping__cart__table">
                        <?php 
                            $contents = Cart::content();
                        ?>
                        <table>
                            <thead>
                                <tr>
                                    <th class="shoping__product">Products</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($contents as $content)
                                <tr>
                                    <td class="shoping__cart__item">
                                        @if(file_exists(public_path("./uploads/{$content->id}.jpg")))
                                        <img width="150" height="150" src={{"/uploads/$content->id.jpg"}} alt="">
                                        @else
                                        <img width="150" height="150" src={{"/uploads/no_photo.png"}} alt="">
                                        @endif
                                        <h5 style="text-transform: capitalize">{{$content->name}}</h5>
                                    </td>
                                    <td class="shoping__cart__price">
                                        {{number_format($content->price).' '.'vnđ'}}
                                    </td>
                                    <td class="shoping__cart__quantity">
                                        <form action="{{url('/update-cart-quantity')}}" method="post">
                                            @csrf
                                            <div class="quantity">
                                                <div class="pro-qty">
                                                    <input type="text" value="{{$content->qty}}" name="cart_quantity">
                                                </div>
                                            </div>
                                            <input type="hidden" value="{{$content->rowId}}" name="rowId_cart" class="form-control">
                                            <input type="submit" value="Cập nhật" name="update-qty" class="btn btn-default btn-sm">
                                        </form>
                                    </td>
                                    <td class="shoping__cart__total">
                                        <?php 
                                            $subtotal = $content->price * $content->qty;
                                            echo number_format($subtotal)." vnđ";
                                        ?>
                                    </td>
                                    <td class="shoping__cart__item__close">
                                        <a href='{{url("/delete-to-cart/$content->rowId")}}'><span class="icon_close"></span></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="shoping__cart__btns">
                        <a href="/" class="primary-btn cart-btn">CONTINUE SHOPPING</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="shoping__continue">
                        <div class="shoping__discount">
                            <h5>Discount Codes</h5>
                            <form action="#">
                                <input type="text" placeholder="Enter your coupon code">
                                <button type="submit" class="site-btn">APPLY COUPON</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="shoping__checkout">
                        <h5>Cart Total</h5>
                        <ul>
                            <li>Tổng <span>{{Cart::subtotal(0).' '.'vnđ'}}</span></li>
                            <li>Phí vận chuyển <span>Free</span></li>
                            <li>Thành tiền <span>{{Cart::subtotal(0).' '.'vnđ'}}</span></li>
                        </ul>
                        <a href="{{url('/checkout')}}" class="primary-btn">PROCEED TO CHECKOUT</a>
                    </div>
                </div>
            </div>
        </div>
    </section> 
    <!-- Shoping Cart Section End -->
</section>
@endsection