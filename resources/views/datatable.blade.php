<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>
</head>
<body class="bg-light">
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="text-center">Laravel 8 Ajax CRUD Tutorial Using Datatable - MyWebTuts.com</h4>
                    </div>
                    <div class="col-md-12 mb-4 text-right">
                        <a class="btn btn-success" href="javascript:void(0)" id="createNewProduct"> <i class="fas fa-plus"></i></a>
                    </div>
                    <div class="col-md-12">
                        <table class="table table-hover table-bordered data-table">
                            <thead class="bg-secondary text-white">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ajaxModel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading"></h4>
                </div>
                <div class="modal-body">
                  <form id="productForm" name="productForm" class="form-horizontal">
                    <input type="hidden" name="product_id" id="product_id">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="" maxlength="50" required="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="price" class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="email" name="email" placeholder="Enter Email" value="" maxlength="50" required="">
                        </div>
                        <p class="error_msg" id="email"></p>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Phone</label>
                        <div class="col-sm-12">
                          <input type="number" class="col-sm-10 form-control" id="phone" placeholder="Phone" name="phone" value="{{ old('phone') }}" required>
                        </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-2 control-label">Password</label>
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
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-2 control-label">Password</label>
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
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-2 control-label">Address</label>
                      <div class="col-sm-12">
                          <textarea id="address" name="address" required="" placeholder="Enter address" class="form-control"></textarea>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-2 control-label">Giới tính</label>
                      <div class="col-sm-12">
                        <input type="radio" class="form-check-input" id="sex" placeholder="Giới tính" name="sex" value="1" {{old('sex')?"checked":""}}">Nam

                        <input type="radio" class="form-check-input" id="sex" placeholder="Giới tính" name="sex" value="0" {{old('sex')?"":"checked"}}">NỮ
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-2 control-label">Ngày sinh</label>
                      <div class="col-sm-12">
                        <input class="form-control" id="DOB" placeholder="Ngày tháng năm sinh" name="DOB" type="date" value="{{ old('DOB') }}" autofocus>
                      </div>
                    </div>
      
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes</button>
                    </div>
                  </form>
                </div>
            </div>
        </div>
    </div>
</body>

<script>
    $(function(){
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('product.index') }}",
            columns : [
                // {data:'DT_RowIndex',name:'DT_RowIndex'},
                {data:'id',name:'id'},
                {data:'name',name:'name'},
                {data:'email',name:'email'},
                {data:'phone',name:'phone'},
                {data:'address',name:'address'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

        $('#createNewProduct').click(function () {
            $('#saveBtn').val("create-product");
            $('#product_id').val('');
            $('#productForm').trigger("reset");
            $('#modelHeading').html("Create New Product");
            $('#ajaxModel').modal('show');
        });

        $('body').on('click', '.editProduct', function () {
          var product_id = $(this).data('id');
          $.get("{{ route('product.index') }}" +'/' + product_id +'/edit', function (data) {
          $('#modelHeading').html("Edit Product");
          $('#saveBtn').val("edit-user");
          $('#ajaxModel').modal('show');
          $('#product_id').val(data.id);
          $('#name').val(data.name);
          $('#email').val(data.email);
          $('#phone').val(data.phone);
          $('#password').val(data.password);
          $('#address').val(data.address);
          $('#sex').val(data.sex);
          $('#DOB').val(data.DOB);
          })
        });

        $('#saveBtn').click(function (e) {
            e.preventDefault();
            $(this).html('Sending..');
            var email = $("input[name='email']").val();
        
            $.ajax({
                data: $('#productForm').serialize(),
                url: "{{ route('product.store') }}",
                type: "POST",
                dataType: 'json',
                success: function(data) {
                    if($.isEmptyObject(data.errors)){
                        $(".error_msg").html('');
                        alert(data.success);
                    }else{
                        let resp = data.errors;
                        for (index in resp) {
                            $("#" + index).html(resp[index]);
                        }
                    }
                }
            });
        });

        $('body').on('click', '.deleteProduct', function (){
            var product_id = $(this).data("id");
            var result = confirm("Are You sure want to delete !");
            if(result){
                $.ajax({
                    type: "DELETE",
                    url: "{{ route('product.store') }}"+'/'+product_id,
                    success: function (data) {
                        table.draw();
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                });
            }else{
                return false;
            }
        });
    });
</script>
</html>