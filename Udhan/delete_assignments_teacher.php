<?php
/**
 * Created by PhpStorm.
 * User: Udhan
 * Date: 7/5/2018
 * Time: 11:26 PM
 */

session_start();
require "connection.php";
//$student_id=$_SESSION['reg_no'];
$assignment_id=$_GET['assignment_id'];
$mysqli->query("DELETE FROM assignments WHERE id='$assignment_id'");
//$first_name = $_SESSION['first_name'];
//$last_name = $_SESSION['last_name'];
//$assignment_title=$_GET['assignment_title'];

header("location: up_del_assignments_teacher.php");
?>
