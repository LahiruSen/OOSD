<?php
/**
 * Created by PhpStorm.
 * User: Udhan
 * Date: 7/5/2018
 * Time: 9:53 PM
 */
if (session_status() == PHP_SESSION_NONE) {    session_start();}
require "u_connection.php";

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
    $user_id=$_SESSION['user_id'];

    $employee_query=$mysqli->query("SELECT * FROM employee_data WHERE user_id='$user_id'");
    $employee=$employee_query->fetch_assoc();
    $employee_type_id=$employee['employee_type_id'];

    if ($types == 2) {
        header("location: home_student.php");
    }else{
        if($employee_type_id==1 || $employee_type_id==3 ||$employee_type_id==4){
            header("location: home_employee.php");
        }
    }
}

//$first_name = $_SESSION['first_name'];
//$last_name = $_SESSION['last_name'];
//$reg_no=$_SESSION['reg_no'];

$assignment_id=$_SESSION['assignment_id'];
$assignment_title=$_SESSION['assignment_title'];

$assignment_query=$mysqli->query("SELECT * FROM assignments WHERE id='$assignment_id'");
$assignment=$assignment_query->fetch_assoc();

$deadline=$assignment['date_of_deadline'];

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Vocational training center">
    <meta name="author" content="G27">
    <title>My Home : <?= $first_name.' '.$last_name ?></title>
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
                <?php require 'navigation.php';?>
            </div>
        </div>
    </nav>

<!-- Header -->
<header class="masthead bg-primary text-white text-center ">

    <div>
        <h1 class="text-uppercase mb-0">Emplup <i class="fa fa-user"></i></h1>
        <h2 style="font-size:50px" class="text-dark mb-2">Employee</h2>
        <h4 class=" font-weight-light mb-0">Vocational Trainings - Student Management - Employee Management</h4>
    </div>

</header>

<!-- Dashboard Section -->



