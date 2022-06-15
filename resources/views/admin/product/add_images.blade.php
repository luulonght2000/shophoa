<html lang="en">
<head>
  <title>Laravel Multiple File Upload Example</title>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
</head>
<body>
  <div class="container" style="margin-top: 20px">
      <div class="row jumbotron">
        <div class="mb-6 col-md-6">
          <h3 style="text-transform: capitalize" >Tên hoa: {{$product->name}}</h3>
          <a href='{{url("admin/product")}}'><button class="btn btn-primary" style="margin-top:10px">Quay lại</button></a> 

          <div class="add-image" style="height: auto; margin-top: 10px">
            @for ($i=1; $i<10; $i++)
              <div>
                @if(file_exists(public_path("./files/{$product_id}-$i.jpg")))
                <img width="100" height="100" style="float: left; margin: 10 10px" src={{"/files/{$product_id}-$i.jpg"}} alt="">
                @endif
              </div>
            @endfor
          </div>
      
          <div class="container" style="float: left;">
            <form method="post" action="{{url('/admin/add-images')}}" enctype="multipart/form-data">
              {{csrf_field()}}
        
                <div class="input-group control-group increment" >
                  <input type="file" name="filename[]" class="form-control">
                  <div class="input-group-btn"> 
                    <button class="btn btn-success" type="button"><i class="glyphicon glyphicon-plus"></i>Add</button>
                  </div>
                </div>
                <div class="clone hide">
                  <div class="control-group input-group" style="margin-top:10px">
                    <input type="file" name="filename[]" class="form-control">
                    <div class="input-group-btn"> 
                      <button class="btn btn-danger" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button>
                    </div>
                  </div>
                </div>
        
                <input type="hidden" value="{{$product->id}}" name="product_id" class="form-control">
                <button type="submit" class="btn btn-primary" style="margin-top:10px">Submit</button>
            </form>
          </div>  
        </div>
        <div class="mb-6 col-md-6">
          @if(file_exists(public_path("./uploads/{$product->id}.jpg")))
          <img width="300" height="auto" src={{"/uploads/{$product->id}.jpg"}} alt="">
          @else
          <img width="300" height="auto" src={{"/uploads/no_photo.png"}} alt="">
          @endif
          <br><br>

          <div class="notification">
            @if (count($errors) > 0)
            <div class="alert alert-danger">
              <strong>Whoops!</strong> There were some problems with your input.<br><br>
              <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
            @endif

            @if(session('success'))
            <div class="alert alert-success">
              {{ session('success') }}
            </div> 
            @endif
          </div>
        </div>
      </div>     
  </div>


<script type="text/javascript">


    $(document).ready(function() {

      $(".btn-success").click(function(){ 
          var html = $(".clone").html();
          $(".increment").after(html);
      });

      $("body").on("click",".btn-danger",function(){ 
          $(this).parents(".control-group").remove();
      });

    });

</script>
</body>
</html>