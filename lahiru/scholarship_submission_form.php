
<?php
/* Displays user information and some useful messages */
require '../db.php';
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
    $two_step= $_SESSION['two_step'];



    if($types == 1) {
        $_SESSION['message'] = "Only Students can apply for scholarsips !";
        header("location: ../error.php");
        die();

    }

    $result = $mysqli->query("SELECT id,title FROM scholarships WHERE active=1") or die($mysqli->error());

    if ( $result->num_rows == 0 ) // Scholarships are not available
    {
        $_SESSION['message'] = "Sorry. Currently there is no scholarships available to you !!!";
        header("location: ../error.php");
        die();
    }
    else {

//    echo "<select name='username'>";
//    while ($row = mysql_fetch_array($result)) {
//        echo "<option value='" . $row['username'] ."'>" . $row['username'] ."</option>";
//    }
//    echo "</select>";
        $rows = array();
        while ($row = $result->fetch_object()) {
            $rows[]= $row;
        }



    } } ?>





<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Vocational training center">
    <meta name="author" content="G27">
    <title>Submit Scholarship Application : <?= $first_name.' '.$last_name ?></title>
    <?php include 'css/css.html'; ?>
</head>

<body id="page-top">




<!--content-->
<div class="form">
    <h1>Submit Scholarship Application</h1>
    <form action="scholarship_submission.php" method="post" enctype="multipart/form-data">
        <div class="field-wrap">
            First Name              :<br>
            <input type="text" name="first_name">
            <br>
            Registration Number     :<br>
            <input type="text" name = "registration_number">
            Select the scholarship   :<br>

            <select name="list">
                <option selected="selected" value="0">Choose one</option>
                <?php

                foreach($rows as $r){
                    ?>
                    <?php echo $r->id.'<br>';
                    echo $r->title;?>
                    <option name='<?php echo $r->id; ?>' value="<?php echo $r->id; ?>"><?php echo $r->title; ?></option>

                <?php } ?>
            </select>


            <br>
            Select pdf version of your application file to upload:
            <input type="file" name="scholarship_application" id="scholarship_application">
            <br>
            <input class='button button-block' type="submit" value="Submit">
        </div>

    </form>

</div>

</body>

</html>

