
@extends('admin.master')
@section('content')
  <!-- Content wrapper -->
  <div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
      <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Shop / Product /</span> Edit</h4>

      <div class="row">
        <div class="col-md-12">
          <div class="card mb-4">
            <h5 class="card-header" style="color: red">Edit Flower</h5>
            <hr class="my-0" />
            <div class="card-body">
              <form action="{{route('product.update', ['product'=>$product->id])}}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                  <div class="mb-3 col-md-6">
                    <label class="col-sm-2 col-form-label" for="name">Tên hoa</label>
                    <input type="text" class="col-sm-10 form-control" id="name" placeholder="Tên hoa" name="name" value="{{count($errors)?old('name'):$product->name}}">
                    <span class="error-message" style="color: red">{{ $errors->first('name') }}</span>
                  </div>
                  <div class="mb-3 col-md-6">
                    <label class="col-sm-2 col-form-label" for="category_id">Loại hoa</label>
                    <select class="col-sm-10 form-control" id="category_id" placeholder="Loại hoa" name="category_id" value="{{old('name')}}">
                      <?php
                      $current_category_id = count($errors) ? old('category_id') : $product->category_id;
                      ?>
                      @foreach($categories as $category)
                      <option value="{{$category->id}}" <?php echo $category->id == $current_category_id ? "selected" : ""; ?>>{{$category->name}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="mb-6 col-md-12">
                    <label class="col-sm-2 col-form-label" for="avatar">Ảnh</label>
                    <div class="col-sm-10">
                      @if(file_exists(public_path("./uploads/{$product->id}.jpg")))
                      <img width="320" height="300" src={{"/uploads/{$product->id}.jpg"}} alt="">
                      @else
                      <img width="320" height="300" src={{"/uploads/no_photo.png"}} alt="">
                      @endif
                      <input type="file" class="form-control" id="avatar" placeholder="Ảnh thẻ" name="avatar" value="{{old('avatar')}}">
                      <span class="error-message" style="color: red">{{ $errors->first('avatar') }}</span>
                    </div>
                  </div>

                  <div class="mb-3 col-md-6">
                    <label class="col-sm-2 col-form-label" for="size">Kích cỡ</label>
                    <input type="text" class="col-sm-10 form-control" id="size" placeholder="Kích cỡ" name="size" value="{{count($errors)?old('size'):$product->size}}">
                  </div>

                  <div class="mb-3 col-md-6">
                    <label class="col-sm-2 col-form-label" for="style_id">Kiểu hoa</label>
                    <select class="col-sm-10 form-control" id="style_id" placeholder="Kiểu hoa" name="style_id" value="{{old('name')}}">
                      <?php
                      $current_style_id = count($errors) ? old('style_id') : $product->style_id;
                      ?>
                      @foreach($styles as $style)
                      <option value="{{$style->id}}" <?php echo $style->id == $current_style_id ? "selected" : ""; ?>>{{$style->name}}</option>
                      @endforeach
                    </select>
                    <span class="error-message">{{ $errors->first('style_id') }}</span>
                  </div>

                  <div class="mb-3 col-md-6">
                    <label class="col-sm-2 col-form-label" for="price">Giá bán</label>
                    <input type="number" class="col-sm-10 form-control" id="price" placeholder="Giá bán" name="price" value="{{count($errors)?old('price'):$product->price}}">
                    <span class="error-message" style="color: red">{{ $errors->first('price') }}</span>
                  </div>
            
                  <div class="mb-3 col-md-6">
                    <label class="col-sm-2 col-form-label" for="old_price">Giá cũ</label>
                    <input type="number" class="col-sm-10 form-control" id="old_price" placeholder="Giá cũ" name="old_price" value="{{count($errors)?old('old_price'):$product->old_price}}">
                    <span class="error-message" style="color: red">{{ $errors->first('old_price') }}</span>
                  </div>

                  <div class="mb-6 col-md-12">
                    <label class="col-sm-2 col-form-label" for="description">Mô tả</label>
                    <textarea class="col-sm-10 form-control" id="ckeditor1" name="description">{{count($errors)?old('description'):$product->description}}</textarea>
                  </div>
                </div>

                <div class="mt-2">
                  <button type="submit" class="btn btn-primary me-2">Save changes</button>
                  <button type="reset" class="btn btn-outline-secondary">Reset</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- / Content -->
@endsection

    

   