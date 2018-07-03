<?php
/* Reset your password form, sends reset.php password link */
require '../db.php';
session_start();


$email = $_SESSION['email'];
$result = $mysqli->query("SELECT id FROM users WHERE email='$email'");

if ( $result->num_rows == 0 ) // User doesn't exist
{
    $_SESSION['message'] = "This user detail doesn't exist in the system.";
    header("location: ../error.php");
    die();
}
else { // User exists (num_rows != 0)

$user = $result->fetch_assoc(); // $user becomes array with user data

$user_id = $user['id'];
$result_new = $mysqli->query("SELECT employee_id FROM employee_data WHERE user_id='$user_id' " );

if($result_new->num_rows==0) {
    $_SESSION['message'] = "This employ detail doesn't exist in employ_data table.";
    header("location:../error.php");
    die();}

else{
    $employee = $result_new->fetch_assoc(); // employ become arry with employ data
    $employee_id = $employee['employee_id'];

    $date_result = $mysqli->query("SELECT available_leave FROM employee_data WHERE employee_id=$employee_id");

    if($date_result->num_rows==0){
        $_SESSION['message'] = "This employ detail doesn't exist in employ_data table*.";
        header("location:../error.php");
        die();}

        else{
        $date_result1 = $date_result->fetch_assoc();
        $days = $date_result1['available_leave'];

        }


}


}


// Check if form submitted with method="post"
?>
<!DOCTYPE html>
<html>
<head>
    <title>Total Available Leave</title>
    <?php include 'css/css.html'; ?>
</head>

<body>

<div class="form">

    <h1>Available Leave</h1>




            <p>
                You have total <?php echo $days  ?> leave  days available for this year.<span class="req"></span>
            </p>

    <a href="../index.php"><button class="button button-block"/>Home</button></a>

</div>

</body>

</html>
