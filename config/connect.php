<?
require_once "userpassDb.php";
$conn = new mysqli($hostDb,$userDb,$passDb,$nameDb);
if($conn->connect_error) { alert("can't connect db"); } 
$conn -> set_charset("utf8");
date_default_timezone_set("Asia/Bangkok");

?>