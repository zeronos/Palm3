var addModal =
`
<div class="modal fade" id="addModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header header-modal">
                <h4 class="modal-title">เพิ่มสวนปาล์ม</h4>
            </div>
            <div class="modal-body" id="addModalBody">
                <div class="row mb-4">
                    <div class="col-xl-3 col-12 text-right">
                        <span>ชื่อสวนปาล์ม</span>
                    </div>
                    <div class="col-xl-9 col-12">
                        <input type="text" class="form-control" id="rank">
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-xl-3 col-12 text-right">
                        <span>อำเภอ</span>
                    </div>
                    <div class="col-xl-9 col-12">
                        <select id="amp" class="form-control">
                            <option selected>เลือกอำเภอ</option>
                            <option>เมือง</option>
                            <option>กำแพงแสน</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-xl-3 col-12 text-right">
                        <span>จังหวัด</span>
                    </div>
                    <div class="col-xl-9 col-12">
                        <select id="province" class="form-control">
                            <option selected>เลือกจังหวัด</option>
                            <option>กรุงเทพ</option>
                            <option>นครปฐม</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-xl-3 col-12 text-right">
                        <span>เจ้าของสวนปาล์ม</span>
                    </div>
                    <div class="col-xl-9 col-12">
                        <select id="amp" class="form-control">
                            <option selected>เลือกเกษตร</option>
                            <option>บรรยาวัชร</option>
                            <option>ธารินทร์</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success">ยืนยัน</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">ยกเลิก</button>
            </div>
        </div>
    </div>
</div>

`;


var addSubGardenModal =
`
<div class="modal fade" id="addSubGardenModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header header-modal">
                <h4 class="modal-title">เพิ่มแปลง</h4>
            </div>
            <div class="modal-body" id="addModalBody">
                <div class="row mb-4">
                    <div class="col-xl-3 col-12 text-right">
                        <span>ชื่อแปลง</span>
                    </div>
                    <div class="col-xl-9 col-12">
                        <input type="text" class="form-control" id="rank">
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-xl-3 col-12 text-right">
                        <span>จำนวนไร่</span>
                    </div>
                    <div class="col-xl-9 col-12">
                        <input type="text" class="form-control" id="firstname">
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-xl-3 col-12 text-right">
                        <span>จำนวนต้นไม้</span>
                    </div>
                    <div class="col-xl-9 col-12">
                        <input type="text" class="form-control" id="lastname">
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-xl-3 col-12 text-right">
                        <span>อำเภอ</span>
                    </div>
                    <div class="col-xl-9 col-12">
                        <select id="amp" class="form-control">
                            <option selected>เลือกอำเภอ</option>
                            <option>เมือง</option>
                            <option>กำแพงแสน</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-xl-3 col-12 text-right">
                        <span>จังหวัด</span>
                    </div>
                    <div class="col-xl-9 col-12">
                        <select id="province" class="form-control">
                            <option selected>เลือกจังหวัด</option>
                            <option>กรุงเทพ</option>
                            <option>นครปฐม</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success">ยืนยัน</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">ยกเลิก</button>
            </div>
        </div>
    </div>
</div>

`;


var editSubDetailModal =
`
<div class="modal fade" id="editSubDetailModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header header-modal">
                <h4 class="modal-title">แก้ไขข้อมูลแปลงปลูก</h4>
            </div>
            <div class="modal-body" id="addModalBody">
                <div class="row mb-4">
                    <div class="col-xl-3 col-12 text-right">
                        <span>ชื่อสวน</span>
                    </div>
                    <div class="col-xl-8 col-12">
                        <input type="text" class="form-control" id="rank" value="ไลอ้อนฟาร์ม">
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-xl-3 col-12 text-right">
                        <span>ชื่อแปลง</span>
                    </div>
                    <div class="col-xl-8 col-12">
                        <input type="text" class="form-control" id="rank" value="ไลอ้อนแปลง 1">
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-xl-3 col-12 text-right">
                        <span>ที่อยู่</span>
                    </div>
                    <div class="col-xl-8 col-12">
                        <input type="text" class="form-control" id="firstname" value="69/30 หมู่ 8 ต.บางจาก อ.พระประะแดง จ.สมุทรปราการ 10130">
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-xl-3 col-12 text-right">
                        <span>พื้นที่</span>
                    </div>
                    <div class="col-xl-9 col-12">
                        <div class="row">
                            <div class="col-3">
                                <input type="number" class="form-control" id="lastname" value="5">
                            </div>
                            <div class="col-3 mt-1">
                                <span>ไร่</span>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-3">
                                <input type="number" class="form-control" id="lastname" value="2">
                            </div>
                            <div class="col-3 mt-1">
                                <span>งาน</span>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-3">
                                <input type="number" class="form-control" id="lastname" value="50">
                            </div>
                            <div class="col-3 mt-1">
                                <span>วา</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success">ยืนยัน</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">ยกเลิก</button>
            </div>
        </div>
    </div>
</div>

`;

var editDetailModal =
`
<div class="modal fade" id="editDetailModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header header-modal">
                <h4 class="modal-title">แก้ไขข้อมูลแปลงปลูก</h4>
            </div>
            <div class="modal-body" id="addModalBody">
                <div class="row mb-4">
                    <div class="col-xl-3 col-12 text-right">
                        <span>ชื่อสวน</span>
                    </div>
                    <div class="col-xl-8 col-12">
                        <input type="text" class="form-control" id="rank" value="ไลอ้อนฟาร์ม">
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-xl-3 col-12 text-right">
                        <span>ที่อยู่</span>
                    </div>
                    <div class="col-xl-8 col-12">
                        <input type="text" class="form-control" id="firstname" value="69/30 หมู่ 8 ต.บางจาก อ.พระประะแดง จ.สมุทรปราการ 10130">
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-xl-3 col-12 text-right">
                        <span>พื้นที่</span>
                    </div>
                    <div class="col-xl-9 col-12">
                        <div class="row">
                            <div class="col-3">
                                <input type="number" class="form-control" id="lastname" value="5">
                            </div>
                            <div class="col-3 mt-1">
                                <span>ไร่</span>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-3">
                                <input type="number" class="form-control" id="lastname" value="2">
                            </div>
                            <div class="col-3 mt-1">
                                <span>งาน</span>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-3">
                                <input type="number" class="form-control" id="lastname" value="50">
                            </div>
                            <div class="col-3 mt-1">
                                <span>วา</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success">ยืนยัน</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">ยกเลิก</button>
            </div>
        </div>
    </div>
</div>

`;

function editMapModalFun(mapd, mapc)
{
    var editMapModal =
    `
    <div class="modal fade" id="editMapModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header header-modal">
                    <h4 class="modal-title">แก้ไขตำแหน่งพื้นที่</h4>
                </div>
                <div class="modal-body" id="addModalBody">
                    <div class="row mb-4">
                        <div class="col-12">
                            <button type="button" id="btn_remove_mark" style="float:right;" class="btn btn-warning btn-sm">ลบตำแหน่งทั้งหมด</button>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div id="map_area_edit" style="width:100%; height:400px;"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success">ยืนยัน</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">ยกเลิก</button>
                </div>
            </div>
        </div>
    </div>
    
    `;

    return editMapModal;
}
