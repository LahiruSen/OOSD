<?php
	
	$db=new mysqli("localhost","root","","drie-tech");
	echo $db->connect_error;
	if($db->connect_errno){
		die("Sorry we are having some errors");
	}
	
	
?>





