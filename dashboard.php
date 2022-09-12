<!-- nav -->
<?
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if($_SESSION['status_type'] != '1'){
            exit();
        }




        include "config/connect.php";
        include "function.php";
        $sql = "SELECT * FROM reservation";
        $result = $conn->query($sql);
        $numRes = $result->num_rows;

        $sql = "SELECT * FROM reservation WHERE `status` = '1'";
        $result = $conn->query($sql);
        $numResApprove = $result->num_rows;

        $sql = "SELECT * FROM reservation WHERE `status` = '0'";
        $result = $conn->query($sql);
        $numResWaiting = $result->num_rows;
    ?>
<!-- nav -->

<!-- หน้าแรก -->
<div class="row mt-3">
    <div class="col-12">
        <div class="card card-border">
            <div class="card-body">
                SESSION :
                <? 
                        foreach($_SESSION as $index => $val) {
                            echo "$index = $val , ";
                        }
                        
                        ?>
            </div>
        </div>
    </div>

</div>
<div class="row mt-3">
    <div class="col-lg-4 col-md-4">
        <div class="card card-border">
            <div class="card-body">
                <h4 class="card-title">
                    <?echo $numRes;?><small class="text-muted"> รายการจองทั้งหมด</small>
                </h4>
            </div>
            <div class="list-group list-group-flush">
                <a href="booking-list.php" class="list-group-item list-group-item-primary">ดูทั้งหมด</a>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4">
        <div class="card card-border">
            <div class="card-body">
                <h4 class="card-title text-success">
                    <?echo $numResApprove;?> <small> รายการจองที่อนุมัติ</small>
                </h4>
            </div>
            <div class="list-group list-group-flush">
                <a href="booking-list.php" class="list-group-item list-group-item-primary"> ดูทั้งหมด</a>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4">
        <div class="card card-border">
            <div class="card-body">
                <h4 class="card-title text-warning">
                    <?echo $numResWaiting;?> <small>รายการจองที่รอตรวจสอบ</small>
                </h4>
            </div>
            <div class="list-group list-group-flush">
                <a href="booking-list.php" class="list-group-item list-group-item-primary">ดูทั้งหมด</a>
            </div>
        </div>
    </div>
</div>
<!-- หน้าแรก (สิ้นสุด) -->