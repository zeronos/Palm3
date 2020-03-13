<?php
session_start();

$idUT = $_SESSION[md5('typeid')];
$idUTLOG = $_SESSION[md5('LOG_LOGIN')];
$CurrentMenu = "OilPalmAreaVol";
$currentYear = date("Y") + 543;
$backYear = date("Y") + 543 - 1;

include_once("../layout/LayoutHeader.php"); 
include_once("../../dbConnect.php"); 
include_once("import_Js.php");

?>

<body>
    
    <div class="container">
        <div class="row">
            <div class="col-xl-12 col-12 mb-4">
                <div class="card">
                    <div class="card-header card-bg">
                        <div class="row">
                            <div class="col-12">
                                <span class="link-active font-weight-bold" style="color:<?=$color?>;">ผลผลิตสวนปาล์มน้ำมัน</span>
                                <span style="float:right;">
                                    <i class="fas fa-bookmark"></i>
                                    <a class="link-path" href="#">หน้าแรก</a>
                                    <span> > </span>
                                    <a class="link-path link-active" href="#" style="color:#006633;">ผลผลิตสวนปาล์มน้ำมัน</a>
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
                                <div class="font-weight-bold  text-uppercase mb-1">ผลผลิตปี <?php echo $currentYear ?></div>
                                <?php 
                                    $sql = "SELECT * FROM `log-harvest` WHERE `isDelete` =0";
                                    $myConDB = connectDB();
                                    $result = $myConDB->prepare( $sql ); 
                                    $result->execute(); 
                                    $weightCard = 0;
                                    while ($row = $result->fetch(PDO::FETCH_ASSOC)){
                                        if((int)date('Y',$row["Modify"]) + 543==(int)$currentYear)
                                            $weightCard = $weightCard + $row['Weight'];
                                    }
                                ?>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo number_format($weightCard, 0, '.', ','); ?> ก.ก.</div>
                                
                            </div>
                            <div class="col-auto">
                                <i class="material-icons icon-big">filter_vintage</i>
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
                                <div class="font-weight-bold  text-uppercase mb-1">ผลผลิตปี <?php echo $backYear ?></div>
                                <?php
                                    $sql = "SELECT * FROM `log-harvest` WHERE `isDelete` =0";
                                    $myConDB = connectDB();
                                    $result = $myConDB->prepare( $sql ); 
                                    $result->execute(); 
                                    $weightCardBY = 0;
                                    while ($row = $result->fetch(PDO::FETCH_ASSOC)){
                                        if((int)date('Y',$row["Modify"]) + 543==(int)$backYear)
                                            $weightCardBY = $weightCardBY + $row['Weight'];
                                    } 
                                ?>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo number_format($weightCardBY, 0, '.', ',');?> ก.ก.</div>
                            </div>
                            <div class="col-auto">
                                <i class="material-icons icon-big">filter_vintage</i>
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
                                <div class="font-weight-bold  text-uppercase mb-1">พื้นที่ทั้งหมด</div>
                                <?php
                                    $sql = "SELECT `log-farm`.`DIMfarmID` , `db-subfarm`.`AreaRai`, `db-subfarm`.`AreaNgan` FROM `log-farm`
                                    JOIN `dim-farm` ON `log-farm`.`DIMsubfID` = `dim-farm`.`ID`
                                    JOIN `db-subfarm` ON `dim-farm`.`dbID` = `db-subfarm`.`FSID`
                                    WHERE `dim-farm`.`isFarm` = 0 
                                    ";
                                $myConDB = connectDB();
                                $result = $myConDB->prepare( $sql ); 
                                $result->execute();
                                $areaCard = 0;
                                while ($row = $result->fetch(PDO::FETCH_ASSOC)){ 
                                    $areaCard= $areaCard + $row['AreaRai'];
                                
                                }
                                ?>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $areaCard; ?> ไร่</div>
                            </div>
                            <div class="col-auto">
                                <i class="material-icons icon-big">dashboard</i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-12 mb-4">
                <div class="card border-left-primary card-color-four shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="font-weight-bold  text-uppercase mb-1">จำนวนต้นไม้</div>
                                <?php
                                     $sql = "SELECT * FROM `log-planting` WHERE  `isDelete`= 0";
                                     $myConDB = connectDB();
                                     $result = $myConDB->prepare( $sql ); 
                                     $result->execute(); 
                                     $numTreeCard = 0;
                                     while ($row = $result->fetch(PDO::FETCH_ASSOC)){
                                             $numTreeCard = $numTreeCard + $row['NumGrowth1'] + $row['NumGrowth2'] - $row['NumDead'];
                                     }
                                ?>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $numTreeCard; ?> ต้น</div>
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
        <div class="col-xl-12 col-12">
            <div id="accordion">
                <div class="card">
                    <div class="card-header collapsed" id="headingOne" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne" style="cursor:pointer; background-color: #006664; color: white;">
                        <div class="row">
                            <div class="col-3">
                                <i class="fas fa-search"> ค้นหาขั้นสูง</i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="collapseOne" class="card collapse" aria-labelledby="headingOne" data-parent="#accordion">
                <div class="card-header card-bg">
                    ตำแหน่งสวนปาล์มน้ำมัน
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-6 col-12">
                            <div id="map" style="width:auto;height:60vh;"></div>
                        </div>
                        <div class="col-xl-6 col-12">
                            <div class="row">
                                <div class="col-12">
                                    <span>จังหวัด</span>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-12">
                                    <select id="province" class="js-example-basic-single form-control">
                                        <option disabled selected value="0">เลือกจังหวัด</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row  mb-2">
                                <div class="col-12">
                                    <span>อำเภอ</span>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-12">
                                    <select id="amp" class="js-example-basic-single form-control">
                                        <option disabled selected value="0">เลือกอำเภอ</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-11">

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-11">
                                    <span>ชื่อเกษตรกร</span>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-12">
                                    <input type="text" class="form-control" id="name">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-11">
                                    <span>หมายเลขบัตรประชาชน</span>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-12">
                                    <input type="password" class="form-control input-setting" id="FormalID">
                                    <i class="fa fa-eye-slash eye-setting" id="hide1"></i>
                                </div>
                            </div>
                            <div class="row mb-2 padding">
                                <div class="col-12">
                                    <button type="button" id="btn_search" class="btn btn-success btn-sm form-control">ค้นหา</button>
                                </div>
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
                    <div class="card-header card-bg">
                        <div>
                            <span>ผลผลิตสวนปาล์มน้ำมันในระบบ</span>
                            <span style="float:right;">ปี <?php echo $currentYear; ?></span>
                        </div>
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
                                        <th>ชื่อเกษตรกร</th>
                                        <th>ชื่อสวน</th>
                                        <th>จำนวนแปลง</th>
                                        <th>พื้นที่ปลูก</th>
                                        <th>จำนวนต้น</th>
                                        <th>ผลผลิต</th>
                                        <th>จัดการ</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>ชื่อเกษตรกร</th>
                                        <th>ชื่อสวน</th>
                                        <th>จำนวนแปลง</th>
                                        <th>พื้นที่ปลูก</th>
                                        <th>จำนวนต้น</th>
                                        <th>ผลผลิต</th>
                                        <th>จัดการ</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                <?php
                                         // ID ของ farm
                                        $sql = "SELECT `dim-farm`.`dbID` FROM `dim-farm` WHERE `isFarm` = 1 
                                         ";
                                        $myConDB = connectDB();
                                        $result = $myConDB->prepare( $sql ); 
                                        $result->execute();
                                        $num = 0;    
                                        $A1 = array();    
                                        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                            $A1[$num] = $row['dbID'];
                                            $num += 1;
                                        }
                                        $A = array_unique($A1);
                                        rsort($A);
                                        $x = count($A);
                                        for($i=0;$i<$x;$i++){
                                            $subFarm["$A[$i]"]=0;
                                            $area["$A[$i]"]=0;
                                            $numTree["$A[$i]"]=0;
                                            $weight["$A[$i]"]=0;
                                            $uname["$A[$i]"]="";
                                            $fname["$A[$i]"]="";
                                            $unameID["$A[$i]"]=0;
                                        }
                                        //

                                        
                                        for($i=0;$i<$x;$i++){
                                            $FMID = $A[$i];

                                        // จำนวนแปลง
                                            $sql = "SELECT count(`FMID`) as count FROM `db-subfarm` 
                                                    WHERE  `db-subfarm`.`FMID` = $FMID
                                                    ";
                                            $myConDB = connectDB();
                                            $result = $myConDB->prepare( $sql ); 
                                            $result->execute(); 
                                            while ($row = $result->fetch(PDO::FETCH_ASSOC)){
                                                    $subFarm["$FMID"] = $row['count'];
                                            }      

                                        //

                                        // จำนวนไร่
                                            $sql = "SELECT * FROM `db-subfarm` 
                                                    WHERE `db-subfarm`.`FMID` = $FMID 
                                                    ";
                                            $myConDB = connectDB();
                                            $result = $myConDB->prepare( $sql ); 
                                            $result->execute(); 
                                            while ($row = $result->fetch(PDO::FETCH_ASSOC)){ 
                                                $area["$FMID"] = $area["$FMID"] + $row['AreaRai'];
                                            }
                                        
                                        //

                                        // จำนวนต้นไม้
                                        $sql = "SELECT * FROM `log-planting` 
                                                JOIN `dim-farm` ON `log-planting`.`DIMfarmID` = `dim-farm`.`dbID`
                                                WHERE `isDelete`= 0 AND `dim-farm`.`isFarm` = 1  AND `dim-farm`.`dbID` = $FMID  
                                                ";
                                        $myConDB = connectDB();
                                        $result = $myConDB->prepare( $sql ); 
                                        $result->execute(); 
                                        
                                        while ($row = $result->fetch(PDO::FETCH_ASSOC)){
                                                $numTree["$FMID"] = $numTree["$FMID"] + $row['NumGrowth1'] + $row['NumGrowth2'] -$row['NumDead'];
                                        }
                                        //

                                        // น้ำหนักรวม
                                        $sql = "SELECT * FROM `log-harvest`
                                                JOIN `dim-farm` ON `log-harvest`.`DIMfarmID` = `dim-farm`.`dbID`
                                                WHERE `isDelete`= 0 AND `dim-farm`.`isFarm` = 1  AND `dim-farm`.`dbID` = $FMID  
                                                ";
                                        $myConDB = connectDB();
                                        $result = $myConDB->prepare( $sql ); 
                                        $result->execute(); 
                                        while ($row = $result->fetch(PDO::FETCH_ASSOC)){
                                            if((int)date('Y',$row["Modify"]) + 543==$currentYear)
                                                $weight["$FMID"] = $weight["$FMID"] + $row['Weight'];
                                        }
                                        //

                                        // ชื่อคน
                                             $sql = "SELECT `dim-user`.`Alias` , `db-farmer`.`UFID` FROM `db-farm` 
                                                    JOIN `db-farmer` ON `db-farm`.`UFID` = `db-farmer`.`UFID` 
                                                    JOIN `dim-user` ON `db-farmer`.`UFID` = `dim-user`.`dbID`
                                                    WHERE `dim-user`.`Type` = 'F' AND `db-farm`.`FMID` = $FMID
                                                    ";
                                            $myConDB = connectDB();
                                            $result = $myConDB->prepare( $sql ); 
                                            $result->execute();
                                            while ($row = $result->fetch(PDO::FETCH_ASSOC)){
                                                $uname["$FMID"] = $row['Alias'];
                                                $unameID["$FMID"] = $row['UFID'];
                                            }
                                        //

                                        // ชื่อฟาร์ม
                                            $sql = "SELECT * FROM  `dim-farm` WHERE `isFarm`= 1 AND `dbID` = $FMID" ;
                                            $myConDB = connectDB();
                                            $result = $myConDB->prepare($sql); 
                                            $result->execute();
                                            while ($row = $result->fetch(PDO::FETCH_ASSOC)){
                                                $fname["$FMID"] = $row["Alias"];
                                            }
                                        //

                                        }

                                        //แสดงค่าในตาราง
                                            for($i=0;$i<$x;$i++){
                                                $farmID = $A[$i];
                                                $userID = $unameID["$A[$i]"];
                                                ?>
                                            <tr>
                                                <td><?php echo $uname["$farmID"]; ?></td>
                                                <td><?php echo $fname["$farmID"];?></td>
                                                <td style="text-align:right;"><?php echo $subFarm["$farmID"]; ?> แปลง</td>
                                                <td style="text-align:right;"><?php echo $area["$farmID"]; ?> ไร่</td>
                                                <td style="text-align:right;"><?php echo $numTree["$farmID"]; ?> ต้น</td>
                                                <td style="text-align:right;"><?php echo $weight["$farmID"];?> ก.ก.</td>
                                                <td style="text-align:center;">
                                                <form method="post" id="ID" name = "formID" action="OilPalmAreaVolDetail.php">
                                                    <input type="text" hidden class="form-control" name="farmID" id="farmID" value="<?php echo "$farmID"?>">
                                                    <input type="text" hidden class="form-control" name="userID" id="userID" value="<?php echo "$userID"?>">
                                                    <button type="submit"  id="btn_info" class="btn btn-info btn-sm" data-toggle="tooltip" title="รายละเอียด"><i class="fas fa-bars"></i></button></a>
                                                </form>
                                                </td>
                                            </tr>       
                                        <?php
                                            }
                                        
                                        ?>
                                    <!-- <tr>
                                    <td>บรรยาวัชร</td>
                                    <td>ไลอ้อน</td>
                                    <td>50</td>
                                    <td>210</td>
                                    <td>50</td>
                                    <td>150</td>
                                    <td>19/05/1996</td>
                                    <td style="text-align:center;">
                                        <button type="button" id="btn_info" class="btn btn-info btn-sm"><i class="fas fa-bars"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>บรรยาวัชร</td>
                                    <td>ไลอ้อน</td>
                                    <td>50</td>
                                    <td>210</td>
                                    <td>50</td>
                                    <td>150</td>
                                    <td>19/05/1996</td>
                                    <td style="text-align:center;">
                                        <button type="button" id="btn_info" class="btn btn-info btn-sm"><i class="fas fa-bars"></i></button>
                                    </td>
                                </tr> -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include_once("../layout/LayoutFooter.php"); ?>


    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDwVxLnsuNM9mJUqDFkj6r7FSxVcQCh4ic&callback=map_create" async defer></script>
    <script src="OilPalmAreaVol.js"></script>
    <script src="OilPalmAreaVolModal.js"></script>

    <script>
        $("#map_area").css('height', $("#forMap").css('height'));
        // $("#card_add").click(function () {
        //     $("body").append(addModal);
        //     $("#addModal").modal('show');
        // });

        // $("#btn_info").click(function () {
        //     console.log("testefe");
        // });

        $("#btn_delete").click(function() {
            swal({
                title: "ยืนยันการลบข้อมูล",
                icon: "warning",
                buttons: ["ยกเลิก", "ยืนยัน"],
            });
        });

    </script>