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

    if ($types == 2) {
        header("location: home_student.php");
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

<?php } else { if($two_step == 1){

        $user_id = $_SESSION['user_id']; $current_employee_type_result = $mysqli->query("select DISTINCT employee_types.title,employee_types.id from employee_types, users, employee_data where employee_data.user_id = '$user_id' and employee_types.id = employee_data.employee_type_id") or die($mysqli->error());
        if($current_employee_type_result->num_rows !=0)
        {
            $current_employee_type_data = $current_employee_type_result->fetch_assoc();
            $current_employee_type_result->free();
            $type_of_employment = $current_employee_type_data['title'];
        }


if ($_SERVER['REQUEST_METHOD'] == 'GET')
{

    if(isset($_GET['id']) && isset($_GET['ay_id']))
    {

        $aid = $_GET['ay_id'];

        if((is_int($_GET['id']) || ctype_digit($_GET['id'])) && (int)$_GET['id'] > 0)
        {
            $id = $_GET['id'];

            $result  =  $mysqli->query("select * from student_data where id='$id'") or die($mysqli->error());


            if($result->num_rows !=0 )
            {



                $data=$result->fetch_assoc();



                $user_id = $data['user_id'];
                $resultbasic  =  $mysqli->query("select * from users where id='$user_id'") or die($mysqli->error());

                if($resultbasic->num_rows ==0)
                {
                    $_SESSION['message'] = "Not a valid users";
                    header("location:error.php");

                }

                $databasic=$resultbasic->fetch_assoc();

                $result->free();
                $resultbasic->free();

                if(isset($data) && isset($databasic))
                {

                    $student_data_new = $data;
                    $student_basic_data = $databasic;

                }else
                {
                    header("location: student_registrations.php?academic_year_id='$aid'");


                }



            }else
            {
                header("location: student_registrations.php?academic_year_id='$aid'");

                //should set error in here
            }


        }else
        {
            header("location: student_registrations.php?academic_year_id='$aid'");

            //should set error in here
        }

    }else {

        $_SESSION['message'] = "No valid parameters";
        header("location:error.php");

    }

}else
    {
        $_SESSION['message'] = "Invalid request";
        header("location:error.php");

    }


 if($type_of_employment == 'Administrator') {  ?>


    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg bg-secondary fixed-top text-uppercase" id="mainNav">
        <div class="container">
            <a class="navbar-brand js-scroll-trigger" href="#page-top">Emplup<i class="fa fa-user"></i></a>
            <button class="navbar-toggler navbar-toggler-right text-uppercase bg-primary text-white rounded" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                Menu
                <i class="fa fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <?php require 'navigation.php';?>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <header class="masthead bg-primary text-white text-center ">

        <div>
            <h1 class="text-uppercase mb-0">Emplup <i class="fa fa-user"></i></h1>
            <h2 style="font-size:50px" class="text-dark mb-2"> Student Profile </h2>

        </div>

    </header>


    <section style="padding:10px;" id="portfolio">
        <div class="container ">
            <div id="two_step_submission_form" class="two_step_form">
                <div class="container">
                    <div class="text-left">
                        <div id="form_section_header" class="bg-topfive">
                            <h2> Basic Information </h2>
                        </div>
                        <div class="row m-2">
                            <div class="form-group col-lg-6 col-md-6">
                                <label class="text-dark" for="first_name">First Name</label>
                                <input type="text"  id="first_name" name="first_name" class="input-active"  value="<?= $student_basic_data['first_name'] ?>" readonly>
                            </div>
                            <div class="form-group col-lg-6 col-md-6">
                                <label class="text-dark" for="last_name">Last Name</label>
                                <input type="text"  id="last_name" name="last_name" class="input-active"  value="<?= $student_basic_data['last_name']  ?>" readonly>
                            </div>
                        </div>
                        <div class="row m-2">
                            <div class="form-group col-lg-12 col-md-12">
                                <label class="text-dark" for="email">Email</label>
                                <input type="text"  id="email" name="email" class="input-active"  value="<?= $student_basic_data['email']  ?>" readonly>
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
                                <select id="title" name="title" disabled >
                                    <option value="Mr" <?php if(isset($old)){if ($old['title'] == 'Mr') {echo "selected";}}else{if(isset($student_data_new)) {if ($student_data_new['title'] == 'Mr') {echo "selected";}}} ?> >Mr</option>
                                    <option value="Miss" <?php if(isset($old)){if ($old['title'] == 'Miss') {echo "selected";}}else{if(isset($student_data_new)) {if ($student_data_new['title'] == 'Miss') {echo "selected";}}} ?> >Miss</option>
                                    <option value="Mrs" <?php if(isset($old)){if ($old['title'] == 'Mrs') {echo "selected";}}else{if(isset($student_data_new)) {if ($student_data_new['title'] == 'Mrs') {echo "selected";}}} ?> >Mrs</option>
                                </select>
                            </div>
                            <div class="form-group col-lg-6 col-md-6">
                                <label class="text-dark" for="sex">Sex</label>
                                <select id="sex" name="sex" disabled >
                                    <option value="Male" <?php if(isset($old)){if ($old['sex'] == 'Male') {echo "selected";}}else{if(isset($student_data_new)) {if ($student_data_new['sex'] == 'Male') {echo "selected";}}} ?> >Male</option>
                                    <option value="Female" <?php if(isset($old)){if ($old['sex'] == 'Female') {echo "selected";}}else{if(isset($student_data_new)) {if ($student_data_new['sex'] == 'Female') {echo "selected";}}} ?> >Female</option>
                                </select>
                            </div>
                        </div>

                        <div class="row m-2">
                            <div class="form-group col-lg-12 col-md-12">
                                <label class="text-dark" for="full_name">Full Name</label>
                                <input  class="<?php if(isset($error_array) && array_key_exists('full_name',$error_array))  { echo('text-danger');} ?>" type="text" id="full_name" name="full_name"  required <?php if(isset($old)){echo 'value="'.$old['full_name'].'"';}else{if(isset($student_data_new)) {echo 'value="'.$student_data_new['full_name'].'"';}} ?><?php if(isset($student_data_new)){if($student_data_new['is_locked'] == 1){echo ('readonly');}}?> readonly  >
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
                                <input  class="<?php if(isset($error_array) && array_key_exists('dob',$error_array))  { echo('text-danger');} ?>" type="date" id="dob" name="dob" required <?php if(isset($old)){echo 'value="'.$old['dob'].'"';}else{if(isset($student_data_new)) {echo 'value="'.$student_data_new['dob'].'"';}} ?> <?php if(isset($student_data_new)){if($student_data_new['is_locked'] == 1){echo ('readonly');}}?> readonly >
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
                                <select id="civil_status" name="civil_status" disabled >
                                    <option value="Single" <?php if(isset($old)){if ($old['civil_status'] == 'Single') {echo "selected";}}else{if(isset($student_data_new)) {if ($student_data_new['civil_status'] == 'Single') {echo "selected";}}} ?> >Single</option>
                                    <option value="Married" <?php if(isset($old)){if ($old['civil_status'] == 'Married') {echo "selected";}}else{if(isset($student_data_new)) {if ($student_data_new['civil_status'] == 'Married') {echo "selected";}}} ?> >Married</option>
                                </select>
                            </div>
                        </div>

                        <div class="row m-2">
                            <div class="form-group col-lg-12 col-md-12">
                                <label class="text-dark" for="nic">National Identity Card Number</label>
                                <input  class="<?php if(isset($error_array) && array_key_exists('nic',$error_array))  { echo('text-danger');} ?>" type="text" id="nic" name="nic" required <?php if(isset($old)){echo 'value="'.$old['nic'].'"';}else{if(isset($student_data_new)) {echo 'value="'.$student_data_new['nic'].'"';}} ?> <?php if(isset($student_data_new)){if($student_data_new['is_locked'] == 1){echo ('readonly');}}?> readonly >
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
                                <label class="text-dark" for="is_physical">Are you physically okay?</label>

                                <?php if($student_data_new['is_physically_disabled'] == "on") {?>

                                    <h5>Yes</h5>

                                <?php } else { echo "<h5>Yes</h5>";}?>



                                              </div>
                        </div>

                        <div class="row m-2">
                            <div class="form-group col-lg-12 col-md-12">
                                <label class="text-dark" for="father_full_name">Father's Full Name</label>
                                <input  class="<?php if(isset($error_array) && array_key_exists('father_full_name',$error_array))  { echo('text-danger');} ?>" type="text" id="father_full_name" name="father_full_name" required <?php if(isset($old)){echo 'value="'.$old['father_full_name'].'"';}else{if(isset($student_data_new)) {echo 'value="'.$student_data_new['father_full_name'].'"';}} ?> <?php if(isset($student_data_new)){if($student_data_new['is_locked'] == 1){echo ('readonly');}}?> readonly >
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
                                <input  class="<?php if(isset($error_array) && array_key_exists('mother_full_name',$error_array))  { echo('text-danger');} ?>" type="text" id="mother_full_name" name="mother_full_name" required <?php if(isset($old)){echo 'value="'.$old['mother_full_name'].'"';}else{if(isset($student_data_new)) {echo 'value="'.$student_data_new['mother_full_name'].'"';}} ?> <?php if(isset($student_data_new)){if($student_data_new['is_locked'] == 1){echo ('readonly');}}?> readonly >
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
                                <input  class="<?php if(isset($error_array) && array_key_exists('add_line_1',$error_array))  { echo('text-danger');} ?>"type="text" id="add_line_1" name="add_line_1" required <?php if(isset($old)){echo 'value="'.$old['add_line_1'].'"';}else{if(isset($student_data_new)) {echo 'value="'.$student_data_new['address_line_1'].'"';}} ?> <?php if(isset($student_data_new)){if($student_data_new['is_locked'] == 1){echo ('readonly');}}?> readonly >
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
                                <input  class="<?php if(isset($error_array) && array_key_exists('add_line_2',$error_array))  { echo('text-danger');} ?>" type="text" id="add_line_2" name="add_line_2" required <?php if(isset($old)){echo 'value="'.$old['add_line_2'].'"';}else{if(isset($student_data_new)) {echo 'value="'.$student_data_new['address_line_2'].'"';}} ?> <?php if(isset($student_data_new)){if($student_data_new['is_locked'] == 1){echo ('readonly');}}?> readonly >
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
                                <input  class="<?php if(isset($error_array) && array_key_exists('postal_code',$error_array))  { echo('text-danger');} ?>" type="number" id="postal_code" name="postal_code" required <?php if(isset($old)){echo 'value="'.$old['postal_code'].'"';}else{if(isset($student_data_new)) {echo 'value="'.$student_data_new['postal_code'].'"';}} ?> <?php if(isset($student_data_new)){if($student_data_new['is_locked'] == 1){echo ('readonly');}}?> readonly >
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
                                <input  class="<?php if(isset($error_array) && array_key_exists('city',$error_array))  { echo('text-danger');} ?>" type="text" id="city" name="city" required <?php if(isset($old)){echo 'value="'.$old['city'].'"';}else{if(isset($student_data_new)) {echo 'value="'.$student_data_new['city'].'"';}} ?> <?php if(isset($student_data_new)){if($student_data_new['is_locked'] == 1){echo ('readonly');}}?> readonly >
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
                                <input  class="<?php if(isset($error_array) && array_key_exists('phone_number',$error_array))  { echo('text-danger');} ?>" type="number" id="phone_number" name="phone_number" required <?php if(isset($old)){echo 'value="'.$old['phone_number'].'"';}else{if(isset($student_data_new)) {echo 'value="'.$student_data_new['phone_number'].'"';}} ?> <?php if(isset($student_data_new)){if($student_data_new['is_locked'] == 1){echo ('readonly');}}?> readonly >
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
                                <input  class="<?php if(isset($error_array) && array_key_exists('cp_full_name',$error_array))  { echo('text-danger');} ?>" type="text" id="cp_full_name" name="cp_full_name" required <?php if(isset($old)){echo 'value="'.$old['cp_full_name'].'"';}else{if(isset($student_data_new)) {echo 'value="'.$student_data_new['contact_person_full_name'].'"';}} ?> <?php if(isset($student_data_new)){if($student_data_new['is_locked'] == 1){echo ('readonly');}}?> readonly >
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
                                <input  class="<?php if(isset($error_array) && array_key_exists('cp_phone_number',$error_array))  { echo('text-danger');} ?>" type="number" id="cp_phone_number" name="cp_phone_number" required <?php if(isset($old)){echo 'value="'.$old['cp_phone_number'].'"';}else{if(isset($student_data_new)) {echo 'value="'.$student_data_new['contact_person_phone_number'].'"';}} ?> <?php if(isset($student_data_new)){if($student_data_new['is_locked'] == 1){echo ('readonly');}}?> readonly >
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
                                <input class="<?php if(isset($error_array) && array_key_exists('al_index_number',$error_array))  { echo('text-danger');} ?>" type="number" id="al_index_number" name="al_index_number" class="input-active" required <?php if(isset($old)){echo 'value="'.$old['al_index_number'].'"';}else{if(isset($student_data_new)) {echo 'value="'.$student_data_new['al_index_number'].'"';}} ?> <?php if(isset($student_data_new)){if($student_data_new['is_locked'] == 1){echo ('readonly');}}?> readonly >
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






                    <form  action="student_registrations_action.php" method="post">

                        <?php ?>
                        <?php if($student_data_new['is_locked'] == 1) { if($student_data_new['is_approved'] ==1) {?>
                            <input name="id" type="hidden" value="<?php echo $student_data_new['id']?>">
                            <input name="action_type" type="hidden" value="disapprove">
                            <div class="text-center mt-4">
                                <button name="student" type="submit" class="btn btn-xl btn-outline-warning" >Disapprove</button>
                            </div>
                        <?php }else{ ?>
                            <input name="id" type="hidden" value="<?php echo $student_data_new['id']?>">
                            <input name="action_type" type="hidden" value="approve">
                            <div class="text-center mt-4">
                                <button name="student" type="submit" class="btn btn-xl btn-outline-success" >Approve</button>
                            </div>

                        <?php }} ?>

                    </form>

                    <form  action="student_registrations_action.php" method="post">
                        <input name="id" type="hidden" value="<?php echo $student_data_new['id']?>">
                        <input name="action_type" type="hidden" value="delete">
                        <div class="text-center mt-4">
                            <button name="student" type="submit" class="btn btn-xl btn-outline-danger" >Delete</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </section>


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

<?php }else{

    if ($_SESSION['types'] == 1) {

        header('location: home_employee.php');
    } else {
        header('location: home_student.php');
    }

}} else
    {
        if ($_SESSION['types'] == 1) {

            header('location: home_employee.php');
        } else {
            header('location: home_student.php');
        }

    }
}?>


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



