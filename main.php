<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
        integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <link rel="stylesheet" href="css/styleCalendar.css">
    <link rel="stylesheet" href="css/style.css">
    <title>ห้องประชุม</title>
</head>

<body>

    <!-- nav -->
    <?include "ui/nav.php";?>
    <!-- nav -->

    <div class="container-fluid">
        <div class="row mt-3">
            <div class="col-lg-10 col-md-10 mb-2 mx-auto">
                <div class="pb-2 mt-4 mb-2">
                    <h3><u>ปฏิทินการจองห้อง</u></h3>
                </div>
                <div class="form-row" style="background-color:#F0E68C;padding:10px;margin:2px;">
                    <div class="col-sm-6">
                        <label for="name_room" style='color:#2F4F4F'>ห้องประชุม : </label>
                        <select class='form-control form-control-sm' name='name_room' id='name_room'></select>
                    </div>
                    <div class="text-right col-sm-6">
                        <h4 id="monthAndYear" style='color:#2F4F4F'></h4>
                        <button id="prevBtn" class='btn btn-success btn-sm'><i class="fa fa-arrow-left"></i></button>
                        <button id="nextBtn" class='btn btn-success btn-sm'><i class="fa fa-arrow-right"></i></button>
                    </div>
                </div>
                <hr>
                <table id="calendarTable" class="table table-bordered">
                </table>
                <div id='eventPopUp' hidden>
                    <button id="closeEventBtn">&#10006</button>
                    <div id="eventTextArea">
                    </div>
                </div>
                <? include "ui/footer.php"; ?>
            </div>
        </div>
    </div>


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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <script src="js/calendar.js"></script>
    <!-- <script src="js/event.js"></script> -->
</body>

</html>

<script>
$(document).ready(function() {

    $("#name_room").change(function() {
        $("#waitttAmazingLover").addClass("loading");
        $("#waitttAmazingLover").css("display", "block");
        setTimeout(function() {
            var room_id = $('#name_room option:selected').val();
            console.log(room_id);
            generateMonth();
            getEventsAjax(room_id);
            $("#waitttAmazingLover").css("display", "none");
        }, 500);
    });

    // ********************************* autocomplete search 'BUILDING NAME ( ตึก )' ************************************
    option = '';
    $.ajax({
        url: "search.php",
        method: "POST",
        data: {
            topic: 'หาห้องประชุม',
        },
        success: function(data) {
            console.log(data)
            option = '';
            if (data.length > 0) {
                // option +=
                //     "<option value = ''>เลือกห้องประชุม...</option>";
                for (i = 0; i < data.length; i++) {
                    option += "<option value='" + data[i]['id'] + "'>";
                    option += data[i]['name'];
                    option += "</option>";
                }
            } else {
                option +=
                    "<option value = '' selected disabled>ไม่พบห้องประชุม...</option>";
            }
            $('#name_room').html(option);

            var room_id = $('#name_room option:selected').val();
            generateMonth();
            getEventsAjax(room_id);

        }
    })
    // ********************************* autocomplete search 'ROOMS' (END) ************************************
})
</script>