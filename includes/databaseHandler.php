<?php

// Content of database.php
include "../config/userpassDb.php";

$mysqliConn = mysqli_connect($hostDb, $userDb ,$passDb,$nameDb);
// $mysqliConn = mysqli_connect('localhost', 'root', '', 'booking-med');

if (!$mysqliConn){
    die("Could not connect to database: ".mysqli_connect_error());
}


?>