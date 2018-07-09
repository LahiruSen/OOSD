<?php

if (session_status() == PHP_SESSION_NONE) {    session_start();}
require 'u_connection.php';

$user_id=$_SESSION['user_id'];
$user_type=$_SESSION['types'];


$course_query_student='';
$name='';


    $student_query=$mysqli->query("SELECT * FROM student_data WHERE user_id='$user_id'");
    $student=$student_query->fetch_assoc();

    $student_reg_no=$student['registration_number'];
    $course_query_student=$mysqli->query("SELECT course_id FROM course_registration WHERE registration_number='$student_reg_no' and is_approved=0 ");



?>