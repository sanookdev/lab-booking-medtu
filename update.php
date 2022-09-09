<?php
include "config/connect.php";
include "function.php";

if (!empty($_POST)) {
    $data = array();
    for ($i = 0; $i < count($_POST['key']); $i++) {
        if($_POST['key'][$i] == 'password'){
            $data[$_POST['key'][$i]] = encryptIt($_POST['data'][$i]);

        }else{
            $data[$_POST['key'][$i]] = trim(mysqli_real_escape_string($conn,$_POST['data'][$i]));
        }
    }
    if (update($_POST['table'], $data,  $_POST['where'], $conn) == true) {
        echo "1";
    } else {
        echo "0";
    }
}