<script src="jquery-3.3.1.min.js"></script>
<script>
$(document).ready(function(){
	$('form').submit(function(){
		$.ajax({
			data:$(this).serialize(),
			type:"post",
			url:"2.php",
			success:function(varX){
				$('#get_content').html(varX);
				$("#message").val('');
			}
		});
		return false;
	});
});
</script>

<form>

Message:<input id="message" type="textarea" name="message"><br>
<input type="submit" value="Broadcast message">

</form>
<div id="get_content">
</div>



