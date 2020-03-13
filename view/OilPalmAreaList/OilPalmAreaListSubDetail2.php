<?php
session_start();

$idUT = $_SESSION[md5('typeid')];
$CurrentMenu = "OilPalmAreaList";
?>


<?php include_once("../layout/LayoutHeader.php");
if (isset($_GET[('nfarm')]) && isset($_GET[('nsubfarm')]) && isset($_GET[('farmer')]) && isset($_GET[('logid')]) && isset($_GET[('numtree')])) {
    $nfarm = $_SESSION[('nfarm')] = $_GET[('nfarm')];
    $nsubfarm = $_SESSION[('nsubfarm')] = $_GET[('nsubfarm')];
    $farmer = $_SESSION[('farmer')] = $_GET[('farmer')];
    $ffullname = $_SESSION[('ffullname')] = $_GET[('ffullname')];
    $logid = $_SESSION[('logid')] = $_GET[('logid')];
    $numtree = $_SESSION[('numtree')] = $_GET[('numtree')];
    $fmid = $_SESSION[('fmid')] = $_GET[('fmid')];
    $numtree = $_SESSION[('numtree')] = $_GET[('numtree')];
} else {
    $nfarm = $_SESSION[('nfarm')];
    $nsubfarm = $_SESSION[('nsubfarm')];
    $farmer = $_SESSION[('farmer')];
    $ffullname = $_SESSION[('ffullname')];
    $logid = $_SESSION[('logid')];
    $numtree = $_SESSION[('numtree')];
    $fmid = $_SESSION[('fmid')];
    $numtree = $_SESSION[('numtree')];
}
$sumtree = 0;

$suid = $_GET[('SFID')];
$StartT = time();
$sql = "SELECT 	`db-subfarm`.* ,`db-subdistrinct`.`AD2ID`,`db-distrinct`.`AD1ID` FROM `db-subfarm` INNER JOIN `db-subdistrinct`ON `db-subfarm`.`AD3ID`=`db-subdistrinct`.`AD3ID`
 INNER JOIN `db-distrinct`ON`db-distrinct`.`AD2ID`=`db-subdistrinct`.`AD2ID` WHERE `FSID`='$suid'";
$dataFarm = selectData($sql);
$sql = "SELECT Address , subDistrinct , Distrinct , Province FROM `db-farm`
inner join `db-subdistrinct` on `db-subdistrinct`.`AD3ID` = `db-farm`.`AD3ID`
inner join `db-distrinct` on `db-distrinct`.`AD2ID` = `db-subdistrinct`.`AD2ID`
inner join `db-province` on `db-province`.`AD1ID` = `db-distrinct`.`AD1ID`
where Name = '" . $nfarm . "'";
$sql2 = "SELECT `log-farm`.`AreaRai`,`log-farm`.`AreaNgan`,`log-farm`.`AreaWa`,`log-farm`.`ID` FROM `db-farm`  
inner join `db-subfarm` on `db-farm`.`FMID` = `db-subfarm`.`FMID` 
INNER JOIN `dim-farm` on `db-farm`.FMID = `dim-farm`.`dbID`  
INNER JOIN `log-farm` on `log-farm`.`DIMfarmID`=`dim-farm`.`ID`
where `log-farm`.`ID` ='" . $logid . "'
group by `log-farm`.`ID`";
$sql3 = "SELECT `dim-farm`.`Name`,`log-planting`.`NumGrowth1`,`log-planting`.`NumGrowth2`,`log-planting`.`NumDead`,`dim-time`.`Date` 
 FROM `dim-farm`
INNER JOIN `log-planting` on `log-planting`.`DIMsubFID` = `dim-farm`.`ID`
INNER JOIN `dim-time` on `dim-time`.`ID` = `log-planting`.`DIMdateID`

