<?
    session_start();
    $conn = new mysqli('192.168.66.17', 'medtu' ,'tmt@medtu','lab_booking');mysqli_set_charset($conn,"utf8");
    if($conn->connect_error) { alert("can't connect db"); } 
    $sql = "INSERT INTO `log`(medcode,stats) VALUE('".$_SESSION['MEDCODE']."','0')";
    $conn->query($sql);
    session_destroy();
    header('location: login.php');
?>