<section class="" id="portfolio">
    <div class="container">
        <h2 class="text-center text-uppercase text-secondary mb-0"><?php echo $assignment_title?></h2>
        <hr class="star-dark mb-5">
        <div class="col-md">
        <div class="jumbotron jumbotron-fluid bg-topfive">
        <div class="container text-center">
            <div class="card" style="width:100%">
                <div class="card-body">
                    <h6 class="card-title">Description</h6>
            <p class="card-text text-center"><?php echo $assignment['description'];?></p>
                    <h6 class="card-title">Attachment</h6>
            <a href="<?php echo $assignment['attachment_link'];?>" target="_blank"> <li class="badge badge-pill badge-primary "><?php echo $assignment['attachment_link'];?></li></a>
                    <h6 class="card-title">Deadline</h6>
            <p class="card-text text-center"><?php echo $assignment['date_of_deadline'];?></p>
                    <h6 class="card-title">Date of Update</h6>
            <p class="card-text text-center"><?php echo $assignment['date_of_update'];?></p>
                    <h6 class="card-title">Date of Create</h6>
            <p class="card-text text-center"><?php echo $assignment['date_of_create'];?></p>
                </div>
            </div>
        </div>

        </div></div>
        <?php

        $today = date("Y-m-d H:i:s");
        $submission_query=$mysqli->query("SELECT * FROM assignment_submissions WHERE assignment_id='$assignment_id'");
        $no_of_submissions=$submission_query->num_rows;

        if($today<=$deadline){
            if($no_of_submissions==0){
                ?>
                <div class="row">
                <div class="col-md">
                <div class="container text-center text-uppercase text-secondary mb-0">

                    <button type="button" style="width: 50%;" class="btn btn-dark" data-toggle="modal" data-target="#popUpWindow2">UPDATE ASSIGNMENT</button>
                    <div class="modal fade" id="popUpWindow2">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title">Update Assignment</h3>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body" >
                                    <form role="form" action="u_update_assignments_teacher.php?assignment_id=<?php echo $assignment_id?>" method="POST" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <li type="text" class="text-dark align-content-lg-start">Previous Name  <?php echo $assignment['title']?></li>
                                            <input type="text" class="form-control" placeholder="New Title" name="title">
                                        </div>
                                        <div class="form-group">
                                            <li type="text" class="text-dark align-content-lg-start">Previous Description <?php echo $assignment['description']?></li>
                                            <input type="text" class="form-control" placeholder="New Description" name="description">
                                        </div>
                                        <div class="form-group">
                                            <li type="text" class="text-dark align-content-lg-start">Previous AttachmentLink <a href="<?php echo $assignment['attachment_link'];?>" target="_blank"> <li class="badge badge-pill badge-primary "><?php echo $assignment['attachment_link'];?></li></a></li>
                                            <input type="file" class="form-control" placeholder="Attachment" name="file">
                                        </div>
                                        <div class="form-group">
                                            <li type="text" class="text-dark align-content-lg-start">Previous Deadline <?php echo $assignment['date_of_deadline']?></li>
                                            <input type="datetime-local" class="form-control" placeholder="Deadline" name="deadline">
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-primary btn-block">Update</button>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div></div><br>
                <div class="col">
                <div class="container text-center text-uppercase text-secondary mb-0">

                    <button type="button" style="width: 50%;" class="btn btn-dark" data-toggle="modal" data-target="#popUpWindow">DELETE ASSIGNMENT</button>
                    <div class="modal fade" id="popUpWindow">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-topfive">
                                    <h3 class="modal-title">ARE YOU SURE?</h3>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body" >

                                    <p>You are going to delete this assignment permanantly</p>
                                    <!--                                    <a href="--><?php //echo $previous_submission['pdf_link'];?><!--" target="_blank"><li class="badge badge-success">--><?php //echo $previous_submission['pdf_link']?><!--</li></a><br>-->

                                </div>
                                <div class="modal-footer">
                                    <a class="text-light btn-block btn btn-primary" href="u_delete_assignments_teacher.php?assignment_id=<?php echo $assignment_id?>&assignment_title=<?php echo $assignment_title?>">  <button class="btn btn-primary btn-block">Delete</button></a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                </div>
                </div>

                <!--                <div class="container">-->

                <!--                    <div class="col-lg-6 " align="center">-->
                <!--                        <li class="badge"><label class="btn btn-light btn-lg-0">Assignment id:--><?php //echo $asignment[0]; ?><!--</label></li>-->
                <!---->
                <!---->
                <!--                        <label class="btn btn-success btn-lg-0" style="">--><?php //echo $asignment[5];?><!--</label>-->

                <!--                        <a class="text-dark" href="assignment_session_setup.php?assignment_id=--><?php //echo $asignment[0]?><!--&assignment_title=--><?php //echo $asignment[5]?><!--"> <input class="btn btn-dark btn-lg-0" type="submit" value="View Submissions"></a>-->
                <!--                        <br>-->
                <!--                        <br>-->
                <!--                    </div>-->


                <!--                    <button type="button" style="width: 50%;" class="btn btn-danger" data-toggle="modal" data-target="#popUpWindow3">SUBMIT</button>-->
                <!--                    <div class="modal fade" id="popUpWindow3">-->
                <!--                        <div class="modal-dialog">-->
                <!--                            <div class="modal-content">-->
                <!--                                <div class="modal-header">-->
                <!--                                    <h3 class="modal-title">NEW SUBMISSION</h3>-->
                <!--                                    <button type="button" class="close" data-dismiss="modal">&times;</button>-->
                <!--                                </div>-->
                <!--                                <div class="modal-body" >-->
                <!--                                    <p>--><?php //echo $assignment_id?><!--</p>-->
                <!--                                    <form role="form" action="upload_submission.php?assignment_id=--><?php //echo $assignment_id?><!--&assignment_title=--><?php //echo $assignment_title?><!--" method="POST" enctype="multipart/form-data">-->
                <!--                                        <div class="form-group">-->
                <!--                                            <input type="file" class="form-control" placeholder="Title" name="file" required>-->
                <!--                                        </div>-->
                <!--                                        <div class="modal-footer">-->
                <!--                                            <button class="btn btn-primary btn-block">Submit</button>-->
                <!--                                        </div>-->
                <!--                                    </form>-->
                <!---->
                <!---->
                <!---->
                <!--                                </div>-->
                <!---->
                <!--                            </div>-->
                <!--                        </div>-->
                <!--                    </div>-->
                <!--                </div>-->

            <?php }else{
                $submissions=$submission_query->fetch_assoc();
                ?>

                <div class="container text-center text-uppercase text-secondary mb-0">

                    <a class="text-light btn-block btn btn-primary" href="u_assignment_session_setup.php?assignment_id=<?php echo $assignment_id?>&assignment_title=<?php echo $assignment_title?>">  <button class="btn btn-primary btn-block">View Submission</button></a>

                </div>

                <!--                <div class="container ">-->
                <!--                    <a href="assignment_session_setup.php?assignment_id=--><?php //echo $asignment[0]?><!--&assignment_title=--><?php //echo $asignment[5]?><!--"> <button class="btn btn-success" style="width: 80%" type="button">Delete Assignment</button></a>-->
                <!---->
                <!--                </div>-->
                <!---->
                <!--                <div class="container text-center text-uppercase text-secondary mb-0">-->
                <!---->
                <!--                    <button type="button" style="width: 50%;" class="btn btn-success" data-toggle="modal" data-target="#popUpWindow">VIEW SUBMISSION</button>-->
                <!--                    <div class="modal fade" id="popUpWindow">-->
                <!--                        <div class="modal-dialog">-->
                <!--                            <div class="modal-content">-->
                <!--                                <div class="modal-header">-->
                <!--                                    <h3 class="modal-title">MY SUBMISSION</h3>-->
                <!--                                    <button type="button" class="close" data-dismiss="modal">&times;</button>-->
                <!--                                </div>-->
                <!--                                <div class="modal-body" >-->
                <!---->
                <!--                                    <p>--><?php //echo $assignment_id?><!--</p>-->
                <!--                                    <a href="--><?php //echo $previous_submission['pdf_link'];?><!--" target="_blank"><li class="badge badge-success">--><?php //echo $previous_submission['pdf_link']?><!--</li></a><br>-->
                <!---->
                <!---->
                <!---->
                <!--                                </div>-->
                <!---->
                <!--                            </div>-->
                <!--                        </div>-->
                <!--                    </div>-->
                <!--                </div>-->

                <!--                <br><div class="container text-center text-uppercase text-secondary mb-0">-->
                <!---->
                <!--                    <button type="button" style="width: 50%;" class="btn btn-dark" data-toggle="modal" data-target="#popUpWindow2">DELETE SUBMISSION</button>-->
                <!--                    <div class="modal fade" id="popUpWindow2">-->
                <!--                        <div class="modal-dialog">-->
                <!--                            <div class="modal-content">-->
                <!--                                <div class="modal-header">-->
                <!--                                    <h3 class="modal-title">ARE YOU SURE?</h3>-->
                <!--                                    <button type="button" class="close" data-dismiss="modal">&times;</button>-->
                <!--                                </div>-->
                <!--                                <div class="modal-body" >-->
                <!---->
                <!--                                    <p>--><?php //echo $assignment_id?><!--</p>-->
                <!--                                    <a href="--><?php //echo $previous_submission['pdf_link'];?><!--" target="_blank"><li class="badge badge-success">--><?php //echo $previous_submission['pdf_link']?><!--</li></a><br>-->
                <!---->
                <!--                                </div>-->
                <!--                                <div class="modal-footer">-->
                <!--                                    <a class="text-light btn-block btn btn-primary" href="delete_submissions_student.php?assignment_id=--><?php //echo $assignment_id?><!--&assignment_title=--><?php //echo $assignment_title?><!--">  <button class="btn btn-primary btn-block">Delete</button></a>-->
                <!--                                </div>-->
                <!---->
                <!--                            </div>-->
                <!--                        </div>-->
                <!--                    </div>-->
                <!--                </div>-->





            <?php  }}else{

        if($no_of_submissions==0){
            ?>
            <div class="col-md">
            <div class="text-center mb-0">
                <label class="btn bg-danger text-light">No Submissions</label>
            </div>
            </div>
        <?php }else{
        //$previous_submission=$submission_query->fetch_assoc();
        ?>

        <div class="container text-center text-uppercase text-secondary mb-0">

            <a class="text-light btn-block btn btn-primary" href="u_assignment_session_setup.php?assignment_id=<?php echo $assignment_id?>&assignment_title=<?php echo $assignment_title?>">  <button class="btn btn-primary btn-block">View Submission</button></a>

        </div>
    </div>

    <?php  }
    }?>

    </div>
