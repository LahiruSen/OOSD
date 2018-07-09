<?php
/**
 * Created by PhpStorm.
 * User: Udhan
 * Date: 3/30/2018
 * Time: 11:53 PM
 */
if (session_status() == PHP_SESSION_NONE) {    session_start();}
require 'u_connection.php';

$name=$_FILES["file"]["name"];
$tmp_name=$_FILES["file"]["tmp_name"];
$location='assignment_files/';
move_uploaded_file($tmp_name,$location.$name);

$course_id=$_SESSION["course_id"];
$course_title=$_SESSION["course_title"];

$description=$_POST["description"];
$title=$_POST["title"];
$deadline=$_POST["deadline"];

$string = "$location.$name";
$lastDot = strrpos($string, ".");
$string = str_replace(".", "", substr($string, 0, $lastDot)) . substr($string, $lastDot);

$today = date("Y-m-d H:i:s");

$sql="INSERT INTO assignments(course_id,description, attachment_link,title,date_of_deadline,date_of_update, date_of_create) VALUES ('$course_id','$description','$string','$title','$deadline','$today','$today')";

if ( $mysqli->query($sql) ) {

    $_SESSION['message']="Your Assignment is uploaded successfully";
    header("location: success.php");
    die();

}
else{
    $_SESSION['message']="Sorry. Your Assignment could not be uploaded. Please, Try again";
    header("location: error.php");
    die();
}
//header("Location:u_course_details_teacher.php");

?>
