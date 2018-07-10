<?php
/**
 * Created by PhpStorm.
 * User: BlackLion
 * Date: 3/30/2018
 * Time: 6:09 AM
 */

require 'db.php';

if (session_status() == PHP_SESSION_NONE) {    session_start();}




    if ( $_SESSION['logged_in'] != 1 ) {

        $_SESSION['message'] = "You must log in before viewing your profile page!";
        header("location: error.php");

    }

    elseif($_SESSION['active'] != 1)
    {
        $_SESSION['message'] = "We have sent you a verification email to your email account. Please click verification link to verify your account!!!";
        header("location: error.php");

    } else
    {


    // Makes it easier to read
    $first_name = $_SESSION['first_name'];
    $last_name = $_SESSION['last_name'];
    $email = $_SESSION['email'];
    $active = $_SESSION['active'];
    $types = $_SESSION['types'];
    $two_step= $_SESSION['two_step'];

    //user data
    $result = $mysqli->query("SELECT * FROM users WHERE email='$email'") or die($mysqli->error());



    if($result->num_rows ==0)
    {
        $_SESSION['message'] = "This user is not a valid user!!!";
        header("location: error.php");
    } else
        {
            $user = $result->fetch_assoc();
            $result->free();
            $userId = $user['id'];
            $_SESSION['user_id'] = $userId;



            //get students or employee data if available
            if( $types == 2)
            {
                $student_result = $mysqli->query("SELECT * FROM student_data WHERE user_id='$userId'") or die($mysqli->error());
                $ayear_result = $mysqli->query("SELECT * FROM academic_year WHERE status=1") or die($mysqli->error());



                if($ayear_result->num_rows != 0)
                {

                    $ayear_data = $ayear_result->fetch_assoc();

                    $ayear_result->free();
                }


                if($student_result->num_rows != 0)
                {

                    $student_data = $student_result->fetch_assoc();
                    $student_result->free();
                }
            }
            else
            {
                $employee_result = $mysqli->query("SELECT * FROM employee_data WHERE user_id='$userId'") or die($mysqli->error());
                $employee_types_result = $mysqli->query("SELECT * FROM employee_types") or die($mysqli->error());

                if($employee_types_result->num_rows ==0)
                {
                    $_SESSION['message'] = "No Employee types found ";
                    header("location: error.php");

                }else
                {
                    $employee_types_data = array();



                    while ($row = $employee_types_result->fetch_assoc())
                    {
                        $employee_types_data[] = $row;
                    }


                    $employee_types_result->free();




                }


                if($employee_result->num_rows != 0)
                {

                    $employee_data = $employee_result->fetch_assoc();
                    $employee_result->free();


                }

            }

        }




}
?>


<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{

    if (isset($_POST['student'])) {

        require 'twostep_submit_student.php';

    }

    elseif (isset($_POST['employee'])) {

        require 'twostep_submit_employee.php';

    }
}

?>



<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Vocational training center">
    <meta name="author" content="G27">
    <title>Profile : <?= $first_name.' '.$last_name ?></title>
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


    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg bg-secondary fixed-top text-uppercase" id="mainNav">
        <div class="container">
            <a class="navbar-brand js-scroll-trigger" href="#page-top">Emplup<i class="fa fa-user"></i></a>
            <button class="navbar-toggler navbar-toggler-right text-uppercase bg-primary text-white rounded" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                Menu
                <i class="fa fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <?php
                $on_two_step=0;
                require 'navigation.php';
                ?>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <header class="masthead bg-primary text-white text-center ">

        <div>
            <h1 class="text-uppercase mb-0">Emplup <i class="fa fa-user"></i></h1>

            <?php if($types == 2) { ?>

            <?php if($two_step != 1){ ?>

                <h4 style="font-size:50px" class="text-dark mb-2"> <?php if(isset($ayear_data)) { echo('You are registering for '.$ayear_data['title']);} ?>. <strong class="text-white"><?= $first_name.' '.$last_name; ?></strong><?php if(isset($student_data)) { if($student_data['is_locked'] != 1){echo (', Please complete your student profile');}}else{echo (', Please complete your student profile');}?></h4>
               <?php if(isset($ayear_data)){ ?>

                    <h5 style="font-size:30px" class="text-white text-uppercase mb-2">Deadline <?=$ayear_data['registration_deadline']?></h5>

                <?php } else { ?>

                        <h5 style="font-size:30px" class="text-white text-uppercase mb-2">No academic years detected</h5>

                    <?php } ?>

            <?php } else {
                ?>
                    <h4 style="font-size:50px" class="text-primary mb-2"><strong class="text-white"><?= $first_name.' '.$last_name ?></strong>, Your profile is verified <i class="fa fa-check-circle "></i></h4>

                <?php
                } } else { ?>

          <?php if($two_step != 1){ ?>


                <?php if(isset($employee_data)){


                    if($employee_data['is_locked'] ==1){ ?>
                            <h4 style="font-size:50px" class="text-warning mb-2"><strong class="text-white"><?= $first_name.' '.$last_name ?></strong>, Your profile activation is pending <i class="fa fa-exclamation-triangle"></i></h4>
                    <?php } else { ?>

                            <h4 style="font-size:50px" class="text-dark mb-2"><strong class="text-white"><?= $first_name.' '.$last_name ?></strong>, complete your employee profile</h4>
                    <?php } } else { ?>
                            <h4 style="font-size:50px" class="text-dark mb-2"><strong class="text-white"><?= $first_name.' '.$last_name ?></strong>, add profile information</h4>
                    <?php } ?>

        <?php } else { ?>
                    <h4 style="font-size:50px" class="text-primary mb-2"><strong class="text-white"><?= $first_name.' '.$last_name ?></strong>, Your profile is verified <i class="fa fa-check-circle "></i></h4>

        <?php }} ?>

        <div class="container">


            <?php if($types == 2) { ?>

                <?php if (isset($student_data)) { if($student_data['is_locked'] !=1 ) {?>
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>

                 You only have <strong><?php $now = date_create(); $doc=date_create($student_data['date_of_create']); date_add($doc,date_interval_create_from_date_string("7 days")); $diff = date_diff($now, $doc); echo($diff->format("%a days %H hours %I minutes")) ?></strong> period to change your profile information. After this period, our system administrator will lock your profile information and sent it to verification.

            </div>
                    <?php }else{ ?>
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>

                        You have completed your profile information submission. If you want to inquire about your information, please contact admin.

                    </div>




               <?php }} else {

                    ?>

                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>

                        <?php if(isset($ayear_data)) {

                            $current_date = date('Y-m-d H:i:s');
                            $deadline = date('Y-m-d H:i:s',strtotime($ayear_data['registration_deadline']));

                            if($current_date<=$deadline)
                            {
                            ?>

                        Before the deadline <?= $ayear_data['registration_deadline'] ?> please save and submit your profile information.

                        <?php }else{

                                ?>

                                Registration deadline is exceeded, our system may not add your information <strong style="color: indianred"><?= $ayear_data['registration_deadline'] ?></strong> contact administrator!


                                <?php
                            }
                        } ?>

                    </div>


                    <?php
                } ?>

            <?php } else { ?>
                <?php if (isset($employee_data)) { if($employee_data['is_locked'] !=1 ) {?>
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>

                        When you save your profile, you can complete your account anytime that you want. When you complete your profile you won't be able to change it from here

                    </div>
                <?php }else{ ?>
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>

                        You have completed your profile information submission. If you want to inquire about your information, please contact admin.

                    </div>




                <?php }} else {

                    ?>

                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>


                            Please save and complete your profile information.


                    </div>


                    <?php
                } ?>

            <?php } ?>


        </div>

        </div>

    </header>

