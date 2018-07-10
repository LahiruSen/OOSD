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
    $email = $_SESSION['email'];
    $active = $_SESSION['active'];

       if($active != 1)
       {

           $_SESSION['message'] = "Please activate your account";
           header("location:error.php");
       }

}else
{
    $_SESSION['message'] = "This session has expired. Please login again!!!";
    header("location:error.php");
}



/*
academic year
*/


//Defining validation check and old variable arrays


$validation_result = array();

if(isset($_POST['new_password'])){$validation_result[] = array('new_password',password_character_matching_validator($_POST['new_password']));}
if(isset($_POST['confirm_password'])){$validation_result[] = array('confirm_password',password_character_matching_validator($_POST['confirm_password']));}
if(isset($_POST['confirm_password'])  && isset($_POST['new_password']) ){$validation_result[] = array('confirm_password',password_matching_validator($_POST['confirm_password'],$_POST['new_password']));$validation_result[] = array('new_password',password_matching_validator($_POST['confirm_password'],$_POST['new_password']));}





$error_counter = 0;
$error_array = array();

for($i=0;$i< sizeof($validation_result);$i++)
{

    if($validation_result[$i][1] != 'Y')
    {
        $error_counter++;
        $error_array[$validation_result[$i][0]] = $validation_result[$i][1];
    }

}



if($error_counter == 0)
{



        $password = $mysqli->escape_string(password_hash($_POST['new_password'], PASSWORD_BCRYPT));
        $date_of_update= $mysqli->escape_string( date("Y-m-d H:i:s"));

        //insert query
        $sql_1 = "UPDATE users  SET password='$password',date_of_update='$date_of_update' WHERE email='$email'";



        if($mysqli->query($sql_1))
        {
            $_SESSION['message'] = "Password is successfully changed!";
            header("location:success.php");
        }
        else
        {
            $_SESSION['message'] = "Something went wrong!";
            header("location:error.php");
        }





}
else
    {
        $_SESSION['message'] = "Please activate your account";
        header("location:error.php");


    }















