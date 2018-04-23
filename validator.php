<?php
/**
 * Created by PhpStorm.
 * User: BlackLion
 * Date: 4/19/2018
 * Time: 11:09 AM
 */



/* student

first_name
last_name
email
title *
sex *
full_name *
dob *
civil_states *
nic*
is_physical *
father_full_name *
mother_full_name *
add_line_1 *
add_line_2 *
postal_code *
city *
phone_number *
cp_full_name *
cp_phone_number *
al_index_number *
user_id
type

*/

//full_name, father_full_name, mother_full_name, cp_full_name
function name_validator($val)
{

    if(isset($val)) {


        if (strlen($val) == 0) {
            return "Can't be empty!";
        } else {

            if (preg_match("/^([a-zA-Z' ]+)$/", $val)) {
                return "Y";
            } else {
                return "This is not a valid name!";
            }
        }
    } else
        {
            return "This input did not receive!";
        }

}

//dob
function dob_validator($val)
{


    if(isset($val)) {

            $current_date = date('m/d/Y');
            $today =  new DateTime($current_date);

            if( strlen($val) == 0)
            {
                return "This is can not be empty!";
            }else {
                $dob = new DateTime($val);

                if ($today > $dob) {
                    return "Y";
                } else {
                    return "This is not a valid date!";
                }
            }
    }
    else
    {
        return "This input did not receive!";
    }
}

//nic validator
function nic_validator($val)
{

    if(isset($val)) {


        if (strlen($val) == 0) {
            return "This is can not be empty!";
        } else {
            if (strlen($val) < 10) {

                return "This should have at least 10 characters";
            } else {
                return "Y";
            }
        }
    }
    else
    {
        return "This input did not receive!";
    }

}

//add_line_1, add_line_2 , city
function address_validator($val)
{

    if(isset($val)) {


        if (strlen($val) == 0) {
            return "This is can not be empty!";
        } else {

           return "Y";
        }
    } else
    {
        return "This input did not receive!";
    }

}

//postal_code validator
function postal_code_validator($val)
{

    if(isset($val)) {


        if (strlen($val) == 0) {
            return "This is can not be empty!";
        }
        else
        {
            if (strlen($val) != 5 || !is_numeric($val)) {

                return "This should have 5 numbers";
            } else {
                return "Y";
            }
        }
    } else
    {
        return "This input did not receive!";
    }

}

//phone number validator
function phone_number_validator($val)
{

    if(isset($val)) {


        if (strlen($val) == 0) {
            return "This is can not be empty!";
        }
        else
        {
            if (strlen($val) != 10 || !is_numeric($val)) {

                return "This should have 10 numbers";
            } else {
                return "Y";
            }
        }
    } else
    {
        return "This input did not receive!";
    }

}

//AL index validator [only for student]
function al_index_validator($val)
{

    if(isset($val)) {


        if (strlen($val) == 0) {
            return "This is can not be empty!";
        }
        else
        {
            if (strlen($val) != 8 || !is_numeric($val)) {

                return "This should have 8 numbers";
            } else {
                return "Y";
            }
        }
    } else
    {
        return "This input did not receive!";
    }

}

//employee ID [only for employee]
function employee_id_validator($val)
{

    if(isset($val)) {


        if (strlen($val) == 0) {
            return "This is can not be empty!";
        }
        else
        {
            if (strlen($val) < 8) {

                return "This should have at least 8 characters";
            } else {
                return "Y";
            }
        }
    } else
    {
        return "This input did not receive!";
    }

}