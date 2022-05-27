@extends('layouts.app')

@section('content')

<section class="product-details spad">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6">
        <div class="product__details__pic">
          <div class="product__details__pic__item">
            @if(file_exists(public_path("./uploads/{$product->id}.jpg")))
            <img width="100%" height="100%" src={{"/uploads/{$product->id}.jpg"}} alt="">
            @else
            <img width="100%" height="100%" src={{"/uploads/no_photo.png"}} alt="">
            @endif
          </div>
          <div class="product__details__pic__slider owl-carousel">
            <img data-imgbigurl="img/product/details/product-details-2.jpg" src="/img/product/details/thumb-1.jpg" alt="">
            <img data-imgbigurl="img/product/details/product-details-3.jpg" src="/img/product/details/thumb-2.jpg" alt="">
            <img data-imgbigurl="img/product/details/product-details-5.jpg" src="/img/product/details/thumb-3.jpg" alt="">
            <img data-imgbigurl="img/product/details/product-details-4.jpg" src="/img/product/details/thumb-4.jpg" alt="">
          </div>
        </div>
      </div>
      <div class="col-lg-6 col-md-6">
        <div class="product__details__text">
          <h3>{{$product->name}}</h3>
          <div class="product__details__rating">
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star-half-o"></i>
            <span>({{$product->viewed}})</span>
          </div>
          <div class="product__details__price">Giá bán: {{$product->price}}đ
            <p style="display: inline; text-decoration: line-through">{{$product->old_price}}</p>
          </div>
          <p>{{$product->description}}</p>
          <div class=" product__details__quantity">
            <div class="quantity">
              <div class="pro-qty">
                <input type="text" value="1">
              </div>
            </div>
          </div>
          <a href="#" class="primary-btn">Thanh Toán</a>
          <a href="#" class="heart-icon"><span class="icon_heart_alt"></span></a>
          <ul>
            <li><b>Availability</b> <span>In Stock</span></li>
            <li><b>Shipping</b> <span>01 day shipping. <samp>Free pickup today</samp></span></li>
            <li><b>Weight</b> <span>{{$product->weight}}</span></li>
            <li><b>Share on</b>
              <div class="share">
                <a href="#"><i class="fa fa-facebook"></i></a>
                <a href="#"><i class="fa fa-twitter"></i></a>
                <a href="#"><i class="fa fa-instagram"></i></a>
                <a href="#"><i class="fa fa-pinterest"></i></a>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>

    
  </div>
</section>

@endsection