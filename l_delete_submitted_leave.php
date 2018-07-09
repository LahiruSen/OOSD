
<?php
/* Displays user information and some useful messages */
require 'db.php';
if (session_status() == PHP_SESSION_NONE) {    session_start();}

// Check if user is logged in using the session variable
if ( $_SESSION['logged_in'] != 1 ) {
    $_SESSION['message'] = "You must log in before viewing your profile page!";
    header("location: error.php");
}
else {
    // Makes it easier to read
    $first_name = $_SESSION['first_name'];
    $last_name = $_SESSION['last_name'];
    $email = $_SESSION['email'];
    $active = $_SESSION['active'];
    $types = $_SESSION['types'];
    $two_step = $_SESSION['two_step'];


    if ($types == 2) {
        header("location: home_student.php");
        die();
    }
    else {
        if (isset($_SESSION['email'])) {
            $email = $_SESSION['email'];
            $current_employee_type_result = $mysqli->query("select DISTINCT employee_types.title,employee_types.id from employee_types, users, employee_data where users.email = '$email' and employee_types.id = employee_data.employee_type_id") or die($mysqli->error());
            if ($current_employee_type_result->num_rows != 0) {

                        if ($_SERVER["REQUEST_METHOD"] == "POST") {


                            $leave_id = $_POST['leave_id'];
//                            $leave_result = $mysqli->query("SELECT * FROM leave_submission WHERE id='$leave_id' ");
//                            $leave_result_array = $leave_result->fetch_assoc();
//                            if($leave_result_array['approved_by_admin']==1){
//                                $_SESSION['message']="Sorry.You can't Delete this leave application cause it's already approved by Admin";
//                                header("location: error.php");
//                                die();
//
//                            }


                            $sql = "DELETE FROM leave_submission WHERE id= $leave_id";



                            if ( $mysqli->query($sql) ) {

                                $_SESSION['message']="Leave application Deleted";
                                header("location:success.php");
                                die();

                            }
                            else{
                                $_SESSION['message']="Sorry. Leave application couldn't be deleted";
                                header("location: error.php");
                                die();
                            }












                        }
                        else{
                            $_SESSION['message']="Invalid Request.";
                            header("location: error.php");
                            die();

                        }





        } else {
            $_SESSION['message'] = "This session has expired. Please login again!!!";
            header("location:error.php");
            die();
        }


    }




}}