<?php
session_start();
$idUT = $_SESSION[md5('typeid')];
$CurrentMenu = "FertilizerUsageList";
$currentYear = date("Y") + 543;
$backYear = date("Y") + 543 - 1;
?>

<?php
    include_once("../layout/LayoutHeader.php");
    require_once("../../dbConnect.php");
    $name = $_GET['name'];
    $nfarm = $_GET['nfarm'];
    $NumTree = $_GET['NumTree'];
    $AreaRai = $_GET['AreaRai'];
    $AreaNgan = $_GET['AreaNgan'];
    $AreaWa = $_GET['AreaWa'];
    $HarvestVol = $_GET['HarvestVol'];

    $sql1 = "SELECT DISTINCT `dim-time`.`Year2` 
            FROM `log-fertilising`
            INNER JOIN `dim-time` ON `dim-time`.`ID` = `log-fertilising`.`DIMdateID`
            INNER JOIN `dim-farm` ON `dim-farm`.`ID` = `log-fertilising`.`DIMfarmID`
            WHERE `log-fertilising`.`isDelete` = 0  AND `dim-farm`.`Name` = '$nfarm'
            ORDER BY `dim-time`.`Year2` DESC";
    $year = selectData($sql1);
    $FerVal = selectData("SELECT SUM(`log-fertilising`.`Vol`)
        FROM `log-fertilising` 
        WHERE `log-fertilising`.`isDelete` = 0 AND `log-fertilising`.`DIMfarmID` = '$'
        GROUP BY `log-fertilising`.`DIMfarmID` ");
    
    $farmerID = $_GET['farmerID'];
    $farmID = $_GET['farmID'];
    $subfarmID = $_GET['subfarmID'];
    $year = $_GET['year'];
    $LAID = $_GET['LAID'];

    // $farmer = selectData("SELECT * FROM `db-farmer` WHERE `db-farmer`.`UFID` = '$farmerID'");
    // $farm = selectData("SELECT * FROM `db-farm` WHERE `db-farm`.`FMID` = '$farmID'");
    // $logActivity = selectData("SELECT * FROM `log-activity` WHERE `log-activity`.`ID` = '$LAID'");

?>

<style>
    .img_scan {}

    .text-left {
        align: left;
    }

    .text-right {
        align: right;
    }

    .margin-photo {
        margin-top: 25px;
    }

    .set-images {
        width: 100%;
        height: 250px;
    }

    .padding {
        padding-top: 10px;
    }

    .export-button {
        background: white;
        margin-right: 7px;
        margin-bottom: 10px;
    }

    .mar {
        margin-top: 5px;
    }

    font {
        font-family: 'Kanit';
        font-weight: normal;
    }

    span.select2-container {
        box-sizing: border-box;
        display: block;
        margin: 0;
        position: relative;
    }

    .border-from-control {
        border: 3px solid rgba(78, 115, 223, 0.3);
        border-radius: .55rem;
    }

    .select2-container .select2-selection--single .select2-selection__rendered {
        width: 100%;
        color: #6E707E;
        height: calc(1.5em + .75rem + 2px);
        padding: .375rem .75rem;
        font-size: 1rem;
        font-weight: 400;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #d1d3e2;
        border-radius: .35rem;
    }

    span.select2-container .select2-selection--single .select2-selection__rendered {
        padding-left: 15px;
    }

    span.select2-container--default .select2-selection--single {
        display: contents;
        background-color: #fff;
        border: 0px;
        border-radius: 4px;
    }

    span.select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #6E707E;
        line-height: 25px;
    }

    input.gj-textbox-md {
        border: 1px solid #d1d3e2;
        border-radius: .35rem;
        height: calc(1.5em + .75rem + 2px);
        padding: .375rem .9rem;
        color: #6e707e;
        font-family: 'Kanit', sans-serif;
    }

    .gj-datepicker-md [role=right-icon] {
        padding-top: 6.5px;
        padding-right: 6.5px;
    }
</style>

<link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="../../croppie/croppie.css">

