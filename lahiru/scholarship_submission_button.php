<?php
require 'db.php';
/* Displays user information and some useful messages */
session_start();

// Check if user is logged in using the session variable
if ( $_SESSION['logged_in'] != 1 ) {
    $_SESSION['message'] = "You must log in before viewing your profile page!";
    header("location: error.php");
}
else {
    // Makes it easier to read
    $first_name = $_SESSION['first_name'];
    $last_name = $_SESSION['last_name'];
    $email = $_SESSION['email'];
    $active = $_SESSION['active'];
    $types = $_SESSION['types'];
    $two_step = $_SESSION['two_step'];

}
if($types == 1)
    {
        $_SESSION['message'] = "You're not allowed to apply scholarships";
        header("location: error.php");


}

//content

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
// define variables and set to empty values

$nameErr = $regErr ='';
$first_name1 = $registration_number1 ='';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["first_name"])) {
        $nameErr = "Name is required";
    } else {
        $first_name1 = test_input($_POST["first_name"]);
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z ]*$/", $first_name1)) {
            $nameErr = "Only letters and white space allowed for name";
        }
    }

    if (empty($_POST["registration_number"])) {
        $regErr = "Registration Number is required";
    } else {
        $registration_number1 = test_input($_POST["registration_number"]);

    }

    if('$regErr'!='' or '$nameErr'!=''){
        $_SESSION['message'] = $nameErr.'<br>'.$regErr;
        header("location: error.php");
        die();
    }

    $result = $mysqli->query("SELECT id FROM users WHERE email='$email'");
    $user = $result->fetch_assoc();
    echo $user['id'];
    die();

    if ( $result->num_rows == 0 ) // User doesn't exist
    {
        $_SESSION['message'] = "User doesn't exist!";
        header("location: error.php");
        die();
    }
       else { // User exists (num_rows != 0)

        $user = $result->fetch_assoc(); // $user becomes array with user data

        $id = $user['id'];
           $_SESSION['message'] = '';
           header("location: error.php");
           die();




    // write here code to identyfy this registration number has season email


}


?>



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


    <?php if(!$active) { ?>

        <div class="form text-center">

            <h4 class="alert-heading">Please verify your account!</h4>
            <p>We have sent you a verification email to your email account. Please click verification link to verify your account!!!</p>
            <a href="logout.php"><button class="btn btn-group btn-lg">Logout</button></a>

        </div>

    <?php } else { ?>




                        <?php if($_SESSION['two_step'] == 0) { ?>
                            <a href="twostep.php"><button class="btn btn-success btn-lg">Complete your profile</button> </a>
                        <?php } else { ?>




                        <?php } ?>

        <!--content-->



    <?php


    $target_dir = "scholarship_application_uploads/";
    $target_file = $target_dir . basename($_FILES["scholarship_application"]["name"]);
    $uploadOk = 1;
    $FileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    // Check if pdf file is a actual or not
    //if(isset($_POST["submit"])) {
    //    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    //    if($check !== false) {
    //        echo "File is an image - " . $check["mime"] . ".";
    //        $uploadOk = 1;
    //    } else {
    //        echo "File is not an image.";
    //        $uploadOk = 0;
    //    }
    //}
    // Check if file already exists
    if (file_exists($target_file)) {
        $_SESSION['message'] = "The file already exists!";
        $uploadOk = 0;
        header("location: error.php");

    }
    // Check file size
    if ($_FILES["scholarship_application"]["size"] > 10000000) {
        $_SESSION['message'] = "Maximum size exceeds. Maximum size is 10 MB";
        $uploadOk = 0;
        header("location: error.php");

    }
    // Allow certain file formats
    if($FileType != "pdf") {

        $_SESSION['message'] = "Sorry, only pdf files are allowed.";
        $uploadOk = 0;
        header("location: error.php");
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        $_SESSION['message'] = "Sorry your file was not uploaded";
        header("location: error.php");
// if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["scholarship_application"]["tmp_name"], $target_file)) {
            echo  "<div class='form'><p><strong><h6>You have successfully uploaded the Application.<br>
            We will inform you when it's approved or rejected.</h6></strong></p>
             <a href=\"index.php\"><button class=\"button button-block\"/>Home</button></a>
             </div>
            ";
        } else {
            $_SESSION['message'] = "Sorry. Error occoured during upload";
            header("location: error.php");
        }
    }
    ?>




    <?php } ?>

    </body>

    </html>
<?php } ?>

else{
$_SESSION['message'] = 'Error while uploading the file';
header('location:error.php');
die();

}




