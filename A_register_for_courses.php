<html>
<head>
    <style type="text/css">
        #table{
            width:50%;
        }
    </style>
</head>
<body>

<?php
require "db.php";
require "functions/security.php";
include 'css/css.html';

$records=array();
$level_id=0;
if($results=$mysqli->query("SELECT course_id,title,description,credits,no_of_working_hours FROM courses where level_id='{$level_id}'")){
if($results->num_rows){
while($row=$results->fetch_object()){
$records[]=$row;
}
$results->free();
}
} $i=0;
?>


<?php
if(!count($records)){
    echo "No records";
}else{

    ?>
    <div id="table">
    <table class="table table-striped table-bordered border="5";"  >
        <thead>
        <tr>
            <th>Course ID</th>
            <th>Title</th>
            <th>Description</th>
            <th>Credits</th>
            <th>No of working hours</th>

        </tr>
        </thead>
        <tbody>

            <?php
            $option="<select>";
            foreach($records as $r){
                $i++;
                ?>
                <tr>
                    <td><?php echo $r->course_id;?></td>
                    <td><?php echo $r->title;?></td>
                    <td ><?php echo $r->description;?></td>
                    <td><?php echo $r->credits;?></td>
                    <td><?php echo $r->no_of_working_hours;?></td>
                    <?php // $option.'<option value="'.$r->course_id.'">'.$r->title.'</option>' ;?>

                </tr>
                <?php
            }
            //echo $option.'</select>';
            ?>


        </tbody>
    </table>
        <form action="" method="post">

    <input type="submit" value="Submit">
        </form>
    </div>
    <?php
}
?>
<hr>




</body>
</html>