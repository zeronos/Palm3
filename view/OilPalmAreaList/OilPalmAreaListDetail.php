<?php
session_start();

$idUT = $_SESSION[md5('typeid')];
$CurrentMenu = "OilPalmAreaList";
$USER = $_SESSION[md5('user')];
?>


<?php include_once("../layout/LayoutHeader.php");
include_once("../../dbConnect.php");
if (isset($_GET[('id')]) && isset($_GET[('fmid')]) 
&& isset($_GET[('fname')]) && isset($_GET[('logid')])) {
    $id     = $_SESSION[('id')]     = $_GET[('id')];
    $fmid   = $_SESSION[('fmid')]   = $_GET[('fmid')];
    $fname  = $_SESSION[('fname')]  = $_GET[('fname')];
    $ffullname = $_SESSION[('ffullname')] = $_GET[('ffullname')];
    $logid  = $_SESSION[('logid')]  = $_GET[('logid')];
} else {
    $id     = $_SESSION[('id')];
    $fmid   = $_SESSION[('fmid')];
    $fname  = $_SESSION[('fname')];
    $ffullname = $_SESSION[('ffullname')];
    $logid  = $_SESSION[('logid')];
}

$StartT = time();
$sql = "SELECT Address , subDistrinct , Distrinct , Province FROM `db-farm`
inner join `db-subdistrinct` on `db-subdistrinct`.`AD3ID` = `db-farm`.`AD3ID`
inner join `db-distrinct` on `db-distrinct`.`AD2ID` = `db-subdistrinct`.`AD2ID`
inner join `db-province` on `db-province`.`AD1ID` = `db-distrinct`.`AD1ID`
where Name = '" . $id . "'";
$sql2 = "SELECT t.FSID as fsid,t.n as namesub,t.n2,t.AreaTotal ,NumTree FROM 
(SELECT `db-subfarm`.`FSID`,`db-subfarm`.Name as n,`db-farm`.Name as n2,`db-subfarm`.AreaTotal ,NumTree,`log-farm`.`DIMfarmID`,`log-farm`.`DIMSubfID`, `dim-farm`.`IsFarm` FROM `db-subfarm` 
inner join `db-farm` on `db-subfarm`.`FMID` = `db-farm`.`FMID` 
INNER JOIN `dim-farm` on `db-farm`.FMID = `dim-farm`.`dbID`  
INNER JOIN `log-farm` on `log-farm`.`DIMfarmID`=`dim-farm`.`ID`
where `log-farm`.`NumSubFarm` = '1' 
GROUP by `db-subfarm`.Name
ORDER by `log-farm`.`ID` DESC) as t 
where t.`DIMfarmID`='" . $fmid . "'
GROUP by t.n";
$sql3 = "SELECT * FROM `log-farm`WHERE `ID`='$logid '";
$sql4 = "SELECT FMID,Name,Alias,Address,UFID, `db-farm`.`AD3ID`,`db-subdistrinct`.`AD2ID`,`db-distrinct`.`AD1ID`
FROM `db-farm`INNER JOIN `db-subdistrinct`ON `db-farm`.`AD3ID`=`db-subdistrinct`.`AD3ID`
INNER JOIN `db-distrinct`ON`db-distrinct`.`AD2ID`=`db-subdistrinct`.`AD2ID` WHERE `FMID`='$fmid'";
$sql5 = "SELECT `log-farm`.`Latitude` , `log-farm`.`Longitude`  FROM `log-farm`
where `log-farm`.`ID` = '" . $logid . "'";
$sql6 = "select count(`db-subfarm`.`FSID`) as csub from `db-farm` 
inner join `db-subfarm` on `db-farm`.`FMID` = `db-subfarm`.`FMID`
where `db-farm`.`FMID` = '" . $fmid . "'";
$sql7 = "SELECT `log-farm`.`Latitude` , `log-farm`.`Longitude` FROM `log-farm`
INNER JOIN `dim-farm` on `dim-farm`.`ID` = `log-farm`.`DIMfarmID`
WHERE `log-farm`.`DIMSubfID` IS NOT null AND `dim-farm`.`Name` = '" . $id . "' AND `log-farm`.`EndT` IS NULL";
$sql8 = "SELECT `log-icon`.`DIMiconID`,`log-icon`.`Path`,`log-icon`.`FileName` FROM `log-icon` 
INNER JOIN `dim-user` on`log-icon`.`DIMiconID` = `dim-user`.`ID`
INNER JOIN `db-farmer` on `db-farmer`.`UFID` = `dim-user`.`dbID`
WHERE `log-icon`.`Type` = 5 AND `db-farmer`.`FirstName`='" . $fname . "'";
$sql9 = "SELECT `log-icon`.`DIMiconID`,`log-icon`.`Path`,`log-icon`.`FileName` FROM `log-icon` 
INNER JOIN `dim-farm` on`log-icon`.`DIMiconID` = `dim-farm`.`ID`
INNER JOIN `db-farm` on `db-farm`.`FMID` = `dim-farm`.`dbID`
WHERE `log-icon`.`Type` = 4 AND `db-farm`.`FMID`= '" . $fmid . "'";
$sql10 = "SELECT `db-coorfarm`.`Latitude`,`db-coorfarm`.`Longitude`,`db-subfarm`.`FSID` FROM `db-coorfarm`
INNER JOIN `db-subfarm` ON `db-coorfarm`.`FSID`=`db-subfarm`.`FSID`
INNER JOIN `db-farm` ON `db-subfarm`.`FMID` = `db-farm`.`FMID`
WHERE `db-farm`.`FMID` = '" . $fmid . "'";
$sql11 = "SELECT`db-subfarm`.`FSID`,COUNT(*) as count FROM `db-coorfarm` 
INNER JOIN `db-subfarm` ON `db-coorfarm`.`FSID`=`db-subfarm`.`FSID` 
INNER JOIN `db-farm` ON `db-subfarm`.`FMID` = `db-farm`.`FMID` 
WHERE `db-farm`.`FMID` = '" . $fmid . "' GROUP BY `db-subfarm`.`FSID`";

