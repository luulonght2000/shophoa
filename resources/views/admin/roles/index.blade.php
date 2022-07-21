
@extends('admin.master')
@section('content')
  <!-- Content wrapper -->
  <div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
      <div class="row">
        <div class="mb-3 col-md-6">
          <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Shop /</span> Role</h4>
        </div>
      </div>
      
      <div class="row">
        <div class="col-md-12">
          <ul class="nav nav-pills flex-column flex-md-row mb-3">
            <li class="nav-item">
              <a class="nav-link active" href="{{url('admin/role/create')}}">Add Role</a>
            </li>
          </ul>
          <div class="card mb-4">
            <h5 class="card-header">List Role</h5>
            @if ($message = Session::get('success'))
                   <div class="alert alert-success alert-block">
                     <strong>{{ $message }}</strong>
                   </div>
                   <br>
                   @endif
            <!-- Account -->
            <hr class="my-0" />
            <div class="card-body">
                <div class="row">
                  <div class="mb-6 col-md-12">
                    <table class="table table-hover table-dark" border="1">
                      <thead>
                        <tr >
                          <th>Chức vụ</th>
                          {{-- <th>Active</th> --}}
                          <th>Action</th>
                        </tr>
                      </thead>
                      @foreach($roles as $role)
                      <tr>
                        <td style="text-transform: capitalize">{{$role->name}}</td>
                        {{-- <td>{{$role->feature?"Nổi bật":"Không nổi bật"}}</td> --}}
                        <td>
                          <a style=" float: left;" href="{{route('role.edit', ['role'=>$role->id])}}"><button type="button" class="btn btn-success">Sửa</button></a>
                  
                          <form action="{{route('role.destroy', ['role'=>$role->id])}}" method="POST" onsubmit="return(confirm('bạn có thực sự muốn xóa?'))">
                            @method('DELETE')
                            @csrf
                            <button  type="submit" class="btn btn-danger">Xóa</button>
                          </form>
                        </td>
                      </tr>
                      @endforeach
                    </table>
                  <br>
                  
                    <div class="pagination justify-content-center">
                      {{$roles->onEachSide(5)->links()}}
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

    

   