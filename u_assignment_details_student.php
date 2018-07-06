<?php
/**
 * Created by PhpStorm.
 * User: Udhan
 * Date: 3/31/2018
 * Time: 6:16 PM
 */
session_start();
require "u_connection.php";

$first_name = $_SESSION['first_name'];
$last_name = $_SESSION['last_name'];
$reg_no=$_SESSION['reg_no'];

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


<!-- Navigation -->
<nav class="navbar navbar-expand-lg bg-secondary fixed-top text-uppercase" id="mainNav">
    <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="#page-top">Emplup<i class="fa fa-user"></i></a>
        <button class="navbar-toggler navbar-toggler-right text-uppercase bg-primary text-white rounded" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            Menu
            <i class="fa fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">

                <li class="nav-item mx-0 mx-lg-1">
                    <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#about"><?php echo $first_name.' '.$last_name?></a>
                </li>

                <li class="nav-item mx-0 mx-lg-1">
                    <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="logout.php">Logout</a>
                </li>

            </ul>
        </div>
    </div>
</nav>

<!-- Header -->
<header class="masthead bg-primary text-white text-center ">

    <div>
        <h1 class="text-uppercase mb-0">Emplup <i class="fa fa-user"></i></h1>
        <h2 style="font-size:50px" class="text-dark mb-2">Student</h2>
        <h4 class=" font-weight-light mb-0">Vocational Trainings - Student Management - Employee Management</h4>
    </div>

</header>

<!-- Dashboard Section -->



<section class="" id="portfolio">
    <div class="container  ">
        <h2 class="text-center text-uppercase text-secondary mb-0"><?php echo $assignment_title?></h2>
        <hr class="star-dark mb-5">

        <div class="text-center text-secondary mb-0">
            <li class="badge"><?php echo $assignment['description'];?></li><br>
            <a href="<?php echo $assignment['attachment_link'];?>" target="_blank"> <li class="badge badge-pill badge-primary "><?php echo $assignment['attachment_link'];?></li></a>
        </div>
        <br>

        <?php

        $today = date("Y-m-d H:i:s");
        $submission_query=$mysqli->query("SELECT * FROM assignment_submissions WHERE assignment_id='$assignment_id' AND student_id='$reg_no' ");
        $no_of_submissions=$submission_query->num_rows;

        if($today<=$deadline){
            if($no_of_submissions==0){
                ?>

                <div class="container text-center text-uppercase text-secondary mb-0">

                    <button type="button" style="width: 50%;" class="btn btn-danger" data-toggle="modal" data-target="#popUpWindow3">SUBMIT</button>
                    <div class="modal fade" id="popUpWindow3">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title">NEW SUBMISSION</h3>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body" >
                                    <p><?php echo $assignment_id?></p>
                                    <form role="form" action="u_upload_submission.php?assignment_id=<?php echo $assignment_id?>&assignment_title=<?php echo $assignment_title?>" method="POST" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <input type="file" class="form-control" placeholder="Title" name="file" required>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-primary btn-block">Submit</button>
                                        </div>
                                    </form>



                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            <?php }else{
                $previous_submission=$submission_query->fetch_assoc();
                ?>

                <div class="container text-center text-uppercase text-secondary mb-0">

                    <button type="button" style="width: 50%;" class="btn btn-success" data-toggle="modal" data-target="#popUpWindow">VIEW SUBMISSION</button>
                    <div class="modal fade" id="popUpWindow">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title">MY SUBMISSION</h3>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body" >

                                    <p><?php echo $assignment_id?></p>
                                    <a href="<?php echo $previous_submission['pdf_link'];?>" target="_blank"><li class="badge badge-success"><?php echo $previous_submission['pdf_link']?></li></a><br>



                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <br><div class="container text-center text-uppercase text-secondary mb-0">

                    <button type="button" style="width: 50%;" class="btn btn-dark" data-toggle="modal" data-target="#popUpWindow2">DELETE SUBMISSION</button>
                    <div class="modal fade" id="popUpWindow2">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title">ARE YOU SURE?</h3>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body" >

                                    <p><?php echo $assignment_id?></p>
                                    <a href="<?php echo $previous_submission['pdf_link'];?>" target="_blank"><li class="badge badge-success"><?php echo $previous_submission['pdf_link']?></li></a><br>

                                </div>
                                <div class="modal-footer">
                                    <a class="text-light btn-block btn btn-primary" href="u_delete_submissions_student.php?assignment_id=<?php echo $assignment_id?>&assignment_title=<?php echo $assignment_title?>">  <button class="btn btn-primary btn-block">Delete</button></a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>





            <?php  }}else{

            if($no_of_submissions==0){
                ?>
                <div class="text-center text-uppercase text-danger mb-0">
                    <li class="badge">No Submission</li>
                </div>
            <?php }else{
                $previous_submission=$submission_query->fetch_assoc();
                ?>

                <div class="container text-center text-uppercase text-secondary mb-0">

                    <button type="button" style="width: 50%;" class="btn btn-success" data-toggle="modal" data-target="#popUpWindow">VIEW SUBMISSION</button>
                    <div class="modal fade" id="popUpWindow">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title">MY SUBMISSION</h3>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body" >

                                    <p><?php echo $assignment_id?></p>
                                    <a href="<?php echo $previous_submission['pdf_link'];?>" target="_blank"><li class="badge badge-success"><?php echo $previous_submission['pdf_link']?></li></a><br>

                                </div>

                            </div>
                        </div>
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