<?php
/**
 * Created by PhpStorm.
 * User: Udhan
 * Date: 3/29/2018
 * Time: 7:31 PM
 */
require 'u_connection.php';
if (session_status() == PHP_SESSION_NONE) {    session_start();}


$name=$_FILES['file']['name'];
$tmp_name=$_FILES['file']['tmp_name'];
$assignment_id=$_POST["assignment_id"];

$location='submission_files/';
move_uploaded_file($tmp_name,$location.$name);
$reg_no=$_SESSION['reg_no'];
//$first_name = $_SESSION['first_name'];
//$last_name = $_SESSION['last_name'];
$assignment_title = $_POST['assignment_title'];

$string = "$location.$name";
$lastDot = strrpos($string, ".");
$string = str_replace(".", "", substr($string, 0, $lastDot)) . substr($string, $lastDot);

$today = date("Y-m-d H:i:s");

$sql="INSERT INTO assignment_submissions(assignment_id, student_id, pdf_link,date_of_create, date_of_update) VALUES ('$assignment_id','$reg_no','$string','$today','$today')";

if ( $mysqli->query($sql) ) {

    $_SESSION['message']="Your Submission is uploaded successfully";
    header("location: success.php");
    die();

}
else{
    $_SESSION['message']="Sorry. Your Submissionl could not be uploaded. Please, Try again";
    header("location: error.php");
    die();
}
//header("Location:u_assignment_details_student.php");

?>
