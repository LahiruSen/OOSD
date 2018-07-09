<?php
/**
 * Created by PhpStorm.
 * User: Udhan
 * Date: 4/18/2018
 * Time: 10:47 AM
 */
if (session_status() == PHP_SESSION_NONE) {    session_start();}
require "u_connection.php";
$student_id=$_SESSION['reg_no'];
$assignment_id=$_GET['assignment_id'];

$sql="DELETE FROM assignment_submissions WHERE assignment_id='$assignment_id' AND student_id='$student_id'";

if ( $mysqli->query($sql) ) {

    $_SESSION['message']="Your Submission is deleted successfully";
    header("location: success.php");
    die();

}
else{
    $_SESSION['message']="Sorry. Your Submisssion could not be deleted. Please, Try again";
    header("location: error.php");
    die();
}


//header("location: u_assignment_details_student.php");
?>

