<?php
/**
 * Created by PhpStorm.
 * User: Udhan
 * Date: 3/30/2018
 * Time: 3:16 PM
 */
require 'connection.php';


$user_id=$_SESSION['user_id'];
$user_type=$_SESSION['type'];
$result2='';
$result4='';
$name='';
if($user_type==1){
    $result1=$mysqli->query("SELECT * FROM employee_data WHERE user_id='$user_id'");
    $user=$result1->fetch_assoc();

    $teacher_id=$user['id'];
    $result2=$mysqli->query("SELECT * FROM courses WHERE assigned_teacher_id='$teacher_id'");
    $name=$user['full_name'];
}else{
    $result3=$mysqli->query("SELECT * FROM student_data WHERE user_id='$user_id'");
    $student_user=$result3->fetch_assoc();

    $student_reg_no=$student_user['registration_number'];
    $result4=$mysqli->query("SELECT * FROM course_registration WHERE registration_number='$student_reg_no'");
    $name=$_SESSION['first_name'].' '.$_SESSION['last_name'];

}

$_SESSION['name']=$name;
?>





