<?php

$db=new mysqli('localhost','root','','vier');

if(!empty($_POST)){
	
$firstname=$_POST['firstname'];
$lastname=$_POST['lastname'];
$email=$_POST['email'];
$course=$_POST['course'];
$indexal=$_POST['indexal'];
$maths=$_POST['maths'];
$chemistry=$_POST['chemistry'];
$physics=$_POST['physics'];


$results=$db->query("select maths,chemistry,physics from courses where name='{$course}'");

echo $course."<br>";

$row=$results->fetch_object();

$chkmaths=$row->maths;
$chkchemistry=$row->chemistry;
$chkphysics=$row->physics;
//echo $chkmaths." ".$chkphysics." ".$chkchemistry."<br>";
//echo "yours ".$maths." ".$physics." ".$chemistry."<br>";

if($maths<=$chkmaths && $chemistry<=$chkchemistry && $physics<=$chkphysics){
	//echo "true"."<br>";
$db->query("insert into students (firstname,lastname,email,course,indexal,maths,chemistry,
physics) values ('{$firstname}','{$lastname}','{$email}','{$course}','{$indexal}'
,'{$maths}','{$chemistry}','{$physics}')");

header("Location:mysite _ Registration success.html");

}else{
	//echo "false"."<br>";
	header("Location:mysite _ Registration failure.html");
}
//echo $firstname." ".$lastname." ".$email." ".$course." ".$indexal." ".$maths
//." ".$chemistry." ".$physics;
}

?>