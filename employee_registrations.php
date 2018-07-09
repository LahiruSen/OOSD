
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
$user_id = $_SESSION['user_id']; $current_employee_type_result = $mysqli->query("select DISTINCT employee_types.title,employee_types.id from employee_types, users, employee_data where employee_data.user_id = '$user_id' and employee_types.id = employee_data.employee_type_id") or die($mysqli->error());
if($current_employee_type_result->num_rows !=0)
{
    $current_employee_type_data = $current_employee_type_result->fetch_assoc();
    $current_employee_type_result->free();
    $type_of_employment = $current_employee_type_data['title'];
}




if ($_SERVER['REQUEST_METHOD'] == 'GET')
{

   if (isset($_GET['employee_type_id']))
    {

        if((is_int($_GET['employee_type_id']) || ctype_digit($_GET['employee_type_id'])) && (int)$_GET['employee_type_id'] > 0)
        {
            $employee_type_id = $_GET['employee_type_id'];

            $employee_type = $mysqli->query("select title from employee_types where id='$employee_type_id'");

            if($employee_type->num_rows !=0)
            {

                $employee_type_title = $employee_type->fetch_assoc();

                $employee_type_title = $employee_type_title['title'];
            }else
                {
                    $_SESSION['message'] = "Employee type id is not a valid id!";
                    header("location:error.php");

                }

            $all_employee_data_result =  $mysqli->query("select * from employee_data where employee_type_id='$employee_type_id'") or die($mysqli->error());

            if($all_employee_data_result->num_rows !=0)
            {

                $all_employee_data= array();

                while($row = $all_employee_data_result->fetch_assoc())
                {
                    $all_employee_data[] = $row;

                }
                $all_employee_data_result->free();


            }else
            {

                $_SESSION['message'] = "No employee are associated with the academic year";
                header("location:error.php");

            }


        }else
        {
            $_SESSION['message'] = "Employee type id should be an integer";
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
            <h2 style="font-size:50px" class="text-dark mb-2">Employee Registrations <i class="fa fa-graduation-cap"></i> </h2>
        </div>

    </header>

    <!-- Dashboard Section -->
    <section class="" id="portfolio">
        <div class="container ">


            <div class="row text-center">
                        <div class="col-lg-12  col-xl-12">
                            <?php if(isset($all_employee_data)){?>
                                <h3 class="text-center text-uppercase text-secondary mb-0">All Employee List</h3>
                                <h5 class="text-center text-uppercase text-primary mb-0"><?=$employee_type_title?></h5>

                                <hr class="star-dark mb-5">
                                <div class="container">
                                    <div class="text-left ">
                                        <table class="table table-striped table-bordered">
                                            <thead class="thead_my">
                                            <tr class="text-white" >
                                                <th>ID</th>
                                                <th>Full Name</th>
                                                <th>NIC</th>
                                                <th>Information status</th>
                                                <th>Employee ID </th>
                                                <th>Approved</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            <?php foreach ($all_employee_data as $sd){ ?>

                                                    <tr>
                                                        <td><?= $sd['id'] ?></td>
                                                        <td><?= $sd['full_name'] ?></td>
                                                        <td><?= $sd['nic'] ?></td>
                                                        <td><?php if($sd['is_locked'] == 1){echo("Locked");}else{echo("Not locked");} ?></td>
                                                        <td><?= $sd['employee_id'] ?></td>
                                                        <td><?php if($sd['is_approved'] == 1){echo("Approved");}else{echo("Pending");} ?></td>
                                                        <td>
                                                            <div class="btn-group" role="group" >
                                                                <a href="employee_registration_view.php?id=<?= $sd['id'];?>&et_id=<?=$employee_type_id?>"><button class="btn btn-outline-primary m-1 " type="submit">View</button></a>
                                                            </div>
                                                        </td>

                                                    </tr>

                                            <?php } ?>


                                            </tbody>
                                        </table>
                                    </div>
                                </div>

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


