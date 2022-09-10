<?
    header("Content-type: application/json; charset=utf-8");
    
    // require('../config/connect.php');
    require('./services.php');

    // if use axios open comment this
    // $_POST = json_decode(file_get_contents("php://input"),true); 

    $access = new DB_con();
    $topic = $_POST['topic'];
    // print_r($_POST);
    $result = array();
    if($topic == 'searchRooms'){
        $sql = "SELECT name,id,detail FROM rooms";
        $result = $access->select($sql);
    }else if($topic == 'useFor'){
        $sql = "SELECT `topic`,`category_id` FROM category WHERE type = 'use'";
        $result = $access->select($sql);
    }else if($topic == 'checkTimeValidate'){
        $begin = $_POST['begin'];
        $end = $_POST['end'];
        $room_id = $_POST['room_id'];
        $sql = "
                SELECT * FROM reservation
                    WHERE 
                        (`begin` <= '$begin' AND '$begin' < `end`)
                            OR (`begin` < '$end' AND '$end' <= `end`)
                                OR ('$begin' <= `begin` AND `begin` < '$end')
                            LIMIT 1
        ";
        $result = $access->select($sql);
        if(count($result) > 0){
            $result = $result;
        }else{
            $result = 1;
        }
    }
    echo json_encode($result);
?>