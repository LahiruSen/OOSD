
<?php
/* Displays user information and some useful messages */
require 'db.php';
if (session_status() == PHP_SESSION_NONE) {    session_start();}

// Check if user is logged in using the session variable
if ( $_SESSION['logged_in'] != 1 ) {
    $_SESSION['message'] = "You must log in before viewing your profile page!";
    header("location: error.php");
}
elseif($_SESSION['active'] != 1)
{
    $_SESSION['message'] = "We have sent you a verification email to your email account. Please click verification link to verify your account!!!";
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



    if ($types == 2) {
        header("location: home_student.php");
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

<?php } else { if($two_step ==1)
{



if ($_SERVER['REQUEST_METHOD'] == 'POST')
{

    if (isset($_POST['academic_year_id']) && isset($_POST['title'])&& isset($_POST['description']))
    {

        if((is_int($_POST['academic_year_id']) || ctype_digit($_POST['academic_year_id'])) && (int)$_POST['academic_year_id'] > 0)
        {
            $academic_year_id = $_POST['academic_year_id'];
            $title = $_POST['title'];
            $description = $_POST['description'];


            $student_result_to_send = $mysqli->query("select * from student_data where registered_ayear_id='$academic_year_id'");

            if($student_result_to_send->num_rows !=0)
            {



                $student_data_to_send = array();

                while($row = $student_result_to_send->fetch_assoc())
                {
                    $student_data_to_send[] = $row;
                }





            }else
            {
                $_SESSION['message'] = "There is no students which are registered with the academic year";
                header("location:error.php");

            }



        }else
        {
            $_SESSION['message'] = "Academic year id should be an integer";
            header("location:error.php");


        }


    }else
    {
        $_SESSION['message'] = "No valid parameters";
        header("location:error.php");

    }


}else
{

    $_SESSION['message'] = "Invalid request!";
    header("location:error.php");
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
            <h2 style="font-size:50px" class="text-dark mb-2">Send Notification <i class="fa fa-graduation-cap"></i> </h2>

        </div>

    </header>

    <!-- Dashboard Section -->
    <section class="" id="portfolio">
        <div class="container ">


            <div class="row text-center">
                <div class="col-lg-12  col-xl-12">
                    <h3 class="text-center text-uppercase text-secondary mb-0">Select Student(s)</h3>
                    <hr class="star-dark mb-5">
                    <div id="two_step_submission_form" class="two_step_form"  >
                        <div class="container">
                            <form method="post" action="">
                                <div class="text-left ">
                                    <div id="form_section_header" class="bg-topfive">
                                        <h2 class="text-white"> Notification Details</h2>
                                    </div>
                                    <div class="row m-2">
                                        <div class=" form-group col-lg-12 col-md-12">
                                            <label class="text-dark" for="title">Title</label>
                                            <input id="title" name="title" class="text-dark" value="<?= $title ?>" readonly >

                                        </div>
                                    </div>
                                    <div class="row m-2">
                                        <div class=" form-group col-lg-12 col-md-12">
                                            <label class="text-dark" for="description">Description</label>
                                            <textarea rows="10" class="textarea_expand text-dark"  readonly type="text" id="description" name="description" required  ><?= $description ?></textarea>

                                        </div>
                                    </div>
                                    <div id="form_section_header" class="bg-topfive">
                                        <h2 class="text-white">Receivers</h2>
                                    </div>

                                    <div class="row m-2">

                                        <div class="form-group col-lg-12 col-md-12">

                                            <div class="m-2">
                                                <h4 class="text-dark">Students</h4>
                                            </div>

                                            <div class="row m-2">
                                                <div class="col-lg-10 col-xl-10">
                                                    <div class="input-group date">
                                                        <label class="text-dark" for="student_id">Select students</label>
                                                        <select class="student_multi_search" id="student_id" name="student_id[]" multiple="multiple">

                                                            <?php for ( $i=0;$i<count($student_data_to_send);$i++ ) {  ?>

                                                                <option  value="<?php echo($student_data_to_send[$i]['user_id']) ?>"><?php if($student_data_to_send[$i]['registration_number'] == null){$regno ="no registration";}else{$regno=$student_data_to_send[$i]['registration_number'];}  echo($regno.'-'.$student_data_to_send[$i]['full_name']) ?> </option>

                                                            <?php } ?>

                                                        </select>

                                                    </div>
                                                </div>
                                                <div class="col-lg-2 col-xl-2" style="width: 100%">
                                                    <label class="text-dark" for="checkbox" ><strong>Select all</strong></label>
                                                    <input type="checkbox" id="checkbox" style="width: 60px;height: 60px;">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="text-center mt-4 w-100">
                                                    <button name="student" type="submit" class="btn btn-lg btn-primary" formaction="student_submit_notification.php" >Send</button>
                                                </div>
                                            </div>
                                        </div>



                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
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

    <!-- Model -->
    <div class="modal fade" id="academic_level_view">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content ">

                <!-- Modal Header -->
                <div id="modal_head_div" class="modal-header">
                    <h4 id="al_title" class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="m-2">
                        <div class="row ">
                            <label class="text-dark" for="al_description">Description</label>
                        </div>
                        <div class="row">
                            <p id="al_description"></p>
                        </div>

                    </div>
                    <div class="m-2">
                        <div class="row">
                            <label class="text-dark" for="al_registration_deadline">Registration deadline</label>
                        </div>
                        <div class="row">
                            <p style="font-size: 20px" id="al_registration_deadline"></p>
                        </div>
                    </div>

                    <div class="m-2">
                        <div class="row">
                            <label class="text-dark" for="al_registration_level_type">Academic Level</label>
                        </div>
                        <div class="row">
                            <p style="font-size: 30px" id="al_registration_level_type"></p>
                        </div>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-lg-4">
                            <a href="" id="al_update_btn"  class="btn btn-success" data-dismiss="modal">Update</a>
                        </div>
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

    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5aa8ad68cc6156e6"></script>

    <?php

} else
{

    if ($_SESSION['types'] == 1) {

        header('location: home_employee.php');
    } else {
        header('location: home_student.php');
    }

}
}
?>


<!-- Bootstrap core JavaScript -->
<script src="js/jquery.min.js"></script>
<script src="js/moment.min.js"></script>
<script type="text/javascript" src="js/tempusdominus-bootstrap-4.min.js"></script>

<script src="js/bootstrap.bundle.min.js"></script>

<!-- Plugin JavaScript -->
<script src="js/jquery.easing.min.js"></script>
<script src="js/jquery.magnific-popup.min.js"></script>

<!-- Contact Form JavaScript -->
<script src="js/jqBootstrapValidation.min.js"></script>

<script src="js/contact_me.js"></script>
<!-- Custom scripts for this template -->
<script src="js/freelancer.js"></script>
<script src="js/select2.min.js"></script>



<!--custom-->
<script type="text/javascript">

    $(document).ready(function() {
        $('#student_id').select2();
    });

    $("#checkbox").click(function(){
        if($("#checkbox").is(':checked') ){
            $("#student_id > option").prop("selected","selected");// Select All Options
            $("#student_id").trigger("change");// Trigger change to select 2
        }else{
            $("#student_id > option").removeAttr("selected");
            $("#student_id").trigger("change");// Trigger change to select 2
        }
    });



</script>



</body>
</html>


