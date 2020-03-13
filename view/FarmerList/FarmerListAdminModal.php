<?php 
include_once("../../dbConnect.php");

$sql1 = "SELECT * FROM `db-emailtype`";
$result_e1 = $myConDB->prepare( $sql1 ); 
$result_e1->execute();
$result_e2 = $myConDB->prepare( $sql1 ); 
$result_e2->execute();
?>

<!-- addModal -->

<div class="modal fade" id="addModal" tabindex="-1" role="dialog">
    <form method="post" id="formAdd" name="formAdd" action="manage.php">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header header-modal" style="background-color: <?=$color?>;">
                    <h4 class="modal-title" style="color:white">เพิ่มบัญชีผู้ใช้</h4>
                </div>
                <div class="modal-body" id="addModalBody">
                    <div class="container">
                        <div class="row mb-4">
                            <div class="'col-lg-3 col-md-3 col-sm-12 col-xs-12 text-right">
                                <span>คำนำหน้า<span class="text-danger"> *</span></span>
                            </div>

                            <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">

                                <select class="form-control" id="title" name="title">
                                    <option value=1>นาย</option>
                                    <option value=3>นางสาว</option>
                                    <option value=2>นาง</option>
                                </select>

                            </div>


                        </div>
                        <div class="row mb-4">
                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-right">
                                <span>ชื่อ<span class="text-danger"> *</span></span>
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">
                                <input type="text" class="form-control" id="fname" name="fname" placeholder="ชื่อ"
                                    required="" oninput="setCustomValidity(' ')">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-right">
                                <span>นามสกุล<span class="text-danger"> *</span></span>
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">
                                <input type="text" class="form-control" id="lname" name="lname" placeholder="นามสกุล"
                                    required="" oninput="setCustomValidity(' ')">
                            </div>
                        </div>
                        
                        <div class="row mb-4">
                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-right">
                                <span>หมายเลขประจำตัวประชาชน<span class="text-danger"> *</span></span>
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">
                                <input type="text" class="form-control" id="formalid" name="formalid"
                                    placeholder="หมายเลขประจำตัวประชาชน" required="" oninput="setCustomValidity(' ')">
                            </div>
                        </div>


                        <div class="row mb-4">
                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-right">
                                <span>ที่อยู่<span class="text-danger"> *</span></span>
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">
                                <input type="text" class="form-control" id="address" name="address"
                                    placeholder="ที่อยู่" required="" oninput="setCustomValidity(' ')">
                            </div>
                        </div>

                        <?php
                        $sql = "SELECT * FROM `db-province` ORDER BY `db-province`.`Province`  ASC";
                        $myConDB = connectDB();
                        $result = $myConDB->prepare($sql);
                        $result->execute();
                        ?>

                        <div class="row mb-4">
                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-right">
                                <span>จังหวัด<span class="text-danger"> *</span></span>
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">
                                <!-- <select id="province" class="form-control" onclick="data_show(this.value,'distrinct','');"> -->
                                <select id="province" name="province" class="form-control">
                                    <option selected value=0>เลือกจังหวัด</option>
                                    <?php
                                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                        ?>
                                    <option value="<?php echo $row["AD1ID"]; ?>"> <?php echo $row["Province"]; ?> </option>
                                    <?php
                                    }
                                    //$conn->close();
                                    ?>
                                </select>
                                
                            </div>
                            
                        </div>
                        <div class="row mb-1">
                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-right">

                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">
                                <label hidden id="f_province" style='color:red'>กรุณาเลือกจังหวัด</label>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-right">
                                <span>อำเภอ<span class="text-danger"> *</span></span>
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">
                                <select id="distrinct" name="distrinct" class="form-control"> 
                                    <option selected value=0>เลือกอำเภอ</option>
                                    
                                </select>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-right">

                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">
                                <label hidden id="f_distrinct" style='color:red'>กรุณาเลือกอำเภอ</label>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-right">
                                <span>ตำบล<span class="text-danger"> *</span></span>
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">
                                <select id="subdistrinct" name="subdistrinct" class="form-control">
                                    <option selected value=0>เลือกตำบล</option>
                                    
                                </select>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-right">

                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">
                                <label hidden id="f_subdistrinct" style='color:red'>กรุณาเลือกตำบล</label>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-right">
                                <span>สถานะ<span class="text-danger"> *</span></span>
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" value="1">
                                    <label class="form-check-label" for="inlineCheckbox1">ยืนยัน</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" checked value="0">
                                    <label class="form-check-label" for="inlineCheckbox1">ไม่ยืนยัน</label>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="row mb-1">
                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-right">
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">
                                <label hidden id="f_province" style='color:red'>กรุณาเลือกจังหวัด</label>
                                <label hidden id="f_distrinct" style='color:red'>กรุณาเลือกอำเภอ</label>
                                <label hidden id="f_subdistrinct" style='color:red'>กรุณาเลือกตำบล</label>
                            </div>
                        </div> -->
                        
                        <input type="text" hidden class="form-control" name="request" value="insert">

                        <input type="text" hidden class="form-control" name="st" id="st" value="">

                        <input type="text" hidden class="form-control" name="prov" id="prov" value="">
                        <input type="text" hidden class="form-control" name="dist" id="dist" value="">
                        <input type="text" hidden class="form-control" name="subdist" id="subdist" value="">

                        <input type="text" hidden class="form-control" name="id_prov" id="id_prov" value="">
                        <input type="text" hidden class="form-control" name="id_dist" id="id_dist" value="">
                        <input type="text" hidden class="form-control" name="id_subdist" id="id_subdist" value="">

                        
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" id="save" name="save" class="btn btn-success">ยืนยัน</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">ยกเลิก</button>
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
                                    required="" oninput="setCustomValidity(' ')">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-right">
                                <span>นามสกุล<span class="text-danger"> *</span></span>
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">
                                <input type="text" class="form-control" id="e_lname" name="e_lname" placeholder="นามสกุล"
                                    required="" oninput="setCustomValidity(' ')">
                            </div>
                        </div>
                        
                        <div class="row mb-4">
                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-right">
                                <span>หมายเลขประจำตัวประชาชน<span class="text-danger"> *</span></span>
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">
                                <input type="text" class="form-control" id="e_formalid" name="e_formalid" disabled
                                    placeholder="หมายเลขประจำตัวประชาชน" required="" oninput="setCustomValidity(' ')">
                            </div>
                        </div>


                        <div class="row mb-4">
                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-right">
                                <span>ที่อยู่<span class="text-danger"> *</span></span>
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">
                                <input type="text" class="form-control" id="e_address" name="e_address"
                                    placeholder="ที่อยู่" required="" oninput="setCustomValidity(' ')">
                            </div>
                        </div>

                        <?php
                        $sql = "SELECT * FROM `db-province` ORDER BY `db-province`.`Province`  ASC";
                        $myConDB = connectDB();
                        $result = $myConDB->prepare($sql);
                        $result->execute();
                        ?>

                        <div class="row mb-4">
                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-right">
                                <span>จังหวัด<span class="text-danger"> *</span></span>
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">
                                <select id="e_province" name="e_province" class="form-control">
                                    <option selected>เลือกจังหวัด</option>
                                    <?php
                                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                        ?>
                                    <option value="<?php echo $row["AD1ID"]; ?>"> <?php echo $row["Province"]; ?> </option>
                                    <?php
                                    }
                                    //$conn->close();
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-right">

                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">
                                <label hidden id="fe_province" style='color:red'>กรุณาเลือกจังหวัด</label>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-right">
                                <span>อำเภอ<span class="text-danger"> *</span></span>
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">
                                <select id="e_distrinct" name="e_distrinct" class="form-control">
                                    <option selected>เลือกอำเภอ</option>
                                    

                                </select>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-right">

                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">
                                <label hidden id="fe_distrinct" style='color:red'>กรุณาเลือกอำเภอ</label>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-right">
                                <span>ตำบล<span class="text-danger"> *</span></span>
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">
                                <select id="e_subdistrinct" name="e_subdistrinct" class="form-control">
                                    <option selected>เลือกตำบล</option>
                                    
                                </select>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-right">

                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">
                                <label hidden id="fe_subdistrinct" style='color:red'>กรุณาเลือกตำบล</label>
                            </div>
                        </div>
                        <!-- <div class="row mb-4">
                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-right">
                                <span>สถานะ<span class="text-danger"> *</span></span>
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="e_status" id="e_status1" value="1">
                                    <label class="form-check-label" for="inlineCheckbox1">ยืนยัน</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="e_status" id="e_status0" checked value="0">
                                    <label class="form-check-label" for="inlineCheckbox1">ไม่ยืนยัน</label>
                                </div>
                            </div>
                        </div> -->

                        
                        <input type="text" hidden class="form-control" name="request" value="update">

                        <input type="text" hidden class="form-control" name="e_uid" id="e_uid" value="">

                        <!-- <input type="text" hidden class="form-control" name="e_st" id="e_st" value=""> -->

                        <input type="text" hidden class="form-control" name="e_prov" id="e_prov" value="">
                        <input type="text" hidden class="form-control" name="e_dist" id="e_dist" value="">
                        <input type="text" hidden class="form-control" name="e_subdist" id="e_subdist" value="">

                        <input type="text" hidden class="form-control" name="e_id_prov" id="e_id_prov" value="">
                        <input type="text" hidden class="form-control" name="e_id_dist" id="e_id_dist" value="">
                        <input type="text" hidden class="form-control" name="e_id_subdist" id="e_id_subdist" value="">

                        
                        
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" id="edit" name="edit" class="btn btn-success">ยืนยัน</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">ยกเลิก</button>
                </div>
            </div>
        </div>
    </form>
</div>


<script>
$(document).ready(function() {

    $('.tt').tooltip();

});
</script>