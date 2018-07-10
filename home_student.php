
<?php
/* Displays user information and some useful messages */
require 'db.php';
if (session_status() == PHP_SESSION_NONE) {    session_start();}

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
    $two_step= $_SESSION['two_step'];


    if($types == 1)
    {
        header("location: home_employee.php");
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

<?php } else {


if($two_step==1)
{
    $user_id =  $_SESSION['user_id'];

    $messager_result = $mysqli->query("SELECT title,description FROM notifications WHERE target_user_ids='$user_id' and delete_receiver='0' ORDER BY date_of_create DESC LIMIT 5");

    if($messager_result->num_rows>0)
    {
        $meesages = array();

        while($row=$messager_result->fetch_assoc())
        {
            $meesages[] =$row;
        }

    }else
    {

        $meesages = array();


    }







}
    ?>


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
            <h2 style="font-size:50px" class="text-dark mb-2">Student</h2>
            <h4 class=" font-weight-light mb-0">Vocational Trainings - Student Management - Employee Management</h4>
        </div>

    </header>

    <!-- Dashboard Section -->
    <section class="" id="portfolio">
        <div class="container ">
            <h2 class="text-center text-uppercase text-secondary mb-0">Dashboard</h2>
            <hr class="star-dark mb-5">
            <div class="row">

                <div class="col-lg-6 ">


                    <h1 class="display-4">What do Student get?</h1>
                    <p class="lead">Please some one give brief introduction in here [TASK]</p>
                    <hr class="my-4">
                    <p class="bg-topfive-text"><i class="fa fa-circle"></i>   Point 1 [TASK]</p>
                    <p class="bg-topfive-text"><i class="fa fa-circle"></i>   Point 2 [TASK]</p>
                    <p class="bg-topfive-text"><i class="fa fa-circle"></i>   Point 3 [TASK]</p>
                    <p class="bg-topfive-text"><i class="fa fa-circle"></i>   Point 4 [TASK]</p>

                    <p class="lead">
                        <a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a>
                    </p>


                </div>
                <div class=" col-lg-6">
                    <div class="card card-style">
                        <div class="card-header bg-topfive">
                            <h3 class="card-header-pills">Messages</h3>
                        </div>
                        <div class="card-body">

                            <?php if($_SESSION['two_step'] == 0) { ?>
                                <div class="row topfive-margin">
                                    <div class="col-lg-12">

                                        <h2>This section will automatically enable after getting approval for your profile!</h2>

                                    </div>

                                </div>
                            <?php }else { ?>

                                <?php if (count($meesages) > 0) {
                                    $xi =0;
                                    foreach ($meesages as $m) { $xi++;  ?>
                                        <div class="card">
                                            <div class="card-header bg-secondary">
                                                <h5 class="text-white"><?= $xi ?>. <?= $m['title'] ?></h5>
                                            </div>
                                            <div class="card-body m-2">
                                                <div class="row">
                                                    <p class="bg-topfive-text"><?= $m['description'] ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    <?php }
                                } else { ?>
                                    <div class="row topfive-margin">
                                        <div class="col-lg-12">

                                            <h2>No messages to display</h2>

                                        </div>

                                    </div>

                                <?php }
                            }?>

                        </div>

                        <?php if($_SESSION['two_step'] != 0) { ?>
                            <div class="card-footer text-muted">
                                <a href="notification_list_inbox.php"><button class="btn btn-primary text-white btn-md">More</button></a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="row">

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
                    <h4>Our Vision</h4>
                    <p class="lead">To become the most efficient training providing organization effectively contributing to achieve prosperity in Sri Lanka through Human Resource Development.</p>
                </div>
                <div class="col-lg-4 mr-auto">
                    <h4>Our Mission</h4>
                    <p class="lead">Providing vocational and Technical Training for youth, to acquire employable skills through well formulated skills programs with highest professional Standards to meet the skilled manpower requirement in the industry.</p>
                </div>
            </div>


        </div>
    </section>

    <!--Model-->

<?php if($_SESSION['two_step'] == 0) { ?>
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

<?php } ?>
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



<?php if($_SESSION['two_step'] == 0) { ?>
    <script >
        $( document ).ready(function() {
            $('#completeProfile').modal('show');
        });

    </script>

<?php } ?>


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



