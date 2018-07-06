<?php
/**
 * Created by PhpStorm.
 * User: Udhan
 * Date: 3/30/2018
 * Time: 3:16 PM
 */
require 'u_connection.php';

$user_id=$_SESSION['user_id'];
$user_type=$_SESSION['type'];

$course_query_teacher='';
$course_query_student='';
$name='';

if($user_type==1){
    $employee_query=$mysqli->query("SELECT * FROM employee_data WHERE user_id='$user_id'");
    $employee=$employee_query->fetch_assoc();

    $teacher_id=$employee['id'];
    $course_query_teacher=$mysqli->query("SELECT * FROM courses WHERE assigned_teacher_id='$teacher_id'");
    //$name=$user['full_name'];
}else{
    $student_query=$mysqli->query("SELECT * FROM student_data WHERE user_id='$user_id'");
    $student=$student_query->fetch_assoc();

    $student_reg_no=$student['registration_number'];
    $course_query_student=$mysqli->query("SELECT * FROM course_registration WHERE registration_number='$student_reg_no'");

}
$name=$_SESSION['first_name'].' '.$_SESSION['last_name'];
$_SESSION['name']=$name;
?>