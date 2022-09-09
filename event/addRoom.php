    <div class="modal fade" id="add_room" tabindex="-1" aria-labelledby="add_room" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">เพิ่มห้องประชุม</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="insert">
                        <div class="mb-3">
                            <label for="name_room">ชื่อห้องประชุม</label>
                            <input type="text" class="form-control form-control-sm" placeholder="ชื่อห้องประชุม"
                                name="name_room" required>
                        </div>
                        <div class="mb-3">
                            <label for="details_rooms">รายละเอียดเพิ่มเติม</label>
                            <textarea class="form-control form-control-sm" name="details_rooms" rows='3' cols='50'
                                placeholder="กรุณากรอกรายละเอียด"></textarea>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-sm btn-success btn-block">บันทึก</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>