
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

<?php } else { if($two_step ==1)
{
    $current_employee_type_result = $current_user_info_result = $mysqli->query("select DISTINCT employee_types.title,employee_types.id from employee_types, users, employee_data where users.email = '$email' and employee_types.id = employee_data.employee_type_id") or die($mysqli->error());
    if($current_employee_type_result->num_rows !=0)
    {
        $current_employee_type_data = $current_employee_type_result->fetch_assoc();
        $current_employee_type_result->free();
        $type_of_employment = $current_employee_type_data['title'];
    }




if ($_SERVER['REQUEST_METHOD'] == 'GET')
{

    if(isset($_GET['id']))
    {

        if((is_int($_GET['id']) || ctype_digit($_GET['id'])) && (int)$_GET['id'] > 0)
        {
            $student_id = $_GET['id'];

            $student_data_result =  $mysqli->query("select * from student_data where id='$student_id'") or die($mysqli->error());

            if($student_data_result->num_rows !=0)
            {

                $student_data=$student_data_result->fetch_assoc();

                $student_data_result->free();


            }else
                {

                    $_SESSION['message'] = "Student id is not a valid id!";
                    header("location:error.php");

                }


        }else
            {
                $_SESSION['message'] = "Id should be an integer";
                header("location:error.php");


            }

    }elseif (isset($_GET['academic_year_id']))
    {

        if((is_int($_GET['academic_year_id']) || ctype_digit($_GET['academic_year_id'])) && (int)$_GET['academic_year_id'] > 0)
        {
            $student_ayid = $_GET['academic_year_id'];

            $academic_year = $mysqli->query("select title from academic_year where id='$student_ayid'");

            if($academic_year->num_rows !=0)
            {

                $academic_year_title = $academic_year->fetch_assoc();

                $academic_year_title = $academic_year_title['title'];
            }else
                {
                    $_SESSION['message'] = "Academic year id is not a valid id!";
                    header("location:error.php");

                }

            $all_student_data_result =  $mysqli->query("select * from student_data where registered_ayear_id='$student_ayid'") or die($mysqli->error());

            if($all_student_data_result->num_rows !=0)
            {

                $all_student_data= array();

                while($row = $all_student_data_result->fetch_assoc())
                {
                    $all_student_data[] = $row;

                }
                $all_student_data_result->free();


            }else
            {

                $_SESSION['message'] = "No student are associated with the academic year";
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


}

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
            <h2 style="font-size:50px" class="text-dark mb-2">Students Registration <i class="fa fa-graduation-cap"></i> </h2>
        </div>

    </header>

    <!-- Dashboard Section -->
    <section class="" id="portfolio">
        <div class="container ">


            <div class="row text-center">
                        <div class="col-lg-12  col-xl-12">
                            <?php if(isset($all_student_data)){?>
                                <h3 class="text-center text-uppercase text-secondary mb-0">All Student List</h3>
                                <h5 class="text-center text-uppercase text-primary mb-0"><?=$academic_year_title?></h5>

                                <hr class="star-dark mb-5">
                                <div class="container">
                                    <div class="text-left ">
                                        <table class="table table-striped">
                                            <thead>
                                            <tr class="text-white bg-dark" style="border: darkorchid solid 10px; border-radius: 1px">
                                                <th>ID</th>
                                                <th>Full Name</th>
                                                <th>NIC</th>
                                                <th>Information status</th>
                                                <th>Registration Number</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            <?php foreach ($all_student_data as $sd){ ?>
                                                <form id="two_step_submission_form" class="two_step_form" action="student_registrations.php?id=<?= $sd['id'];?>" method="post">
                                                    <tr>
                                                        <td><?= $sd['id'] ?></td>
                                                        <td><?= $sd['full_name'] ?></td>
                                                        <td><?= $sd['nic'] ?></td>
                                                        <td><?php if($sd['is_locked'] == 1){echo("Locked");}else{echo("Not locked");} ?></td>
                                                        <td><?php if($sd['registration_number'] == null){echo("Pending");}else{$sd['registration_number'];} ?></td>
                                                        <td>
                                                            <div class="btn-group" role="group" >
                                                                <button class="btn btn-info m-1" type="submit">View</button>
                                                                <?php if($sd['is_locked'] == 1){?>
                                                                    <button class="btn btn-success m-1" type="submit" formaction="student_registrations_approve.php?id=<?= $sd['id'];?>" >Approve</button>
                                                                <?php } ?>
                                                                <button class="btn btn-danger m-1" formaction="student_registrations_delete.php?id=<?= $sd['id'];?>" >Delete</button>
                                                            </div>
                                                        </td>

                                                    </tr>
                                                </form>
                                            <?php } ?>


                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            <?php }elseif(isset($student_data)) { ?>
                                <h3 class="text-center text-uppercase text-secondary mb-0">Student Data</h3>

                            <?php } ?>


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

    <?php if(isset($selected) || isset($old)) {?>


    <?php if(isset($selected)){ ?>
        deadline = moment('<?php echo $selected['deadline'] ?>').format('YYYY-MM-DD HH:mm:ss');

    <?php } ?>


    <?php if(isset($old)){ ?>
        deadline = moment('<?php echo $selected['deadline'] ?>').format('YYYY-MM-DD HH:mm:ss');
    <?php } ?>

    $('#datetimepicker3').attr('disabled',false);



    $('#datetimepicker3').datetimepicker({
        useCurrent: false,
        defaultDate: deadline,
        minDate: moment($('#academic_year_id').find(':selected').data('fromdate')).format('YYYY-MM-DD HH:mm:ss'),
        maxDate: moment($('#academic_year_id').find(':selected').data('todate')).format('YYYY-MM-DD HH:mm:ss'),
        format: 'YYYY-MM-DD HH:mm:ss'
    });


    $('#academic_year_id').on('change', function() {

        if(this.value != 0)
        {
            $('#datetimepicker3').attr('disabled',false);


            Selected_from_date = moment($(this).find(':selected').data('fromdate')).format('YYYY-MM-DD HH:mm:ss');
            Selected_to_date = moment($(this).find(':selected').data('todate')).format('YYYY-MM-DD HH:mm:ss');

            set_from_date = moment($('#datetimepicker3').datetimepicker('minDate')).format('YYYY-MM-DD HH:mm:ss');
            set_to_date = moment($('#datetimepicker3').datetimepicker('maxDate')).format('YYYY-MM-DD HH:mm:ss');

            if(Selected_to_date>set_to_date)
            {
                $('#datetimepicker3').datetimepicker('maxDate', Selected_to_date);
                $('#datetimepicker3').datetimepicker('minDate',Selected_from_date );

            }else
            {

                $('#datetimepicker3').datetimepicker('minDate',Selected_from_date );
                $('#datetimepicker3').datetimepicker('maxDate', Selected_to_date);
            }
        }
        else
        {

            $('#datetimepicker3').attr('disabled',true);
            $('#datetimepicker3').val('');

            $('#datetimepicker3').datetimepicker(
                {
                    useCurrent: false,
                    format: 'YYYY-MM-DD HH:mm:ss'

                });

        }
    });


    <?php }else { ?>


    $('#datetimepicker3').datetimepicker({
        useCurrent: false,
        format: 'YYYY-MM-DD HH:mm:ss'
    });


    $('#academic_year_id').on('change', function() {

        if(this.value != 0)
        {
            $('#datetimepicker3').attr('disabled',false);


            Selected_from_date = moment($(this).find(':selected').data('fromdate')).format('YYYY-MM-DD HH:mm:ss');
            Selected_to_date = moment($(this).find(':selected').data('todate')).format('YYYY-MM-DD HH:mm:ss');

            set_from_date = moment($('#datetimepicker3').datetimepicker('minDate')).format('YYYY-MM-DD HH:mm:ss');
            set_to_date = moment($('#datetimepicker3').datetimepicker('maxDate')).format('YYYY-MM-DD HH:mm:ss');

            if(Selected_to_date>set_to_date)
            {
                $('#datetimepicker3').datetimepicker('maxDate', Selected_to_date);
                $('#datetimepicker3').datetimepicker('minDate',Selected_from_date );

            }else
                {

                    $('#datetimepicker3').datetimepicker('minDate',Selected_from_date );
                    $('#datetimepicker3').datetimepicker('maxDate', Selected_to_date);
                }
        }
        else
            {

                $('#datetimepicker3').attr('disabled',true);
                $('#datetimepicker3').val('');

                $('#datetimepicker3').datetimepicker(
                    {
                        useCurrent: false,
                        format: 'YYYY-MM-DD HH:mm:ss'

                    });

            }
    });


    <?php
    }

    $body ='';

    if(isset($all_accedemic_levels_data)) {

        for ($k = 0; $k < count($all_accedemic_levels_data); $k++) {

            $body = $body . '<a  data-id="'.$all_accedemic_levels_data[$k]['id'] .'" data-title="'.$all_accedemic_levels_data[$k]['title'] .'" data-deadline="'.$all_accedemic_levels_data[$k]['deadline'] .'"  data-description="'.$all_accedemic_levels_data[$k]['description'] .'" class=" al_view w-100 btn list-group-item list-group-item-action text-dark  font-weight-bold">' . $all_accedemic_levels_data[$k]['title'] . ' <i class="text-dark ';


            $body = $body . ' fa fa-book"></i></a>';

        }
    }

    if($body !=''){

    ?>

    $('#academic_level_togal').on('click',function (e)
    {
        if(btnClick == 0)
        {
            $('#academic_level_div').append('<?=$body?>');
            btnClick++;

        }else if(btnClick == 1)
        {
            $('#academic_level_div').empty();
            btnClick--;
        }

    });

    <?php } ?>


    $(document.body).on('click', '.al_view' ,function()
    {

        id = $(this).data('id');
        title = $(this).data('title');
        description = $(this).data('description');
        deadline = $(this).data('deadline');





        $('#academic_level_view #al_title').text(title);
        $('#academic_level_view #al_description').text(description);
        $('#academic_level_view #al_registration_deadline').text(deadline);

        $('#academic_level_view #modal_head_div').addClass('bg-primary');



        $('#academic_level_view #al_update_btn').click(function(){
            window.location.href='create_academic_level.php?id='+id;
        });

        $('#academic_level_view #al_delete_btn').click(function(){
            window.location.href='academic_level_delete.php?id='+id;
        });

        $('#academic_level_view').modal('show');


    });



</script>


</body>
</html>