<div class="container">
    <!--------------------- Head Link --------------------->
    <div class="row">
        <div class="col-xl-12 col-12 mb-4">
            <div class="card">
                <div class="card-header card-bg">
                    <div class="row">
                        <div class="col-12">
                            <span class="link-active" style="color: #006664;">รายละเอียดการใส่ปุ๋ยสวนปาล์มน้ำมัน</span>
                            <span style="float:right;">
                                <i class="fas fa-bookmark"></i>
                                <a class="link-path" href="#">หน้าแรก</a>
                                <span> > </span>
                                <a class="link-path" href="#">การใส่ปุ๋ย</a>
                                <span> > </span>
                                <a class="link-path link-active" style="color: #006664;" href="#">รายละเอียดการใส่ปุ๋ยสวนปาล์มน้ำมัน</a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--------------------- Head Cards --------------------->
    <div class="row mb-3">
        <div class="col-xl-6 col-12">
            <div class="card">
                <div class="card-body" id="for_card">
                    <div class="row">

                        <!-- <img class="img-radius img-profile" src="../../icon/farm/1/FM1.png"> -->
                        <!-- <img class="img-radius" style="box-shadow: 2px 4px 10px #888888;" width="125px" height="125px" src="../../picture/palm1.jpg" /> -->
                    </div>
                    <div class="row mt-3 justify-content-center">
                        <div class="col-xl-2 col-3 text-right">
                            <span>ชื่อสวน : </span>
                        </div>
                        <div class="">
                            <span></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-12">
            <div class="card">
                <div class="card-body" id="card_height">
                    <div class="row">

                        <!-- <img class="img-radius img-profile" src="../../icon/farmer/1/F1.png"> -->
                        <!-- <img class="img-radius" style="box-shadow: 2px 4px 10px #888888;" width="125px" height="125px" src="../../picture/default.jpg" /> -->
                    </div>
                    <div class="row mt-3 justify-content-center">
                        <div class="col-xl-3 col-3 text-right">
                            <span>เกษตรกร : </span>
                        </div>
                        <div class="">
                            <span></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--------------------- Cards --------------------->
    <div class="row mt-4">
        <div class="col-xl-3 col-12 mb-2">
            <div class="card border-left-primary card-color-one shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="font-weight-bold  text-uppercase mb-1">จำนวนแปลง</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $AreaRai ?> แปลง</div>
                            <br>
                        </div>
                        <div class="col-auto">
                            <i class="material-icons icon-big">waves</i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-12 mb-2">
            <div class="card border-left-primary card-color-two shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="font-weight-bold  text-uppercase mb-1">จำนวนต้น</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $NumTree ?> ต้น</div>
                            <br>
                        </div>
                        <div class="col-auto">
                            <i class="material-icons icon-big">format_size</i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-12 mb-2">
            <div class="card border-left-primary card-color-three shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="font-weight-bold  text-uppercase mb-1">พื้นที่ทั้งหมด</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php echo ($AreaRai . " ไร่ " . $AreaNgan . " งาน" . "<br>" . $AreaWa . " วา") ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="material-icons icon-big">dashboard</i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-12 mb-2">
            <div class="card border-left-primary card-color-one shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="font-weight-bold  text-uppercase mb-1">ผลผลิตปี <?= $backYear ?></div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $HarvestVol ?> (ก.ก.)</div>
                            <br>
                        </div>
                        <div class="col-auto">
                            <i class="material-icons icon-big">filter_vintage</i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- <div class="row mt-4">

        <div class="col-xl-3 col-12 mb-4">
            <div class="card border-left-primary card-color-two shadow h-100 py-2">
                <div class="card-body">
                    <div class="row">
                        <canvas id="FerPie1"></canvas>
                    </div>
                    <div class="row">
                        <span style="margin: auto; color: black;">ปูนขาว</span>
                    </div>
                </div>
            </div>
        </div> 
        <div class="col-xl-3 col-12 mb-4">
            <div class="card border-left-primary card-color-three shadow h-100 py-2">
                <div class="card-body">
                    <div class="row">
                        <canvas id="FerPie2"></canvas>
                    </div>
                    <div class="row">
                        <span style="margin: auto; color: black;">ปุ๋ยสูตร 1</span>
                    </div>
                </div>
            </div>
        </div> 
         <div class="col-xl-3 col-12 mb-4">
            <div class="card border-left-primary card-color-four shadow h-100 py-2">
                <div class="card-body">
                    <div class="row">
                        <canvas id="FerPie3"></canvas>
                    </div>
                    <div class="row">
                        <span style="margin: auto; color: black;">ปุ๋ยสูตร 2</span>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <!-- <div class="row mt-4">
        <div class="col-xl-12 col-12">
            <div class="card">
                <div class="card-header card-bg">
                    <div class="row">
                        <div class="col-10">
                            <h4>โดโลไมท์ </h4>
                        </div>
                        <div class="col-2">
                            <select id="year" class="form-control">
                                <option selected>2562</option>
                                <option>2561</option>
                                <option>2560</option>
                                <option>2559</option>
                                <option>2558</option>
                                <option>2557</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-12 col-12">
                            <div class="row mb-2">
                                <div class="col-xl-6 col-12">
                                    <canvas id="ferVol1" style="height:200px;"></canvas>
                                </div>
                                <div class="col-xl-6 col-12">
                                    <canvas id="FerPie1"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

    <!--------------------- Graps --------------------->
    <div class="row mt-4">
        <div class="col-xl-12 col-12">
            <div class="card">
                <div class="card-header card-bg">
                    <div class="row">
                        <div class="col-10">
                            <h4>ปุ๋ยทั่วไป </h4>
                        </div>
                        <div class="col-2">
                            <select id="year" class="form-control">
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
                    <div class="row">
                        <div class="col-xl-12 col-12">
                            <div class="row mb-2">
                                <div class="col-xl-6 col-12">
                                    <canvas id="ferVol2" style="height:200px;"></canvas>
                                </div>
                                <div class="col-xl-6 col-12">
                                    <canvas id="FerPie2"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--------------------- Table --------------------->
    <div class="row mt-4 mb-4">
        <div class="col-xl-12 col-12">
            <div class="card">
                <div class="card-header card-bg">
                    <div>
                        <span >การใส่ปุ๋ยสวนปาล์มน้ำมันในระบบ</span>
                        <!-- <span style="float:right;">ปี 2562</span> -->
                        <button type="button" id="btn-modal4" style="float:right;" class="btn btn-success" data-toggle="modal" data-target="#modal-4"><i class="fas fa-plus"></i> เพิ่มการใส่ปุ๋ย</button>
                    </div>
                </div>
                <div class="card-body" style="overflow-x:scroll;">
                    <!-- <div class="row mb-2">
                        <div class="col-xl-3 col-12">
                            <button type="button" id="btn_comfirm" class="btn btn-outline-success btn-sm"><i class="fas fa-file-excel"></i> Excel</button>
                            <button type="button" id="btn_comfirm" class="btn btn-outline-danger btn-sm"><i class="fas fa-file-pdf"></i> PDF</button>
                        </div>
                    </div> -->
                    <div class="table-responsive" style="">
                        <table id="example" class="table table-bordered table-striped table-hover table-data" width="100%">
                            <thead style="text-align:center;">
                                <tr>
                                    <th>ชื่อแปลง</th>
                                    <th>วันที่</th>
                                    <th>สูตรปุ๋ย</th>
                                    <th>จำนวน (กก.)</th>
                                    <th>จัดการ</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>ชื่อแปลง</th>
                                    <th>วันที่</th>
                                    <th>สูตรปุ๋ย</th>
                                    <th>จำนวน (กก.)</th>
                                    <th>จัดการ</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <tr>
                                    <td>แปลง1</td>
                                    <td>06/06/2562</td>
                                    <td>โดโลไมท์</td>
                                    <td>20</td>
                                    <td style="text-align:center;">
                                        <button type="button" id='btn_edit' Pid='' class="btn btn-warning btn-sm btn-edit" data-toggle="modal" data-target="#modal-4"><i class="fas fa-edit"></i></button>
                                        <button type="button" id='btn_pic' Pid='' class="btn btn-info btn-sm btn-photo" data-toggle="modal" data-target="#modal-2"><i class="far fa-images"></i></button>
                                        <button type="button" id='btn_delete' Pid='' class="btn btn-danger btn-sm btn-delete"><i class="far fa-trash-alt"></i></button>
                                        <!-- <button type="button" id="btn_pic" class="btn btn-info btn-sm"><i class="fas fa-images"></i></button> -->
                                        <!-- <button type="button" id="btn_delete" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></button> -->
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!---------------------  Modal ADD --------------------->
    <div class="modal fade" id="modal-4" role="dialog">
        <form method="post" enctype="multipart/form-data" id="form">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header header-modal">
                        <h4 class="modal-title">เพิ่มการใส่ปุ๋ย</h4>
                    </div>
                    <div class="modal-body">
                        <div class="main">
                            <div class="row mb-4">
                                <div class="col-xl-3 col-12 text-right">
                                    <span>วันที่</span>
                                    <span class="text-danger"> *</span>
                                </div>
                                <div class="col-xl-8 col-12">
                                    <input class="form-control" width="auto" id="p_date" name="p_date" />
                                </div>
                            </div>
                            <!-- <div class="row mb-4">
                                <div class="col-xl-3 col-12 text-right">
                                    <span>จากสวน</span>
                                </div>
                                <div class="col-xl-9 col-12">
                                    <select class="js-example-basic-single" id="p_farm" name="p_farm">

                                    </select>
                                </div>
                            </div> -->
                            <div class="row mb-4">
                                <div class="col-xl-3 col-12 text-right">
                                    <span>จากแปลง</span>
                                    <span class="text-danger"> *</span>
                                </div>
                                <div class="col-xl-8 col-12">
                                    <select class="js-example-basic-single" id="p_subfarm" name="p_subfarm">

                                    </select>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-xl-3 col-12 text-right">
                                    <span>ชนิดปุ๋ย</span>
                                    <span class="text-danger"> *</span>
                                </div>
                                <div class="col-xl-8 col-12">
                                    <select class="js-example-basic-single" id="p_fertilizer" name="p_fertilizer">

                                    </select>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-xl-3 col-12 text-right">
                                    <span>ปริมาณปุ๋ยที่ใส่ (ก.ก.)</span>
                                    <span class="text-danger"> *</span>
                                </div>
                                <div class="col-xl-8 col-12">
                                    <input placeholder="ปริมาณปุ๋ยที่ใส่" type="text" class="form-control" id="p_vol" name="p_vol" onblur="check_num();" value="">

                                    </input>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-xl-3 col-12 text-right">
                                    <span>จำนวนต้น</span>
                                    <span class="text-danger"> *</span>
                                </div>
                                <div class="col-xl-8 col-12">
                                    <input placeholder="จำนวนต้น" type="text" class="form-control" id="p_tree" name="p_tree" onblur="check_num();" value="">

                                    </input>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-xl-3 col-12 text-right">
                                    <span>รูปภาพ</span>
                                </div>
                                <div class="col-xl-9 col-12">
                                    <div class="grid-img-multiple" id="p_insert_img">

                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="pestAlarmID" id="pestAlarmID" value="0" />
                        </div>
                        <div class="crop-img">
                            <center>
                                <div id="upload-demo" class="center-block"></div>
                            </center>
                        </div>
                        <input type="hidden" id="hidden_id" name="photo" value="insert" />
                        <div class="modal-footer normal-button">
                            <button id="m_success" type="button" class="btn btn-success">ยืนยัน</button>
                            <button id="m_not_success" type="button" class="btn btn-danger" data-dismiss="modal">ยกเลิก</button>
                        </div>
                        <div class="modal-footer crop-button">
                            <button type="button" class="btn btn-success btn-crop">ยืนยัน</button>
                            <button type="button" class="btn btn-danger btn-cancel-crop">ยกเลิก</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!--------------  Modal Button ------------->
    <div class="modal fade" id="modal-2" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header header-modal">
                    <h4 class="modal-title">รูปภาพการใส่ปุ๋ย</h4>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row margin-gal" id="fetchPhoto">

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-3" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header header-modal">
                    <h4 class="modal-title">ข้อมูลสำคัญของศัตรูพืช</h4>
                </div>
                <div class="modal-body" id="noteModalBody">
                    <span id="Note"></span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                </div>
            </div>
        </div>
    </div>




