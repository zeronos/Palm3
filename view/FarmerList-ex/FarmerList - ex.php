<?php
session_start();

$idUT = $_SESSION[md5('typeid')];
$CurrentMenu = "FarmerList";
?>


<?php include_once("../layout/LayoutHeader.php"); ?>

<body>
    <?php include_once("../../connect_db.php"); ?>
    <div class="container">
        <div class="row mb-4">
            <div class="col-xl-12 col-12">
                <div class="card">
                    <div class="card-header card-bg">
                        <div class="row">
                            <div class="col-12">
                                <span class="link-active" style="color:<?=$color?>;" >รายชื่อเกษตรกร</span>
                                <span style="float:right;">
                                    <i class="fas fa-bookmark"></i>
                                    <a class="link-path" href="#">หน้าแรก</a>
                                    <span> > </span>
                                    <a class="link-path link-active" href="#" style="color:<?=$color?>;" >รายชื่อเกษตรกร</a>
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
                                <div class="font-weight-bold  text-uppercase mb-1">เกษตรกร (มีสวน)</div>
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

        <div class="row">
            <div class="col-xl-12 col-12 mb-2">
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
                <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                    <div class="card-body" style="background-color: white; ">
                        <div class="row mb-4 ">
                            <div class="col-xl-4 col-12 text-right">
                                <span>หมายเลขบัตรประชาชน</span>
                            </div>
                            <div class="col-xl-6 col-12">
                                <input type="password" class="form-control input-setting" id="idcard">
                                <i class="far fa-eye-slash eye-setting"></i>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-xl-4 col-12 text-right">
                                <span>ชื่อเกษตรกร</span>
                            </div>
                            <div class="col-xl-6 col-12">
                                <input type="text" class="form-control" id="username">
                            </div>
                        </div>
                        
                        <div class="row mb-4">
                            <div class="col-xl-4 col-12 text-right">
                                <span>จังหวัด</span>
                            </div>
                            <div class="col-xl-6 col-12">
                                <select id="province" class="form-control">
                                    <option selected>เลือกจังหวัด</option>
                                    <?php
                                    $sql = "SELECT * FROM `db-province` ";
                                    $result = $conn->query($sql);
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            ?>
                                            <option> <?php echo $row["Province"]; ?> </option>
                                    <?php
                                        }
                                    } else {
                                        echo "0 row";
                                    }
                                    //$conn->close();
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-xl-4 col-12 text-right">
                                <span>อำเภอ</span>
                            </div>
                            <div class="col-xl-6 col-12">
                                <select id="amp" class="form-control">
                                    <option selected>เลือกอำเภอ</option>
                                    <?php
                                    $sql = "SELECT * FROM `db-distrinct` ";
                                    $result = $conn->query($sql);
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            ?>
                                            <option> <?php echo $row["Distrinct"]; ?> </option>
                                    <?php
                                        }
                                    } else {
                                        echo "0 row";
                                    }
                                    //$conn->close();
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-4 col-12 text-right">
                            </div>
                            <div class="col-xl-6 col-12">
                                <button type="button" id="btn_pass" class="btn btn-success btn-sm form-control">ค้นหา</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-xl-12 col-12">
                <div class="card">
                    <div class="card-header card-bg" >
                        <span style="color:#006633;">รายชื่อเกษตรกรในระบบ (มีสวน)</span>
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
                                $sql = "SELECT `UFID`,`FirstName`,`LastName`,`Distrinct`,`Province` FROM `db-farmer` 
                                        JOIN `db-subdistrinct` ON `db-subdistrinct`.`AD3ID` = `db-farmer`.`AD3ID` 
                                        JOIN `db-distrinct` ON `db-distrinct`.`AD2ID` = `db-subdistrinct`.`AD2ID`
                                        JOIN `db-province` ON `db-province`.`AD1ID` = `db-distrinct`.`AD1ID` ";
                                $myConDB = connectDB();
                                $result = $myConDB->prepare($sql);
                                $result->execute();
                                //COUNT FARM
                                $sql1 = "SELECT UFID, COUNT(CASE WHEN `UFID` IN (`UFID`) THEN 1 END) f FROM `db-farm` GROUP BY `UFID`";
                                $myConDB = connectDB();
                                $result1 = $myConDB->prepare($sql1);
                                $result1->execute();
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
                                while ($row = $result->fetch(PDO::FETCH_ASSOC)){
                                ?>
                                    <tr>
                                        <td><?php echo $row["FirstName"] . " " . $row["LastName"]; ?></td>
                                        <td><?php echo $row["Province"] ?></td>
                                        <td><?php echo $row["Distrinct"] ?></td>
                                        <?php $row1 = $result1->fetch(PDO::FETCH_ASSOC) ?>
                                        <td class = "text-right"><?php if($row1["f"] != NULL) echo $row1["f"]; else echo "0" ?> สวน</td>
                                        <?php $row2 = $result2->fetch(PDO::FETCH_ASSOC) ?>
                                        <td class = "text-right"><?php if($row2["sf"] != NULL) echo $row2["sf"]; else echo "0" ;?> แปลง</td>
                                        <?php $row4 = $result4->fetch(PDO::FETCH_ASSOC) ?>
                                        <td class = "text-right"><?php if($row4["A"] != NULL) echo $row4["A"]; else echo "0" ?> ไร่</td>
                                        <?php $row3 = $result3->fetch(PDO::FETCH_ASSOC) ?>
                                        <td class = "text-right"><?php if($row3['sumTree'] != NULL) echo $row3['sumTree']; else echo "0" ?> ต้น</td>
                                        <td style="text-align:center;">
                                            <form method="post" id="ID" name = "formID" action="FarmerListDetail.php">
                                                <input type="text" hidden class="form-control" name="farmerID" id="farmerID" value="<?php echo $row["UFID"];?>">
                                                <button type="submit"  id="btn_info" class="btn btn-info btn-sm"><i class="fas fa-bars"></i></button></a>
                                            </form>
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
    </div>

    <?php include_once("../layout/LayoutFooter.php"); ?>


    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBMLhtSzox02ZCq2p9IIuihhMv5WS2isyo&callback=initMap&language=th" async defer></script>
    <!-- <script src="../Water/DataTable_Js/jquery-3.3.1.js"></script>
  <script src="../Water/DataTable_Js/jquery.dataTables.min.js"></script>
  <script src="../Water/DataTable_Js/dataTables.bootstrap4.min.js"></script>
  <script src="../Water/DataTable_Js/dataTables.buttons.min.js"></script>
  <script src="../Water/DataTable_Js/buttons.bootstrap4.min.js"></script>
  <script src="../Water/DataTable_Js/jszip.min.js"></script>
  <script src="../Water/DataTable_Js/pdfmake.min.js"></script>
  <script src="../Water/DataTable_Js/vfs_fonts.js"></script>
  <script src="../Water/DataTable_Js/buttons.html5.min.js"></script>
    <script>
    $(document).ready(function() {

        $('#table').DataTable({
            dom: '<"row"<"col-sm-6"B>>' +
                '<"row"<"col-sm-6 mar"l><"col-sm-6 mar"f>>' +
                '<"row"<"col-sm-12"tr>>' +
                '<"row"<"col-sm-5"i><"col-sm-7"p>>',
            buttons: [{
                    extend: 'excel',
                    text: '<i class="fas fa-file-excel"> <font> Excel</font> </i>',
                    className: 'btn btn-outline-success btn-sm export-button'
                },
                {
                    extend: 'pdf',
                    text: '<i class="fas fa-file-pdf"> <font> PDF</font> </i>',
                    className: 'btn btn-outline-danger btn-sm export-button',
                    pageSize: 'A4',
                    customize: function(doc) {
                        doc.defaultStyle = {
                            font: 'THSarabun',
                            fontSize: 16
                        };
                    }
                }
            ],
            language: {
                emptyTable: "ไม่พบข้อมูลที่ต้องการค้นหา !!"
            }
        });
    });
    </script> -->



