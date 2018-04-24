<?php
/**
 * Created by PhpStorm.
 * User: BlackLion
 * Date: 4/6/2018
 * Time: 8:19 AM
 */


require 'validator.php';

// all the input name

/* student

first_name
last_name
email
title
sex
full_name
dob
civil_status
nic
is_physical
father_full_name
mother_full_name
add_line_1
add_line_2
postal_code
city
phone_number
cp_full_name
cp_phone_number
al_index_number
user_id
type

*/


//This array is useful to get previous value of post if there is validation error(s)



$old = array();

$old['title'] = $_POST['title'];
$old['sex'] = $_POST['sex'];
$old['full_name'] = $_POST['full_name'];
$old['dob'] = $_POST['dob'];
$old['nic'] = $_POST['nic'];
$old['civil_status'] = $_POST['civil_status'];
$old['add_line_1'] = $_POST['add_line_1'];
$old['add_line_2'] = $_POST['add_line_2'];
$old['postal_code'] = $_POST['postal_code'];
$old['city'] = $_POST['city'];
$old['phone_number'] = $_POST['phone_number'];
$old['employee_id'] = $_POST['employee_id'];
$old['employee_type_id'] = $_POST['employee_type_id'];


//validate post inputs
$validation_result = array();

$validation_result[] = array('full_name',name_validator($_POST['full_name']));
$validation_result[] = array('dob',dob_validator($_POST['dob']));
$validation_result[] = array('nic',nic_validator($_POST['nic']));
$validation_result[] = array('add_line_1',address_validator($_POST['add_line_1']));
$validation_result[] = array('add_line_2',address_validator($_POST['add_line_2']));
$validation_result[] = array('postal_code',postal_code_validator($_POST['postal_code']));
$validation_result[] = array('city',address_validator($_POST['city']));
$validation_result[] = array('phone_number',phone_number_validator($_POST['phone_number']));
$validation_result[] = array('employee_id',employee_id_validator($_POST['employee_id']));


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

        }



}














