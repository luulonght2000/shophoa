
@extends('admin.master')
@section('content')
  <!-- Content wrapper -->
  <div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
      <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Shop / User /</span> Edit</h4>

      <div class="row">
        <div class="col-md-12">
          <div class="card mb-4">
            <h5 class="card-header" style="color: red">Edit Flower</h5>
            <hr class="my-0" />
            <div class="card-body">
              <form action="{{route('user.update', ['user'=>$user->id])}}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                  <div class="mb-3 col-md-6">
                    <label class="col-sm-2 col-form-label" for="name">Tên</label>
                    <input type="text" class="col-sm-10 form-control" id="name" placeholder="Tên " name="name" value="{{count($errors)?old('name'):$user->name}}">
                    <span class="error-message" style="color: red">{{ $errors->first('name') }}</span>
                  </div>
                  <div class="mb-3 col-md-6">
                    <label class="col-sm-2 col-form-label" for="size">Email</label>
                    <input type="text" class="col-sm-10 form-control" id="email" placeholder="Email" name="email" value="{{count($errors)?old('email'):$user->email}}">
                  </div>
                  <div class="mb-6 col-md-12">
                    <label class="col-sm-2 col-form-label" for="avatar">Ảnh</label>
                    <div class="col-sm-10">
                      @if(file_exists(public_path("./uploads_user/{$user->id}.jpg")))
                      <img width="320" height="300" src={{"/uploads_user/{$user->id}.jpg"}} alt="">
                      @else
                      <img width="320" height="300" src={{"/uploads_user/no_photo.png"}} alt="">
                      @endif
                      <input type="file" class="form-control" id="avatar" placeholder="Ảnh thẻ" name="avatar" value="{{old('avatar')}}">
                      <span class="error-message" style="color: red">{{ $errors->first('avatar') }}</span>
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

    

   