 <?php
    include "config/connect.php";
    include "function.php";

    $where = $_POST['where'];
    $table = $_POST['table'];
    $sql = "SELECT * FROM $table WHERE $where";
    $result = $conn->query($sql);
    $result = $result->fetch_array();
    // $result['password'] = decryptIt($result['password']);
    echo json_encode($result);
?>