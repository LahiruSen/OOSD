<?php
/**
 * Created by PhpStorm.
 * User: Udhan
 * Date: 7/4/2018
 * Time: 3:18 PM
 */
if (session_status() == PHP_SESSION_NONE) {    session_start();}
$user_type=$_SESSION['types'];
$_SESSION['assignment_id']=$_GET['assignment_id'];
$_SESSION['assignment_title']=$_GET['assignment_title'];
if($user_type==1) {
    header("Location:u_view_submissions_teacher.php");
    die();
}else{
    header("Location:u_assignment_details_student.php");
    die();
}