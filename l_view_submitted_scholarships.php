<?php
/* Reset your password form, sends reset.php password link */
require 'db.php';
session_start();


$email = $_SESSION['email'];
$result = $mysqli->query("SELECT id FROM users WHERE email='$email'");


// Check if user is logged in using the session variable
if ($_SESSION['logged_in'] != 1) {
    $_SESSION['message'] = "You must log in before viewing your profile page!";
    header("location: error.php");
    die();
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
        die();
    }

}

if ($result->num_rows == 0) // User doesn't exist
{
    $_SESSION['message'] = "This user detail doesn't exist in the system.";
    header("location: error.php");
    die();
}
else { // User exists (num_rows != 0)

    $user = $result->fetch_assoc(); // $user becomes array with user data

    $user_id = $user['id'];
    $result_new = $mysqli->query("SELECT * FROM employee_data WHERE user_id='$user_id' ");

    if ($result_new->num_rows == 0) {
        $_SESSION['message'] = "Not a valid user";
        header("location:error.php");
        die();
    }

    else {
        $employee = $result_new->fetch_assoc(); // employ become arry with employ data
        $employee_type_id = $employee['employee_type_id'];

        if ($employee_type_id == 1) {


        $schol_submission_result = $mysqli->query("SELECT * FROM scholarship_submissions ORDER BY  scholarship_id");

        if ($schol_submission_result->num_rows==0) {
            $_SESSION['message'] = "No Scholarship Applications are submmitted yet";
            header("location:error.php");
            die();
        } else {




                $submission_records = array();

                while ($row = mysqli_fetch_array($schol_submission_result, MYSQLI_NUM)) {

                    $student_registration_number = $row[1];
                    $pdf_url = $row[2];
                    $scholarship_type_id = $row[3];
                    $submission_id = $row[0];



                    $scholarship_title_result = $mysqli->query("SELECT * FROM  scholarships WHERE id= '$scholarship_type_id'");


                    if ($schol_submission_result->num_rows>0) {


                        $scholarship_title_array = $scholarship_title_result->fetch_assoc();

                        $scholarship_title = $scholarship_title_array['title'];
                    } else {


                        $_SESSION['message'] = "This Scholarship is not available any longer.";
                        header("location:error.php");
                        die();
                    }



                    $submission_records[] = array($scholarship_title,$student_registration_number, $pdf_url,$submission_id);


                }




        }
    }
    else{
        $_SESSION['message'] = "You are not allowed to view submitted scholarship applications.";
        header("location:error.php");
        die();
    }




    }


}


// Check if form submitted with method="post"
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
        <p>We have sent you a verification email to your email account. Please click verification link to verify
            your account!!!</p>
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
            <h2 style="font-size:50px" class="text-dark mb-2">Student</h2>
            <h4 class=" font-weight-light mb-0">Vocational Trainings - Student Management - Employee
                Management</h4>
        </div>

    </header>

    <!-- Dashboard Section -->
    <section class="" id="portfolio">
        <div class="container ">
            <h2 class="text-center text-uppercase text-secondary mb-0">View Scholarship Submissions</h2>
            <hr class="star-dark mb-5">
            <div class="row">


            </div>
        </div>

    </section>


    <div class=" container">
        <div>
            <table id="level_mark" class="table table-dark">
                <tr>
                    <th>Scholarship Title</th>
                    <th>Registration No. of Student</th>
                    <th>PDF </th>
                    <th>Delete</th>

                </tr>
                <tbody>
                <?php foreach ($submission_records as $sr){ ?>
                    <tr>
                        <td><?php echo $sr[0] ?></td>
                        <td><?php echo $sr[1] ?></td>
                        <td><button class="btn btn-dark " ><a href="<?php echo $sr[2] ?>" target="_blank">View</a></button></td>
                        <td><button class="btn btn-dark" data-toggle="modal" data-target="#popUpWindow_<?=$sr[1]?>" >Delete</button></td>
                    </tr>



                    <div class="modal fade" id="popUpWindow_<?=$sr[1]?>">
                        <form action="l_delete_submitted_scholarship.php" method="post">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title">ARE YOU SURE?</h3>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body" >
                                    <input type="hidden" name="scholarship_id" value="<?php echo $sr[3] ?>">
                                    <p>Select Delete if you want to delete this submission.</p>

                                </div>
                                <div class="modal-footer">
                                    <input class='button button-block' type="submit" value="Delete">
                                </div>

                            </div>
                        </div>
                        </form>
                    </div>

                <?php } ?>
                </tbody>
            </table>


        </div>

    </div>



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

<?php if ($_SESSION['two_step'] == 0) { ?>
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
                    Our system administrator should verify your profile information before giving access to
                    EMPLUP resources.
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
    <script type="text/javascript"
            src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5aa8ad68cc6156e6"></script>

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


<?php if ($_SESSION['two_step'] == 0) { ?>
    <script>
        $(document).ready(function () {
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