</div>

</div>
<!-- /.container-fluid -->
</div>
<!-- End of Main Content -->
</div>
<!-- End of Content Wrapper -->
</div>
<!-- End of Page Wrapper -->
<?php include_once("./import_Js.php"); ?>

</body>

</html>

<script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBMLhtSzox02ZCq2p9IIuihhMv5WS2isyo&callback=initMap&language=th" async defer></script>
<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="../../croppie/croppie.js"></script>

<script>
    document.getElementById("btn-modal4").addEventListener("load", loadFarm());

    $(document).ready(function() {
        $('.js-example-basic-single').select2();
        $('.js-example-basic-single').on('select2:open', function(e) {
            $(this).next().addClass("border-from-control");
        });
        $('.js-example-basic-single').on('select2:close', function(e) {
            $(this).next().removeClass("border-from-control");
        });

        $('#p_date').datepicker({
            showOtherMonths: true,
            format: 'yyyy-mm-dd'
        });

        $('#e_p_date').datepicker({
            showOtherMonths: true,
            format: 'yyyy-mm-dd'
        });

        $('#example').DataTable({
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
            ]
        });


    });


    // Start Event Select_สวน
    $("#p_farm").on('change', function() {
        $("#p_subfarm").empty();
        let x = document.getElementById("p_farm").value;
        ID_Farm = x;
        loadSubFarm(x, "#p_subfarm");
    });
    // Start Event Select_แปลง
    $("#p_subfarm").on('change', function() {
        let x = document.getElementById("p_subfarm").value;
        ID_SubFarm = x;
    });

    // โหลด Farm
    function loadFarm() {
        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                dataFarm = JSON.parse(this.responseText);
                let text = "<option disabled selected value='-1'>เลือกสวน</option>";
                for (i in dataFarm) {
                    text += ` <option value="${dataFarm[i].FMID}">${dataFarm[i].Name}</option> `
                }
                $("#p_farm").html(text);
            }
        };
        xhttp.open("GET", "./loadFarm.php", true);
        xhttp.send();
    }
    // โหลด SubFarm
    function loadSubFarm(farm, ID) {
        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                dataSubFarm = JSON.parse(this.responseText);
                let text = "<option value='-1' disabled selected>เลือกแปลง</option>";
                for (i in dataSubFarm) {
                    text += ` <option value="${dataSubFarm[i].FSID}">${dataSubFarm[i].Name}</option> `
                }
                $(ID).html(text);
            }
        };
        xhttp.open("GET", "./loadSubFarm.php?farm=" + farm, true);
        xhttp.send();
    }

    // Start Event Create Modal && LoadFarm
    $("#btn-modal4").on('click', function() {
        let current_datetime = new Date()
        let formatted_date = (current_datetime.getFullYear() + "-" + (current_datetime.getMonth() + 1) + "-" + current_datetime.getDate());
        $('#p_date').val(formatted_date);
        loadFarm();
        $('#p_farm').val(-1).trigger('change').html("<option disabled selected>เลือกสวน</option>");
        $('#p_subfarm').html("<option disabled selected>เลือกแปลง</option>");
        $('#p_fertilizer').html("<option disabled selected>เลือกชนิดปุ๋ย</option>");
        $('#p_vol').html("<input>เลือกแปลง</input>");
        //document.getElementById("p_note").value = "";
        $('#p_insert_img').html(`<div class="img-reletive">
                                    <img src="https://ast.kaidee.com/blackpearl/v6.18.0/_next/static/images/gallery-filled-48x48-p30-6477f4477287e770745b82b7f1793745.svg" width="50px" height="50px" alt="">
                                    <input type="file" class="form-control" id="p_photo" name="p_photo[]" accept=".jpg,.png" multiple>
                                </div>`);
        $('#hidden_id').attr('value', "insert");
    });

    //  // Start Edit Botton
    // $(document).on('click', '.btn-edit', function() {
    //     let id = $(this).attr('id');
    //     let text = "";

    //     // $('#setText-edit').html("แก้ไขการใส่ปุ๋ย");

    //     $('#p_date').val(data[id].Date);

    //     for (i in dataFarm)
    //         text += ` <option value="${dataFarm[i].FMID}">${dataFarm[i].Name}</option> `;
    //     $("#p_farm").html(text);
    //     $('#p_farm').val(data[id].FID).trigger('change');

    //     let xhttp = new XMLHttpRequest();
    //     xhttp.onreadystatechange = function() {
    //         if (this.readyState == 4 && this.status == 200) {
    //             dataSubFarm = JSON.parse(this.responseText);
    //             let text = "";
    //             for (i in dataSubFarm)
    //                 text += ` <option value="${dataSubFarm[i].FSID}">${dataSubFarm[i].Name}</option> `
    //             $("#p_subfarm").html(text);
    //             $('#p_subfarm').val(data[id].SFID).trigger('change');
    //         }
    //     };
    //     xhttp.open("GET", "./loadSubFarm.php?farm=" + data[id].FID, true);
    //     xhttp.send();

    //     $('#p_rank').html(`<option value="1">แมลงศัตรูพืช</option>
    //                         <option value="2">โรคพืช</option>
    //                         <option value="3">วัชพืช</option>
    //                         <option value="4">ศัตรูพืชอื่นๆ</option>`);
    //     $('#p_rank').val(data[id].dbpestTID).trigger('change');

    //     loadPest(data[id].dbpestTID, id, "#p_pest", "edit");

    //     document.getElementById("p_note").value = data[id].Note;

    //     loadPhoto_LogPestAlarm2(data[id].PICS, "#p_insert_img");

    //     $('#hidden_id').attr('value', "edit");
    //     $('#pestAlarmID').attr('value', data[id].ID);
    // });

    // Start Submit Create Modal
    $(document).on('click', '#m_success', function() {
        check_num()

        let form = new FormData($('#form')[0]);
        let pic_sc = new Array();
        $('.img_scan').each(function(i, obj) {
            pic_sc.push($(this).attr('src') + 'manu20');
        });
        form.append('pic', pic_sc);

        $.ajax({
            type: "POST",
            data: form,
            url: "insert_edit.php",
            async: false,
            cache: false,
            contentType: false,
            processData: false,
            success: function(result) {
                location.reload();
                // console.log(result);
            }
        });
    });

    /*<! ----------------------------------------------------- Function && Event All Photo ----------------------------------------------------------- !>*/
    let count = 0;
    let idImg;
    $('.crop-img').hide()
    $('.crop-button').hide()
    // Start Insert Photo
    $(document).on('change', '#p_photo', function() {
        img_Preview_Upload(this, '#p_insert_img');
    });

    // Show Preview Photo --> After Insert
    function img_Preview_Upload(input, Target) {
        if (input.files) {
            var filesAmount = input.files.length;
            for (i = 0; i < filesAmount; i++) {
                var reader = new FileReader();
                reader.onload = function(event) {
                    console.log(count + "  *-*-*\n");
                    $(Target).prepend(`<div class="card" width="70px" hight="70px">
                                            <div class="card-body" style="padding:0;">
                                                <img class="img_scan" src = "${event.target.result}" id = "${count++}_CropPhoto" width="100%" hight="100%" />
                                            </div>
                                            <div class="card-footer">
                                                <button type="button" class="btn btn-warning edit-img">แก้ไข</button>
                                                <button type="button" class="btn btn-danger delete-img">ลบ</button>
                                            </div>
                                        </div>`)
                }
                reader.readAsDataURL(input.files[i]);
            }
        }
        $(input).val('');
    }

    // Start Delete Photo
    $(document).on('click', '.delete-img', function() {
        $(this).parent().parent().remove()
    });

    // Start Edit-Crop Photo
    $(document).on('click', '.edit-img', function() {
        let me = $(this).parent().prev().children().attr('src');
        idImg = $(this).parent().prev().children().attr('id');
        //console.log(me + "  " + idImg)
        $('.main').hide();
        $('.normal-button').hide();
        $('.crop-img').show();
        $('.crop-button').show();
        let UC = $('#upload-demo').croppie({
            viewport: {
                width: 200,
                height: 200,
            },
            enforceBoundary: false,
            enableExif: true
        });
        UC.croppie('bind', {
            url: me
        }).then(function() {
            console.log('jQuery bind complete');
        });
    });

    // Start Submit Crop Photo
    $(document).on('click', '.btn-crop', function(ev) {
        $('#upload-demo').croppie('result', {
                type: 'canvas',
                size: 'viewport'
            })
            .then(function(r) {
                $('.main').show()
                $('.normal-button').show()
                $('.crop-img').hide()
                $('.crop-button').hide()
                $("#" + idImg).attr('src', r);
                console.log(idImg + " *-*");
            });
        $('#upload-demo').croppie('destroy');
    });

    // Start Cancel Crop Photo
    $(document).on('click', '.btn-cancel-crop', function(ev) {
        $('.main').show();
        $('.normal-button').show();
        $('.crop-img').hide();
        $('.crop-button').hide();
        $('#upload-demo').croppie('destroy');
    });
    /*<! ----------------------------------------------------- Function && Event All Photo ----------------------------------------------------------- !>*/


    pdfMake.fonts = {
        THSarabun: {
            normal: 'THSarabun.ttf',
            bold: 'THSarabun-Bold.ttf',
            italics: 'THSarabun-Italic.ttf',
            bolditalics: 'THSarabun-BoldItalic.ttf'
        }
    }

    $("#card_height").css('height', $("#for_card").css('height'));
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

    //pie chart
    var speedData = {
        labels: ["ปริมาณที่ใส่แล้ว", "ปริมาณที่ควรใส่เพิ่ม"],
        datasets: [{
            label: "Demo Data 1",
            data: [0, 0],
            backgroundColor: ["#00ce68", "#F32C24"]
        }]
    };

    var ctx = $("#FerPie1");
    var plantPie = new Chart(ctx, {
        type: 'pie',
        data: speedData,
        options: chartOptions
    });

    // var speedData = {
    // labels: ["ปริมาณที่ใส่", "ปริมาณที่ควรใส่"],
    // datasets: [{
    //     label: "Demo Data 1",
    //     data: [30,70],
    //     backgroundColor: ["#00ce68", "#f6c23e"]
    // }]
    // };

    var ctx = $("#FerPie2");
    var plantPie = new Chart(ctx, {
        type: 'pie',
        data: speedData,
        options: chartOptions
    });

    // var speedData = {
    // labels: ["ปริมาณที่ใส่", "ปริมาณที่ควรใส่"],
    // datasets: [{
    //     label: "Demo Data 1",
    //     data: [80,20],
    //     backgroundColor: ["#00ce68", "#f6c23e"]
    // }]
    // };

    var ctx = $("#FerPie3");
    var plantPie = new Chart(ctx, {
        type: 'pie',
        data: speedData,
        options: chartOptions
    });

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
        tooltips: {
            mode: 'index',
            intersect: false
        },
        scales: {
            yAxes: [{
                scaleLabel: {
                    display: true,
                    labelString: 'ปริมาณปุ๋ยที่ใส่ (ก.ก.)'
                },
                gridLines: {
                    display: true
                },
                stacked: true
            }],
            xAxes: [{
                scaleLabel: {
                    display: true,
                    labelString: 'รายปี'
                },
                gridLines: {
                    display: false
                },
                stacked: true
            }],
        }
    };

    //graps 
    var speedData1 = {
        labels: ["2560", "2561", "2562"],
        datasets: [{
                // label: "ใส่แล้ว",
                // data: [300, 70, 50],
                // backgroundColor: '#00ce68'
            },
            {
                // label: "ควรใส่",
                // data: [50, 40, 30],
                // backgroundColor: '#F32C24'
            },
        ]
    };

    var ctx = $("#ferVol1");
    var plantPie = new Chart(ctx, {
        type: 'bar',
        data: speedData1,
        options: chartOptions
    });

    var speedData2 = {
        labels: ["2560", "2561", "2562"],
        datasets: [{
            label: "Demo Data 1",
            data: [100, 50, 60],
            backgroundColor: '#00ce68'
        }]
    };

    var ctx = $("#ferVol2");
    var plantPie = new Chart(ctx, {
        type: 'bar',
        data: speedData1,
        options: chartOptions
    });

    var speedData3 = {
        labels: ["2560", "2561", "2562"],
        datasets: [{
            label: "Demo Data 1",
            data: [100, 50, 70],
            backgroundColor: '#00ce68'
        }]
    };

    $('#btn_pic').click(function() {
        $('body').append(imageModal)
        console.log('xxx')
        $('#imageModal').modal('show')
    })

    // Start Delete Botton
    $(document).on('click', '.btn-delete', function() {
        let id = $(this).attr('id');
        let pid = $(this).attr('Pid');
        swal({
                title: "ยืนยันการลบข้อมูล",
                // text: `Id_diary : ${id} ?`,
                icon: "warning",
                buttons: {
                    confirm: "ยืนยัน",
                    cancel: "ยกเลิก"
                },
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    swal("ดำเนินการลบสำเร็จ !!", {
                        icon: "success",
                    }).then((willDelete) => {
                        let xhttp = new XMLHttpRequest();
                        xhttp.onreadystatechange = function() {
                            if (this.readyState == 4 && this.status == 200) {
                                let count = 0;
                                data.splice(id, 1);
                                let text = "";
                                for (i in data) {
                                    text += `<tr>
                                                <td class="text-left">${data[i].Name}</td>
                                                <td class="text-left">${data[i].FName}</td>
                                                <td class="text-left">${data[i].subFName}</td>
                                                <td class="text-right">${data[i].SumArea}</td>
                                                <td class="text-right">${data[i].SumNumTree}</td>
                                                <td style="text-align:center;">${data[i].TypeTH}</td>
                                                <td class="text-right">${data[i].Date}</td>
                                                <td style="text-align:center;">
                                                    <button type="button" id='${i}' Pid='${data[i].ID}' class="btn btn-warning btn-sm btn-edit" data-toggle="modal" data-target="#modal-4"><i class="fas fa-edit"></i></button>
                                                    <button type="button" id='${i}' Pid='${data[i].ID}' class="btn btn-success btn-sm btn-Pest" data-toggle="modal" data-target="#modal-1"><i class="fas fa-bars"></i></button>
                                                    <button type="button" id='${i}' Pid='${data[i].ID}' class="btn btn-info btn-sm btn-photo" data-toggle="modal" data-target="#modal-2"><i class="far fa-images"></i></button>
                                                    <button type="button" id='${i}' Pid='${data[i].ID}' class="btn btn-primary btn-sm btn-note" data-toggle="modal" data-target="#modal-3"><i class="far fa-sticky-note"></i></button>
                                                    <button type="button" id='${i}' Pid='${data[i].ID}' class="btn btn-danger btn-sm btn-delete"><i class="far fa-trash-alt"></i></button>
                                                </td>
                                            </tr>`;
                                    count++;
                                }
                                $("#fetchDataTable").html(text);
                                document.getElementById("cardPestAlarm").textContent = count + " ครั้ง";
                            }
                        };
                        xhttp.open("POST", "./deletePest.php", true);
                        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                        xhttp.send(`ID=${pid}`);
                    });
                }
                // else {
                //     swal("ยกเลิกการดำเนินการลบ !!");
                // }
            });
    });

    // ---- delete ---- 



    //ing


    //ing
</script>