</section>

<!-- About Section -->
<section class="bg-primary text-white mb-0" id="about">
    <div class="container">
        <h2 class="text-center text-uppercase text-white">About EMPLUP</h2>
        <hr class="star-light mb-5">
        <div class="row">
            <div class="col-lg-4 ml-auto">
                <p class="lead">Basic introduction about the web site goes here! {description left]</p>
            </div>
            <div class="col-lg-4 mr-auto">
                <p class="lead">Basic introduction about the web site goes here! {description right</p>
            </div>
        </div>
        <div class="text-center mt-4">
            <a class="btn btn-xl btn-outline-light" href="#">
                <i class="fa fa-info mr-2"></i>
                Read More
            </a>
        </div>
    </div>
</section>

<?php if($_SESSION['two_step'] == 0) {


$user_result =  $mysqli->query("SELECT * FROM users WHERE email='$email'") or die($mysqli->error());

if($user_result->num_rows != 0)
{
$user_data = $user_result->fetch_assoc();
$user_result->free();
$user_id = $user_data['id'];
$employee_result =  $mysqli->query("SELECT * FROM employee_data WHERE user_id='$user_id'") or die($mysqli->error());


if($employee_result->num_rows != 0)
{
$employee_data = $employee_result->fetch_assoc();

$employee_result->free();

if($employee_data['is_locked'] != 1)
{
?>

    <div class="modal fade" id="completeProfile">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content ">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Please Complete Your Profile</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    Our system administrator should verify your profile information before giving access to EMPLUP resources.
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>

    <?php
}
else
{
    ?>

    <div class="modal fade" id="completeProfile">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content ">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title text-warning">Activation is pending <i class="fa fa-exclamation-triangle"></i></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    Our system administrator should verify your profile information before giving access to EMPLUP resources.
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>

    <?php
}

}
else
{

    ?>

    <div class="modal fade" id="completeProfile">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content ">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Please Add Profile information</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    Our system administrator should verify your profile information before giving access to EMPLUP resources.
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>

<?php

}

}

else
{

    $_SESSION['message'] = "You are not a valid user";
    header("location:error.php");
}

} ?>



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

<!--Model-->
<!-- Footer -->

<!-- Bootstrap core JavaScript -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>

<!-- Plugin JavaScript -->
<script src="js/jquery.easing.min.js"></script>
<script src="js/jquery.magnific-popup.min.js"></script>

<!-- Contact Form JavaScript -->
<script src="js/jqBootstrapValidation.min.js"></script>
<script src="js/contact_me.js"></script>
<!-- Custom scripts for this template -->
<script src="js/freelancer.js"></script>

</body>

</html>

<?php if($_SESSION['two_step'] == 0) { ?>
    <script >
        $( document ).ready(function() {
            $('#completeProfile').modal('show');
        });

    </script>

<?php } ?>

</body>
</html>

