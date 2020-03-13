<?php 
include_once("../../dbConnect.php");
$sql = "SELECT * FROM `db-department`";
$myConDB = connectDB();
$result_d1 = $myConDB->prepare( $sql ); 
$result_d1->execute();
$result_d2 = $myConDB->prepare( $sql ); 
$result_d2->execute();

$sql1 = "SELECT * FROM `db-emailtype`";
$result_e1 = $myConDB->prepare( $sql1 ); 
$result_e1->execute();
$result_e2 = $myConDB->prepare( $sql1 ); 
$result_e2->execute();
?>
<div class="modal fade" id="passModal" tabindex="-1" role="dialog">
    <form method="post" id="formPass" name="formPass" action="manage.php">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header header-modal" style="background-color: <?=$color?>;">
                    <h4 class="modal-title">เปลี่ยนรหัสผ่าน</h4>
                </div>
                <div class="modal-body" id="passModalBody">
                    <div class="row mb-4">
                        <div class="col-xl-3 col-12 text-right">
                            <span>รหัสผ่านเก่า<span class="text-danger"> *</span></span>
                        </div>
                        <div class="col-xl-8 col-12">
                            <input type="password" class="form-control" id="old_pwd" name="old_pwd" required=""
                                oninput="setCustomValidity('')">
                            <i class="far fa-eye-slash eye-setting" id="hide_1"></i>
                        </div>
                        <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
                            <i class="fa fa-question-circle tt" style="color:red" data-toggle="tooltip"
                                data-placement="bottom"
                                title="-ต้องมีขนาดมากกว่า 7 ตัวอักษร -ต้องมีอักษรภาษาอังกฤษ ตัวเลข และอักขระพิเศษ"></i>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-xl-3 col-12 text-right">
                            <span>รหัสผ่านใหม่<span class="text-danger"> *</span></span>
                        </div>
                        <div class="col-xl-8 col-12">
                            <input type="password" class="form-control" id="e_pwd" name="e_pwd" required=""
                                oninput="setCustomValidity('')">
                            <i class="far fa-eye-slash eye-setting" id="hide_2"></i>
                        </div>
                        <!-- <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
                            <i class="fa fa-question-circle tt" style="color:red" data-toggle="tooltip"
                                data-placement="bottom"
                                title="-ต้องมีขนาดมากกว่า 7 ตัวอักษร -ต้องมีอักษรภาษาอังกฤษ ตัวเลข และอักขระพิเศษ"></i>
                        </div> -->
                    </div>
                    <div class="row mb-4">
                        <div class="col-xl-3 col-12 text-right">
                            <span>ยืนยันรหัสผ่านใหม่<span class="text-danger"> *</span></span>
                        </div>
                        <div class="col-xl-8 col-12">
                            <input type="password" class="form-control" id="e_pwd1" name="e_pwd1" required=""
                                oninput="setCustomValidity('')">
                            <i class="far fa-eye-slash eye-setting" id="hide_3"></i>
                            <input type="text" hidden class="form-control" name="request" value="changePass">
                            <input type="text" hidden class="form-control" name="pass_uid" id="pass_uid" value="">
                            <input type="text" hidden class="form-control" name="pass_old" id="pass_old" value="">
                            <input type="text" hidden class="form-control" name="pass_username" id="pass_username"
                                value="">

                            <input type="text" hidden class="form-control" name="p_title" id="p_title" value="">
                            <input type="text" hidden class="form-control" name="p_fname" id="p_fname" value="">
                            <input type="text" hidden class="form-control" name="p_lname" id="p_lname" value="">
                        </div>
                        <!-- <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
                            <i class="fa fa-question-circle tt" style="color:red" data-toggle="tooltip"
                                data-placement="bottom"
                                title="-ต้องมีขนาดมากกว่า 7 ตัวอักษร -ต้องมีอักษรภาษาอังกฤษ ตัวเลข และอักขระพิเศษ"></i>
                        </div> -->
                    </div>
                </div>
                <div class="modal-footer">

                    <button type="submit" id="edit_pass" name="edit_pass" class="btn btn-success">ยืนยัน</button>
                    <button type="button" id="edit_cancel" name="edit_cancel" class="btn btn-danger"
                        data-dismiss="modal">ยกเลิก</button>

                </div>
            </div>
        </div>
    </form>
</div>

<!-- editModal -->

