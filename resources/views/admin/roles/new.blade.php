
@extends('admin.master')
@section('content')
  <!-- Content wrapper -->
  <div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
      <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Shop / Role /</span> New</h4>

      <div class="row">
        <div class="col-md-12">
          <div class="card mb-4">
            <h5 class="card-header" style="color: red">Create new Role</h5>
            <hr class="my-0" />
            <div class="card-body">
              <form action="{{route('role.store')}}" method="post">
                @csrf
                <div class="row">
                  <div class="mb-3 col-md-6">
                    <label class="col-sm-3 col-form-label" for="name">Tên Chức Vụ</label>
                    <input type="text" class="col-sm-10 form-control" id="name" placeholder="Tên chức vụ" name="name" value="{{old('name')}}">
                    <span class="error-message" style="color: red">{{ $errors->first('name') }}</span>
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

    

   