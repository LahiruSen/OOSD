<?php

require "connect.php";

$records1=array();
$messagesarray=array();

	//$_SESSION['name']

$output='';
	
 if($results1=$db->query("SELECT id FROM _teacher3 where seen=1 order by id desc") ){
	if($results1->num_rows){
		while($row=$results1->fetch_object()){
			$records1[]=$row;
		}
		$results1->free();
		
			foreach($records1 as $r){
		
		$txt=sprintf("select message from ajax where id=%s ",$r->id);
		//echo $txt.'<br>';
		$message=$db->query($txt);
		
		while($row1=$message->fetch_object())
			$messagesarray[]=$row1;
			
		
	}
	
	foreach($messagesarray as $m){
	 $output.='
            <li>
				<a href="#">
                <strong>'.$m->message.'</strong>
				</a>
				<br>
            </li>
               ';
			
	}
	}
	else{
	 if($results2=$db->query("SELECT id FROM _teacher3 order by id desc limit 10")){
	if($results2->num_rows){
		while($row=$results2->fetch_object()){
			$records1[]=$row;
		}
		$results2->free();
	}
	foreach($records1 as $r){
		
		$txt=sprintf("select message from ajax where id=%s ",$r->id);
		//echo $txt.'<br>';
		$message=$db->query($txt);
		
		while($row1=$message->fetch_object())
			$messagesarray[]=$row1;
			
		
	}
	
	foreach($messagesarray as $m){
	 $output.='
            <li>
				<a href="#">
                '.$m->message.'
				</a>
				<br>
            </li>
               ';
			
	}
 }
 }
 }
	
//echo $output.'<br>';
 
 $result_1 = $db->query( "SELECT id FROM _teacher3 where seen=1");
 $count = mysqli_num_rows($result_1);
 $data = array(
  'notification'   => $output,
  'unseen_notification' => $count
 );
 
 

    echo json_encode($data);
	
	//echo $data['notification'];
	//echo '<pre>';
	//print_r($data);
	// echo '</pre>';



?>