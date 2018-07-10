
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
    $user_id = $_SESSION['user_id']; $current_employee_type_result = $mysqli->query("select DISTINCT employee_types.title,employee_types.id from employee_types, users, employee_data where employee_data.user_id = '$user_id' and employee_types.id = employee_data.employee_type_id") or die($mysqli->error());
    if($current_employee_type_result->num_rows !=0)
    {
        $current_employee_type_data = $current_employee_type_result->fetch_assoc();
        $current_employee_type_result->free();
        $type_of_employment = $current_employee_type_data['title'];
    }

    $all_courses_result  =  $mysqli->query("select * from courses") or die($mysqli->error());

    if($all_courses_result->num_rows !=0) {
        $all_courses_data = array();

        while ($row = $all_courses_result->fetch_assoc())
        {
            $all_courses_data[] = $row;
        }

        $all_courses_result->free();
    }


if ($_SERVER['REQUEST_METHOD'] == 'GET')
{

    if(isset($_GET['id']))
    {

            $ay_id = $_GET['id'];

            $selceted_courses_result  =  $mysqli->query("select * from courses where course_id='$ay_id'") or die($mysqli->error());

            if($selceted_courses_result->num_rows !=0)
            {

                $selceted_courses_data=$selceted_courses_result->fetch_assoc();

                $selceted_courses_result->free();

                if(isset($selceted_courses_data))
                {

                    $selected = $selceted_courses_data;

                }else
                    {
                        header("location: A_create_courses.php");
                    }



            }else
                {
                    header("location: A_create_courses.php");
                }




    }


}elseif($_SERVER['REQUEST_METHOD'] == 'POST')
{

    require 'A_courses_submit.php';

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
            <h2 style="font-size:50px" class="text-dark mb-2">Courses <i class="fa fa-graduation-cap"></i> </h2>

        </div>

    </header>

    <!-- Dashboard Section -->
    <section class="" id="portfolio">
        <div class="container ">


            <div class="row text-center">
                        <div class="col-lg-8  col-xl-8">
                            <?php if(isset($_GET['id'])){?>
                                <h3 class="text-center text-uppercase text-secondary mb-0">Update</h3>
                            <?php }else { ?>
                                <h3 class="text-center text-uppercase text-secondary mb-0">Create New</h3>
                            <?php } ?>
                            <hr class="star-dark mb-5">
                            <form id="two_step_submission_form" class="two_step_form" action="#" method="post">
                                <div class="container">


                                    <div class="text-left ">
                                        <div id="form_section_header" class="bg-topfive">
                                            <h2 class="text-white"> Basic information </h2>
                                        </div>


                                        <div class="row m-2">
                                            <div class=" form-group col-lg-12 col-md-12">
                                                <label class="text-dark" for="title">Corse ID</label>
                                                <input  class="text-dark <?php if(isset($error_array) && array_key_exists(
                                                        'course_id',$error_array))  { echo('text-danger');} ?>" type="text"
                                                        id="course_id" name="course_id" required <?php if(isset($old)){
                                                    echo 'value="'.$old['course_id'].'"';}elseif(isset($selected)){
                                                    echo 'value="'.$selected['course_id'].'"';} ?> >

                                                <?php if(isset($error_array) && array_key_exists('course_id',$error_array))  {?>
                                                    <div class="row">
                                                        <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                                            <small id="passwordHelp" class="text-danger">
                                                                <?= $error_array['course_id'] ?>
                                                            </small>
                                                        </div>
                                                    </div>
                                                <?php } ?>

                                            </div>
                                        </div>

                                        <div class="row m-2">
                                            <div class=" form-group col-lg-12 col-md-12">
                                                <label class="text-dark" for="title">Course Name</label>
                                                <input  class="text-dark <?php if(isset($error_array) &&
                                                    array_key_exists('title',$error_array))  {
                                                    echo('text-danger');} ?>" type="text" id="title" name="title"
                                                        required <?php if(isset($old)){echo 'value="'.$old['title'].'"';}
                                                        elseif(isset($selected)){echo 'value="'.$selected['title'].'"';} ?> >

                                                <?php if(isset($error_array) && array_key_exists('title',$error_array))
                                                {?>
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
                                                <textarea rows="10" class="textarea_expand text-dark <?php
                                                if(isset($error_array) && array_key_exists('description',$error_array))
                                                { echo('text-danger');} ?>" type="text" id="description" name="description" required
                                                ><?php if(isset($old)){echo $old['description'];}elseif(isset($selected)){
                                                    echo $selected['description'];}?></textarea>

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


                                        <div class="row m-2">
                                            <div class=" form-group col-lg-12 col-md-12">
                                                <label class="text-dark" for="title">Credits</label>
                                                <input  class="text-dark <?php if(isset($error_array) && array_key_exists(
                                                        'credits',$error_array))  { echo('text-danger');} ?>" type="text"
                                                        id="credits" name="credits" required <?php if(isset($old)){
                                                            echo 'value="'.$old['credits'].'"';}elseif(isset($selected)){
                                                            echo 'value="'.$selected['credits'].'"';} ?> >

                                                <?php if(isset($error_array) && array_key_exists('credits',$error_array))  {?>
                                                    <div class="row">
                                                        <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                                            <small id="passwordHelp" class="text-danger">
                                                                <?= $error_array['credits'] ?>
                                                            </small>
                                                        </div>
                                                    </div>
                                                <?php } ?>

                                            </div>
                                        </div>


                                        <div class="row m-2">
                                            <div class=" form-group col-lg-12 col-md-12">
                                                <label class="text-dark" for="title">Level ID</label>
                                                <input  class="text-dark <?php if(isset($error_array) && array_key_exists(
                                                        'level_id',$error_array))  { echo('text-danger');}
                                                        ?>" type="text" id="level_id" name="level_id" required
                                                    <?php if(isset($old)){echo 'value="'.$old['level_id'].'"';}
                                                    elseif(isset($selected)){echo 'value="'.$selected['level_id'].'"';} ?> >

                                                <?php if(isset($error_array) && array_key_exists('level_id',$error_array))  {?>
                                                    <div class="row">
                                                        <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                                            <small id="passwordHelp" class="text-danger">
                                                                <?= $error_array['level_id'] ?>
                                                            </small>
                                                        </div>
                                                    </div>
                                                <?php } ?>

                                            </div>
                                        </div>

                                        <div class="row m-2">
                                            <div class=" form-group col-lg-12 col-md-12">
                                                <label class="text-dark" for="title">Assigned Teacher ID</label>
                                                <input  class="text-dark <?php if(isset($error_array) && array_key_exists(
                                                        'assigned_teacher_id',$error_array))  { echo('text-danger');}
                                                        ?>" type="text" id="assigned_teacher_id" name="assigned_teacher_id" required
                                                    <?php if(isset($old)){echo 'value="'.$old['assigned_teacher_id'].'"';}
                                                    elseif(isset($selected)){echo 'value="'.$selected['assigned_teacher_id'].'"';} ?> >

                                                <?php if(isset($error_array) && array_key_exists('assigned_teacher_id',$error_array))
                                                {?>
                                                    <div class="row">
                                                        <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                                            <small id="passwordHelp" class="text-danger">
                                                                <?= $error_array['assigned_teacher_id'] ?>
                                                            </small>
                                                        </div>
                                                    </div>
                                                <?php } ?>

                                            </div>
                                        </div>

                                        <div class="row m-2">
                                            <div class=" form-group col-lg-12 col-md-12">
                                                <label class="text-dark" for="title">No. of working hours</label>
                                                <input  class="text-dark <?php if(isset($error_array) && array_key_exists(
                                                        'no_of_working_hours',$error_array))  { echo('text-danger');} ?>"
                                                        type="text" id="no_of_working_hours" name="no_of_working_hours" required
                                                    <?php if(isset($old)){echo 'value="'.$old['no_of_working_hours'].'"';}
                                                    elseif(isset($selected)){echo 'value="'.$selected['no_of_working_hours'].'"';} ?> >

                                                <?php if(isset($error_array) && array_key_exists('no_of_working_hours',$error_array))  {?>
                                                    <div class="row">
                                                        <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                                            <small id="passwordHelp" class="text-danger">
                                                                <?= $error_array['no_of_working_hours'] ?>
                                                            </small>
                                                        </div>
                                                    </div>
                                                <?php } ?>

                                            </div>
                                        </div>

