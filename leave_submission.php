<?php
/* Reset your password form, sends reset.php password link */
require 'db.php';
session_start();

// Check if form submitted with method="post"
if ( $_SERVER['REQUEST_METHOD'] == 'POST' )
{   // set variables to be inserted to database

    $reason = $mysqli->escape_string($_POST['reason']);
    $description = $mysqli->escape_string($_POST['description']);
    $start_date = $mysqli->escape_string($_POST['start_date']);
    $end_date = $mysqli->escape_string($_POST['end_date']);
    $date_of_create= $mysqli->escape_string( date("Y-m-d H:i:s"));
    $date_of_update= $mysqli->escape_string( date("Y-m-d H:i:s"));

    $datetime1 = new DateTime($start_date);
    $datetime2 = new DateTime($end_date);

    $number_of_dates = $datetime2->diff($datetime1)->d;





    $email = $_SESSION['email'];
    $result = $mysqli->query("SELECT id FROM users WHERE email='$email'");

    if ( $result->num_rows == 0 ) // User doesn't exist
    {
        $_SESSION['message'] = "This user detail doesn't exist in the system.";
        header("location: error.php");
        die();
    }
    else { // User exists (num_rows != 0)

        $user = $result->fetch_assoc(); // $user becomes array with user data

        $user_id = $user['id'];
        $result_new = $mysqli->query("SELECT employee_id FROM employee_data WHERE user_id='$user_id' " );

        if($result_new->num_rows==0){
            $_SESSION['message']="This employ detail doesn't exist in the system.";
        header("location:error.php");
        die();
    }
        else{
            $employee = $result_new->fetch_assoc(); // employ become arry with employ data
            $employee_id = $employee['employee_id'];

            $sql = "INSERT INTO leave_submission (employee_id, reason, description, number_of_dates, start_date, end_date, date_of_create,date_of_update) "
                . "VALUES ('$employee_id','$reason','$description','$number_of_dates', '$start_date', '$end_date','$date_of_create','$date_of_update',)";

            if ( $mysqli->query($sql) ) {

                $_SESSION['message']="Your leave application is uploaded successfully";
                header("location:success.php");
                die();

            }
            else{
                $_SESSION['message']="Sorry. Your application could not be uploaded";
                header("location:error.php");
                die();
            }

            }

    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Apply for Leave</title>
    <?php include 'css/css.html'; ?>
</head>

<body>

<div class="form">

    <h1>Apply for leave</h1>

    <form action="leave_submission.php" method="post">
        <div class="field-wrap">
            <label>
                Reason for Leave<span class="req">*</span>
            </label>
            <input type="text" name="reason"/>
            <label>
                Description<span class="req">*</span>
            </label>
            <textarea name='description'value= 'Please describe the reason briefly.'rows="4" cols="50"></textarea>
            <label>
                Start Date<span class="req">*</span>
            </label>
            <input type="date" name="start_date" max='2018-12-31' min= <?php echo date('Y-m-d');  ?> />
            <label>
                End Date<span class="req">*</span>
            </label>
            <input type="date" name="end_date" max='2018-12-31' min=  <?php echo date('Y-m-d');  ?> />
        </div>
        <button class="button button-block"/>Apply </button>
    </form>
</div>

<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src="js/index.js"></script>
</body>

</html>