$areatotal = selectData($sql3);
$subfarm = selectData($sql2);
$address = selectData($sql);
//print_r($address);
//echo $sql4;
$DATAFarm = selectData($sql4);
$latlong = selectData($sql5);
$csub = selectData($sql6);
$manycoor = selectData($sql7);
$idfarmer = selectData($sql8);
$idfarm = selectData($sql9);
$coorsfarm = selectData($sql10);
$numcoor = selectData($sql11);;

?>
<style>
    .text-left {
        align: left;

    }

    .text-right {
        align: right;
    }

    .text-center {
        align: center;
    }

    #map {
        width: 100%;
        height: 700px;
    }

    #find {
        max-width: 500px;
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.css">
<div class="container">

    <div class="row">
        <div class="col-xl-12 col-12 mb-4">
            <div class="card">
                <div class="card-header card-bg">
                    <div class="row">
                        <div class="col-12">
                            <span class="link-active font-weight-bold" style="color:<?=$color?>;">รายละเอียดสวนปาล์มน้ำมัน</span>
                            <span style="float:right;">
                                <i class="fas fa-bookmark"></i>
                                <a class="link-path" href="#">หน้าแรก</a>
                                <span> > </span>
                                <a class="link-path" href="OilPalmAreaList.php">รายชื่อสวนปาล์มน้ำมัน</a>
                                <span> > </span>
                                <a class="link-path link-active" href="#" style="color:<?=$color?>;">รายละเอียดสวนปาล์มน้ำมัน</a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-xl-6 col-12">
            <div class="card">
                <div class="card-body" id="for_card">
                    <div class="row justify-content-center">
                        <div class="col-xl-4 col-4 text-right font-weight-bold" style="color:<?=$color?>;">
                            <span>ชื่อสวน : </span>
                        </div>
                        <div class="col-xl-8 col-8">
                            <span><?php echo "$id" ?></span>
                            <button type="button" id="edit_photo" 
                            class="btn btn-warning btn-sm tt" style="float:right;"
                            title='เปลี่ยนรูปโปรไฟล์สวน'
                            uid="<?php echo $fmid; ?>">
                            <i class="fas fa-image"></i></button>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <img class="img-radius img-profile" 
                        <?php 
                            if($idfarm[1]['FileName']!='')
                                echo "src=\"../../".$idfarm[1]['Path']."/".$idfarm[1]['FileName']."\"  ";
                            else 
                                echo "src=\"../../icon/farm/farm.png\"  ";
                        ?>
                        \>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-12">
            <div class="card">
                <div class="card-body" id="card_height">
                    <div class="row justify-content-center">
                        <div class="col-xl-4 col-4 text-right font-weight-bold" style="color:<?=$color?>;">
                            <span>เกษตรกร : </span>
                        </div>
                        <div class="col-xl-8 col-8">
                            <span>
                                <a href='../FarmerList/FarmerListDetail.php?farmerID=<?php echo $fmid;?>'>
                                <?php echo "$ffullname" ?>
                                </a>
                            </span>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <img class="img-radius img-profile" 
                        <?php 
                        $sql = "SELECT * , CASE WHEN `Title` IN ('1') THEN 'นาย'
                        WHEN `Title` IN ('2') THEN 'นาง' 
                        WHEN `Title` IN ('3') THEN 'นางสาว' END AS Title                   
                        FROM `db-farmer` JOIN `db-subdistrinct` ON `db-subdistrinct`.`AD3ID` = `db-farmer`.`AD3ID` 
                        JOIN `db-distrinct` ON `db-distrinct`.`AD2ID` = `db-subdistrinct`.`AD2ID`
                        JOIN `db-province` ON `db-province`.`AD1ID` = `db-distrinct`.`AD1ID` WHERE `UFID` =$fmid";
                        $myConDB = connectDB();
                        $result = $myConDB->prepare($sql);
                        $result->execute();
                        if ($row = $result->fetch(PDO::FETCH_ASSOC)){
                            //echo "src=\"../../".$idfarmer[1]['Path']."/".$idfarmer[1]['FileName']."\" ";
                            
                        if ($row["Icon"] != NULL)
                            echo $src = "src=\"../../icon/farmer/".$fmid."/".$row["Icon"]."\""; 
                        else if($row['Title']=='นาย') 
                            echo $src = "src=\"../../icon/farmer/man.jpg\"" ;
                        else 
                            echo $src = "src=\"../../icon/farmer/woman.jpg\"" ; 
                        }
                        ?>
                        \>
                    </div>
                    <!--div  class="row mt-3"><div>&nbsp;</div></div-->
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mt-3">
                        <div class="col-xl-2 col-2 text-right font-weight-bold" style="color:<?=$color?>;">
                            <span>ที่อยู่ : </span>
                        </div>
                        <div class="col-xl-10 col-10">
                            <span><?php echo $address[1]['Address']; ?> ต.<?php echo $address[1]['subDistrinct']; ?> อ.<?php echo $address[1]['Distrinct']; ?> จ.<?php echo $address[1]['Province']; ?></span>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-xl-2 col-2 text-right font-weight-bold" style="color:<?=$color?>;">
                            <span>พื้นที่ทั้งหมด : </span>
                        </div>
                        <div class="col-xl-8 col-8">
                            <span><?php echo $areatotal[1]['AreaRai']; ?> ไร่ <?php echo $areatotal[1]['AreaNgan']; ?> งาน <?php echo $areatotal[1]['AreaWa']; ?> วา</span>
                        </div>
                        <div class="col-xl-2 col-2">
                            <button type="button" id="btn_edit_map" 
                                class="btn btn-warning btn-sm btn_edit tt"
                                data-toggle="tooltip" title="แก้ไขตำแหน่งสวน"
                                style="float:right;" >
                                <i class="fas fa-map-marker"></i>
                            </button>
                            <button type="button" id="btn_edit_detail1" 
                                class="btn btn-warning btn-sm btn_edit tt"
                                data-toggle="tooltip" title="แก้ไขข้อมูลสวน"
                                style="float:right; margin-right:10px;" >
                                <i class="fas fa-edit"></i>
                            </button>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <!--div class="col-12 mb-3">
                            <button type="button" id="btn_edit_map" style="float:right;" 
                                class="btn btn-warning btn-sm">แก้ไขตำแหน่งสวน</button>
                            <button type="button" id="btn_edit_detail1" style="float:right; margin-right:10px;" 
                                class="btn btn-warning btn-sm">แก้ไขข้อมูลสวน</button>
                        </div-->
                        <div class="col-xl-6 col-12">
                            <div id="map" style="width:auto; height:400px;"></div>
                        </div>
                        <div class="col-xl-6 col-12">
                            <div id="map2" style="width:auto; height:400px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-xl-12 col-12">
            <div class="card">
                <div class="card-header card-bg">
                    <div>
                        <span>รายการแปลงปลูกปาล์มน้ำมัน</span>
                        <button type="button" id="btn_add_subgarden1" 
                            class="btn btn-success btn-sm btn_edit tt"
                            data-toggle="tooltip" title="เพิ่มแปลงปลูก"
                            style="float:right; margin-right:10px;" >
                            <i class="fas fa-plus"></i> เพิ่มแปลง</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-xl-3 col-12">
                            <button type="button" id="btn_comfirm" 
                                class="btn btn-outline-success btn-sm">
                                <i class="fas fa-file-excel"></i> Excel</button>
                            <button type="button" id="btn_comfirm" 
                                class="btn btn-outline-danger btn-sm">
                                <i class="fas fa-file-pdf"></i> PDF</button>

                        </div>

                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover table-data" width="100%">
                            <thead>
                                <tr>
                                    <th>ชื่อแปลง</th>
                                    <th>พื้นที่ปลูก</th>
                                    <th>จำนวนต้น</th>
                                    <th>อายุปาล์มน้ำมัน</th>
                                    <th>จัดการ</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>ชื่อแปลง</th>
                                    <th>พื้นที่ปลูก</th>
                                    <th>จำนวนต้น</th>
                                    <th>อายุปาล์มน้ำมัน</th>
                                    <th>จัดการ</th>
                                </tr>
                            </tfoot>
                            <tbody id="getData">


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editDetailModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form class="form-signin" method="POST" action='manage.php'>
                    <div class="modal-header header-modal">
                        <h4 class="modal-title">แก้ไขสวนปาล์ม</h4>
                    </div>
                    <div class="modal-body" id="addModalBody">
                        <div class="row mb-4">
                            <div class="col-xl-3 col-12 text-right">
                                <span>ชื่อสวนปาล์ม</span>
                            </div>
                            <div class="col-xl-9 col-12">
                                <input type="text" class="form-control" name="namefarm2" id="rank32" value="<?= $DATAFarm['1']['Name'] ?>">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-xl-3 col-12 text-right">
                                <span>ชื่อย่อสวนปาล์ม</span>
                            </div>
                            <div class="col-xl-9 col-12">
                                <input type="text" class="form-control" name="aliasfarm2" id="rank42" value="<?= $DATAFarm['1']['Alias'] ?>">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-xl-3 col-12 text-right">
                                <span>ที่อยู่</span>
                            </div>
                            <div class="col-xl-9 col-12">
                                <input type="text" class="form-control" name="addfarm2" id="rrrr" value="<?= $DATAFarm['1']['Address'] ?>">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-xl-3 col-12 text-right">
                                <span>จังหวัด</span>
                            </div>
                            <div class="col-xl-9 col-12">
                                <select id="province2" class="form-control" name="province">
                                    <option disabled selected id="province_list2">เลือกจังหวัด</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-xl-3 col-12 text-right">
                                <span>อำเภอ</span>
                            </div>
                            <div class="col-xl-9 col-12">
                                <select id="amp2" name="amphur2" class="form-control">
                                    <option selected="" disabled="">เลือกอำเภอ</option>

                                </select>

                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-xl-3 col-12 text-right">
                                <span>ตำบล</span>
                            </div>
                            <div class="col-xl-9 col-12">
                                <select id="subamp2" name="subdistrinct2" class="form-control">
                                    <option selected="" disabled="">เลือกตำบล</option>

                                </select>
                            </div>
                        </div>


                        <div class="row mb-4">
                            <div class="col-xl-3 col-12 text-right">
                                <span>เจ้าของสวนปาล์ม</span>
                            </div>
                            <div class="col-xl-9 col-12">
                                <select class="form-control" id="farmer2" name="farmer2">
                                    <option selected="" disabled="">เลือกเจ้าของสวน</option>

                                </select>
                            </div>
                        </div>
                        <input type="hidden" name="IDFarm" value="<?= $fmid ?>">
                        <input type="hidden" name="edit">

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-success btn-md" style="float:right;" type="submit">ยืนยัน</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">ยกเลิก</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- ส่วนที่ต้องเอาไปแทนในของอิง -->
    <div class="modal fade" id="addSubGardenModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form class="form-signin" method="POST" action='addData.php'>
                    <div class="modal-header header-modal">
                        <h4 class="modal-title">เพิ่มแปลง</h4>
                    </div>
                    <div class="modal-body" id="addModalBody">
                        <div class="row mb-4">
                            <div class="col-xl-3 col-12 text-right">
                                <span>ชื่อแปลง</span>
                            </div>
                            <div class="col-xl-9 col-12">
                                <input type="text" class="form-control" id="namefarm" name="namefarm">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-xl-3 col-12 text-right">
                                <span>ชื่อย่อแปลง</span>
                            </div>
                            <div class="col-xl-9 col-12">
                                <input type="text" class="form-control" id="initials" name="initials">
                            </div>
                        </div>
                        <!-- <div class="row mb-4">
                            <div class="col-xl-3 col-12 text-right">
                                <span>จำนวนพื้นที่</span>
                            </div>
                            <div class="col-xl-9 col-12">
                               ไร่<input class="form-control" type="text"   id="farm" name="farm">
                               งาน<input class="form-control" type="text"  id="work" name="work">
                               ตารางวา<input class="form-control" type="text"  id="wah" name="wah">
                            </div>
                        </div> -->
                        <div class="row mb-4">
                            <div class="col-xl-3 col-12 text-right">
                                <span>พื้นที่</span>
                            </div>
                            <div class="col-xl-9 col-12">
                                <div class="row">
                                    <div class="col-3">
                                        <input type="number" class="form-control" id="farm" name="farm" value="0">
                                    </div>
                                    <div class="col-3 mt-1">
                                        <span>ไร่</span>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-3">
                                        <input type="number" class="form-control" id="work" name="work" value="0">
                                    </div>
                                    <div class="col-3 mt-1">
                                        <span>งาน</span>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-3">
                                        <input type="number" class="form-control" id="wah" name="wah" value="0">
                                    </div>
                                    <div class="col-3 mt-1">
                                        <span>วา</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-xl-3 col-12 text-right">
                                <span>จังหวัด</span>
                            </div>
                            <div class="col-xl-9 col-12">
                                <select id="province1" class="form-control" name="province">
                                    <option disabled selected id="province_list">เลือกจังหวัด</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-xl-3 col-12 text-right">
                                <span>อำเภอ</span>
                            </div>
                            <div class="col-xl-9 col-12">
                                <select id="amp1" name="amphur" class="form-control">
                                    <option selected="" disabled="">เลือกอำเภอ</option>
                                </select>

                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-xl-3 col-12 text-right">
                                <span>ตำบล</span>
                            </div>
                            <div class="col-xl-9 col-12">
                                <select id="subamp" name="subdistrinct" class="form-control">
                                    <option selected="" disabled="">เลือกตำบล</option>
                                </select>
                            </div>
                        </div>

                    </div>
                    <input type="hidden" name="add">.
                    <input type="hidden" id="fmid" name="fmid" value="<?php echo $fmid ?>">
                    <input type="hidden" id="id" name="id" value="<?php echo $id ?>">
                    <input type="hidden" id="fname" name="fname" value="<?php echo $fname ?>">
                    <input type="hidden" id="logid" name="logid" value="<?php echo $logid ?>">
                    <input type="hidden" id="StartT" name="StartT" value="<?php echo $StartT ?>">
                    <div class="modal-footer">
                        <button class="btn btn-success btn-md" type="submit">ยืนยัน</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">ยกเลิก</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ส่วนที่ต้องเอาไปแทนในของอิง -->
    <div class="modal fade" id="photoModal" tabindex="-1" role="dialog">
        <form method="post" id="formPhoto" name="formPhoto" action="manage.php">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header header-modal">
                        <h4 class="modal-title">เปลี่ยนรูปสวน</h4>
                    </div>
                    <div class="modal-body" id="passModalBody">
                        <div class="form-group divHolder">
                            <div class="form-inline">
                                <div class="UI" center>
                                    <input id='pic-logo' type='file' class='item-img file center-block' name='icon_insert' />
                                    <img id="img-insert" src="https://via.placeholder.com/200x200.png" alt="" width="200" height="200">
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
                            <button type="submit" class="btn btn-success waves-effect insertSubmit" id="add-data">ยืนยัน</button>
                            <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">ยกเลิก</button>
                        </div>
                        <div class="buttonCrop">
                            <button type="button" id="cropImageBtn" class="btn btn-primary">Crop</button>
                            <button type="button" class="btn btn-default" id="cancelCrop">Close</button>

                        </div>
                    </div>
        </form>
    </div>
