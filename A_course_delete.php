<?php
/**
 * Created by PhpStorm.
 * User: BlackLion
 * Date: 5/5/2018
 * Time: 7:37 PM
 */


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


        $ay_id = $_GET['id'];

        $sql = "SELECT * FROM courses WHERE course_id='$ay_id'";
        $ay_result = $mysqli->query($sql) or die($mysqli->error());

        if($ay_result->num_rows !=0)
        {
            $ay_result->free();

            $sql = "SELECT * FROM course_registration WHERE course_id='$ay_id'";
            $st_data_result = $mysqli->query($sql) or die($mysqli->error());

            if($st_data_result->num_rows ==0)
            {
                $st_data_result->free();
                $sql = "DELETE FROM courses WHERE course_id='$ay_id'";

                if($mysqli->query($sql))
                {

                    header("location:A_create_courses.php");

                }else
                    {
                        $_SESSION['message'] = "Something went wrong";
                        header("location:error.php");
                    }

            }else
                {
                    $_SESSION['message'] = "It is not possible to delete this academic year. Some student's registrations are associated with this course!!!";
                    header("location:error.php");
                }




        }else
            {
                $_SESSION['message'] = "can't find associated course";
                header("location:error.php");
            }




}else
    {
        $_SESSION['message'] = "No Course id found!!!";
        header("location:error.php");
    }


