<?php
/**
 * Created by PhpStorm.
 * User: Udhan
 * Date: 7/9/2018
 * Time: 10:59 AM
 */

if (session_status() == PHP_SESSION_NONE) {    session_start();}
require 'u_connection.php';

$course_registration_id=$_POST['course_registration_id'];

$mysqli->query("DELETE FROM course_mark WHERE course_registration_id=$course_registration_id");

header("Location:u_enter_course_marks.php");

?>