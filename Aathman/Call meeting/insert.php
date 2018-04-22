<?php

require "connect.php";

if(!empty($_POST)){
	$message=$_POST['message'];
	
	$db->query("insert into ajax (message,date) values ('{$message}',NOW())");
	
	
    if($db->affected_rows){
         echo '<script> alert("Post set");</script>';
    } else{
        echo "Failiure???";
    }

	
	$records1=array();


	
   if($results1=$db->query("SELECT name FROM teachers")){
	if($results1->num_rows){
		while($row=$results1->fetch_object()){
			$records1[]=$row;
		}
		$results1->free();
	}
	
	foreach($records1 as $r){
		
		$txt=sprintf("insert into %s (seen) values (1)",'_'.$r->name);
		$db->query($txt);
		
		
			
		if($db->affected_rows){
			echo "Success!!!";
		} else{
			echo "Failiure???";
		}

	}
			
			

   }
	
	
}//echo $_POST['email'];

?>