<div class="modal fade" id="editModal" tabindex="-1" role="dialog">
    <form method="post" id="formEdit" name="formEdit" action="manage.php">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header header-modal" style="background-color: <?=$color?>;">
                    <h4 class="modal-title" style="color:white">แก้ไขบัญชีผู้ใช้</h4>
                </div>
                <div class="modal-body" id="addModalBody">
                    <div class="container">
                        <div class="row mb-4">
                            <div class="'col-lg-3 col-md-3 col-sm-12 col-xs-12 text-right">
                                <span>คำนำหน้า<span class="text-danger"> *</span></span>
                            </div>

                            <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">

                                <select class="form-control" id="e_title" name="e_title">
                                    <option value=1>นาย</option>
                                    <option value=2>นาง</option>
                                    <option value=3>นางสาว</option>

                                </select>

                            </div>

                        </div>
                        <div class="row mb-4">
                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-right">
                                <span>ชื่อ<span class="text-danger"> *</span></span>
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">
                                <input type="text" class="form-control" id="e_fname" name="e_fname" placeholder="ชื่อ"
                                    required="" oninput="setCustomValidity('')">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-right">
                                <span>นามสกุล<span class="text-danger"> *</span></span>
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">
                                <input type="text" class="form-control" id="e_lname" name="e_lname"
                                    placeholder="นามสกุล" required="" oninput="setCustomValidity('')">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-right">
                                <span>ชื่อผู้ใช้<span class="text-danger"> *</span></span>
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">
                                <input type="text" class="form-control" disabled id="e_username" name="e_username"
                                    placeholder="ชื่อผู้ใช้">
                                <input type="text" hidden class="form-control" id="e_username1" name="e_username1">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-right">
                                <span>อีเมล์<span class="text-danger"> *</span></span>
                            </div>
                            <div class="col-lg-5 col-md-4 col-sm-12 col-xs-12 ">
                                <input type="text" class="form-control" id="e_mail" name="e_mail" placeholder="อีเมล์"
                                    required="" oninput="setCustomValidity('')">
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 ">
                                <select class="form-control" id="e_type" name="e_type">
                                    <?php while ($row = $result_e2->fetch(PDO::FETCH_ASSOC)){ ?>
                                    <option value=<?php echo $row["ETID"]; ?>>@<?php echo $row["Type"]; ?></option>
                                    <?php
                                    }
                                ?>
                                </select>

                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="'col-lg-3 col-md-3 col-sm-12 col-xs-12 text-right">
                                <span>หน่วยงาน<span class="text-danger"> *</span></span>
                            </div>

                            <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">
                                <select class="form-control" name="e_department" id="e_department">
                                    <?php while ($row = $result_d2->fetch(PDO::FETCH_ASSOC)){ ?>
                                    <option value=<?php echo $row["DID"]; ?>><?php echo $row["Department"]; ?></option>
                                    <?php
                                    }
                                ?>
                                </select>

                            </div>


                        </div>
                        <input type="text" hidden class="form-control" name="request" value="update">
                        <input type="text" hidden class="form-control" name="uid" id="uid" value="">
                        <div class="row mb-4" hidden>
                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-right">
                                <!-- <span>สิทธิการเข้าใช้งาน<span class="text-danger"> *</span></span> -->
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" hidden id="e_admin" name="e_admin"
                                        value="option1">
                                    <label class="form-check-label" hidden for="inlineCheckbox1">ผู้ดูแลระบบ</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" hidden type="checkbox" id="e_research" name="e_research"
                                        value="option2">
                                    <label class="form-check-label" hidden for="inlineCheckbox2">นักวิจัย</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" hidden type="checkbox" id="e_operator" name="e_operator"
                                        value="option3">
                                    <label class="form-check-label" hidden for="inlineCheckbox3">พนักงานทั่วไป</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" hidden type="checkbox" id="e_farmer" name="e_farmer"
                                        value="option4">
                                    <label class="form-check-label" hidden for="inlineCheckbox4">เกษตรกร</label>
                                </div>
                            </div>

                        </div>
                        <div class="row mb-4" hidden>
                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-right">

                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">
                                <label hidden id="error" style='color:red'>กรุณาเลือกสิทธิ์การเข้าใช้งาน</label>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" id="edit" class="btn btn-success">ยืนยัน</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">ยกเลิก</button>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="modal fade" id="photoModal" tabindex="-1" role="dialog">
    <form method="post" id="formPhoto" name="formPhoto" action="manage.php">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header header-modal" style="background-color: <?=$color?>;">
                    <h4 class="modal-title">เปลี่ยนรูปโปรไฟล์</h4>
                </div>
                <div class="modal-body" id="passModalBody">
                    <div class="form-group divHolder">
                        <div class="" align="center">
                            <div class="UI" >
                                <input id='pic-logo' type='file' class='item-img file center-block'
                                    name='icon_insert' />
                                <img id="img-insert" src="https://via.placeholder.com/200x200.png" alt="" width="200"
                                    height="200">
                                <!-- <div id="upload-demo" class="center-block"></div> -->
                            </div>
                        </div>
                    </div>
                    <div class="form-group divCrop">

                        <center>
                            <div id="upload-demo" class="center-block"></div>
                        </center>
                    </div>
                    <input type="text" hidden class="form-control" name="p_uid" id="p_uid" value="">
                    <input type="hidden" id="request" name="request" value="photo">
                    <input type="hidden" id="imagebase64" name="imagebase64">
                </div>
                <!-- end  body---------------------------------------------- -->
                <div class="modal-footer footer-insert">
                    <div class="buttonSubmit">
                        <button type="submit" class="btn btn-success waves-effect insertSubmit"
                            id="add-data">ยืนยัน</button>
                        <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">ยกเลิก</button>
                    </div>
                    <div class="buttonCrop">
                        <button type="button" id="cropImageBtn" class="btn btn-primary">Crop</button>
                        <button type="button" class="btn btn-default" id="cancelCrop">Close</button>

                    </div>
                </div>
    </form>
</div>

<!-- <div class="modal fade" id="photoModal" tabindex="-1" role="dialog">
    <form method="post" id="formPhoto" name="formPhoto" action="manage.php">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header header-modal" >
                    <h4 class="modal-title">เปลี่ยนรหัสผ่าน</h4>
                </div>
                <div class="modal-body" id="passModalBody">
                    <div class="container">
                        <div class="upload-demo-wrap">
                            <div id="upload-demo">
                            </div>
                            <div class="actions">
                                <a class="btn file-btn">
                                    <span>upload</span>
                                    <input type="file" id="upload" accept="image/*" value="Choose a file">
                                </a>
                                <button class="upload-result">Result</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="edit" class="btn btn-success">ยืนยัน</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">ยกเลิก</button>
                </div>
            </div>

        </div>
    </form>
</div> -->
<script>
$(document).ready(function() {

    $('.tt').tooltip();

});
</script>