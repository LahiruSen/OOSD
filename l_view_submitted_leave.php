<?php
require 'db.php';
/* Displays user information and some useful messages */
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in using the session variable
if ($_SESSION['logged_in'] != 1) {
    $_SESSION['message'] = "You must log in before viewing your profile page!";
    header("location: error.php");
    die();
}

// Makes it easier to read
$first_name = $_SESSION['first_name'];
$last_name = $_SESSION['last_name'];
$email = $_SESSION['email'];
$active = $_SESSION['active'];
$types = $_SESSION['types'];
$two_step = $_SESSION['two_step'];
$user_id = $_SESSION['user_id'];


$employee_id_result = $mysqli->query("SELECT * FROM employee_data WHERE 	user_id='$user_id'");


if ($employee_id_result->num_rows > 0) {
    $employee_id_array = $employee_id_result->fetch_assoc();
    $employee_id = $employee_id_array['employee_id'];
    $employee_type_id = $employee_id_array['employee_type_id'];


    $leave_submissions = $mysqli->query("SELECT * FROM leave_submission WHERE 	employ_id='$employee_id' ");
    $records = array();


    if ($leave_submissions->num_rows > 0) {
        while ($row = $leave_submissions->fetch_object()) {
            $records[] = $row;
        }
        $leave_submissions->free();


    } else {

        $ismodel = 0; ?>
        <div class="modal fade  hidden" id="popUpWindow2">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">No Submissions</h3>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">

                        <p>You haven't submitted any leave applications.</p>
                    </div>
                    <div class="modal-footer">
                        <a class="text-light btn-block btn btn-primary"
                           href="home_employee.php">
                            <button class="btn btn-primary btn-block">Home</button>
                        </a>
                    </div>

                </div>
            </div>
        </div>
        </div>
        <?php


    }
    if ($types == 2) {
        $_SESSION['message'] = "You(Student) don't have access to this page!";
        header("location: error.php");
        die();


    }


} else {
    $_SESSION['message'] = "Invalid User !";
    header("location: error.php");
    die();

}


?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Vocational training center">
    <meta name="author" content="G27">
    <title>My Home : <?= $first_name . ' ' . $last_name ?></title>
    <?php include 'css/css.html'; ?>
</head>

<body id="page-top">


