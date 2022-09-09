<?
    include "./config.php";
    $conn = new mysqli(HOSTDB,USERDB,PASSDB,NAMEDB);
    if($conn->connect_error) { alert("can't connect db"); } 

?>