</div>


<?php include_once("../layout/LayoutFooter.php"); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBMLhtSzox02ZCq2p9IIuihhMv5WS2isyo&callback=initMap&language=th" async defer></script>

<script src="OilPalmAreaList.js"></script>
<script src="OilPalmAreaListModal.js"></script>
<script src="../../croppie/croppie.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.js"></script>


<script>
    var mapdetail, mapcolor;


    $("#card_height").css('height', $("#for_card").css('height'));

    $("#btn_edit_detail1").click(function() {
        $("body").append(editDetailModal);
        $("#editDetailModal").modal('show');
    });
    $("#edit_photo").click(function() {
        console.log("photo");
        $("#photoModal").modal();
        var uid = $(this).attr('uid');
        $('#p_uid').val(uid);

    });

    $("#btn_edit_map").click(function() {
        $("body").append(editMapModalFun(mapdetail, mapcolor));
        $("#editMapModal").modal('show');

        var startLatLng = new google.maps.LatLng(13.736717, 100.523186);
        console.log(mapcolor);
        console.log(mapdetail.markers[0].getPosition().lng());

        var startLatLng = new google.maps.LatLng(<?= $latlong[1]['Latitude'] ?>, <?= $latlong[1]['Longitude'] ?>);

        var mapedit = new google.maps.Map(document.getElementById('map_area_edit'), {
            // center: { lat: 13.7244416, lng: 100.3529157 },
            center: startLatLng,
            zoom: 17,
            mapTypeId: 'satellite'
        });

        mapedit.markers = [];
        for (let i = 0; i < mapdetail.markers.length; i++) {
            let marker;
            if (i == 0) {

            } else {
                marker = new google.maps.Marker({
                    position: new google.maps.LatLng(mapdetail.markers[i].getPosition().lat(), mapdetail.markers[i].getPosition().lng()),
                    map: mapedit,
                    title: "test",
                    draggable: true,
                });
            }
            mapedit.markers.push(marker);
        }

        var latlng = [];
        var sumcoorlat = 0;
        var sumcoorlng = 0;
        var sumlat = 0;
        var sumlng = 0;
        var x = 0;
        google.maps.event.addListener(mapedit, 'click', function(event) {
            latlng.push(event.latLng.lat(), event.latLng.lng());

            placeMarker(event.latLng);
            sumlat = sumlat + event.latLng.lat();
            sumlng = sumlng + event.latLng.lng();
            x = x + 1;
            sumcoorlat = sumlat / x;
            sumcoorlng = sumlng / x;
            //console.table(sumcoorlat, sumcoorlng);
        });

        function placeMarker(location) {
            var marker = new google.maps.Marker({
                position: location,
                map: mapedit,
                draggable: true,
            });
            mapedit.markers.push(marker);

        }

        $("#btn_remove_mark").click(function() {
            for (let i = 0; i < mapedit.markers.length; i++) {
                if (i != 0) {
                    mapedit.markers[i].setMap(null);
                    for (let i = 0; i < latlng.length; i++) {
                        latlng[i] = 0;
                    }
                    sumlat = 0;
                    sumlng = 0;
                    x = 0;
                }
            }
        });

    });

    $("#btn_add_subgarden1").click(function() {
        $("body").append(addSubGardenModal);
        $("#addSubGardenModal").modal('show');
    });

    $("#btn_info").click(function() {
        console.log("testefe");
    });
    $(document).on('click', '.insertSubmit', function(e) { // insert submit
        console.log('sss');

        let icon = $("#pic-logo");

        if (!checkNull(icon)) return;

        // let form = new FormData($('#formPhoto')[0]);
        // form.append('imagebase64', $('#img-insert').attr('src'))
        // insertPh(form); // insert data
    })
    $(document).on('click', '#cropImageBtn', function(ev) {

        $('#upload-demo').croppie('result', {
                type: 'canvas',
                size: 'viewport'
            })
            .then(function(r) {
                $('.buttonSubmit').show()
                $('.divName').show()
                $('.buttonCrop').hide()
                $('.divHolder').show()
                $('#img-insert').attr('src', r);
                $('#imagebase64').val(r);
                $('.divCrop').hide()
            });
        $('#upload-demo').croppie('destroy')

    });
    $(document).on('click', '#cancelCrop', function() {
        $('#upload-demo').croppie('destroy')
        $('.divName').show()
        $('.divHolder').show()
        $('.divCrop').hide()
        $('.buttonCrop').hide()
        $('.buttonSubmit').show()
        // $('#img-insert').attr('src', "https://via.placeholder.com/200x200.png");
    })


    //  <!-- ส่วนที่ต้องเอาไปแทนในของอิง -->
    document.getElementById("province1").addEventListener("load", loadProvince1());

    let data;

    // โหลดจังหวัด
    function loadProvince1() {
        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                data = JSON.parse(this.responseText);
                let text = "";
                for (i in data) {
                    text += ` <option value='${data[i].AD1ID}'>${data[i].Province}</option> `

                }
                $("#province1").append(text);

            }
        };
        xhttp.open("GET", "./loadProvince.php", true);
        xhttp.send();
    }
    // โหลดอำเภอ

    $("#province1").on('change', function() {
        $("#amp1").empty();
        let x = document.getElementById("province1").value;
        let y = document.getElementById("province1");
        if (y.length == 78)
            y.remove(0);
        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {

            if (this.readyState == 4 && this.status == 200) {
                data = JSON.parse(this.responseText);
                let text = "";
                for (i in data) {
                    text += ` <option value ='${data[i].AD2ID}'>${data[i].Distrinct}</option> `
                }
                $("#amp1").append(text);
            }
        };
        xhttp.open("GET", "./loadDistrinct.php?id=" + x, true);
        xhttp.send();
    });
    // โหลดตำบล
    $("#amp1").on('change', function() {
        $("#subamp").empty();
        let x = document.getElementById("amp1").value;
        let y = document.getElementById("amp1");
        if (y.length == 78)
            y.remove(0);
        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {

                data = JSON.parse(this.responseText);
                let text = "";
                for (i in data) {
                    text += ` <option value ='${data[i].AD3ID}'>${data[i].subDistrinct}</option> `
                }

                $("#subamp").append(text);
            }
        };
        xhttp.open("GET", "./loadSubDistrinct.php?id=" + x, true);
        xhttp.send();
    });
    //  <!-- ส่วนที่ต้องเอาไปแทนในของอิง -->
    //<!-- ส่วนแก้ไขสวน -->
    document.getElementById("province2").addEventListener("load", loadProvince2());



    // โหลดจังหวัด
    function loadProvince2() {
        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                data = JSON.parse(this.responseText);
                let text = "<option value='0'>เลือกจังหวัด</option> ";
                for (i in data) {
                    if (data[i].AD1ID == '<?= $DATAFarm[1]['AD1ID'] ?>') {
                        text += ` <option value='${data[i].AD1ID}' selected>${data[i].Province}</option> `;
                    } else {
                        text += ` <option value='${data[i].AD1ID}'>${data[i].Province}</option> `;
                    }
                }
                $("#province2").append(text);
                loadDistrinct2();


            }
        };
        xhttp.open("GET", "./loadProvince.php", true);
        xhttp.send();
    }

    function loadDistrinct2() {
        $("#amp2").empty();
        let x = document.getElementById("province2").value;
        let y = document.getElementById("province2");
        if (y.length == 78)
            y.remove(0);
        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {

            if (this.readyState == 4 && this.status == 200) {
                data = JSON.parse(this.responseText);
                let text = "<option value='0'>เลือกอำเภอ</option>";
                for (i in data) {
                    if (data[i].AD2ID == '<?= $DATAFarm[1]['AD2ID'] ?>') {
                        text += ` <option value ='${data[i].AD2ID}' selected>${data[i].Distrinct}</option> `
                    } else {
                        text += ` <option value ='${data[i].AD2ID}'>${data[i].Distrinct}</option> `
                    }
                }
                $("#amp2").append(text);
                loadSubDistrinct2();

            }
        };
        xhttp.open("GET", "./loadDistrinct.php?id=" + x, true);
        xhttp.send();
    }

    function loadSubDistrinct2() {
        $("#subamp2").empty();
        let x = document.getElementById("amp2").value;
        let y = document.getElementById("amp2");
        if (y.length == 78)
            y.remove(0);
        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {

                data = JSON.parse(this.responseText);
                let text = "<option value='0'>เลือกตำบล</option>";
                for (i in data) {
                    if (data[i].AD3ID == '<?= $DATAFarm[1]['AD3ID'] ?>') {
                        text += ` <option value ='${data[i].AD3ID}' selected>${data[i].subDistrinct}</option> `
                    } else {
                        text += ` <option value ='${data[i].AD3ID}'>${data[i].subDistrinct}</option> `
                    }
                }

                $("#subamp2").append(text);
            }
        };
        xhttp.open("GET", "./loadSubDistrinct.php?id=" + x, true);
        xhttp.send();
    }
    // โหลดอำเภอ

    $("#province2").on('change', function() {
        $("#amp2").empty();
        let x = document.getElementById("province2").value;
        let y = document.getElementById("province2");
        if (y.length == 78)
            y.remove(0);
        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {

            if (this.readyState == 4 && this.status == 200) {
                data = JSON.parse(this.responseText);
                let text = "<option value='0'>เลือกอำเภอ</option>";
                for (i in data) {
                    text += ` <option value ='${data[i].AD2ID}'>${data[i].Distrinct}</option> `
                }
                $("#amp2").append(text);
            }
        };
        xhttp.open("GET", "./loadDistrinct.php?id=" + x, true);
        xhttp.send();
    });
    // โหลดตำบล
    $("#amp2").on('change', function() {
        $("#subamp2").empty();
        let x = document.getElementById("amp2").value;
        let y = document.getElementById("amp2");
        if (y.length == 78)
            y.remove(0);
        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {

                data = JSON.parse(this.responseText);
                let text = "<option value='0'>เลือกตำบล</option>";
                for (i in data) {
                    text += ` <option value ='${data[i].AD3ID}'>${data[i].subDistrinct}</option> `
                }

                $("#subamp2").append(text);
            }
        };
        xhttp.open("GET", "./loadSubDistrinct.php?id=" + x, true);
        xhttp.send();
    });
    //  <!--แก้ไขฟาร์ม -->

    $(document).ready(function() {
        let data;
        loadData();
        loadFarmer();

        function loadData() {

            $("#example1").DataTable().destroy();
            let logid = "<?php echo $logid; ?>"
            let xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    data = JSON.parse(this.responseText);
                    //console.table(data)
                    let i;
                    let text = "";
                    for (i = 1; i <= data[0].numrow; i++) {
                        
                        let tmpURL = "OilPalmAreaListSubDetail.php";
                        tmpURL += "?fmid=<?= $fmid ?>";
                        tmpURL += "&SFID="+data[i].dbID;
                        tmpURL += "&DIMfarmID="+data[i].DIMfarmID;
                        tmpURL += "&DIMSubfID="+data[i].DIMSubfID;
                        tmpURL += "&nfarm="+data[i].nFarm;
                        tmpURL += "&nsubfarm="+data[i].Name;
                        tmpURL += "&ffullname="+data[i].FullName;
                        tmpURL += "&farmer="+data[i].Alias;
                        tmpURL += "&logid="+data[i].ID;
                        tmpURL += "&numtree="+data[i].NumTree;

                        text += `<tr>
                            <td class="text-left">${data[i].Name}</td>
                            <td class="text-right">${data[i].AreaRai} ไร่ ${data[i].AreaNgan} งาน</td>
                            <td class="text-right">${data[i].NumTree} ต้น</td>
                            <td class="text-right">${data[i].year} ปี ${data[i].month} เดือน ${data[i].day} วัน</td>
                            <td style='text-align:center;'>
                                <a href='`+tmpURL+`'>
                                <button type='button' id='btn_info'  
                                    class="btn btn-info btn-sm btn_edit tt"
                                    data-toggle="tooltip" title="รายละเอียดข้อมูลแปลง" >
                                    <i class='fas fa-bars'></i>
                                </button></a>
                            <button type='button' id='btn_delete' 
                                class="btn btn-danger btn-sm btn_edit tt"
                                data-toggle="tooltip" title="ลบแปลง"
                                style="margin-right:10px;"  
                                onclick="delfunction('${data[i].namesub}' , '${data[i].dbID}')">
                                <i class='far fa-trash-alt'></i>
                            </button>   
                            </button>
                            </td>
                        </tr> `;

                    }

                    $("#getData").html(text);
                    $('#example1').DataTable();
                }
            };
            xhttp.open("GET", "./getData2.php?id=" + logid, true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send();
        }

        function loadFarmer() {
            $("#farmer2").empty;
            let xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    data = JSON.parse(this.responseText);
                    let text = "";
                    for (i in data) {
                        if (data[i].UFID == '<?= $DATAFarm[1]['UFID'] ?>') {
                            text += ` <option value="${data[i].UFID}" selected>${data[i].FirstName}</option> `;
                        } else {
                            text += ` <option value="${data[i].UFID}" >${data[i].FirstName}</option> `;
                        }
                    }

                    $("#farmer2").append(text);
                }
            };
            xhttp.open("GET", "./loadFarmer.php", true);
            xhttp.send();
        }

    });

    function setAddr() {

    }
