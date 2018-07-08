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



/*
academic year
*/


//Defining validation check and old variable arrays

$old = array();
$validation_result = array();

if(isset($_POST['title'])){$old['title'] = $_POST['title'];}else{$validation_result[] = array('title',"Please put a valid title");}
if(isset($_POST['description'])){$old['description'] = $_POST['description'];}else{$validation_result[] = array('description',"Please put a valid description");}
if(isset($_POST['deadline'])){$old['deadline'] = $_POST['deadline']; if(isset($_POST['academic_year_id'])){  $ayv = academic_year_for_level_validator($_POST['academic_year_id'],$mysqli);  if($ayv[0] =='Y') {$from_date = new DateTime($ayv[1]['from_date']);$to_date = new DateTime($ayv[1]['to_date']);$deadline = new DateTime($_POST['deadline']);$validation_result[] = array('deadline',deadline_validator($from_date,$to_date,$deadline));}}else{$validation_result[] = array('deadline',"Should have an associative valid academic year");}}else{$validation_result[] = array('deadline',"Please put a valid deadline");}
if(isset($_POST['academic_year_id'])){$old['academic_year_id'] = $_POST['academic_year_id'];$validation_result[] = array('academic_year_id',academic_year_for_level_validator($_POST['academic_year_id'],$mysqli)[0]);}else{$validation_result[] = array('academic_year_id',"Please put a valid academic year");}

if(isset($_GET['id'])) {
    if (isset($_POST['type']) && isset($_POST['academic_year_id'])) {
        $old['type'] = $_POST['type'];
        $validation_result[] = array('type', academic_level_type_validator($_POST['academic_year_id'],$_POST['type'],$_GET['id'], $mysqli));
    } else {
        $validation_result[] = array('type', "Please put a valid academic year or select a type[academic year is required to define type]");
    }

}else
    {
        if (isset($_POST['type']) && isset($_POST['academic_year_id'])) {
            $old['type'] = $_POST['type'];
            $validation_result[] = array('type', academic_level_type_validator($_POST['academic_year_id'],$_POST['type'],0, $mysqli));
        } else {
            $validation_result[] = array('type', "Please put a valid academic year or select a type[academic year is required to define type]");
        }

    }





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

    if(isset($_POST['create_new_al']))
    {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $deadline = $_POST['deadline'];
        $type = $_POST['type'];
        $academic_year_id = $_POST['academic_year_id'];
        $date_of_create= $mysqli->escape_string( date("Y-m-d H:i:s"));
        $date_of_update= $mysqli->escape_string( date("Y-m-d H:i:s"));

        //insert query
        $sql = "INSERT INTO level  (title, description, deadline, academic_year_id, date_of_create,"
            ." date_of_update,type) "
            . "VALUES ('$title','$description','$deadline',$academic_year_id,'$date_of_create','$date_of_update','$type')";


        if($mysqli->query($sql))
        {
            header("location:create_academic_level.php");
        }
        else
        {
            $_SESSION['message'] = "Something went wrong!";
            header("location:error.php");
        }

    }
    else
    {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $deadline = $_POST['deadline'];
        $type = $_POST['type'];
        $academic_year_id = $_POST['academic_year_id'];
        $date_of_update= $mysqli->escape_string( date("Y-m-d H:i:s"));
        $id = $_GET['id'];


        $sql_level = "SELECT * FROM level WHERE id='$id'";
        $level_result = $mysqli->query($sql_level);

        if($level_result->num_rows !=0)
        {
            $sql = "UPDATE level  SET title='$title', description='$description', deadline='$deadline', academic_year_id='$academic_year_id', date_of_update='$date_of_update',type='$type'"
                ."  WHERE id='$id'";

            if($mysqli->query($sql))
            {
                header("location:create_academic_level.php");
            }
            else
             {
                 $_SESSION['message'] = "Something went wrong!";
                 header("location:error.php");
             }

            $level_result->free();


        }else
        {
            $_SESSION['message'] = "This academic year is not available ";
            header("location:error.php");
        }



    }


}else
    {

        if(!isset($_POST['create_new_al'])) {

            $id = $_GET['id'];

            if((is_int($id) || ctype_digit($id)) && (int)$id > 0)
            {
                $level_id = $id;

                $selceted_accedemic_level_result  =  $mysqli->query("select * from level where id='$level_id'") or die($mysqli->error());

                if($selceted_accedemic_level_result->num_rows !=0)
                {

                    $selceted_accedemic_level_data=$selceted_accedemic_level_result->fetch_assoc();

                    $selceted_accedemic_level_result->free();

                    if(isset($selceted_accedemic_level_data))
                    {

                        $selected = $selceted_accedemic_level_data;

                    }else
                    {
                        header("location: create_academic_level.php");


                    }



                }else
                {
                    header("location: create_academic_level.php");

                }


            }else
            {
                header("location: create_academic_level.php");


            }




        }else
        {
            $_SESSION['message'] = "No valid submission";
            header("location:error.php");

            //should set error in here
        }




    }















