<?
header("Content-type: application/json; charset=utf-8");
include "config/connect.php";
include "function.php";

$getVal = $_POST['topic'];
if($getVal == 'ห้องประชุม'){
    $rs = select("SELECT `name`,`id` FROM rooms", $conn);
}
else if($getVal == 'ใช้สำหรับ'){
    $rs = select("SELECT `topic`,`category_id` FROM category WHERE type = 'use'", $conn);
}
else if($getVal == 'อุปกรณ์'){
    $rs = select("SELECT `topic`,`category_id` FROM category WHERE type = 'accessories'", $conn);
}
else if ($getVal =='ตึก'){
    $rs = select("SELECT * FROM building",$conn);
}
else if ($getVal =='ชั้น'){
    $building_id = $_POST['building_id'];
    $rs = select("SELECT c.*,c.id,b.id AS building_id ,b.building_name FROM class AS c
                    LEFT JOIN building AS b ON b.id = c.building_id WHERE building_id = '$building_id'
                        ORDER BY c.class_no ASC ",$conn);
}
else if ($getVal =='หาห้องประชุม'){
    $rs = select("SELECT name,id,detail FROM rooms",$conn);
}

else if ($getVal =='เช็คเวลา'){
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
    $rs = select($sql
                                    ,$conn);
    if(count($rs) > 0){
        $rs = $rs;
    }else{
        $rs = 1;
    }
}

echo json_encode($rs);
?>