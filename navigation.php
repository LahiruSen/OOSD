
<!-- This is employee navigation bar -->
<?php if($_SESSION['types']==1) { ?>
<ul class="navbar-nav ml-auto">


    <?php
    if($_SESSION['two_step'] == 0) {

        $user_result =  $mysqli->query("SELECT * FROM users WHERE email='$email'") or die($mysqli->error());



        if($user_result->num_rows != 0)
        {
            $user_data = $user_result->fetch_assoc();
            $user_result->free();
            $user_id = $user_data['id'];
            $employee_result =  $mysqli->query("SELECT * FROM employee_data WHERE user_id='$user_id'") or die($mysqli->error());


            if($employee_result->num_rows != 0)
            {
                $employee_data = $employee_result->fetch_assoc();
                $employee_result->free();

                if($employee_data['is_locked'] != 1)
                {
                    if(!isset($on_two_step)) {
                        ?>
                        <a href="twostep.php">
                            <button class="btn btn-success btn-lg">Complete your profile</button>
                        </a>
                        <?php

                    }else
                        {
                            ?>
                            <a href="index.php">
                                <button class="btn btn-success btn-lg">Back to Home</button>
                            </a>
                            <?php
                        }
                }
                else
                {

                    if(!isset($on_two_step)) {
                        ?>
                        <a href="twostep.php"><button class="btn btn-warning btn-lg">Activation pending <i class="fa fa-exclamation-triangle"></i></button> </a>

                        <?php

                    }else
                    {
                        ?>
                        <a href="index.php">
                            <button class="btn btn-success btn-lg">Back to Home</button>
                        </a>
                        <?php
                    }
                }

            }else
            {



                if(!isset($on_two_step)) {
                    ?>
                    <a href="twostep.php"><button class="btn btn-info btn-lg">Add profile information</button> </a>
                    <?php

                }else
                {
                    ?>
                    <a href="index.php">
                        <button class="btn btn-success btn-lg">Back to Home</button>
                    </a>
                    <?php
                }
            }

        }
        else
        {

            $_SESSION['message'] = "You are not a valid user";
            header("location:error.php");
        }
    }
    else
    {

        $user_result = $mysqli->query("SELECT * FROM users WHERE email='$email'") or die($mysqli->error());
        $user_data = $user_result->fetch_assoc();
        $user_result->free();
        $user_id = $user_data['id'];

        $employee_result =  $mysqli->query("SELECT * FROM employee_data WHERE user_id='$user_id'") or die($mysqli->error());
        $employee_data =  $employee_result->fetch_assoc();

        $employee_result->free();

        $employee_type_id = $employee_data['employee_type_id'];
        $employee_type_result = $mysqli->query("SELECT * FROM employee_types WHERE id='$employee_type_id'") or die($mysqli->error());

        if($employee_type_result->num_rows !=0)
        {
            $employee_type_data = $employee_type_result->fetch_assoc();
            $employee_type_result->free();


            //                     <!-- Navigation menus-->

            if($employee_type_data['title'] == 'Administrator'){ ?>

                <!--FOR ADMIN-->
                <li class="nav-item mx-0 mx-lg-1">
                    <div class="dropdown">
                        <a href="home_employee.php" style="width: 100%; border-radius: .25rem" class="btn btn-primary text-capitalize"  >
                            Home
                        </a>

                    </div>
                </li>
                <li class="nav-item mx-0 mx-lg-1">
                    <div class="dropdown">
                        <button style="width: 100%" class="btn dropdown-toggle btn-danger" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Registration
                        </button>
                        <div  class="dropdown-menu dropdown-menu-right bg-dropdown" aria-labelledby="dropdownMenuButton">
                            <h6 class="dropdown-header">Registration</h6>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Student Registration</a>
                            <a class="dropdown-item" href="#">Employee Registration</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Student Registration Setting</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Add Courses</a>
                        </div>
                    </div>
                </li>
                <li class="nav-item mx-0 mx-lg-1">
                    <div class="dropdown">
                        <button style="width: 100%" class="btn  dropdown-toggle btn-primary" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Notification
                        </button>
                        <div class="dropdown-menu dropdown-menu-right bg-dropdown" aria-labelledby="dropdownMenuButton">
                            <h6 class="dropdown-header">Notification</h6>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Create Notification</a>
                            <a class="dropdown-item" href="#">Notification List</a>
                        </div>
                    </div>
                </li>
                <li class="nav-item mx-0 mx-lg-1">
                    <div class="dropdown">
                        <button style="width: 100%" class="btn  dropdown-toggle btn-primary" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Academic
                        </button>
                        <div class="dropdown-menu dropdown-menu-right bg-dropdown" aria-labelledby="dropdownMenuButton">
                            <h6 class="dropdown-header">Academic</h6>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="create_academic_year.php">Academic Years</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="create_academic_level.php">Academic Level</a>

                        </div>
                    </div>
                </li>
                <li class="nav-item mx-0 mx-lg-1">
                    <div class="dropdown">
                        <button style="width: 100%" class="btn  dropdown-toggle btn-primary" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Employee Leaves
                        </button>
                        <div class="dropdown-menu dropdown-menu-right bg-dropdown" aria-labelledby="dropdownMenuButton">
                            <h6 class="dropdown-header">Employee Leaves</h6>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Employee Leave Request</a>

                        </div>
                    </div>
                </li>



            <?php }
            elseif ($employee_type_data['title'] == 'Teacher') { ?>
                <!--FOR Teacher-->
                <li class="nav-item mx-0 mx-lg-1">
                    <div class="dropdown">
                        <a href="home_employee.php" style="width: 100%; border-radius: .25rem" class="btn btn-primary text-capitalize"  >
                            Home
                        </a>

                    </div>
                </li>
                <li class="nav-item mx-0 mx-lg-1">
                    <div class="dropdown">
                        <button style="width: 100%" class="btn dropdown-toggle btn-danger" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            My Leave
                        </button>
                        <div  class="dropdown-menu dropdown-menu-right bg-dropdown" aria-labelledby="dropdownMenuButton">
                            <h6 class="dropdown-header">My Leave</h6>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Available leave</a>
                            <a class="dropdown-item" href="#">Submit leave</a>
                        </div>
                    </div>
                </li>
                <li class="nav-item mx-0 mx-lg-1">
                    <div class="dropdown">
                        <button style="width: 100%" class="btn  dropdown-toggle btn-primary" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Notification
                        </button>
                        <div class="dropdown-menu dropdown-menu-right bg-dropdown" aria-labelledby="dropdownMenuButton">
                            <h6 class="dropdown-header">Notification</h6>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Create Notification</a>
                            <a class="dropdown-item" href="#">Notification List</a>
                        </div>
                    </div>
                </li>
                <li class="nav-item mx-0 mx-lg-1">
                    <div class="dropdown">
                        <button style="width: 100%" class="btn  dropdown-toggle btn-primary" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Courses
                        </button>
                        <div class="dropdown-menu dropdown-menu-right bg-dropdown" aria-labelledby="dropdownMenuButton">
                            <h6 class="dropdown-header">Courses</h6>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="">Courses list</a>
                            <a class="dropdown-item" href="">Enter Marks</a>
                            <a class="dropdown-item" href="create_academic_level.php">Attendance</a>

                        </div>
                    </div>
                </li>



            <?php }
            elseif ($employee_type_data['title'] == 'Principal') { ?>
                <!--FOR Principal-->

                <li class="nav-item mx-0 mx-lg-1">
                    <div class="dropdown">
                        <a href="home_employee.php" style="width: 100%; border-radius: .25rem" class="btn btn-primary text-capitalize"  >
                            Home
                        </a>

                    </div>
                </li>
                <li class="nav-item mx-0 mx-lg-1">
                    <div class="dropdown">
                        <button style="width: 100%" class="btn dropdown-toggle btn-danger" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            My Leave
                        </button>
                        <div  class="dropdown-menu dropdown-menu-right bg-dropdown" aria-labelledby="dropdownMenuButton">
                            <h6 class="dropdown-header">My Leave</h6>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="/lahiru/check_leave.php">Available leave</a>
                            <a class="dropdown-item" href="/lahiru/leave_submission.php">Submit leave</a>
                        </div>
                    </div>
                </li>
                <li class="nav-item mx-0 mx-lg-1">
                    <div class="dropdown">
                        <button style="width: 100%" class="btn  dropdown-toggle btn-primary" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Notification
                        </button>
                        <div class="dropdown-menu dropdown-menu-right bg-dropdown" aria-labelledby="dropdownMenuButton">
                            <h6 class="dropdown-header">Notification</h6>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Create Notification</a>
                            <a class="dropdown-item" href="#">Notification List</a>
                        </div>
                    </div>
                </li>
                <li class="nav-item mx-0 mx-lg-1">
                    <div class="dropdown">
                        <button style="width: 100%" class="btn  dropdown-toggle btn-primary" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Approve Leave
                        </button>
                        <div class="dropdown-menu dropdown-menu-right bg-dropdown" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="lahiru/approve_leave_application_form.php    ">Approve Leave</a>
                        </div>
                    </div>
                </li>


            <?php }
            elseif ($employee_type_data['title'] == 'HR Manager') { ?>
                <!--FOR HR Manager-->
                <li class="nav-item mx-0 mx-lg-1">
                    <div class="dropdown">
                        <a href="home_employee.php" style="width: 100%; border-radius: .25rem" class="btn btn-primary text-capitalize"  >
                            Home
                        </a>

                    </div>
                </li>
                <li class="nav-item mx-0 mx-lg-1">
                    <div class="dropdown">
                        <button style="width: 100%" class="btn dropdown-toggle btn-danger" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            My Leave
                        </button>
                        <div  class="dropdown-menu dropdown-menu-right bg-dropdown" aria-labelledby="dropdownMenuButton">
                            <h6 class="dropdown-header">My Leave</h6>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Available leave</a>
                            <a class="dropdown-item" href="#">Submit leave</a>
                        </div>
                    </div>
                </li>
                <li class="nav-item mx-0 mx-lg-1">
                    <div class="dropdown">
                        <button style="width: 100%" class="btn  dropdown-toggle btn-primary" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Notification
                        </button>
                        <div class="dropdown-menu dropdown-menu-right bg-dropdown" aria-labelledby="dropdownMenuButton">
                            <h6 class="dropdown-header">Notification</h6>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Create Notification</a>
                            <a class="dropdown-item" href="#">Notification List</a>
                        </div>
                    </div>
                </li>
                <li class="nav-item mx-0 mx-lg-1">
                    <div class="dropdown">
                        <button style="width: 100%" class="btn  dropdown-toggle btn-primary" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Approve Leave
                        </button>
                        <div class="dropdown-menu dropdown-menu-right bg-dropdown" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="">Approve Leave</a>
                        </div>
                    </div>
                </li>

            <?php }

        }else
        {
            $_SESSION['message'] = "This user is not belongs to a valid employee type";
            header("location:error.php");
        }
    } ?>

    <li class="nav-item mx-0 mx-lg-1">
        <div class="dropdown">
            <button style="width: 100%" class="btn  dropdown-toggle user-dropdown text-white" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-user-circle"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-right bg-dropdown" aria-labelledby="dropdownMenuButton">
                <h6 class="dropdown-header b"><?= $first_name.' '.$last_name ?> </h6>
                <div class="dropdown-divider"></div>
                <?php if($two_step ==1) { ?>
                    <a class="dropdown-item" href="#">Profile( <strong class="text-primary"><?php if(isset($employee_type_data)){echo($employee_type_data['title']);}?></strong> )</a>
                <?php } ?>
                <a class="dropdown-item" href="#">Messages</a>
                <a class="dropdown-item" href="logout.php">Logout</a>


            </div>
        </div>
    </li>

</ul>


<?php } else { ?>





<!-- This is student navigation bar -->



<ul class="navbar-nav ml-auto">


    <?php
    if($_SESSION['two_step'] == 0) {

        $user_result =  $mysqli->query("SELECT * FROM users WHERE email='$email'") or die($mysqli->error());



        if($user_result->num_rows != 0)
        {
            $user_data = $user_result->fetch_assoc();
            $user_result->free();
            $user_id = $user_data['id'];
            $student_result =  $mysqli->query("SELECT * FROM student_data WHERE user_id='$user_id'") or die($mysqli->error());


            if($student_result->num_rows != 0)
            {
                $student_data = $student_result->fetch_assoc();
                $student_result->free();

                if($student_data['is_locked'] != 1)
                {
                    if(!isset($on_two_step)) {
                        ?>
                        <a href="twostep.php">
                            <button class="btn btn-success btn-lg">Complete your profile</button>
                        </a>
                        <?php

                    }else
                    {
                        ?>
                        <a href="index.php">
                            <button class="btn btn-success btn-lg">Back to Home</button>
                        </a>
                        <?php
                    }
                }
                else
                {
                    if(!isset($on_two_step)) {
                        ?>
                        <a href="twostep.php"><button class="btn btn-warning btn-lg">Activation pending <i class="fa fa-exclamation-triangle"></i></button> </a>

                        <?php

                    }else
                    {
                        ?>
                        <a href="index.php">
                            <button class="btn btn-success btn-lg">Back to Home</button>
                        </a>
                        <?php
                    }
                }

            }else
            {

                if(!isset($on_two_step)) {
                    ?>
                    <a href="twostep.php"><button class="btn btn-info btn-lg">Add profile information</button> </a>
                    <?php

                }else
                {
                    ?>
                    <a href="index.php">
                        <button class="btn btn-success btn-lg">Back to Home</button>
                    </a>
                    <?php
                }

            }

        }
        else
        {

            $_SESSION['message'] = "You are not a valid user";
            header("location:error.php");
        }
    }
    else
    {

?>

                <!--FOR Student-->
        <li class="nav-item mx-0 mx-lg-1">
            <div class="dropdown">
                <a href="home_employee.php" style="width: 100%; border-radius: .25rem" class="btn btn-primary text-capitalize"  >
                    Home
                </a>

            </div>
        </li>
        <li class="nav-item mx-0 mx-lg-1">
            <div class="dropdown">
                <button style="width: 100%" class="btn dropdown-toggle btn-danger" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                   Courses
                </button>
                <div  class="dropdown-menu dropdown-menu-right bg-dropdown" aria-labelledby="dropdownMenuButton">
                    <h6 class="dropdown-header">Courses</h6>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Enroll Course</a>
                    <a class="dropdown-item" href="#">Course List</a>
                </div>
            </div>
        </li>

        <li class="nav-item mx-0 mx-lg-1">
            <div class="dropdown">
                <button style="width: 100%" class="btn dropdown-toggle btn-danger" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Due Assignments
                </button>
                <div  class="dropdown-menu dropdown-menu-right bg-dropdown" aria-labelledby="dropdownMenuButton">
                    <h6 class="dropdown-header">Due Assignments</h6>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Due Assignments List</a>
                </div>
            </div>
        </li>

        <li class="nav-item mx-0 mx-lg-1">
            <div class="dropdown">
                <button style="width: 100%" class="btn dropdown-toggle btn-danger" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Scholarships
                </button>
                <div  class="dropdown-menu dropdown-menu-right bg-dropdown" aria-labelledby="dropdownMenuButton">
                    <h6 class="dropdown-header">Scholarships</h6>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Submit Scholarship</a>
                </div>
            </div>
        </li>

        <li class="nav-item mx-0 mx-lg-1">
            <div class="dropdown">
                <button style="width: 100%" class="btn dropdown-toggle btn-danger" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Grades
                </button>
                <div  class="dropdown-menu dropdown-menu-right bg-dropdown" aria-labelledby="dropdownMenuButton">
                    <h6 class="dropdown-header">Grades</h6>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">View Grades</a>
                </div>
            </div>
        </li>

            <?php

    } ?>

    <li class="nav-item mx-0 mx-lg-1">
        <div class="dropdown">
            <button style="width: 100%" class="btn  dropdown-toggle user-dropdown text-white" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-user-circle"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-right bg-dropdown" aria-labelledby="dropdownMenuButton">
                <h6 class="dropdown-header b"><?= $first_name.' '.$last_name ?> </h6>
                <div class="dropdown-divider"></div>
                <?php if($two_step ==1) { ?>
                    <a class="dropdown-item" href="#">Profile( <strong class="text-primary"><?php if(isset($student_type_data)){echo($student_type_data['title']);}?></strong> )</a>
                <?php } ?>
                <a class="dropdown-item" href="#">Messages</a>
                <a class="dropdown-item" href="logout.php">Logout</a>


            </div>
        </div>
    </li>

</ul>

<?php } ?>