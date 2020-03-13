<?php
session_start();
$idUT = $_SESSION[md5('typeid')];
$CurrentMenu = "Pest";
// $idUTLOG = $_SESSION[md5('LOG_LOGIN')];
?>

<?php include_once("../layout/LayoutHeader.php");
require_once("../../dbConnect.php");
$totalFarm = selectDataOne("SELECT COUNT(`db-farm`.`FMID`) AS totalFarm FROM `db-farm` ");
$totalSubFarm = selectDataOne("SELECT COUNT(`db-subfarm`.`FSID`) AS totalSubFarm FROM `db-subfarm` ");
$totalAreaRai = selectDataOne("SELECT SUM(`db-subfarm`.`AreaRai`) AS totalAreaRai FROM `db-subfarm` ");
$totalPalm = selectDataOne("SELECT (SUM(`log-planting`.`NumGrowth1`)+SUM(`log-planting`.`NumGrowth2`))-SUM(`log-planting`.`NumDead`) AS totalPalm FROM `log-planting` WHERE `log-planting`.`isDelete` = 0");
$totalPestAlarm = selectDataOne("SELECT COUNT(lp.isDelete) AS totalPestAlarm FROM `log-pestalarm` AS lp WHERE lp.isDelete = 0");
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

<div class="container">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="../../croppie/croppie.css">

    <!------------ Start Head ------------>
    <div class="row">
        <div class="col-xl-12 col-12 mb-4">
            <div class="card">
                <div class="card-header card-bg">
                    <div class="row">
                        <div class="col-12">
                            <span class="link-active" style="color:<?= $color ?>;">ศัตรูพืช</span>
                            <span style="float:right;">
                                <i class="fas fa-bookmark"></i>
                                <a class="link-path" href="">หน้าแรก</a>
                                <span> > </span>
                                <a class="link-path link-active" href="" style="color:<?= $color ?>;"> ศัตรูพืช</a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!------------ Start Card ------------>
    <div class="row">
        <div class="col-xl-3 col-12 mb-4">
            <div class="card border-left-primary card-color-one shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="font-weight-bold  text-uppercase mb-1">จำนวนครั้งพบศัตรูพืช</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><span id="cardPestAlarm"><?php echo number_format($totalPestAlarm['totalPestAlarm']) . " ครั้ง" ?></span></div>
                        </div>
                        <div class="col-auto">
                            <i class="material-icons icon-big">panorama_vertical</i>
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
                            <div class="font-weight-bold  text-uppercase mb-1">จำนวนสวน/แปลง</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $totalFarm['totalFarm'] . " สวน / " . $totalSubFarm['totalSubFarm'] . " แปลง"; ?></div>
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
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo number_format($totalAreaRai['totalAreaRai']); ?> ไร่</div>
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
                            <div class="font-weight-bold  text-uppercase mb-1">จำนวนต้นไม้ทั้งหทด</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo number_format($totalPalm['totalPalm']); ?> ต้น</div>
                        </div>
                        <div class="col-auto">
                            <i class="material-icons icon-big">format_size</i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!------------ Start Serch ------------>
    <div class="row">
        <div class="col-xl-12 col-12">
            <div id="accordion">
                <div class="card">
                    <div class="card-header collapsed" id="headingOne" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne" style="cursor:pointer; background-color: <?= $color ?>; color: white;">
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
                    ตำแหน่งศัตรูพืชสวนปาล์มน้ำมัน
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-6 col-12">
                            <div id="map" style="width:auto; height:75vh;"></div>
                        </div>

                        <div class="col-xl-6 col-12">

                            <div class="row">
                                <div class="col-12">
                                    <span>ปี</span>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-12">
                                    <select id="year" class="form-control">
                                        <?php
                                        $yearCurrent = date('Y') + 543;
                                        echo "<option value='$yearCurrent' selected>$yearCurrent</option>";
                                        for ($i = 0, $yearCurrent--; $i < 2; $i++, $yearCurrent--)
                                            echo "<option value='$yearCurrent'>$yearCurrent</option>";
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <span>ชนิด</span>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-12">
                                    <select id="pest" class="js-example-basic-single">
                                        <option disabled selected value='null'>เลือกชนิดศัตรูพืช</option>
                                        <option value="1">แมลงศัตรูพืช</option>
                                        <option value="2">โรคพืช</option>
                                        <option value="3">วัชพืช</option>
                                        <option value="4">ศัตรูพืชอื่นๆ</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <span>จังหวัด</span>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-12">
                                    <select id="province" class="js-example-basic-single">
                                        <option disabled selected value="null">เลือกจังหวัด</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <span>อำเภอ</span>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-12">
                                    <select id="amp" class="js-example-basic-single">
                                        <option disabled selected value="null">เลือกอำเภอ</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <span>ชื่อเกษตรกร</span>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-12">
                                    <input type="text" class="form-control" id="name">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <span>หมายเลขบัตรประชาชน</span>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-12">
                                    <input type="password" class="form-control input-setting" id="idcard">
                                    <i class="far fa-eye-slash eye-setting"></i>
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

    <!------------ Start Table ------------>
    <div class="row mt-4">
        <div class="col-xl-12 col-12">
            <div class="card">
                <div class="card-header card-bg">
                    <div>
                        <span>ศัตรูพืชสวนปาล์มน้ำมันในระบบ</span>
                        <span style="float:right;">ปี <?php echo date('Y') + 543; ?></span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <button type="button" id="btn-modal4" style="float:right;" class="btn btn-success" data-toggle="modal" data-target="#modal-4"><i class="fas fa-plus"></i>เพิ่มการตรวจพบศัตรูพืช</button>
                        <table id="example" class="table table-bordered table-striped table-hover table-data">
                            <thead>
                                <tr>
                                    <th>ชื่อเกษตรกร</th>
                                    <th>ชื่อสวน</th>
                                    <th>ชื่อแปลง</th>
                                    <th>พื้นที่ปลูก</th>
                                    <th>จำนวนต้น</th>
                                    <th>ชนิด</th>
                                    <th>วันที่พบ</th>
                                    <th>จัดการ</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>ชื่อเกษตรกร</th>
                                    <th>ชื่อสวน</th>
                                    <th>ชื่อแปลง</th>
                                    <th>พื้นที่ปลูก</th>
                                    <th>จำนวนต้น</th>
                                    <th>ชนิด</th>
                                    <th>วันที่พบ</th>
                                    <th>จัดการ</th>
                                </tr>
                            </tfoot>
                            <tbody id="fetchDataTable">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!------------ Start Modal ------------>

    <div class="modal fade" id="modal-1" role="dialog">
        <div class="modal-dialog modal-xl " role="document">
            <!-- modal-dialog-scrollable -->
            <div class="modal-content">
                <div class="modal-header header-modal">
                    <h4 class="modal-title">ข้อมูลลักษณะทั่วไปของศัตรูพืช</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="infoModalBody">
                    <div class="row mb-4">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4" style="text-align: center;">
                            <div style="text-align: center;">
                                <img id="img-icon" class="img-radius" height="180px" width="180px" />
                            </div>
                            <hr>
                            <h4 id="PAlias"></h4>
                            <h4 id="PName"></h4>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                            <h4>ลักษณะ</h4>
                            <textarea id="Charactor" rows="10" cols="40" style="margin-bottom:20px; max-width: 270px;" readonly></textarea>
                            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">

                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                            <h4>อันตราย</h4>
                            <textarea id="Danger" rows="10" cols="40" style="margin-bottom:20px; max-width: 270px;" readonly>ข้อมูลอันตราย</textarea>
                            <div id="carouselExampleIndicators2" class="carousel slide" data-ride="carousel">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-2" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header header-modal">
                    <h4 class="modal-title">รูปภาพศัตรูพืช</h4>
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

    <div class="modal fade" id="modal-4" role="dialog">
        <form method="post" enctype="multipart/form-data" id="form">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header header-modal">
                        <h4 class="modal-title">เพิ่มการตรวจพบศัตรูพืช</h4>
                    </div>
                    <div class="modal-body">
                        <div class="main">
                            <div class="row mb-4">
                                <div class="col-xl-3 col-12 text-right">
                                    <span>วันที่</span>
                                </div>
                                <div class="col-xl-9 col-12">
                                    <input class="form-control" width="auto" id="p_date" name="p_date" />
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-xl-3 col-12 text-right">
                                    <span>จากสวน</span>
                                </div>
                                <div class="col-xl-9 col-12">
                                    <select class="js-example-basic-single" id="p_farm" name="p_farm">

                                    </select>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-xl-3 col-12 text-right">
                                    <span>จากแปลง</span>
                                </div>
                                <div class="col-xl-9 col-12">
                                    <select class="js-example-basic-single" id="p_subfarm" name="p_subfarm">

                                    </select>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-xl-3 col-12 text-right">
                                    <span>ชนิดศัตรูพืช</span>
                                </div>
                                <div class="col-xl-9 col-12">
                                    <select class="js-example-basic-single" id="p_rank" name="p_rank">

                                    </select>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-xl-3 col-12 text-right">
                                    <span>ศัตรูพืช</span>
                                </div>
                                <div class="col-xl-9 col-12">
                                    <select class="js-example-basic-single" id="p_pest" name="p_pest">

                                    </select>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-xl-3 col-12 text-right">
                                    <span>ลักษณะ</span>
                                </div>
                                <div class="col-xl-9 col-12">
                                    <textarea name="p_note" class="form-control" id="p_note" cols="30" rows="5"></textarea>
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
                            <button id="m_success" type="button" class="btn btn-success" data-dismiss="modal">ยืนยัน</button>
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

