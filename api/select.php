 <?php
    include "../config/connect.php";
    session_start();
    $output = '';
    if ($_POST['topic'] == 'rooms') {
        $sql = "SELECT * FROM rooms  WHERE id = '" . $_POST["id"] . "'";
        $result = $conn->query($sql);
        $output .= ' <table class="table table-bordered">';
        while ($row = $result->fetch_array()) {
            $output .= '  
               <tr>
                    <th>ID</th>
                    <td>' . $row['id'] . '</td>
                </tr>
                <tr>
                    <th>ชื่อห้องประชุม</th>
                    <td>' . $row['name'] . '</td>
                </tr>
                <tr>
                    <th>รายละเอียด</th>
                    <td>' . $row['detail'] . '</td>
                </tr>
           ';
            $output .= '  
           </table> ';
        } 
    } else if($_POST['topic'] == 'user'){
        $sql = "SELECT * FROM users  WHERE id = '" . $_POST["id"] . "'";
        $result = $conn->query($sql);
        $output .= ' <table class="table table-bordered">';
        while ($row = $result->fetch_array()) {
            $output .= '  
                <tr>
                    <th>ID</th>
                    <td>' . $row['id'] . '</td>
                </tr>
                <tr>
                    <th>เลขบัตรประชาชน</th>
                    <td>' . $row['id_card'] . '</td>
                </tr>
                <tr>
                    <th>MEDCODE</th>
                    <td>' . $row['username']. '</td>
                </tr>
                <tr>
                    <th>ชื่อ - สกุล</th>
                    <td>' . $row['TFNAME'] .' '. $row['TLNAME'] .'</td>
                </tr>
                <tr>
                    <th>เพศ</th>
                    <td>' . $row['sex'] . '</td>
                </tr>
           ';
            $output .= '</table>';
        } 
    } else if ($_POST['topic'] == 'booking' || $_POST['topic'] == 'booking-list') {
        $id = $_POST['id'];
        $sql = "SELECT res.*,room.name , room.detail ,cat.topic AS use_for 
                    FROM reservation AS res
                        JOIN rooms AS room ON res.room_id = room.id";
        if(!isset($_SESSION['status_type']) || (isset($_SESSION['status_type']) && ($_SESSION['status_type'] != '1'))){
            $sql .= " JOIN users AS u ON res.member_id = '".$_SESSION['MEDCODE']."'";
        }
        $sql .="  JOIN category AS cat ON res.for = cat.category_id WHERE cat.type = 'use' AND res.id = '" . $_POST['id'] . "' LIMIT 1";
        $result = $conn->query($sql);
        $output .= '<table class="table table-bordered">';
        while ($row = $result->fetch_assoc()) {
            $output .= '
                <tr>
                    <th>ID</th>
                    <td>' . $row['id'] . '</td>
                </tr>
                <tr>
                    <th>วันที่สร้างคำขอ</th>
                    <td>' . $row['create_date'] . '</td>
                </tr>
                <tr>
                    <th>ผู้จอง</th>
                    <td>' . $row['FULLNAME'] . '</td>
                </tr>
                <tr>
                    <th>รายละเอียดห้อง</th>
                    <td>' . $row['detail'] . '</td>
                </tr>
                <tr>
                    <th>หัวเรื่อง</th>
                    <td>' . $row['topic'] . '</td>
                </tr>
                <tr>
                    <th>วันที่จอง</th>
                    <td>' . date('d-m-Y', strtotime($row['begin'])) . '</td>
                </tr>
                <tr>
                    <th>เวลาจอง (วัน / เดือน / ปี)</th>
                    <td>' . date('G:h', strtotime($row['begin'])) . ' น. - ' . date('G:h', strtotime($row['end'])) . ' น.' . '</td>
                </tr>
                <tr>
                    <th>ใช้สำหรับ</th>
                    <td>' . $row['use_for'] . '</td>
                </tr> 
                <tr>
                <th>เบอร์ติดต่อ</th>
                <td>' . $row['phone'] . '</td>
            </tr> 
                 <tr>
                    <th>รายละเอียดเพิ่มเติม</th>
                    <td>' . $row['comment'] . '</td>
                </tr> 
            ';
            if ($_POST['topic'] == 'booking-list' && (isset($_SESSION['status_type']) && $_SESSION['status_type']) == '1') {
                $stats = $row['status'];
                $output .= '<tr>
                                <th>เครื่องมือ</th>
                                <td>
                                <select class="form-control form-control-sm" style="width:100%" type="text" name="status_value" id="status_value" placeholder="ดำเนินการ..." required>';

                $output .= ($stats == 0) ? '<option selected value="0">รอตรวจสอบ</option>' : '<option value="0">รอตรวจสอบ</option>';
                $output .= ($stats == 1) ? '<option selected value="1">อนุมัติ</option>' : '<option value="1">อนุมัติ</option>';
                $output .= ($stats == 2) ? '<option selected value="2">ยกเลิก</option>' : '<option value="2">ยกเลิก</option>';

                $output .= ' </select>
                                <input type="button" name = "status_set" value = "ดำเนินการ" class="btn btn-sm btn-success btn-block mt-2" id = "' . $_POST["id"] . '"/>
                                </td>
                            </tr> ';
            }
        }
        $output .= ' </table> ';
    }

    echo $output;
    ?>