<?php
require "db.php";
session_start();

if(!empty($_POST)){

    if($results3=$mysqli->query("select id from course_registration where registration_number='{$_POST['reg_num']}'")){
        if ($results3->num_rows >= 4) {
            $_SESSION['message'] = "Course registration limit reached";
            header("location: error.php");

        } else {


            //If he didn't register for 4 courses


            if ($results2 = $mysqli->query("select id from course_registration where registration_number='{$_POST['reg_num']}' and course_id='{$_POST['course_id']}'")){
                if ($results2->num_rows) {

                    //If the course is registered before


                    $_SESSION['message'] = "You have already registered for this course";
                    header("location: error.php");
                } else {

                    //If the course is not registered before


                    if ($results = $mysqli->query("insert into course_registration (registration_number,is_approved,date_of_create,date_of_update,course_id) values ('{$_POST['reg_num']}',0,NOW(),NOW(),'{$_POST['course_id']}')")) {
                        if ($results->affected_rows != 0) {
                            $_SESSION['message'] = "Err1 Something went wrong!";
                            header("location: error.php");

                        } else {
                            $_SESSION['message'] = "Success!";
                            header("location: success.php");

                        }
                    } else {
                        $_SESSION['message'] = "Err2 Something went wrong!";
                        header("location: error.php");
                    }
                }
            }
        }
    }else{
        $_SESSION['message'] = "Err3 Something went wrong!";
        header("location: error.php");
    }


}

