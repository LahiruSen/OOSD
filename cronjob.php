<?php

// this is cronjob to lock the student information
require 'db.php';

$students_result = $mysqli->query("select student_data.id from student_data where DATEDIFF(NOW(),student_data.date_of_create) >= 7  and student_data.is_locked != 1");



if($students_result->num_rows >0)
{

    $student_data = array();
    while ($row = $students_result->fetch_assoc())
    {

        $student_data[] = $row;

    }



    foreach ($student_data as $sd)
    {
        $id= $sd['id'];

        $mysqli->query("UPDATE student_data  SET is_locked=1 WHERE id='$id'");


    }

}








