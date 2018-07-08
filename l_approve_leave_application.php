<?php
require 'db.php';
/* Displays user information and some useful messages */
session_start();

// Check if user is logged in using the session variable
if ($_SESSION['logged_in'] != 1) {
    $_SESSION['message'] = "You must log in before viewing your profile page!";
    header("location: error.php");
} else {
    // Makes it easier to read
    $first_name = $_SESSION['first_name'];
    $last_name = $_SESSION['last_name'];
    $email = $_SESSION['email'];
    $active = $_SESSION['active'];
    $types = $_SESSION['types'];
    $two_step = $_SESSION['two_step'];


    $employee_type_result = $mysqli->query("SELECT employee_types.user_level FROM employee_types,employee_data,users WHERE users.email='$email' AND users.id = employee_data.user_id AND employee_data.employee_type_id = employee_types.id");


    if ($employee_type_result->num_rows > 0) {
        $results = $employee_type_result->fetch_assoc();
        $employee_type = $results['user_level'];


    } else {
        $_SESSION['message'] = "Invalid Request ";
        header("location: error.php");
        die();

    }


    $leave_result = $mysqli->query("SELECT * FROM leave_submission ");

    if ($leave_result->num_rows) {
        while ($row = $leave_result->fetch_object()) {
            $records[] = $row;
        }
        $leave_result->free();

    }
    if ($types == 2) {
        $_SESSION['message'] = "You(Student) don't have access to this page!";
        header("location: error.php");
        die();


    }


// accept = 1; reject = 2
    if (isset($_POST)) {
        if (isset($_POST['accept'])) {
            if (isset($_POST['leave_id'])) {
                $leave_id = $_POST['leave_id'];


                $leave_result = $mysqli->query("select number_of_dates,employ_id,id,approved_by_principal,approved_by_hr,approved_by_admin from leave_submission where id = '$leave_id'"); //or die($mysqli->error());


                if ($leave_result->num_rows > 0) {    //principal
                    if ($employee_type == 2) {
                        $sql = "UPDATE leave_submission SET approved_by_principal = '1' WHERE id = '$leave_id'";;
                    } //hr Manager
                    elseif ($employee_type == 3) {
                        $sql = "UPDATE leave_submission SET approved_by_hr = '1' WHERE id = '$leave_id' ";
                    } //admin
                    elseif ($employee_type == 1) {
                        $sql = "UPDATE leave_submission SET approved_by_admin = '1'   WHERE id = '$leave_id'";

                        // reduce available leave

                        $leave_result_array = $leave_result->fetch_assoc();
                        $employee_id = $leave_result_array['employ_id'];
                        $number_of_dates =  ($leave_result_array['number_of_dates'] );
                        $_SESSION['message'] = "Sorry.Your not a valid employee.";


                        $employee_data_result = $mysqli->query("SELECT * from employee_data WHERE employee_id='$employee_id'");
                        if ($employee_data_result->num_rows > 0) {
                            $employee_data_array = $employee_data_result->fetch_assoc();
                            $pre_available_leave = $employee_data_array['available_leave'];
                            $now_available_leave = $pre_available_leave - $number_of_dates;

                            $sql_reduce = "UPDATE employee_data SET available_leave ='$now_available_leave' WHERE employee_id='$employee_id'";
                            if($mysqli->query($sql_reduce)){

                            }
                            else{
                                $_SESSION['message'] = "Sorry.Accept action could't be completed.";
                                header("location: error.php");
                                die();

                            }



                        } else {
                            $_SESSION['message'] = "Sorry.Your not a valid employee.";
                            header("location: error.php");
                            die();
                        }


                    } else {

                        $_SESSION['message'] = "Sorry.You are not allowed to perform this action.";
                        header("location: error.php");
                        die();
                    }


                    if ($mysqli->query($sql)) {
                        header("location:l_approve_leave_application_form.php");
                        die();
                    } else {
                        $_SESSION['message'] = "Sorry. Accept Action was unsuccessful.";
                        header("location: error.php");
                        die();
                    }


                } else {
                    $_SESSION['message'] = "Not a valid leave Id ";
                    header("location: error.php");
                    die();
                }


            } else {
                $_SESSION['message'] = "No Leave Id detect";
                header("location: error.php");
                die();
            }

        } elseif (isset($_POST['reject'])) {
            if (isset($_POST['leave_id'])) {
                $leave_id = $_POST['leave_id'];

                $leave_result = $mysqli->query("select id,approved_by_principal,approved_by_hr,approved_by_admin from leave_submission where id = $leave_id"); //or die($mysqli->error());

                if ($leave_result->num_rows > 0) {  //principal
                    if ($employee_type == 2) {
                        $sql = "UPDATE leave_submission SET approved_by_principal = '2' WHERE id = '$leave_id'";
                    } //hr Manager
                    elseif ($employee_type == 3) {
                        $sql = "UPDATE leave_submission SET approved_by_hr = '2' WHERE id = '$leave_id' ";
                    } //admin
                    elseif ($employee_type == 1) {
                        $sql = "UPDATE leave_submission SET approved_by_admin = '2' WHERE id = '$leave_id'";
                    } else {

                        $_SESSION['message'] = "Sorry.You are not allowed to perform this action.";
                        header("location: error.php");
                        die();
                    }

                    if ($mysqli->query($sql)) {
                        header("location:l_approve_leave_application.php");
                    } else {
                        $_SESSION['message'] = "Sorry. Reject action was unsuccessful.";
                        header("location: error.php");
                        die();
                    }


                } else {
                    $_SESSION['message'] = "Not a valid leave Id*  ";
                    header("location: error.php");
                    die();
                }
            } else {
                $_SESSION['message'] = "No Leave Id detect";
                header("location: error.php");
                die();
            }
        } elseif (isset($_POST['delete'])) {
            if (isset($_POST['leave_id'])) {
                $leave_id = $_POST['leave_id'];


                $leave_result = $mysqli->query("select id,approved_by_principal,approved_by_hr,approved_by_admin from leave_submission where id = $leave_id");//or die($mysqli->error());

                if ($leave_result->num_rows > 0) {
                    $sql = "DELETE FROM leave_submission WHERE id= $leave_id";
                    if ($mysqli->query($sql)) {
                        header("location:l_approve_leave_application.php");
                    } else {
                        $_SESSION['message'] = "Sorry. Delete Action was unsuccessful.";
                        header("location: error.php");
                        die();
                    }


                } else {
                    $_SESSION['message'] = "Not a valid leave Id ";
                    header("location: error.php");
                    die();
                }
            } else {
                $_SESSION['message'] = "No Leave Id detect";
                header("location: error.php");
                die();
            }

        } else {

            header("location: l_approve_leave_application_form.php");
            die();
        }

    } else {
        $_SESSION['message'] = "Invalid request";
        header("location: error.php");
        die();

    }


}