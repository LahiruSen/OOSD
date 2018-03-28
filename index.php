<?php
/* Main page with two forms: sign up and log in */
require 'db.php';
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Sign-Up/Login Form</title>
    <?php include 'css/css.html'; ?>
</head>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if (isset($_POST['login'])) { //user logging in

        require 'login.php';

    }

    elseif (isset($_POST['register'])) { //user registering

        require 'register.php';

    }
}
?>

<?php

if(isset($_SESSION['logged_in'])) {
    if ($_SESSION['logged_in'] == 1) {

        if ($_SESSION['types'] == 1) {

            header('location: home_employee.php');
        } else {
            header('location: home_student.php');
        }
    }
}
?>
<body>
<div class="form">

    <ul class="tab-group">
        <li class="tab"><a href="#signup">Sign Up</a></li>
        <li class="tab active"><a href="#login">Log In</a></li>
    </ul>

    <div class="tab-content">

        <div id="login">

            <div style="width: 100%; text-align: center">
                <img src="img/login.png" style="width: 40%"></img>
            </div>


            <form action="index.php" method="post" autocomplete="off">

                <div class="field-wrap">
                    <label>
                        Email Address<span class="req">*</span>
                    </label>
                    <input type="email" required autocomplete="off" name="email"/>
                </div>

                <div class="field-wrap">
                    <label>
                        Password<span class="req">*</span>
                    </label>
                    <input type="password" required autocomplete="off" name="password"/>
                </div>

                <p class="forgot"><a href="forgot.php">Forgot Password?</a></p>

                <button class="button button-block" name="login" />Log In</button>

            </form>

        </div>

        <div id="signup">
            <div style="width: 100%; text-align: center">
                <img src="img/signup.png" style="width: 40%"></img>
            </div>

            <form action="index.php" method="post" autocomplete="off">

                <div class="top-row">
                    <div class="field-wrap">
                        <label>
                            First Name<span class="req">*</span>
                        </label>
                        <input type="text" required autocomplete="off" name='firstname' />
                    </div>

                    <div class="field-wrap">
                        <label>
                            Last Name<span class="req">*</span>
                        </label>
                        <input type="text"required autocomplete="off" name='lastname' />
                    </div>
                </div>

                <div class="field-wrap">
                    <label>
                        Email Address<span class="req">*</span>
                    </label>
                    <input type="email"required autocomplete="off" name='email' />
                </div>



                <div class="field-wrap">
                    <label for="type">
                        I want to be<span class="req">*</span>
                    </label>

                    <select name="types" id="types">
                        <option style="color: black" value="1">Employee</option>
                        <option style="color: black" value="2">Student</option>
                    </select>
                </div>


                <div class="field-wrap">
                    <label>
                        Set A Password<span class="req">*</span>
                    </label>

                        <input  id="password" type="password" required autocomplete="off" name='password' aria-describedby="btnGroupAddon" />
                        <span id="passwordicon" class="fa fa-eye " style="color: white; float: right; margin-right: 10px;margin-top: -24px; position: relative;z-index: 2;" ></span>
                </div>


                <button type="submit" class="button button-block" name="register" />Register</button>

            </form>

        </div>

    </div><!-- tab-content -->

</div> <!-- /form -->
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

<script src="js/index.js"></script>

</body>
</html>
