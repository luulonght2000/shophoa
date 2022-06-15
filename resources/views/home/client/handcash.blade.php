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
        @if(session()->has('success'))
        <div class="alert alert-success" style="font-size: 30px">
          {{ session()->get('success') }}
        </div>
        @endif
        <div class="home">
          <a href="{{url('/')}}" class="btn btn-info" role="button">Tiếp tục mua hàng</a>
        </div>
      </div>
    </section>
    <!-- Checkout Section End -->

@endsection