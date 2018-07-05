<?php
/**
 * Created by PhpStorm.
 * User: Udhan
 * Date: 4/1/2018
 * Time: 4:50 PM
 */
session_start();
require 'connection.php';

$full_name=$_SESSION['name'];
$id=$_GET['id'];
$assignment_id=$_GET['assignment_id'];
$assignment_title=$_GET['assignment_title'];
$mark=$_POST['marks'];
$mysqli->query("UPDATE assignment_submissions SET mark='$mark' WHERE id=$id");

header("Location:view_submissions.php?assignment_id=$assignment_id&assignment_title=$assignment_title");

?>

