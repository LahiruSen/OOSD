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





function course_id_validator($val)
{

    if(isset($val)) {


        if (strlen($val) == 0) {
            return "This is can not be empty!";
        } else {
            if(strlen($val)==6 && preg_match("/^[A-Z]{2}+[0-9]{4}/", $val)){
                return "Y";

            }else{
                return "Invalid Course ID format!";
            }

        }
    } else
    {
        return "This input did not receive!";
    }

}

function title_validator($val)
{

    if(isset($val)) {


        if (strlen($val) == 0) {
            return "This is can not be empty!";
        } else {

            if(preg_match("/^[A-Z]{1}/", $val)){
                if(strlen($val)>3){
                    return "Y";
                }else{
                    return "Please type something more";
                }


            }else{
                return "Invalid course name!";
            }
        }
    } else
    {
        return "This input did not receive!";
    }

}

function description_validator($val)
{

    if(isset($val)) {


        if (strlen($val) == 0) {
            return "This is can not be empty!";

        } else {

            if(preg_match("/^[A-Z]{1}/", $val)){
                if(strlen($val) > 10){
                    return "Y";

                }else{
                    return "Please add some more description!";
                }

            }else{
                return "Invalid course description!";
            }


        }
    } else
    {
        return "This input did not receive!";
    }

}

function credits_validator($val)
{

    if(isset($val)) {


        if (strlen($val) == 0) {
            return "This is can not be empty!";
        } else {
            if(is_numeric($val)){

                    if($val<=5 && $val>=1){
                        return "Y";
                    }else{
                        return "Enter numbers between 1 to 5";
                    }

                }else{
                return "Enter numbers only";
            }
        }

    } else
    {
        return "This input did not receive!";
    }

}

function working_hours_validator($val)
{

    if(isset($val)) {

        if (strlen($val) == 0) {
            return "This is can not be empty!";
        } else {
            if(is_numeric($val)){

                    if($val>=10 && $val<=50){
                        return "Y";
                    }else{
                        return "Enter numbers between 10 to 50";
                    }

            }else{
                return "Enter numbers only";
            }
        }

    } else
    {
        return "This input did not receive!";
    }

}

function level_validator($val)
{

    if(isset($val)) {

        if ($val == "select") {
            return "Select a level!";
        }
        else
        {
            return "Y";
        }
    } else
    {
        return "This input did not receive!";
    }

}

function teacher_validator($val)
{

    if(isset($val)) {

        if ($val == "select") {
            return "Select a teacher name!";
        }
        else
        {
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



function date_withing_validator($from_date,$to_date,$mysqli,$id=0)
{

        if($id !=0)
    {
        $academic_years_result = $mysqli->query("SELECT * FROM academic_year WHERE ((('$from_date' <= to_date AND '$from_date' >= from_date) OR ('$to_date' <= to_date AND '$to_date' >= from_date)) AND '$id' <> id)") or die($mysqli->error());
    }else
        {
            $academic_years_result = $mysqli->query("SELECT * FROM academic_year WHERE (('$from_date' <= to_date AND '$from_date' >= from_date) OR ('$to_date' <= to_date AND '$to_date' >= from_date))") or die($mysqli->error());
        }

    if($academic_years_result->num_rows !=0 )
    {
        $return_text ="Date range is overlapping! with following academic years: ";


        while ($row = $academic_years_result->fetch_assoc())
        {
            $return_text = $return_text.$row['title'].' ';
        }

        return $return_text;
    }else
        {
            return "Y";
        }

}


function deadline_validator($from_date,$to_date,$deadline)
{
    if($from_date<=$deadline && $deadline<= $to_date)
    {

        return "Y";
    }
    else
        {
            return "Deadline is not in the academic year range!";

        }

}

function academic_year_for_level_validator($academic_year_id,$mysqli)
{
    if(isset($academic_year_id) )
    {
        if($academic_year_id != 0) {
            $ay_id = $academic_year_id;
            $ay = $mysqli->query("select * from academic_year where id = '$ay_id'");

            if ($ay->num_rows != 0) {
                $ay_data = $ay->fetch_assoc();

                if (!isset($ay_data)) {


                    return ['Something went wrong while fetching academic year',[]];
                }else
                    {
                        $ay->free();

                        return ['Y',$ay_data];

                    }

            } else {

                return ['This academic year ID is not belongs to valid academic year',[]];
            }
        }else
            {
                return ['Please select one academic year',[]];

            }
    }
    else
    {
        return ["Not a valid academic year",[]];

    }

}


function academic_level_type_validator($academic_year_id,$type,$id,$mysqli)
{
    if(isset($academic_year_id) )
    {
        if($academic_year_id != 0) {
            $ay_id = $academic_year_id;
            $ay = $mysqli->query("select * from academic_year where id = '$ay_id'");

            if ($ay->num_rows != 0) {
                $ay_data = $ay->fetch_assoc();

                if (!isset($ay_data)) {


                    return "Something went wrong while fetching academic year";
                }else
                {

                    if($id == 0)
                    {
                        $level_result = $mysqli->query("select id from level where academic_year_id='$academic_year_id' and type='$type'");

                        if($level_result->num_rows == 0)
                        {

                            return "Y";

                        }else
                            {
                                return "Level ".$type." is already created for this academic year";

                            }


                    }else
                        {
                            $level_result = $mysqli->query("select id from level where academic_year_id='$academic_year_id' and type='$type' and id <> '$id'");

                            if($level_result->num_rows == 0)
                            {

                                return "Y";

                            }else
                            {
                                return "Level ".$type." is already created for this academic year";

                            }



                        }


                }

            } else {

                return "This academic year ID is not belongs to valid academic year";
            }
        }else
        {
            return "Please select an academic year";

        }
    }
    else
    {
        return "Academic year is needed!";

    }

}