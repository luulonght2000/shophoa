
@extends('admin.master')
@section('content')
  <!-- Content wrapper -->
  <div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
      <div class="row">
        <div class="mb-3 col-md-6">
          <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Shop /</span> Style</h4>
        </div>
      </div>
      
      <div class="row">
        <div class="col-md-12">
          <ul class="nav nav-pills flex-column flex-md-row mb-3">
            <li class="nav-item">
              <a class="nav-link active" href="{{url('admin/style/create')}}">Add Style</a>
            </li>
          </ul>
          <div class="card mb-4">
            <h5 class="card-header">List Style</h5>
            <!-- Account -->
            <hr class="my-0" />
            <div class="card-body">
                <div class="row">
                  <div class="mb-6 col-md-12">
                    <table class="table table-hover table-dark" border="1">
                      <thead>
                        <tr >
                          <th style="width: 25%">Kiểu hoa</th>
                          <th>Description</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      @foreach($styles as $style)
                      <tr>
                        <td>{{$style->name}}</td>
                        <td>{{$style->description}}</td>
                        <td>
                          <a style=" float: left;" href="{{route('style.edit', ['style'=>$style->id])}}"><button type="button" class="btn btn-success">Sửa</button></a>
                  
                          <form action="{{route('style.destroy', ['style'=>$style->id])}}" method="POST" onsubmit="return(confirm('bạn có thực sự muốn xóa?'))">
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
                      {{$styles->onEachSide(5)->links()}}
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

    

   