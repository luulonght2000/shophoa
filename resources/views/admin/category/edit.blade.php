
@extends('admin.master')
@section('content')
  <!-- Content wrapper -->
  <div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
      <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Shop / Category /</span> Edit</h4>

      <div class="row">
        <div class="col-md-12">
          <div class="card mb-4">
            <h5 class="card-header" style="color: red">Edit Category Flower</h5>
            <hr class="my-0" />
            <div class="card-body">
              <form action="{{route('category.update', ['category'=>$category->id])}}" method="post">
                @csrf
                @method('PUT')
                <div class="row">
                  <div class="mb-3 col-md-6">
                    <label class="col-sm-3 col-form-label" for="name">Tên loại hoa</label>
                    <input type="text" class="col-sm-10 form-control" id="name" placeholder="Tên loại hoa" name="name" value="{{count($errors)?old('name'):$category->name}}">
                    <span class="error-message" style="color: red">{{ $errors->first('name') }}</span>
                  </div>
                  <div class="mb-3 col-md-6">
                    <label class="col-sm-2 col-form-label" for="feature">Đặc biệt</label>
                    <input type="radio" class="form-check-inline" id="feature" placeholder="Đặc biệt" name="feature" value="1" {{(count($errors)?old('feature'):$category->feature)?"checked":""}}">Có

                    <input style="margin-left: 2000" type="radio" class="form-check-inline" id="feature" placeholder="Đặc biệt" name="feature" value="0" {{(count($errors)?old('feature'):$category->feature)?"":"checked"}}">Không

                    <br><span class="error-message" style="color: red">{{ $errors->first('feature') }}</span>
                  </div>
                  
                  <div class="mb-6 col-md-12">
                    <label class="col-sm-2 col-form-label" for="description">Mô tả</label>
                    <textarea class="col-sm-10 form-control" id="description" placeholder="Mô tả" name="description">{{count($errors)?old('description'):$category->description}}</textarea>
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

    

   