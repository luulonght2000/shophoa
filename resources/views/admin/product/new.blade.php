
@extends('admin.master')
@section('content')
  <!-- Content wrapper -->
  <div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
      <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Shop / Product /</span> New</h4>

      <div class="row">
        <div class="col-md-12">
          <div class="card mb-4">
            <h5 class="card-header" style="color: red">Create new Flower</h5>
            <hr class="my-0" />
            <div class="card-body">
              <form action="{{route('product.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                  <div class="mb-3 col-md-6">
                    <label class="col-sm-2 col-form-label" for="name">Tên hoa</label>
                    <input type="text" class="col-sm-10 form-control" id="name" placeholder="Tên hoa" name="name" value="{{old('name')}}">
                    <span class="error-message" style="color: red">{{ $errors->first('name') }}</span>
                  </div>
                  <div class="mb-3 col-md-6">
                    <label class="col-sm-2 col-form-label" for="category_id">Loại hoa</label>
                    <select class="col-sm-10 form-control" id="category_id" placeholder="Loại hoa" name="category_id" value="{{old('name')}}">
                      @foreach($categories as $category)
                      <option value="{{$category->id}}">{{$category->name}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="mb-6 col-md-12">
                    <label class="col-sm-2 col-form-label" for="avatar">Ảnh thẻ</label>
                    <input type="file" class="col-sm-10 form-control" id="avatar" placeholder="Ảnh thẻ" name="avatar" value="{{old('avatar')}}">
                    <span class="error-message" style="color: red">{{ $errors->first('avatar') }}</span>
                  </div>

                  <div class="mb-3 col-md-6">
                    <label class="col-sm-2 col-form-label" for="size">Kích cỡ</label>
                    <input type="text" class="col-sm-10 form-control" id="size" placeholder="Kích cỡ" name="size" value="{{old('size')}}">
                  </div>

                  <div class="mb-3 col-md-6">
                    <label class="col-sm-2 col-form-label" for="style_id">Kiểu hoa</label>
                    <select class="col-sm-10 form-control" id="style_id" placeholder="Kiểu hoa" name="style_id" value="{{old('name')}}">
                      @foreach($styles as $style)
                      <option value="{{$style->id}}">{{$style->name}}</option>
                      @endforeach
                    </select>
                    <span class="error-message">{{ $errors->first('style_id') }}</span>
                  </div>

                  <div class="mb-3 col-md-6">
                    <label class="col-sm-2 col-form-label" for="price">Giá bán</label>
                    <input type="number" class="col-sm-10 form-control" id="price" placeholder="Giá bán" name="price" value="{{old('price')}}">
                    <span class="error-message" style="color: red">{{ $errors->first('price') }}</span>
                  </div>
            
                  <div class="mb-3 col-md-6">
                    <label class="col-sm-2 col-form-label" for="old_price">Giá cũ</label>
                    <input type="number" class="col-sm-10 form-control" id="old_price" placeholder="Giá cũ" name="old_price" value="{{old('old_price')}}">
                    <span class="error-message" style="color: red">{{ $errors->first('old_price') }}</span>
                  </div>

                  <div class="mb-6 col-md-12">
                    <label class="col-sm-2 col-form-label" for="description">Mô tả</label>
                    <textarea style="resize: none" class=" form-control" id="ckeditor1" placeholder="Mô tả" name="description">{{old('description')}}</textarea>
                  </div>
                </div>

                <div class="mt-2">
                  <button type="submit" class="btn btn-primary me-2">Save changes</button>
                  <button type="reset" class="btn btn-outline-secondary">Reset</button>
                </div>

                {{-- <div class="form-group row">
                  <input type="submit" class="col-sm-2 form-control" value="Thêm">
                  <input type="reset" class="col-sm-2 form-control" value="Nhập lại">
                </div> --}}
              </form>
            </div>
            <!-- /Account -->
          </div>
        </div>
      </div>
    </div>
    <!-- / Content -->
@endsection

    

   