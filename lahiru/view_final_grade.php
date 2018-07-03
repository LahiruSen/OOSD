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
    $result_new = $mysqli->query("SELECT registration_number FROM student_data WHERE user_id='$user_id' " );

    if($result_new->num_rows==0) {
        $_SESSION['message'] = "This student's detail doesn't exist in student data table.";
        header("location:../error.php");
        die();}

    else{
        $student = $result_new->fetch_assoc(); // employ become arry with employ data
        $registration_number = $student['registration_number'];

        $grade_result = $mysqli->query("SELECT * FROM student_final_grade WHERE registration_number=$registration_number");

        if($grade_result->num_rows==0){
            $_SESSION['message'] = "Your grades are not available. Please contact Administration.".$registration_number;
            header("location:../error.php");
            die();}

        else{
            while ($row = $grade_result->fetch_object()) {
                $records[] = $row;
            }
            $grade_result->free();
            $i = 0;

        }


    }


}


// Check if form submitted with method="post"
?>
<!DOCTYPE html>
<html>
<head>
    <title>My Grades</title>
    <?php include 'css/css.html'; ?>
</head>

<body>

<div class="form">

    <h1>My Grades</h1>

    <table>
        <tr>
            <th>Level</th>
            <th>Status</th>
            <th>Mark(%)</th>
        </tr>
        <tbody>
        <?php

        foreach($records as $r){
            $i++;
            ?>
            <tr>
                <td><?php echo $r->level_id; ?></td>
                <td><?php echo $r->status; ?></td>
                <td><?php echo $r->mark; ?></td>
            </tr>
        <?php } ?>

        </tbody>
    </table>


    <a href="../index.php"><button class="button button-block"/>Home</button></a>

</div>

</body>

</html>
