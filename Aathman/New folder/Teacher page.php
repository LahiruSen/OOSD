<html>
<head>
<script src="jquery-3.3.1.js"></script></head>
<body>

<script>
    $(document).ready(function(){
       /*function load_unseen_notification(view='') {
            $.ajax({
                url:"ReadMessage.php",
                method:"POST",
                data:{view:view},
                dataType:"json",
                success:function(data){
                   $('.dropdown').html(data.notification);
                    /*if(data.unseen_notification>0){
                    //    $('.count').html(data.unseen_notification);
                    }
                }
            });
        }
		*/
		$("#button").click(function(){
			
			/*$.ajax({
			type:"post",
			url:"test.php",
			success:function(varX){
				$('#get_content').html(varX);
				
			}
			});
			
			*/
			$("#test").fadeOut(1000);
		});
		
		
		return false;
	});
});
</script>

<p id="test">Jquery tutorial</p>
<button id="button">Click</button>

<div id="get_content">

</div>

</body>
</html>

