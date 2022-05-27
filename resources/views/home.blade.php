@extends('layouts.app')

@section('content')
<section class="featured spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <h2>Featured Product</h2>
                </div>
                <!-- <div class="featured__controls">
                    <ul>
                        <li class="active" data-filter="*">All</li>
                        <li data-filter=".oranges">Oranges</li>
                        <li data-filter=".fresh-meat">Fresh Meat</li>
                        <li data-filter=".vegetables">Vegetables</li>
                        <li data-filter=".fastfood">Fastfood</li>
                    </ul>
                </div> -->
            </div>
        </div>
        <div class="row featured__filter">
            @foreach($products as $product)
                @if ($product->product_status == 0)
                <div class="col-lg-3 col-md-4 col-sm-6 mix ">
                    <div class="product__item">
                        <div class="product__item__pic set-bg">
                            @if(file_exists(public_path("./uploads/{$product->id}.jpg")))
                            <img width="100%" height="350px" src={{"/uploads/$product->id.jpg"}} alt="">
                            @else
                            <img width="100%" height="350px" src={{"/uploads/no_photo.png"}} alt="">
                            @endif
                            <ul class="product__item__pic__hover">
                                <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                <li><a href="/productDetail/{{$product->id}}"><i class="fa fa-retweet"></i></a></li>
                                <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                            </ul>
                        </div>
                        <div class="featured__item__text">
                            <h6 style="text-transform: capitalize"><a href="/productDetail/{{$product->id}}">{{$product->name}}</a></h6>
                            <h5>{{$product->price}}
                                <p style="display: inline; color: red; text-decoration: line-through">{{$product->old_price}}</p>
                            </h5>
                        </div>
                    </div>
                </div>
                @endif
            @endforeach
        </div>
    </div>
</section>
@endsection