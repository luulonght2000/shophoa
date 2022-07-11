@extends('layouts.app')

@section('content')

    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="img/breadcrumb.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>Checkout</h2>
                        <div class="breadcrumb__option">
                            <a href="./index.html">Home</a>
                            <span>Thanh toán giỏ hàng</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Checkout Section Begin -->
    <section class="checkout spad">
        <div class="container">
        @if(session()->has('error'))
        <div class="alert alert-danger">
        {{ session()->get('error') }}
        </div>
        @endif
          <div class="col-lg-12 col-md-12">
            <div class="checkout__order">
                <h4>Your Order</h4>
                <div class="checkout__order__products">Products  <span>Quantity</span></div>
                <ul>
                    @foreach ($contents as $content)
                    <li style="text-transform: capitalize">{{$content->name}}<span>{{$content->qty}}</span></li>
                    @endforeach
                </ul>
                <div class="checkout__order__subtotal">Subtotal <span>{{Cart::subtotal(0).' '.'vnđ'}}</span></div>

                <form action="{{url('/order-place')}}" method="POST">
                  @csrf
                  <div class="row">
                    <div class="col-lg-4 col-md-4">
                      <h5 style="color: red">Hình thức thanh toán</h4>
                    </div>
                    <div class="checkout__input__checkbox col-lg-4 col-md-4">
                        <label for="ATM">
                            Thanh toán qua ATM
                            <input id="ATM" name="payment_option" value="Bằng ATM" type="radio">
                            <span class="checkmark"></span>
                        </label>
                    </div>
                    <div class="checkout__input__checkbox col-lg-4 col-md-4">
                      <label for="payment">
                          Thanh toán khi nhận hàng
                          <input id="payment" name="payment_option" value="Thanh toán khi nhận hàng" type="radio">
                          <span class="checkmark"></span>
                      </label>
                    </div>
                    <span class="error-message" style="color: red">{{ $errors->first('payment_option') }}</span>
                    <button type="submit" name="send_order_place" class="site-btn">Đặt hàng</button>
                  </div>
                </form>
                <form action='{{url("delete-order/$shipping_id")}}' method="POST" onsubmit="return(confirm('bạn có thực sự muốn hủy đơn hàng này?'))">
                    @method('DELETE')
                    @csrf
                    <button type="submit" name="send_order_place" class="site-btn">Hủy đặt hàng</button>
                  </form>
            </div>
        </div>
      </div>
    </section>
    <!-- Checkout Section End -->

@endsection