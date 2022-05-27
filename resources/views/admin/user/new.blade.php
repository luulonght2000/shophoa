
@extends('admin.master')
@section('content')
  <!-- Content wrapper -->
  <div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
      <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Shop / User /</span> New</h4>

      <div class="row">
        <div class="col-md-12">
          <div class="card mb-4">
            <h5 class="card-header" style="color: red">Create new User</h5>
            <hr class="my-0" />
            <div class="card-body">
              <div class="container">
                <form action="{{ route('user.store') }}" method="post">
                  @csrf
                  <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                      <input class="form-control" placeholder="Họ và tên" name="name" type="text" value="{{ old('name') }}" autofocus>
                    </div><br>
                    <span style="color: red" class="error-message">{{ $errors->first('name') }}</span>
                  </div>

                  <div class="form-group">
                    <div class="mb-6 col-md-12">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                        <input class="form-control" placeholder="Email" name="email" type="text" value="{{ old('email') }}">
                    </div>
                    <span style="color: red" class="error-message">{{ $errors->first('email') }}</span> 
                  </div><br>

                  <div class="form-group">
                    <div class="mb-6 col-md-12">
                      <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                      <input type="number" class="col-sm-10 form-control" id="phone" placeholder="Phone" name="phone" value="{{ old('phone') }}" required>
                    </div>
                  </div><br>

                  <div class="mb-3 form-password-toggle">
                    <div class="input-group input-group-merge">
                      <input
                        type="password"
                        id="password"
                        class="form-control"
                        name="password"
                        placeholder="Mật khẩu"
                        aria-describedby="password"
                      />
                      <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                    </div>
                    <span style="color: red" class="error-message">{{ $errors->first('password') }}</span>
                  </div>
  
                  <div class="mb-3 form-password-toggle">
                    <div class="input-group input-group-merge">
                      <input
                        type="password"
                        id="password"
                        class="form-control"
                        name="password_confirmation"
                        placeholder="Xác nhận mật khẩu"
                        aria-describedby="password"
                      />
                      <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                    </div>
                    <span style="color: red" class="error-message">{{ $errors->first('password') }}</span>
                  </div>

                  <div class="row">
                    <div class="mb-3 col-md-6">
                      <label class="col-form-label" for="DOB">Ngày sinh</label>
                      <input class="form-control" placeholder="Ngày tháng năm sinh" name="DOB" type="date" value="{{ old('DOB') }}" autofocus>
                      <span style="color: red" class="error-message">{{ $errors->first('DOB') }}</span>
                    </div>

                    <div class="mb-3 col-md-6">
                      <label class=" col-form-label" for="sex">Giới tính</label>
                      <input type="radio" class="form-check-input" id="sex" placeholder="Giới tính" name="sex" value="1" {{old('sex')?"checked":""}}">Nam

                      <input type="radio" class="form-check-input" id="sex" placeholder="Giới tính" name="sex" value="0" {{old('sex')?"":"checked"}}">NỮ
                    </div>
                  </div>
  
                  <button type="submit" class="btn btn-primary me-2">Save</button>
                  <button type="reset" class="btn btn-outline-secondary">Reset</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- / Content -->
@endsection

    

   