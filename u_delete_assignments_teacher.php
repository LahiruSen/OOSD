<?php
/**
 * Created by PhpStorm.
 * User: Udhan
 * Date: 7/5/2018
 * Time: 11:26 PM
 */

if (session_status() == PHP_SESSION_NONE) {    session_start();}
require "u_connection.php";
//$student_id=$_SESSION['reg_no'];
$assignment_id=$_GET['assignment_id'];
$sql="DELETE FROM assignments WHERE id='$assignment_id'";

if ( $mysqli->query($sql) ) {

    $_SESSION['message']="Your Assignment is deleted successfully";
    header("location: success.php");
    die();

}
else{
    $_SESSION['message']="Sorry. Your Assignment could not be deleted. Please, Try again";
    header("location: error.php");
    die();
}

//header("location: u_up_del_assignments_teacher.php");
?>
