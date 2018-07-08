<?php
/**
 * Created by PhpStorm.
 * User: BlackLion
 * Date: 5/5/2018
 * Time: 7:37 PM
 */


require 'db.php';
if (session_status() == PHP_SESSION_NONE) {    session_start();}

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


if(isset($_GET['id']))
{



    if((is_int($_GET['id']) || ctype_digit($_GET['id'])) && (int)$_GET['id'] > 0)
    {
        $al_id = $_GET['id'];

        $sql = "SELECT * FROM level WHERE id='$al_id'";
        $al_result = $mysqli->query($sql) or die($mysqli->error());

        if($al_result->num_rows !=0)
        {
            $al_result->free();

            $sql = "SELECT * FROM courses WHERE level_id='$al_id'";
            $courses_data_result = $mysqli->query($sql) or die($mysqli->error());

            if($courses_data_result->num_rows ==0)
            {
                $courses_data_result->free();
                $sql = "DELETE FROM level WHERE id='$al_id'";

                if($mysqli->query($sql))
                {

                    header("location:create_academic_level.php");

                }else
                    {
                        $_SESSION['message'] = "Something went wrong";
                        header("location:error.php");
                    }

            }else
                {
                    $_SESSION['message'] = "It is not possible to delete this academic level. Some courses are associated with this academic level!!!";
                    header("location:error.php");
                }




        }else
            {
                $_SESSION['message'] = "associated academic level can't find";
                header("location:error.php");
            }

    }else
        {
            $_SESSION['message'] = "academic level id is not valid integer!!!";
            header("location:error.php");
        }



}else
    {
        $_SESSION['message'] = "No academic level's id found!!!";
        header("location:error.php");
    }


