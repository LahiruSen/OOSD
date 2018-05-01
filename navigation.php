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
                    ?>
                    <a href="twostep.php"><button class="btn btn-success btn-lg">Complete your profile</button> </a>
                    <?php
                }
                else
                {
                    ?>
                    <a href="twostep.php"><button class="btn btn-warning btn-lg">Activation pending <i class="fa fa-exclamation-triangle"></i></button> </a>
                    <?php
                }

            }else
            {

                ?>
                <a href="twostep.php"><button class="btn btn-info btn-lg">Add profile information</button> </a>
                <?php

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
                            <a class="dropdown-item" href="#">Employee Leave Request</a>
                            <a class="dropdown-item" href="#">User Profiles</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Student Registration Setting</a>
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
                            Role
                        </button>
                        <div class="dropdown-menu dropdown-menu-right bg-dropdown" aria-labelledby="dropdownMenuButton">
                            <h6 class="dropdown-header">Role</h6>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Create Roll</a>
                            <a class="dropdown-item" href="#">Roll List</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Roll Access</a>

                        </div>
                    </div>
                </li>
                <li class="nav-item mx-0 mx-lg-1">
                    <div class="dropdown">
                        <button style="width: 100%" class="btn  dropdown-toggle btn-primary" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Academic
                        </button>
                        <div class="dropdown-menu dropdown-menu-right bg-dropdown" aria-labelledby="dropdownMenuButton">
                            <h6 class="dropdown-header">Academic Year</h6>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="create_academic_year.php">Create Academic Year</a>
                            <a class="dropdown-item" href="#">Academic Year List</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Create Academic Level</a>
                            <a class="dropdown-item" href="#">Academic Level List</a>

                        </div>
                    </div>
                </li>


            <?php }
            elseif ($employee_type_data['title'] == 'Teacher') { ?>
                <!--FOR Teacher-->

                <li class="nav-item mx-0 mx-lg-1">
                    <a href="leave.php" class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#portfolio">Leave</a>
                </li>
                <li class="nav-item mx-0 mx-lg-1">
                    <a href="Udhan/courses.php" class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#contact">Courses</a>
                </li>
                <li class="nav-item mx-0 mx-lg-1">
                    <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#about">Link 3</a>
                </li>
                <li class="nav-item mx-0 mx-lg-1">
                    <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#contact">Link 4</a>
                </li>
                <li class="nav-item mx-0 mx-lg-1">
                    <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#about">Link 5</a>
                </li>


            <?php }
            elseif ($employee_type_data['title'] == 'Principal') { ?>
                <!--FOR Principal-->

                <li class="nav-item mx-0 mx-lg-1">
                    <a href="leave.php" class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#portfolio">Leave</a>
                </li>
                <li class="nav-item mx-0 mx-lg-1">
                    <a href="Udhan/courses.php" class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#contact">Courses</a>
                </li>
                <li class="nav-item mx-0 mx-lg-1">
                    <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#about">Link 3</a>
                </li>
                <li class="nav-item mx-0 mx-lg-1">
                    <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#contact">Link 4</a>
                </li>
                <li class="nav-item mx-0 mx-lg-1">
                    <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#about">Link 5</a>
                </li>


            <?php }
            elseif ($employee_type_data['title'] == 'HR Manager') { ?>
                <!--FOR HR Manager-->

                <li class="nav-item mx-0 mx-lg-1">
                    <a href="leave.php" class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#portfolio">Leave</a>
                </li>
                <li class="nav-item mx-0 mx-lg-1">
                    <a href="Udhan/courses.php" class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#contact">Courses</a>
                </li>
                <li class="nav-item mx-0 mx-lg-1">
                    <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#about">Link 3</a>
                </li>
                <li class="nav-item mx-0 mx-lg-1">
                    <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#contact">Link 4</a>
                </li>
                <li class="nav-item mx-0 mx-lg-1">
                    <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#about">Link 5</a>
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