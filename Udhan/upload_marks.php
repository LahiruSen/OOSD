<?php
/**
 * Created by PhpStorm.
 * User: Udhan
 * Date: 4/1/2018
 * Time: 4:50 PM
 */
session_start();
require 'connection.php';

//$full_name=$_SESSION['name'];
$submission_id=$_GET['submission_id'];
//$assignment_id=$_GET['assignment_id'];
//$assignment_title=$_GET['assignment_title'];
$mark=$_POST['marks'];
//if(is_numeric($mark)){
//    $mark=(double)$mark;
if($mark>=0 && $mark<=100) {
    $mysqli->query("UPDATE assignment_submissions SET mark='$mark' WHERE id=$submission_id");
}
//
//}


header("Location:view_submissions_teacher.php");


?>



