<!DOCTYPE html>
<html>
 <head>
  <title>Teacher Profile</title>
  <script src="jquery-3.3.1.min.js"></script>
  <link rel="stylesheet" href="bootstrap.min.css" />
  <script src="bootstrap.min.js"></script>
 </head>
 <body>
  <br /><br />
  <div class="container">
   <nav class="navbar navbar-inverse">
    <div class="container-fluid">
     <div class="navbar-header">
      <a class="navbar-brand" href="#">Teacher</a>
     </div>
     <ul class="nav navbar-nav navbar-right">
      <li class="dropdown">
       <a href="#" class="dropdown-toggle" data-toggle="dropdown">
	   <span class="label label-pill label-danger count" style="border-radius:10px;"></span>
	   Notification</a>
       <ul class="dropdown-menu"></ul>
      </li>
     </ul>
    </div>
   </nav>
   <br />
   <h2 align="center">Teacher Account</h2>
   <br />
   
   
  </div>
 </body>
</html>

<script>
$(document).ready(function(){
 
 function load_unseen_notification(view = '')
 {
  $.ajax({
   url:"read.php",
   method:"POST",
   data:{view:view},
   dataType:"json",
   success:function(data)
   {
	 // alert("fetch");
    $('.dropdown-menu').html(data.notification);
    if(data.unseen_notification > 0)
    {
		$('.count').html(data.unseen_notification);
    }
   }
  });
 }
 
 load_unseen_notification();
 
 
 function clear_unseen(){
	$.ajax({ 
	 url:"update.php",
	 method:"GET",
	 success:function(data){
		// $('.dropdown-menu').html("No notification");
	 }
	});
 }
 
 $(document).on('click', '.dropdown-toggle', function(){
  $('.count').html('');
 clear_unseen();
 //load_unseen_notification();
 });
 
 setInterval(function(){ 
  load_unseen_notification(); 
 }, 5000);
 
});
</script>



<!--
<script src="jquery-3.3.1.min.js"></script></head>


<script>



    $(document).ready(function(){
		checknotif();
	setInterval(function(){ checknotif(); }, 10000);
    });

    var i=0;
function checknotif() {
    i++;
	alert("fetch"+i);

	$.ajax({
        url:"read.php",
        type:"post",
		//dataType:"json",
        success:function(data){
            $(".outdiv").html(data);
        }
    });
};

</script>


<div class="outdiv">

</div>

-->