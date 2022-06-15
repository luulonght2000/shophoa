@extends('layouts.app')

@section('content')

<style>
  #imageGallery img{
    width: 100%;
  }
</style>
<section class="product-details spad">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6">
        <div class="product__details__pic">
          <ul id="imageGallery">
            <li data-thumb="{{"/uploads/$product->id.jpg"}}" data-src="{{"/uploads/$product->id.jpg"}}">
              <img src="{{"/uploads/$product->id.jpg"}}" alt="Không có ảnh" style="height: 600px"/>
            </li>
            @for ($i=1; $i<4; $i++)
              <li data-thumb="{{"/files/$product->id-$i.jpg"}}" data-src="{{"/files/$product->id-$i.jpg"}}">
                <img src="{{"/files/$product->id-$i.jpg"}}" style="height: 600px" />
              </li>
            @endfor
          </ul>
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
          <form action="{{'/save-cart'}}" method="POST">
            @csrf
            <div class="product__details__price">Giá bán: {{$product->price}}đ
              <p style="display: inline; text-decoration: line-through">{{$product->old_price}}đ</p>
            </div>
            <p>{{$product->description}}</p>
            <div class=" product__details__quantity">
              <div class="quantity">
                <div class="pro-qty">
                  <input name="qty" type="number" min="1" value="1">
                </div>
              </div>
            </div>
            <input name="productid_hidden" type="hidden" value="{{$product->id}}">
            <button type="submit" class="btn btn-success"><i class="fa fa-shopping-cart"></i>Add To Cart</button>
          </form>
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