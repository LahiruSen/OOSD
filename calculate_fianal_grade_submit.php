<?php
/**
 * Created by PhpStorm.
 * User: BlackLion
 * Date: 7/9/2018
 * Time: 8:41 AM
 */




require 'db.php';
if (session_status() == PHP_SESSION_NONE) {    session_start();}

    if(isset($_GET['id']))
    {


        $id = $_GET['id'];




        $result_al=$mysqli->query("SELECT * FROM level WHERE id='$id'");

        if($result_al->num_rows >0)
        {

            $result_al = $result_al->fetch_assoc();

            $al_ay = $result_al['academic_year_id'];




            $students_result = $mysqli->query("SELECT registration_number FROM student_data WHERE registered_ayear_id='$al_ay'");



            if($students_result->num_rows >0)
            {



               while($row_student = $students_result->fetch_assoc())
               {

                    $st_id = $row_student['registration_number'];

                    $all_course_result = $mysqli->query("SELECT DISTINCT courses.credits,course_registration.id as crid FROM courses,course_registration WHERE courses.level_id='$id' and course_registration.registration_number='$st_id' and course_registration.is_approved = '1'");




                    if($all_course_result->num_rows >0)
                    {

                        $total_mark=0;
                        while ($row_reg = $all_course_result->fetch_assoc())
                        {


                            $cid = $row_reg['crid'];
                            $course_mark = $mysqli->query("SELECT * FROM course_mark where course_registration_id='$cid'");

                            if($course_mark->num_rows>0)
                            {
                                $course_data = $course_mark->fetch_assoc();
                                if($course_data['status'] == 1)
                                {
                                    $total_mark=(int)$course_data['marks']+$total_mark;


                                }


                            }else
                                {


                                    $_SESSION['message'] = 'Some course marks are not submitted yet. contact teacher!';
                                    header("location: error.php");
                                }






                        }

                        $final_mark=$total_mark/count($all_course_result);




                    }
                    else

                        {

                            $_SESSION['message'] = 'No result available!';
                            header("location: error.php");


                        }


               }



            }else
                {


                    $_SESSION['message'] = 'No student found in this academic year!!';
                    header("location: error.php");
                }



        }else
            {

                $_SESSION['message'] = 'No academic year are associated with the academic year';
                header("location: error.php");

            }




    }
    else
        {
            $_SESSION['message'] = 'Parameter error';
            header("location: error.php");

        }