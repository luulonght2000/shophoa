
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
          <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Shop /</span> Order</h4>
        </div>
      </div>
      
      <div class="row">
        <div class="mb-6 col-md-12">
          <ul class="nav nav-pills flex-column flex-md-row mb-3">
            <li class="nav-item" style="margin-left: 10px">
              <a class="nav-link active" href="{{url('admin/export-order')}}">Export Order</a>
            </li>
          </ul>
        </div>
        <div class="mb-6 col-md-12">
          <div class="card mb-4">
            <div  class="mb-6 col-md-12">
              <h5 class="card-header">Quản lý đơn hàng</h5>
            </div>
            <div class="row">
              <div  class="mb-3 col-md-6"> 
                <form action="" class="form-inline">
                  <div class="input-group" style="padding: 20px">
                    <select class="form-select" name="payment_key" aria-label="Default select example">
                      <option value="">Tất cả</option>
                      <option value="Đã thanh toán">Đã thanh toán</option>
                      <option value="Đang chờ xử lý">Đang chờ xử lý</option>
                    </select>
                    <button type="submit" class="btn btn-outline-primary">search</button>
                  </div>
                </form>
              </div>
              <div  class="mb-3 col-md-6">                
                <form action="" class="form-inline">
                  <div class="input-group" style="padding: 20px">
                    <select class="form-select" name="key" aria-label="Default select example">
                      <option value="">Tất cả</option>
                      <option value="Giao hàng thành công">Giao hàng thành công</option>
                      <option value="Đang giao hàng">Đang giao hàng</option>
                      <option value="Đang chờ xử lý">Đang chờ xử lý</option>
                    </select>
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
              @if(session('error'))
              <div class="alert alert-warning">
                  {{session('error')}}
              </div>
              @endif
                <div class="row">
                  <div class="mb-6 col-md-12">
                    <div class="table-wrapper-scroll-y my-custom-scrollbar">
                      <table class="table table-hover table-dark" border="1" >
                        <thead>
                          <tr>
                            <th>Tên người đặt</th>
                            <th>Tổng giá tiền</th>
                            <th>Tình trạng</th>
                            <th>Thanh toán</th>
                            <th>Hiển thị</th>
                          </tr>
                        </thead>
                  
                        @foreach($all_order as $order)
                        <tr>
                          <td>{{$order->name}}</td>
                          <td>{{$order->order_total}}</td>
                          <td>{{$order->order_status}}</td>
                          <td>{{$order->payment_status}}</td>
                  
                          <td>
                            <a href="{{route('order.edit', ['order'=>$order->order_id])}}"><button type="button" class="btn btn-success" style="width: 100px">Xem</button></a>
                  
                            <form action="{{route('order.destroy', ['order'=>$order->order_id])}}" method="POST" onsubmit="return(confirm('Bạn có thực sự muốn xóa?'))">
                              @method('DELETE')
                              @csrf
                              <button type="submit" class="btn btn-danger" style="width: 100px; margin-top: 10px">Xóa</button>
                            </form>
                          </td>
                        </tr>
                        @endforeach
                      </table>
                    </div><br>
                    <div class="pagination justify-content-center">
                      {{$all_order->onEachSide(5)->links()}}
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

    

   