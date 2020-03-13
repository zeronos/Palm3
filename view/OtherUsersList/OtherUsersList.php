<?php 
    session_start();
    
    $idUT = $_SESSION[md5('typeid')];
    $CurrentMenu = "OtherUsersList";
?>


<?php include_once("../layout/LayoutHeader.php"); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.css">


<style>
#serach {
    background-color: #E91E63;
    color: white;
    float: right;
}

#card-detail {
    border-color: #E91E63;
    border-top: none;
}
</style>
<?php 
include_once("../../dbConnect.php");
$myConDB = connectDB();


$admin=0;
// $admin2=0;
$research=0;
$operator=0;
$farmer=0;

if(isset($_POST['s_admin'])){
    $admin=1;
}
if(isset($_POST['s_research'])){
    $research=1;
}
if(isset($_POST['s_operator'])){
    $operator=1;
}
if(isset($_POST['s_farmer'])){
    $farmer=1;
    
}

$department = 0;
if(isset($_POST['s_department'])){
    $department = $_POST['s_department'];
}

if(isset($_POST['s_block'])){
    $block=1;
}   
if(isset($_POST['s_unblock'])){
    $unblock=1;
} 
$sql = "SELECT * FROM `db-user` 
        INNER JOIN `db-department` ON `db-user`.`DID` = `db-department`.`DID` 
        INNER JOIN `db-emailtype` on `db-emailtype`.`ETID` = `db-user`.`ETID`
        WHERE 1 ";
if($department != 0) $sql = $sql." AND `db-department`.`DID` = '".$department."' ";
if($admin   ==1) $sql = $sql."  AND IsAdmin = 1 ";
if($research==1) $sql = $sql."  AND IsResearch = 1 ";
if($operator==1) $sql = $sql."  AND IsOperator = 1 ";
if($farmer  ==1) $sql = $sql."  AND IsFarmer = 1 ";
if($block==1&&$unblock==0) $sql = $sql."  AND IsBlock = 1 ";
if($block==0&&$unblock==1) $sql = $sql."  AND IsBlock = 0 ";

//echo $sql;

$result = $myConDB->prepare($sql); 
$result->execute();

$sql1 = "SELECT * FROM `db-department`";
$result1 = $myConDB->prepare( $sql1 ); 
$result1->execute();

$sql2 = "SELECT * FROM `db-user`";
$result2 = $myConDB->prepare( $sql2 ); 
$result2->execute();

$sql3 = "SELECT * FROM `db-user` WHERE IsAdmin = 1 ";
$result3 = $myConDB->prepare( $sql3 ); 
$result3->execute();

?>