</script>
<script>
    function initMap() {
        var startLatLng = new google.maps.LatLng(<?= $latlong[1]['Latitude'] ?>, <?= $latlong[1]['Longitude'] ?>);

        mapdetail = new google.maps.Map(document.getElementById('map'), {
            // center: { lat: 13.7244416, lng: 100.3529157 },
            center: startLatLng,
            zoom: 13,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        mapdetail.markers = [];
        <?php
        for ($i = 1; $i < count($manycoor); $i++) {
            echo "marker = new google.maps.Marker({
                position: new google.maps.LatLng(" . $manycoor[$i]['Latitude'] . "," . $manycoor[$i]['Longitude'] . "),
                map: mapdetail,
                title: \"test\"
                });
                
                //alert(marker.position);

                mapdetail.markers.push(marker);";
        }

        ?>



        // new map ///////////////////////////////////////////////////////////////////
        
        <?php
        $lat =0;
        $long = 0;
        for ($i = 1; $i < count($coorsfarm); $i++) {
            $lat = $lat+$coorsfarm[$i]['Latitude'];
            $long = $long+$coorsfarm[$i]['Longitude'];
        } ?>
        var startLatLng = new google.maps.LatLng(<?= $lat/(count($coorsfarm)-1) ?>, <?= $long/(count($coorsfarm)-1) ?>);

        mapcolor = new google.maps.Map(document.getElementById('map2'), {
            // center: { lat: 13.7244416, lng: 100.3529157 },
            center: startLatLng,
            zoom: 16,
            mapTypeId: 'satellite'
        });

        mapcolor.markers = [];






        var triangleCoords = [

            <?php
            for ($i = 1; $i <= $numcoor[1]['count']; $i++)
                echo "
            {
                lat:  " . $coorsfarm[$i]['Latitude'] . "   ,
                lng: " . $coorsfarm[$i]['Longitude'] . "
            },";
            ?>


        ];
        <?php
        $k = 5;
        for ($i = 1; $i <= count($subfarm) - 2; $i++) {
            echo "
            var triangleCoords$i = [";

            for ($j = 1; $j <= $numcoor[$i + 1]['count']; $j++) {

                echo "
                    {
                        lat: " . $coorsfarm[$k]['Latitude'] . " ,
                        lng: " . $coorsfarm[$k]['Longitude'] . "
                    },";
                $k++;
            }



            echo "];
            ";
        }
        ?>



        console.log(triangleCoords);

        <?php
        for ($i = 0; $i <= count($subfarm); $i++) {
            if ($i == 0) {
                echo "
        var mapPoly = new google.maps.Polygon({
            paths: triangleCoords,
            strokeColor: '#FF0000',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: '#FF0000',
            fillOpacity: 0.35
        });
        mapPoly.setMap(mapcolor);";
            } else {
                echo "
        var mapPoly$i = new google.maps.Polygon({
            paths: triangleCoords$i,
            strokeColor: '#FF0000',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: '#FF0000',
            fillOpacity: 0.35
        });
        mapPoly$i.setMap(mapcolor);";
            }
        }

        ?>



    }

    function delfunction(_username, _uid) {

        swal({
                title: "คุณต้องการลบ",
                text: `${_username} หรือไม่ ?`,
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                cancelButtonClass: "btn-secondary",
                confirmButtonText: "ยืนยัน",
                cancelButtonText: "ยกเลิก",
                closeOnConfirm: false,
                closeOnCancel: function() {
                    $('[data-toggle=tooltip]').tooltip({
                        boundary: 'window',
                        trigger: 'hover'
                    });
                    return true;
                }
            },
            function(isConfirm) {
                if (isConfirm) {
                    console.log(_uid);
                    swal({

                        title: "ลบข้อมูลสำเร็จ",
                        type: "success",
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "ตกลง",
                        closeOnConfirm: false,

                    }, function(isConfirm) {
                        if (isConfirm) {
                            deleteSub(_uid)
                        }

                    });

                } else {

                }
            });

    }

    function deleteSub(_fid) {
        var xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                window.location.href = './OilPalmAreaListDetail.php';

            }
        };
        xhttp.open("POST", "manage.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send(`fsid=${_fid}&deleteSub=delete`);

    }
</script>