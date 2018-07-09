<?php
/**
 * Created by PhpStorm.
 * User: Udhan
 * Date: 7/8/2018
 * Time: 6:45 PM
 */
if (session_status() == PHP_SESSION_NONE) {    session_start();}
require 'u_connection.php';

$course_registration_id=$_POST['course_registration_id'];
$attendance=$_POST['attendance'];
$temp=$_POST['temp'];

$mark=$_POST['marks'];
$status='';
$today = date("Y-m-d H:i:s");

if($mark>=35) {
    $status=1;
}else{
    $status=0;
}
if($temp==1){
    $mysqli->query("UPDATE course_mark SET marks='$mark',date_of_update='$today', status='$status' WHERE course_registration_id=$course_registration_id");
}else{
    $mysqli->query("INSERT INTO course_mark(course_registration_id, marks, status, attendance, date_of_create, date_of_update) VALUES ('$course_registration_id','$mark','$status','$attendance','$today','$today')");
}


header("Location:u_enter_course_marks.php");
die();