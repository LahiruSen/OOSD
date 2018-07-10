<?php


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
    $two_step= $_SESSION['two_step'];


    if($types == 1)
    {
        header("location: home_employee.php");
    }

}

//$user_id=$_SESSION['user_id'];
//$student_query=$mysqli->query("SELECT * FROM student_data WHERE user_id='$user_id' ");
//$student=$student_query->fetch_assoc();
//
//$reg_no=$student['registration_number'];
//$_SESSION['reg_no']=$reg_no;
//
//$first_name = $_SESSION['first_name'];
//$last_name = $_SESSION['last_name'];
//
//$course_query=$mysqli->query("SELECT * FROM course_registration WHERE registration_number='$reg_no' AND is_approved=1");
//$no_of_courses=$courrse_query->num_rows;
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
            <h2 style="font-size:50px" class="text-dark mb-2">Student</h2>
            <h4 class=" font-weight-light mb-0">Vocational Trainings - Student Management - Employee Management</h4>
        </div>

    </header>

    <!-- Dashboard Section -->
    <section class="" id="portfolio">
        <div class="container">
            <div class="row text-center">
                <div class="col-lg-12  col-xl-12">
                    <h3 class="text-center text-uppercase text-secondary mb-0">My recently enrolled courses</h3>
                    <hr class="star-dark mb-5">
                    <div class="container">
                        <div class="text-left ">
                            <table class="table table-striped text-center">
                                <thead>
                                <tr class="text-white bg-dark" style="border: dimgray solid 10px; border-radius: 1px">
                                    <th>Level</th>
                                    <th>Course Title</th>
                                    <th>Course Id</th>
                                    <th class="text-center">Action</th>
                                </tr>
                                </thead>
                                <tbody>



                                <?php require "A_search_courses.php";

                                while ($course = mysqli_fetch_array($course_query_student,MYSQLI_NUM)) {
                                    $course_id=$course[5];
                                    $result5=$mysqli->query("SELECT * FROM courses WHERE course_id='$course_id'");
                                    $my_course=$result5->fetch_assoc();//course2

                                    $level_id=$my_course['level_id'];
                                    $level_query=$mysqli->query("SELECT * FROM level WHERE id='$level_id'");
                                    $level=$level_query->fetch_assoc();

                                    $current_date = date('Y-m-d H:i:s');
                                    $deadline=$level['deadline'];

                                    $interval = strtotime($deadline)-strtotime($current_date);
                                    ?>
                                    <?php if($interval>=0){?>
                                    <tr>
                                        <td class="text-success font-weight-bold"><?php echo $level['title'];?></td>
                                        <td class="text-success font-weight-bold"><?php echo $my_course['title'];?></td>
                                        <td class="text-success font-weight-bold"><?php echo $my_course['course_id'];?></td>

                                        <td class="text-center">
                                            <div class="btn-group" role="group" >
                                                <a data-regno="<?=$student_reg_no?>" data-course="<?=$course_id?>" class="enroll_view btn btn-info" > Unenroll</a>
                                            </div>
                                        </td>
                                    </tr>

                                    <?php }
                                }

                                ?>


                                </tbody>
                            </table></div>
                    </div></div></div>
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

    <div class="modal fade" id="academic_level_view">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content ">

                <!-- Modal Header -->
                <div id="modal_head_div" class="modal-header">
                    <h4 id="al_title" class="modal-title">Are you sure?</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>



                <!-- Modal footer -->
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-lg-4">
                            <a href="" id="al_delete_btn"  class="btn btn-danger" data-dismiss="modal">Delete</a>
                        </div>
                        <div class="col-lg-4 ">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>



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


<script type="text/javascript">


    $(document.body).on('click', '.enroll_view' ,function()
    {

        regno = $(this).data('regno');
        course = $(this).data('course');




        $('#academic_level_view #modal_head_div').addClass('bg-primary');


        $('#academic_level_view #al_delete_btn').click(function(){
            window.location.href='A_enroll_unenroll.php?course='+course+'&regno='+regno;
        });

        $('#academic_level_view').modal('show');


    });


</script>


</body>

</html>