WHERE`dim-farm`.`Name` = '" . $nsubfarm . "'
GROUP BY  `dim-farm`.`Name`,`log-planting`.`NumGrowth1`,`log-planting`.`NumGrowth2`,`log-planting`.`NumDead`
ORDER BY `log-planting`.`NumGrowth1`  DESC";
$sql4 = "SELECT `dim-farm`.`Name` , `log-planting`.`DIMdateID` ,FLOOR(TIMESTAMPDIFF(DAY,`dim-time`.`Date`,CURRENT_TIME)% 30.4375 )as day,FLOOR(TIMESTAMPDIFF( MONTH,`dim-time`.`Date`,CURRENT_TIME)% 12 )as month,FLOOR(TIMESTAMPDIFF( YEAR,`dim-time`.`Date`,CURRENT_TIME))as year from
`dim-farm` INNER JOIN `log-planting` ON `dim-farm`.`ID` =`log-planting`.`DIMsubFID`
INNER JOIN `dim-time` on `log-planting`.`DIMdateID` = `dim-time`.`ID`
where `dim-farm`.`Name` = '" . $nsubfarm . "'
group by `dim-farm`.`Name`,`dim-time`.`ID`";
$sql5 = "SELECT DISTINCT `dim-time`.`Year2` FROM `log-harvest`
INNER JOIN `dim-time` on `log-harvest`.`DIMdateID` = `dim-time`.`ID`  
ORDER BY `dim-time`.`Year2` DESC";
$sql6 = "SELECT max(m.Year2) as max from (SELECT t.Year2 FROM(SELECT `dim-time`.`Year2`,`dim-farm`.`Name`,`log-harvest`.`Weight` FROM `log-harvest` INNER JOIN `dim-time` on `log-harvest`.`DIMdateID` = `dim-time`.`ID` INNER JOIN `dim-farm` on `dim-farm`.`ID` = `log-harvest`.`DIMsubFID` WHERE `dim-farm`.`Name` = '" . $nsubfarm . "' AND`dim-farm`.`IsFarm`='0' ORDER BY `dim-time`.`Year2` ASC) as t 
GROUP BY t.`Year2`) as m";
$sql7 = "SELECT SUM(`log-fertilising`.`Vol`) as sumvol FROM `log-fertilising` 
INNER JOIN `dim-time` ON `dim-time`.`ID` = `log-fertilising`.`DIMdateID`
INNER JOIN `dim-fertilizer` ON `dim-fertilizer`.`ID` = `log-fertilising`.`DIMferID`  
INNER JOIN `dim-farm` on `dim-farm`.`ID` = `log-fertilising`.`DIMsubFID`
where `dim-farm`.`Name` = '" . $nsubfarm . "'
GROUP BY `dim-fertilizer`.`Name` ,`dim-time`.`Year2`
ORDER BY `dim-time`.`Year2`  DESC LIMIT 3";
$sql8 = "SELECT`dim-time`.`Year2`,`dim-farm`.`Name` FROM `log-fertilising`
INNER JOIN `dim-time` ON `log-fertilising`.`DIMdateID` = `dim-time`.`ID`
INNER JOIN `dim-farm` ON `dim-farm`.`ID` = `log-fertilising`.`DIMsubFID`
where `dim-farm`.`Name` = '" . $nsubfarm . "'
group by `dim-time`.`Year2`  
ORDER BY `dim-time`.`Year2`  DESC LIMIT 3";
$sql9 = "SELECT `dim-fertilizer`.`Name`as namevol FROM `log-fertilising` 
INNER JOIN `dim-time` ON `dim-time`.`ID` = `log-fertilising`.`DIMdateID`
INNER JOIN `dim-fertilizer` ON `dim-fertilizer`.`ID` = `log-fertilising`.`DIMferID`  
INNER JOIN `dim-farm` on `dim-farm`.`ID` = `log-fertilising`.`DIMsubFID`
where `dim-farm`.`Name` = '" . $nsubfarm . "' 
GROUP BY `dim-fertilizer`.`Name` 
ORDER BY `dim-time`.`Year2`";
$sql10 = "SELECT `log-farm`.`Latitude` , `log-farm`.`Longitude`  FROM `log-farm`
where `log-farm`.`ID` = '" . $logid . "'";
$sql11 = "SELECT  `db-fertilizer`.`EQ1`,`db-fertilizer`.`EQ2` FROM `db-fertilizer`
INNER JOIN `dim-fertilizer` ON `dim-fertilizer`.`dbID` = `db-fertilizer`.`FID`
INNER JOIN `log-fertilising` ON `log-fertilising`.`DIMferID` = `dim-fertilizer`.`ID`
INNER JOIN `dim-farm` on `dim-farm`.`ID`= `log-fertilising`.`DIMsubFID`
where `dim-farm`.`Name` ='" . $nsubfarm . "'  ";
$sql12 = "SELECT `log-icon`.`DIMiconID`,`log-icon`.`Path`,`log-icon`.`FileName` FROM `log-icon` 
INNER JOIN `dim-user` on`log-icon`.`DIMiconID` = `dim-user`.`ID`
INNER JOIN `db-farmer` on `db-farmer`.`UFID` = `dim-user`.`dbID`
WHERE `log-icon`.`Type` = 5 AND `db-farmer`.`FirstName`='" . $farmer . "'";
$sql13 = "SELECT `log-icon`.`DIMiconID`,`log-icon`.`Path`,`log-icon`.`FileName` FROM `log-icon` 
INNER JOIN `dim-farm` on`log-icon`.`DIMiconID` = `dim-farm`.`ID`
INNER JOIN `db-subfarm` on `db-subfarm`.`FSID` = `dim-farm`.`dbID`
WHERE `log-icon`.`Type` = 3 AND `db-subfarm`.`Name`= '" . $nsubfarm . "' ";

$address = selectData($sql);
$areatotal = selectData($sql2);
$tree = selectData($sql3);
$dmy = selectData($sql4);
// echo $sql6;
$year = selectData($sql5);
$maxyear = selectData($sql6);
$vol = selectDataArray($sql7);
$yearvol = selectData($sql8);
$namevol = selectData($sql9);
//print_r($namevol);
$latlong = selectData($sql10);
$numvol = selectData($sql11);
$idfarmer = selectData($sql12);
$idfarm = selectData($sql13);
//echo ($vol);


