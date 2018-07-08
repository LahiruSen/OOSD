
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

    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    if ($types == 2) {
        header("location: home_student.php");
        die();
    }
    else {
        if (isset($_SESSION['email'])) {
            $email = $_SESSION['email'];
            $current_employee_type_result = $mysqli->query("select DISTINCT employee_types.title,employee_types.id from employee_types, users, employee_data where users.email = '$email' and employee_types.id = employee_data.employee_type_id") or die($mysqli->error());
            if ($current_employee_type_result->num_rows != 0) {
                $current_employee_type_data = $current_employee_type_result->fetch_assoc();
                $current_employee_type_result->free();
                $type_of_employment = $current_employee_type_data['title'];
            } else {
                $_SESSION['message'] = "Not a valid email address";
                header("location:error.php");

            }

            $titleErr;
            $descriptionError;

            if (isset($type_of_employment)) {
                if ($type_of_employment = 'Administrator') {

                    if ($_SERVER["REQUEST_METHOD"] == "POST") {

                        if (empty($_POST["title"])) {
                            $titleErr = "Please select enter a title for the scholarship";
                        } else {
                            $title1 = test_input($_POST["title"]);
                            if (!preg_match("/^[a-zA-Z0-9 ]*$/", $title1)) {

                                $titleErr = "Title only can contain letters and numbers";
                            }

                        }

                        if (empty($_POST["description"])) {
                            $descriptionErr = "Please select enter a description for the scholarship";
                        } else {
                            $description1 = test_input($_POST["description"]);
                            if (!preg_match("/^[a-zA-Z0-9. ]*$/", $description1)) {
                                $descriptionErr = "Description only can contain letters and numbers";
                            }

                        }

                        if (!empty($titleErr) or !empty($descriptionErr)) {
                            $_SESSION['message'] = $titleErr . '<br>' . $descriptionErr ;
                            header("location: error.php");
                            die();
                        }
                        else{
                            $date_of_create= $mysqli->escape_string( date("Y-m-d H:i:s"));
                            $date_of_update= $mysqli->escape_string( date("Y-m-d H:i:s"));

                            $sql = "INSERT INTO scholarships(title,description,date_of_create,date_of_update) "
                                . "VALUES ('$title1','$description1','$date_of_create','$date_of_update')";


                            if ( $mysqli->query($sql) ) {

                                $_SESSION['message']="New scholarship has been successfully added.";
                                header("location: success.php");
                                die();

                            }
                            else{
                                $_SESSION['message']="Sorry. New scholarship couldn't be created.";
                                header("location: error.php");
                                die();
                            }






                        }





                    }




                }

            } else {
                $_SESSION['message'] = "Only Administrator have access to this area";
                header("location:error.php");
                die();
            }

        } else {
            $_SESSION['message'] = "This session has expired. Please login again!!!";
            header("location:error.php");
            die();
        }


    }




}