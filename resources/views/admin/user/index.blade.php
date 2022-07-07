
@extends('admin.master')
@section('content')
  <!-- Content wrapper -->
  <div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
      <div class="row">
        <div class="mb-3 col-md-6">
          <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Shop /</span> User</h4>
        </div>
      </div>
      
      <div class="row">
        <div class="mb-6 col-md-12">
          <ul class="nav nav-pills flex-column flex-md-row mb-3">
            <li class="nav-item">
              <a class="nav-link active" href="{{url('admin/user/create')}}">Add User</a>
            </li>
            <li class="nav-item" style="margin-left: 10px">
              <a class="nav-link active" href="{{url('admin/export-user')}}">Export User</a>
            </li>
          </ul>
          <div class="card mb-4">
            <div class="row">
              <div  class="mb-3 col-md-6">
                <h5 class="card-header">List User</h5>
              </div>

              <div  class="mb-3 col-md-6">
                <form action="" class="form-inline">
                  <div class="input-group" style="padding: 20px">
                      <input type="search" class="form-control rounded" name="key" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
                      <button type="submit" class="btn btn-outline-primary">search</button>
                  </div>
              </form>
              </div>
            </div>
            
            <!-- Account -->
            <hr class="my-0" />
            <div class="card-body">
              <div class="row">
                <div class="nav-align-top mb-4">
                  <ul class="nav nav-pills mb-3" role="tablist">
                    <li class="nav-item">
                      <button
                        type="button"
                        class="nav-link active"
                        role="tab"
                        data-bs-toggle="tab"
                        data-bs-target="#navs-pills-top-home"
                        aria-controls="navs-pills-top-home"
                        aria-selected="true"
                      >
                        User
                      </button>
                    </li>
                    <li class="nav-item">
                      <button
                        type="button"
                        class="nav-link"
                        role="tab"
                        data-bs-toggle="tab"
                        data-bs-target="#navs-pills-top-profile"
                        aria-controls="navs-pills-top-profile"
                        aria-selected="false"
                      >
                        User Admin
                      </button>
                    </li>
                  </ul>
                  <div class="tab-content">
                    <div class="tab-pane fade show active" id="navs-pills-top-home" role="tabpanel">
                      <table class="table table-hover table-dark" border="1">
                        <thead>
                          <tr>
                            <th>Ảnh</th>
                            <th>FullName</th>
                            <th>Giới tính</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Địa chỉ</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                  
                        @foreach($users as $user)
                        <tr>
                          <td>
                            @if(file_exists(public_path("/uploads_user/{$user->id}.jpg")))
                            <img width="100" height="100" src={{"/uploads_user/{$user->id}.jpg"}} alt="">
                            @else
                            <img width="100" height="100" src={{"/uploads_admin/no_photo.jpg"}} alt="">
                            @endif
                          </td>
                          <td>{{$user->name}}</td>
                          <td>{{$user->sex?"Nam":"Nữ"}}</td>
                          <td>{{$user->email}}</td>
                          <td>{{$user->phone}}</td>
                          <td>{{$user->address}}</td>
                          <td>
                            <form action="{{route('user.destroy', ['user'=>$user->id])}}" method="POST" onsubmit="return(confirm('bạn có thực sự muốn xóa?'))">
                              @method('DELETE')
                              @csrf
                              <button type="submit" class="btn btn-icon btn-outline-danger">
                                <i class="bx bx-trash-alt"></i>
                              </button>
                            </form>
                          </td>
                        </tr>
                        @endforeach
                      </table>
                    </div>
                    <div class="tab-pane fade" id="navs-pills-top-profile" role="tabpanel">
                      <table class="table table-hover table-dark" border="1">
                        <thead>
                          <tr>
                            <th>Ảnh</th>
                            <th>FullName</th>
                            <th>Giới tính</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Địa chỉ</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                  
                        @foreach($user_admins as $user_admin)
                        <tr>
                          <td>
                            @if(file_exists(public_path("./uploads_admin/{$user_admin->id}.jpg")))
                            <img width="100" height="100" src={{"/uploads_admin/{$user_admin->id}.jpg"}} alt="">
                            @else
                            <img width="100" height="100" src={{"/uploads_admin/no_photo.jpg"}} alt="">
                            @endif
                          </td>
                          <td>{{$user_admin->name}}</td>
                          <td>{{$user_admin->sex?"Nam":"Nữ"}}</td>
                          <td>{{$user_admin->email}}</td>
                          <td>{{$user_admin->phone}}</td>
                          <td>{{$user_admin->address}}</td>
                          <td>
                            <form action="{{route('user.destroy', ['user'=>$user_admin->id])}}" method="POST" onsubmit="return(confirm('bạn có thực sự muốn xóa?'))">
                              @method('DELETE')
                              @csrf
                              <button type="submit" class="btn btn-icon btn-outline-danger">
                                <i class="bx bx-trash-alt"></i>
                              </button>
                            </form>
                          </td>
                        </tr>
                        @endforeach
                      </table>
                    </div> 
                  </div>
                </div>
              </div>
            </div>
            <!-- /Account -->
          </div>
        </div>
      </div>
    </div>
    <!-- / Content -->
@endsection

    

   