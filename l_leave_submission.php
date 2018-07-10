<?php
/* Reset your password form, sends reset.php password link */
require 'db.php';
if (session_status() == PHP_SESSION_NONE) {    session_start();}

if ($_SESSION['logged_in'] != 1) {
    $_SESSION['message'] = "You must log in before viewing your profile page!";
    header("location: error.php");
} else {
    // Makes it easier to read
    $first_name = $_SESSION['first_name'];
    $last_name = $_SESSION['last_name'];
    $email = $_SESSION['email'];
    $active = $_SESSION['active'];
    $types = $_SESSION['types'];
    $two_step = $_SESSION['two_step'];

    if ($types == 2) {
        header("location: home_student.php");
    } else {

// Check if form submitted with method="post"
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {   // set variables to be inserted to database

            $reason = $mysqli->escape_string($_POST['reason']);
            $description = $mysqli->escape_string($_POST['description']);
            $start_date = $mysqli->escape_string($_POST['start_date']);
            $end_date = $mysqli->escape_string($_POST['end_date']);
            $date_of_create = $mysqli->escape_string(date("Y-m-d H:i:s"));
            $date_of_update = $mysqli->escape_string(date("Y-m-d H:i:s"));

            $datetime1 = new DateTime($start_date);
            $datetime2 = new DateTime($end_date);

            $number_of_dates = 1+$datetime2->diff($datetime1)->d;

            if (!preg_match("/^[a-zA-Z ]*$/", $reason)) {
                $_SESSION['message'] = "Reason can only contain letters";
                header("location: error.php");
                die();
            }

//            if (!preg_match("/^[a-zA-Z0-9. ]*$/", $description)) {
//                $_SESSION['message'] = "Description can only contain letters and numbers";
//                header("location: error.php");
//                die();
//            }




            $email = $_SESSION['email'];
            $result = $mysqli->query("SELECT id FROM users WHERE email='$email'");

            if ($result->num_rows == 0) // User doesn't exist
            {
                $_SESSION['message'] = "This user detail doesn't exist in the system.";
                header("location: error.php");
                die();
            } else { // User exists (num_rows != 0)

                $user = $result->fetch_assoc(); // $user becomes array with user data

                $user_id = $user['id'];
                $result_new = $mysqli->query("SELECT employee_id,	employee_type_id FROM employee_data WHERE user_id='$user_id' ");


                if ($result_new->num_rows == 0) {
                    $_SESSION['message'] = "This employ detail doesn't exist in the system.";
                    header("location: error.php");
                    die();
                } else {
                    $employee = $result_new->fetch_assoc(); // employ become arry with employ data
                    $employee_id = $employee['employee_id'];
                    $employee_type_id = $employee['employee_type_id'];
                    //teacher

                    if(	$employee_type_id==2) {

                        $sql = "INSERT INTO leave_submission (employ_id, reason_for_leave, description, number_of_dates, start_date, end_date, date_of_create,date_of_update) "
                            . "VALUES ('$employee_id','$reason','$description','$number_of_dates', '$start_date', '$end_date','$date_of_create','$date_of_update')";
                    }
                   // principal
                    elseif($employee_type_id==3){
                        $sql = "INSERT INTO leave_submission (employ_id, reason_for_leave, description, number_of_dates, start_date, end_date, date_of_create,date_of_update,approved_by_principal) "
                            . "VALUES ('$employee_id','$reason','$description','$number_of_dates', '$start_date', '$end_date','$date_of_create','$date_of_update',1)";

                //HR
                    }
                    elseif($employee_type_id==4){
                        $sql = "INSERT INTO leave_submission (employ_id, reason_for_leave, description, number_of_dates, start_date, end_date, date_of_create,date_of_update,approved_by_principal,	approved_by_hr) "
                            . "VALUES ('$employee_id','$reason','$description','$number_of_dates', '$start_date', '$end_date','$date_of_create','$date_of_update',1,1)";



                    }

                    else{
                        $_SESSION['message'] = "You're not able to upload leave applications";
                        header("location: error.php");
                        die();

                    }

                    if ($mysqli->query($sql)) {

                        $_SESSION['message'] = "Your leave application was uploaded successfully";
                        header("location: success.php");
                        die();

                    } else {
                        $_SESSION['message'] = "Sorry. Your application could not be uploaded";
                        header("location: error.php");
                        die();
                    }

                }

            }
        }
    }
} ?>
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
        <h4 class="font-weight-light mb-0">Vocational Trainings - Student Management - Employee Management</h4>
    </div>

</header>


<body>

<div class="form">

    <h1>Apply for leave</h1>

    <form action="l_leave_submission.php" method="post">
        <div class="field-wrap">

            <label>
                Reason for Leave<span class="req"  >*</span>
            </label>
            <input type="text" name="reason"  required>
            <label>
                Description<span class="req">*</span>
            </label>
            <textarea name='description' value='Please describe the reason briefly.' rows="4" cols="50" pattern="[A-Za-z ]+" required></textarea>
            <label>
                Start Date<span class="req">*</span>
            </label>
            <input  id="start_date" required type="date" name="start_date" max="2018-12-31" min="<?php echo date('Y-m-d'); ?>" >
            <label>
                End Date<span class="req">*</span>
            </label>
            <input id="end_date" required type="date" name="end_date" max="2018-12-31" >
        </div>
        <button class="button button-block"/>
        Apply </button>
    </form>
</div>

<script src='js/jquery.min.js'></script>
<script src="js/index.js"></script>
</body>


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

   $("#start_date").on("change", function() {
        var v= $(this).val();
        $('#end_date').attr('min',v);
    });


</script>


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




