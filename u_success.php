<?php
/**
 * Created by PhpStorm.
 * User: Udhan
 * Date: 7/9/2018
 * Time: 4:32 PM
 */

/* Displays all successful messages */
if (session_status() == PHP_SESSION_NONE) {    session_start();}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Success</title>
  <?php include 'css/css.html'; ?>
</head>
<body>
<div class="form">
    <div class="text-center jumbotron bg-white">
        <h1><?= 'Success'; ?></h1>
        <h5 class="text-success">
            <?php
            if( isset($_SESSION['message']) ):
                echo $_SESSION['message'];
                unset($_SESSION['message']);
            else:
                header( "location: index.php" );
            endif;
            ?>
        </h5>
    </div>
    <a href="index.php"><button class="button button-block">Home</button></a>


    <div class="m-4">
        <a href="u_up_del_assignments_teacher.php"><button class="button button-block">Back</button></a>
    </div>

</div>




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


<!--<script type="text/javascript">-->
<!--    $("#back_btn").on('click',function (e) {-->
<!---->
<!--        window.history.back();-->
<!--    })-->
<!--</script>-->
</body>
</html>