//print_r($idfarm);


?>

<style>
    #map {
        width: 100%;
        height: 700px;
    }

    #find {
        max-width: 500px;
    }
</style>

<div class="container">
    <!-- <?php echo "{$maxyear[1]['max']}" ?> -->

    <div class="row">
        <div class="col-xl-12 col-12 mb-4">
            <div class="card">
                <div class="card-header card-bg">
                    <div class="row">
                        <div class="col-12">
                            <span class="link-active font-weight-bold" style="color:<?=$color?>;">รายละเอียดแปลงปลูก</span>
                            <span style="float:right;">
                                <i class="fas fa-bookmark"></i>
                                <a class="link-path" href="#">หน้าแรก</a>
                                <span> > </span> 
                                <a class="link-path" href="OilPalmAreaList.php">รายชื่อสวนปาล์มน้ำมัน</a>
                                <span> > </span>
                                <a class="link-path" href="#">รายละเอียดสวนปาล์มน้ำมัน</a>
                                <span> > </span>
                                <a class="link-path link-active" href="#" style="color:<?=$color?>;">รายละเอียดแปลงปลูก</a>
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
                            <span><?php echo "$nfarm" ?></span>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-xl-4 col-4 text-right font-weight-bold" style="color:<?=$color?>;">
                            <span>ชื่อแปลง : </span>
                        </div>
                        <div class="col-xl-8 col-8">
                            <span><?php echo "$nsubfarm" ?></span>
                            <button type="button" id="edit_photo" 
                            class="btn btn-warning btn-sm tt" style="float:right;"
                            title='เปลี่ยนรูปโปรไฟล์สวน'
                            uid="<?php echo $fmid; ?>">
                            <i class="fas fa-image"></i></button>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <img class="img-radius img-profile" src="<?php echo "../../".$idfarm[1]['Path']."/".$idfarm[1]['FileName']; ?>" />
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-12">
            <div class="card">
                <div class="card-body" id="card_height">
                    <div class="row mt-3 justify-content-center">
                        <div class="col-xl-4 col-4 text-right font-weight-bold" style="color:<?=$color?>;">
                            <span>เกษตรกร : </span>
                        </div>
                        <div class="col-xl-8 col-8">
                            <span><?php echo "$ffullname" ?></span>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <img class="img-radius img-profile" 
                        src="<?php echo "../../".$idfarmer[1]['Path']."/".$idfarmer[1]['FileName']; ?>" >
                    </div>
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
                            <span>พื้นที่แปลงปลูก : </span>
                        </div>
                        <div class="col-xl-8 col-8">
                            <span><?php echo $areatotal[1]['AreaRai']; ?> ไร่ <?php echo $areatotal[1]['AreaNgan']; ?> งาน <?php echo $areatotal[1]['AreaWa']; ?> วา</span>
                        </div>
                        <div class="col-xl-2 col-2">
                            <button type="button" id="btn_add_map" 
                                class="btn btn-warning btn-sm btn_edit tt"
                                data-toggle="tooltip" title="แก้ไขตำแหน่งแปลง"
                                style="float:right;" >
                                <i class="fas fa-map-marker"></i>
                            </button>
                            <button type="button" id="btn_edit_subdetail1" 
                                class="btn btn-warning btn-sm btn_edit tt"
                                data-toggle="tooltip" title="แก้ไขข้อมูลแปลง"
                                style="float:right; margin-right:10px;" >
                                <i class="fas fa-edit"></i>
                            </button>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <!--div class="col-12 mb-3">
                            <button type="button" id="btn_edit_subdetail1" 
                            style="float:right;" class="btn btn-warning btn-sm">แก้ไขข้อมูลแปลง</button>
                            <button type="button" id="btn_add_map" 
                            style="float:right;" class="btn btn-success btn-sm">เพิ่มตำแหน่งแปลง</button>
                        </div-->
                        <div class="col-xl-6 col-12">
                            <div id="map" style="width:auto; height:360px;"></div>
                        </div>
                        <div class="col-xl-6 col-12">
                            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                                <ol class="carousel-indicators">
                                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                                </ol>
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <img class="" src="../../picture/farm/defaultPalm1.jpg">
                                    </div>
                                    <div class="carousel-item">
                                        <img class="" src="../../picture/farm/defaultPalm2.jpg">
                                    </div>
                                    <div class="carousel-item">
                                        <img class="" src="../../picture/farm/defaultPalm3.jpg">
                                    </div>
                                </div>
                                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-xl-12 col-12">
            <div class="card">
                <div class="card-header card-bg" style="color:<?=$color?>;">
                        <button type="button" id="plantingmodal" 
                            style="float:right;" class="btn btn-success btn-sm">เพิ่มข้อมูลการปลูก</button>
                    <?php
                    if ($dmy[0]['numrow'] == 0) {
                        echo "<h4>- ต้น อายุ - ปี - เดือน - วัน</h4>";
                    } else {
                        echo "<h4>$numtree ต้น อายุ  {$dmy[1]['year']} ปี {$dmy[1]['month']} เดือน {$dmy[1]['day']} วัน</h4>";
                    }
                    ?>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-6 col-12">
                            <?php
                            $n = 1;
                            $m = 1;
                            $sumng1 = 0;
                            $sumng2 = 0;
                            $sumdead = 0;
                            $sum = 0;
                            if ($tree[0]['numrow'] == 0) {
                                echo "<h4>ไม่มีข้อมูล</h4>";
                            } else {

                                for ($i = 1; $i <= $tree[0]['numrow']; $i++) {
                                    if ($tree[$i]['NumGrowth1'] > 0) {
                                        $sumng1 += $tree[$i]['NumGrowth1'];
                                        echo "<div class=\"row mb-3\">
                                <div class=\"col-xl-2 col-2 font-weight-bold\" style=\"color:$color;\">
                                    <span>ปลูก :  </span>
                                </div>
                                <div class=\"col-xl-5 col-5\">
                                    <span>" . date("d/m/
                                    ", strtotime($tree[$i]['Date'])) . (date("Y", strtotime($tree[$i]['Date'])) + 543) . "</span>
                                </div>
                                <div class=\"col-xl-5 col-5\">
                                    <span>{$tree[$i]['NumGrowth1']} ต้น</span>
                                </div>
                                </div>";
                                    }
                                    if ($tree[$i]['NumGrowth2'] > 0) {
                                        $sumng2 += $tree[$i]['NumGrowth2'];
                                        echo "<div class=\"row mb-3\">
                                <div class=\"col-xl-2 col-2 font-weight-bold\" style=\"color:$color;\">
                                    <span>ซ่อม" . $n++ . " :  </span>
                                </div>
                                <div class=\"col-xl-5 col-5\">
                                    <span>" . date("d/m/
                                    ", strtotime($tree[$i]['Date'])) . (date("Y", strtotime($tree[$i]['Date'])) + 543) . "</span>
                                </div>
                                <div class=\"col-xl-5 col-5\">
                                    <span>{$tree[$i]['NumGrowth2']} ต้น</span>
                                </div>
                                </div>";
                                    }
                                    if ($tree[$i]['NumDead'] > 0) {
                                        $sumdead += $tree[$i]['NumDead'];
                                        echo "<div class=\"row mb-3\">
                                <div class=\"col-xl-2 col-2 font-weight-bold\" style=\"color:$color;\">
                                     <span>ตาย" . $m++ . " :  </span>
                                 </div>
                                 <div class=\"col-xl-5 col-5\">
                                     <span>" . date("d/m/
                                     ", strtotime($tree[$i]['Date'])) . (date("Y", strtotime($tree[$i]['Date'])) + 543) . "</span>
                                 </div>
                                 <div class=\"col-xl-5 col-5\">
                                     <span>-{$tree[$i]['NumDead']} ต้น</span>
                                 </div>
                                 </div>";
                                    }
                                }
                                $sum += $sumng1 + $sumng2 + $sumdead;
                                $sumtree = $sum;
                                $sumng1 = round(($sumng1 / $sum) * 100, 1);
                                $sumng2 = round(($sumng2 / $sum) * 100, 1);
                                $sumdead = round(($sumdead / $sum) * 100, 1);
                            }


                            ?>
                        </div>
                        <div class="col-xl-6 col-12">
                            <div class="row">
                                <div class="col-8">
                                    <canvas id="plantPie"></canvas>
                                </div>
                                <div class="col-4">
                                    <div class="row mt-2">
                                        <div class="col-3 mt-1">
                                            <div style="width: 30px; height: 15px; background-color: #00ce68; "></div>
                                        </div>
                                        <div class="col-9">
                                            <span>ปลูก <?= $sumng1 ?> %</span>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-3 mt-1">
                                            <div style="width: 30px; height: 15px; background-color: #f6c23e; "></div>
                                        </div>
                                        <div class="col-9">
                                            <span>ซ่อม <?= $sumng2 ?> %</span>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-3 mt-1">
                                            <div style="width: 30px; height: 15px; background-color: #e74a3b; "></div>
                                        </div>
                                        <div class="col-9">
                                            <span>ตาย <?= $sumdead ?> %</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4 mb-4">
        <div class="col-xl-12 col-12">
            <div class="card">
                <div class="card-header card-bg">
                    <div class="row">
                        <div class="col-6">
                            <a href="OilPalmAreaVolDetail.php " style="text-decoration: none;"
                            data-toggle="tooltip" title="รายละเอียดผลผลิต">
                                <h4><i class='fas fa-leaf'></i> ผลผลิต</h4>
                                        </button>
                            </a>
                        </div>
                        <div class="col-6">
                            <select id="year" class="form-control" style="width:20%; float:right;">
                                <?php
                                for ($i = 1; $i <= $year[0]['numrow']; $i++) {
                                    echo "<option value='{$year[$i]['Year2']}'>{$year[$i]['Year2']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <?php
                    if ($maxyear[1]['max'] != null) {
                        echo "<div class=\"row\">
                            <div class=\"col-xl-6 col-12 PDY\">
                                <canvas id=\"productYear\" style=\"height:250px;\"></canvas>
                            </div>
                            <div class=\"col-xl-6 col-12 PDM\">
                                <canvas id=\"productMonth\" style=\"height:250px;\"></canvas>
                            </div>
                        </div>";
                    } else {
                        echo "<h4>ไม่มีข้อมูล</h4>";
                    }
                    ?>
                    <!--div class="row"> 
                        <div class="col-xl-6 col-12 PDY">
                            <canvas id="productYear" style="height:250px;"></canvas>
                        </div>
                        <div class="col-xl-6 col-12 PDM">
                            <canvas id="productMonth" style="height:250px;"></canvas>
                        </div>
                    </div-->
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4 mb-4">
        <div class="col-xl-12 col-12">
            <div class="card">
                <div class="card-header card-bg">
                    <h4>ปริมาณการใส่ปุ๋ย</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-12 col-12">
                            <div class="row">
                                <?php
                                if ($namevol[0]['numrow'] != 0) {
                                    for ($i = 1; $i <= $namevol[0]['numrow']; $i++) {
                                        echo "
                                <div class=\"col-4\">
                                    <canvas id=\"ferYear" . $i . "\" style=\"height:250px;\"></canvas>
                                </div>";
                                    }
                                } else {
                                    echo "<h4>ไม่มีข้อมูล</h4>";
                                }
                                ?>
                            </div>
                            <div class="row">
                                <?php
                                if ($namevol[0]['numrow'] != 0) {
                                    for ($i = 1; $i <= $namevol[0]['numrow']; $i++) {
                                        echo "
                                    <div class=\"col-4 text-center\">
                                    <span style=\"margin-left: 17%;\">" . $namevol[$i]['namevol'] . "</span>
                                </div>";
                                    }
                                }



                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editSubDetailModal1" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <!-- ส่วนขอการแก้ไข เฟรม -->
                <form class="form-signin" method="POST" action='updateData.php'>
                    <div class="modal-header header-modal">
                        <h4 class="modal-title">แก้ไขแปลง</h4>
                    </div>
                    <div class="modal-body" id="addModalBody">
                        <div class="row mb-4">
                            <div class="col-xl-3 col-12 text-right">
                                <span>ชื่อแปลง</span>
                            </div>
                            <div class="col-xl-9 col-12">
                                <input type="text" class="form-control" id="namefarm" name="namefarm" value="<?php echo $dataFarm[1]['Name'] ?>">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-xl-3 col-12 text-right">
                                <span>ชื่อย่อแปลง</span>
                            </div>
                            <div class="col-xl-9 col-12">
                                <input type="text" class="form-control" id="initials" name="initials" value="<?php echo $dataFarm[1]['Alias'] ?>">
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
                                        <input type="number" class="form-control" id="farm" name="farm" value="<?php echo $dataFarm[1]['AreaRai'] ?>">
                                    </div>
                                    <div class="col-3 mt-1">
                                        <span>ไร่</span>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-3">
                                        <input type="number" class="form-control" id="work" name="work" value="<?php echo $dataFarm[1]['AreaNgan'] ?>">
                                    </div>
                                    <div class="col-3 mt-1">
                                        <span>งาน</span>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-3">
                                        <input type="number" class="form-control" id="wah" name="wah" value="<?php echo $dataFarm[1]['AreaWa'] ?>">
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
                                <select id="subamp1" name="subdistrinct" class="form-control">
                                    <option selected="" disabled="">เลือกตำบล</option>
                                </select>
                            </div>
                        </div>

                    </div>
                    <input type="hidden" name="add">
                    <input type="hidden" id="fmid" name="fmid" value="<?php echo $fmid ?>">
                    <input type="hidden" id="id" name="id" value="<?php echo $id ?>">
                    <input type="hidden" id="fname" name="fname" value="<?php echo $fname ?>">
                    <input type="hidden" id="logid" name="logid" value="<?php echo $logid ?>">
                    <input type="hidden" id="StartT" name="StartT" value="<?php echo $StartT ?>">
                    <input type="hidden" id="suid" name="suid" value="<?php echo $suid ?>">
                    <div class="modal-footer">
                        <button class="btn btn-success btn-md" type="submit">ยืนยัน</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">ยกเลิก</button>
                    </div>
                </form>
                <!-- ส่วนขอการแก้ไข -->
            </div>
        </div>
    </div>
    <div class="modal fade" id="addMapModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header header-modal">
                    <h4 class="modal-title">เพิ่มตำแหน่งพื้นที่</h4>
                </div>
                <div class="modal-body" id="addModalBody">
                    <div class="row mb-4">
                        <div class="col-12">
                            <button type="button" id="btn_remove_mark" style="float:right;" class="btn btn-warning btn-sm">ลบตำแหน่งทั้งหมด</button>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div id="map_area_edit" style="width:100%; height:400px;"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success">ยืนยัน</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">ยกเลิก</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addplant" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form class="form-signin" method="POST" action='updateData.php'>
                    <div class="modal-header header-modal">
                        <h4 class="modal-title">เพิ่มข้อมูลการปลูก</h4>
                    </div>
                    <div class="modal-body" id="addModalBody">
                        <div class="row mb-4">
                            <div class="col-xl-3 col-12 text-right">
                                <span>ข้อมูลที่จะเพิ่ม</span>
                            </div>
                            <div class="col-xl-9 col-12">
                                <select id="" class="form-control" name="">
                                    <option>การปลูก</option>
                                    <option>การซ่อม</option>
                                    <option>การตาย</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-xl-3 col-12 text-right">
                                <span>วันที่ทำ</span>
                            </div>
                            <div class="col-xl-9 col-12">
                                <input type="date" class="form-control" id="" name="" value="">
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-success btn-md" type="submit">ยืนยัน</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">ยกเลิก</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include_once("../layout/LayoutFooter.php"); ?>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBMLhtSzox02ZCq2p9IIuihhMv5WS2isyo&callback=initMap&language=th" async defer></script>

<script src="OilPalmAreaListModal.js"></script>

<script type="text/javascript">
    // document.getElementById("year").addEventListener("load", loadData());
</script>

<script>
    var mapdetail, mapcolor;

    $("#card_height").css('height', $("#for_card").css('height'));

    $("#btn_add_subgarden").click(function() {
        $("body").append(addSubGardenModal);
        $("#addSubGardenModal").modal('show');
    });
    $("#btn_add_subgarden").click(function() {
        $("body").append(addSubGardenModal);
        $("#addSubGardenModal").modal('show');
    });
    $("#btn_add_map").click(function() {
        $("body").append(editMapModalFun(mapdetail, mapcolor));
        $("#addMapModal").modal('show');


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
            console.table(sumcoorlat, sumcoorlng);
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

    $("#btn_edit_subdetail1").click(function() {
        $("body").append(editSubDetailModal);
        $("#editSubDetailModal1").modal('show');
    });
    $("#plantingmodal").click(function() {
        $("body").append(addplant);
        $("#addplant").modal('show');
    });

    $("#btn_add_map").click(function() {
        $("body").append(addMapModal);
        $("#addMapModal").modal('show');
    });

    $("#btn_info").click(function() {
        console.log("testefe");
    });

    $("#btn_delete").click(function() {
        swal({
            title: "ยืนยันการลบข้อมูล",
            icon: "warning",
            buttons: ["ยกเลิก", "ยืนยัน"],
        });
    });
    // ส่วนของกราฟ////////////////////////////////////////////////////////////////////////////////////////////////

    $("#year").change(function() {

        var year = $(this).val();
        var nsubfarm = "<?= $nsubfarm ?>"
        if (year != '') {
            load_year(year, nsubfarm);
            load_month(year, nsubfarm);
        }

    });

    load_year("<?php echo $maxyear[1]['max'] ?>", "<?= $nsubfarm ?>")
    load_month("<?php echo $maxyear[1]['max'] ?>", "<?= $nsubfarm ?>")


    //  <!-- ส่วนที่ต้องเอาไปแทนในของอิง เฟรม -->
    document.getElementById("province1").addEventListener("load", loadProvince1());



    // โหลดจังหวัด
    function loadProvince1() {
        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                data = JSON.parse(this.responseText);
                let text = "<option value='0'>เลือกจังหวัด</option> ";
                for (i in data) {
                    if (data[i].AD1ID == '<?= $dataFarm[1]['AD1ID'] ?>') {
                        text += ` <option value='${data[i].AD1ID}' selected>${data[i].Province}</option> `;
                    } else {
                        text += ` <option value='${data[i].AD1ID}'>${data[i].Province}</option> `;
                    }
                }
                $("#province1").append(text);
                loadDistrinct2();


            }
        };
        xhttp.open("GET", "./loadProvince.php", true);
        xhttp.send();
    }

    function loadDistrinct2() {
        $("#amp1").empty();
        let x = document.getElementById("province1").value;
        let y = document.getElementById("province1");
        if (y.length == 78)
            y.remove(0);
        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {

            if (this.readyState == 4 && this.status == 200) {
                data = JSON.parse(this.responseText);
                let text = "<option value='0'>เลือกอำเภอ</option>";
                for (i in data) {
                    if (data[i].AD2ID == '<?= $dataFarm[1]['AD2ID'] ?>') {
                        text += ` <option value ='${data[i].AD2ID}' selected>${data[i].Distrinct}</option> `
                    } else {
                        text += ` <option value ='${data[i].AD2ID}'>${data[i].Distrinct}</option> `
                    }
                }
                $("#amp1").append(text);
                loadSubDistrinct2();

            }
        };
        xhttp.open("GET", "./loadDistrinct.php?id=" + x, true);
        xhttp.send();
    }

    function loadSubDistrinct2() {
        $("#subamp1").empty();
        let x = document.getElementById("amp1").value;
        let y = document.getElementById("amp1");

        if (y.length == 78)
            y.remove(0);
        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {

                data = JSON.parse(this.responseText);
                let text = "<option value='0'>เลือกตำบล</option>";
                for (i in data) {
                    if (data[i].AD3ID == '<?= $dataFarm[1]['AD3ID'] ?>') {
                        text += ` <option value='${data[i].AD3ID}' selected>${data[i].subDistrinct}</option> `
                    } else {
                        text += ` <option value='${data[i].AD3ID}'>${data[i].subDistrinct}</option> `
                    }
                }

                $("#subamp1").append(text);
            }
        };
        xhttp.open("GET", "./loadSubDistrinct.php?id=" + x, true);
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
                let text = "<option value='0'>เลือกอำเภอ</option>";
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
        $("#subamp1").empty();
        let x = document.getElementById("amp1").value;
        let y = document.getElementById("amp1");
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

                $("#subamp1").append(text);
            }
        };
        xhttp.open("GET", "./loadSubDistrinct.php?id=" + x, true);
        xhttp.send();
    });
    //  <!--แก้ไขฟาร์ม -->
    //  <!-- ส่วนที่ต้องเอาไปแทนในของอิง -->


    function load_year(year, nsubfarm) {
        $.ajax({
            url: "loadproduct.php",
            method: "POST",
            data: {
                year: year,
                nsubfarm: nsubfarm
            },
            dataType: "JSON",
            success: function(data) {

                chartyear(data);
                // chartyear(year)
            }
        });
        console.log(year+"555555555555")
    }

    function load_month(year, nsubfarm) {
        $.ajax({
            url: "loadMproduct.php",
            method: "POST",
            data: {
                year: year,
                nsubfarm: nsubfarm
            },
            dataType: "JSON",
            success: function(data) {

                chartmonth(data);
                // chartyear(year)
            }
        });
    }
    // ผลผลิตต่อเดือน////////////////////////////////////////////////////////
    function chartmonth(chart_data) {
        $('.PDM').empty()
        $('.PDM').html(` <canvas id="productMonth" style="height:250px;"></canvas>`)
        console.table(chart_data);
        let data2 = []
        var i, j = 0;

        for (i = 0; i < 12; i++) {
            if (chart_data[j] != null) {
                if (i == chart_data[j].Month - 1) {
                    console.log("5");
                    data2.push(chart_data[j].s)
                    j++;
                } else {
                    data2.push(0)
                }
            } else {
                data2.push(0)
            }
        }


        var chartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            legend: {
                display: false,
                position: 'top',
                labels: {
                    boxWidth: 80,
                    fontColor: 'black'
                }
            },
            scales: {
                yAxes: [{
                    interval: 100,
                    minimum: 0,
                    maximum: 500,
                    scaleLabel: {
                        display: true,
                        labelString: 'ผลผลิต (ก.ก.)'
                    },
                    gridLines: {
                        display: true
                    }
                }],
                xAxes: [{
                    scaleLabel: {
                        display: true,
                        labelString: 'รายเดือน'
                    },
                    gridLines: {
                        display: false
                    }
                }],
            }
        };
        var speedData = {
            labels: ["ม.ค.", "ก.พ.", "มี.ค.",
                "เม.ย", "พ.ค.", "มิ.ย.",
                "ก.ค.", "ส.ค.", "ก.ย.",
                "ต.ค.", "พ.ย.", "ธ.ค."
            ],
            datasets: [{
                data: data2,
                backgroundColor: '#05acd3'
            }]
        };

        var ctx = $("#productMonth");
        var plantPie = new Chart(ctx, {
            type: 'bar',
            data: speedData,
            options: chartOptions
        });


    }
    // ผลผลิตต่ปี///////////////////////////////////////////////////
    function chartyear(chart_data) {
        $('.PDY').empty()
        $('.PDY').html(` <canvas id="productYear" style="height:250px;"></canvas>`)
        //alert(chart_data);
        var jsonData = chart_data;
        let labelData = []
        let data2 = []
        for (i in chart_data) {

            labelData.push(chart_data[i].Year2)
            data2.push(chart_data[i].s)
        }
        // alert(labelData + "jjjjjjj" + data2)


        var chartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            legend: {
                display: false,
                position: 'top',
                labels: {
                    boxWidth: 80,
                    fontColor: 'black'
                }
            },
            scales: {
                yAxes: [{
                    interval: 500,
                    minimum: 0,
                    maximum: 2000,
                    scaleLabel: {
                        display: true,
                        labelString: 'ผลผลิต (ก.ก.)'
                    },
                    gridLines: {
                        display: true
                    },
                }],
                xAxes: [{
                    scaleLabel: {
                        display: true,
                        labelString: 'รายปี'
                    },
                    gridLines: {
                        display: false
                    }
                }],
            }
        };
        var speedData = {
            labels: labelData,
            datasets: [{
                label: "Demo Data 1",
                data: data2,
                backgroundColor: '#00ce68'
            }]
        };

        var ctx = $("#productYear");
        var plantPie = new Chart(ctx, {
            type: 'bar',
            data: speedData,
            options: chartOptions
        });
    }


    // ปลูกซ่อมตาย/////////////////////////////////////////////////////////

    var chartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        legend: {
            display: true,
            position: 'top',
            labels: {
                boxWidth: 50,
                fontColor: 'black'
            }
        },
    };

    var speedData = {
        labels: ["ปลูก", "ซ่อม", "ตาย"],
        datasets: [{
            label: "Demo Data 1",
            data: [<?= $sumng1 ?>, <?= $sumng2 ?>, <?= $sumdead ?>],
            backgroundColor: ["#00ce68", "#f6c23e", "#e74a3b"]
        }]
    };

    var ctx = $("#plantPie");
    var plantPie = new Chart(ctx, {
        type: 'pie',
        data: speedData,
        options: chartOptions
    });


    
    //Fer section////////////////////////////////////////////////////////
    <?php




    for ($i = 1; $i <= $namevol[0]['numrow']; $i++) {
        echo "var chartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            legend: {
                display: false,
                position: 'top',
                labels: {
                    boxWidth: 80,
                    fontColor: 'black'
                }
            },
            scales: {
                yAxes: [{
                    scaleLabel: {
                        display: true,
                        labelString: 'ปริมาณปุ๋ย (ก.ก.)'
                    },
                    gridLines: {
                        display: true
                    },
                    ticks: {
                        min: 0
                        
                    }
                }]
                ,
                xAxes: [{
                    scaleLabel: {
                        display: true,
                        labelString: 'รายปี'
                    },
                    gridLines: {
                        display: false
                    }
                }],
            }
        };
    
        var speedData = {
            labels: [\"2561\", \"2562\", \"2563\"],
            datasets: [
                {
                    label: \"Demo Data 1\",
                    data: $vol,
                    backgroundColor: '#05acd3'
                }
            ]
        };
    
        var ctx = $(\"#ferYear$i\");
        var plantPie = new Chart(ctx, {
            type: 'bar',
            data: speedData,
            options: chartOptions
        });";
    }
    ?>
</script>

<script>
    function initMap() {
        var startLatLng = new google.maps.LatLng(<?= $latlong[1]['Latitude'] ?>, <?= $latlong[1]['Longitude'] ?>);

        mapdetail = new google.maps.Map(document.getElementById('map'), {
            // center: { lat: 13.7244416, lng: 100.3529157 },
            center: startLatLng,
            zoom: 12,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        mapdetail.markers = [];
        marker = new google.maps.Marker({
            position: new google.maps.LatLng(<?= $latlong[1]['Latitude'] ?>, <?= $latlong[1]['Longitude'] ?>),
            map: mapdetail,
            title: "test"
        });
        mapdetail.markers.push(marker);



        // new map ///////////////////////////////////////////////////////////////////



        var startLatLng = new google.maps.LatLng(<?= $latlong[1]['Latitude'] ?>, <?= $latlong[1]['Longitude'] ?>);

        mapcolor = new google.maps.Map(document.getElementById('map2'), {
            // center: { lat: 13.7244416, lng: 100.3529157 },
            center: startLatLng,
            zoom: 13,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });


        var triangleCoords = [{
                lat: <?= $latlong[1]['Latitude'] ?> + 0.1,
                lng: <?= $latlong[1]['Longitude'] ?> - 0.3
            },
            {
                lat: <?= $latlong[1]['Latitude'] ?> + 0.2,
                lng: <?= $latlong[1]['Longitude'] ?> + 0.2
            },
            {
                lat: <?= $latlong[1]['Latitude'] ?> - 0.4,
                lng: <?= $latlong[1]['Longitude'] ?> + 0.6
            },
            {
                lat: <?= $latlong[1]['Latitude'] ?> - 0.4,
                lng: <?= $latlong[1]['Longitude'] ?> + 0.3555
            },
        ];


        // Construct the polygon.
        var mapPoly = new google.maps.Polygon({
            paths: triangleCoords,
            strokeColor: '#FF0000',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: '#FF0000',
            fillOpacity: 0.35
        });
        mapPoly.setMap(mapcolor);



    }

    function placeMarkerAndPanTo(latLng, map) {
        map.markers.push(marker);
        var marker = new google.maps.Marker({
            position: latLng,
            map: map
        });
        var triangleCoords = [{
                lat: 13.814029,
                lng: 100.037292
            },
            {
                lat: 13.5338601,
                lng: 100.54962158
            },
            {
                lat: 13.361143,
                lng: 100.984673
            },
            {
                lat: 14.31761484,
                lng: 100.6072998
            },
        ];
        console.table(triangleCoords);
        var bermudaTriangle = new google.maps.Polygon({
            paths: triangleCoords,
            strokeColor: '#FF0000',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: '#FF0000',
            fillOpacity: 0.35
        });
        map.panTo(latLng);

    }

    //location.length=0;
</script>