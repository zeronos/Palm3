<?php 
    session_start();
    
    $idUT = $_SESSION[md5('typeid')];
    $CurrentMenu = "FarmerListAdmin";
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

if( isset($_POST['s_formalid']))  $idformal = rtrim($_POST['s_formalid']);
if( isset($_POST['s_province']))  $fpro     = $_POST['s_province'];
if( isset($_POST['s_distrinct'])) $fdist    = $_POST['s_distrinct'];
if( isset($_POST['s_name'])){
  $fullname = rtrim($_POST['s_name']); 
  $fullname = preg_replace('/[[:space:]]+/', ' ', trim($fullname));
  $namef = explode(" ",$fullname);
  if(isset($namef[1])){
      $fnamef =$namef[0];
      $lnamef = $namef[1];
  }else{
      $fnamef =$fullname;
      $lnamef= $fullname;
  } 
}

$sql = "SELECT UFID,Title,FirstName,LastName,FormalID,Icon,`Address`,`db-farmer`.`AD3ID`,IsBlock,`db-farmer`.`ModifyDT`,`db-distrinct`.AD2ID,`db-distrinct`.AD1ID,subDistrinct,Distrinct,Province FROM `db-farmer` 
                INNER JOIN `db-subdistrinct` ON `db-farmer`.`AD3ID`=  `db-subdistrinct`.AD3ID
                INNER JOIN `db-distrinct` ON `db-subdistrinct`.`AD2ID`=  `db-distrinct`.AD2ID
                INNER JOIN `db-province` ON `db-distrinct`.`AD1ID`=  `db-province`.AD1ID
                WHERE 1 ";

if($idformal!='') $sql = $sql." AND FormalID LIKE '%".$idformal."%' ";
if($fullname!='') $sql = $sql." AND (FirstName LIKE '%".$fnamef."%' OR LastName LIKE '%".$lnamef."%') ";
if($fpro    !=0)  $sql = $sql." AND `db-distrinct`.AD1ID = '".$fpro."' ";
if($fdist   !=0)  $sql = $sql." AND `db-distrinct`.AD2ID = '".$fdist."' ";

//echo $sql;

$result2 = $myConDB->prepare($sql); 
$result2->execute();

// $sql2 = "SELECT UFID,Title,FirstName,LastName,FormalID,Icon,`Address`,`db-farmer`.`AD3ID`,IsBlock,`db-farmer`.`ModifyDT`,`db-distrinct`.AD2ID,`db-distrinct`.AD1ID,subDistrinct,Distrinct,Province FROM `db-farmer` 
// INNER JOIN `db-subdistrinct` ON `db-farmer`.`AD3ID`=  `db-subdistrinct`.AD3ID
// INNER JOIN `db-distrinct` ON `db-subdistrinct`.`AD2ID`=  `db-distrinct`.AD2ID
// INNER JOIN `db-province` ON `db-distrinct`.`AD1ID`=  `db-province`.AD1ID";
// $result2 = $myConDB->prepare( $sql2 ); 
// $result2->execute();

?>

