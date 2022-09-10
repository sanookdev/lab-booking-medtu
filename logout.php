<?
    session_start();
    include "./config/connect.php";
    $sql = "INSERT INTO `log`(medcode,stats) VALUE('".$_SESSION['MEDCODE']."','0')";
    $conn->query($sql);
    session_destroy();
    header('location: login.php');
?>