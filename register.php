<?php
/* Registration process, inserts user info into the database 
   and sends account confirmation email message
 */


// Set session variables to be used on home_employee.php page
$_SESSION['email'] = $_POST['email'];
$_SESSION['first_name'] = $_POST['firstname'];
$_SESSION['last_name'] = $_POST['lastname'];
$_SESSION['types'] = $_POST['types'];
$_SESSION['two_step'] = 0;

// Escape all $_POST variables to protect against SQL injections
$first_name = $mysqli->escape_string($_POST['firstname']);
$types = $mysqli->escape_string($_POST['types']);
$last_name = $mysqli->escape_string($_POST['lastname']);
$email = $mysqli->escape_string($_POST['email']);
$password = $mysqli->escape_string(password_hash($_POST['password'], PASSWORD_BCRYPT));
$hash = $mysqli->escape_string( md5( rand(0,1000) ) );
$date_of_create= $mysqli->escape_string( date("Y-m-d H:i:s"));
$date_of_update= $mysqli->escape_string( date("Y-m-d H:i:s"));

// Check if user with that email already exists
$result = $mysqli->query("SELECT * FROM users WHERE email='$email'") or die($mysqli->error());

// We know user email exists if the rows returned are more than 0
if ( $result->num_rows > 0 ) {

    $_SESSION['message'] = 'User with this email already exists!';
    header("location: error.php");

}
else { // Email doesn't already exist in a database, proceed...

    // active is 0 by DEFAULT (no need to include it here)
    $sql = "INSERT INTO users (first_name, last_name, email, password, hash, types,date_of_create,date_of_update) "
        . "VALUES ('$first_name','$last_name','$email','$password', '$hash', '$types','$date_of_create','$date_of_update')";

    // Add user to the database
    if ( $mysqli->query($sql) ){

        $_SESSION['active'] = 0; //0 until user activates their account with verify.php
        $_SESSION['logged_in'] = true; // So we know the user has logged in
        $_SESSION['message'] =

            "Confirmation link has been sent to $email, please verify
                 your account by clicking on the link in the message!";

        // Send registration confirmation link (verify.php)
        $to      = $email;
        $subject = 'Account Verification';
        $message_body = '
        Hello '.$first_name.',

        Thank you for signing up!

        Please click this link to activate your account:'

        .$HOST. 'verify.php?email='.$email.'&hash='.$hash;

        $headers =  'MIME-Version: 1.0' . "\r\n";
        $headers .= 'From: Kumudu Weerasinghe <geekquero@gmail.com>' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        mail( $to, $subject, $message_body , $headers );

        if($types == 2)
        {
            header("location: home_student.php");
        }
        else
        {
            header("location: home_employee.php");
        }
    }

    else {
        $_SESSION['message'] = 'Registration failed!';
        header("location: error.php");
    }

}