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
    $user_id = $_SESSION['user_id']; $current_employee_type_result = $mysqli->query("select DISTINCT employee_types.title,employee_types.id from employee_types, users, employee_data where employee_data.user_id = '$user_id' and employee_types.id = employee_data.employee_type_id") or die($mysqli->error());
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

$old['course_id'] = $_POST['course_id'];
$old['title'] = $_POST['title'];
$old['description'] = $_POST['description'];
$old['credits'] = $_POST['credits'];
$old['level_id'] = $_POST['level_id'];
$old['assigned_teacher_id'] = $_POST['assigned_teacher_id'];
$old['no_of_working_hours'] = $_POST['no_of_working_hours'];



//validate post inputs
$validation_result = array();

$validation_result[] = array('course_id',course_id_validator($_POST['course_id']));
$validation_result[] = array('title',title_validator($_POST['title']));
$validation_result[] = array('description',description_validator($_POST['description']));
$validation_result[] = array('credits',credits_validator($_POST['credits']));
$validation_result[] = array('credits',level_validator($_POST['level_id']));
$validation_result[] = array('credits',teacher_validator($_POST['assigned_teacher_id']));
$validation_result[] = array('no_of_working_hours',working_hours_validator($_POST['no_of_working_hours']));





//Might be needed

//if(address_validator($_POST['from_date']) =="Y" && address_validator($_POST['to_date'])  == "Y" && isset($_POST['course_id']))
//{
//    $validation_result[] = array('from_to',date_withing_validator($_POST['from_date'],$_POST['to_date'],$mysqli,$_POST['course_id']));
//}
//else
//    {
//        $validation_result[] = array('from_to',date_withing_validator($_POST['from_date'],$_POST['to_date'],$mysqli));
//    }




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
        $course_id = $_POST['course_id'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $credits = $_POST['credits'];
        $level_id = $_POST['level_id'];
        $assigned_teacher_id = $_POST['assigned_teacher_id'];
        $no_of_working_hours = $_POST['no_of_working_hours'];


        //insert query

        if ($results3 = $mysqli->query("select * from courses where course_id='{$_POST['course_id']}'")){
            if ($results3->num_rows) {

                //If the course is registered before


                $_SESSION['message'] = "You have already registered for this course";
                header("location: error.php");
            } else {

                //If the course is not registered before


                if ($results4 = $mysqli->query("INSERT INTO courses  (course_id,title, description, credits, level_id, assigned_teacher_id,"
                    ." no_of_working_hours,date_of_create,date_of_update) "
                    . "VALUES ('$course_id','$title','$description','$credits', '$level_id','$assigned_teacher_id','$no_of_working_hours',"
                    ."NOW(),NOW())")) {
                    if ($results4->affected_rows != 0) {
                        $_SESSION['message'] = "Err1 Something went wrong!";
                        header("location: error.php");

                    } else {
                        $_SESSION['message'] = "Success!";
                        header("location: success.php");

                    }
                } else {
                    $_SESSION['message'] = "Err2 Something went wrong!";
                    header("location: error.php");
                }
            }
        }else {
            $_SESSION['message'] = "Err3 Something went wrong!";
            header("location: error.php");
        }








    }
    else
    {
        $course_id = $_POST['course_id'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $credits = $_POST['credits'];
        $level_id = $_POST['level_id'];
        $assigned_teacher_id = $_POST['assigned_teacher_id'];
        $no_of_working_hours = $_POST['no_of_working_hours'];


        $course_id = $_POST['course_id'];

        $sql_year = "SELECT * FROM courses WHERE course_id='$course_id'";
        $year_result = $mysqli->query($sql_year);

        if($year_result->num_rows !=0)
        {
            $sql = "UPDATE courses  SET course_id='$course_id', title='$title', description='$description', credits='$credits', level_id='$level_id', assigned_teacher_id='$assigned_teacher_id',"
                ." num_of_working_hours='$no_of_working_hours', date_of_update=NOW() WHERE course_id='$course_id'";

            if($mysqli->query($sql))
            {
                header("location:A_create_courses.php");
            }
            else
             {
                 $_SESSION['message'] = "Something went wrong!";
                 header("location:error.php");
             }

            $year_result->free();


        }else
        {
            $_SESSION['message'] = "This course is not available ";
            header("location:error.php");
        }



    }


}















