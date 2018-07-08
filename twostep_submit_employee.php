<?php
/**
 * Created by PhpStorm.
 * User: BlackLion
 * Date: 4/6/2018
 * Time: 8:19 AM
 */


require 'validator.php';
if (session_status() == PHP_SESSION_NONE) {    session_start();}
if(isset($_SESSION['email']))
{

    $email = $_SESSION['email'];
    $sql ="SELECT * FROM users WHERE email='$email'";

    $user_result = $mysqli->query($sql);

    if($user_result->num_rows ==0)
    {
        $_SESSION['message'] = "This is invalid submition";
        header("location:error.php");
    }

}else
{
    $_SESSION['message'] = "This session has expired. Please login again!!!";
    header("location:error.php");
}


//Defining validation check and old variable arrays



$old = array();
$validation_result = array();


if(isset($_POST['title'])){$old['title'] = $_POST['title'];}else{$validation_result[] = array('title',"Please select a valid title");}
if(isset($_POST['sex'])){$old['sex'] = $_POST['sex'];}else{$validation_result[] = array('sex',"Please select a valid sex");}
if(isset($_POST['full_name'])){$old['full_name'] = $_POST['full_name'];$validation_result[] = array('full_name',name_validator($_POST['full_name']));}else{$validation_result[] = array('full_name',"Please put a valid full name");}
if(isset($_POST['dob'])){$old['dob'] = $_POST['dob'];$validation_result[] = array('dob',dob_validator($_POST['dob']));}else{$validation_result[] = array('dob',"Please put a valid date of birth");}
if(isset($_POST['nic'])){$old['nic'] = $_POST['nic'];$validation_result[] = array('nic',nic_validator($_POST['nic']));}else{$validation_result[] = array('nic',"Please put a valid national identity card number");}
if(isset($_POST['civil_status'])){$old['civil_status'] = $_POST['civil_status'];}else{$validation_result[] = array('civil_status',"Please select a valid civil status");}
if(isset($_POST['add_line_1'])){$old['add_line_1'] = $_POST['add_line_1'];$validation_result[] = array('add_line_1',address_validator($_POST['add_line_1']));}else{$validation_result[] = array('add_line_1',"Please put a valid address line one");}
if(isset($_POST['add_line_2'])){$old['add_line_2'] = $_POST['add_line_2'];$validation_result[] = array('add_line_2',address_validator($_POST['add_line_2']));}else{$validation_result[] = array('add_line_2',"Please put a valid address line two");}
if(isset($_POST['postal_code'])){$old['postal_code'] = $_POST['postal_code'];$validation_result[] = array('postal_code',postal_code_validator($_POST['postal_code']));}else{$validation_result[] = array('postal_code',"Please put a valid postal code");}
if(isset($_POST['city'])){$old['city'] = $_POST['city'];$validation_result[] = array('city',address_validator($_POST['city']));}else{$validation_result[] = array('city',"Please put a valid city");}
if(isset($_POST['phone_number'])){$old['phone_number'] = $_POST['phone_number'];$validation_result[] = array('phone_number',phone_number_validator($_POST['phone_number']));}else{$validation_result[] = array('phone_number',"Please put a valid phone number");}
if(isset($_POST['employee_id'])){$old['employee_id'] = $_POST['employee_id'];$validation_result[] = array('employee_id',employee_id_validator($_POST['employee_id']));}else{$validation_result[] = array('employee_id',"Please put a valid employee ID");}
if(isset($_POST['employee_type_id'])){$old['employee_type_id'] = $_POST['employee_type_id'];}else{$validation_result[] = array('employee_type_id',"Please select a valid employee type");}




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

    $user_id = $_POST['user_id'];
    $address_line_1 = $_POST['add_line_1'];
    $address_line_2 = $_POST['add_line_2'];
    $city = $_POST['city'];
    $title = $_POST['title'];
    $phone_number = $_POST['phone_number'];
    $employee_id = $_POST['employee_id'];
    $employee_type_id = $_POST['employee_type_id'];
    $postal_code = $_POST['postal_code'];
    $full_name = $_POST['full_name'];
    $dob = $_POST['dob'];
    $civil_status = $_POST['civil_status'];
    $sex = $_POST['sex'];
    $nic = $_POST['nic'];
    $date_of_create= $mysqli->escape_string( date("Y-m-d H:i:s"));
    $date_of_update= $mysqli->escape_string( date("Y-m-d H:i:s"));

    $is_employee_result = $mysqli->query("SELECT * FROM employee_data WHERE user_id='$user_id'") or die($mysqli->error());


    if($is_employee_result->num_rows != 0)
    {

        $is_employee_data = $is_employee_result->fetch_assoc();
        $is_employee_result->free();

        if($is_employee_data['is_locked'] == 0)
        {

            if($_POST['employee'] == "lock")
            {
                $sql = "UPDATE employee_data SET address_line_1='$address_line_1', address_line_2='$address_line_2', city='$city', title='$title', phone_number='$phone_number', postal_code='$postal_code',"
                    ."full_name='$full_name', dob='$dob', "
                    ."civil_status='$civil_status', sex='$sex', nic='$nic', employee_id='$employee_id', employee_type_id='$employee_type_id', date_of_update='$date_of_update', is_locked=1 WHERE user_id='$user_id'";

            }

            else {
                //update query
                $sql = "UPDATE employee_data SET address_line_1='$address_line_1', address_line_2='$address_line_2', city='$city', title='$title', phone_number='$phone_number', postal_code='$postal_code',"
                    . "full_name='$full_name', dob='$dob', "
                    . "civil_status='$civil_status', sex='$sex', nic='$nic', employee_id='$employee_id', employee_type_id='$employee_type_id', date_of_update='$date_of_update' WHERE user_id='$user_id'";
            }

        } else
        {
            $_SESSION['message'] = "You can not change your profile information Now. You already locked your information. Please contact the admin if you want to change the information!";
            header("location:error.php");

        }

    }else
    {
        //insert query
        $sql = "INSERT INTO employee_data (user_id, address_line_1, address_line_2, city, title, phone_number, postal_code,"
            ." full_name, dob, "
            ."civil_status, sex, nic, employee_id, employee_type_id, date_of_create, date_of_update) "
            . "VALUES ('$user_id','$address_line_1','$address_line_2','$city', '$title', '$phone_number','$postal_code',"
            ."'$full_name','$dob','$civil_status','$sex',"
            ."'$nic','$employee_id','$employee_type_id','$date_of_create','$date_of_update')";

    }






    if ( $mysqli->query($sql) )
    {

        if($_POST['employee'] == "lock")
        {
            $_SESSION['message'] = "You have successfully submitted your profile information. Our admin will look about it and verify your account. Thank you.";
            header("location:success.php");
        }
        else
            {
                $_SESSION['message'] = "You have successfully save your profile information. When you have finish with your profile please press the complete button instead of pressing save button";
                header("location:success.php");

            }



    }else
        {
            $_SESSION['message'] = "Unexpected error is occurred . contact our administrator";
            header("location:error.php");
        }



}














