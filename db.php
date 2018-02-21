<?php
/* Database connection settings */
require 'config.php';
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'oosd';
$mysqli = new mysqli($host,$user,$pass,$db) or die($mysqli->error);

