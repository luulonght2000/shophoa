<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="YRpUZtbORLCQyvQIrzQh3Xj2C7Zf8JKRM7efSOMF">
  <title>Ogani | Shop hoa</title>

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;900&display=swap" rel="stylesheet">
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
  <link href="{{asset('./css/font-awesome.min.css')}}" rel="stylesheet">
  <link href="{{ asset('./css/font-awesome.min.css') }}" rel="stylesheet">

  <!-- Css Styles -->
  <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}" type="text/css">
  <link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}" type="text/css">
  <link rel="stylesheet" href="{{asset('css/elegant-icons.css')}}" type="text/css">
  <link rel="stylesheet" href="{{asset('css/nice-select.css')}}" type="text/css">
  <link rel="stylesheet" href="{{asset('css/jquery-ui.min.css')}}" type="text/css">
  <link rel="stylesheet" href="{{asset('css/owl.carousel.min.css')}}" type="text/css">
  <link rel="stylesheet" href="{{asset('css/slicknav.min.css')}}" type="text/css">
  <link rel="stylesheet" href="{{asset('css/style.css')}}" type="text/css">
  <link rel="stylesheet" href="{{asset('dist/css/sweetalert.css')}}" type="text/css">

  <script src="{{asset('./js/app.js')}}"></script>
  <script src="{{ asset('./js/app.js') }}" defer></script>

  <!---TinyMCE Editor-->
  <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.4.1/css/glide.core.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.4.1/css/glide.theme.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.4.1/glide.min.js">
  </script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.4.1/css/glide.core.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.4.1/css/glide.theme.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.4.1/glide.min.js">
  </script>
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="js/glide.js"></script>
  <script src="./js/jquery-3.6.0.js"></script>
  <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
  <link href="{{asset('fontawesome/css/all.css')}}" rel="stylesheet">
  <link href="{{asset('css/lightgallery.min.css')}}" rel="stylesheet">
  <link href="{{asset('css/lightslider.css')}}" rel="stylesheet">
  <link href="{{asset('css/prettify.css')}}" rel="stylesheet">
</head>

<body>
  @yield('master_content')

  {{-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> --}}
  <script src="{{ asset('js/jquery.min.js') }}"></script>
  <script src="{{ asset('js/lightgallery-all.min.js') }}"></script>
  <script src="{{ asset('js/lightslider.js') }}"></script>
  <script src="{{ asset('js/prettify.js') }}"></script> 

  <script type="text/javascript">
    $(document).ready(function() {
        $('#imageGallery').lightSlider({
            gallery:true,
            item:1,
            loop:true,
            thumbItem:4,
            slideMargin:0,
            enableDrag: false,
            currentPagerPosition:'left',
            onSliderLoad: function(el) {
                el.lightGallery({
                    selector: '#imageGallery .lslide'
                });
            }   
        });  
      });
  </script>

  <!-- Messenger Plugin chat Code -->
  <div id="fb-root"></div>

  <!-- Your Plugin chat code -->
  <div id="fb-customer-chat" class="fb-customerchat">
  </div>

  <script>
    var chatbox = document.getElementById('fb-customer-chat');
    chatbox.setAttribute("page_id", "110400165066636");
    chatbox.setAttribute("attribution", "biz_inbox");
  </script>

  <!-- Your SDK code -->
  <script>
    window.fbAsyncInit = function() {
      FB.init({
        xfbml            : true,
        version          : 'v14.0'
      });
    };

    (function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = 'https://connect.facebook.net/vi_VN/sdk/xfbml.customerchat.js';
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
  </script>
  
  <script type="text/javascript">
    $(document).ready(function(){
      $('.add-to-cart').click(function(){
        var id=$(this).data('id_product');
        var cart_product_id = $('.cart_product_id_' + id).val();
        var cart_product_name = $('.cart_product_name_' + id).val();
        var cart_product_image = $('.cart_product_image_' + id).val();
        var cart_product_price = $('.cart_product_price_' + id).val();
        var cart_product_qty = $('.cart_product_qty_' + id).val();
        var _token = $('input[name="_token"]').val();

        $.ajax({
          url: "{{url('/add-cart')}}",
          method: 'POST',
          data:{
            cart_product_id:cart_product_id,
            cart_product_name:cart_product_name,
            cart_product_image:cart_product_image,
            cart_product_price:cart_product_price,
            cart_product_qty:cart_product_qty,
            _token:_token
          },
          success:function(data){
            alert(data);
          }
        });
      });

    $(".fa-user").click(function(event){
          $(".target").toggle('slow', function(){
            $(".log").text('');
          });
      });
    });
  </script>
</body>

</html>