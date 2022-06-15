<html>
   <head>
      <title>The jQuery Example</title>
      <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		
      <script type="text/javascript" language="javascript">

        $(document).ready(function() {
          $(".clickme").click(function(event){
              $(".target").toggle('slow', function(){
                $(".log").text('');
              });
          });
        });

        $(document).ready(function() {
          $("#show").click(function () {
            $(".mydiv").show( 1000 );
          });

          $("#hide").click(function () {
            $(".mydiv").hide( 1000 );
          });
        });
      </script>
		
      <style>
         .clickme{ margin:10px;padding:12px; border:2px solid #666; width:100px; height:50px;}
      </style>
		
   </head>
	
   <body>
	
      <div class="content">
         <div class="clickme">Click Me</div>
         <div class="target">
            <img src="./images/jquery.jpg" alt="jQuery" />
         </div>
         <div class="log"></div>
      </div>	
      
      <div>
        <div class="mydiv">
          This is a SQUARE
       </div>
 
       <input id="hide" type="button" value="Hide" />   
       <input id="show" type="button" value="Show" />   
      </div>
   </body>
	
</html>