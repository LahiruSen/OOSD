<?php
/**
 * Created by PhpStorm.
 * User: Udhan
 * Date: 7/5/2018
 * Time: 9:57 PM
 */

session_start();
$user_type=$_SESSION['type'];
$_SESSION['assignment_id']=$_GET['assignment_id'];
$_SESSION['assignment_title']=$_GET['assignment_title'];
//if($user_type==1) {
//header("Location:u_view_submissions_teacher.php");
//}else if($user_type==2){
header("Location:u_assignment_details_teacher.php");
//}