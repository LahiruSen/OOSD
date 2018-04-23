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

var_dump($_POST);
die();

//This array is useful to get previous value of post if there is validation error(s)

$old = array();

$old['title'] = $_POST['title'];
$old['sex'] = $_POST['sex'];
$old['full_name'] = $_POST['full_name'];
$old['dob'] = $_POST['dob'];
$old['nic'] = $_POST['nic'];
$old['civil_status'] = $_POST['civil_status'];

if(isset($_POST['is_physical']))
{
    $old['is_physical'] = $_POST['is_physical'];
}
else
{
    $old['is_physical'] = 'off';
}

$old['father_full_name'] = $_POST['father_full_name'];
$old['mother_full_name'] = $_POST['mother_full_name'];
$old['add_line_1'] = $_POST['add_line_1'];
$old['add_line_2'] = $_POST['add_line_2'];
$old['postal_code'] = $_POST['postal_code'];
$old['city'] = $_POST['city'];
$old['phone_number'] = $_POST['phone_number'];
$old['cp_full_name'] = $_POST['cp_full_name'];
$old['cp_phone_number'] = $_POST['cp_phone_number'];
$old['al_index_number'] = $_POST['al_index_number'];


//validate post inputs
$validation_result = array();

$validation_result[] = array('full_name',name_validator($_POST['full_name']));
$validation_result[] = array('dob',dob_validator($_POST['dob']));
$validation_result[] = array('nic',nic_validator($_POST['nic']));
$validation_result[] = array('father_full_name',name_validator($_POST['father_full_name']));
$validation_result[] = array('mother_full_name',name_validator($_POST['mother_full_name']));
$validation_result[] = array('add_line_1',address_validator($_POST['add_line_1']));
$validation_result[] = array('add_line_2',address_validator($_POST['add_line_2']));
$validation_result[] = array('postal_code',postal_code_validator($_POST['postal_code']));
$validation_result[] = array('city',address_validator($_POST['city']));
$validation_result[] = array('phone_number',phone_number_validator($_POST['phone_number']));
$validation_result[] = array('cp_full_name',name_validator($_POST['cp_full_name']));
$validation_result[] = array('cp_phone_number',phone_number_validator($_POST['cp_phone_number']));
$validation_result[] = array('al_index_number',al_index_validator($_POST['al_index_number']));


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
    $postal_code = $_POST['postal_code'];
    $father_full_name = $_POST['father_full_name'];
    $mother_full_name = $_POST['mother_full_name'];
    $contact_person_full_name = $_POST['cp_full_name'];
    $contact_person_phone_number = $_POST['cp_phone_number'];
    $full_name = $_POST['full_name'];
    $dob = $_POST['dob'];
    $civil_status = $_POST['civil_status'];
    $sex = $_POST['sex'];
    $nic = $_POST['nic'];

    if(isset($_POST['is_physical']))
    {
        $is_physically_disabled = $_POST['is_physical'];
    }
    else
    {
        $is_physically_disabled = 'off';
    }

    $al_index_number = $_POST['al_index_number'];


    $date_of_create= $mysqli->escape_string( date("Y-m-d H:i:s"));
    $date_of_update= $mysqli->escape_string( date("Y-m-d H:i:s"));
    $registered_ayear_id = $_POST['ayear_id'];

    $is_student_result = $mysqli->query("SELECT * FROM student_data WHERE user_id='$user_id'") or die($mysqli->error());

    if($is_student_result->num_rows != 0)
    {

        $is_student_data = $is_student_result->fetch_assoc();

        if($is_student_data['is_locked'] == 0)
        {
            //update query
            $sql = "UPDATE student_data SET address_line_1='$address_line_1', address_line_2='$address_line_2', city='$city', title='$title', phone_number='$phone_number', postal_code='$postal_code',"
                ." father_full_name='$father_full_name', mother_full_name='$mother_full_name', contact_person_full_name='$contact_person_full_name', contact_person_phone_number='$contact_person_phone_number', full_name='$full_name', dob='$dob', "
                ."civil_status='$civil_status', sex='$sex', nic='$nic', is_physically_disabled='$is_physically_disabled', al_index_number='$al_index_number', date_of_create='$date_of_create', date_of_update='$date_of_update', registered_ayear_id='$registered_ayear_id' WHERE user_id='$user_id'";

        } else
            {
                $_SESSION['message'] = "You can not change your profile information Now. Deadline is exceeded";
                header("location:error.php");

            }

    }else
        {
            //insert query
            $sql = "INSERT INTO student_data (user_id, address_line_1, address_line_2, city, title, phone_number, postal_code,"
                ." father_full_name, mother_full_name, contact_person_full_name, contact_person_phone_number, full_name, dob, "
                ."civil_status, sex, nic, is_physically_disabled, al_index_number, date_of_create, date_of_update, registered_ayear_id) "
                . "VALUES ('$user_id','$address_line_1','$address_line_2','$city', '$title', '$phone_number','$postal_code','$father_full_name',"
                ."'$mother_full_name','$contact_person_full_name','$contact_person_phone_number','$full_name','$dob','$civil_status','$sex',"
                ."'$nic','$is_physically_disabled','$al_index_number','$date_of_create','$date_of_update','$registered_ayear_id')";

        }


    if ( $mysqli->query($sql) )
    {

        $ay_result = $mysqli->query("SELECT * FROM academic_year WHERE id='$registered_ayear_id'") or die($mysqli->error());

        if($ay_result->num_rows != 0)
        {
            $ay_data = $ayear_result->fetch_assoc();

            if($ay_data['status'] == 1) {
                $_SESSION['message'] = "You have successfully save your profile information. You can change those information before the deadline for the academic year reregistration. The information will lock after the deadline ".$ay_data['registration_deadline'];
                header("location:success.php");
            }
            else
                {
                    $_SESSION['message'] = "You have successfully save your profile information. But the is an issue with the academic year. Please contact the administrator.";
                    header("location:error.php");
                }
        }




    }




}














