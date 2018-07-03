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

