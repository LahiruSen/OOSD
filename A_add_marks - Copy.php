
<?php
/* Displays user information and some useful messages */
require 'db.php';
require "functions/security.php";

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



<?php
$records=array();
$records1=array();
$records2=array();

if(!empty($_POST)){

    $course_id=$_POST['course_id'];
if($results1=$mysqli->query("SELECT id,registration_number FROM course_registration where course_id=$course_id and is_approved=1")){
if($results1->num_rows){
while($row=$results1->fetch_object()){
$records1[]=$row;
}
$results1->free();
}


}
}

$i1=0;
foreach($records1 as $r){
$i1++;
$value=$_POST["group".$i1];
echo $value.$i1.'<br>';

$txt=sprintf("insert into %s (PresentAbsent,Date) values ('{$value}',NOW())",escape('_'.$r->RegistrationNumber));
$mysqli->query($txt);



if($mysqli->affected_rows){
echo "Success!!!";
} else{
echo "Failiure???";
}

}




$course_id="CS 2022";
if($results=$mysqli->query("SELECT id,registration_number FROM course_registration where course_id='{$course_id}' and is_approved=1")){
if($results->num_rows){
while($row=$results->fetch_object()){
    //echo $row->id.'<br>';
   // echo $row->registration_number.'<br>';
    $records[]=$row;
}
$results->free();
}
} $i=0;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Attendance</title>
</head>
<body>


<?php
if(!count($records)){
    echo "No records";
}else{

?>
<table>
    <thead>
    <tr>
        <th>Index number</th>
        <th>Present</th>
        <th>Absent</th>

    </tr>
    </thead>
    <tbody>
    <form action="" method="post">
        <?php
        foreach($records as $r){
            $i++;
            ?>
            <tr>
                <td><?php echo escape($r->registration_number);?></td>


                <td><input type="radio" name="<?php echo "group".$i;?>"  value="1" checked="checked"></td>
                <td><input type="radio" name="<?php echo "group".$i;?>" value="0" ></td>
            </tr>
            <?php
        }
        ?>


    </tbody>
</table>
<?php }

var_dump($records);

die();




if(!count($records)){
    echo "No records";
}else{

    ?>
    <table class="table table-dark">
        <thead>
        <tr>
            <th>Registration number</th>
            <th>Marks</th>
            <th>Attendance</th>
            <th>Status</th>
            <th>Submit</th>

        </tr>
        </thead>
        <tbody>

            <?php
            /*foreach($records as $t) {
                echo $t->id . '<br>';
                echo $t->registration_number . '<br>';

                $sql = "SELECT marks,status,attendance FROM course_mark where course_registration_id='{$t->id}'";
                echo $sql . '<br>';
                if ($results = $mysqli->query($sql)) {
                    if ($results->num_rows) {
                        $row2 = $results->fetch_object();
                    }
                }
            }*/
            foreach($records as $r){
                //echo $r->id;

                ?>
            <form action="enroll_mark_submit.php" method="post">
                <tr>
                <td><?php echo escape($r->registration_number); ?></td>
                   <?php $sql="SELECT marks,status,attendance FROM course_mark where course_registration_id='{$r->id}'";

                   var_dump($sql);
                   die();

                    if($results=$mysqli->query($sql)) {
                        if ($results->num_rows ) { $row2 = $results->fetch_object(); ?>

                            <td><input class="text-dark bg-white" type="text" name="mark" value=<?php echo escape($row2->marks); ?>></td>
                            <td><input type="text" class="text-dark bg-white" name="attendance"  value=<?php  echo escape($row2->attendance); ?>></td>
                            <td><input type="text" class="text-dark bg-white" name="attendance"  value=<?php echo escape($row2->attendance); ?>></td>
                            <td><input type="text" class="text-dark bg-white" name="attendance"  value=<?php echo escape($row2->attendance); ?>></td>


                    <!--
                    <td>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input style="width: 20px;height: 20px" name="status" type="checkbox" class="form-check-input" value="1" checked=<?php if(($row2->status)==1){return "checked";}else{return null;}; ?>>
                            </label>
                        </div>
                    </td>
                    -->
                       <?php  }

                     }else{echo "hi";?><!--
                        <td><input class="text-dark bg-white" type="text" name="mark" value=0></td>
                    <td><input type="text" class="text-dark bg-white" name="attendance"  value=0></td>
                    <td>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input style="width: 20px;height: 20px" name="status" type="checkbox" class="form-check-input" value="1" >
                            </label>
                        </div>
                    </td>
                    -->
                    <?php
                   }?>


                    <!--
                    <td><input type="hidden" name="marks_id" value="<?php echo escape($r->id); ?>" ></td>
                    <td> <input class="text-dark bg-white" type="submit" value="Submit"></td>
               -->


            </form>

            </tr>
                <?php
                echo "hi";
            }
            ?>
        </tbody>
    </table>



    <?php
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


</body>

</html>