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
                            <span>Checkout</span>
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
            <div class="row">
                <div class="col-lg-12">
                    <h6><span class="icon_tag_alt"></span> Have a coupon? <a href="#">Click here</a> to enter your code
                    </h6>
                </div>
            </div>
            <div class="checkout__form">
                <h4>Billing Details</h4>
                <form action="{{url('/save-checkout-user')}}" method="post">
                    @csrf
                        <div class="row">
                          <div class="col-lg-8 col-md-6">
                              <div class="checkout__input">
                                  <p>Full Name<span>*</span></p>
                                  <input type="text" name="shipping_name" placeholder="" value="{{Auth::user()->name}}">
                              </div>
                              <div class="checkout__input">
                                  <p>Address<span>*</span></p>
                                  <input type="text" value="{{Auth::user()->address}}" name="shipping_address" class="checkout__input__add" value="{{old('shipping_address')}}" required>
                              </div>
                              <div class="row">
                                  <div class="col-lg-6">
                                      <div class="checkout__input">
                                          <p>Phone<span>*</span></p>
                                          <input type="text" name="shipping_phone" value="{{old('shipping_phone')}}" >
                                          <span class="error-message" style="color: red">{{ $errors->first('shipping_phone') }}</span>
                                      </div>
                                  </div>
                                  <div class="col-lg-6">
                                      <div class="checkout__input">
                                          <p>Email<span>*</span></p>
                                          <input type="text" name="shipping_email" placeholder="{{Auth::user()->email}}">
                                          <span class="error-message" style="color: red">{{ $errors->first('shipping_email') }}</span>
                                      </div>
                                  </div>
                              </div>
                              <div class="checkout__input">
                                  <p>Order notes<span>*</span></p>
                                  <input type="text" name="shipping_note" placeholder="Ghi chú." value="{{old('shipping_note')}}">
                                <span class="error-message" style="color: red">{{ $errors->first('shipping_note') }}</span>
                              </div>
                          </div>
                          <div class="col-lg-4 col-md-6">
                              <div class="checkout__order">
                                  <h4>Your Order</h4>
                                  <div class="checkout__order__products">Products  <span>Quantity</span></div>
                                  <ul>
                                      @foreach ($contents as $content)
                                      <li style="text-transform: capitalize">{{$content->name}}<span>{{$content->qty}}</span></li>
                                      @endforeach
                                  </ul>
                                  <div class="checkout__order__subtotal">Subtotal <span>{{Cart::subtotal(0).' '.'vnđ'}}</span></div>
                                  
                                  <button type="submit" name="send_order" class="site-btn">PLACE ORDER</button>
                              </div>
                          </div>
                      </div>
                </form>
            </div>
        </div>
    </section>
    <!-- Checkout Section End -->

@endsection