<?php
require "db.php";
session_start();

if(!empty($_POST)){

   if( $results=$mysqli->query("insert into course_registration (registration_number,is_approved,date_of_create,date_of_update,course_id) values ('{$_POST['reg_num']}',0,NOW(),NOW(),'{$_POST['course_id']}')")){
       if($results->affected_rows!=0){
           $_SESSION['message'] = "Something went wrong!";
           header("location: error.php");

       }else{
           $_SESSION['message'] = "Success!";
           header("location: success.php");

       }
   }else{
       $_SESSION['message'] = "Something went wrong!";
       header("location: error.php");
   }

}

