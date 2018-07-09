
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
    $id=$_SESSION['user_id'];


    if ($types == 1) {

        header("location: home_employee.php");
        die();
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
$current_employee_type_result = $current_user_info_result = $mysqli->query("select DISTINCT employee_types.title,employee_types.id from employee_types, users, employee_data where users.email = '$email' and employee_types.id = employee_data.employee_type_id") or die($mysqli->error());
if($current_employee_type_result->num_rows !=0)
{
    $current_employee_type_data = $current_employee_type_result->fetch_assoc();
    $current_employee_type_result->free();
    $type_of_employment = $current_employee_type_data['title'];
}else{
    $_SESSION['message'] = "Err1 There are no courses available";
    header("location:error.php");
}


$records=array();

if($result1 = $mysqli->query("SELECT registration_number,registered_ayear_id FROM student_data WHERE user_id='{$id}'")){
    if($result1->num_rows){
        $output=$result1->fetch_object();
        $reg_num=$output->registration_number;
        $ay_id=$output->registered_ayear_id;
       //  var_dump($reg_num);
       //  var_dump($ay_id);
       // die();
        $result1->free();
    }else{
        $_SESSION['message'] = "Err2:1 There are no courses available";
        header("location:error.php");
    }


}else{
    $_SESSION['message'] = "Err2 There are no courses available";
    header("location:error.php");
}




//If there is a record in student_final_grade

    if($results3=$mysqli->query("select level_id,status from student_final_grade where registration_number='{$reg_num}' ")){
        if($results3->num_rows){
            $output2=$results3->fetch_object();
            $level_id=$output2->level_id;
            $status=$output2->status;
          //  var_dump($level_id);
          //  var_dump($status);

            //If the student passed his level
//$level_id+=1


            if($status==1){

                $level_id+=1;




                //if the level_id is in between the deadline

                $current_date = date('Y-m-d H:i:s');
                if($results4=$mysqli->query("select from_date from academic_year where id='{$level_id}'")){
                    if($results4->num_rows){
                        $ay_start=$results4->fetch_object()->from_date;
                    }
                else{
                        $_SESSION['message'] = "Err3:1 There are no courses available";
                        header("location:error.php");
                    }
                }else{
                    $_SESSION['message'] = "Err3 There are no courses available";
                    header("location:error.php");
                }


                if($results5=$mysqli->query("select deadline from level where id='{$level_id}'")){
                    if($results5->num_rows){
                        $deadline=$results5->fetch_object()->deadline;
                    }else{
                        $_SESSION['message'] = "Err4:1 There are no courses available";
                        header("location:error.php");
                    }

                }else{
                    $_SESSION['message'] = "Err4 There are no courses available";
                    header("location:error.php");
                }

                $interval_b = strtotime($deadline)-strtotime($current_date);
                $interval_a = strtotime($current_date)-strtotime($ay_start);

                //     echo "deadline ";
                //     var_dump($deadline);
                //     echo '<br>'."current date ";
                //     var_dump($current_date);
                //     echo '<br>'."start date ";
                //   var_dump($ay_start);
                //    var_dump($interval_a);
                //    var_dump($interval_b);
                //die();

                if($interval_b>=0 && $interval_a>=0){
                    //  echo '<script type="text/javascript">alert("hi");</script>';
                    if($results=$mysqli->query("SELECT course_id,title,description,credits,no_of_working_hours FROM courses where level_id='{$level_id}'")){
                        if($results->num_rows){
                            while($row=$results->fetch_object()){
                                $records[]=$row;
                            }
                            $results->free();
                        }else{
                            $_SESSION['message'] = "Err5:1 There are no courses available";
                            header("location:error.php");
                        }

                    }
                }else{
                    $_SESSION['message'] = "Err5 There are no courses available";
                    header("location:error.php");
                }

            }
            //If the status is zero
            else{
                $level_id+=2;


                //if the level_id is in between the deadline

                $current_date = date('Y-m-d H:i:s');
                if($results4=$mysqli->query("select from_date from academic_year where id='{$level_id}'")){
                   if($results4->num_rows){
                       $ay_start=$results4->fetch_object()->from_date;
                   }

                else{
                        $_SESSION['message'] = "Err6:1 There are no courses available";
                        header("location:error.php");
                    }
                }else{
                    $_SESSION['message'] = "Err6 There are no courses available";
                    header("location:error.php");
                }

                if($results5=$mysqli->query("select deadline from level where id='{$level_id}'")){
                    if($results5->num_rows) {
                        $deadline = $results5->fetch_object()->deadline;
                    } else{
                        $_SESSION['message'] = "Err7:1 There are no courses available";
                        header("location:error.php");
                    }
                }else{
                    $_SESSION['message'] = "Err7 There are no courses available";
                    header("location:error.php");
                }



                $interval_b = strtotime($deadline)-strtotime($current_date);
                $interval_a = strtotime($current_date)-strtotime($ay_start);

                /* var_dump($level_id);
                 echo "deadline ";
                 var_dump($deadline);
                 echo '<br>'."current date ";
                 var_dump($current_date);
                 echo '<br>'."start date ";
                 var_dump($ay_start);
                 var_dump($interval_a);
                 var_dump($interval_b);
                 die();

                 */
                if($interval_b>=0 && $interval_a>=0){
                    if($results=$mysqli->query("SELECT course_id,title,description,credits,no_of_working_hours FROM courses where level_id='{$level_id}'")){
                        if($results->num_rows){
                            while($row=$results->fetch_object()){
                                $records[]=$row;
                            }
                            $results->free();
                        }

                    }
                }else{
                    $_SESSION['message'] = "Err8 There are no courses available";
                    header("location:error.php");
                }
            }


        }else{


//If the record is not found in student_final_grade


            $records2=array();
            var_dump($ay_id);


            if($result2 = $mysqli->query("SELECT id FROM level WHERE academic_year_id='{$ay_id}'")){
                if($result2->num_rows){
                    while($row=$result2->fetch_object()){
                        $records2[]=$row;
                    }
                    $result2->free();
                }
            }else{
                $_SESSION['message'] = "Err9 There are no courses available";
                header("location:error.php");
            }
            $level_id_1 = $records2[0]->id;
            $level_id_2 = $records2[1]->id;

            var_dump($level_id_1);
            var_dump($level_id_2);
            echo '<br>';
            echo '<br>';
           // die();

            $current_date = date('Y-m-d H:i:s');

            if($results4=$mysqli->query("select from_date from academic_year where id='{$level_id_1}'")){
                if($results4->num_rows){
                    $ay_start=$results4->fetch_object()->from_date;
                }else{
                    $_SESSION['message'] = "Err10:1 There are no courses available";
                    header("location:error.php");
                }

            }else{
                $_SESSION['message'] = "Err10 There are no courses available";
                header("location:error.php");
            }


            if($results5=$mysqli->query("select deadline from level where id='{$level_id_1}'")){
                if($results5->num_rows){
                    $deadline=$results5->fetch_object()->deadline;
                }else{
                    $_SESSION['message'] = "Err11 There are no courses available";
                    header("location:error.php");
                }

            }else{
                $_SESSION['message'] = "Err11 There are no courses available";
                header("location:error.php");
            }

            $interval_b = strtotime($deadline)-strtotime($current_date);
            $interval_a = strtotime($current_date)-strtotime($ay_start);

               /* echo "level_id ";
                var_dump($level_id_1);
                echo '<br>'."deadline ";
                var_dump($deadline);
                echo '<br>'."current date ";
                var_dump($current_date);
                echo '<br>'."start date ";
                var_dump($ay_start);
                var_dump($interval_a);
                var_dump($interval_b);
                die();

            */

            if($interval_b>=0 && $interval_a>=0){
                if($results=$mysqli->query("SELECT course_id,title,description,credits,no_of_working_hours FROM courses where level_id='{$level_id_1}'")){
                    if($results->num_rows){
                        while($row=$results->fetch_object()){
                            $records[]=$row;
                        }
                        $results->free();
                    }else{
                        $_SESSION['message'] = "Err12:1 There are no courses available";
                        header("location:error.php");
                    }

                }else{
                    $_SESSION['message'] = "Err12 There are no courses available";
                    header("location:error.php");
                }

            }else{
                if($results=$mysqli->query("SELECT course_id,title,description,credits,no_of_working_hours FROM courses where level_id='{$level_id_2}'")){
                    if($results->num_rows){
                        while($row=$results->fetch_object()){
                            $records[]=$row;
                        }
                        $results->free();
                    }else{
                        $_SESSION['message'] = "Err13:1 There are no courses available";
                        header("location:error.php");
                    }

                }else{
                    $_SESSION['message'] = "Err13 There are no courses available";
                    header("location:error.php");
                }
            }
        }



}else
    {
        $_SESSION['message'] = "Err14 There are no courses available";
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
            <h2 style="font-size:50px" class="text-dark mb-2">Courses List <i class="fa fa-graduation-cap"></i> </h2>

        </div>

    </header>

    <!-- Dashboard Section -->
    <section class="" id="portfolio">
        <div class="container ">


            <div class="row text-center">
                <div class="col-lg-12  col-xl-12">
                    <h3 class="text-center text-uppercase text-secondary mb-0">Select a course</h3>

                    <hr class="star-dark mb-5">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-4 col-xl-4" >

                                <form action="A_course_registration_check.php" method="post">



                                            <div class=" row m-2">
                                                <div class="col-lg-12">
                                                    <?php $option="<select name='course_id'>";foreach ($records as $r){  $option.='<option value="'.$r->course_id.'">'.$r->title.'</option>' ;
                                                    } ?>

                                                    <?php
                                                    echo $option.='</select>';
                                                    ?>
                                                </div>
                                            </div>
                                    <input type="hidden" name="reg_num" value="<?php  echo $reg_num; ?>" >
                                            <div class="row m-2 ">
                                                <div class="col-lg-12">
                                                    <button type="submit" class="btn btn-lg btn-success">Register</button>
                                                </div>
                                            </div>


                                </form>

                            </div>
                            <div class="text-left col-lg-8 col-xl-8">
                                <table class="table table-striped text-center">
                                <thead>
                                <tr class="text-white bg-dark" style="border: dimgray solid 10px; border-radius: 1px">
                                    <th>Course ID</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Credits</th>
                                    <th>No of working hours</th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php foreach ($records as $r){ ?>

                                        <tr>
                                            <td><?php echo $r->course_id;?></td>
                                            <td><?php echo $r->title;?></td>
                                            <td ><?php echo $r->description;?></td>
                                            <td><?php echo $r->credits;?></td>
                                            <td><?php echo $r->no_of_working_hours;?></td>


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
                            <label class="text-dark" for="ay_description">Description</label>
                        </div>
                        <div class="row">
                            <p id="ay_description"></p>
                        </div>

                    </div>
                    <div class="m-2">
                        <div class="row">
                            <label class="text-dark" for="ay_registration_deadline">Registration deadline</label>
                        </div>
                        <div class="row">
                            <p style="font-size: 20px" id="ay_registration_deadline"></p>
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



</body>
</html>


