
@extends('admin.master')
@section('content')
  <!-- Content wrapper -->
  <div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
      <div class="row">
        <div class="mb-3 col-md-6">
          <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Shop /</span> Category</h4>
        </div>
      </div>
      
      <div class="row">
        <div class="col-md-12">
          <ul class="nav nav-pills flex-column flex-md-row mb-3">
            <li class="nav-item">
              <a class="nav-link active" href="{{url('admin/category/create')}}">Add Category</a>
            </li>
          </ul>
          <div class="card mb-4">
            <h5 class="card-header">List Category</h5>
            <!-- Account -->
            <hr class="my-0" />
            <div class="card-body">
                <div class="row">
                  <div class="mb-6 col-md-12">
                    <table class="table table-hover table-dark" border="1">
                      <thead>
                        <tr >
                          <th>Tên loại hoa</th>
                          <th>feature</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      @foreach($categories as $category)
                      <tr>
                        <td>{{$category->name}}</td>
                        <td>{{$category->feature?"Nổi bật":"Không nổi bật"}}</td>
                        <td>
                          <a style=" float: left;" href="{{route('category.edit', ['category'=>$category->id])}}"><button type="button" class="btn btn-success">Sửa</button></a>
                  
                          <form action="{{route('category.destroy', ['category'=>$category->id])}}" method="POST" onsubmit="return(confirm('bạn có thực sự muốn xóa?'))">
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
                      {{$categories->onEachSide(5)->links()}}
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

    

   