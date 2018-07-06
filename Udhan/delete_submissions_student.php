<?php
/**
 * Created by PhpStorm.
 * User: Udhan
 * Date: 4/18/2018
 * Time: 10:47 AM
 */
session_start();
require "connection.php";
$student_id=$_SESSION['reg_no'];
$assignment_id=$_GET['assignment_id'];
$mysqli->query("DELETE FROM assignment_submissions WHERE assignment_id='$assignment_id' AND student_id='$student_id'");
//$first_name = $_SESSION['first_name'];
//$last_name = $_SESSION['last_name'];
//$assignment_title=$_GET['assignment_title'];

header("location: assignment_details_student.php");
?>

