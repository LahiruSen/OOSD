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
    $current_employee_type_result = $current_user_info_result = $mysqli->query("select DISTINCT employee_types.title,employee_types.id from employee_types, users, employee_data where users.email = '$email' and employee_types.id = employee_data.employee_type_id") or die($mysqli->error());
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


                $result = $mysqli->query("select * from employee_data where id='$id' and is_locked='1'");

                if ($result->num_rows != 0) {

                    $data = $result->fetch_assoc();

                    $user_id = $data['user_id'];


                    $sql_1 = "UPDATE employee_data  SET is_approved='1'"
                        . "  WHERE id='$id'";

                    $sql_2 = "UPDATE users  SET two_step='1'"
                        . "  WHERE id='$user_id'";


                    if ($mysqli->query($sql_1) && $mysqli->query($sql_2)) {


                        $_SESSION['message'] = "You have successfully approved the employee";
                        header("location:success.php");
                    } else {
                        $_SESSION['message'] = "Database access error";
                        header("location:error.php");

                    }




                } else {

                    $_SESSION['message'] = "Can't find the employee data for the given id or The employee profile which isn't locked yet";
                    header("location:error.php");

                }


            } elseif ($at == "disapprove") {
                $result = $mysqli->query("select * from employee_data where id='$id' and is_locked='1'");

                if ($result->num_rows != 0) {


                    $data = $result->fetch_assoc();
                    $user_id = $data['user_id'];

                    $sql_1 = "UPDATE employee_data  SET is_approved='0'"
                        . "  WHERE id='$id'";

                    $sql_2 = "UPDATE users  SET two_step='0'"
                        . "  WHERE id='$user_id'";


                    if ($mysqli->query($sql_1) && $mysqli->query($sql_2)) {


                        $_SESSION['message'] = "You have successfully disapproved the employee";
                        header("location:success.php");
                    } else {
                        $_SESSION['message'] = "Database access error";
                        header("location:error.php");

                    }

                }
                else {

                    $_SESSION['message'] = "Can't find the employee data for the given id or The employee profile which isn't locked yet";
                    header("location:error.php");

                }


            } elseif ($at == "delete") {

                $result = $mysqli->query("select * from employee_data where id='$id'");

                if ($result->num_rows != 0) {

                    $data = $result->fetch_assoc();
                    $user_id = $data['user_id'];

                    $sql_1 = "DELETE FROM employee_data WHERE id='$id'";

                    $sql_2 = "UPDATE users  SET two_step='0'"
                        . "  WHERE id='$user_id'";


                    if ($mysqli->query($sql_1) && $mysqli->query($sql_2)) {


                        $_SESSION['message'] = "You have successfully deleted the employee";
                        header("location:success.php");
                    } else {
                        $_SESSION['message'] = "Database access error";
                        header("location:error.php");

                    }


                }
                else {

                    $_SESSION['message'] = "Can't find the employee data for the given id or The employee profile which isn't locked yet";
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