<!--               Might be usefull                          -->
<!--                                        --><?php //if(isset($error_array) && array_key_exists('from_to',$error_array))  {?>
<!--                                            <div class="form-group row m-2">-->
<!--                                                <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-10">-->
<!--                                                    <small id="passwordHelp" class="text-danger">-->
<!--                                                        --><?//= $error_array['from_to'] ?>
<!--                                                    </small>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                        --><?php //} ?>


                                        <div class="row m-2">
                                            <div class=" form-group col-lg-6 col-md-6">



                                                <?php if(isset($error_array) && array_key_exists('registration_deadline',$error_array))  {?>
                                                    <div class="row">
                                                        <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                                            <small id="passwordHelp" class="text-danger">
                                                                <?= $error_array['registration_deadline'] ?>
                                                            </small>
                                                        </div>
                                                    </div>
                                                <?php } ?>

                                                <?php if(isset($error_array) && array_key_exists('registration_deadline_not_range',$error_array))  {?>
                                                    <div class="row">
                                                        <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                                            <small id="passwordHelp" class="text-danger">
                                                                <?= $error_array['registration_deadline_not_range'] ?>
                                                            </small>
                                                        </div>
                                                    </div>
                                                <?php } ?>

                                            </div>



                                            <?php if(isset($selected)) {?>
                                                <input type="hidden" name="id" value="<?=$selected['course_id']?>">
                                            <?php }?>

                                        </div>



                                        <div class="row m-2">

                                            <?php if(isset($selected)) {?>
                                                <div class="text-center mt-4 w-100">
                                                    <button name="update_ay" type="submit" class="btn btn-xl btn-outline-primary" >Update</button>
                                                </div>
                                            <?php }else{?>
                                                <div class="text-center mt-4 w-100">
                                                    <button name="create_new_ay" type="submit" class="btn btn-xl btn-outline-success" >Create</button>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>


                        <div class="col-lg-4  col-xl-4">
                            <h3 class="text-center text-uppercase text-secondary mb-0">List</h3>
                            <hr class="star-dark mb-5">
                            <div class="container">
                                <div class="text-left two_step_form">
                                    <?php if(isset($_GET['id'])){ ?>
                                        <div class="form-group text-center">

                                                <a href="create_academic_year.php" class="btn btn-xl btn-outline-success" >Create New</a>

                                        </div>


                                    <?php }?>
                                    <?php if(isset($all_courses_data)) { ?>


                                        <button id="academic_year_togal" type="button" class="btn btn-primary w-100">
                                            Courses
                                        </button>


                                        <div  class="container w-100 text-center">
                                            <ul id="academic_year_div" class="list-group  w-100 text-center">

                                            </ul>
                                        </div>

                                    <?php } else { ?>


                                        <?php if(isset($_GET['id'])){ ?>

                                            <div class="text-center mt-4 w-100">
                                                <a href="create_academic_year.php" class="btn btn-xl btn-outline-primary" >Create New</a>
                                            </div>
                                        <?php }?>

                                        <div class="jumbotron jumbotron-fluid bg-topfive">
                                            <div class="container">
                                                <h1>Can't Find Any Modules</h1>
                                                <p>Please create a new module!</p>
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


    <!-- Model -->
    <div class="modal fade" id="academic_year_view">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content ">

                <!-- Modal Header -->
                <div id="modal_head_div" class="modal-header">
                    <h4 id="ay_title" class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="m-2">
                        <div class="row ">
                            <label class="text-dark" for="ay_title">Title</label>
                        </div>
                        <div class="row">
                            <p id="ay_title"></p>
                        </div>

                    </div>

                    <div class="m-2">
                        <div class="row">
                                <label class="text-dark" for="ay_description">Description</label>
                        </div>
                        <div class="row">
                                <p style="font-size: 20px" id="ay_description"></p>
                        </div>
                    </div>

                    <div class="m-2">
                        <div class="row">
                            <label class="text-dark" for="ay_credits">Credits</label>
                        </div>
                        <div class="row">
                            <p style="font-size: 20px" id="ay_credits"></p>
                        </div>
                    </div>

                    <div class="m-2">
                        <div class="row">
                            <label class="text-dark" for="ay_level-id">Level ID</label>
                        </div>
                        <div class="row">
                            <p style="font-size: 20px" id="ay_level-id"></p>
                        </div>
                    </div>

                    <div class="m-2">
                        <div class="row">
                            <label class="text-dark" for="ay_assigned-teacher-id">Assigned Teacher ID</label>
                        </div>
                        <div class="row">
                            <p style="font-size: 20px" id="ay_assigned-teacher-id"></p>
                        </div>
                    </div>

                    <div class="m-2">
                        <div class="row">
                            <label class="text-dark" for="ay_no-of-working-hours">No. of working hours</label>
                        </div>
                        <div class="row">
                            <p style="font-size: 20px" id="ay_no-of-working-hours"></p>
                        </div>
                    </div>


                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-lg-4">
                            <a href="" id="ay_update_btn"  class="btn btn-success" data-dismiss="modal">Update</a>
                        </div>
                        <div class="col-lg-4">
                            <a href="" id="ay_delete_btn"  class="btn btn-danger" data-dismiss="modal">Delete</a>
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

<?php } else
    {
        if ($_SESSION['types'] == 1) {

            header('location: home_employee.php');
        } else {
            header('location: home_student.php');
        }
    }

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

    var btnClick =0;

    $('textarea.textarea_expand').focus(function () {
        $(this).animate({height: "184px"}, 1000);
    });










    <?php

    $body ='';

    if(isset($all_courses_data)) {

        for ($k = 0; $k < count($all_courses_data); $k++) {

            $body = $body . '<a  data-id="'.$all_courses_data[$k]['course_id']
                .'" data-title="'.$all_courses_data[$k]['title'] .'" data-description="'
                .$all_courses_data[$k]['description'] .'" data-credits="'
                .$all_courses_data[$k]['credits'] .'" data-level="'
                .$all_courses_data[$k]['level_id'].'" data-assigned="'
                .$all_courses_data[$k]['assigned_teacher_id'].'" data-working="'
                .$all_courses_data[$k]['no_of_working_hours']
                .'" class=" ay_view w-100 btn list-group-item list-group-item-action text-dark  font-weight-bold">'
                . $all_courses_data[$k]['title'] . '<i class="';



            $body = $body . ' fa fa-graduation-cap"></i></a>';

        }
    }

    if($body !=''){

    ?>

    $('#academic_year_togal').on('click',function (e)
    {
        if(btnClick == 0)
        {
            $('#academic_year_div').append('<?=$body?>');
            btnClick++;

        }else if(btnClick == 1)
        {
            $('#academic_year_div').empty();
            btnClick--;
        }

    });

    <?php } ?>

//    $( document ).ready(function() {
//        $('#academic_year_view').modal('show');
//    });


    $(document.body).on('click', '.ay_view' ,function()
    {

        course_id = $(this).data('id');
        title = $(this).data('title');
        description = $(this).data('description');
        credits = $(this).data('credits');
        level_id = $(this).data('level');
        assigned_teacher_id = $(this).data('assigned');
        no_of_working_hours= $(this).data('working');




        $('#academic_year_view #ay_id').text(course_id);
        $('#academic_year_view #ay_title').text(title);
        $('#academic_year_view #ay_description').text(description);
        $('#academic_year_view #ay_credits').text(credits);
        $('#academic_year_view #ay_level-id').text(level_id);
        $('#academic_year_view #ay_assigned-teacher-id').text(assigned_teacher_id);
        $('#academic_year_view #ay_no-of-working-hours').text(no_of_working_hours);



            $('#academic_year_view #modal_head_div').addClass('bg-success');
            $('#academic_year_view #modal_head_div').removeClass('bg-warning');
            $('#academic_year_view #modal_head_div').removeClass('bg-dark');
            $('#academic_year_view #modal_head_div').removeClass('text-white');



        $('#academic_year_view #ay_update_btn').click(function(){
            window.location.href='A_create_courses.php?id='+course_id;
        });

        $('#academic_year_view #ay_delete_btn').click(function(){
            window.location.href='A_course_delete.php?id='+course_id;
        });

        $('#academic_year_view').modal('show');


    });



</script>
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