<!-- for Employee -->

<?php if($types == 1) { ?>
    <section style="padding:10px;" id="portfolio">
        <div class="container ">
            <form id="two_step_submission_form" class="two_step_form" action="twostep.php" method="post">

                <div class="container">
                    <div class="text-left">
                        <div id="form_section_header" class="bg-topfive">
                            <h2> Basic Information </h2>
                        </div>
                        <div class="row m-2">
                            <div class="form-group col-lg-6 col-md-6">
                                <label class="text-dark" for="first_name">First Name</label>
                                <input type="text" style="background-color: #e6e9ee" id="first_name" name="first_name" class="input-active"  value="<?= $first_name ?>" readonly>
                            </div>
                            <div class="form-group col-lg-6 col-md-6">
                                <label class="text-dark" for="last_name">Last Name</label>
                                <input type="text" style="background-color: #e6e9ee" id="last_name" name="last_name" class="input-active"  value="<?= $last_name ?>" readonly>
                            </div>
                        </div>
                        <div class="row m-2">
                            <div class="form-group col-lg-12 col-md-12">
                                <label class="text-dark" for="email">Email</label>
                                <input type="text" style="background-color: #e6e9ee" id="email" name="email" class="input-active"  value="<?= $email ?>" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="text-left">
                        <div id="form_section_header" class="bg-topfive">
                            <h2> Personal Information </h2>
                        </div>
                        <div class="row m-2">
                            <div class="form-group col-lg-6 col-md-6">
                                <label class="text-dark" for="title">Title</label>
                                <select id="title" name="title" <?php if(isset($employee_data)){if($employee_data['is_locked'] == 1){echo ('disabled');}}?> >
                                    <option value="Mr" <?php if(isset($old)){if ($old['title'] == 'Mr') {echo "selected";}}else{if(isset($employee_data)) {if ($employee_data['title'] == 'Mr') {echo "selected";}}} ?> >Mr</option>
                                    <option value="Miss" <?php if(isset($old)){if ($old['title'] == 'Miss') {echo "selected";}}else{if(isset($employee_data)) {if ($employee_data['title'] == 'Miss') {echo "selected";}}} ?> >Miss</option>
                                    <option value="Mrs" <?php if(isset($old)){if ($old['title'] == 'Mrs') {echo "selected";}}else{if(isset($employee_data)) {if ($employee_data['title'] == 'Mrs') {echo "selected";}}} ?> >Mrs</option>
                                </select>


                                <?php if(isset($error_array) && array_key_exists('title',$error_array))  {?>
                                    <div class="row">
                                        <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                            <small id="passwordHelp" class="text-danger">
                                                <?= $error_array['title'] ?>
                                            </small>
                                        </div>
                                    </div>
                                <?php } ?>

                            </div>
                            <div class="form-group col-lg-6 col-md-6">
                                <label class="text-dark" for="sex">Sex</label>
                                <select id="sex" name="sex" <?php if(isset($employee_data)){if($employee_data['is_locked'] == 1){echo ('disabled');}}?>>
                                    <option value="Male" <?php if(isset($old)){if ($old['sex'] == 'Male') {echo "selected";}}else{if(isset($employee_data)) {if ($employee_data['sex'] == 'Male') {echo "selected";}}} ?> >Male</option>
                                    <option value="Female" <?php if(isset($old)){if ($old['sex'] == 'Female') {echo "selected";}}else{if(isset($employee_data)) {if ($employee_data['sex'] == 'Female') {echo "selected";}}} ?> >Female</option>
                                </select>


                                <?php if(isset($error_array) && array_key_exists('sex',$error_array))  {?>
                                    <div class="row">
                                        <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                            <small id="passwordHelp" class="text-danger">
                                                <?= $error_array['sex'] ?>
                                            </small>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="row m-2">
                            <div class="form-group col-lg-12 col-md-12">
                                <label class="text-dark" for="full_name">Full Name</label>
                                <input pattern="[A-Za-z ]+" title="Can't have numbers and special characters" class="<?php if(isset($error_array) && array_key_exists('full_name',$error_array))  { echo('text-danger');} ?>" type="text" id="full_name" name="full_name" required <?php if(isset($old)){echo 'value="'.$old['full_name'].'"';}else{if(isset($employee_data)) {echo 'value="'.$employee_data['full_name'].'"';}} ?> <?php if(isset($employee_data)){if($employee_data['is_locked'] == 1){echo ('readonly');}}?> >

                                <?php if(isset($error_array) && array_key_exists('full_name',$error_array))  {?>
                                    <div class="row">
                                        <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                            <small id="passwordHelp" class="text-danger">
                                                <?= $error_array['full_name'] ?>
                                            </small>
                                        </div>
                                    </div>
                                <?php } ?>

                            </div>
                        </div>

                        <div class="row m-2">
                            <div class="form-group col-lg-6 col-md-6">
                                <label class="text-dark" for="dob">Date of Birth</label>
                                <input  class="<?php if(isset($error_array) && array_key_exists('dob',$error_array))  { echo('text-danger');} ?>" type="date" id="dob" name="dob" required <?php if(isset($old)){echo 'value="'.$old['dob'].'"';}else{if(isset($employee_data)) {echo 'value="'.$employee_data['dob'].'"';}} ?> <?php if(isset($employee_data)){if($employee_data['is_locked'] == 1){echo ('readonly');}}?> >

                                <?php if(isset($error_array) && array_key_exists('dob',$error_array))  {?>
                                    <div class="row">
                                        <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                            <small id="passwordHelp" class="text-danger">
                                                <?= $error_array['dob'] ?>
                                            </small>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="form-group col-lg-6 col-md-6">
                                <label class="text-dark" for="sex">Civil Status</label>
                                <select id="civil_status" name="civil_status" <?php if(isset($employee_data)){if($employee_data['is_locked'] == 1){echo ('disabled');}}?> >
                                    <option value="Single" <?php if(isset($old)){if ($old['civil_status'] == 'Single') {echo "selected";}}else{if(isset($employee_data)) {if ($employee_data['civil_status'] == 'Single') {echo "selected";}}} ?> >Single</option>
                                    <option value="Married" <?php if(isset($old)){if ($old['civil_status'] == 'Married') {echo "selected";}}else{if(isset($employee_data)) {if ($employee_data['civil_status'] == 'Married') {echo "selected";}}} ?> >Married</option>
                                </select>


                                <?php if(isset($error_array) && array_key_exists('civil_status',$error_array))  {?>
                                    <div class="row">
                                        <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                            <small id="passwordHelp" class="text-danger">
                                                <?= $error_array['civil_status'] ?>
                                            </small>
                                        </div>
                                    </div>
                                <?php } ?>

                            </div>
                        </div>

                        <div class="row m-2">
                            <div class="form-group col-lg-12 col-md-12">
                                <label class="text-dark" for="nic">National Identity Card Number</label>
                                <input  class="<?php if(isset($error_array) && array_key_exists('nic',$error_array))  { echo('text-danger');} ?>" type="text" id="nic" name="nic" required <?php if(isset($old)){echo 'value="'.$old['nic'].'"';}else{if(isset($employee_data)) {echo 'value="'.$employee_data['nic'].'"';}} ?> <?php if(isset($employee_data)){if($employee_data['is_locked'] == 1){echo ('readonly');}}?> >
                                <?php if(isset($error_array) && array_key_exists('nic',$error_array))  {?>
                                    <div class="row">
                                        <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                            <small id="passwordHelp" class="text-danger">
                                                <?= $error_array['nic'] ?>
                                            </small>
                                        </div>
                                    </div>
                                <?php } ?>

                            </div>
                        </div>

                    </div>

                    <div class="text-left">
                        <div id="form_section_header" class="bg-topfive">
                            <h2> Contact Information </h2>
                        </div>

                        <div class="row m-2">
                            <div class="form-group col-lg-12 col-md-12">
                                <label class="text-dark" for="add_line_1">Address Line 1</label>
                                <input  pattern="[A-Za-z1-9 ]+" title="Can't have  special characters" class="<?php if(isset($error_array) && array_key_exists('add_line_1',$error_array))  { echo('text-danger');} ?>" type="text" id="add_line_1" name="add_line_1" required <?php if(isset($old)){echo 'value="'.$old['add_line_1'].'"';}else{if(isset($employee_data)) {echo 'value="'.$employee_data['address_line_1'].'"';}} ?> <?php if(isset($employee_data)){if($employee_data['is_locked'] == 1){echo ('readonly');}}?> >
                                <?php if(isset($error_array) && array_key_exists('add_line_1',$error_array))  {?>
                                    <div class="row">
                                        <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                            <small id="passwordHelp" class="text-danger">
                                                <?= $error_array['add_line_1'] ?>
                                            </small>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="row m-2">
                            <div class="form-group col-lg-12 col-md-12">
                                <label class="text-dark" for="add_line_2">Address Line 2</label>
                                <input pattern="[A-Za-z1-9 ]+" title="Can't have special characters" class="<?php if(isset($error_array) && array_key_exists('add_line_2',$error_array))  { echo('text-danger');} ?>" type="text" id="add_line_2" name="add_line_2" required <?php if(isset($old)){echo 'value="'.$old['add_line_2'].'"';}else{if(isset($employee_data)) {echo 'value="'.$employee_data['address_line_2'].'"';}} ?> <?php if(isset($employee_data)){if($employee_data['is_locked'] == 1){echo ('readonly');}}?> >
                                <?php if(isset($error_array) && array_key_exists('add_line_2',$error_array))  {?>
                                    <div class="row">
                                        <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                            <small id="passwordHelp" class="text-danger">
                                                <?= $error_array['add_line_2'] ?>
                                            </small>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="row m-2">
                            <div class="form-group col-lg-6 col-md-6">
                                <label class="text-dark" for="postal_code">Postal Code</label>
                                <input  class="<?php if(isset($error_array) && array_key_exists('postal_code',$error_array))  { echo('text-danger');} ?>" type="number" id="postal_code" name="postal_code" required <?php if(isset($old)){echo 'value="'.$old['postal_code'].'"';}else{if(isset($employee_data)) {echo 'value="'.$employee_data['postal_code'].'"';}} ?> <?php if(isset($employee_data)){if($employee_data['is_locked'] == 1){echo ('readonly');}}?> >
                                <?php if(isset($error_array) && array_key_exists('postal_code',$error_array))  {?>
                                    <div class="row">
                                        <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                            <small id="passwordHelp" class="text-danger">
                                                <?= $error_array['postal_code'] ?>
                                            </small>
                                        </div>
                                    </div>
                                <?php } ?>

                            </div>
                            <div class="form-group col-lg-6 col-md-6">
                                <label class="text-dark" for="city">City</label>
                                <input pattern="[A-Za-z1-9 ]+" title="Can't have numbers and special characters" class="<?php if(isset($error_array) && array_key_exists('city',$error_array))  { echo('text-danger');} ?>" type="text" id="city" name="city" required <?php if(isset($old)){echo 'value="'.$old['city'].'"';}else{if(isset($employee_data)) {echo 'value="'.$employee_data['city'].'"';}} ?> <?php if(isset($employee_data)){if($employee_data['is_locked'] == 1){echo ('readonly');}}?> >
                                <?php if(isset($error_array) && array_key_exists('city',$error_array))  {?>
                                    <div class="row">
                                        <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                            <small id="passwordHelp" class="text-danger">
                                                <?= $error_array['city'] ?>
                                            </small>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="row m-2">
                            <div class="form-group col-lg-8 col-md-8">
                                <label class="text-dark" for="phone_number">Phone Number</label>
                                <input  class="<?php if(isset($error_array) && array_key_exists('phone_number',$error_array))  { echo('text-danger');} ?>" type="number" id="phone_number" name="phone_number" required <?php if(isset($old)){echo 'value="'.$old['phone_number'].'"';}else{if(isset($employee_data)) {echo 'value="'.$employee_data['phone_number'].'"';}} ?> <?php if(isset($employee_data)){if($employee_data['is_locked'] == 1){echo ('readonly');}}?> >
                                <?php if(isset($error_array) && array_key_exists('phone_number',$error_array))  {?>
                                    <div class="row">
                                        <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                            <small id="passwordHelp" class="text-danger">
                                                <?= $error_array['phone_number'] ?>
                                            </small>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>

                    </div>

                    <div class="text-left">
                        <div id="form_section_header" class="bg-topfive">
                            <h2> Employment Information </h2>
                        </div>

                        <div class="row m-2">
                            <div class="form-group col-lg-6 col-md-6">
                                <label class="text-dark" for="employee_id">Employee ID</label>

                                <input class="<?php if(isset($error_array) && array_key_exists('employee_id',$error_array))  { echo('text-danger');} ?>" type="number" id="employee_id" name="employee_id" class="input-active" required <?php if(isset($old)){echo 'value="'.$old['employee_id'].'"';}else{if(isset($employee_data)) {echo 'value="'.$employee_data['employee_id'].'"';}} ?> <?php if(isset($employee_data)){if($employee_data['is_locked'] == 1){echo ('readonly');}}?> >
                                <?php if(isset($error_array) && array_key_exists('employee_id',$error_array))  {?>
                                    <div class="row">
                                        <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                            <small id="passwordHelp" class="text-danger">
                                                <?= $error_array['employee_id'] ?>
                                            </small>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="form-group col-lg-6 col-md-6">
                                <label class="text-dark" for="employee_type_id">I want to be a/an</label>
                                <select id="employee_type_id" name="employee_type_id" <?php if(isset($employee_data)){if($employee_data['is_locked'] == 1){echo ('disabled');}}?> >


                                    <?php for( $j=0;$j<count($employee_types_data);$j++ ) { ?>

                                        <option value="<?= $employee_types_data[$j]['id'] ?>" <?php if(isset($old)){if ($old['employee_type_id'] == $employee_types_data[$j]['id']) {echo "selected";}}else{if(isset($employee_data)) {if ($employee_data['employee_type_id'] == $employee_types_data[$j]['id']) {echo "selected";}}} ?> ><?= $employee_types_data[$j]['title'] ?></option>

                                    <?php } ?>
                                </select>


                                <?php if(isset($error_array) && array_key_exists('employee_type_id',$error_array))  {?>
                                    <div class="row">
                                        <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                            <small id="passwordHelp" class="text-danger">
                                                <?= $error_array['employee_type_id'] ?>
                                            </small>
                                        </div>
                                    </div>
                                <?php } ?>

                            </div>
                        </div>
                    </div>

                    <input name="user_id" id="user_id" type="hidden" value="<?= $userId ?>">
                    <input name="type" id="type" type="hidden" value="<?= $types ?>">

                    <?php if(isset($employee_data)) {?>

                        <?php if($employee_data['is_locked'] != 1) {?>
                                <div class="text-center mt-4">
                                    <button name="employee" type="submit" class="btn btn-xl btn-outline-primary">Save</button>
                                    <button value="lock" name="employee" type="submit" class="btn btn-xl btn-outline-success">Complete</button>
                                </div>

                        <?php }?>
                    <?php }else {?>

                        <div class="text-center mt-4">
                            <button name="employee" type="submit" class="btn btn-xl btn-outline-primary">Save</button>
                        </div>
                        <?php } ?>

                    </div>
                </div>

            </form>
        </div>
    </section>


    <!-- for Student -->
<?php } else { if(isset($ayear_data)){ ?>

    <section style="padding:10px;" id="portfolio">
        <div class="container ">
            <form id="two_step_submission_form" class="two_step_form" action="twostep.php" method="post">

                <div class="container">
                    <div class="text-left">
                        <div id="form_section_header" class="bg-topfive">
                            <h2> Basic Information </h2>
                        </div>
                        <div class="row m-2">
                            <div class="form-group col-lg-6 col-md-6">
                                <label class="text-dark" for="first_name">First Name</label>
                                <input type="text" style="background-color: #e6e9ee" id="first_name" name="first_name" class="input-active"  value="<?= $first_name ?>" readonly>
                            </div>
                            <div class="form-group col-lg-6 col-md-6">
                                <label class="text-dark" for="last_name">Last Name</label>
                                <input type="text" style="background-color: #e6e9ee" id="last_name" name="last_name" class="input-active"  value="<?= $last_name ?>" readonly>
                            </div>
                        </div>
                        <div class="row m-2">
                            <div class="form-group col-lg-12 col-md-12">
                                <label class="text-dark" for="email">Email</label>
                                <input type="text" style="background-color: #e6e9ee" id="email" name="email" class="input-active"  value="<?= $email ?>" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="text-left">
                        <div id="form_section_header" class="bg-topfive">
                            <h2> Personal Information </h2>
                        </div>
                        <div class="row m-2">
                            <div class="form-group col-lg-6 col-md-6">
                                <label class="text-dark" for="title">Title</label>
                                <select id="title" name="title" <?php if(isset($student_data)){if($student_data['is_locked'] == 1){echo ('disabled');}}?> >
                                    <option value="Mr" <?php if(isset($old)){if ($old['title'] == 'Mr') {echo "selected";}}else{if(isset($student_data)) {if ($student_data['title'] == 'Mr') {echo "selected";}}} ?> >Mr</option>
                                    <option value="Miss" <?php if(isset($old)){if ($old['title'] == 'Miss') {echo "selected";}}else{if(isset($student_data)) {if ($student_data['title'] == 'Miss') {echo "selected";}}} ?> >Miss</option>
                                    <option value="Mrs" <?php if(isset($old)){if ($old['title'] == 'Mrs') {echo "selected";}}else{if(isset($student_data)) {if ($student_data['title'] == 'Mrs') {echo "selected";}}} ?> >Mrs</option>
                                </select>

                                <?php if(isset($error_array) && array_key_exists('title',$error_array))  {?>
                                    <div class="row">
                                        <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                            <small id="passwordHelp" class="text-danger">
                                                <?= $error_array['title'] ?>
                                            </small>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="form-group col-lg-6 col-md-6">
                                <label class="text-dark" for="sex">Sex</label>
                                <select id="sex" name="sex" <?php if(isset($student_data)){if($student_data['is_locked'] == 1){echo ('disabled');}}?> >
                                    <option value="Male" <?php if(isset($old)){if ($old['sex'] == 'Male') {echo "selected";}}else{if(isset($student_data)) {if ($student_data['sex'] == 'Male') {echo "selected";}}} ?> >Male</option>
                                    <option value="Female" <?php if(isset($old)){if ($old['sex'] == 'Female') {echo "selected";}}else{if(isset($student_data)) {if ($student_data['sex'] == 'Female') {echo "selected";}}} ?> >Female</option>
                                </select>


                                <?php if(isset($error_array) && array_key_exists('sex',$error_array))  {?>
                                    <div class="row">
                                        <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                            <small id="passwordHelp" class="text-danger">
                                                <?= $error_array['sex'] ?>
                                            </small>
                                        </div>
                                    </div>
                                <?php } ?>

                            </div>
                        </div>

                        <div class="row m-2">
                            <div class="form-group col-lg-12 col-md-12">
                                <label class="text-dark" for="full_name">Full Name</label>
                                <input pattern="[A-Za-z ]+" title="Can't have numbers and special characters" class="<?php if(isset($error_array) && array_key_exists('full_name',$error_array))  { echo('text-danger');} ?>" type="text" id="full_name" name="full_name"  required <?php if(isset($old)){echo 'value="'.$old['full_name'].'"';}else{if(isset($student_data)) {echo 'value="'.$student_data['full_name'].'"';}} ?><?php if(isset($student_data)){if($student_data['is_locked'] == 1){echo ('readonly');}}?>  >
                                <?php if(isset($error_array) && array_key_exists('full_name',$error_array))  {?>
                                    <div class="row">
                                        <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                            <small id="passwordHelp" class="text-danger">
                                                <?= $error_array['full_name'] ?>
                                            </small>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="row m-2">
                            <div class="form-group col-lg-6 col-md-6">
                                <label class="text-dark" for="dob">Date of Birth</label>
                                <input  class="<?php if(isset($error_array) && array_key_exists('dob',$error_array))  { echo('text-danger');} ?>" type="date" id="dob" name="dob" required <?php if(isset($old)){echo 'value="'.$old['dob'].'"';}else{if(isset($student_data)) {echo 'value="'.$student_data['dob'].'"';}} ?> <?php if(isset($student_data)){if($student_data['is_locked'] == 1){echo ('readonly');}}?> >
                                <?php if(isset($error_array) && array_key_exists('dob',$error_array))  {?>
                                    <div class="row">
                                        <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                            <small id="passwordHelp" class="text-danger">
                                                <?= $error_array['dob'] ?>
                                            </small>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="form-group col-lg-6 col-md-6">
                                <label class="text-dark" for="civil_status">Civil Status</label>
                                <select id="civil_status" name="civil_status" <?php if(isset($student_data)){if($student_data['is_locked'] == 1){echo ('disabled');}}?> >
                                    <option value="Single" <?php if(isset($old)){if ($old['civil_status'] == 'Single') {echo "selected";}}else{if(isset($student_data)) {if ($student_data['civil_status'] == 'Single') {echo "selected";}}} ?> >Single</option>
                                    <option value="Married" <?php if(isset($old)){if ($old['civil_status'] == 'Married') {echo "selected";}}else{if(isset($student_data)) {if ($student_data['civil_status'] == 'Married') {echo "selected";}}} ?> >Married</option>
                                </select>

                                <?php if(isset($error_array) && array_key_exists('civil_status',$error_array))  {?>
                                    <div class="row">
                                        <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                            <small id="passwordHelp" class="text-danger">
                                                <?= $error_array['civil_status'] ?>
                                            </small>
                                        </div>
                                    </div>
                                <?php } ?>

                            </div>
                        </div>

                        <div class="row m-2">
                            <div class="form-group col-lg-12 col-md-12">
                                <label class="text-dark" for="nic">National Identity Card Number</label>
                                <input  class="<?php if(isset($error_array) && array_key_exists('nic',$error_array))  { echo('text-danger');} ?>" type="text" id="nic" name="nic" required <?php if(isset($old)){echo 'value="'.$old['nic'].'"';}else{if(isset($student_data)) {echo 'value="'.$student_data['nic'].'"';}} ?> <?php if(isset($student_data)){if($student_data['is_locked'] == 1){echo ('readonly');}}?> >
                                <?php if(isset($error_array) && array_key_exists('nic',$error_array))  {?>
                                    <div class="row">
                                        <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                            <small id="passwordHelp" class="text-danger">
                                                <?= $error_array['nic'] ?>
                                            </small>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="row m-2">
                            <div class="form-group col-lg-4 col-md-4">
                                <label class="text-dark" for="is_physical">Are you physically disabled?</label>
                                <input  type="checkbox" id="is_physical" name="is_physical" <?php if(isset($old)){if ($old['is_physical'] == 'on') {echo "checked";}}else{if(isset($student_data)) {if ($student_data['is_physically_disabled'] == 'on') {echo "checked";}}} ?> <?php if(isset($student_data)){if($student_data['is_locked'] == 1){echo ('readonly');}}?> >
                            </div>
                        </div>

                        <div class="row m-2">
                            <div class="form-group col-lg-12 col-md-12">
                                <label class="text-dark" for="father_full_name">Father's Full Name</label>
                                <input pattern="[A-Za-z ]+" title="Can't have numbers and special characters" class="<?php if(isset($error_array) && array_key_exists('father_full_name',$error_array))  { echo('text-danger');} ?>" type="text" id="father_full_name" name="father_full_name" required <?php if(isset($old)){echo 'value="'.$old['father_full_name'].'"';}else{if(isset($student_data)) {echo 'value="'.$student_data['father_full_name'].'"';}} ?> <?php if(isset($student_data)){if($student_data['is_locked'] == 1){echo ('readonly');}}?> >
                                <?php if(isset($error_array) && array_key_exists('father_full_name',$error_array))  {?>
                                    <div class="row">
                                        <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                            <small id="passwordHelp" class="text-danger">
                                                <?= $error_array['father_full_name'] ?>
                                            </small>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="row m-2">
                            <div class="form-group col-lg-12 col-md-12">
                                <label class="text-dark" for="mother_full_name">Mother's Full Name</label>
                                <input pattern="[A-Za-z ]+" title="Can't have numbers and special characters" class="<?php if(isset($error_array) && array_key_exists('mother_full_name',$error_array))  { echo('text-danger');} ?>" type="text" id="mother_full_name" name="mother_full_name" required <?php if(isset($old)){echo 'value="'.$old['mother_full_name'].'"';}else{if(isset($student_data)) {echo 'value="'.$student_data['mother_full_name'].'"';}} ?> <?php if(isset($student_data)){if($student_data['is_locked'] == 1){echo ('readonly');}}?> >
                                <?php if(isset($error_array) && array_key_exists('mother_full_name',$error_array))  {?>
                                    <div class="row">
                                        <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                            <small id="passwordHelp" class="text-danger">
                                                <?= $error_array['mother_full_name'] ?>
                                            </small>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>

                    </div>

                    <div class="text-left">
                        <div id="form_section_header" class="bg-topfive">
                            <h2> Contact Information </h2>
                        </div>

                        <div class="row m-2">
                            <div class="form-group col-lg-12 col-md-12">
                                <label class="text-dark" for="add_line_1">Address Line 1</label>
                                <input pattern="[A-Za-z1-9 ]+" title="Can't special characters" class="<?php if(isset($error_array) && array_key_exists('add_line_1',$error_array))  { echo('text-danger');} ?>"type="text" id="add_line_1" name="add_line_1" required <?php if(isset($old)){echo 'value="'.$old['add_line_1'].'"';}else{if(isset($student_data)) {echo 'value="'.$student_data['address_line_1'].'"';}} ?> <?php if(isset($student_data)){if($student_data['is_locked'] == 1){echo ('readonly');}}?> >
                                <?php if(isset($error_array) && array_key_exists('add_line_1',$error_array))  {?>
                                    <div class="row">
                                        <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                            <small id="passwordHelp" class="text-danger">
                                                <?= $error_array['add_line_1'] ?>
                                            </small>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="row m-2">
                            <div class="form-group col-lg-12 col-md-12">
                                <label class="text-dark" for="add_line_2">Address Line 2</label>
                                <input pattern="[A-Za-z1-9 ]+" title="Can't special characters" class="<?php if(isset($error_array) && array_key_exists('add_line_2',$error_array))  { echo('text-danger');} ?>" type="text" id="add_line_2" name="add_line_2" required <?php if(isset($old)){echo 'value="'.$old['add_line_2'].'"';}else{if(isset($student_data)) {echo 'value="'.$student_data['address_line_2'].'"';}} ?> <?php if(isset($student_data)){if($student_data['is_locked'] == 1){echo ('readonly');}}?> >
                                <?php if(isset($error_array) && array_key_exists('add_line_2',$error_array))  {?>
                                    <div class="row">
                                        <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                            <small id="passwordHelp" class="text-danger">
                                                <?= $error_array['add_line_2'] ?>
                                            </small>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="row m-2">
                            <div class="form-group col-lg-6 col-md-6">
                                <label class="text-dark" for="postal_code">Postal Code</label>
                                <input  class="<?php if(isset($error_array) && array_key_exists('postal_code',$error_array))  { echo('text-danger');} ?>" type="number" id="postal_code" name="postal_code" required <?php if(isset($old)){echo 'value="'.$old['postal_code'].'"';}else{if(isset($student_data)) {echo 'value="'.$student_data['postal_code'].'"';}} ?> <?php if(isset($student_data)){if($student_data['is_locked'] == 1){echo ('readonly');}}?> >
                                <?php if(isset($error_array) && array_key_exists('postal_code',$error_array))  {?>
                                    <div class="row">
                                        <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                            <small id="passwordHelp" class="text-danger">
                                                <?= $error_array['postal_code'] ?>
                                            </small>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="form-group col-lg-6 col-md-6">
                                <label class="text-dark" for="city">City</label>
                                <input pattern="[A-Za-z1-9 ]+" title="Can't special characters" class="<?php if(isset($error_array) && array_key_exists('city',$error_array))  { echo('text-danger');} ?>" type="text" id="city" name="city" required <?php if(isset($old)){echo 'value="'.$old['city'].'"';}else{if(isset($student_data)) {echo 'value="'.$student_data['city'].'"';}} ?> <?php if(isset($student_data)){if($student_data['is_locked'] == 1){echo ('readonly');}}?> >
                                <?php if(isset($error_array) && array_key_exists('city',$error_array))  {?>
                                    <div class="row">
                                        <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                            <small id="passwordHelp" class="text-danger">
                                                <?= $error_array['city'] ?>
                                            </small>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="row m-2">
                            <div class="form-group col-lg-8 col-md-8">
                                <label class="text-dark" for="phone_number">Phone Number</label>
                                <input  class="<?php if(isset($error_array) && array_key_exists('phone_number',$error_array))  { echo('text-danger');} ?>" type="number" id="phone_number" name="phone_number" required <?php if(isset($old)){echo 'value="'.$old['phone_number'].'"';}else{if(isset($student_data)) {echo 'value="'.$student_data['phone_number'].'"';}} ?> <?php if(isset($student_data)){if($student_data['is_locked'] == 1){echo ('readonly');}}?> >
                                <?php if(isset($error_array) && array_key_exists('phone_number',$error_array))  {?>
                                    <div class="row">
                                        <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                            <small id="passwordHelp" class="text-danger">
                                                <?= $error_array['phone_number'] ?>
                                            </small>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="row m-2">
                            <div class="form-group col-lg-12 col-md-12">
                                <label class="text-dark" for="cp_full_name">Contact Person's Full Name</label>
                                <input pattern="[A-Za-z ]+" title="Can't have numbers and special characters" class="<?php if(isset($error_array) && array_key_exists('cp_full_name',$error_array))  { echo('text-danger');} ?>" type="text" id="cp_full_name" name="cp_full_name" required <?php if(isset($old)){echo 'value="'.$old['cp_full_name'].'"';}else{if(isset($student_data)) {echo 'value="'.$student_data['contact_person_full_name'].'"';}} ?> <?php if(isset($student_data)){if($student_data['is_locked'] == 1){echo ('readonly');}}?> >
                                <?php if(isset($error_array) && array_key_exists('cp_full_name',$error_array))  {?>
                                    <div class="row">
                                        <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                            <small id="passwordHelp" class="text-danger">
                                                <?= $error_array['cp_full_name'] ?>
                                            </small>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="row m-2">
                            <div class="form-group col-lg-8 col-md-8">

                                <label class="text-dark" for="cp_phone_number">Contact Person's Phone Number</label>
                                <input  class="<?php if(isset($error_array) && array_key_exists('cp_phone_number',$error_array))  { echo('text-danger');} ?>" type="number" id="cp_phone_number" name="cp_phone_number" required <?php if(isset($old)){echo 'value="'.$old['cp_phone_number'].'"';}else{if(isset($student_data)) {echo 'value="'.$student_data['contact_person_phone_number'].'"';}} ?> <?php if(isset($student_data)){if($student_data['is_locked'] == 1){echo ('readonly');}}?> >
                                <?php if(isset($error_array) && array_key_exists('cp_phone_number',$error_array))  {?>
                                    <div class="row">
                                        <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                            <small id="passwordHelp" class="text-danger">
                                                <?= $error_array['cp_phone_number'] ?>
                                            </small>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>

                    </div>

                    <div class="text-left">
                        <div id="form_section_header" class="bg-topfive">
                            <h2> Educational Information </h2>
                        </div>

                        <div class="row m-2">
                            <div class="form-group col-lg-8 col-md-8">
                                <label class="text-dark" for="al_index_number">A/L Index Number</label>
                                <input class="<?php if(isset($error_array) && array_key_exists('al_index_number',$error_array))  { echo('text-danger');} ?>" type="number" id="al_index_number" name="al_index_number" class="input-active" required <?php if(isset($old)){echo 'value="'.$old['al_index_number'].'"';}else{if(isset($student_data)) {echo 'value="'.$student_data['al_index_number'].'"';}} ?> <?php if(isset($student_data)){if($student_data['is_locked'] == 1){echo ('readonly');}}?> >
                                <?php if(isset($error_array) && array_key_exists('al_index_number',$error_array))  {?>
                                    <div class="row">
                                        <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                            <small id="passwordHelp" class="text-danger">
                                                <?= $error_array['al_index_number'] ?>
                                            </small>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>

                    <input name="user_id" id="user_id" type="hidden" value="<?= $userId ?>">
                    <input name="type" id="type" type="hidden" value="<?= $types ?>">
                    <input name="ayear_id" id="ayear_id" type="hidden" value="<?= $ayear_data['id'] ?>">

                    <?php

                    if(isset($student_data)){

                        if($student_data['is_locked'] !=1)
                        {
                            ?>
                            <div class="text-center mt-4">
                                <button name="student" type="submit" class="btn btn-xl btn-outline-primary" >Save</button>
                            </div>
                            <?php
                        }

                    }else{ ?>
                        <div class="text-center mt-4">
                            <button name="student" type="submit" class="btn btn-xl btn-outline-primary" >Save</button>
                        </div>
                    <?php } ?>


                </div>

            </form>
        </div>
    </section>
<?php }
else
    {?>

    <section style="padding:10px;" id="portfolio">
        <div class="container ">
            <div class="row topfive-margin">
                <div class="col-lg-12">

                    <h2>New batch registration is not started yet. It will be available soon. Please be wait :)</h2>

                </div>

            </div>
        </div>
    </section>

    <?php

    }
} ?>

    <!--Model-->

    <!-- Footer -->
    <footer class="footer text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-5 mb-lg-0">
                    <h4 class="text-uppercase mb-4">Location</h4>
                    <p class="lead mb-0">University of Moratuwa, <strong>Sri Lanka</strong></p>
                </div>
                <div class="col-md-4 mb-5 mb-lg-0">
                    <h4 class="text-uppercase mb-4">Around the EMPLUP</h4>
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item">
                            <a class="btn btn-outline-light btn-social text-center rounded-circle" href="#">
                                <i class="fa fa-fw fa-facebook"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a class="btn btn-outline-light btn-social text-center rounded-circle" href="#">
                                <i class="fa fa-fw fa-google-plus"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a class="btn btn-outline-light btn-social text-center rounded-circle" href="#">
                                <i class="fa fa-fw fa-twitter"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a class="btn btn-outline-light btn-social text-center rounded-circle" href="#">
                                <i class="fa fa-fw fa-linkedin"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a class="btn btn-outline-light btn-social text-center rounded-circle" href="#">
                                <i class="fa fa-fw fa-dribbble"></i>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h4 class="text-uppercase mb-4">Footer Note</h4>
                    <p class="lead mb-0">This is the description of the footer note </p>
                </div>
            </div>
        </div>
    </footer>

    <div class="copyright py-4 text-center text-white">
        <div class="container">
            <small>Copyright &copy; EMPLUP 2018</small>
        </div>
    </div>

    <!-- Scroll to Top Button (Only visible on small and extra-small screen sizes) -->
    <div class="scroll-to-top d-lg-none position-fixed ">
        <a class="js-scroll-trigger d-block text-center text-white rounded" href="#page-top">
            <i class="fa fa-chevron-up"></i>
        </a>
    </div>
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5aa8ad68cc6156e6"></script>

<?php } ?>


<!-- Bootstrap core JavaScript -->
<script src="js/jquery.min.js"></script>
<script src="js/moment.min.js"></script>

<script src="js/bootstrap.bundle.min.js"></script>

<!-- Plugin JavaScript -->
<script src="js/jquery.easing.min.js"></script>
<script src="js/jquery.magnific-popup.min.js"></script>

<!-- Contact Form JavaScript -->
<script src="js/jqBootstrapValidation.min.js"></script>
<script src="js/contact_me.js"></script>
<!-- Custom scripts for this template -->
<script src="js/freelancer.js"></script>


<script type="text/javascript">


    $(document).ready(function() {
        setInterval(function(){getMessage()}, 10000);

    });

    function getMessage() {

        $.ajax({
            type: 'get',
            url: 'message_count.php',
            dataType:"html",
            data: {user_id: '<?= $_SESSION['user_id'] ?>'},
            success: function (data) {


                if(data =='0'){

                    $('#unseen_count').html('');
                    $('#user_logo').css({"border-color": '', "border-style": '',"border-size": '',"border-radius": ''});

                }else
                {

                    $('#unseen_count').html("  "+data);
                    $('#user_logo').css({"border-color": "orangered", "border-style": "solid","border-size": "2px","border-radius": "25px"});

                }


            },
            error: function(jqxhr, status, exception) {

            }
        });

    }




</script>


</body>

</html>



