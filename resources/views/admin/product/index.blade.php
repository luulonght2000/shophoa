
@extends('admin.master')
@section('content')

<style>
  .my-custom-scrollbar {
position: relative;
height: 500px;
overflow: auto;
}
.table-wrapper-scroll-y {
display: block;
}
</style>
  <!-- Content wrapper -->
  <div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
      <div class="row">
        <div class="mb-3 col-md-6">
          <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Shop /</span> Product</h4>
        </div>
      </div>
      
      <div class="row">
        <div class="row justify-content-centre" style="margin-bottom: 2%">
          <div class="col-md-8">
              <div class="card">
                  <div class="card-header bgsize-primary-4 white card-header">
                      <h4 class="card-title">Import Excel Data Product</h4>
                  </div>
                  <div class="card-body">
                   @if ($message = Session::get('success'))
                   <div class="alert alert-success alert-block">
                     <strong>{{ $message }}</strong>
                   </div>
                   <br>
                   @endif
                      <form action="{{url("admin/import-product")}}" method="post" enctype="multipart/form-data">
                          @csrf
                          <fieldset>
                              <label>Select File to Upload  <small class="warning text-muted">{{__('Please upload only Excel (.xlsx or .xls) files')}}</small></label>
                              <div class="input-group">
                                  <input type="file" required class="form-control" name="uploaded_file" id="uploaded_file">
                                  <div class="input-group-append" id="button-addon2">
                                      <button class="btn btn-primary square" type="submit"><i class="ft-upload mr-1"></i> Upload</button>
                                  </div>
                              </div>
                              @if ($errors->has('uploaded_file'))
                              <p style="color: red;">
                                <small>{{ $errors->first('uploaded_file') }}</small>
                              </p>
                              @endif
                          </fieldset>
                      </form>
                  </div>
              </div>
          </div>
        </div>
        <div class="mb-6 col-md-12">
          <ul class="nav nav-pills flex-column flex-md-row mb-3">
            <li class="nav-item">
              <a class="nav-link active" href="{{url('admin/product/create')}}">Add Product</a>
            </li>
            <li class="nav-item" style="margin-left: 10px">
              <a class="nav-link active" href="{{url('admin/export-product')}}">Export Product</a>
            </li>
          </ul>
          <div class="card mb-4">
            <div class="row">
              <div  class="mb-3 col-md-6">
                <h5 class="card-header">List Product</h5>
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
              @if(session('success'))
              <div class="col-sm-12">
                <div class="alert fade alert-simple alert-success font__family-montserrat font__size-16 font__weight-light brk-library-rendered rendered show">
                  <p>{{session('success')}}</p>
                </div>
              </div>
              @endif
                <div class="row">
                  <div class="mb-6 col-md-12">
                    <div class="table-wrapper-scroll-y my-custom-scrollbar">
                      <table class="table table-hover table-dark" border="1" >
                        <thead>
                          <tr style="text-align: center">
                            <th>Ảnh</th>
                            <th>Tên hoa</th>
                            <th>Loại hoa</th>
                            <th>Kiểu hoa</th>
                            <th>Giá</th>
                            <th>Hiển thị</th>
                            <th>Đã bán</th>
                            <th>Thao tác</th>
                          </tr>
                        </thead>
                  
                        @foreach($products as $product)
                        <tr>
                          <td>
                            @if(file_exists(public_path("./uploads/{$product->id}.jpg")))
                            <img width="75" height="100" src={{"/uploads/{$product->id}.jpg"}} alt="">
                            @else
                            <img width="75" height="100" src={{"/uploads/no_photo.png"}} alt="">
                            @endif
                          </td>
                          <td>{{$product->name}}</td>
                          <td>{{$product->category->name ?? 'None'}}</td>
                          <td>{{$product->style->name}}</td>
                          <td>{{number_format($product->price, 0, '', '.')}}đ</td>
                          <td>
                              @if ($product->product_status==0)
                                <a href="{{url('admin/unactive-product/'.$product->id)}}"><i class="fa-thumb-styling fa fa-thumbs-up" aria-hidden="false"></i></a>
                              @else
                                <a href="{{url('admin/active-product/'.$product->id)}}"><i class="fa-thumb-styling fa fa-thumbs-down" aria-hidden="false"></i></a>
                              @endif
                          </td>
                          <td>{{$product->sold}}</td>
                  
                          <td>
                            <a href="{{route('product.edit', ['product'=>$product->id])}}"><button type="button" class="btn btn-success" style="width: 80px">Sửa</button></a>
                  
                            <form action="{{route('product.destroy', ['product'=>$product->id])}}" method="POST" onsubmit="return(confirm('bạn có thực sự muốn xóa?'))">
                              @method('DELETE')
                              @csrf
                              <button type="submit" class="btn btn-danger" style="width: 80px; margin-top: 10px">Xóa</button>
                            </form>
                          </td>
                        </tr>
                        @endforeach
                      </table>
                    </div><br>
                    <div class="pagination justify-content-center">
                      {{$products->onEachSide(10)->links()}}
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

    

   