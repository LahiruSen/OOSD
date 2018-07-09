<?php
require "db.php";
session_start();

if(!empty($_GET)){

    var_dump($_GET['regno']);
    var_dump($_GET['course']);
    die();
    if($results=$mysqli->query("delete from course_registration where registration_number='{$_GET['regno']}' and course_id='{$_GET['course']}'")){
        $_SESSION['message'] = "Successfully unenrolled from the course!";
        header("location: success.php");
    }else{
        $_SESSION['message'] = "Err3 Something went wrong!";
        header("location: error.php");
    }


}

