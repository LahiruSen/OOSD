
<?php
/* Displays user information and some useful messages */
require 'db.php';
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

<?php } else { if($two_step ==1) {
    $current_employee_type_result = $current_user_info_result = $mysqli->query("select DISTINCT employee_types.title,employee_types.id from employee_types, users, employee_data where users.email = '$email' and employee_types.id = employee_data.employee_type_id") or die($mysqli->error());
    if($current_employee_type_result->num_rows !=0)
    {
        $current_employee_type_data = $current_employee_type_result->fetch_assoc();
        $current_employee_type_result->free();
        $type_of_employment = $current_employee_type_data['title'];
    }



    $all_accedemic_years_result  =  $mysqli->query("select * from academic_year") or die($mysqli->error());

    if($all_accedemic_years_result->num_rows !=0) {
        $all_accedemic_years_data = array();

        while ($row = $all_accedemic_years_result->fetch_assoc())
        {
            $all_accedemic_years_data[] = $row;
        }

        $all_accedemic_years_result->free();
    }
    //THE RULE WILL CHANGE IN HERE DUE TO RULES

    if($type_of_employment == 'Administrator'){
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
            <h2 style="font-size:50px" class="text-dark mb-2">Academic Years <i class="fa fa-graduation-cap"></i> </h2>

        </div>

    </header>

    <!-- Dashboard Section -->
    <section class="" id="portfolio">
        <div class="container ">


            <div class="row text-center">
                        <div class="col-lg-8 col-md-8  col-xl-8">
                            <h3 class="text-center text-uppercase text-secondary mb-0">Create New</h3>
                            <hr class="star-dark mb-5">
                            <form id="two_step_submission_form" class="two_step_form" action="#" method="post">
                                <div class="container">
                                    <div class="text-left ">
                                        <div id="form_section_header" class="bg-topfive">
                                            <h2 class="text-white"> Basic information </h2>
                                        </div>
                                        <div class="row m-2">
                                            <div class=" form-group col-lg-12 col-md-12">
                                                <label class="text-dark" for="title">Title</label>
                                                <input  class="text-dark <?php if(isset($error_array) && array_key_exists('title',$error_array))  { echo('text-danger');} ?>" type="text" id="title" name="title" required <?php if(isset($old)){echo 'value="'.$old['title'].'"';} ?> >

                                                <?php if(isset($error_array) && array_key_exists('title',$error_array))  {?>
                                                    <div class="row">
                                                        <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                                            <small id="passwordHelp" class="text-danger">
                                                                <?= $error_array['title'] ?>
                                                            </small>
                                                        </div>
                                                    </div>
                                                <?php } ?>

                                            </div>
                                        </div>
                                        <div class="row m-2">
                                            <div class=" form-group col-lg-12 col-md-12">
                                                <label class="text-dark" for="description">Description</label>
                                                <textarea rows="10" class="textarea_expand text-dark <?php if(isset($error_array) && array_key_exists('description',$error_array))  { echo('text-danger');} ?>" type="text" id="description" name="description" required <?php if(isset($old)){echo 'value="'.$old['description'].'"';}?> ></textarea>

                                                <?php if(isset($error_array) && array_key_exists('description',$error_array))  {?>
                                                    <div class="row">
                                                        <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                                            <small id="passwordHelp" class="text-danger">
                                                                <?= $error_array['description'] ?>
                                                            </small>
                                                        </div>
                                                    </div>
                                                <?php } ?>

                                            </div>
                                        </div>
                                        <div id="form_section_header" class="bg-topfive">
                                            <h2 class="text-white">Academic Year Duration</h2>
                                        </div>
                                        <div class="row m-2">
                                            <div class="form-group col-lg-6 col-md-6" >
                                                <label class="text-dark" for="from_date">Start date</label>
                                                <input type="text" id="datetimepicker3" data-toggle="datetimepicker" data-target="#datetimepicker3"  class="form-control datetimepicker-input text-dark <?php if(isset($error_array) && array_key_exists('from_date',$error_array))  { echo('text-danger');} ?>"  name="from_date" required <?php if(isset($old)){echo 'value="'.$old['from_date'].'"';} ?> placeholder="from date here">

                                                <?php if(isset($error_array) && array_key_exists('from_date',$error_array))  {?>
                                                    <div class="row">
                                                        <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                                            <small id="passwordHelp" class="text-danger">
                                                                <?= $error_array['from_date'] ?>
                                                            </small>
                                                        </div>
                                                    </div>
                                                <?php } ?>

                                            </div>

                                            <div class="form-group col-lg-6 col-md-6" >
                                                <label class="text-dark" for="datetimepicker4">End date</label>
                                                <input  type="text" id="datetimepicker4" data-toggle="datetimepicker" data-target="#datetimepicker4"  class="form-control datetimepicker-input text-dark <?php if(isset($error_array) && array_key_exists('to_date',$error_array))  { echo('text-danger');} ?>"  name="to_date" required <?php if(isset($old)){echo 'value="'.$old['to_date'].'"';} ?>  placeholder="End date here">

                                                <?php if(isset($error_array) && array_key_exists('to_date',$error_array))  {?>
                                                    <div class="row">
                                                        <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                                            <small id="passwordHelp" class="text-danger">
                                                                <?= $error_array['to_date'] ?>
                                                            </small>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div id="form_section_header" class="bg-topfive">
                                            <h2 class="text-white">Registration Settings</h2>
                                        </div>
                                        <div class="row m-2">
                                            <div class=" form-group col-lg-6 col-md-6">

                                                <div class='input-group date'>
                                                    <label class="text-dark" for="datetimepicker1">Student registration deadline</label>
                                                    <input type="text" id="datetimepicker1" data-toggle="datetimepicker" data-target="#datetimepicker1"  class="form-control datetimepicker-input text-dark <?php if(isset($error_array) && array_key_exists('registration_deadline',$error_array))  { echo('text-danger');} ?>"  name="registration_deadline" required <?php if(isset($old)){echo 'value="'.$old['registration_deadline'].'"';} ?> placeholder="Fill here">
                                                </div>

                                                <?php if(isset($error_array) && array_key_exists('registration_deadline',$error_array))  {?>
                                                    <div class="row">
                                                        <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                                            <small id="passwordHelp" class="text-danger">
                                                                <?= $error_array['registration_deadline'] ?>
                                                            </small>
                                                        </div>
                                                    </div>
                                                <?php } ?>

                                            </div>

                                            <div class=" form-group col-lg-6 col-md-6">
                                                <div class='input-group date' >
                                                    <label class="text-dark" for="datetimepicker2">Course registration deadline</label>
                                                    <input type="text"  id="datetimepicker2" data-toggle="datetimepicker" data-target="#datetimepicker2"  class="form-control datetimepicker-input text-dark <?php if(isset($error_array) && array_key_exists('course_deadline',$error_array))  { echo('text-danger');} ?>" type="text"  id="datetimepicker2" name="course_deadline" required <?php if(isset($old)){echo 'value="'.$old['course_deadline'].'"';} ?> placeholder="Fill here" >
                                                </div>
                                                <?php if(isset($error_array) && array_key_exists('course_deadline',$error_array))  {?>
                                                    <div class="row">
                                                        <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                                            <small id="passwordHelp" class="text-danger">
                                                                <?= $error_array['course_deadline'] ?>
                                                            </small>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </div>


                                        </div>
                                        <div class="row m-2">
                                            <div class="text-center mt-4 w-100">
                                                <button name="create_new_ay" type="submit" class="btn btn-xl btn-outline-primary" >Create</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>


                        <div class="col-lg-4 col-md-4 col-xl-4">
                            <h3 class="text-center text-uppercase text-secondary mb-0">List</h3>
                            <hr class="star-dark mb-5">
                            <div class="container">
                                <div class="text-left two_step_form">

                                    <?php if(isset($all_accedemic_years_data)) { ?>
                                        <ul class="list-group">
                                            <?php for($k=0;$k< count($all_accedemic_years_data);$k++){ ?>

                                            <li class=" btn list-group-item list-group-item-action text-dark  font-weight-bold"><?= $all_accedemic_years_data[$k]['title']?> <i class="  <?php if($all_accedemic_years_data[$k]['status'] == -1){echo ('text-warning');}elseif($all_accedemic_years_data[$k]['status'] == 1){echo ('text-success');}elseif($all_accedemic_years_data[$k]['status'] == 0){echo ('text-dark');}?>  fa fa-graduation-cap"><?php if($all_accedemic_years_data[$k]['status'] == 1){echo ('');} ?></i></li>

                                            <?php } ?>
                                        </ul>
                                    <?php } else { ?>


                                        <div class="jumbotron jumbotron-fluid bg-topfive">
                                            <div class="container">
                                                <h1>Can't Find Any Academic years</h1>
                                                <p>Please create a new academic year!</p>
                                            </div>
                                        </div>

                                   <?php } ?>


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
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5aa8ad68cc6156e6"></script>

<?php } else
    {
        if ($_SESSION['types'] == 1) {

            header('location: home_employee.php');
        } else {
            header('location: home_student.php');
        }
    }

} else {

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



<!--custom-->

<script type="text/javascript">

    $('textarea.textarea_expand').focus(function () {
        $(this).animate({ height: "184px" }, 1000);
    });

    $('#datetimepicker1').datetimepicker({
        useCurrent: false,
        format: 'YYYY-MM-DD HH:mm:ss'
    });
    $('#datetimepicker2').datetimepicker({
        useCurrent: false,
        format: 'YYYY-MM-DD HH:mm:ss'
    });
    $("#datetimepicker1").on("change.datetimepicker", function (e) {
        $('#datetimepicker2').datetimepicker('minDate', e.date);
    });
    $("#datetimepicker2").on("change.datetimepicker", function (e) {
        $('#datetimepicker1').datetimepicker('maxDate', e.date);
    });


    $('#datetimepicker3').datetimepicker({
        useCurrent: false,
        format: 'YYYY-MM-DD'
    });
    $('#datetimepicker4').datetimepicker({
        useCurrent: false,
        format: 'YYYY-MM-DD'
    });
    $("#datetimepicker3").on("change.datetimepicker", function (e) {
        $('#datetimepicker4').datetimepicker('minDate', e.date);
    });
    $("#datetimepicker4").on("change.datetimepicker", function (e) {
        $('#datetimepicker3').datetimepicker('maxDate', e.date);
    });

</script>


</body>
</html>


