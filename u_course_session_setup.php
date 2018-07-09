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
$_SESSION['course_registration_id']=$_GET['course_registration_id'];
if($user_type==1) {
    header("Location:u_course_details_teacher.php");
}else{
    header("Location:u_course_details_student.php");
}