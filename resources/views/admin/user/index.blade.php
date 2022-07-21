
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
  tfoot input {
        width: 100%;
        padding: 3px;
        box-sizing: border-box;
    }
</style>
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
            </div>
            <div class="row">
              <div class="tab-content">
                <div class="tab-pane fade show active" id="navs-pills-top-home" role="tabpanel">
                  <div class="table-wrapper-scroll-y my-custom-scrollbar">
                    <table id="table_user" class="table table-bordered table-striped mb-0" style="width: 150%">
                      <thead>
                        <tr>
                          <th>Ảnh</th>
                          <th>Role</th>
                          <th>FullName</th>
                          <th>Email</th>
                          <th>Phone</th>
                          <th>Ngày sinh</th>
                          <th>Giới tính</th>
                          <th>Address</th>
                          <th>Action</th> 
                        </tr>
                      </thead>
                      <tfoot>
                        <tr>
                          <th>Ảnh</th>
                          <th>Role</th>
                          <th>FullName</th>
                          <th>Email</th>
                          <th>Phone</th>
                          <th>Ngày sinh</th>
                          <th>Giới tính</th>
                          <th>Address</th>
                          <th>Action</th> 
                        </tr>
                    </tfoot>
                    </table>
                  </div>
                  {{-- <table class="table table-hover table-dark" border="1">
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
                      
                    </tr>
                    @endforeach
                  </table> --}}
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- / Content -->

    <script type="text/javascript">
      $(document).ready( function () {
        $('#table_user tfoot th').each(function () {
          var title = $(this).text();
          if(title != "Ảnh" && title !== "Action"){
            $(this).html('<input type="text" placeholder="Search ' + title + '" />');
          }
        });

        $.ajaxSetup({
          headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });

        $('#table_user').DataTable({
          language: {
            processing: "Đang tải dữ liệu",
            lengthMenu: "Điều chỉnh số lượng bản ghi trên 1 trang _MENU_ ",
            info: "Bản ghi từ _START_ đến _END_ Tổng công _TOTAL_ bản ghi",
            emptyTable: "Không có dữ liệu",
            paginate: {
                first: "Trang đầu",
                previous: "Trang trước",
                next: "Trang sau",
                last: "Trang cuối"
            },
          },
          "processing": true,
          "serverSide": true,
          "ajax": '{{ route('ajax.user.index') }}',
          "type": 'POST',
          "columns": [
            { "data": "avatar", "name": "avatar" },
            { "data": "role", "name": "role" },
            { "data": "name" },
            { "data": "email" },
            { "data": "phone", "name": "phone", "orderable": false },
            { "data": "DOB" },
            { "data": "sex",
              render: function(data, type, row) {
                if(data === 1) {
                  return 'Nam';
                }else if (data === 0) {
                  return 'Nữ';
                }
              }
            },
            { "data": "address", "orderable": false },
            { "data": "action", "name": "action", "orderable": false, "searchable": false }
          ],
          "pageLength": 5,
          initComplete: function () {
            this.api()
              .columns()
              .every(function () {
                  var that = this;
                  $('input', this.footer()).on('keyup change clear', function () {
                      if (that.search() !== this.value) {
                          that.search(this.value).draw();
                      }
                  });
              });
            },
        });

        $('body').on('click', '.delete', function () {
          if (confirm("Bạn có chắc chắn muốn xóa người dùng này?") == true) {
            var id = $(this).data('id');
            
            // ajax
            $.ajax({
                type:"POST",
                url: "{{ url('admin/delete-user') }}",
                data: { id: id },
                dataType: 'json',
                success: function(res){
                  var oTable = $('#table_user').dataTable();
                  oTable.fnDraw(false);
              }
            });
          }
        });
      });
    </script>
@endsection

    

   