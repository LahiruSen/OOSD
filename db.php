<?php
/* Database connection settings */
require 'config.php';
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'oosd';
$mysqli = new mysqli($host,$user,$pass,$db) or die($mysqli->error);



function query_to_array($query,$connection)
{
    $result = $connection->query($query);

    $data = array();

    while($row  = $result->fetch_assoc())
    {
        $data = $row;
    }

    $result->free();

    return $data;


}