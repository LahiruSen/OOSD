<?php
/* Displays all error messages */
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Error</title>
  <?php include 'css/css.html'; ?>
</head>
<body>
<div class="form">
    <h1><?= 'Error'; ?></h1>
    <p class="text-danger">
    <?php 
    if( isset($_SESSION['message']) ):
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    else:
        header( "location: index.php" );
    endif;
    ?>
    </p>     
    <a href="index.php"><button class="button button-block">Home</button></a>
</div>
</body>
</html>
