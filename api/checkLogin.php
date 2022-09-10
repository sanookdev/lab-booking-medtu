<?php
// include "config/connect.php";
date_default_timezone_set('Asia/Bangkok');
session_start();
include '../function.php';
include '../config/userpassDb.php';
$uname =  strtoupper(trim($_POST['username']));
$password = strtoupper(trim($_POST['password']));

if($uname != "ADMIN"){
  $jsonurl = 'http://203.131.209.236/_authen/getProfile.php?user_login=' . $uname . '&user_pwd='.$password;
  $json = file_get_contents($jsonurl);
  $returnInfo = json_decode($json, true);
  $data = $returnInfo;
  $_SESSION = $returnInfo[0];
  if (count($_SESSION) > 0) {
    $output = '1';
    $_SESSION['status_type'] = '0';
  } else {
    $output = '0';
  }
}
else{
    $conn = new mysqli($hostDb, $userDb ,$passDb,$nameDb);mysqli_set_charset($conn,"utf8");
    if($conn->connect_error) { alert("can't connect db"); } 
    $sql = "SELECT id_card AS ID_CODE, username AS medcode, status_type ,`password` 
                    , CONCAT(TFNAME,' ',TLNAME) AS FULLNAME FROM users 
                        WHERE username = '$uname' AND `password` = '$password' LIMIT 1";
                        // echo $sql;
    $result = $conn->query($sql) or die($conn->error());
    if($result->num_rows == 1){
      $data = $result->fetch_array();
      $output = '1';
      $_SESSION['FULLNAME'] = $data['FULLNAME'];
      if($uname = 'ADMIN'){
        $_SESSION['status_type'] = $data['status_type'];
      }
    }else{
      $output = '0';
    }
    $conn->close();
}
if(count($_SESSION) > 0){
  $conn = new mysqli($hostDb, $userDb ,$passDb,$nameDb);mysqli_set_charset($conn,"utf8");
  if($conn->connect_error) { alert("can't connect db"); } 
  $sql = "INSERT INTO `log`(medcode,stats) VALUE('".$uname."','1')";
  $conn->query($sql);
  $_SESSION['MEDCODE'] = $uname;
  $conn->close();
  echo json_encode($_SESSION);
}else{
  echo "0";
  session_destroy();
}