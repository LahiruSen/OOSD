<?php


/**
 * Created by PhpStorm.
 * User: BlackLion
 * Date: 4/6/2018
 * Time: 8:19 AM
 */

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


//This array is useful to get previous value of post if there is validation error(s)

$old = array();

$old['title'] = $_POST['title'];
$old['description'] = $_POST['description'];
$old['from_date'] = $_POST['from_date'];
$old['to_date'] = $_POST['to_date'];
$old['registration_deadline'] = $_POST['registration_deadline'];
$old['status'] = $_POST['status'];



//validate post inputs
$validation_result = array();

$validation_result[] = array('title',address_validator($_POST['title']));
$validation_result[] = array('description',address_validator($_POST['description']));
$validation_result[] = array('from_date',address_validator($_POST['from_date']));
$validation_result[] = array('to_date',address_validator($_POST['to_date']));
$validation_result[] = array('registration_deadline',address_validator($_POST['registration_deadline']));


//Might be needed

//if(address_validator($_POST['from_date']) =="Y" && address_validator($_POST['to_date'])  == "Y" && isset($_POST['id']))
//{
//    $validation_result[] = array('from_to',date_withing_validator($_POST['from_date'],$_POST['to_date'],$mysqli,$_POST['id']));
//}
//else
//    {
//        $validation_result[] = array('from_to',date_withing_validator($_POST['from_date'],$_POST['to_date'],$mysqli));
//    }

$from_date = new DateTime($_POST['from_date']);
$to_date = new DateTime($_POST['to_date']);
$registration_deadline = new DateTime($_POST['registration_deadline']);



if($registration_deadline>$to_date || $registration_deadline <$from_date)
{
    $validation_result[] = array('registration_deadline_not_range','Registration deadline is not in the academic year period');
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
        $id = $_POST['id'];

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















