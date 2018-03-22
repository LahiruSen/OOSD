
<?php
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
}
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


<?php if($active) {?>

<div class="container">
    <p class="alert alert-danger alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    <p><strong>Warning! </strong>  Account is unverified, please confirm your email by clicking
        on the email link!


        <button type="button" class="btn btn-danger" href="logout.php">
            Logout
        </button>

    </p>
</div>

<?php} else{ ?>


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

                <?php




                ?>



                <li class="nav-item mx-0 mx-lg-1">
                    <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#portfolio">Link 1</a>
                </li>
                <li class="nav-item mx-0 mx-lg-1">
                    <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#contact">Link 2</a>
                </li>
                <li class="nav-item mx-0 mx-lg-1">
                    <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#about">Link 3</a>
                </li>
                <li class="nav-item mx-0 mx-lg-1">
                    <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#contact">Link 4</a>
                </li>
                <li class="nav-item mx-0 mx-lg-1">
                    <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#about">Link 5</a>
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

        <h1 class="text-uppercase mb-0">Emplup <i class="fa fa-user"></i></h1>
        <h2 class="font-weight-light mb-0">Vocational Trainings - Student Management - Employee Management</h2>



    </div>




</header>

<!-- Dashboard Section -->
<section class="" id="portfolio">
    <div class="container ">
        <h2 class="text-center text-uppercase text-secondary mb-0">Dashboard</h2>
        <hr class="star-dark mb-5">
        <div class="row">

            <div class="col-lg-6 ">


                <h1 class="display-4">Why Tubepick?</h1>
                <p class="lead">Tubepick downloader is famous among our beloved users because of</p>
                <hr class="my-4">
                <p class="bg-topfive-text"><i class="fa fa-circle"></i>   No charges, 100% free, fast just like a thunder.</p>
                <p class="bg-topfive-text"><i class="fa fa-circle"></i>   Very easy to use.</p>
                <p class="bg-topfive-text"><i class="fa fa-circle"></i>   Support both HD and SD videos(Up to 4K).</p>
                <p class="bg-topfive-text"><i class="fa fa-circle"></i>   Support audio download.</p>
                <p class="bg-topfive-text"><i class="fa fa-circle"></i>   Add supports for new site every week.</p>
                <p class="bg-topfive-text"><i class="fa fa-circle"></i>   Generate all possible download links.</p>
                <p class="lead">
                    <a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a>
                </p>


            </div>
            <div class=" col-lg-6">
                <div class="card card-style">
                    <div class="card-header bg-topfive">
                        <h3 class="card-header-pills">Top Sites</h3>
                    </div>
                    <div class="card-body">
                        <div class="row topfive-margin">
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xl-8 col-xs-8">

                                <h5>Facebook.com </h5>

                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xl-4 col-xs-4 text-center">
                                <span style="width: 80px" class="badge badge-success badge-pill">Active <i class="fa fa-check" style="color: green"></i></span>
                            </div>
                        </div>

                        <div class="row topfive-margin">
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xl-8 col-xs-8">

                                <h5>Instagram.com</h5>

                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xl-4 col-xs-4 text-center">
                                <span style="width: 80px" class="badge badge-danger badge-pill">Inactive <i class="fa fa-times" style="color: red"></i></span>
                            </div>
                        </div>
                        <div class="row topfive-margin">
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xl-8 col-xs-8">

                                <h5>Vevo.com</h5>

                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xl-4 col-xs-4 text-center">
                                <span style="width: 80px" class="badge badge-success badge-pill">Active <i class="fa fa-check" style="color: green"></i></span>
                            </div>
                        </div>

                        <div class="row topfive-margin">
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xl-8 col-xs-8">

                                <h5>Vimeo.com</h5>

                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xl-4 col-xs-4 text-center">
                                <span style="width: 80px" class="badge badge-success badge-pill">Active <i class="fa fa-check" style="color: green"></i></span>
                            </div>
                        </div>

                        <div class="row topfive-margin">
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xl-8 col-xs-8">

                                <h5>Dailymotion.com</h5>

                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xl-4 col-xs-4 text-center">
                                <span style="width: 80px" class="badge badge-success badge-pill">Active <i class="fa fa-check" style="color: green"></i></span>
                            </div>
                        </div>
                        <div class="row topfive-margin">
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xl-8 col-xs-8">

                                <h5>Soundcloud.com</h5>

                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xl-4 col-xs-4 text-center">
                                <span style="width: 80px" class="badge badge-success badge-pill">Active <i class="fa fa-check" style="color: green"></i></span>
                            </div>
                        </div>
                        <div class="row topfive-margin">
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xl-8 col-xs-8">

                                <h5>Abcnews.co.com</h5>

                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xl-4 col-xs-4 text-center">
                                <span style="width: 80px" class="badge badge-success badge-pill">Active <i class="fa fa-check" style="color: green"></i></span>
                            </div>
                        </div>

                    </div>
                    <div class="card-footer text-muted">
                        <button class="btn btn-primary text-white btn-md">More</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class=" col-lg-6">
                <div class="card ">
                    <div class="card-header bg-primary">
                        <h3 class="card-header-pills">Latest Downloads</h3>
                    </div>
                    <div class="card-body">

                    </div>

                </div>
            </div>
            <div class=" col-lg-6">
                <div class="card ">
                    <div class="card-header bg-primary">
                        <h3 class="card-header-pills">New Features</h3>
                    </div>
                    <div class="card-body">

                    </div>

                </div>
            </div>
        </div>
    </div>
    </div>
</section>

<!-- About Section -->
<section class="bg-primary text-white mb-0" id="about">
    <div class="container">
        <h2 class="text-center text-uppercase text-white">About</h2>
        <hr class="star-light mb-5">
        <div class="row">
            <div class="col-lg-4 ml-auto">
                <p class="lead">Tubepick Downloader is a 100% free web application that provides lots of methods to download high definition and standard definition videos and audios from websites like Facebook, Instagram, Vimeo, Vevo, Dailymotion, Soundcloud and many more.</p>
            </div>
            <div class="col-lg-4 mr-auto">
                <p class="lead">If you want to download a video or an audio then simply copy the URL of the page that has the video/audio you want to download. Put it in the download textbox above and simply click 'Download' button. Tubepick will generate all the possible download links from the URL that you provided.</p>
            </div>
        </div>
        <div class="text-center mt-4">
            <a class="btn btn-xl btn-outline-light" href="#">
                <i class="fa fa-download mr-2"></i>
                Download Now!
            </a>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section id="contact">
    <div class="container">
        <h2 class="text-center text-uppercase text-secondary mb-0">Contact Me</h2>
        <hr class="star-dark mb-5">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <!-- To configure the contact form email address, go to mail/contact_me.php and update the email address in the PHP file on line 19. -->
                <!-- The form should work on most web servers, but if the form is not working you may need to configure your web server differently. -->
                <form name="sentMessage" id="contactForm" novalidate="novalidate">
                    <div class="control-group">
                        <div class="form-group floating-label-form-group controls mb-0 pb-2">
                            <label>Name</label>
                            <input class="form-control" id="name" type="text" placeholder="Name" required="required" data-validation-required-message="Please enter your name.">
                            <p class="help-block text-danger"></p>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="form-group floating-label-form-group controls mb-0 pb-2">
                            <label>Email Address</label>
                            <input class="form-control" id="email" type="email" placeholder="Email Address" required="required" data-validation-required-message="Please enter your email address.">
                            <p class="help-block text-danger"></p>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="form-group floating-label-form-group controls mb-0 pb-2">
                            <label>Phone Number</label>
                            <input class="form-control" id="phone" type="tel" placeholder="Phone Number" required="required" data-validation-required-message="Please enter your phone number.">
                            <p class="help-block text-danger"></p>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="form-group floating-label-form-group controls mb-0 pb-2">
                            <label>Message</label>
                            <textarea class="form-control" id="message" rows="5" placeholder="Message" required="required" data-validation-required-message="Please enter a message."></textarea>
                            <p class="help-block text-danger"></p>
                        </div>
                    </div>
                    <br>
                    <div id="success"></div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-xl" id="sendMessageButton">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="footer text-center">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-5 mb-lg-0">
                <h4 class="text-uppercase mb-4">Location</h4>
                <p class="lead mb-0">2215 John Daniel Drive
                    <br>Clark, MO 65243</p>
            </div>
            <div class="col-md-4 mb-5 mb-lg-0">
                <h4 class="text-uppercase mb-4">Around the Web</h4>
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
                <h4 class="text-uppercase mb-4">About Freelancer</h4>
                <p class="lead mb-0">Freelance is a free to use, open source Bootstrap theme created by
                    <a href="http://startbootstrap.com">Start Bootstrap</a>.</p>
            </div>
        </div>
    </div>
</footer>

<div class="copyright py-4 text-center text-white">
    <div class="container">
        <small>Copyright &copy; Your Website 2018</small>
    </div>
</div>

<!-- Scroll to Top Button (Only visible on small and extra-small screen sizes) -->
<div class="scroll-to-top d-lg-none position-fixed ">
    <a class="js-scroll-trigger d-block text-center text-white rounded" href="#page-top">
        <i class="fa fa-chevron-up"></i>
    </a>
</div>

<?php } ?>

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



