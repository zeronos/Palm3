<!-- addModal -->
<div class="modal fade" id="addModal" name="addModal" tabindex="-1" role="dialog">
    <form method="post" id="formAdd" name = "formAdd" action="manage.php">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header header-modal" style="background-color: <?=$color?>;">
                <h4 class="modal-title" style="color:white">เพิ่มหน่วยงาน</h4>
            </div>
            <div class="modal-body" id="addModalBody">
                <div class="container">
                    
                    <div class="row mb-4">
                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-right">
                            <span>ชื่อหน่วยงาน<span class="text-danger"> *</span></span>
                        </div>
                        <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">
                            <input type="text" class="form-control" style="" name="department" id="department"
                             placeholder="กรุณากรอกชื่อหน่วยงาน" required="" oninput="setCustomValidity('')">
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-right">
                            <span>ชื่อย่อหน่วยงาน<span class="text-danger"> *</span></span>
                        </div>
                        <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">
                            <input type="text" class="form-control" name="alias" id="alias" placeholder="กรุณากรอกชื่อย่อหน่วยงาน" 
                            cc>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-right">
                            <span>หมายเหตุ<span class="text-danger"></span></span>
                        </div>
                        <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">
                            <input type="text" class="form-control" name="note" id="note" placeholder="หมายเหตุ">
                            <input type="text" hidden class="form-control" name="request" id="request" value="insert">
                            
                        </div>
                    </div>
                 

                    
                </div>

            </div>
            <div class="modal-footer"> 
                <button type="submit" name="save" id="save" value="insert" class="btn btn-success">ยืนยัน</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal" id="a_cancel">ยกเลิก</button>               
            </div>
        </div>
        </form>
    </div>
</div>

<!-- editModal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog">
<form method="post" id="formEdit" name = "formEdit" action="manage.php">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header header-modal" style="background-color: <?=$color?>;">
                <h4 class="modal-title" style="color:white">แก้ไขหน่วยงาน</h4>
            </div>
            <div class="modal-body" id="addModalBody">
                <div class="container">
                    
                    <div class="row mb-4">
                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-right">
                            <span>ชื่อหน่วยงาน<span class="text-danger"> *</span></span>
                        </div>
                        <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">
                            <input type="text" class="form-control" id="e_department" name="e_department" placeholder="" value="" 
                            required="" oninput="setCustomValidity('')">
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-right">
                            <span>ชื่อย่อหน่วยงาน<span class="text-danger"> *</span></span>
                        </div>
                        <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">
                            <input type="text" class="form-control" id="e_alias" name="e_alias" placeholder="" value="" 
                            required="" oninput="setCustomValidity('')">
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-right">
                            <span>หมายเหตุ</span>
                        </div>
                        <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">
                            <input type="text" class="form-control" id="e_note" name="e_note" placeholder="" value="">
                            <input type="text" hidden class="form-control" name="e_did" id="e_did" value="">
                            <input type="text" hidden class="form-control" name="request" id="request" value="update">
                        </div>
                    </div>
                    <input type="hidden" id="e_o_department" name="e_o_department" value="" >
                    <input type="hidden" id="e_o_alias" name="e_o_alias" value="" >
                    <input type="hidden" id="e_o_note" name="e_o_note" value="" >
                </div>

            </div>
            <div class="modal-footer"> 
                <button type="submit" id="edit" class="btn btn-success">ยืนยัน</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal" id="e_cancel">ยกเลิก</button>               
            </div>
        </div>
    </div>
    </form>
</div>
