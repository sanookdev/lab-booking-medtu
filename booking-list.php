<?
    include "config/connect.php";
    include "function.php";
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
        integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

    <link rel="stylesheet" href="css/style.css">
    <title>จองห้องประชุม</title>

    <style>
    .fixed-height {
        padding: 1px;
        max-height: 200px;
        overflow: auto;
    }

    input[type="checkbox"] {
        cursor: pointer !important;
    }
    </style>
</head>

<body>

    <!-- nav -->
    <?
    include "ui/nav.php";
    
    $myRes = array();
    $sql = "SELECT res.*,room.name ,room.detail
                FROM reservation AS res
                    JOIN rooms AS room ON res.room_id = room.id";
    if($_SESSION['MEDCODE'] != "ADMIN"){
        $sql .= " WHERE res.member_id = '".$_SESSION['MEDCODE']."'";
    }                 
    $sql .=" ORDER BY res.create_date  DESC";
    $result = $conn->query($sql) or die('error SQL');
    if($result->num_rows >0){
        $i = 0; 
        while($row = $result->fetch_assoc()){
                $data[$i] = $row;
                $myRes[$i]['id'] = $row['id'];
                $myRes[$i]['topic'] = $row['topic'];
                $myRes[$i]['room_name'] = $row['name'];
                $myRes[$i]['date_book'] = date('d-m-Y',strtotime($row['begin']));
                $myRes[$i]['time_start'] = date('H:i',strtotime($row['begin']))." น.";
                $myRes[$i]['time_end'] = date('H:i',strtotime($row['end']))." น.";
                $myRes[$i]['create_date'] = date('d-m-Y G:h',strtotime($row['create_date']));
                $myRes[$i]['status'] = $row['status'];
                $myRes[$i]['phone'] = $row['phone'];
                $i++;
        }
    }
    ?>

    <!-- dashboard contents -->
    <div class="container-fluid">
        <div class="row mt-3">
            <div class="col-lg-10 col-md-10 mb-2 mx-auto">
                <div class="pb-2 mt-4 mb-2">
                    <h3><u>รายการจองห้อง</u></h3>
                </div>
                <table class="table table-bordered shadow" id="data-table" style="width:100%">
                    <thead class="table-dark text-center">
                        <tr>
                            <th width="5%">#</th>
                            <th width="20%">ชื่อเรื่อง</th>
                            <th>ชื่อห้อง</th>
                            <th>วันที่จอง (ว/ด/ป)</th>
                            <th>เวลาจอง</th>
                            <th>เบอร์ติดต่อ</th>
                            <th width="12%">รายละเอียด</th>
                            <th width="9%">สถานะ</th>
                            <?if(isset($_SESSION['status_type']) && $_SESSION['status_type'] == '1'){?>
                            <th width="5%">ลบ</th>
                            <?}?>
                        </tr>
                    </thead>
                    <tbody class="bg-light text-center">
                        <?
                    if(count($myRes > 0)){
                        for($i = 0 ; $i < count($myRes) ; $i++){?>
                        <tr>
                            <td><?= $i + 1; ?></td>
                            <td><?= $myRes[$i]['topic']; ?> </td>
                            <td><?= $myRes[$i]['room_name']; ?>
                            </td>
                            <td><?= $myRes[$i]['date_book']; ?> </td>
                            <td><?= $myRes[$i]['time_start'] . "-" . $myRes[$i]['time_end']; ?> </td>
                            <td><?= $myRes[$i]['phone']; ?> </td>
                            <td>
                                <button type="button" name="details" class="btn btn-sm btn-block btn-info view_data"
                                    id="<?= $myRes[$i]['id']; ?>">
                                    <i class="fa fa-list"></i> รายละเอียด</button>
                            </td>
                            <td>
                                <?if($myRes[$i]['status'] == 0){?>
                                <input type="button" value="รอตรวจสอบ" name="status"
                                    class="btn btn-sm btn-block btn-warning" style='opacity:1;' disabled />
                                <?}else if ($myRes[$i]['status'] == 1){?>
                                <input type="button" value="อนุมัติ" name="status"
                                    class="btn btn-sm btn-block btn-success" style='opacity:1' disabled />
                                <?}else{?>
                                <input type="button" value="ยกเลิก" name="status"
                                    class="btn btn-sm btn-block btn-danger" style='opacity:1' disabled />
                                <?}?>
                            </td>
                            <?if(isset($_SESSION['status_type']) && $_SESSION['status_type'] == '1'){?>

                            <td>
                                <button type="button" class="btn btn-danger btn-sm delete_data" name="delete_data"
                                    id="<?= $myRes[$i]['id']; ?>">
                                    <i class="fa fa-remove" aria-hidden="true"></i>
                                </button>
                            </td>
                            <?}?>
                        </tr>
                        <?}
                    }?>
                    </tbody>
                </table>
                <button class="btn btn-success  pull-right add_data" href="#" data-toggle="modal"
                    data-target="#add_booking">
                    <i class="fa fa-plus mr-2" aria-hidden="true"></i>จองห้อง
                </button>
            </div>
        </div>
    </div>

    <!-- Add Job Modal -->
    <? include "event/addBooking.php";?>

    <!-- Rooms Details Model -->
    <? include "event/view_details.php";?>

    <!-- Edit Job Detaisl -->
    <? include "event/editRoom.php";?>


    <!-- Optional JavaScript -->
    <!-- Popper.js first, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"
        integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
        integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous">
    </script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <!-- <script src="js/event.js"></script> -->




    <!-- ******************************************* JS ********************************************* -->

    <script>
    console.log(<?= json_encode($_SESSION); ?>);
    $(document).ready(function() {

        status_err = false;
        // ************************** DATA TABLE *************************
        $('#data-table').DataTable({
            "bInfo": false,
            "bLengthChange": false,
            "bPaginate": true,
            "bFilter": false,
            "pagingType": "full_numbers"
        });
        // ************************** DATA TABLE (END) *************************



        // --------------------------- VIEW DATA ---------------------------
        $(document).on('click', '.view_data', function() {
            var id = $(this).attr("id");
            console.log(id);
            if (id != '') {
                $.ajax({
                    url: "select.php",
                    method: "POST",
                    data: {
                        id: id,
                        topic: 'booking-list'
                    },
                    success: function(data) {
                        $('#showData').html(data);
                        $('#room_details').modal('show');
                    }
                });
            }
        });
        // --------------------------- VIEW DATA (END---------------------------



        // --------------------------- INSERT DATA ---------------------------

        $('.add_data').on('click', function() {
            $.ajax({
                url: "search.php",
                method: "POST",
                data: {
                    topic: 'หาห้องประชุม'
                },
                success: function(data) {
                    // console.log(data);
                    option = "";
                    if (data.length > 0) {
                        for (i = 0; i < data.length; i++) {
                            option += "<option value='" + data[i]['id'] + "'>";
                            option += data[i]['name'];
                            option += "</option>";
                            $('#start_date').prop('disabled', false);
                            $('#end_date').prop('disabled', false);
                        }
                    } else {
                        option +=
                            "<option value = '' selected disabled>ไม่พบห้องประชุม...</option>";
                        $('#start_date').prop('disabled', true);
                        $('#end_date').prop('disabled', true);
                    }
                    $('#name_room').html(option);
                }
            })

            $.ajax({
                url: "search.php",
                method: "POST",
                data: {
                    topic: 'ใช้สำหรับ'
                },
                success: function(data) {
                    console.log(data);
                    option = "";
                    if (data.length > 0) {
                        for (i = 0; i < data.length; i++) {
                            option += "<option value='" + data[i]['category_id'] + "'>";
                            option += data[i]['topic'];
                            option += "</option>";
                        }
                    } else {
                        option +=
                            "<option value = '' selected disabled>ไม่พบการใช้สำหรับ...</option>";
                    }
                    $('#for').html(option);
                }
            })
        })

        // เวลา เริ่ม - สิ้นสุด
        $('[name = end_date]').on('change', function() {

            begin = $('[name = start_date]').val();
            end = $('[name = end_date]').val();
            begin = begin.replace('T', ' ');
            end = end.replace('T', ' ');
            room_id = $('#name_room').val();
            // console.log(begin + ' ' + end);

            if (begin != '' && end != '') {
                $.ajax({
                    url: "search.php",
                    method: "POST",
                    data: {
                        topic: 'เช็คเวลา',
                        begin: begin,
                        end: end,
                        room_id
                    },
                    success: function(data) {
                        // console.log(data);
                        var msg = '';
                        if (data == 1) {
                            msg =
                                "<span class = 'success'>สามารถจองในช่วงเวลาดังกล่าวได้...</span>";
                            status_err = false;
                            $('.btn_submit').prop('disabled', false);
                        } else {
                            time_begin = data[0]['begin'].split(' ')[1];
                            time_end = data[0]['end'].split(' ')[1];
                            // console.log(time_begin + " " + time_end);
                            msg =
                                "<span class = 'error'>!! ไม่สามารถจองช่วงเวลาดังกล่าวได้...</span><br>";
                            msg += "<span class = 'error'>มีผู้จองเวลา : " + time_begin +
                                " น.-" +
                                time_end +
                                " น.</span>";
                            status_err = true;
                            $('.btn_submit').prop('disabled', true);
                        }
                        $('.start_err').html(msg);
                    }
                })
            }
        })

        $('[name = start_date]').on('change', function() {

            begin = $('[name = start_date]').val();
            end = $('[name = end_date]').val();
            begin = begin.replace('T', ' ');
            end = end.replace('T', ' ');
            room_id = $('#name_room').val();
            // console.log(begin + ' ' + end);

            if (begin != '' && end != '') {
                $.ajax({
                    url: "search.php",
                    method: "POST",
                    data: {
                        topic: 'เช็คเวลา',
                        begin: begin,
                        end: end,
                        room_id
                    },
                    success: function(data) {
                        // console.log(data);
                        var msg = '';
                        if (data == 1) {
                            msg =
                                "<span class = 'success'>สามารถจองในช่วงเวลาดังกล่าวได้...</span>";
                            status_err = false;
                            $('.btn_submit').prop('disabled', false);
                        } else {
                            time_begin = data[0]['begin'].split(' ')[1];
                            time_end = data[0]['end'].split(' ')[1];
                            // console.log(time_begin + " " + time_end);
                            msg =
                                "<span class = 'error'>!! ไม่สามารถจองช่วงเวลาดังกล่าวได้...</span><br>";
                            msg += "<span class = 'error'>มีผู้จองเวลา : " + time_begin +
                                " น.-" +
                                time_end +
                                " น.</span>";
                            status_err = true;
                            $('.btn_submit').prop('disabled', true);
                        }
                        $('.start_err').html(msg);
                    }
                })
            }
        })

        // insert confirm submit
        $('#insertBooking').on("submit", function(event) {
            event.preventDefault();
            data = {};
            checkbox = '';
            i = 0;
            $("input:checkbox[name=acs]:checked").each(function() {
                if (i != 0) {
                    checkbox += ',';
                }
                checkbox += $(this).val();
                i++;
            });

            data['id_room'] = $('select[name=name_room]').val();
            data['id_card'] = <?= json_encode($_SESSION['MEDCODE']);?>;
            data['FULLNAME'] = <?= json_encode($_SESSION['FULLNAME']);?>;
            data['subject'] = $('input[name=topic]').val();
            data['details'] = $('#details_booking').val();
            data['start_date'] = $('input[name=start_date]').val().replace('T', " ");
            data['end_date'] = $('input[name=end_date]').val().replace('T', " ");
            data['for'] = $('select[name=for]').val();
            data['phone'] = $('input[name=phone]').val();
            console.log(data['acs']);
            $.ajax({
                url: "insert.php",
                method: "POST",
                dataType: "json",
                data: {
                    data,
                    topic: 'reservation',
                },
                beforeSend: function() {
                    $('#insertBooking').val("Inserting");
                },
                success: function(data) {
                    $('#insertBooking')[0].reset();
                    $('#add_booking').modal('hide');
                    sessionStorage.setItem('add_order', '1');
                    window.location.reload();
                }
            });
        });
        // --------------------------- INSERT DATA (END) ---------------------------



        // --------------------------- DELETE DATA ---------------------------
        $(document).on('click', '.delete_data', function() {
            var id = $(this).attr("id");
            var where = "id=" + id;
            var table = "reservation";
            if (id != '') {
                Swal.fire({
                    title: 'ลบข้อมูล ?',
                    text: "ท่านแน่ใจว่าต้องการลบข้อมูล !",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: 'red',
                    cancelButtonColor: 'grey',
                    confirmButtonText: 'ลบข้อมูล !'
                }).then((result) => {
                    if (result.value) {
                        sessionStorage.setItem('delete_order', '1');
                        $.ajax({
                            url: "delete.php",
                            method: "POST",
                            data: {
                                table: table,
                                id: id,
                                where: where
                            },
                            success: function(data) {
                                console.log(data);
                                window.location.reload();
                            }
                        });
                    }
                })
            }
        });
        // --------------------------- DELETE DATA (END) ---------------------------

        // --------------------------- UPDATE STATUS ---------------------------
        $(document).on('click', 'input[name = "status_set"]', function() {
            var id = $(this).attr("id");
            var where = "id=" + id;
            var table = "reservation";
            var data = [];
            data[0] = $('#status_value').val();
            var key = [];
            key[0] = 'status';

            console.log('id = ' + id);
            console.log('value = ' + data[0]);
            Swal.fire({
                title: 'ต้องการปรับสถานะ ?',
                text: "ต้องการปรับสถานะ !",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: 'green',
                cancelButtonColor: 'grey',
                confirmButtonText: 'บันทึก !'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "update.php",
                        method: "POST",
                        data: {
                            data,
                            table: table,
                            where: where,
                            key: key
                        },
                        success: function(data) {
                            sessionStorage.setItem('status_order', '1');
                            window.location.reload();
                        }
                    });
                }
            })
        });
        // --------------------------- CHANGE STATUS (END) ---------------------------



        // --------------------------- use_for ---------------------------

        // var $option = $('<option selected><?= isset($_POST['for']) ? $_POST['for'] : '' ?></option>')
        //     .val('<?= isset($_POST['for']) ? $_POST['for'] : '' ?>');
        // $("select[name=for]").append($option).trigger('change'); // append the option and update Select2
        // $("select[name=for]").select2({
        //     minimumResultsForSearch: -1,
        //     tags: true,
        //     templateSelection: function(state) {
        //         if (state.id === '') {
        //             return 'choose...';
        //         }
        //         return state.text;
        //     },
        //     ajax: {
        //         url: 'search.php',
        //         dataType: 'json',
        //         type: "POST",
        //         quietMillis: 100,
        //         data: ({
        //             topic: 'ใช้สำหรับ'
        //         }),
        //         processResults: function(data) {
        //             // console.log(data);
        //             return {
        //                 results: $.map(data, function(item) {
        //                     return {
        //                         text: item.topic,
        //                         id: item.category_id,
        //                     }
        //                 })
        //             };
        //         }
        //     }
        // });



        // --------------------------- send event after refresh page for show "sweetalert" ---------------------------
        $(function() {
            if (sessionStorage.getItem('delete_order') == '1') {
                Swal.fire({
                    position: 'bottom-end',
                    icon: 'error',
                    title: 'ลบข้อมูลเรียบร้อยแล้ว',
                    showConfirmButton: false,
                    timer: 1500
                });
                sessionStorage.setItem('delete_order', '0');
            }
            if (sessionStorage.getItem('add_order') == '1') {
                Swal.fire({
                    position: 'bottom-end',
                    icon: 'success',
                    title: 'บันทึกข้อมูลเรียบร้อยแล้ว',
                    showConfirmButton: false,
                    timer: 1500
                });
                sessionStorage.setItem('add_order', '0');

            }
            if (sessionStorage.getItem('edit_order') == '1') {
                Swal.fire({
                    position: 'bottom-end',
                    icon: 'success',
                    title: 'อัพเดตข้อมูลเรียบร้อยแล้ว',
                    showConfirmButton: false,
                    timer: 1500
                });
                sessionStorage.setItem('edit_order', '0');

            }
            if (sessionStorage.getItem('status_order') == '1') {
                Swal.fire({
                    position: 'bottom-end',
                    icon: 'success',
                    title: 'อัพเดตข้อมูลเรียบร้อยแล้ว',
                    showConfirmButton: false,
                    timer: 1500
                });
                sessionStorage.setItem('status_order', '0');

            }

        });
        // --------------------------- send event after refresh page for show "sweetalert" ( END ) ---------------------------

    });
    </script>

</body>

</html>