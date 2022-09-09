<?php
header("Content-type: application/json; charset=utf-8");

include "config/connect.php";
include "function.php";

if (!empty($_POST)) {
    if (isset($_POST['topic']) && $_POST['topic'] == 'reservation') {
        $_POST['table'] = 'reservation(`room_id`,`member_id`,`FULLNAME`,`topic`,`comment`, `begin`,`end`,`for`,`phone`)';
    }else if(isset($_POST['topic']) && $_POST['topic'] == 'addUser'){
        $_POST['table'] = 'users(`username`,`TFNAME`,`TLNAME`,`id_card`,`sex`,`password`)';
        $_POST['data']['username'] = strtoupper($_POST['data']['username']);
        $_POST['data']['password'] = encryptIt($_POST['data']['password']);
    }
    if (insert($_POST['table'], $_POST['data'], $conn) == true) {
        echo "1";
    } else {
        echo "0";
    }
}