<?php



/**
 * Created by PhpStorm.
 * User: BlackLion
 * Date: 4/6/2018
 * Time: 8:19 AM
 */

if (session_status() == PHP_SESSION_NONE) {    session_start();}
require 'validator.php';
require 'db.php';



// CHECK THERE IS A LOGNG[SESSION VARIABLE WERE ONLY CREATED DURING LOGIN] &&&& CHECK USER TYPE = ADMINISTRATOR
if(isset($_SESSION['email']))
{



    $email = $_SESSION['email'];
    $user_id = $_SESSION['user_id']; $current_employee_type_result = $mysqli->query("select DISTINCT employee_types.title,employee_types.id from employee_types, users, employee_data where employee_data.user_id = '$user_id' and employee_types.id = employee_data.employee_type_id") or die($mysqli->error());
    if($current_employee_type_result->num_rows !=0)
    {
        $current_employee_type_data = $current_employee_type_result->fetch_assoc();
        $current_employee_type_result->free();
        $type_of_employment = $current_employee_type_data['title'];
    }
    else
        {
            $_SESSION['message'] = "Not a valid email address";
            header("location:error.php");

        }

   if(isset($type_of_employment))
   {
       if($type_of_employment != 'Administrator')
       {
           $_SESSION['message'] = "This is invalid submission";
           header("location:error.php");
       }
       if($_SESSION['two_step'] == 0)
       {
           $_SESSION['message'] = "You are not completed 2nd step of registration";
           header("location:error.php");

       }



   }else
       {
           $_SESSION['message'] = "Something went wrong";
           header("location:error.php");
       }

}else
{
    $_SESSION['message'] = "This session has expired. Please login again!!!";
    header("location:error.php");
}


if(isset($_POST))
{

    if(isset($_POST['id']) && isset($_POST['action_type']))
    {
        $id = $_POST['id'];
        $at = $_POST['action_type'];

        if((is_int($id) || ctype_digit($id)) && (int)$id > 0) {

            if ($at == "approve") {


                $result = $mysqli->query("select * from student_data where id='$id' and is_locked='1'");

                if ($result->num_rows != 0) {

                    $data = $result->fetch_assoc();

                    $user_id = $data['user_id'];

                    if ($data['registration_number'] == null) {
                        $result_max = $mysqli->query("select MAX(registration_number) as max_reg from student_data WHERE registration_number IS NOT NULL");

                        if ($result_max->num_rows != 0) {

                            $data_max = $result_max->fetch_assoc();
                            $max_value = $data_max['max_reg'];

                            if ($max_value == NULL) {
                                $next_id = 100001;
                            } else {
                                $next_id = (int)$max_value + 1;

                            }


                        } else {

                            $_SESSION['message'] = "Database access error";
                            header("location:error.php");

                        }


                        $sql_1 = "UPDATE student_data  SET is_approved='1', registration_number='$next_id'"
                            . "  WHERE id='$id'";

                        $sql_2 = "UPDATE users  SET two_step='1'"
                            . "  WHERE id='$user_id'";


                        if ($mysqli->query($sql_1) && $mysqli->query($sql_2)) {


                            $_SESSION['message'] = "You have successfully approved the student";
                            header("location:success.php");
                        } else {
                            $_SESSION['message'] = "Database access error";
                            header("location:error.php");

                        }


                    } else {

                        $sql_1 = "UPDATE student_data  SET is_approved='1'"
                            . "  WHERE id='$id'";

                        $sql_2 = "UPDATE users  SET two_step='1'"
                            . "  WHERE id='$user_id'";


                        if ($mysqli->query($sql_1) && $mysqli->query($sql_2)) {


                            $_SESSION['message'] = "You have successfully approved the student";
                            header("location:success.php");
                        } else {
                            $_SESSION['message'] = "Database access error";
                            header("location:error.php");

                        }


                    }

                } else {

                    $_SESSION['message'] = "Can't find the student data for the given id or The student profile which isn't locked yet";
                    header("location:error.php");

                }


            } elseif ($at == "disapprove") {
                $result = $mysqli->query("select * from student_data where id='$id' and is_locked='1'");

                if ($result->num_rows != 0) {


                    $data = $result->fetch_assoc();
                    $user_id = $data['user_id'];

                    $sql_1 = "UPDATE student_data  SET is_approved='0'"
                        . "  WHERE id='$id'";

                    $sql_2 = "UPDATE users  SET two_step='0'"
                        . "  WHERE id='$user_id'";


                    if ($mysqli->query($sql_1) && $mysqli->query($sql_2)) {


                        $_SESSION['message'] = "You have successfully disapproved the student";
                        header("location:success.php");
                    } else {
                        $_SESSION['message'] = "Database access error";
                        header("location:error.php");

                    }

                }
                else {

                    $_SESSION['message'] = "Can't find the student data for the given id or The student profile which isn't locked yet";
                    header("location:error.php");

                }


            } elseif ($at == "delete") {

                $result = $mysqli->query("select * from student_data where id='$id'");

                if ($result->num_rows != 0) {

                    $data = $result->fetch_assoc();
                    $user_id = $data['user_id'];

                    $sql_1 = "DELETE FROM student_data WHERE id='$id'";

                    $sql_2 = "UPDATE users  SET two_step='0'"
                        . "  WHERE id='$user_id'";


                    if ($mysqli->query($sql_1) && $mysqli->query($sql_2)) {


                        $_SESSION['message'] = "You have successfully deleted the student";
                        header("location:success.php");
                    } else {
                        $_SESSION['message'] = "Database access error";
                        header("location:error.php");

                    }


                }
                else {

                    $_SESSION['message'] = "Can't find the student data for the given id or The student profile which isn't locked yet";
                    header("location:error.php");

                }

            } else {

                $_SESSION['message'] = "Parameters error";
                header("location:error.php");
            }
        }
        else
            {
                $_SESSION['message'] = "Id must be an integer";
                header("location:error.php");

            }

    }
    else
    {

        $_SESSION['message'] = "Parameters are missing";
        header("location:error.php");

    }





}else
    {

        $_SESSION['message'] = "Not a valid method";
        header("location:error.php");

    }












