<!DOCTYPE html>
<html>
 <head>
  <title>Admin Broadcast Message</title>
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
      <a class="navbar-brand" href="#">Admin</a>
     </div>
     
    </div>
   </nav>
   <br />
   <h2 align="center">Admin Profile</h2>
   <br />
   <form method="post" id="form">
   
    <div class="form-group">
     <label>Enter message to brodcast</label>
     <textarea name="message" id="message" class="form-control" rows="5"></textarea>
    </div>
    <div class="form-group">
     <input type="submit" name="post" id="post" class="btn btn-info" value="Post" />
    </div>
   </form>
   
  </div>
 </body>
</html>



<script src="jquery-3.3.1.min.js"></script>
<script>
$(document).ready(function(){
	$('form').submit(function(){
		$.ajax({
			data:$(this).serialize(),
			type:"post",
			url:"insert.php",
			success:function(varX){
				//$('#get_content').html(varX);
				$("#message").val('');
			}
		});
		return false;
	});
});
</script>


<!--<div id="get_content">
</div>
-->


