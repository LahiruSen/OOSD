<?php

require "connect.php";

$records1=array();
$messagesarray=array();

	//$_SESSION['name']
	
	
   if($results1=$db->query("SELECT id FROM _teacher1 where seen=1")){
	if($results1->num_rows){
		while($row=$results1->fetch_object()){
			$records1[]=$row;
		}
		$results1->free();
	}
	
	foreach($records1 as $r){
		
		$txt=sprintf("select message from ajax where id=%s",$r->id);
		$message=$db->query($txt);
		
		while($row1=$message->fetch_object())
			$messagesarray[]=$row1;
			
		if($db->affected_rows){
			echo "Success!!!";
		} else{
			echo "Failiure???";
		}

	}
/*$output='';
foreach($messagesarray as $m){
	 $output.='
            <li>
                <a href="#">
                     <strong>'.$row["comment_subject"].'</strong><br>
                      <small><em>'.$row["comment_text"].'</em></small>
                 </a>
            </li>
               ';
			   
			   
			   $t=sprintf("         %s",$m->message);
			   $output.=$t;
}	
*/

/*$data=array(
        'notification'=>$output,
    );
    echo json_encode($data);
*/
echo "hi";	



?>