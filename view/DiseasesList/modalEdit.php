<!-- editModal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog">
    <form method="post" id="formEdit" name="formEdit" action="upload.php">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header header-modal" style="background-color: #006664;">
                    <h4 class="modal-title" id="largeModalLabel" style="color:white">แก้ไขชนิดโรคพืช</h4>
                </div>
                <div class="modal-body" id="addModalBody">
                    <div class="main">
                        <div class='row clearfix'>
                            <div class='col-lg-3 col-md-3 col-sm-3 col-xs-6 form-control-label text-right'>
                                <label>ชื่อ : </label>
                            </div>
                            <div class='col-lg-8 col-md-8 col-sm-9 col-xs-6'>
                                <div class='form-group'>
                                    <div class='form-line'>
                                        <input type="text" class="form-control" id="e_name" name="e_name" placeholder="" value="" required="" oninput="setCustomValidity('')">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class='row clearfix'>
                            <div class='col-lg-3 col-md-3 col-sm-3 col-xs-6 form-control-label text-right'>
                                <label>ชื่อทางการ : </label>
                            </div>
                            <div class='col-lg-8 col-md-8 col-sm-9 col-xs-6'>
                                <div class='form-group'>
                                    <div class='form-line'>
                                        <input type="text" class="form-control" id="e_alias" name="e_alias" placeholder="" value="" required="" oninput="setCustomValidity('')">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class='row clearfix'>
                            <div class='col-lg-3 col-md-3 col-sm-3 col-xs-6 form-control-label text-right'>
                                <label>ลักษณะ : </label>
                            </div>
                            <div class='col-lg-8 col-md-8 col-sm-9 col-xs-6'>
                                <div class='form-group'>
                                    <div class='form-line'>
                                        <textarea type="text" rows="2" class="form-control mb-2" name='e_charactor' id="e_charactor" placeholder="" value="" required="" oninput="setCustomValidity('')"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class='row clearfix'>
                            <div class='col-lg-3 col-md-3 col-sm-3 col-xs-6 form-control-label text-right'>
                                <label>อันตราย : </label>
                            </div>
                            <div class='col-lg-8 col-md-8 col-sm-9 col-xs-6'>
                                <div class='form-group'>
                                    <div class='form-line'>
                                        <textarea type="text" rows="2" class="form-control mb-2" name='e_danger' id="e_danger" placeholder="" value="" required="" oninput="setCustomValidity('')"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class='row clearfix'>
                            <div class='col-lg-3 col-md-3 col-sm-3 col-xs-6 form-control-label text-right'>
                                <label>รูปโรคพืช : </label>
                            </div>
                            <div class='col-lg-8 col-md-8 col-sm-9 col-xs-6'>
                                <div class='form-group'>

                                    <div class="img-reletive">
                                        <img width="100px" height="100px" id="img-pic-logo-edit" src="https://ast.kaidee.com/blackpearl/v6.18.0/_next/static/images/gallery-filled-48x48-p30-6477f4477287e770745b82b7f1793745.svg" width="50px" height="50px" alt="">
                                        <input type="file" id="pic-logo-edit" name="icon_insert-edit" accept=".jpg,.png">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class='row clearfix'>
                            <div class='col-lg-3 col-md-3 col-sm-3 col-xs-6 form-control-label text-right'>
                                <label>รูปลักษณะ : </label>
                            </div>
                            <div class='col-lg-8 col-md-8 col-sm-9 col-xs-6'>
                                <div class='form-group'>
                                    <div id="grid-pic-style-char-edit" class="grid-img-multiple">


                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class='row clearfix'>
                            <div class='col-lg-3 col-md-3 col-sm-3  col-xs-6 form-control-label text-right'>
                                <label>รูปลักษณะการทำลาย : </label>
                            </div>
                            <div class='col-lg-8 col-md-8 col-sm-9 col-xs-6'>
                                <div class='form-group'>
                                    <div id="grid-p_photo-edit" class="grid-img-multiple">


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="text" hidden class="form-control" name="e_pid" id="e_pid" value="">
                    <input type="text" hidden class="form-control" name="request" id="request" value="update">


                    <input type="hidden" id="e_o_name" name="e_o_name" value="">
                    <input type="hidden" id="e_o_alias" name="e_o_alias" value="">
                    <input type="hidden" id="e_o_charcator" name="e_o_charcator" value="">
                    <input type="hidden" id="e_o_danger" name="e_o_danger" value="">


                    <div class="modal-footer">
                        <button type="submit" id="edit" class="btn btn-success">บันทึก</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal" id="e_cancel">ยกเลิก</button>
                    </div>

                </div>
            </div>
        </div>
    </form>
</div>