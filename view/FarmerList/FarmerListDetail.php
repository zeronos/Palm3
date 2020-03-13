<?php
include_once("../../dbConnect.php");
session_start();

$idUT = $_SESSION[md5('typeid')];
if(isset($_GET['farmerID']))
        $_SESSION["farmerID"] = $_GET['farmerID'];
    $ufid = $_SESSION["farmerID"];
$CurrentMenu = "FarmerList";
?>



<?php include_once("../layout/LayoutHeader.php"); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.css">
<!-- ----------------------- crop photo ------------------------- -->
<link href="../../croppie/croppie.css" rel="stylesheet" />
<link href="style.css" rel="stylesheet" />

<body>
    
    <div class="container">

        <div class="row">
            <div class="col-xl-12 col-12 mb-4">
                <div class="card">
                    <div class="card-header card-bg">
                        <div class="row">
                            <div class="col-12">
                                <span class="link-active  font-weight-bold" style="color:<?=$color?>;">รายละเอียดเกษตรกร</span>
                                <span style="float:right;">
                                    <i class="fas fa-bookmark"></i>
                                    <a class="link-path" href="#">หน้าแรก</a>
                                    <span> > </span>
                                    <a class="link-path" href="FarmerList.php">รายชื่อเกษตรกร</a>
                                    <span> > </span>
                                    <a class="link-path link-active" href="#" style="color:<?=$color?>;" >รายละเอียดเกษตรกร</a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
        $sql = "SELECT `db-farmer`.`UFID` , sum.`f` FROM `db-farmer`
        LEFT JOIN (SELECT `UFID` , COUNT(CASE WHEN `UFID` IN (`UFID`) THEN 1 END) f FROM `db-farm` GROUP BY `UFID`) AS sum
        ON sum.`UFID` = `db-farmer`.`UFID` Where `db-farmer`.`UFID` = $ufid GROUP BY `UFID`";
        $myConDB = connectDB();
        $result = $myConDB->prepare($sql);
        $result->execute();
        ?>

        <div class="row">
            <div class="col-xl-3 col-12 mb-4">
                <div class="card border-left-primary card-color-one shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="font-weight-bold  text-uppercase mb-1">จำนวนสวน</div>
                                <?php
                                while ($row = $result->fetch(PDO::FETCH_ASSOC)){
                                    ?>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"> <?php if($row['f'] != NULL) echo $row['f']; else echo "0" ?> สวน</div>
                                <?php
                                }
                                ?>
                            </div>
                            <div class="col-auto">
                                <i class="material-icons icon-big">group</i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        <?php
        $sql = "SELECT UFID, COUNT(CASE WHEN `UFID` IN (`UFID`) THEN 1 END) sf 
        FROM `db-subfarm`  LEFT JOIN `db-farm` ON `db-farm`.`FMID` = `db-subfarm`.`FMID` 
        WHERE UFID = $ufid GROUP BY UFID";
        $myConDB = connectDB();
        $result = $myConDB->prepare($sql);
        $result->execute();
        ?>


            <div class="col-xl-3 col-12 mb-4">
                <div class="card border-left-primary card-color-two shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="font-weight-bold  text-uppercase mb-1">จำนวนแปลง</div>
                                <?php
                                $row = $result->fetch(PDO::FETCH_ASSOC);
                                    ?>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php if($row["sf"] != NULL)echo $row["sf"]; else echo "0"; ?> แปลง</div>
                                
                            </div>
                            <div class="col-auto">
                                <i class="material-icons icon-big">waves</i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            $sql = "SELECT UFID, SUM(CASE WHEN `UFID` IN (`UFID`) THEN `AreaRai` END) A 
            FROM `db-subfarm` LEFT JOIN `db-farm` ON `db-farm`.`FMID` = `db-subfarm`.`FMID` 
            WHERE `UFID` = $ufid GROUP BY UFID ";
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
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php if($row["A"] != NULL) echo $row["A"]; else echo "0" ?> ไร่</div>
                                
                            </div>
                            <div class="col-auto">
                                <i class="material-icons icon-big">dashboard</i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            

            
            <?php
            //ALLTREE
            $sql = "SELECT sum(`log-farm`.`NumTree`) as sumTree, `dim-farm`.`dbID` , `db-farm`.`UFID`
            FROM `log-farm`
            INNER JOIN `dim-farm` on `dim-farm`.`ID` = `log-farm`.`DIMfarmID`
            INNER JOIN `db-farm` ON `db-farm`.`FMID` = `dim-farm`.`dbID` AND `dim-farm`.`IsFarm` = 1
            where `log-farm`.`EndT` is null AND `log-farm`.`DIMSubfID` is null AND `db-farm`.`UFID` = $ufid
            GROUP BY `db-farm`.`UFID` 
            ";
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
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php if($row["sumTree"] !=NULL) echo $row["sumTree"]; else echo "0"; ?> ต้น</div>
                            </div>
                            <div class="col-auto">
                                <i class="material-icons icon-big">format_size</i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-xl-6 col-12 mb-4">
                <div class="row">
                    <div class="col-xl-12 col-12">
                        <div class="card">
                            <div class="card-header card-bg font-weight-bold" style="color:<?=$color?>;">
                                <div>
                                <span>ข้อมูลเกษตรกร</span>
                                
                                </div> 
                                
                            </div>

                            
                            <?php
                                        $sql = "SELECT * , CASE WHEN `Title` IN ('1') THEN 'นาย'
                                        WHEN `Title` IN ('2') THEN 'นาง' 
                                        WHEN `Title` IN ('3') THEN 'นางสาว' END AS Title                   
                                        FROM `db-farmer` JOIN `db-subdistrinct` ON `db-subdistrinct`.`AD3ID` = `db-farmer`.`AD3ID` 
                                        JOIN `db-distrinct` ON `db-distrinct`.`AD2ID` = `db-subdistrinct`.`AD2ID`
                                        JOIN `db-province` ON `db-province`.`AD1ID` = `db-distrinct`.`AD1ID` WHERE `UFID` =$ufid ";
                                        $myConDB = connectDB();
                                        $result = $myConDB->prepare($sql);
                                        $result->execute();
                             
                                while ($row = $result->fetch(PDO::FETCH_ASSOC)){
                                ?>
                                    <div class="card-body" >
                                        
                                        <div align="center">
                                            
                                            <img src=<?php 
                                            if ($row["Icon"] != NULL)
                                                echo $src = "../../icon/farmer/".$ufid."/".$row["Icon"]; 
                                            else if($row['Title']=='นาย') 
                                                echo $src = "../../icon/farmer/man.jpg" ;
                                            else 
                                                echo $src = "../../icon/farmer/woman.jpg" ;
                                            ?> 
                                             alt="User" style="border-radius: 100%;width: 300px;height: 300px;">
                                        </div>

                                        <div class="row mb-4 mt-3">
                                            <div class="col-xl-3 col-12 text-right font-weight-bold" style="color:<?=$color?>;">
                                                <span>คำนำหน้า</span>
                                            </div>
                                            <div class="col-xl-9 col-12">
                                                <input type="text" class="form-control" id="rank" value="<?php echo $row['Title'] ?>" disabled>
                                            </div>
                                        </div>

                                        <div class="row mb-4">
                                            <div class="col-xl-3 col-12 text-right font-weight-bold" style="color:<?=$color?>;">
                                                <span>ชื่อ</span>
                                            </div>
                                            <div class="col-xl-9 col-12">

                                                <input type="text" class="form-control" id="firstname" value="<?php echo $row["FirstName"] ?>" disabled>

                                            </div>
                                        </div>

                                        <div class="row mb-4">
                                            <div class="col-xl-3 col-12 text-right font-weight-bold" style="color:<?=$color?>;">
                                                <span>นามสกุล</span>
                                            </div>
                                            <div class="col-xl-9 col-12">
                                                <input type="text" class="form-control" id="lastname" value="<?php echo $row["LastName"] ?>" disabled>
                                            </div>
                                        </div>

                                        <div class="row mb-4">
                                            <div class="col-xl-3 col-12 text-right font-weight-bold" style="color:<?=$color?>;">
                                                <span>ที่อยู่</span>
                                            </div>
                                            <div class="col-xl-9 col-12">
                                                <input type="text" class="form-control" id="address" value="<?php echo $row["Address"] ?>" disabled>
                                            </div>
                                        </div>

                                        <div class="row mb-4">
                                            <div class="col-xl-3 col-12 text-right font-weight-bold" style="color:<?=$color?>;">
                                                <span>ตำบล</span>
                                            </div>
                                            <div class="col-xl-9 col-12">
                                                <input type="text" class="form-control" id="subdistrict" value="<?php echo $row["subDistrinct"] ?>" disabled>
                                            </div>
                                        </div>

                                        <div class="row mb-4">
                                            <div class="col-xl-3 col-12 text-right font-weight-bold" style="color:<?=$color?>;">
                                                <span>อำเภอ</span>
                                            </div>
                                            <div class="col-xl-9 col-12">
                                                <input type="text" class="form-control" id="district" value="<?php echo $row["Distrinct"] ?>" disabled>
                                            </div>
                                        </div>

                                        <div class="row mb-4">
                                            <div class="col-xl-3 col-12 text-right font-weight-bold" style="color:<?=$color?>;">
                                                <span>จังหวัด</span>
                                            </div>
                                            <div class="col-xl-9 col-12">
                                                <input type="text" class="form-control" id="province" value="<?php echo $row["Province"] ?>" disabled>
                                            </div>
                                        </div>

                                        <div class="row mb-4">
                                            <div class="col-xl-3 col-12 text-right">
                                            </div>
                                            <div class="col-xl-9 col-12">
                                               
                                            </div>
                                        </div>


                                    </div>
                            <?php
                            
                            }
                            //$conn->close();
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-6 col-12 mb-4">
                <div class="card">
                    <div class="card-header card-bg font-weight-bold" style="color:<?=$color?>;">
                        ตำแหน่งสวนปาล์ม
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-12 col-12 mb-2">
                                <div id="map" style="width:auto; height:765px"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
        <div class="col-xl-12 col-12">
            <div class="card">
                <div class="card-header card-bg" style="color:#006633;">
                    <?php $sql = "SELECT * FROM `db-farmer` WHERE `UFID` = $ufid ";
                    $myConDB = connectDB();
                    $result = $myConDB->prepare($sql);
                    $result->execute();
                    $row = $result->fetch(PDO::FETCH_ASSOC)
                    ?>
                    รายชื่อสวนของ<?php echo $row["FirstName"] . " " . $row["LastName"]; ?>
                </div>
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-xl-3 col-12">
                            <button type="button" id="btn_comfirm" class="btn btn-outline-success btn-sm"><i class="fas fa-file-excel"></i> Excel</button>
                            <button type="button" id="btn_comfirm" class="btn btn-outline-danger btn-sm"><i class="fas fa-file-pdf"></i> PDF</button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover table-data" width="100%">
                            <thead>
                                <tr>
                                    <th>ชื่อสวน</th>
                                    <th>จังหวัด</th>
                                    <th>อำเภอ</th>
                                    <th>จำนวนแปลง</th>
                                    <th>พื้นที่ปลูก</th>
                                    <th>จำนวนต้น</th>
                                    
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>ชื่อสวน</th>
                                    <th>จังหวัด</th>
                                    <th>อำเภอ</th>
                                    <th>จำนวนแปลง</th>
                                    <th>พื้นที่ปลูก</th>
                                    <th>จำนวนต้น</th>
                                </tr>
                            </tfoot>
                            <?php
                            //INFO FARM
                            $sql = "SELECT * FROM `db-farm` 
                            INNER JOIN `db-subdistrinct` ON `db-subdistrinct`.`AD3ID` = `db-farm`.`AD3ID`
                            INNER JOIN `db-distrinct` ON `db-distrinct`.`AD2ID` = `db-subdistrinct`.`AD2ID`
                            INNER JOIN `db-province` ON `db-province`.`AD1ID` = `db-distrinct`.`AD1ID`
                            WHERE `UFID` = $ufid";
                            $myConDB = connectDB();
                            $result = $myConDB->prepare($sql);
                            $result->execute();
                            
                            //COUNT subFARM
                            $sql2 = "SELECT UFID, COUNT(CASE WHEN `UFID` IN (`UFID`) THEN 1 END) sf 
                            FROM `db-subfarm`  LEFT JOIN `db-farm` ON `db-farm`.`FMID` = `db-subfarm`.`FMID` 
                            WHERE `db-farm`.`UFID` = $ufid";
                            $myConDB = connectDB();
                            $result2 = $myConDB->prepare($sql2);
                            $result2->execute();

                            //COUNT TREE
                            $sql3 = "SELECT sum(`log-farm`.`NumTree`) as sumTree,`dim-farm`.`Name`, `dim-farm`.`dbID` , `db-farm`.`UFID`
                            FROM `log-farm`
                            INNER JOIN `dim-farm` on `dim-farm`.`ID` = `log-farm`.`DIMfarmID`
                            INNER JOIN `db-farm` ON `db-farm`.`FMID` = `dim-farm`.`dbID` AND `dim-farm`.`IsFarm` = 1
                            where `log-farm`.`EndT` is null AND `log-farm`.`DIMSubfID` is null AND `db-farm`.`UFID` = $ufid
                            GROUP BY `db-farm`.`FMID` ";
                            $myConDB = connectDB();
                            $result3 = $myConDB->prepare($sql3);
                            $result3->execute();

                            //COUNT AREA
                            $sql4 = "SELECT * FROM (SELECT FMID, SUM(CASE WHEN `FMID` IN (`FMID`) THEN `AreaRai` END) A 
                            FROM `db-subfarm` GROUP BY FMID) as t INNER JOIN `db-farm` ON `t`.FMID = `db-farm`.`FMID`
                            WHERE `db-farm`.`UFID` = $ufid";
                            $myConDB = connectDB();
                            $result4 = $myConDB->prepare($sql4);
                            $result4->execute();

                            $sql5 = "SELECT `dim-user`.`dbID`,`log-farm`.`ID`,`dim-farm`.`dbID` AS FMID ,`dim-address`.`Province`,`dim-address`.`Distrinct`,`dim-user`.`Alias`, `dim-farm`.`Name`,`log-farm`.`NumSubFarm`,`log-farm`.`AreaRai`,`log-farm`.`NumTree` FROM `log-farm` 
                            INNER JOIN `dim-user`ON `dim-user`.`ID` = `log-farm`.`DIMownerID`
                            INNER JOIN `dim-address`ON `dim-address`.`ID` =`log-farm`.`DIMaddrID`
                            INNER JOIN `dim-farm`ON `dim-farm`.`ID` = `log-farm`.`DIMfarmID`
                            WHERE `log-farm`.`DIMSubfID` IS NULL AND`log-farm`.`EndT`IS NULL AND `dim-user`.`dbID` = $ufid
                            ORDER BY `dim-address`.`Province`,`dim-address`.`Distrinct`,`dim-user`.`Alias`";
                            $myConDB = connectDB();
                            $result5 = $myConDB->prepare($sql5);
                            $result5->execute();
                            ?>

                            <tbody>
                                <?php 
                                while ($row = $result->fetch(PDO::FETCH_ASSOC)){
                                ?>
                                        <tr>
                                            <?php $row5 = $result5->fetch(PDO::FETCH_ASSOC)?> 
                                            <td><a href='./../OilPalmAreaList/OilPalmAreaListDetail.php?id=<?php echo $row5["Name"] ?> & fname=<?php echo $row5["Alias"] ?> & fmid=<?php echo $row5["FMID"] ?> & logid=<?php echo $row5["ID"] ?>' >
                                            <?php echo $row["Name"] ?></td>
                                            <td><?php echo $row["Province"] ?></td>
                                            <td><?php echo $row["Distrinct"] ?></td>
                                            <?php $row2 = $result2->fetch(PDO::FETCH_ASSOC) ?>
                                                <td class = "text-right"><?php if($row2["sf"] != NULL) echo $row2["sf"]; else echo "0"?> แปลง</td>
                                            <?php $row4 = $result4->fetch(PDO::FETCH_ASSOC) ?>
                                                <td class = "text-right"><?php if($row4["A"] != NULL) echo $row4["A"]; else echo "0" ?> ไร่</td>
                                            <?php $row3 = $result3->fetch(PDO::FETCH_ASSOC) ?>
                                                <td class = "text-right"><?php if($row3['sumTree'] != NULL) echo $row3['sumTree']; else echo "0" ?> ต้น</td>
                                        
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

    


    <?php include_once("../layout/LayoutFooter.php"); ?>


    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBMLhtSzox02ZCq2p9IIuihhMv5WS2isyo&callback=initMap&language=th" async defer></script>
    <script src="FarmerList.js"></script>
    <script src="FarmerListModal.js"></script>

    <script>
    function initMap() {

        <?php
            //INFO FARM
            $sql = "SELECT * FROM `db-farm` WHERE `UFID` = $ufid";
            $myConDB = connectDB();
            $result = $myConDB->prepare($sql);
            $result->execute();
            $row = $result->fetch(PDO::FETCH_ASSOC)
        ?>

        var startLatLng = new google.maps.LatLng(<?php if($row["Latitude"] != NULL) echo $row["Latitude"]; else echo "13.7244416" ?>, 
        <?php if($row["Longitude"] != NULL) echo $row["Longitude"]; else echo "100.3529157" ?>);

        mapdetail = new google.maps.Map(document.getElementById('map'), {
        // center: { lat: 13.7244416, lng: 100.3529157 },
        center: startLatLng,
        zoom: 8,
        mapTypeId: google.maps.MapTypeId.ROADMAP
        });



        mapdetail.markers = [];
    // marker = new google.maps.Marker({
    //     position: new google.maps.LatLng(13.736717, 100.523186),
    //     //icon: "http://maps.google.com/mapfiles/kml/paddle/grn-circle.png",
    //     map: mapdetail,
    //     title: "test"
    // });

        <?php
            $sql = "SELECT * FROM `db-farm` WHERE `UFID` = $ufid";
            $myConDB = connectDB();
            $result = $myConDB->prepare($sql);
            $result->execute();
            while ($row = $result->fetch(PDO::FETCH_ASSOC)){
        ?>
            marker = new google.maps.Marker({
            position: new google.maps.LatLng(<?php echo $row["Latitude"] ?> , <?php echo $row["Longitude"] ?>),
            map: mapdetail,
            title:"<?php echo $row["Name"]?>"
            });
            mapdetail.markers.push(marker);

        <?php 
        }
        ?>
    }
</script>