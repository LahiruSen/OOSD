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

if(isset($_POST['id']))
{
    if(isset($_POST['from_date']))
    {
        if(isset($_POST['to_date']))
        {

            $from_to = date_withing_validator($_POST['from_date'],$_POST['to_date'],$mysqli,$_POST['id']);
        }else
            {
                $from_to = "Please select a valid date range";

            }

    }else
    {
        $from_to = "Please select a valid date range";
    }

}
else
{

    if(isset($_POST['from_date']))
    {
        if(isset($_POST['to_date']))
        {

            $from_to = date_withing_validator($_POST['from_date'],$_POST['to_date'],$mysqli);
        }else
        {
            $from_to = "Please select a valid date range";

        }

    }else
    {
        $from_to = "Please select a valid date range";
    }
}

if(isset($_POST['from_date'])){$old['from_date'] = $_POST['from_date'];$validation_result[] = array('from_date',$from_to);}else{$validation_result[] = array('from_date',"Please put a valid start date");}
if(isset($_POST['to_date'])){$old['to_date'] = $_POST['to_date'];$validation_result[] = array('to_date',$from_to);}else{$validation_result[] = array('to_date',"Please put a valid start date");}

if(isset($_POST['from_date']))
{
    if(isset($_POST['to_date']))
    {
        if(isset($_POST['registration_deadline']))
        {
            $from_date = new DateTime($_POST['from_date']);
            $to_date = new DateTime($_POST['to_date']);
            $registration_deadline = new DateTime($_POST['registration_deadline']);

            $val_deadline = deadline_validator($from_date,$to_date,$registration_deadline);

        }
        else
        {
            $val_deadline = "Please select a valid deadline";

        }
    }
    else
        {
            $val_deadline = "To define a valid deadline, academic year end date should be defined first";

        }
}
else
    {
        $val_deadline = "To define a valid deadline, academic year start date should be defined first";

    }

if(isset($_POST['registration_deadline'])){$old['registration_deadline'] = $_POST['registration_deadline'];$validation_result[] = array('registration_deadline',$val_deadline);}else{$validation_result[] = array('registration_deadline',"Please put a valid registration deadline");}

if(isset($_POST['status'])){$old['status'] = $_POST['status'];}else{$validation_result[] = array('status',"Please select a valid title");}






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

    if(isset($_POST['create_new_ay']))
    {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $from_date = $_POST['from_date'];
        $to_date = $_POST['to_date'];
        $registration_deadline = $_POST['registration_deadline'];
        $status = $_POST['status'];
        $date_of_create= $mysqli->escape_string( date("Y-m-d H:i:s"));
        $date_of_update= $mysqli->escape_string( date("Y-m-d H:i:s"));

        //insert query
        $sql = "INSERT INTO academic_year  (title, description, from_date, to_date, registration_deadline, date_of_create,"
            ." date_of_update,status) "
            . "VALUES ('$title','$description','$from_date','$to_date', '$registration_deadline','$date_of_create','$date_of_update',"
            ."'$status')";

        if($mysqli->query($sql))
        {
            header("location:create_academic_year.php");
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
        $from_date = $_POST['from_date'];
        $to_date = $_POST['to_date'];
        $registration_deadline = $_POST['registration_deadline'];

        $status = $_POST['status'];
        $date_of_update= $mysqli->escape_string( date("Y-m-d H:i:s"));
        $id = $_GET['id'];



        $sql_year = "SELECT * FROM academic_year WHERE id='$id'";
        $year_result = $mysqli->query($sql_year);

        if($year_result->num_rows !=0)
        {
            $sql = "UPDATE academic_year  SET title='$title', description='$description', from_date='$from_date', to_date='$to_date', registration_deadline='$registration_deadline', date_of_update='$date_of_update',"
                ." status='$status' WHERE id='$id'";

            if($mysqli->query($sql))
            {
                header("location:create_academic_year.php");
            }
            else
             {
                 $_SESSION['message'] = "Something went wrong!";
                 header("location:error.php");
             }

            $year_result->free();


        }else
        {
            $_SESSION['message'] = "This academic year is not available ";
            header("location:error.php");
        }



    }



}
else
    {

        if(!isset($_POST['create_new_ay']))

            {
                $id = $_GET['id'];

                if((is_int($id) || ctype_digit($id)) && (int)$id > 0)
                {
                    $ay_id = $id;

                    $selceted_accedemic_years_result  =  $mysqli->query("select * from academic_year where id='$ay_id'") or die($mysqli->error());

                    if($selceted_accedemic_years_result->num_rows !=0)
                    {

                        $selceted_accedemic_years_data=$selceted_accedemic_years_result->fetch_assoc();

                        $selceted_accedemic_years_result->free();

                        if(isset($selceted_accedemic_years_data))
                        {

                            $selected = $selceted_accedemic_years_data;

                        }else
                        {
                            header("location: create_academic_year.php");
                        }



                    }else
                    {
                        header("location: create_academic_year.php");
                    }


                }else
                {
                    header("location: create_academic_year.php");
                }

            }


    }