<div class="container">
    <div class="row">
        <div class="col-xl-12 col-12 mb-4">
            <div class="card">
                <div class="card-header card-bg">
                    <div class="row">
                        <div class="col-12">
                            <span class="link-active font-weight-bold" style="color:<?=$color?>;">รายชื่อผู้ใช้</span>
                            <span style="float:right;">
                                <i class="fas fa-bookmark"></i>
                                <a class="link-path" href="#">หน้าแรก</a>
                                <span> > </span>
                                <a class="link-path link-active" href="#" style="color:<?=$color?>;">รายชื่อผู้ใช้</a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-3 col-12 mb-4">
            <div class="card border-left-primary card-color-one shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="font-weight-bold  text-uppercase mb-1">หน่วยงาน</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php  
                                    $count = $result1->rowCount();
                                    echo $count; ?> หน่วยงาน</div>
                        </div>
                        <div class="col-auto">
                            <i class="material-icons icon-big">waves</i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-12 mb-4">
            <div class="card border-left-primary card-color-two shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="font-weight-bold  text-uppercase mb-1">ผู้ใช้งานทั้งหมด</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php  
                                    $count = $result2->rowCount();
                                    echo $count; ?> คน</div>
                        </div>
                        <div class="col-auto">
                            <i class="material-icons icon-big">dashboard</i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-12 mb-4">
            <div class="card border-left-primary card-color-three shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="font-weight-bold  text-uppercase mb-1">ผู้ดูแลระบบ</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php  
                                    $count = $result3->rowCount();
                                    echo $count; ?> คน</div>
                        </div>
                        <div class="col-auto">
                            <i class="material-icons icon-big">format_size</i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-12 mb-4">
            <div class="card border-left-primary card-color-four shadow h-100 py-2" id="addUser"
                style="cursor:pointer;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="font-weight-bold  text-uppercase mb-1">เพิ่มผู้ใช้งานใหม่</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">+1 คน</div>
                        </div>
                        <div class="col-auto">
                            <i class="material-icons icon-big">add_location</i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <form action="OtherUsersList.php?isSearch=1" method="post">
        <div class="row">
            <div class="col-xl-12 col-12 mb-4">
                <div id="accordion">
                    <div class="card">
                        <div class="card-header collapsed" 
                            id="headingOne" 
                            data-toggle="collapse"
                            data-target="#collapseOne" 
                    <?php 
                        if(isset($_GET['isSearch']) && $_GET['isSearch']==1)
                            echo 'aria-expanded="true"';
                        else 
                            echo 'aria-expanded="false"';
                    ?> 
                            aria-controls="collapseOne"
                            style="cursor:pointer; background-color: <?=$color?>; color: white;">
                            <div class="row">
                                <div class="col-3">
                                    <i class="fas fa-search"> ค้นหาขั้นสูง</i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="collapseOne" 
                <?php 
                    if(isset($_GET['isSearch']) && $_GET['isSearch']==1)
                        echo 'class="collapse show"';
                    else 
                        echo 'class="collapse"';
                ?>
                    aria-labelledby="headingOne" 
                    data-parent="#accordion">

                    <div class="card-body" style="background-color: white;">
                        <div class="row mb-4 ">
                            <div class="col-xl-4 col-12 text-right">
                                <span>หน่วยงาน</span>
                            </div>
                            <div class="col-xl-6 col-12">
                                <select class="form-control" id="s_department" name="s_department">
                                    <option value="0">ทุกหน่วยงาน</option>
                                    <?php 
                                    while ($row = $result1->fetch(PDO::FETCH_ASSOC)) 
                                        if($department==$row["DID"])
                                            echo '<option value="'.$row["DID"].'" selected>'.$row["Department"].'</option>';
                                        else
                                            echo '<option value="'.$row["DID"].'">'.$row["Department"].'</option>';
                                    ?>
                                </select>

                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-xl-4 col-12 text-right">
                                <span>สิทธิการเข้าใช้งาน</span>
                            </div>
                            <div class="col-xl-6 col-12">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" 
                                        id="s_admin" name="s_admin"
                                        <?php if($admin==1) echo ' checked ' ?>
                                        value="option1" >
                                    <label class="form-check-label" for="inlineCheckbox1">ผู้ดูแลระบบ</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" 
                                        id="s_research" name="s_research"
                                        <?php if($research==1) echo ' checked ' ?>
                                        value="option2">
                                    <label class="form-check-label" for="inlineCheckbox2">นักวิจัย</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" 
                                        id="s_operator" name="s_operator"
                                        <?php if($operator==1) echo ' checked ' ?>
                                        value="option3">
                                    <label class="form-check-label" for="inlineCheckbox3">พนักงานทั่วไป</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" 
                                        id="s_farmer" name="s_farmer"
                                        <?php if($farmer==1) echo ' checked ' ?>
                                        value="option4">
                                    <label class="form-check-label" for="inlineCheckbox4">เกษตรกร</label>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-xl-4 col-12 text-right">
                                <span>การบล็อกการเข้าใช้งานของผู้ใช้</span>
                            </div>
                            <div class="col-xl-6 col-12">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" 
                                        id="s_block" name="s_block" 
                                        <?php if($block==1) echo ' checked ' ?>
                                        value="1">
                                    <label class="form-check-label" for="inlineCheckbox1">บล็อค</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" 
                                        id="s_unblock" name="s_unblock"
                                        <?php if($unblock==1) echo ' checked ' ?>
                                        value="0">
                                    <label class="form-check-label" for="inlineCheckbox2">ไม่บล็อก</label>
                                </div>

                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-xl-4 col-12 text-right">
                            </div>
                            <div class="col-xl-6 col-12">
                                <button type="submit" id="btn_pass"
                                    class="btn btn-success btn-sm form-control">ค้นหา</button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>



    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header card-header-table py-3">
            <h6 class="m-0 font-weight-bold" style="color:#006633;">รายชื่อผู้ใช้ในระบบ</h6>
        </div>
        <div class="card-body">

            <div class="row mb-2">
                <div class="col-xl-3 col-12">
                    <button type="button" id="btn_comfirm" class="btn btn-outline-success btn-sm"><i
                            class="fas fa-file-excel"></i> Excel</button>
                    <button type="button" id="btn_comfirm" class="btn btn-outline-danger btn-sm"><i
                            class="fas fa-file-pdf"></i> PDF</button>

                </div>

            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-data" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>บัญชีชื่อผู้ใช้</th>
                            <th>อีเมล์</th>
                            <th>ชื่อ-นามสกุล</th>
                            <th>หน่วยงาน</th>
                            <th>สิทธิการเข้าใช้งาน</th>
                            <th>จัดการ</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>บัญชีชื่อผู้ใช้</th>
                            <th>อีเมล์</th>
                            <th>ชื่อ-นามสกุล</th>
                            <th>หน่วยงาน</th>
                            <th>สิทธิการเข้าใช้งาน</th>
                            <th>จัดการ</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php 
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)){
                        ?>
                        <tr>
                            <td><?php echo $row["UserName"]; ?></td>
                            <td><?php echo $row["EMAIL"]; ?>@<?php echo $row["Type"]; ?></td>
                            <td><?php echo $row["FirstName"]; ?> <?php echo $row["LastName"]; ?></td>
                            <td><?php echo $row["Department"]; ?></td>
                            <td style="text-align:center;">
                                <?php if($row["IsAdmin"] ){?>
                                <button type="button" id="btn_comfirm" data-toggle="tooltip" title="แอดมิน"
                                    class="btn btn-success btn-sm btn-circle tt">A</button>
                                <?php }else{ ?>
                                    <button type="button" id="btn_comfirm" data-toggle="tooltip" title="แอดมิน"
                                    class="btn btn-secondary btn-sm btn-circle tt">A</button>
                                <?php } ?>
                                <?php if($row["IsAdmin2"] ){?>
                                <button type="button" id="btn_comfirm" data-toggle="tooltip" title="แอดมิน2"
                                    class="btn btn-success btn-sm btn-circle tt">A2</button>
                                <?php }else{ ?>
                                    <button type="button" id="btn_comfirm" data-toggle="tooltip" title="แอดมิน2"
                                    class="btn btn-secondary btn-sm btn-circle tt">A2</button>
                                <?php } ?>
                                <?php if($row["IsResearch"] ){?>
                                <button type="button" id="btn_info" data-toggle="tooltip" title="นักวิจัย"
                                    class=" btn btn-success btn-sm btn-circle tt">R</button>
                                <?php }else{ ?>
                                    <button type="button" id="btn_comfirm" data-toggle="tooltip" title="นักวิจัย"
                                    class="btn btn-secondary btn-sm btn-circle tt">R</button>
                                <?php } ?>
                                <?php if($row["IsOperator"] ){ ?>
                                <button type="button" id="btn_delete" data-toggle="tooltip" title="พนักงานทั่วไป"
                                    class="btn btn-success btn-sm btn-circle tt">O</button>
                                <?php }else{ ?>
                                    <button type="button" id="btn_comfirm" data-toggle="tooltip" title="พนักงานทั่วไป"
                                    class="btn btn-secondary btn-sm btn-circle tt">O</button>
                                <?php } ?>
                                <?php if($row["IsFarmer"] ){?>
                                <button type="button" id="btn_delete" data-toggle="tooltip" title="เกษตรกร"
                                    class="btn btn-success btn-sm btn-circle tt">F</button>
                                <?php }else{ ?>
                                    <button type="button" id="btn_comfirm" data-toggle="tooltip" title="เกษตรกร"
                                    class="btn btn-secondary btn-sm btn-circle tt">F</button>
                                <?php } ?>

                            </td>

                            <td style="text-align:center;">
                                <!-- <button type="button" data-toggle="tooltip" title="บล็อค"  -->
                        <?php 
                        if($row["IsBlock"] == 0){ 
                            echo "<button type='button' data-toggle='tooltip' title='บล็อค' class='btn btn-success btn-sm tt' ";
                        }else{
                            echo "<button type='button' data-toggle='tooltip' title='ปลดบล็อค' class='btn btn-danger btn-sm tt' ";
                        }
                        ?> id="<?php echo $row["UID"] ?>" onclick="
                        <?php if($row["IsBlock"] == 0){
                            echo "block";
                        }else{
                            echo "unblock"; 
                        }
                         ?>
                        ('<?php echo $row["UserName"]; ?>' , '<?php echo $row["UID"] ?>')">
                                    <i class="fas fa-ban"></i></button>

                                <button type="button" class="btn btn-info btn-sm pass_edit tt" data-toggle="tooltip" title="แก้ไขรหัสผ่าน"
                                    uid="<?php echo $row["UID"]; ?>" username="<?php echo $row["UserName"]; ?>"
                                    pass="<?php echo $row["PWD"]; ?>" titles="<?php echo $row["Title"]; ?>"
                                    fname="<?php echo $row["FirstName"]; ?>" lname="<?php echo $row["LastName"]; ?>">
                                    <i class="fas fa-lock"></i></button>

                                <button type="button" class="btn btn-warning btn-sm btn_edit tt" data-toggle="tooltip" title="แก้ไขข้อมูล"
                                    uid="<?php echo $row["UID"]; ?>" titles="<?php echo $row["Title"]; ?>"
                                    username="<?php echo $row["UserName"]; ?>" fname="<?php echo $row["FirstName"]; ?>"
                                    lname="<?php echo $row["LastName"]; ?>" mail="<?php echo $row["EMAIL"]; ?>"
                                    type_email="<?php echo $row["ETID"]; ?>" department="<?php echo $row["DID"]; ?>"
                                    admin="<?php echo $row["IsAdmin"]; ?>" admin2="<?php echo $row["IsAdmin2"]; ?>"
                                    research="<?php echo $row["IsResearch"]; ?>"
                                    operator="<?php echo $row["IsOperator"]; ?>"
                                    farmer="<?php echo $row["IsFarmer"]; ?> ">
                                    <i class="fas fa-edit"></i></button>
                                <button type="button" class="btn btn-danger btn-sm tt" data-toggle="tooltip" title="ลบ"
                                    onclick="delfunction('<?php echo $row["UserName"]; ?>' , '<?php echo $row["UID"] ?>')">
                                    <i class="fas fa-trash-alt"></i></button>



                            </td>
                        </tr>
                        <?php 
                    }
                        

                ?>


                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="Modal">

    </div>

</div>


<?php include_once("../layout/LayoutFooter.php"); ?>
<?php include_once("OtherUsersListModal.php"); ?>

<script src="OtherUsersList.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.js"></script>