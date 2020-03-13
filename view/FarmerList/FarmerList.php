<?php 
    session_start();
    
    $idUT = $_SESSION[md5('typeid')];
    $CurrentMenu = "FarmerList";
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
            <?php
            $sql = "SELECT COUNT(`UFID`) c FROM `db-farmer`";
            $myConDB = connectDB();
            $result = $myConDB->prepare($sql);
            $result->execute();
            ?>

            <div class="col-xl-3 col-12 mb-4">
                <div class="card border-left-primary card-color-one shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="font-weight-bold  text-uppercase mb-1">จำนวนเกษตรกร</div>
                                <?php
                                $row = $result->fetch(PDO::FETCH_ASSOC);
                                ?>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php if($row["c"] != NULL) echo $row["c"]; else echo "0" ?> คน</div>
                                
                            </div>
                            <div class="col-auto">
                                <i class="material-icons icon-big">group</i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            $sql = "SELECT COUNT(`FSID`) AS sf FROM `db-subfarm`";
            $sql1 = "SELECT COUNT(`FMID`) AS f FROM `db-farm`";
            $myConDB = connectDB();
            $result = $myConDB->prepare($sql);
            $result->execute();
            $myConDB = connectDB();
            $result1 = $myConDB->prepare($sql1);
            $result1->execute();
            ?>

            <div class="col-xl-3 col-12 mb-4">
                <div class="card border-left-primary card-color-two shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="font-weight-bold  text-uppercase mb-1">จำนวนสวน/แปลง</div>
                                <?php
                                $row = $result->fetch(PDO::FETCH_ASSOC);
                                $row1 = $result1->fetch(PDO::FETCH_ASSOC);
                                ?>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php if($row1["f"] != NULL) echo $row1["f"]; else echo "0" ?> สวน 
                                <?php if($row["sf"] != NULL) echo $row["sf"]; else echo "0" ?> แปลง </div>
                               
                            </div>
                            <div class="col-auto">
                                <i class="material-icons icon-big">waves</i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            $sql = "SELECT SUM(`AreaRai`) AS r FROM `db-subfarm`";
            $myConDB = connectDB();
            $result = $myConDB->prepare($sql);
            $result->execute();
            ?>

            <div class="col-xl-3 col-12 mb-4">
                <div class="card border-left-primary card-color-three shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="font-weight-bold  text-uppercase mb-1">พื้นที่ทั้งหมด</div>
                                <?php
                                $row = $result->fetch(PDO::FETCH_ASSOC);
                                    ?>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php if($row["r"] != NULL) echo $row["r"]; else echo "0" ?> ไร่</div>
                               
                            </div>
                            <div class="col-auto">
                                <i class="material-icons icon-big">dashboard</i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            $sql = "SELECT sum(`log-farm`.`NumTree`) as sumTree FROM `log-farm`
            where `log-farm`.`EndT` is null AND `log-farm`.`DIMSubfID` is null";
            $myConDB = connectDB();
            $result = $myConDB->prepare($sql);
            $result->execute();
            ?>

            <div class="col-xl-3 col-12 mb-4">
                <div class="card border-left-primary card-color-four shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="font-weight-bold  text-uppercase mb-1">จำนวนต้นไม้</div>
                                <?php
                                $row = $result->fetch(PDO::FETCH_ASSOC);
                                    ?>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php if($row["sumTree"] != NULL) echo $row["sumTree"]; else echo "0" ?>  ต้น</div>
                                <?php
                                
                                ?>
                            </div>
                            <div class="col-auto">
                                <i class="material-icons icon-big">format_size</i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>

    <form action="FarmerList.php?isSearch=1" method="post">
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

    <div class="row mt-4">
            <div class="col-xl-12 col-12">
                <div class="card">
                    <div class="card-header card-bg" >
                    <h6 class="m-0 font-weight-bold" style="color:#006633;">รายชื่อเกษตรกร</h6>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-xl-3 col-12">
                                <button type="button" id="btn_comfirm" class="btn btn-outline-success btn-sm"><i class="fas fa-file-excel"></i> Excel</button>
                                <button type="button" id="btn_comfirm" class="btn btn-outline-danger btn-sm"><i class="fas fa-file-pdf"></i> PDF</button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id= table class="table table-bordered table-striped table-hover table-data" width="100%">
                                <thead>
                                    <tr>
                                        <th>ชื่อ-นามสกุล</th>
                                        <th>จังหวัด</th>
                                        <th>อำเภอ</th>
                                        <th>จำนวนสวน</th>
                                        <th>จำนวนแปลง</th>
                                        <th>พื้นที่ปลูก</th>
                                        <th>จำนวนต้น</th>
                                        <th>จัดการ</th>
                                    </tr>
                                </thead>

                                <tfoot>
                                    <tr>
                                        <th>ชื่อ-นามสกุล</th>
                                        <th>จังหวัด</th>
                                        <th>อำเภอ</th>
                                        <th>จำนวนสวน</th>
                                        <th>จำนวนแปลง</th>
                                        <th>พื้นที่ปลูก</th>
                                        <th>จำนวนต้น</th>
                                        <th>จัดการ</th>
                                    </tr>
                                </tfoot>

                                <?php
                                //INFO
                                $sql = "SELECT `UFID`,`FirstName`,`LastName`,`Distrinct`,`Province`, 
                                `dim-user`.`FullName`, `dim-user`.`ID` AS dimFID
                                    FROM `db-farmer` 
                                    JOIN `dim-user` ON `dim-user`.`dbID`=`db-farmer`.`UFID`
                                    JOIN `db-subdistrinct` ON `db-subdistrinct`.`AD3ID` = `db-farmer`.`AD3ID` 
                                    JOIN `db-distrinct` ON `db-distrinct`.`AD2ID` = `db-subdistrinct`.`AD2ID`
                                    JOIN `db-province` ON `db-province`.`AD1ID` = `db-distrinct`.`AD1ID` 
                                    WHERE `dim-user`.`Type`='F' ";
                                if($idformal!='') $sql = $sql." AND FormalID LIKE '%".$idformal."%' ";
                                if($fullname!='') $sql = $sql." AND (FirstName LIKE '%".$fnamef."%' OR LastName LIKE '%".$lnamef."%') ";
                                if($fpro    !=0)  $sql = $sql." AND `db-distrinct`.AD1ID = '".$fpro."' ";
                                if($fdist   !=0)  $sql = $sql." AND `db-distrinct`.AD2ID = '".$fdist."' ";
                                $sql = $sql." ORDER BY  `dim-user`.`FullName`";
                                //echo $sql;
                            
                                $myConDB = connectDB();
                                $result = $myConDB->prepare($sql);
                                $result->execute();
                                $numFermer=0;
                                foreach($result as $tmp => $tmpDATA){
                                    //print_r($tmpDATA);
                                    if($tmpDATA['UFID']>0){
                                        $FARMER[$numFermer]['dbID']    =$tmpDATA['UFID'];
                                        $FARMER[$numFermer]['dimID']    = $tmpDATA['dimFID'];
                                        $FARMER[$numFermer]['FullName']    = $tmpDATA['FullName'];
                                        $FARMER[$numFermer]['Province']    = $tmpDATA['Province'];
                                        $FARMER[$numFermer]['Distrinct']    = $tmpDATA['Distrinct'];
                                        $FARMER[$numFermer]['numFarm']    = 0;
                                        $FARMER[$numFermer]['numSubFarm']    = 0;
                                        $FARMER[$numFermer]['numTree']    = 0;
                                        $FARMER[$numFermer]['numArea1']    = 0;
                                        $FARMER[$numFermer]['numArea2']    = 0;
                                        $fermerINDEX[$tmpDATA['dimFID']]   = $numFermer;
                                        //echo $FARMER[$numFermer]['dimID']."-".$FARMER[$numFermer]['FullName']."<br>";
                                        $numFermer++;
                                    }
                                }
                                //COUNT FARM
                                //$sql1 = "SELECT UFID, COUNT(CASE WHEN `UFID` IN (`UFID`) THEN 1 END) f FROM `db-farm` GROUP BY `UFID`";
                                $sql1 = "SELECT `DIMownerID`, `DIMfarmID`, `NumSubFarm`,
                                `NumTree`,`AreaRai`, `AreaNgan`
                                FROM `log-farm`
                                WHERE `DIMSubfID` IS NULL AND `EndT` IS NULL";
                                $myConDB = connectDB();
                                $result1 = $myConDB->prepare($sql1);
                                $result1->execute();
                                foreach($result1 as $tmp => $tmpDATA){
                                    //print_r($tmpDATA);
                                    //echo "<br>".$tmpDATA['DIMownerID']."<br>";
                                    $tmpID = $fermerINDEX[$tmpDATA['DIMownerID']];
                                    if($tmpID>=0){
                                        //print_r($tmpDATA);
                                        $FARMER[$tmpID]['numFarm']++;
                                        $FARMER[$tmpID]['numSubFarm']   += $tmpDATA['NumSubFarm'];
                                        $FARMER[$tmpID]['numTree']      += $tmpDATA['NumTree'];
                                        $FARMER[$tmpID]['numArea1']     += $tmpDATA['AreaRai'];
                                        $FARMER[$tmpID]['numArea2']     += $tmpDATA['AreaNgan'];
                                    }
                                }
                                //COUNT subFARM
                                $sql2 = "SELECT UFID, COUNT(CASE WHEN `UFID` IN (`UFID`) THEN 1 END) sf 
                                FROM `db-subfarm`  LEFT JOIN `db-farm` ON `db-farm`.`FMID` = `db-subfarm`.`FMID` GROUP BY UFID ";
                                $myConDB = connectDB();
                                $result2 = $myConDB->prepare($sql2);
                                $result2->execute();
                                //COUNT TREE
                                $sql3 = "SELECT `db-farmer`.`UFID` , sum.`sumTree` FROM `db-farmer`
                                LEFT JOIN (SELECT sum(`log-farm`.`NumTree`) as sumTree,`dim-farm`.`Name`, `dim-farm`.`dbID` , `db-farm`.`UFID`
                                FROM `log-farm`
                                INNER JOIN `dim-farm` on `dim-farm`.`ID` = `log-farm`.`DIMfarmID`
                                INNER JOIN `db-farm` ON `db-farm`.`FMID` = `dim-farm`.`dbID` AND `dim-farm`.`IsFarm` = 1
                                where `log-farm`.`EndT` is null AND `log-farm`.`DIMSubfID` is null 
                                GROUP BY `db-farm`.`UFID`) AS sum ON `db-farmer`.`UFID` = sum.`UFID` GROUP BY `db-farmer`.`UFID`";
                                $myConDB = connectDB();
                                $result3 = $myConDB->prepare($sql3);
                                $result3->execute();
                                //COUNT AREA
                                $sql4 = "SELECT UFID, SUM(CASE WHEN `UFID` IN (`UFID`) THEN `AreaRai` END) A 
                                FROM `db-farm` LEFT JOIN `db-subfarm` ON `db-farm`.`FMID` = `db-subfarm`.`FMID` 
                                GROUP BY UFID ";
                                $myConDB = connectDB();
                                $result4 = $myConDB->prepare($sql4);
                                $result4->execute();
                                ?>

                                <tbody>
                                <?php 
                                //while ($row = $result->fetch(PDO::FETCH_ASSOC)){
                                for($i=0;$i<$numFermer;$i++) {
                                ?>
                                    <tr>
                                        <td><?php echo $FARMER[$i]['FullName']; ?></td>
                                        <td><?php echo $FARMER[$i]["Province"] ?></td>
                                        <td><?php echo $FARMER[$i]["Distrinct"] ?></td>
                                        <td class = "text-right"><?php echo $FARMER[$i]['numFarm']; ?> สวน</td>
                                        <td class = "text-right"><?php echo $FARMER[$i]['numSubFarm']; ;?> แปลง</td>
                                        <td class = "text-right"><?php echo $FARMER[$i]['numArea1']; ?> ไร่ <?php echo $FARMER[$i]['numArea2']; ?> งาน</td>
                                        <td class = "text-right"><?php echo $FARMER[$i]['numTree']; ?> ต้น</td>
                                        <td style="text-align:center;">
                                            <a href='FarmerListDetail.php?farmerID=<?php echo $FARMER[$i]['dbID'];?>'>
                                            <button type='button' id='btn_info' 
                                                class="btn btn-info btn-sm btn_edit tt"
                                                data-toggle="tooltip" title="รายละเอียดข้อมูลเกษตรกร" >
                                                <i class='fas fa-bars'></i>
                                            </button>
                                            </a>
                                            <!--form method="post" id="ID" name = "formID" action="FarmerListDetail.php">
                                                <input type="text" hidden class="form-control" name="farmerID" id="farmerID" value="<?php echo $row["UFID"];?>">
                                                <button type="submit"  id="btn_info" class="btn btn-info btn-sm"><i class="fas fa-bars"></i></button></a>
                                            </form-->
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