<!-- <script src="PestModal.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBMLhtSzox02ZCq2p9IIuihhMv5WS2isyo&language=th" async defer></script>

<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>

<script src="../../croppie/croppie.js"></script>

<script>
    pdfMake.fonts = {
        THSarabun: {
            normal: 'THSarabun.ttf',
            bold: 'THSarabun-Bold.ttf',
            italics: 'THSarabun-Italic.ttf',
            bolditalics: 'THSarabun-BoldItalic.ttf'
        }
    }

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

        loadProvince();
        loadData();
        loadFarm();
    });

    let dataProvince;
    let dataDistrinct;
    let numProvince = 0;
    let ID_Province = null;
    let ID_Distrinct = null;

    let dataFarm;
    let dataSubFarm;
    let ID_Farm = null;
    let ID_SubFarm = null;

    let dataPest;
    let ID_TypePest = null;
    let ID_Pest = null;
    let type = ["insect", "disease", "weed", "other"];

    let data;

    let year = null;
    let name = null;
    let passport = null;

    /*<! ----------------------------------------------------- Function Mixs All  ----------------------------------------------------------- !>*/
    // LoadMap
    function initMap() {
        // The location of Uluru
        //alert(coordinate[0].lat);
        var marker = {
            lat: 12.815300,
            lng: 101.490997
        };

        // The map, centered at Uluru
        var map = new google.maps.Map(
            document.getElementById('map'), {
                zoom: 16,
                center: marker
            });
        // The marker, positioned at Uluru
        var marker = new google.maps.Marker({
            position: marker,
            map: map
        });
        // Construct the polygon.
        var area = new google.maps.Polygon({
            // paths: zone,
            strokeColor: '#FF0000',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: '#FF0000',
            fillOpacity: 0.35
        });


        let i, info;
        console.log("*-*-*-* " + data);
        for (i = 0; i < data.length; i++) {
            console.log("SET MAP ");
            marker = new google.maps.Marker({
                position: new google.maps.LatLng(data[i].Latitude, data[i].Longitude),
                title: data[i].subFName,
                map: map
            });
            info = new google.maps.InfoWindow();
            google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                    // info.setContent(data[i].name + "<br/>" + data[i].address + "<br/>" + "ปริมาณผลผลิต " + data[i].product + " กิโลกรัม" + "<br/>" + '<a href = "../OilPalmAreaVol/OilPalmAreaVol.php">เพิ่มเติม</a>');
                    info.open(map, marker);
                }
            })(marker, i));
        }
        area.setMap(map);
    }
    // โหลดจังหวัด
    function loadProvince() {
        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                dataProvince = JSON.parse(this.responseText);
                let text = "";
                for (i in dataProvince) {
                    text += ` <option value="${dataProvince[i].AD1ID}">${dataProvince[i].Province}</option> `
                    numProvince++;
                }
                $("#province").append(text);
            }
        };
        xhttp.open("GET", "./loadProvince.php", true);
        xhttp.send();
    }
    // โหลดอำเภอ
    function loadDistrinct(id) {
        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                dataDistrinct = JSON.parse(this.responseText);
                let text = "<option disabled selected value='null'>เลือกอำเภอ</option>";
                for (i in dataDistrinct) {
                    text += ` <option value="${dataDistrinct[i].AD2ID}">${dataDistrinct[i].Distrinct}</option> `
                }
                $("#amp").append(text);
            }
        };
        xhttp.open("GET", "./loadDistrinct.php?id=" + id, true);
        xhttp.send();
    }
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
    // โหลด Pest
    function loadPest(path, id, ID, TEXT) {
        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                dataPest = JSON.parse(this.responseText);
                let text = "<option value='-1' disabled>เลือกศัตรูพืช</option>";
                for (i in dataPest) {
                    text += ` <option value="${dataPest[i].dbpestLID}">${dataPest[i].Alias}</option> `
                }
                $(ID).html(text);
                if (TEXT == "edit")
                    $(ID).val(data[id].dbpestLID).trigger('change');
                else
                    $(ID).val(-1).trigger('change');
            }
        };
        xhttp.open("GET", "./loadPest.php?id=" + path, true);
        xhttp.send();
    }
    // โหลด Photo [log-pest]
    function loadPhoto_LogPest(PID, TYPE1, TYPE2, ID, numPIC) {
        let path = "../../picture/Pest/" + TYPE1 + "/" + TYPE2 + "/" + PID;
        let xhttp = new XMLHttpRequest();
        console.log(path);
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                let data1 = JSON.parse(this.responseText);
                console.log(this.responseText);
                let text = `<ol class="carousel-indicators">
                                <li data-target="${ID}" data-slide-to="0" class="active"></li>`;
                for (i = 1; i < numPIC; i++)
                    text += `<li data-target="${ID}" data-slide-to="${i}"></li>`;
                text += `</ol>`;
                text += `<div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <img class="set-images" src="${path+"/"+data1[0]}">
                                    </div>`;
                for (i = 1; i < numPIC; i++)
                    text += `<div class="carousel-item">
                                <img class="set-images" src="${path+"/"+data1[i]}">
                             </div>`
                text += `</div>
                        <a class="carousel-control-prev" href="${ID}" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="${ID}" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>`;
                $(ID).html(text);
            }
        };
        xhttp.open("POST", "./scanDir.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send(`path=${path}`);
    }
    // โหลด Photo Gallary [log-pestAlarm] -> PICS
    function loadPhoto_LogPestAlarm(PICS) {
        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                let data1 = JSON.parse(this.responseText);
                let text = "";
                for (i in data1) {
                    text += `<a href="${PICS+"/"+data1[i]}" class="col-xl-3 col-3 margin-photo" target="_blank">
                                <img src="${PICS+"/"+data1[i]}"" class="img-gal">
                            </a>`
                }
                $("#fetchPhoto").html(text);
            }
        };
        xhttp.open("POST", "./scanDir.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send(`path=${PICS}`);
    }
    // โหลด Photo Edit [log-pestAlarm] -> PICS
    function loadPhoto_LogPestAlarm2(PICS, id) {
        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                let data1 = JSON.parse(this.responseText);
                let text = ``;
                for (i in data1) {
                    text += `<div class="card" width="70px" hight="70px">
                                    <div class="card-body" style="padding:0;">
                                        <img class="img_scan" src = "${PICS+"/"+data1[i]}" id="${i}_CropPhoto" width="100%" hight="100%" />
                                    </div>
                                    <div class="card-footer">
                                        <button type="button" class="btn btn-warning edit-img">แก้ไข</button>
                                        <button type="button" class="btn btn-danger delete-img">ลบ</button>
                                    </div>
                                </div>`
                }
                text += `<div class="img-reletive">
                            <img src="https://ast.kaidee.com/blackpearl/v6.18.0/_next/static/images/gallery-filled-48x48-p30-6477f4477287e770745b82b7f1793745.svg" width="50px" height="50px" alt="">
                            <input type="file" class="form-control" id="p_photo" name="p_photo[]" accept=".jpg,.png" multiple>
                        </div>`;
                $(id).html(text);
            }
        };
        xhttp.open("POST", "./scanDir.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send(`path=${PICS}`);
    }
    // โหลด Datatable 
    function loadData() {
        let xhttp = new XMLHttpRequest();
        $('#example').DataTable().destroy();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                data = JSON.parse(this.responseText);
                console.log(data);
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
                $('#example').DataTable({
                    dom: '<"row"<"col-sm-6"B>>' +
                        '<"row"<"col-sm-6 mar"l><"col-sm-6 mar"f>>' +
                        '<"row"<"col-sm-12"tr>>' +
                        '<"row"<"col-sm-5"i><"col-sm-7"p>>',
                    buttons: [{
                            extend: 'excel',
                            title: 'การตรวจพบศัตรูพืชในสวนปาล์มน้ำมัน',
                            text: '<i class="fas fa-file-excel"> <font> Excel</font> </i>',
                            className: 'btn btn-outline-success btn-sm export-button'
                        },
                        {
                            extend: 'pdf',
                            title: 'Data export',
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
                initMap();
            }
        };
        xhttp.open("GET", "./loadPestAlarm.php", true);
        xhttp.send();
    }
    // Search And Fetch Datatable 
    function search_Fetch_Datatable() {
        let xhttp = new XMLHttpRequest();
        $('#example').DataTable().destroy();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                data = JSON.parse(this.responseText);
                console.log(data);
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
                $('#example').DataTable({
                    dom: '<"row"<"col-sm-6"B>>' +
                        '<"row"<"col-sm-6 mar"l><"col-sm-6 mar"f>>' +
                        '<"row"<"col-sm-12"tr>>' +
                        '<"row"<"col-sm-5"i><"col-sm-7"p>>',
                    buttons: [{
                            extend: 'excel',
                            title: 'การตรวจพบศัตรูพืชในสวนปาล์มน้ำมัน',
                            text: '<i class="fas fa-file-excel"> <font> Excel</font> </i>',
                            className: 'btn btn-outline-success btn-sm export-button'
                        },
                        {
                            extend: 'pdf',
                            title: 'Data export',
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
            }
        };
        xhttp.open("POST", "./search_Fetch_Datatable.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send(`year=${year}&ID_Pest=${ID_Pest}&ID_Province=${ID_Province}&ID_Distrinct=${ID_Distrinct}&name=${name}&passport=${passport}`);

    }


    /*<! ----------------------------------------------------- Event Mixs All ----------------------------------------------------------- !>*/


    // Start Event Select_จังหวัด 
    $("#province").on('change', function() {
        $("#amp").empty();
        let x = document.getElementById("province").value;
        for (let i = 0; i < numProvince; i++)
            if (dataProvince[i].AD1ID == x) {
                ID_Province = x;
                ID_Distrinct = null;
                loadDistrinct(dataProvince[i].AD1ID);
            }
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
        let ID_SubFarm = document.getElementById("p_subfarm").value;
    });
    // Start Event Select_TypePest
    $("#p_rank").on('change', function() {
        $("#p_pest").empty();
        let x = document.getElementById("p_rank").value;
        ID_TypePest = x;
        loadPest(x, 0, "#p_pest", "");
    });


    // Start Event Create Modal && LoadFarm
    $("#btn-modal4").on('click', function() {
        let current_datetime = new Date()
        let formatted_date = (current_datetime.getFullYear() + "-" + (current_datetime.getMonth() + 1) + "-" + current_datetime.getDate());
        $('#p_date').val(formatted_date);
        loadFarm();
        // $('#p_farm').val(-1).trigger('change');
        $('#p_subfarm').html("<option disabled selected>เลือกแปลง</option>");
        $('#p_rank').html(`<option disabled selected>เลือกชนิดศัตรูพืช</option>
                            <option value="1">แมลงศัตรูพืช</option>
                            <option value="2">โรคพืช</option>
                            <option value="3">วัชพืช</option>
                            <option value="4">ศัตรูพืชอื่นๆ</option>`);
        $('#p_pest').html("<option disabled selected>เลือกศัตรูพืช</option>");
        document.getElementById("p_note").value = "";
        $('#p_insert_img').html(`<div class="img-reletive">
                                    <img src="https://ast.kaidee.com/blackpearl/v6.18.0/_next/static/images/gallery-filled-48x48-p30-6477f4477287e770745b82b7f1793745.svg" width="50px" height="50px" alt="">
                                    <input type="file" class="form-control" id="p_photo" name="p_photo[]" accept=".jpg,.png" multiple>
                                </div>`);
        $('#hidden_id').attr('value', "insert");
    });
    // Start Submit Create Modal
    $(document).on('click', '#m_success', function() {
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
                // location.reload();
                loadData();
            }
        });
    });


    // Start Edit Botton
    $(document).on('click', '.btn-edit', function() {
        let id = $(this).attr('id');
        let text = "";

        $('#p_date').val(data[id].Date);

        for (i in dataFarm)
            text += ` <option value="${dataFarm[i].FMID}">${dataFarm[i].Name}</option> `;
        $("#p_farm").html(text);
        $('#p_farm').val(data[id].FID).trigger('change');

        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                dataSubFarm = JSON.parse(this.responseText);
                let text = "";
                for (i in dataSubFarm)
                    text += ` <option value="${dataSubFarm[i].FSID}">${dataSubFarm[i].Name}</option> `
                $("#p_subfarm").html(text);
                $('#p_subfarm').val(data[id].SFID).trigger('change');
            }
        };
        xhttp.open("GET", "./loadSubFarm.php?farm=" + data[id].FID, true);
        xhttp.send();

        $('#p_rank').html(`<option value="1">แมลงศัตรูพืช</option>
                            <option value="2">โรคพืช</option>
                            <option value="3">วัชพืช</option>
                            <option value="4">ศัตรูพืชอื่นๆ</option>`);
        $('#p_rank').val(data[id].dbpestTID).trigger('change');

        loadPest(data[id].dbpestTID, id, "#p_pest", "edit");

        document.getElementById("p_note").value = data[id].Note;

        loadPhoto_LogPestAlarm2("../../" + data[id].PICS, "#p_insert_img");

        $('#hidden_id').attr('value', "edit");
        $('#pestAlarmID').attr('value', data[id].ID);
    });
    // Start Detail Pest Botton
    $(document).on('click', '.btn-Pest', function() {
        let id = $(this).attr('id');
        let nameType = type[data[id].dbpestTID - 1];
        document.getElementById("PAlias").innerHTML = "ชื่อ : " + data[id].PAlias;
        document.getElementById("PName").innerHTML = "ชื่อทางการ : " + data[id].PName;
        document.getElementById("Charactor").innerHTML = data[id].Charactor;
        document.getElementById("Danger").innerHTML = data[id].Danger;
        document.getElementById("img-icon").src = "../../icon/pest/" + data[id].dbpestLID + "/" + data[id].Icon;

        loadPhoto_LogPest(data[id].dbpestLID, nameType, "danger", "#carouselExampleIndicators", data[id].NumPicDanger);
        loadPhoto_LogPest(data[id].dbpestLID, nameType, "style", "#carouselExampleIndicators2", data[id].NumPicChar);
    });
    // Start Photo PestAlarm Botton
    $(document).on('click', '.btn-photo', function() {
        let id = $(this).attr('id');
        loadPhoto_LogPestAlarm("../../" + data[id].PICS);
    });
    // Start Note Botton
    $(document).on('click', '.btn-note', function() {
        let id = $(this).attr('id');
        document.getElementById("Note").innerHTML = data[id].Note;
    });
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
                        $('#example').DataTable().destroy();
                        let xhttp = new XMLHttpRequest();
                        xhttp.onreadystatechange = function() {
                            if (this.readyState == 4 && this.status == 200) {
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
                                $('#example').DataTable({
                                    dom: '<"row"<"col-sm-6"B>>' +
                                        '<"row"<"col-sm-6 mar"l><"col-sm-6 mar"f>>' +
                                        '<"row"<"col-sm-12"tr>>' +
                                        '<"row"<"col-sm-5"i><"col-sm-7"p>>',
                                    buttons: [{
                                            extend: 'excel',
                                            title: 'การตรวจพบศัตรูพืชในสวนปาล์มน้ำมัน',
                                            text: '<i class="fas fa-file-excel"> <font> Excel</font> </i>',
                                            className: 'btn btn-outline-success btn-sm export-button'
                                        },
                                        {
                                            extend: 'pdf',
                                            title: 'Data export',
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
                            }
                        };
                        xhttp.open("POST", "./deletePest.php", true);
                        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                        xhttp.send(`ID=${pid}`);
                    });
                } else {
                    swal("ยกเลิกการดำเนินการลบ !!");
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


    /*<! ----------------------------------------------------- Function && Event All Searching ----------------------------------------------------------- !>*/

    // Start Search
    $("#btn_search").on('click', function() {
        year = document.getElementById("year").value;
        ID_Pest = document.getElementById("pest").value;
        ID_Distrinct = document.getElementById("amp").value;
        name = document.getElementById("name").value;
        passport = document.getElementById("idcard").value;
        console.log(" [ " + year + " " + ID_Pest + " " + ID_Province + " " + ID_Distrinct + " " + name + " " + passport + " ] ");

        search_Fetch_Datatable();

        $("#collapseOne").children().children().addClass("collapsed");
        document.getElementById("headingOne").setAttribute("aria-expanded", "false");
        $("#collapseOne").removeClass("show");

    });
</script>