<?php if (!$active) { ?>

    <div class="form text-center">

        <h4 class="alert-heading">Please verify your account!</h4>
        <p>We have sent you a verification email to your email account. Please click verification link to verify your
            account!!!</p>
        <a href="logout.php">
            <button class="btn btn-group btn-lg">Logout</button>
        </a>

    </div>

<?php } else { ?>


    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg bg-secondary fixed-top text-uppercase" id="mainNav">
        <div class="container">
            <a class="navbar-brand js-scroll-trigger" href="#page-top">Emplup<i class="fa fa-user"></i></a>
            <button class="navbar-toggler navbar-toggler-right text-uppercase bg-primary text-white rounded"
                    type="button" data-toggle="collapse" data-target="#navbarResponsive"
                    aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                Menu
                <i class="fa fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <?php require 'navigation.php'; ?>
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
            <h2 class="text-center text-uppercase text-secondary mb-0">View Leave Submissions</h2>
            <hr class="star-dark mb-5">
            <div class="row">


                <div class=" col-lg-6">


                </div>

                <?php if ($_SESSION['two_step'] != 0) {

                if (isset($records)) {
                    // Teacher
                    if ($employee_type_id == 2) { ?>


                        <div class="container">


                            <table id="leave_submissions" class="table table-dark">


                                <tbody>

                                <tr>
                                    <th>Reason</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Principal</th>
                                    <th>HR</th>
                                    <th>Administrator</th>
                                    <th>Delete</th>
                                </tr>


                                <?php


                                foreach ($records as $r) { ?>


                                    <tr>
                                        <form action="l_delete_submitted_leave.php" method="post">


                                            <td><?php echo $r->reason_for_leave; ?></td>
                                            <td><?php echo $r->start_date; ?></td>
                                            <td><?php echo $r->end_date; ?></td>

                                            <td><?php if ($r->approved_by_principal == 0) {
                                                    echo 'Pending';
                                                } elseif ($r->approved_by_principal == 1) {
                                                    echo 'Approved';
                                                } elseif ($r->approved_by_principal == 2) {
                                                    echo 'Rejected';
                                                } else {
                                                    echo 'Error';
                                                }
                                                ?></td>
                                            <td><?php if ($r->approved_by_hr == 0) {
                                                    echo 'Pending';
                                                } elseif ($r->approved_by_hr == 1) {
                                                    echo 'Approved';
                                                } elseif ($r->approved_by_hr == 2) {
                                                    echo 'Rejected';
                                                } else {
                                                    echo 'Error';
                                                }


                                                ?></td>

                                            <td><?php if ($r->approved_by_admin == 0) {
                                                    echo 'Pending';
                                                } elseif ($r->approved_by_admin == 1) {
                                                    echo 'Approved';
                                                } elseif ($r->approved_by_admin == 2) {
                                                    echo 'Rejected';
                                                } else {
                                                    echo 'Error';
                                                }


                                                ?></td>


                                            <td><input class="btn btn-dark text-light" type="submit" value="delete"
                                                       name="delete"></td>


                                            <td><input type="hidden" value="<?php echo $r->id; ?>" name="leave_id">
                                            <td>


                                        </form>
                                    </tr>
                                <?php } ?>

                                </tbody>
                            </table>
                        </div>

                        <!--                        Principal-->
                    <?php } elseif ($employee_type_id == 3) {

                        ?>


                        <div class="container">


                            <table id="leave_submissions" class="table table-dark">


                                <tbody>

                                <tr>
                                    <th>Reason</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>HR</th>
                                    <th>Administrator</th>
                                </tr>


                                <?php


                                foreach ($records as $r) { ?>


                                    <tr>

                                        <form action="l_delete_submitted_leave.php" method="post">
                                        <td><?php echo $r->reason_for_leave; ?></td>
                                        <td><?php echo $r->start_date; ?></td>
                                        <td><?php echo $r->end_date; ?></td>


                                        <td><?php if ($r->approved_by_hr == 0) {
                                                echo 'Pending';
                                            } elseif ($r->approved_by_hr == 1) {
                                                echo 'Approved';
                                            } elseif ($r->approved_by_hr == 2) {
                                                echo 'Rejected';
                                            } else {
                                                echo 'Error';
                                            }


                                            ?></td>

                                        <td><?php if ($r->approved_by_admin == 0) {
                                                echo 'Pending';
                                            } elseif ($r->approved_by_admin == 1) {
                                                echo 'Approved';
                                            } elseif ($r->approved_by_admin == 2) {
                                                echo 'Rejected';
                                            } else {
                                                echo 'Error';
                                            }


                                            ?></td>


                                            <td><input class="btn btn-dark text-light" type="submit" value="delete"
                                                       name="delete"></td>


                                            <td><input type="hidden" value="<?php echo $r->id; ?>" name="leave_id">
                                            </td>

                                        </form>
                                    </tr>
                                <?php } ?>

                                </tbody>
                            </table>

                        </div>


                        <!--                        HR-->
                    <?php } elseif ($employee_type_id == 4) { ?>


                        <div class="container">

                            <table id="leave_submissions" class="table table-dark">


                                <tbody>

                                <tr>
                                    <th>Reason</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Administrator</th>
                                </tr>


                                <?php


                                foreach ($records as $r) { ?>


                                    <tr>

                                        <form action="l_delete_submitted_leave.php" method="post">
                                        <td><?php echo $r->reason_for_leave; ?></td>
                                        <td><?php echo $r->start_date; ?></td>
                                        <td><?php echo $r->end_date; ?></td>


                                        <td><?php if ($r->approved_by_admin == 0) {
                                                echo 'Pending';
                                            } elseif ($r->approved_by_admin == 1) {
                                                echo 'Approved';
                                            } elseif ($r->approved_by_admin == 2) {
                                                echo 'Rejected';
                                            } else {
                                                echo 'Error';
                                            }


                                            ?></td>

                                            <td><input class="btn btn-dark text-light" type="submit" value="delete"
                                                       name="delete"></td>


                                            <td><input type="hidden" value="<?php echo $r->id; ?>" name="leave_id">
                                            </td>


                                        </form>
                                    </tr>
                                <?php } ?>

                                </tbody>
                            </table>

                        </div>


                    <?php } else {


                        $_SESSION['message'] = "You are not able to submmit leave application thought this system";
                        header("location:error.php");
                        die();


                    } ?>


                <?php } ?>
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

<?php if ($_SESSION['two_step'] == 0) {


$user_result = $mysqli->query("SELECT * FROM users WHERE email='$email'") or die($mysqli->error());

if ($user_result->num_rows != 0)
{
$user_data = $user_result->fetch_assoc();
$user_result->free();
$user_id = $user_data['id'];
$employee_result = $mysqli->query("SELECT * FROM employee_data WHERE user_id='$user_id'") or die($mysqli->error());


if ($employee_result->num_rows != 0)
{
$employee_data = $employee_result->fetch_assoc();

$employee_result->free();

if ($employee_data['is_locked'] != 1)
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
                    Our system administrator should verify your profile information before giving access to EMPLUP
                    resources.
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
else {
    ?>

    <div class="modal fade" id="completeProfile">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content ">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title text-warning">Activation is pending <i
                                class="fa fa-exclamation-triangle"></i></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    Our system administrator should verify your profile information before giving access to EMPLUP
                    resources.
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
else {

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
                    Our system administrator should verify your profile information before giving access to EMPLUP
                    resources.
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

else {

    $_SESSION['message'] = "You are not a valid user";
    header("location:error.php");
    die();
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

<?php }
} ?>


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

<?php
if ($ismodel == 0) { ?>


    <script>
        type = "text/javascript" >
            $(window).on('load', function () {
                $('#popUpWindow2').modal('show');
            });
    </script>

    <?php
}
?>



<?php
if ($_SESSION['two_step'] == 0) {
    ?>

    <script>
        $(document).ready(function () {
            $('#completeProfile').modal('show');
        });

    </script>

<?php } ?>

</body>
</html>