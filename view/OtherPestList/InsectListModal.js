var addModal =
    `<div class="modal fade" id="insert" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header header-modal">
                <h4 class="modal-title" id="largeModalLabel" style="color:white">เพิ่มชนิดแมลง</h4>
            </div>
            <div class="modal-body">
                <form action="#" method="post" enctype="multipart/form-data" id="form-insert">
                    <div class='row clearfix'>
                        <div class='col-lg-3 col-md-3 col-sm-3 col-xs-6 form-control-label text-right'>
                            <label>ชื่อ : </label>
                        </div>
                        <div class='col-lg-8 col-md-8 col-sm-9 col-xs-6'>
                            <div class='form-group'>
                                <div class='form-line'>
                                    <input type='text' id='name_insert' name='name_insert' class='form-control'>
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
                                    <input type='text' id='alias_insert' name='alias_insert' class='form-control'>
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
                                    <textarea type="text" rows="2" class="form-control mb-2" name='charactor_insert' id="charactor_insert" placeholder="ลักษณะ"></textarea>
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
                                    <textarea type="text" rows="2" class="form-control mb-2" name='danger_insert' id="danger_insert" placeholder="อันตราย"></textarea>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class='row clearfix'>
                        <div class='col-lg-3 col-md-3 col-sm-3 col-xs-6 form-control-label text-right'>
                            <label>รูปแมลงssssssssssss : </label>
                        </div>
                        <div class='col-lg-8 col-md-8 col-sm-9 col-xs-6'>
                            <div class='form-group'>
                                <div class="marge-img">
                                    <img src="" width="200px" height="200px" >
                                    <input type="file" id="pic-logo" name="icon_insert" accept=".jpg,.png" required="">
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

                                <input type="file" id="pic-style-char" name="picstyle_insert" accept=".jpg,.png" required="" multiple>

                            </div>
                        </div>
                    </div>

                    <div class='row clearfix'>
                        <div class='col-lg-3 col-md-3 col-sm-3  col-xs-6 form-control-label text-right'>
                            <label>รูปลักษณะการทำลาย : </label>
                        </div>
                        <div class='col-lg-8 col-md-8 col-sm-9 col-xs-6'>
                            <div class='form-group'>

                                <input type="file" id="pic-danger" name="picdan_insert" accept=".jpg,.png" required="" multiple>

                            </div>
                        </div>
                    </div>

                    <input type="hidden" id="hidden_id" name="request" value="insert" />

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success waves-effect insertSubmit" id="add-data">ยืนยัน</button>
                        <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">ยกเลิก</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
`;