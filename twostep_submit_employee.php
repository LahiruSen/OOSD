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

    //Do the DB insertion and redirect to home page with success messages

}














