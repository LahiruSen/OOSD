
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

    $all_employee_types_result  =  $mysqli->query("select * from employee_types") or die($mysqli->error());
    $all_accedemic_years_result  =  $mysqli->query("select * from academic_year") or die($mysqli->error());

    if( $all_accedemic_years_result->num_rows !=0 && $all_employee_types_result->num_rows !=0) {
        $all_employee_type_data = array();
        $all_accedemic_years_data = array();

        while ($row = $all_employee_types_result->fetch_assoc())
        {
            $all_employee_type_data[] = $row;
        }

        while ($row2 = $all_accedemic_years_result->fetch_assoc())
        {
            $all_accedemic_years_data[] = $row2;
        }




        $all_employee_types_result->free();
        $all_accedemic_years_result->free();
    }else
        {


            $_SESSION['message'] = "No employee data or ";
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
            <h2 style="font-size:50px" class="text-dark mb-2">Create Notification <i class="fa fa-graduation-cap"></i> </h2>

        </div>

    </header>

    <!-- Dashboard Section -->
    <section class="" id="portfolio">
        <div class="container ">


            <div class="row text-center">
                        <div class="col-lg-12  col-xl-12">
                            <h3 class="text-center text-uppercase text-secondary mb-0">Create New</h3>
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
                                                    <input  class="text-dark <?php if(isset($error_array) && array_key_exists('title',$error_array))  { echo('text-danger');} ?>" type="text" id="title" name="title" required <?php if(isset($old)){echo 'value="'.$old['title'].'"';}elseif(isset($selected)){echo 'value="'.$selected['title'].'"';} ?> >

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
                                                    <textarea rows="10" class="textarea_expand text-dark <?php if(isset($error_array) && array_key_exists('description',$error_array))  { echo('text-danger');} ?>" type="text" id="description" name="description" required  ><?php if(isset($old)){echo $old['description'];}elseif(isset($selected)){echo $selected['description'];}?></textarea>

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
                                                <h2 class="text-white">Receivers</h2>
                                            </div>

                                            <div class="row m-2">

                                                <div class="form-group col-lg-6 col-md-6">

                                                    <div class="m-2">
                                                        <h4 class="text-dark">Students</h4>
                                                    </div>

                                                    <div class="row m-2">
                                                        <div class="input-group date">
                                                            <label class="text-dark" for="academic_year_id">Academic Year</label>
                                                            <select id="academic_year_id" name="academic_year_id">

                                                                <?php for ( $i=0;$i<count($all_accedemic_years_data);$i++ ) {  ?>

                                                                    <option  value="<?php echo($all_accedemic_years_data[$i]['id']) ?>"><?php echo($all_accedemic_years_data[$i]['title']) ?> </option>

                                                                <?php } ?>

                                                            </select>

                                                            <?php if(isset($error_array) && array_key_exists('academic_year_id',$error_array))  {?>
                                                                <div class="row">
                                                                    <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                                                        <small id="passwordHelp" class="text-danger">
                                                                            <?= $error_array['academic_year_id'] ?>
                                                                        </small>
                                                                    </div>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="text-center mt-4 w-100">
                                                            <button name="student" type="submit" class="btn btn-lg btn-primary" formaction="student_send_notification.php" >Create</button>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group col-lg-6 col-md-6">

                                                    <div class="m-2">
                                                        <h4 class="text-dark">Employee</h4>
                                                    </div>

                                                    <div class="row m-2">
                                                        <div class="input-group date">
                                                            <label class="text-dark" for="academic_year_id">Employee Type</label>
                                                            <select id="employee_data_id" name="employee_data_id">

                                                                <?php for ( $i=0;$i<count($all_employee_type_data);$i++ ) {  ?>

                                                                    <option  value="<?php echo($all_employee_type_data[$i]['id']) ?>" ><?php echo($all_employee_type_data[$i]['title']) ?> </option>

                                                                <?php } ?>

                                                            </select>

                                                            <?php if(isset($error_array) && array_key_exists('employee_data_id',$error_array))  {?>
                                                                <div class="row">
                                                                    <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                                                        <small id="passwordHelp" class="text-danger">
                                                                            <?= $error_array['employee_data_id'] ?>
                                                                        </small>
                                                                    </div>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="text-center mt-4 w-100">
                                                            <button name="employee" type="submit" class="btn btn-lg btn-primary" formaction="employee_send_notification.php" >Create</button>
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



<!--custom-->


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


