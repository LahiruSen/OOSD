<?php
/* Reset your password form, sends reset.php password link */
require '../db.php';
session_start();


$email = $_SESSION['email'];
$result = $mysqli->query("SELECT id FROM users WHERE email='$email'");

if ($result->num_rows == 0) // User doesn't exist
{
    $_SESSION['message'] = "This user detail doesn't exist in the system.";
    header("location: ../error.php");
    die();
} else { // User exists (num_rows != 0)


    $user = $result->fetch_assoc(); // $user becomes array with user data

    $user_id = $user['id'];
    $result_new = $mysqli->query("SELECT user_type_id FROM employee_data WHERE user_id='$user_id' ");

    if ($result_new->num_rows == 0) {
        $_SESSION['message'] = "This employ detail doesn't exist in employ_data table.";
        header("location:../error.php");
        die();
    } else {
        $employee = $result_new->fetch_assoc(); // employ become arry with employ data
        $user_type_id = $employee['user_type_id'];


        // if user is a principal
        if ($user_type_id == 1) {
            $leave_result = $mysqli->query("SELECT * FROM leave_submission WHERE approved_by_principal=0");

        } else if ($user_type_id == 2) {
            $leave_result = $mysqli->query("SELECT * FROM leave_submission WHERE approved_by_hr=0");
        } else {
            $_SESSION['message'] = "You have no administrative priviledges";
            header("location:../error.php");
            die();
        }

    }


}


// Check if form submitted with method="post"
?>
<!DOCTYPE html>
<html>
<head>
    <title>Approve Leave Application</title>
     <?php // include 'css/css.html'; ?>
</head>

<body>

<section class="" id="portfolio">
    <div class="">
        <h2 class="text-center text-uppercase text-secondary mb-0">Approve Leave
            Application</h2 class="text-center text-uppercase text-secondary mb-0">
        <hr class="star-dark mb-5">

        <form action="approve_leave_application.php">
            <div class="feild-wrap">
        <table>
            <tr>
                <th>Employee ID</th>
                <th>Reason</th>
                <th>Description</th>
                <th>Number Of Days</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Approve</th>
            </tr>
            <tbody>

            <?php
            if ($leave_result->num_rows) {
                while ($row = $leave_result->fetch_object()) {
                    $records[] = $row;
                }
                $leave_result->free();
                $i = 0;
            }
            foreach($records as $r){
                $i++;
                ?>
                <tr>

                    <td><?php echo $r->employee_id; ?></td>
                    <td><?php echo $r->reason; ?></td>
                    <td><?php echo $r->description; ?></td>
                    <td><?php echo $r->number_of_days; ?></td>
                    <td><?php echo $r->start_date; ?></td>
                    <td><?php echo $r->end_date; ?></td>
                    <td><input type="checkbox" name="<?php echo $r->id ; ?>" >  </td>
                </tr>
           <?php } ?>

            </tbody>
        </table>
            </div>
                <input type="submit" value="submit">
            </form>






    </div>
</section>

</body>

</html>
