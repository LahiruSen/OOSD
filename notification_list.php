
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
    $userId = $_SESSION['user_id'];

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


        $notification_result = $mysqli->query("SELECT notifications.*,users.email FROM notifications,users WHERE notifications.sender_id='$userId' and notifications.delete_sender='0' and users.id =notifications.target_user_ids   ORDER BY notifications.date_of_create DESC");



        if($notification_result->num_rows >0)
        {
            $notifications = array();

            while ($row = $notification_result->fetch_assoc())
            {
                $notifications[] = $row;
            }





        }else
            {


                $_SESSION['message'] = "Notification list is empty!";
                header("location:error.php");
            }



//THE RULE WILL CHANGE IN HERE DUE TO RULES


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
            <h2 style="font-size:50px" class="text-dark mb-2">Notifications <i class="fa fa-graduation-cap"></i> </h2>

        </div>

    </header>

    <!-- Dashboard Section -->
    <section class="" id="portfolio">
        <div class="container ">


            <div class="row text-center">
                <div class="col-lg-12  col-xl-12">
                    <h3 class="text-center text-uppercase text-secondary mb-0">My Notification List(Outbox)</h3>

                    <hr class="star-dark mb-5">
                    <div class="container">
                        <div class="text-left ">
                            <table class="table table-striped text-center table-bordered">
                                <thead class="thead_my">
                                <tr class="text-white ">
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Receiver Email</th>
                                    <th>User Seen Status</th>
                                    <th>Type</th>
                                    <th class="text-center">Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php foreach ($notifications as $sd){ ?>

                                        <tr>
                                            <td><?= $sd['id'] ?></td>
                                            <td><?= $sd['title'] ?></td>
                                            <td><?= $sd['email'] ?></td>
                                            <td><?php if($sd['is_seen']==0){ echo("Unseen");}else{echo("Seen");} ?></td>
                                            <td><?php if($sd['types']==1){ echo("Employee");}else{echo("Student");} ?></td>
                                              <td class="text-center">
                                                <div class="btn-group" role="group" >
                                                    <a  data-id="<?= $sd['id'] ?>" data-title="<?= $sd['title'] ?>" data-email="<?= $sd['email'] ?>" data-description="<?= $sd['description'] ?>" class=" al_view w-100 btn list-group-item list-group-item-action text-dark btn-outline-primary font-weight-bold">View</a>
                                                 </div>
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
                        <div class="row ">
                            <label class="text-dark" for="al_description">Receiver Email</label>
                        </div>
                        <div class="row">
                            <h5 id="al_email"></h5>
                        </div>

                    </div>


                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <div class="row ">

                        <div class="col-lg-6">
                            <a href="" id="al_delete_btn"  class="btn btn-danger" data-dismiss="modal">Delete</a>
                        </div>
                        <div class="col-lg-6 ">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>

                    </div>

                </div>

            </div>
        </div>
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
                            <a href="" id="ay_delete_confirm_btn"  class="btn btn-outline-danger" >Delete</a>
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
<script type="text/javascript">


    $(document.body).on('click', '.al_view' ,function()
    {

        id = $(this).data('id');
        title = $(this).data('title');
        description = $(this).data('description');
        email = $(this).data('email');






        $('#academic_level_view #al_title').text(title);
        $('#academic_level_view #al_description').text(description);
        $('#academic_level_view #al_email').text(email);


        $('#academic_level_view #modal_head_div').addClass('bg-primary');


        $('#academic_level_view #al_delete_btn').click(function(){
            $('#academic_year_delete #ay_delete_confirm_btn').attr('href','notification_delete.php?id='+id+'&types=sender');
            $('#academic_year_delete').modal('show');
        });

        $('#academic_level_view').modal('show');


    });

</script>


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




