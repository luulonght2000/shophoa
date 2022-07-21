@extends('layouts.app')

@section('content')


<!-- Breadcrumb Section End -->

<!-- Blog Section Begin -->
<section class="blog spad">
  <div class="container" style="margin-top: -100px">
    <div class="row">
      <div class="col-md-12">
        
        <div class="card mb-4">
          <h5 class="card-header">Profile Details</h5>
          @if(session('success'))
          <div class="alert alert-info">
              {{session('success')}}
          </div>
          @endif
          <!-- Account -->
          <hr class="my-0" />
          <div class="card-body">
            <form action="{{route('profile.update', ['profile'=>$user->id])}}" method="post" enctype="multipart/form-data">
              @csrf
              @method('PUT')
              <div class="card-body">
                <div class="d-flex align-items-start align-items-sm-center gap-4">
                  @if(file_exists(public_path("/uploads_user/{$user->id}.jpg")))
                  <img width="100" height="100" src={{"/uploads_user/{$user->id}.jpg"}} alt="user-avatar" class="d-block rounded">
                  @else
                  <img width="100" height="100" src={{"/uploads_admin/no_photo.jpg"}} alt="user-avatar" class="d-block rounded">
                  @endif
                  
                  <div class="button-wrapper">
                    <label for="avatar" class="btn btn-primary me-2 mb-4" tabindex="0">
                      <span class="d-none d-sm-block">Upload new photo</span>
                      <i class="bx bx-upload d-block d-sm-none"></i>
                      <input type="file" class="form-control" id="avatar" placeholder="Ảnh thẻ" hidden name="avatar" value="{{old('avatar')}}">
                      <span class="error-message" style="color: red">{{ $errors->first('avatar') }}</span>
                    </label>
                    <p class="text-muted mb-0">Allowed JPG, GIF or PNG. Max size of 800K</p>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="mb-6 col-md-12">
                  <label class="col-sm-3 col-form-label" for="name">Name</label>
                  <input type="text" class="col-sm-12 form-control" id="name" placeholder="Tên" name="name" value="{{count($errors)?old('name'):$user->name}}" required>
                </div>
              </div>
              <div class="row">
                <div class="mb-3 col-md-6">
                  <label class="col-sm-3 col-form-label" for="email">Email</label>
                  <input type="email" class="col-sm-10 form-control" id="email" placeholder="Email" name="email" value="{{count($errors)?old('email'):$user->email}}">
                  <span class="error-message" style="color: red">{{ $errors->first('email') }}</span>
                </div>
                <div class="mb-3 col-md-6">
                  <label class="col-sm32 col-form-label" for="email">Phone</label>
                  <input type="number" class="col-sm-10 form-control" id="phone" placeholder="Phone" name="phone" value="{{count($errors)?old('phone'):$user->phone}}" required>
                </div>
              </div>

              <div class="row">
                <div class="mb-3 col-md-6">
                  <label class="col-sm-3 col-form-label" for="DOB">Ngày sinh</label>
                  <input type="date" class="col-sm-10 form-control" id="DOB" placeholder="Ngày sinh" name="DOB" value="{{count($errors)?old('DOB'):(new DateTime($user->DOB))->format('Y-m-d')}}">
                </div>

                <div class="mb-3 col-md-6">
                  <label class="col-sm-3 col-form-label" for="sex">Giới tính:</label>
                  <label class="col-sm-3 col-form-label" for="sex">{{$user->sex?"Nam":"Nữ"}}</label>
                  <input type="radio" class="form-check-inline" id="sex" placeholder="Giới tính" name="sex" value="1" {{old('sex')?"checked":""}}">Nam

                  <input style="margin-left: 2000" type="radio" class="form-check-inline" id="sex" placeholder="Giới tính" name="sex" value="0" {{old('sex')?"":"checked"}}">Nữ
                  <br>
                  <span class="error-message" style="color: red">{{ $errors->first('sex') }}</span>
                </div>
              </div>
              <div class="row">
                <div class="mb-6 col-md-12">
                  <label class="col-sm-3 col-form-label" for="name">Địa chỉ</label>
                  <input type="text" class="col-sm-12 form-control" id="address" placeholder="Địa chỉ" name="address" value="{{count($errors)?old('address'):$user->address}}" required>
                </div>
              </div>
              <div class="mt-2">
                <button type="submit" class="btn btn-primary me-2">Save changes</button>
                <button type="reset" class="btn btn-outline-secondary">Reset</button>
              </div>
            </form>
          </div>
          <!-- /Account -->
        </div>
      </div>
    </div>
  </div>
</section>
<!-- Blog Section End -->

@endsection