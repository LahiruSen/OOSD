<?php

$db=new mysqli('localhost','root','','vier');

if(!empty($_POST)){
	
$name=$_POST['name'];
$type=$_POST['type'];
$duration=$_POST['duration'];
$fee=$_POST['fee'];
$objective=$_POST['objective'];
$overview==$_POST['overview'];
$maths=$_POST['maths'];
$chemistry=$_POST['chemistry'];
$physics=$_POST['physics'];

$db->query("insert into courses (name,type,duration,fee,objective,overview,
maths,chemistry,physics) values ('{$_POST['name']}','{$_POST['type']}','{$_POST['duration']}'
,'{$_POST['fee']}','{$_POST['objective']}','{$_POST['overview']}','{$_POST['maths']}',
'{$_POST['chemistry']}','{$_POST['physics']}')");
	
}
 if($db->affected_rows){
	Success!!!
	} else{
		Failiure???
	} 
?>