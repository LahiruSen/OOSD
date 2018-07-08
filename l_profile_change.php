session_start();

require 'db.php';


if ( $_SESSION['logged_in'] != 1 ) {

$_SESSION['message'] = "You must log in before viewing your profile page!";
header("location: error.php");

}

elseif($_SESSION['active'] != 1)
{
$_SESSION['message'] = "We have sent you a verification email to your email account. Please click verification link to verify your account!!!";
header("location: error.php");

} else
{


// Makes it easier to read
$first_name = $_SESSION['first_name'];
$last_name = $_SESSION['last_name'];
$email = $_SESSION['email'];
$active = $_SESSION['active'];
$types = $_SESSION['types'];
$two_step= $_SESSION['two_step'];

//user data
$result = $mysqli->query("SELECT * FROM users WHERE email='$email'") or die($mysqli->error());



if($result->num_rows ==0)
{
$_SESSION['message'] = "This user is not a valid user!!!";
header("location: error.php");
} else
{
$user = $result->fetch_assoc();
$result->free();
$userId = $user['id'];
$_SESSION['user_id'] = $userId;



//get students or employee data if available
if( $types == 2)
{
$student_result = $mysqli->query("SELECT * FROM student_data WHERE user_id='$userId'") or die($mysqli->error());
$ayear_result = $mysqli->query("SELECT * FROM academic_year WHERE status=1") or die($mysqli->error());



if($ayear_result->num_rows != 0)
{

$ayear_data = $ayear_result->fetch_assoc();

$ayear_result->free();
}


if($student_result->num_rows != 0)
{

$student_data = $student_result->fetch_assoc();
$student_result->free();
}
}
else
{
$employee_result = $mysqli->query("SELECT * FROM employee_data WHERE user_id='$userId'") or die($mysqli->error());
$employee_types_result = $mysqli->query("SELECT * FROM employee_types") or die($mysqli->error());

if($employee_types_result->num_rows ==0)
{
$_SESSION['message'] = "No Employee types found ";
header("location: error.php");

}else
{
$employee_types_data = array();



while ($row = $employee_types_result->fetch_assoc())
{
$employee_types_data[] = $row;
}


$employee_types_result->free();




}


if($employee_result->num_rows != 0)
{

$employee_data = $employee_result->fetch_assoc();
$employee_result->free();


}

}

}




}
?>