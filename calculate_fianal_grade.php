
<?php
/* Displays user information and some useful messages */
require 'db.php';
if (session_status() == PHP_SESSION_NONE) {    session_start();}

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

    $all_accedemic_years_result  =  $mysqli->query("select * from academic_year where status='1'") or die($mysqli->error());



    if($all_accedemic_years_result->num_rows !=0) {
        $all_accedemic_years_data =$all_accedemic_years_result->fetch_assoc();

        $all_accedemic_years_result->free();

        $aid=$all_accedemic_years_data['id'];

        $academic_levels = $mysqli->query("SELECT * FROM level WHERE academic_year_id='$aid'");


        $al = array();

        if($academic_levels->num_rows !=0)
        {
            while ($row = $academic_levels->fetch_assoc())
            {


                $al_id = $row['id'];


                $deadline_al =  DateTime::createFromFormat('Y-m-d H:i:s', $row['deadline']);
                $deadline_al->add(new DateInterval('P1M'));
                $deadline_al->add(new DateInterval('P1M'));
                $deadline_al->add(new DateInterval('P1M'));
                $deadline_al->add(new DateInterval('P1M'));



                $today = new DateTime();
                $today_str = $today->format('Y-m-d H:i:s');

                $final_grade = $mysqli->query("SELECT * FROM student_final_grade WHERE level_id='level_id'");

                if($final_grade->num_rows>0)
                {


                    if($deadline_al>$today)
                    {
                        $al[] = array($row,'1',$deadline_al->format('Y-m-d H:i:s'),'Calculated: Before the right time(Not okay)');

                    }else
                        {
                            $al[] = array($row,'1',$deadline_al->format('Y-m-d H:i:s'),'Calculated');

                        }

                }else
                    {





                        if($deadline_al>$today)
                        {
                            $al[] = array($row,'0',$deadline_al->format('Y-m-d H:i:s'),'Wait till '.$deadline_al->format('Y-m-d H:i:s'));



                        }else
                        {
                            $al[] = array($row,'0',$deadline_al->format('Y-m-d H:i:s'),"It is already late");

                        }



                    }





            }






        }else
            {

                $_SESSION['message'] = "There are no academic levels available for calculation";
                header("location: error.php");
            }






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
            <h2 style="font-size:50px" class="text-dark mb-2">Final Grade <i class="fa fa-graduation-cap"></i> </h2>

        </div>

    </header>

    <!-- Dashboard Section -->
    <section class="" id="portfolio">
        <div class="container ">


            <div class="row text-center">
                        <div class="col-lg-8  col-xl-8">

                            <h3 class="text-center text-uppercase text-secondary mb-0">Student Final Grades</h3>

                            <hr class="star-dark mb-5">
                            <div id="two_step_submission_form" class="two_step_form" method="post">
                                <div class="row text-center">
                                    <div class="col-lg-12  col-xl-12">

                                        <div class="container">
                                            <div class="text-left ">
                                                <table class="table table-striped text-center table-bordered">
                                                    <thead class="thead_my">
                                                    <tr class="text-white ">
                                                        <th>ID</th>
                                                        <th>Title</th>
                                                        <th>Type</th>
                                                        <th>Calculation Date</th>
                                                        <th>About</th>
                                                        <th class="text-center">Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>

                                                    <?php foreach ($al as $sd){ ?>

                                                        <tr>
                                                            <td><?= $sd[0]['id'] ?></td>
                                                            <td><?= $sd[0]['title'] ?></td>
                                                            <td><?= $sd[0]['type'] ?></td>
                                                            <td><?= $sd[2] ?></td>
                                                            <td><?= $sd[3] ?></td>
                                                            <td class="text-center">

                                                                <?php if($sd[1] == 1) { ?>

                                                                <?php }else { ?>

                                                                    <div class="btn-group" role="group" >
                                                                        <a  data-id="<?= $sd[0]['id'] ?>"  class=" ay_view w-100 btn list-group-item list-group-item-action text-dark btn-outline-primary font-weight-bold">Calculate</a>
                                                                    </div>

                                                                <?php } ?>
                                                            </td>

                                                        </tr>

                                                    <?php } ?>


                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
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
                                    <?php if(isset($all_accedemic_years_data)) { ?>

                                            <?php if($all_accedemic_years_data['status'] == 1) { ?>

                                                <div class="jumbotron jumbotron-fluid bg-topfive">
                                                    <div class="container">
                                                        <h1>Current Academic years</h1>
                                                        <div class="card" style="width:100%">
                                                            <div class="container text-center w-100">
                                                                <i style="font-size: 100px" class="fa fa-graduation-cap"></i>
                                                            </div>

                                                            <div class="card-body">
                                                                <h4 class="card-title"><?= $all_accedemic_years_data['title']?></h4>
                                                                <h5 class="card-title"><strong>Period : </strong><?= $all_accedemic_years_data['from_date']?> - <?= $all_accedemic_years_data['to_date']?></h5>
                                                                <p class="card-text"><?= $all_accedemic_years_data['description']?></p>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            <?php } ?>



                                    <?php } else { ?>


                                        <?php if(isset($_GET['id'])){ ?>

                                            <div class="text-center mt-4 w-100">
                                                <a href="create_academic_year.php" class="btn btn-xl btn-outline-primary" >Create New</a>
                                            </div>
                                        <?php }?>

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




    <div class="modal fade" id="academic_year_delete">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content ">

                <!-- Modal Header -->
                <div id="modal_head_div" class="modal-header">
                    <h4  class="modal-title"> Are you sure? </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>


                <!-- Modal footer -->
                <div class="modal-footer">
                    <div class="row">

                        <div class="col-lg-6">
                            <a href="" id="ay_delete_confirm_btn"  class="btn btn-outline-success" >Calculate</a>
                        </div>
                        <div class="col-lg-6 ">
                            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
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



    $(document.body).on('click', '.ay_view' ,function()
    {

        id = $(this).data('id');




            $('#academic_year_delete #ay_delete_confirm_btn').attr('href','calculate_fianal_grade_submit.php?id='+id);

            $('#academic_year_delete').modal('show');




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


