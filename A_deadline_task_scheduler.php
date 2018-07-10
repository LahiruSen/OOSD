<?php
require "db.php";
session_start();


$records=array();

    if($results=$mysqli->query("select course_id from course_registration where is_approved=0 ")){
        if($results->num_rows){
            while($row=$results->fetch_object()){


                if($results2=$mysqli->query("select level_id from courses where course_id='{$row->course_id}'")){
                    if($results2->num_rows){


                        if($results3=$mysqli->query("select deadline from level where id='{$results2->fetch_object()->level_id}'")){
                            if($results3->num_rows){

                                $current_date = date('Y-m-d H:i:s');
                                $deadline=$results3->fetch_object()->deadline;

                                $interval = strtotime($deadline)-strtotime($current_date);

                                if($interval<=0){

                                    if($results4=$mysqli->query("update course_registration set is_approved=1 where course_id='{$row->course_id}'")){
                                        if($results4->affected_rows){

                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            $results->free();
        }
    }





