<?

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if(isset($_SESSION['status_type'])){
        header('Location: ./main.php');
    }else{
        header('Location: ./login.php');
    }
?>