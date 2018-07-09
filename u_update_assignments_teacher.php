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
$assignment_id=$_POST['assignment_id'];

$assignment_query=$mysqli->query("SELECT * FROM assignments WHERE id='$assignment_id'");
$assignment=$assignment_query->fetch_assoc();

$title=$assignment['title'];
$description=$assignment['description'];
$file=$assignment['attachment_link'];
$deadline=$assignment['date_of_deadline'];
$string=$file;

if(!empty($_POST['title'])){
    $title=$_POST['title'];
}
if(!empty($_POST['description'])){
    $description=$_POST['description'];
}
$name=$_FILES["file"]["name"];
if($name!=''){
    $tmp_name=$_FILES["file"]["tmp_name"];
    $location='assignment_files/';
    move_uploaded_file($tmp_name,$location.$name);

    $string = "$location.$name";
    $lastDot = strrpos($string, ".");
    $string = str_replace(".", "", substr($string, 0, $lastDot)) . substr($string, $lastDot);

    //$file=$_POST['file'];
}
if(!empty($_POST['deadline'])){
    $deadline_temp=$_POST['deadline'];
    if($deadline_temp!='') {
        $deadline=$deadline_temp;
    }

}
$today = date("Y-m-d H:i:s");

$sql="UPDATE assignments SET title='$title',description='$description',attachment_link='$string',date_of_deadline='$deadline' ,date_of_update='$today' WHERE id=$assignment_id";

if ( $mysqli->query($sql) ) {

    $_SESSION['message']="Your Assignment is updated successfully";
    header("location: u_success.php");
    die();

}
else{
    $_SESSION['message']="Sorry. Your Assignment could not be updated. Please, Try again";
    header("location: u_error.php");
    die();
}
//header("location: u_up_del_assignments_teacher.php");
?>
