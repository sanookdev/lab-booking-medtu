<div class="modal fade" id="add_employee" tabindex="-1" aria-labelledby="add_employee" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">เพิ่มผู้ใช้งาน</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="insert">
                    <div class="mb-3">
                        <input type="text" class="form-control form-control-sm" minlength="13" maxlength="13"
                            id="id_card" placeholder="บัตรประชาชน" required>
                    </div>
                    <div class="form-row">
                        <div class="mb-3 col">
                            <input type="text" class="form-control form-control-sm"
                                placeholder="username (รหัสนักศึกษา)" id="username" required>
                        </div>
                        <div class="mb-3 col">
                            <input type="text" class="form-control form-control-sm" placeholder="password" id="password"
                                required>
                        </div>
                        <select id="sex" class="form-control form-control-sm mb-3 col" required>
                            <option value="">เพศ</option>
                            <option value="ชาย">ชาย</option>
                            <option value="หญิง">หญิง</option>
                        </select>
                    </div>

                    <div class="form-row">
                        <div class="mb-3 col">
                            <input type="text" class="form-control form-control-sm" placeholder="ชื่อ..." id="TFNAME"
                                required>
                        </div>
                        <div class="mb-3 col">
                            <input type="text" class="form-control form-control-sm" placeholder="นามสกุล..." id="TLNAME"
                                required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-sm btn-success btn-block add_user">บันทึก</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>