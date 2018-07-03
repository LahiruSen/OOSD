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



$i=0;
    $uploadok = false;
foreach ($records  as $r) {
    $id = $r->id;
    // not checked = Rejected;
    if (empty($_POST["$id"])) {
        $sql = "UPDATE leave_submission SET approved_by_principal = 2  WHERE id= $id";
        if ($mysqli->query($sql)) {
            $uploadok = true;
        } else {
            $_SESSION['message'] = "Sorry. Error occured during submitting aprovals.";
            header("location: ../error.php");
            die();
        }

    }
    // checked = accepted
    else {
        $sql = "UPDATE leave_submission SET approved_by_principal = 1 WHERE id= $id";
        if ($mysqli->query($sql)) {
            $uploadok = true;
        } else {

            $_SESSION['message'] = "Sorry. Error occured during submitting aprovals.";
            header("location: ../error.php");
            die();
        }

    }
}

    if ($uploadok ) {

        $_SESSION['message']="Your approvals was submitted successfully";
        header("location: ../success.php");
        die();

    }
    else{
        echo "wrong";
    }





}