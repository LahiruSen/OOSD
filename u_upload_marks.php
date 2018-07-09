<?php
/**
 * Created by PhpStorm.
 * User: Udhan
 * Date: 4/1/2018
 * Time: 4:50 PM
 */
if (session_status() == PHP_SESSION_NONE) {    session_start();}
require 'u_connection.php';

//$full_name=$_SESSION['name'];
$submission_id=$_GET['submission_id'];

$mark=$_POST['marks'];

if($mark>=0 && $mark<=100) {
    $mysqli->query("UPDATE assignment_submissions SET mark='$mark' WHERE id=$submission_id");
}

header("Location:u_view_submissions_teacher.php");


?>



