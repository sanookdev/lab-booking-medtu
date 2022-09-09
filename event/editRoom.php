<div class="modal fade" id="edit_room" tabindex="-1" aria-labelledby="edit_room" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">แกไขข้อมูล</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="form_edit">
                    <div class="form-row">
                        <div class="mb-3 col">
                            <label for="date">วันที่</label>
                            <input type="date" class="form-control form-control-sm" placeholder="วันที่เพิ่มเข้า"
                                name="date_edit" disabled required>
                        </div>
                        <div class="mb-3 col">
                            <label for="id_edit">ID</label>
                            <input type="text" class="form-control form-control-sm" placeholder="รหัสห้อง"
                                name="id_edit" disabled required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="name_edit">ห้องประชุม</label>
                        <input type="text" class="form-control form-control-sm" placeholder="ชื่อห้องประชุม"
                            name="name_edit" required>
                    </div>
                    <div class="mb-3">
                        <label for="details_room_edit">รายละเอียดห้อง</label>
                        <textarea rows='4' type="text" class="form-control form-control-sm" placeholder="รายละเอียด"
                            name="details_room_edit"></textarea>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-sm btn-success btn-block">อัพเดต</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>