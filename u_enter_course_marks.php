
<?php
/**
 * Created by PhpStorm.
 * User: Udhan
 * Date: 7/8/2018
 * Time: 5:36 PM
 */

if (session_status() == PHP_SESSION_NONE) {    session_start();}
require 'u_connection.php';

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

$course_id=$_SESSION['course_id'];
$student_query=$mysqli->query("SELECT * FROM course_registration WHERE course_id='$course_id'");

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
        <h2 class="text-center text-uppercase text-secondary mb-0">Course Marks</h2 class="text-center text-uppercase text-secondary mb-0">
        <hr class="star-dark mb-5">
        <div class="container">
            <div class="text-left ">

        <table class="table table-striped text-center">
            <thead>
            <tr class="text-white bg-dark" style="border: dimgray solid 10px; border-radius: 1px">
                <th>Registration Number</th>
                <th>Full Name</th>
                <th>Marks</th>
                <th>Attendance</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>



            <?php //require "u_search_courses.php";
            while ($student = mysqli_fetch_array($student_query, MYSQLI_NUM)) {
                $reg_no=$student[1];
                $course_registration_id=$student[0];

                $student_query_2=$mysqli->query("SELECT * FROM student_data WHERE registration_number='$reg_no'");
                $student_2=$student_query_2->fetch_assoc();
                $full_name=$student_2['full_name'];

                $student_query_3=$mysqli->query("SELECT * FROM attendance WHERE course_registration_id='$course_registration_id'");
                $student_3=$student_query_3->fetch_assoc();
                $attendance=$student_3['no_of_attendant'];
                $temp='';
                $course_mark_query=$mysqli->query("SELECT * FROM course_mark WHERE course_registration_id='$course_registration_id'");
                $no_of_rows=$course_mark_query->num_rows;
                ?>
               <tr>
                <td class="text-success font-weight-bold"><?php echo $reg_no?></td>
                <td class="text-success font-weight-bold"><?php echo $full_name?></td>
                   <td class="text-success font-weight-bold">
                       <?php
                          if($no_of_rows==1){
                              $course_mark=$course_mark_query->fetch_assoc();
                              $mark=$course_mark['marks'];
                              echo $mark;
                              $temp=1;
                          }else{
                              echo 'Not Graded';
                              $temp=0;
                          }
                       ?>

                   </td>


                   <div class="container">
                       <td><button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#popUpWindow2<?php echo $reg_no?>">View</button></td>
                       <!--                           <a href=""> <input class="btn btn-success btn-block" type="submit" value="Edit Marks"></a>-->
                       <div class="modal fade" id="popUpWindow2<?php echo $reg_no?>">
                           <div class="modal-dialog modal-dialog-centered">
                               <div class="modal-content">
                                   <div class="modal-header bg-topfive">
                                       <h3 class="modal-title">Attendance</h3>
                                       <button type="button" class="close" data-dismiss="modal">&times;</button>
                                   </div>
                                   <div class="modal-body" >

                                       <p><?php echo $attendance?></p>

                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>
<!--                   <td>-->
                   <div class="container">
                   <td>
                       <div class="row">
                       <div class="col-md">
                       <button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#popUpWindow<?php echo $reg_no?>">Edit Marks</button>
                       </div>

                    <?php if($no_of_rows==1){?>
                        <div class="col-md">

                            <form id="clear_form" role="form" action="u_clear_course_marks.php" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="course_registration_id" value="<?php echo $course_registration_id?>">
                                <button type="submit" class="btn btn-success btn-block">Clear Marks</button>
                            </form>
                        </div>

                   <?php }?>
                   </div></td>

                       <div class="modal fade" id="popUpWindow<?php echo $reg_no?>">
                           <div class="modal-dialog modal-dialog-centered">
                               <div class="modal-content">
                                   <div class="modal-header bg-topfive">
                                       <h3 class="modal-title">Grading</h3>
                                       <button type="button" class="close" data-dismiss="modal">&times;</button>
                                   </div>
                                   <div class="modal-body" >
                                       <form id="mark-form" role="form" action="u_upload_course_marks.php" method="POST" enctype="multipart/form-data">
                                           <div class="form-group">
                                               <input id="mark-model-input" type="number" min="0" max="100" class="form-control" placeholder="Marks" name="marks" required>
                                           </div>
                                           <input type="hidden" name="course_registration_id" value="<?php echo $course_registration_id?>">
                                           <input type="hidden" name="attendance" value="<?php echo $attendance?>">
                                           <input type="hidden" name="temp" value="<?php echo $temp?>">
                                           <div class="modal-footer" id="mark-model-btn">
                                               <button class="btn btn-primary btn-block">Submit</button>
                                           </div>
                                       </form>
                                   </div>

                               </div>
                           </div>
                       </div></div>

<!--                   </td>-->
               </tr>
                <?php

                }?>



            </tbody>
        </table></div></div>


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


</body>

</html>


