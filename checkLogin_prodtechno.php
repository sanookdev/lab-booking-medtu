<?php
// include "config/connect.php";
date_default_timezone_set('Asia/Bangkok');
session_start();
include 'function.php';
include './config/userpassDb.php';
$uname =  strtoupper(trim($_POST['username']));
$password = strtoupper(trim($_POST['password']));

if($uname != "ADMIN"){
  $sql = "SELECT
	          CONCAT(personal.appm_personnel.TFNAME,' ',personal.appm_personnel.TLNAME) 
              AS FULLNAME,	personal.appm_personnel.TFNAME,personal.appm_personnel.TLNAME,
                personal.appm_personnel.USERNAME,personal.appm_personnel.ID_CODE
	                FROM personal.appm_personnel
	                  WHERE personal.appm_personnel.USERNAME='".$uname."' AND personal.appm_personnel.PASSWORD='".$password."' LIMIT 1";
  $conn2 = new mysqli('192.168.66.1','root','medadmin','personal');
  if($conn2->connect_error) { alert("can't connect db"); } 
  $conn2 -> set_charset("utf8");

  $result = $conn2->query($sql) or die($conn2->error());
  if($result->num_rows == 1){
    $data = $result->fetch_array();
    for($i = 0 ; $i < 5 ; $i++){
      unset($data[$i]);
    }
    // print_r($data);
    $output = '1';
    $_SESSION = $data;
  }else{
    $output = '0';
  }
  $conn2->close();
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
      if($uname == 'ADMIN'){
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