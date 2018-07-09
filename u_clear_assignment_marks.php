<?php
/**
 * Created by PhpStorm.
 * User: Udhan
 * Date: 7/9/2018
 * Time: 2:31 PM
 */


if (session_status() == PHP_SESSION_NONE) {    session_start();}
require 'u_connection.php';

$submission_id=$_POST['submission_id'];

$mysqli->query("UPDATE assignment_submissions SET mark=-1 WHERE id=$submission_id");

header("Location:u_view_submissions_teacher.php");
die();

?>