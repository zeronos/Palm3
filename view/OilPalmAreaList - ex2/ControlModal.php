<?php 
/*
include_once("../../dbConnect.php");

$sql1 = "SELECT * FROM `db-emailtype`";
$result_e1 = $myConDB->prepare( $sql1 ); 
$result_e1->execute();
$result_e2 = $myConDB->prepare( $sql1 ); 
$result_e2->execute();*/
?>

<!-- addModal -->

<div class="modal fade" id="addModal" tabindex="-1" role="dialog">
    <form method="post" id="formAdd" name="formAdd" action="manage.php">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header header-modal" style="background-color: <?=$color?>;">
                    <h4 class="modal-title" style="color:white">เพิ่มสวนปาล์ม</h4>
                </div>
                <div class="modal-body" id="addModalBody">
                    <div class="container">
                    
                        <?php
                        $sql = "SELECT `UFID`, `Title`, `FirstName`, `LastName` FROM `db-farmer` ORDER BY `Title`, `FirstName`, `LastName`  ASC";
                        $myConDB = connectDB();
                        $result = $myConDB->prepare($sql);
                        $result->execute();
                        ?>

                        <div class="row mb-4">
                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-right">
                                <span>เจ้าของสวน<span class="text-danger"> *</span></span>
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">
                                <select class="form-control" id="farmer" name="farmer">
                                    <!--option selected="" disabled="">เลือกเจ้าของสวน</option-->
                                    <?php 
                                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) { 
                                        $fullname = $row["FirstName"]." ".$row["LastName"];
                                        switch($row["Title"]){
                                            case 1:  $fullname = "นาย".$fullname; break;
                                            case 2:  $fullname = "นาง".$fullname; break;
                                            case 3:  $fullname = "นางสาว".$fullname; break;
                                            default: $fullname = "คุณ".$fullname;
                                        }
                                    ?>
                                        <option value="<?php echo $row["UFID"]; ?>"> 
                                        <?php echo $fullname; ?> </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row mb-4">
                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-right">
                                <span>ชื่อสวน<span class="text-danger"> *</span></span>
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">
                                <input type="text" class="form-control" name="fname" id="fname" 
                                    placeholder="ชื่อสวน" required>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-right">
                                <span>ชื่อย่อสวน<span class="text-danger"> *</span></span>
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">
                                <input type="text" class="form-control" name="falias" id="falias"
                                    placeholder="ชื่อย่อสวน" required>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-right">
                                <span>ที่อยู่<span class="text-danger"> *</span></span>
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">
                                <input type="text" class="form-control" id="address" name="address"
                                    placeholder="ที่อยู่" required>
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
                                <select id="province" name="province" class="form-control">
                                    <option selected value=0>เลือกจังหวัด</option>
                                    <?php
                                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                        ?>
                                    <option value="<?php echo $row["AD1ID"]; ?>"> <?php echo $row["Province"]; ?> </option>
                                    <?php
                                    }
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
                        
                        <input type="text" hidden class="form-control" name="request" value="insert">

                        <input type="text" hidden class="form-control" name="st" id="st" value="">

                        <input type="text" hidden class="form-control" name="prov" id="prov" value="">
                        <input type="text" hidden class="form-control" name="dist" id="dist" value="">
                        <input type="text" hidden class="form-control" name="subdist" id="subdist" value="">

                        <input type="text" hidden class="form-control" name="id_prov" id="id_prov" value="">
                        <input type="text" hidden class="form-control" name="id_dist" id="id_dist" value="">
                        <input type="text" hidden class="form-control" name="id_subdist" id="id_subdist" value="">
                        <input type="hidden" name="add">

                        
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

<!--div class="modal fade" id="editModal" tabindex="-1" role="dialog">
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

                        
                        <input type="text" hidden class="form-control" name="request" value="update">

                        <input type="text" hidden class="form-control" name="e_uid" id="e_uid" value="">

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
</div-->


<script>
$(document).ready(function() {

    $('.tt').tooltip();

});
</script>