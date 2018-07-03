<<<<<<< HEAD:test.php
<?php
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "myDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, firstname, lastname FROM MyGuests";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
    }
} else {
    echo "0 results";
}
$conn->close();
?>
=======
<?php
/**
 * Created by PhpStorm.
 * User: BlackLion
 * Date: 3/22/2018
 * Time: 11:24 AM
 */

require 'db.php';

$sql = "UPDATE academic_year SET status='0' WHERE id='8'";


$mysqli->query($sql);

>>>>>>> cf27c4ac5bb9215d442e525aee1b6de43ebcc889:cron.php
