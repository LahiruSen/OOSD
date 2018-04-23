<?php
session_start();
require 'connection.php';




$course_id=$_GET['id'];
$course_title=$_GET['title'];
//$result=$mysqli->query("SELECT * FROM courses");
//while ($row = mysqli_fetch_array($result, $result->num_rows)) {
//    if (isset($_POST[$row[0]])) {
//        $course_id= $row[0];
//        $course_title=$row[1];
//        break;
//    }
//}
#$_SESSION['course_id']=$course_id;
#$_SESSION['course_title']=$course_title;
$name=$_SESSION['name'];
?>



<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Vocational training center">
    <meta name="author" content="G27">
    <title>My Home : <?= $name?></title>
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

                <!-- Navigation menu-->
                <li class="nav-item mx-0 mx-lg-1">
                    <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#about"><?php echo $name?></a>
                </li>


                <li class="nav-item mx-0 mx-lg-1">
                    <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="logout.php">Logout</a>
                </li>

                <li class="nav-item mx-0 mx-lg-1">
                    <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="courses.php">BACK</a>
                </li>

            </ul>
        </div>
    </div>
</nav>

<!-- Header -->
<header class="masthead bg-primary text-white text-center ">

    <div>
        <h1 class="text-uppercase mb-0">Emplup <i class="fa fa-user"></i></h1>
        <h2 style="font-size:50px" class="text-dark mb-2">Employee</h2>
        <h4 class="font-weight-light mb-0">Vocational Trainings - Student Management - Employee Management</h4>
    </div>

</header>

<!-- Dashboard Section -->
<section class="" id="portfolio">
    <div class="container ">
        <h2 class="text-center text-uppercase text-secondary mb-0"><?php echo $course_title?></h2>
        <hr class="star-dark mb-5">
        <div class="row">

            <div class="col-lg-6 ">


                <li class="button button-block">
                    <a href="create_assignments.php?title=<?php echo $course_title;?>&id=<?php echo $course_id?>" class="nav-link py-0 px-0 px-lg-3 rounded js-scroll-trigger" href="#portfolio">Create Assignments</a>
                </li><br>
                <li class="button button-block">
                    <a href="view_assignments_teacher.php?title=<?php echo $course_title;?>&id=<?php echo $course_id?>" class="nav-link py-0 px-0 px-lg-3 rounded js-scroll-trigger" href="#contact">View  Submissions</a>
                </li><br>
                <li class="button button-block">
                    <a class="nav-link py-0 px-0 px-lg-3 rounded js-scroll-trigger" href="#about">Link 3</a>
                </li><br>
                <li class="button button-block">
                    <a class="nav-link py-0 px-0 px-lg-3 rounded js-scroll-trigger" href="#contact">Link 4</a>
                </li><br>
                <li class="button button-block">
                    <a class="nav-link py-0 px-0 px-lg-3 rounded js-scroll-trigger" href="#about">Link 5</a>
                </li>


            </div>

        </div>
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
