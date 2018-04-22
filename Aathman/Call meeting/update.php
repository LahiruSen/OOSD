<?php

require "connect.php";



	//$_SESSION['name']

	
	$db->query( "UPDATE _teacher3 SET seen=0 WHERE seen=1");
	
	
 ?>