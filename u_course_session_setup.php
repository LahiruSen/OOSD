<?php
/**
 * Created by PhpStorm.
 * User: Udhan
 * Date: 7/4/2018
 * Time: 3:03 PM
 */
if (session_status() == PHP_SESSION_NONE) {    session_start();}
$user_type=$_SESSION['types'];
$_SESSION['course_id']=$_GET['course_id'];
$_SESSION['course_title']=$_GET['course_title'];
if($user_type==1) {
    header("Location:u_course_details_teacher.php");
}else if($user_type==2){
    header("Location:u_course_details_student.php");
}