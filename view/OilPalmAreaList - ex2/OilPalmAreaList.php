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

function getData( $col , $sql ){
    $TEMP = selectDataOne( $sql );
    return $TEMP[$col];
}

$numFarm1 = getData("num","SELECT COUNT(`db-farm`.`FMID`) AS num FROM `db-farm`");
$numFarm2 = getData("num","SELECT COUNT(`db-subfarm`.`FSID`) AS num FROM `db-subfarm`");
$sumAreas = getData("total","SELECT SUM(`db-subfarm`.`AreaRai`) AS total FROM `db-subfarm`");
$sumTrees = getData("total","SELECT sum(`log-farm`.`NumTree`) as total FROM `log-farm`
where `log-farm`.`EndT` is null AND `log-farm`.`DIMSubfID` is null");


if( isset($_POST['s_farm']))  $selectedFarm = rtrim($_POST['s_farm']);
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
if( isset($_POST['s_province'] ))  $fpro  = $_POST['s_province'];
if( isset($_POST['s_distrinct']))  $fdist = $_POST['s_distrinct'];

$sql = "SELECT `log-farm`.`ID` AS FID,`dim-farm`.`dbID` AS FMID ,
`dim-address`.`Province`,`dim-address`.`Distrinct`,
`dim-user`.`FullName`, `dim-user`.`Alias`, `dim-farm`.`Name`,
`log-farm`.`NumSubFarm`,`log-farm`.`NumTree`,
`AreaRai`, `AreaNgan`, `AreaWa` 
FROM `log-farm` 
INNER JOIN `dim-user`ON `dim-user`.`ID` = `log-farm`.`DIMownerID`
INNER JOIN `dim-address`ON `dim-address`.`ID` =`log-farm`.`DIMaddrID`
INNER JOIN `dim-farm`ON `dim-farm`.`ID` = `log-farm`.`DIMfarmID`
WHERE `log-farm`.`DIMSubfID` IS NULL AND `log-farm`.`EndT`IS NULL ";

if( $selectedFarm!='' )  
    $sql .= " AND (`dim-farm`.`Name` LIKE '%".$selectedFarm."%'  OR `dim-farm`.`Alias` LIKE '%".$selectedFarm."%') ";

if($fullname!='') 
    $sql .= " AND (`dim-user`.`FullName` LIKE '%".$fnamef."%' OR `dim-user`.`FullName` LIKE '%".$lnamef."%') ";

if($fpro    !=0)  $sql .= " AND `dim-address`.`dbprovID` = '".$fpro."' ";
if($fdist   !=0)  $sql .= " AND `dim-address`.`dbDistID` = '".$fdist."' ";

$sql .= "ORDER BY `dim-address`.`Province`,`dim-address`.`Distrinct`,`dim-user`.`Alias`";

$DATA = selectAll($sql);
//print_r($DATA);
$numD = sizeof($DATA);

/*
if( isset($_POST['s_formalid']))  $idformal = rtrim($_POST['s_formalid']);

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
$result2->execute(); */

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
                            <span class="link-active font-weight-bold" style="color:<?=$color?>;">รายชื่อสวนปาล์มน้ำมัน</span>
                            <span style="float:right;">
                                <i class="fas fa-bookmark"></i>
                                <a class="link-path" href="#">หน้าแรก</a>
                                <span> > </span>
                                <a class="link-path link-active" href="#" style="color:<?=$color?>;">รายชื่อสวนปาล์มน้ำมัน</a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">

    <?php function creatCard( $styleC, $headC, $textC, $iconC ) { ?>
        <div class="col-xl-3 col-12 mb-4">
            <div class="card border-left-primary <?php echo $styleC;?> shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="font-weight-bold  text-uppercase mb-1"><?php echo $headC;?></div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $textC;?></div>
                        </div>
                        <div class="col-auto">
                            <i class="material-icons icon-big"><?php echo $iconC;?></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php 
        }//end function
        creatCard( "card-color-one",   "จำนวนสวน",  $numFarm1." สวน ".$numFarm2." แปลง", "group" );
        creatCard( "card-color-two",   "พื้นที่ทั้งหมด", $sumAreas." ไร่", "dashboard" );
        creatCard( "card-color-three", "จำนวนต้น",  $sumTrees." ต้น", "format_size" );
    ?>
        <div class="col-xl-3 col-12 mb-4">
            <div class="card border-left-primary card-color-four shadow h-100 py-2" id="addUser"
                style="cursor:pointer;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="font-weight-bold  text-uppercase mb-1">เพิ่มสวน</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">+1 สวน</div>
                        </div>
                        <div class="col-auto">
                            <i class="material-icons icon-big">add_location</i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <form action="OilPalmAreaList.php?isSearch=1" method="post">
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

                        <div class="row mb-4">
                            <div class="col-xl-4 col-12 text-right">
                                <span>ชื่อสวนปาล์มน้ำมัน</span>
                            </div>
                            <div class="col-xl-6 col-12">
                                <input type="text" class="form-control" 
                                    name="s_farm" id="s_farm"
                                    <?php if( isset($_POST['s_farm']))  echo 'value="'.$selectedFarm.'"'; ?>
                                >
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
            <h6 class="m-0 font-weight-bold" style="color:#006633;">รายชื่อสวนปาล์มน้ำมัน</h6>
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
                                <th>จังหวัด</th>
                                <th>อำเภอ</th>
                                <th>ชื่อเกษตรกร</th>
                                <th>ชื่อสวน</th>
                                <th>จำนวนแปลง</th>
                                <th>พื้นที่ปลูก</th>
                                <th>จำนวนต้น</th>
                                <th>รายละเอียด</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>จังหวัด</th>
                                <th>อำเภอ</th>
                                <th>ชื่อเกษตรกร</th>
                                <th>ชื่อสวน</th>
                                <th>จำนวนแปลง</th>
                                <th>พื้นที่ปลูก</th>
                                <th>จำนวนต้น</th>
                                <th>รายละเอียด</th>
                            </tr>
                        </tfoot>
                    <tbody>
                    <?php 
                        for($i=0;$i<$numD;$i++) { 
                            $tmpURL  = "OilPalmAreaListDetail.php?";
                            $tmpURL .= "id=".$DATA[$i]["Name"]."&";
                            $tmpURL .= "fname=".$DATA[$i]["Alias"]."&";
                            $tmpURL .= "fmid=".$DATA[$i]["FMID"]."&";
                            $tmpURL .= "logid=".$DATA[$i]["FID"]."";
                    ?>
                        <tr>
                            <td><?php echo $DATA[$i]["Province"]; ?></td>
                            <td><?php echo $DATA[$i]["Distrinct"]; ?></td>
                            <td><?php echo $DATA[$i]["FullName"]; ?></td>
                            <td><?php echo $DATA[$i]["Name"]; ?></td>
                            <td align="right"><?php echo $DATA[$i]["NumSubFarm"]." แปลง"; ?></td>
                            <td align="right"><?php echo $DATA[$i]["AreaRai"]." ไร่ ".$DATA[$i]["AreaNgan"]." งาน "; ?></td>
                            <td align="right"><?php echo $DATA[$i]["NumTree"]." ต้น"; ?></td>
                            <td align="center">
                                <a href='<?php echo $tmpURL; ?>'>
                                    <button type='button' id='btn_info' 
                                    class='btn btn-info btn-sm  btn_edit tt' 
                                    data-toggle="tooltip" title="รายละเอียดสวน">
                                        <i class='fas fa-bars'></i>
                                    </button>
                                </a>
                                <button type='button' id='btn_delete' 
                                    class='btn btn-danger btn-sm  btn_edit tt' 
                                    data-toggle="tooltip" title="ลบสวน"
                                    onclick="delfunction('<?php echo $DATA[$i]["Name"]; ?>' , '<?php echo $DATA[$i]["FMID"]; ?>')">
                                    <i class='far fa-trash-alt'></i>
                                </button>
                            </td>
                        </tr>
                    <?php } ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="Modal">

    </div>

</div>

<?php 
include_once("../layout/LayoutFooter.php"); 
include_once("ControlModal.php"); 
?>

<script src="ControlModal.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.js"></script>