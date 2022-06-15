
@extends('admin.master')
@section('content')

<style>
  .content{
    text-align: center;
  }

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
          <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Shop / Order</span> </h4>
        </div>
      </div>
      
      <div class="row">
        <div class="mb-6 col-md-12">
          <div class="card mb-4">
            
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
              <div class="col-sm-12">
                <div class="alert fade alert-simple alert-error font__family-montserrat font__size-16 font__weight-light brk-library-rendered rendered show">
                  <p>{{session('error')}}</p>
                </div>
              </div>
              @endif
                <div class="row">
                  <div class="mb-6 col-md-12">
                    <div class="table-wrapper-scroll-y my-custom-scrollbar">
                      <h3 class="content">Thông tin người đặt hàng</h3>
                      <table class="table table-hover table-dark" border="1">
                        <thead>
                          <tr>
                            <th>Tên người đặt</th>
                            <th>Số điện thoại</th>
                            <th>Hình thức thanh toán</th>
                            <th>
                              @if ($userInfo->payment_status==="Đã thanh toán")
                                <a href="{{url('admin/unactive-order/'.$userInfo->payment_id)}}">
                                  <button type="submit" class="btn btn-success" style="width: 200px" name="order_status">Chưa thanh toán</button>
                                </a>
                              @else
                                <a href="{{url('admin/active-order/'.$userInfo->payment_id)}}">
                                  <button type="submit" class="btn btn-success" style="width: 200px" name="order_status">Đã thanh toán</button>
                                </a>
                              @endif
                            </th>
                          </tr>
                        </thead>
                  
                        
                        <tr>
                          <td>{{$userInfo->name}}</td>
                          <td>{{$userInfo->phone}}</td>
                          <td>{{$userInfo->payment_option}}</td>
                          <td>{{$userInfo->payment_status}}</td>
                        </tr>
                        
                      </table>
                      <br><br>

                      <h3 class="content">Thông tin vận chuyển</h3>
                      <table class="table table-hover table-dark" border="1">
                        <thead>
                          <tr>
                            <th>Tên người nhận</th>
                            <th>Số điện thoại</th>
                            <th>Địa chỉ</th>
                            <th>Ghi chú</th>
                          </tr>
                        </thead>
                  
                        <tr>
                          <td>{{$userInfo->shipping_name}}</td>
                          <td>{{$userInfo->shipping_phone}}</td>
                          <td>{{$userInfo->shipping_address}}</td>
                          <td>{{$userInfo->shipping_note}}</td>
                        </tr>
                        
                      </table>

                      <br><br>
                      <h3 class="content">Chi tiết đơn hàng</h3>
                      <table class="table table-hover table-dark" border="1">
                        <thead>
                          <tr>
                            <th>Tên sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Giá</th>
                            <th>Tổng tiền</th>
                          </tr>
                        </thead>
                        @foreach($order_by_id as $key => $order)
                        <tr>
                          <td>{{$order->product_name}}</td>
                          <td>{{$order->product_sales_quantity}}</td>
                          <td>{{$order->product_price}}</td>
                          <td>{{$order->product_price*$order->product_sales_quantity}}</td>
                        </tr>
                        @endforeach
                      </table>
                    </div><br>
                    <div style="float: left;">
                      <a href="{{url('/admin/manage-order')}}"><button type="button" class="btn btn-success" style="width: 150px">Quay lại</button></a>
                    </div>
                    @if ($order_id->order_status ==="Đang chờ xử lý")
                    <form action='{{ url("/admin/order_status/$order_id->order_id") }}' method="post" enctype="multipart/form-data">
                      @csrf
                      @method('PUT')
                      <div style="float: right;">
                        <button type="submit" class="btn btn-success" style="width: 200px" name="shipping" value="Đang giao hàng">Giao hàng</button>
                      </div>
                    </form>
                    @elseif ($order_id->order_status ==="Đang giao hàng")
                    <form action='{{ url("/admin/order_status/$order_id->order_id") }}' method="post" enctype="multipart/form-data">
                      @csrf
                      @method('PUT')
                      <div style="float: right;">
                        <button type="submit" class="btn btn-success" style="width: 200px" name="shipping" value="Giao hàng thành công">Đã giao hàng</button>
                      </div>
                    </form>
                    @else
                    <div style="float: right;">
                      <button class="btn btn-success" style="width: 100%" name="shipping">Đơn hàng đã hàng thành. Kiểm tra thanh toán!</button>
                    </div>
                    @endif
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

    

   