<div class="container">
    <div class="row">
        <div class="col-xl-12 col-12 mb-4">
            <div class="card">
                <div class="card-header card-bg">
                    <div class="row">
                        <div class="col-12">
                            <span class="link-active font-weight-bold" style="color:<?=$color?>;">รายชื่อเกษตรกร</span>
                            <span style="float:right;">
                                <i class="fas fa-bookmark"></i>
                                <a class="link-path" href="#">หน้าแรก</a>
                                <span> > </span>
                                <a class="link-path link-active" href="#" style="color:<?=$color?>;">รายชื่อเกษตรกร</a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">

        <div class="col-xl-3 col-12 mb-4">
            <div class="card border-left-primary card-color-two shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="font-weight-bold  text-uppercase mb-1">จำนวนเกษตรกร</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php  
                                    $count = $result2->rowCount();
                                    echo $count; ?> คน</div>
                        </div>
                        <div class="col-auto">
                            <i class="material-icons icon-big">waves</i>
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
                            <div class="font-weight-bold  text-uppercase mb-1">เพิ่มเกษตรกร</div>
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


    <form action="FarmerListAdmin.php?isSearch=1" method="post">
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

                    <div class="card-body" style="background-color: white; ">
                        <div class="row mb-4 ">
                            <div class="col-xl-4 col-12 text-right">
                                <span>หมายเลขบัตรประชาชน</span>
                            </div>
                            <div class="col-xl-6 col-12">
                                <input type="password" class="form-control input-setting" 
                                    id="s_formalid" name="s_formalid"
                                    <?php if($idformal!='') echo 'value="'.$idformal.'"'; ?>
                                >
                                <i class="far fa-eye-slash eye-setting"></i>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-xl-4 col-12 text-right">
                                <span>ชื่อเกษตรกร</span>
                            </div>
                            <div class="col-xl-6 col-12">
                                <input type="text" class="form-control" 
                                    id="s_name" name="s_name"  
                                    <?php if($fullname!='') echo 'value="'.$fullname.'"'; ?>
                                >
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-xl-4 col-12 text-right">
                                <span>จังหวัด</span>
                            </div>
                            <div class="col-xl-6 col-12">
                                <select id="s_province" name="s_province" class="form-control">
                                    <option selected value=0>เลือกจังหวัด</option>        
                                    <?php 
                                    $sql = "SELECT * FROM `db-province`";
                                    $myConDB = connectDB();
                                    $result = $myConDB->prepare($sql);
                                    $result->execute();

                                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) 
                                        if($fpro==$row["AD1ID"])
                                            echo '<option value="'.$row["AD1ID"].'" selected>'.$row["Province"].'</option>';
                                        else
                                            echo '<option value="'.$row["AD1ID"].'">'.$row["Province"].'</option>';
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-xl-4 col-12 text-right">
                                <span>อำเภอ</span>
                            </div>
                            <div class="col-xl-6 col-12">
                                <select id="s_distrinct" name="s_distrinct" class="form-control"> 
                                    <option selected value=0>เลือกอำเภอ</option>>        
                                    <?php 
                                    if($fpro!=0){
                                        $sql = "SELECT * FROM `db-distrinct` WHERE `AD1ID`=".$fpro;
                                        $myConDB = connectDB();
                                        $result = $myConDB->prepare($sql);
                                        $result->execute();
                                    
                                        while ($row = $result->fetch(PDO::FETCH_ASSOC)) 
                                            if($fdist==$row["AD2ID"])
                                                echo '<option value="'.$row["AD2ID"].'" selected>'.$row["Distrinct"].'</option>';
                                            else
                                                echo '<option value="'.$row["AD2ID"].'">'.$row["Distrinct"].'</option>';
                                    }
                                    ?>
                                    
                                </select>
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
            <h6 class="m-0 font-weight-bold" style="color:#006633;">รายชื่อเกษตรกรในระบบ</h6>
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
                            <th>หมายเลขบัตรประชาชน</th>
                            <th>ชื่อ-นามสกุล</th>
                            <th>อำเภอ</th>
                            <th>จังหวัด</th>
                            <th>สถานะ</th>
                            <th>จัดการ</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>หมายเลขบัตรประชาชน</th>
                            <th>ชื่อ-นามสกุล</th>
                            <th>อำเภอ</th>
                            <th>จังหวัด</th>
                            <th>สถานะ</th>
                            <th>จัดการ</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php 
                    while ($row = $result2->fetch(PDO::FETCH_ASSOC)){
                        $fid = $row["FormalID"];
                        $formalid = substr_replace($fid,"xxxxxxx",3,7);
                ?>
                        <tr>
                            <td align="center"><?php echo $formalid; ?></td>
                            <td><?php echo $row["FirstName"]; ?> <?php echo $row["LastName"]; ?></td>
                            <td><?php echo $row["Distrinct"]; ?></td>
                            <td><?php echo $row["Province"]; ?></td>
                            <td style="text-align:center;">
                                <?php 
                                $isBlock = $row["IsBlock"];
                                $uid = $row["UFID"];
                                if($isBlock == NULL){
                                    echo "<a href='manage.php?confirm=1&uid=$uid'>กดเพื่อยืนยัน</a>";
                                }else{
                                    echo "<label>ยืนยันแล้ว</label>";
                                }
                                    
                                ?>

                            </td>

                            <td style="text-align:center;">
                                <!-- <button type="button" data-toggle="tooltip" title="บล็อค" -->
                        <?php
                        if($row["IsBlock"] == 0){ 
                            echo "<button type='button' data-toggle='tooltip' title='บล็อค' class='btn btn-success btn-sm tt' ";
                        }else{
                            echo "<button type='button' data-toggle='tooltip' title='ปลดบล็อค' class='btn btn-danger btn-sm tt' ";
                        }
                        ?> id="<?php echo $row["UFID"] ?>" onclick="
                        <?php if($row["IsBlock"] == 0){
                            echo "block";
                        }else{
                            echo "unblock"; 
                        }
                         ?>
                        ('<?php echo $row["FirstName"]; ?>' ,'<?php echo $row["LastName"]; ?>', '<?php echo $row["UFID"] ?>')">
                                    <i class="fas fa-ban"></i></button>

                                <button type="button" class="btn btn-warning btn-sm btn_edit tt" data-toggle="tooltip" title="แก้ไขข้อมูล"
                                    uid="<?php echo $row["UFID"]; ?>" titles="<?php echo $row["Title"]; ?>"
                                    formalid="<?php echo $formalid; ?>" fname="<?php echo $row["FirstName"]; ?>"
                                    lname="<?php echo $row["LastName"]; ?>" mail="<?php echo $row["EMAIL"]; ?>"
                                    type_email="<?php echo $row["ETID"]; ?>" address="<?php echo $row["Address"]; ?>"
                                    province="<?php echo $row["AD1ID"]; ?>" distrinct="<?php echo $row["AD2ID"]; ?>"
                                    subdistrinct="<?php echo $row["AD3ID"]; ?>">
                                    <i class="fas fa-edit"></i></button>
                                <button type="button" class="btn btn-danger btn-sm tt" data-toggle="tooltip" title="ลบ"
                                    onclick="delfunction('<?php echo $row["FirstName"]; ?>','<?php echo $row["LastName"]; ?>', '<?php echo $row["UFID"] ?>')">
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
<?php include_once("FarmerListAdminModal.php"); ?>

<script src="FarmerListAdmin.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.js"></script>