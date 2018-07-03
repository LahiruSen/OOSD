<?php
require '../db.php';
/* Displays user information and some useful messages */
session_start();

// Check if user is logged in using the session variable
if ( $_SESSION['logged_in'] != 1 ) {
    $_SESSION['message'] = "You must log in before viewing your profile page!";
    header("location: ../error.php");
}
else {
    // Makes it easier to read
    $first_name = $_SESSION['first_name'];
    $last_name = $_SESSION['last_name'];
    $email = $_SESSION['email'];
    $active = $_SESSION['active'];
    $types = $_SESSION['types'];
    $two_step = $_SESSION['two_step'];

    $leave_result = $mysqli->query("SELECT * FROM leave_submission ");

    if ($leave_result->num_rows) {
        while ($row = $leave_result->fetch_object()) {
            $records[] = $row;
        }
        $leave_result->free();

}
if($types == 0)
{
    $_SESSION['message'] = "You(Student) don't have access to this page!";
    header("location: ../error.php");
    die();


}


// accept = 1; reject = 2
if(isset($_POST))
{
   if(isset($_POST['accept']))
   {
       if(isset($_POST['leave_id']))
       {
           $leave_id = $_POST['leave_id'];
           $leave_result = $mysqli->query("select id,approved_by_principal from leave_submission where id = '$leave_id'"); //or die($mysqli->error());

           if($leave_result->num_rows>0)
           {
                $sql = "UPDATE leave_submission SET approved_by_principal = '1' WHERE id = '$leave_id'";

                if($mysqli->query($sql)) {
                    header("location:approve_leave_application.php");
                }
                else{
                    $_SESSION['message']="Sorry. Action was unsuccessful.";
                    header("location: ../error.php");
                    die();
                }


           }else
               {
                   $_SESSION['message'] = "Not a valid leave Id ";
                   header("location: ../error.php");
                   die();
               }




       }else
       {
           $_SESSION['message'] = "No Leave Id detect";
           header("location: ../error.php");
           die();
       }

   }
   elseif(isset($_POST['reject']))
   {
       if(isset($_POST['leave_id']))
       {
           $leave_id = $_POST['leave_id'];
           $leave_result = $mysqli->query("select id,approved_by_principal from leave_submission where id = $leave_id") or die($mysqli->error());

           if($leave_result->num_rows>0)
           {
               $sql = "UPDATE leave_submission SET approved_by_principal = '2' WHERE id = $leave_id";

               if($mysqli->query($sql)) {
                   header("location:approve_leave_application.php");
               }
               else{
                   $_SESSION['message']="Sorry. Action was unsuccessful.";
                   header("location: ../error.php");
                   die();
               }


           }else
           {
               $_SESSION['message'] = "Not a valid leave Id ";
               header("location: ../error.php");
               die();
           }
       }else
       {
           $_SESSION['message'] = "No Leave Id detect";
           header("location: ../error.php");
           die();
       }
   }elseif (isset($_POST['delete']))
   {
       if(isset($_POST['leave_id']))
       {
           $leave_id = $_POST['leave_id'];
           $leave_result = $mysqli->query("select id,approved_by_principal from leave_submission where id = $leave_id") or die($mysqli->error());

           if($leave_result->num_rows>0)
           {
               $sql = "DELETE FROM leave_submission WHERE id= $leave_id";
               if($mysqli->query($sql)){
                   header("location:approve_leave_application.php");
               }
               else{
                   $_SESSION['message']="Sorry. Action was unsuccessful.";
                   header("location: ../error.php");
                   die();
               }




           }

           else
           {
               $_SESSION['message'] = "Not a valid leave Id ";
               header("location: ../error.php");
               die();
           }
       }else
       {
           $_SESSION['message'] = "No Leave Id detect";
           header("location: ../error.php");
           die();
       }

   }else
       {

           header("location: approve_leave_application_form.php");
           die();
       }

}
else
    {
    $_SESSION['message'] = "Invalid request";
    header("location: ../error.php");
    die();

}


}