<?php


/**
 * Created by PhpStorm.
 * User: BlackLion
 * Date: 4/6/2018
 * Time: 8:19 AM
 */

require 'validator.php';
require 'db.php';

if (session_status() == PHP_SESSION_NONE) {    session_start();}
// CHECK THERE IS A LOGNG[SESSION VARIABLE WERE ONLY CREATED DURING LOGIN] &&&& CHECK USER TYPE = ADMINISTRATOR
if(isset($_SESSION['email']))
{
    $user_id = $_SESSION['user_id'];


    if($_SESSION['two_step'] == 0)
    {
        $_SESSION['message'] = "You are not completed 2nd step of registration";
        header("location:error.php");

    }


    if($_SESSION['types'] == 2 )
   {

       $_SESSION['message'] = "You cannot access this page";
       header("location:error.php");

   }



}else
{
    $_SESSION['message'] = "This session has expired. Please login again!!!";
    header("location:error.php");
}




if(isset($_POST['employee_id']) && isset($_POST['title'])&& isset($_POST['description']))
{



        $title = $_POST['title'];
        $description = $_POST['description'];
        $employee_id = $_POST['employee_id'];
        $sender = $_SESSION['user_id'];

        $number_of_rec = count($employee_id);
        $sent_count =0;





        if($number_of_rec>0){

            $date_of_create= $mysqli->escape_string( date("Y-m-d H:i:s"));
            $date_of_update= $mysqli->escape_string( date("Y-m-d H:i:s"));


            for($p=0;$p<$number_of_rec;$p++)
            {

                $sql = "INSERT INTO notifications  (title, description, target_user_ids,date_of_create,"
                    ." date_of_update,sender_id,is_seen) "
                    . "VALUES ('$title','$description','$employee_id[$p]','$date_of_create','$date_of_update','$sender','0')";


                if($mysqli->query($sql))
                {
                    $sent_count++;

                }else
                    {

                        $_SESSION['message'] = "Something went terribly wrong";
                        header("location:error.php");
                        die();

                    }




            }


            if($sent_count == $number_of_rec)
            {

                $_SESSION['message'] = "All the notification has sent";
                header("location:success.php");

            }else
                {


                    $_SESSION['message'] = "Something went wrong";
                    header("location:error.php");

                }










        }else{


            $_SESSION['message'] = "You have to select at least one employee as a receiver";
            header("location:error.php");


        }



        //insert query






}else
    {

        if(!isset($_POST['employee_id']))
        {
            $_SESSION['message'] = "You have to select at least one employee as a receiver";
            header("location:error.php");
        }else
            {
                $_SESSION['message'] = "Parameters are missing";
                header("location:error.php");
            }


    }















