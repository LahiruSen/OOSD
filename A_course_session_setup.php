<?php

if (session_status() == PHP_SESSION_NONE) {    session_start();}
$user_type=$_SESSION['types'];
$_SESSION['course_id']=$_GET['course_id'];
$_SESSION['course_title']=$_GET['course_title'];

    header("Location:A_course_details_student.php");
