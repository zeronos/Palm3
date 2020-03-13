<?php
session_start();
$idUT = $_SESSION[md5('typeid')];
$CurrentMenu = "FertilizerUsageList";

?>

<?php
include_once("../layout/LayoutHeader.php");
require_once("../../dbConnect.php");
include_once("query.php");





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
                            <span class="link-active" style="color: #006664;">การใส่ปุ๋ย</span>
                            <span style="float:right;">
                                <i class="fas fa-bookmark"></i>
                                <!-- เข้าหน้า home page -->
                                <a class="link-path" href="#">หน้าแรก</a>
                                <span> > </span>
                                <!-- เข้าหน้า Fertilizer -->
                                <a class="link-path link-active" style="color: #006664;" href="#">การใส่ปุ๋ย</a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--------------------- cards --------------------->
    <div class="row">
        <?php
        creatCard("card-color-one", "ปริมาณที่ใส่ปุ๋ยรวม", getCountFertilising() . " ก.ก", "panorama_vertical");
        creatCard("card-color-two", "ผลผลิตรวม ปี" . getYear("back"), getSumHarvest() . " ก.ก", "filter_vintage");
        creatCard("card-color-three", "พื้นที่ทั้งหมด", getTotalArea() . " ไร่", "dashboard");
        creatCard("card-color-four", "ต้นปาล์มทั้งหมด", getTotalPalm() . " ต้น", "format_size");
        ?>
    </div>

    <!--------------------- Searching --------------------->
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
                    ตำแหน่งการใส่ปุ๋ยสวนปาล์มน้ำมัน
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-6 col-12">
                            <div id="map" style="width:auto; height:75vh;"></div>
                        </div>
                        <div class="col-xl-6 col-12" id="forMap">

                            <div class="row">
                                <div class="col-12">
                                    <span>ปี</span>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-12">
                                    <select id="year" class="form-control">
                                        <?php
                                            getYear("all");
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12 col-12">
                                    <div class="irs-demo">
                                        <b>ปริมาณการใส่ปุ๋ย (%)</b>
                                        <input type="text" id="palmvolsilder" value="" />
                                    </div>
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
                                        <option disabled selected>เลือกจังหวัด</option>
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
                                        <option disabled selected>เลือกอำเภอ</option>
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

    <!--------------------- Resault Searched --------------------->
    <div class="row mt-4 mb-4">
        <div class="col-xl-12 col-12">
            <div class="card">
                <div class="card-header card-bg">
                    <div>
                        <span class="getSelectYear">การใส่ปุ๋ยสวนปาล์มน้ำมันในระบบปี <?php echo getYear("current"); ?>
                        </span>
                        <!-- <span style="float:right;" class="getSelectYear">ปี </span> -->
                        <button type="button" id="btn-modal4" style="float:right;" class="btn btn-success" data-toggle="modal" data-target="#modal-4"><i class="fas fa-plus"></i> เพิ่มการใส่ปุ๋ย</button>
                    </div>
                </div>
                <div class="card-body">
                    <!-- <div class="row mb-2">
                        <div class="col-xl-3 col-12">
                            <button type="button" id="btn_comfirm" class="btn btn-outline-success btn-sm"><i class="fas fa-file-excel"></i> Excel</button>
                            <button type="button" id="btn_comfirm" class="btn btn-outline-danger btn-sm"><i class="fas fa-file-pdf"></i> PDF</button>
                        </div>
                    </div> -->
                    <div class="table-responsive">
                        
                        <?php createFertilizingTable(); ?>
                        <!-- <button onclick="update_factFertilizer()">Try it</button> -->
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
                        <h4 class="modal-title setTextEdit">เพิ่มการใส่ปุ๋ย</h4>
                    </div>
                    <div class="modal-body">
                        <div class="main">
                            <?php
                                createForm("วันที่","form-control","p_date");
                                createForm("สวน","js-example-basic-single","p_farm");
                                createForm("แปลง","js-example-basic-single","p_subfarm");
                                createForm("ชนิดปุ๋ย","js-example-basic-single","p_fertilizer");
                                createForm("ปริมาณปุ๋ยที่ใส่ (ก.ก.)","form-control vol","p_vol");
                                createForm("จำนวนต้น","form-control vol","p_tree");
                                createPhoto();
                            ?>
                            
                        </div>

                        <?php createCropImg(); ?>

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



    <!---------------------  Modal Button --------------------->
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
            format: 'yyyy-mm-dd',
            language:'th-th'
        });

        $('#e_p_date').datepicker({
            showOtherMonths: true,
            format: 'yyyy-mm-dd',
            language:'th-th'
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

    pdfMake.fonts = {
        THSarabun: {
            normal: 'THSarabun.ttf',
            bold: 'THSarabun-Bold.ttf',
            italics: 'THSarabun-Italic.ttf',
            bolditalics: 'THSarabun-BoldItalic.ttf'
        }
    }

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
            paths: zone,
            strokeColor: '#FF0000',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: '#FF0000',
            fillOpacity: 0.35
        });
        area.setMap(map);
    }

    let dataProvince;
    let dataDistrinct;
    let numProvince = 0;
    let ID_Province = null;
    let ID_Distrinct = null;
    let name = null;
    let passport = null;

    let dataFarm;
    let dataSubFarm;
    let ID_Farm = null;
    let ID_SubFarm = null;

    let data;
    let year = null;
    let score_From = 0;
    let score_To = 0;
    let time = new Date();
    let currentYear = time.getFullYear() //ค.ศ. ปัจจุบัน

    document.getElementById("province").addEventListener("load", loadProvince());
    document.getElementById("btn-modal4").addEventListener("load", loadFarm());


    function checkInvalidNum() {
        var elem = document.getElementById('p_vol').value;
        if (!elem.trim().match(/^([0-9])+$/i)) {
            //elem.setCustomValidity('ความยาว 5 - 25 ตัวอักษรเท่านั้น');
            alert("กรอกได้เฉพาะตัวเลขเท่านั้น");
            document.getElementById('p_vol').value = "";

        }
    }
    // -------------------------- functions --------------------------
    // โหลดจังหวัด
    function loadProvince() {
        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                dataProvince = JSON.parse(this.responseText);
                let text = "";
                //`<option value=null>เลือกจังหวัด</option>`
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
                let text = "<option disabled selected>เลือกอำเภอ</option>";
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
    loadData((currentYear + 543))

    function loadData(year, data_search) {
        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                data = JSON.parse(this.responseText);
                 console.log(data)
                 //console.log(this.responseText);
                let text = "";
                var NumSubFarm = [],
                    AreaRai = [],
                    NumTree = [],
                    HarvestVol = [],
                    Vol1 = [],
                    Vol2 = [],
                    Vol3 = []
                var nf = new Intl.NumberFormat();
                for (j in data) {
                    NumSubFarm[j] = nf.format(data[j].NumSubFarm);
                    AreaRai[j] = nf.format(data[j].AreaRai);
                    NumTree[j] = nf.format(data[j].NumTree);
                    HarvestVol[j] = nf.format(data[j].HarvestVol);
                    Vol1[j] = nf.format(data[j].Vol1);
                    Vol2[j] = nf.format(data[j].Vol2);
                    Vol3[j] = nf.format(data[j].Vol3);
                }
                for (i in data) {
                    text += ` <tr>
                            <th class="text-left">${data[i].Alias}</th>
                            <th class="text-left">${data[i].FarmName}</th>
                            <th class="text-right">${NumSubFarm[i]}</th>
                            <th class="text-right">${AreaRai[i]}</th>
                            <th class="text-right">${NumTree[i]}</th>
                            <th class="text-right">${data[i].FerName}</th>
                            <th class="text-right">${HarvestVol[i]}</th>
                            <th class="text-right">${Vol1[i]}</th>
                            <th class="text-right">${Vol2[i]}</th>
                            <th class="text-right">${Vol3[i]}</th>
                            <th style="text-align:center;">
                                <a href='FertilizerUsageListDetail.php?name=${data[i].Alias}&farm=${data[i].FarmName}&NumTree=${data[i].NumTree}&AreaRai=${data[i].AreaRai}&AreaNgan=${data[i].AreaNgan}&AreaWa=${data[i].AreaWa}&HarvestVol=${data[i].HarvestVol}'><button type="button" id="btn_info" class="btn btn-info btn-sm"><i class="fas fa-bars"></i></button></a>
                            </th>
                        </tr>`
                }
                $("#fetchDatatable1").html(text)
            }
        };

        xhttp.open("POST", "./loadFertilizer.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send(`year=${year}` + data_search);
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
    // -------------------------- functions --------------------------


    //Start Event Select_จังหวัด && Select_อำเภอ
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
    $("#amp").on('change', function() {
        let x = document.getElementById("amp").value;
        ID_Distrinct = x;
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

    // Start Event Create Modal && LoadFarm
    $("#btn-modal4").on('click', function() {
        let current_datetime = new Date()
        let formatted_date = (current_datetime.getFullYear() + "-" + (current_datetime.getMonth() + 1) + "-" + current_datetime.getDate());
        $('#p_date').val(formatted_date);
        loadFarm();
        $('#p_farm').val(-1).trigger('change').html("<option disabled selected>เลือกสวน</option>");
        $('#p_subfarm').html("<option disabled selected>เลือกแปลง</option>");
        $('#p_fertilizer').html("<option disabled selected>เลือกชนิดปุ๋ย</option>");
        $('#p_vol').html("<input disabled>ปริมาณปุ๋ย</input>");
        $('#p_tree').html("<input disabled>จำนวนต้น</input>");
        //document.getElementById("p_note").value = "";
        $('#p_insert_img').html(`<div class="img-reletive">
                                    <img src="https://ast.kaidee.com/blackpearl/v6.18.0/_next/static/images/gallery-filled-48x48-p30-6477f4477287e770745b82b7f1793745.svg" width="50px" height="50px" alt="">
                                    <input type="file" class="form-control" id="p_photo" name="p_photo[]" accept=".jpg,.png" multiple>
                                </div>`);
        $('#hidden_id').attr('value', "insert");
    });

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

    // Start Edit Botton
    $(document).on('click', '.btn-edit', function() {
        // $(".setTextEdit").html("แก้ไขการใส่ปุ๋ย")
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

        loadPhoto_LogPestAlarm2(data[id].PICS, "#p_insert_img");

        $('#hidden_id').attr('value', "edit");
        $('#pestAlarmID').attr('value', data[id].ID);
    });

    $("#palmvolsilder").ionRangeSlider({
        type: "double",
        from: 0,
        to: 0,
        step: 1,
        min: 0,
        max: 100,
        grid: true,
        grid_num: 10,
        grid_snap: false,
        onFinish: function(data) {
            score_From = data.from;
            score_To = data.to;
            //console.log(score_From + " " + score_To);
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
        }
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

    $(document).on('click', '.btn-detail', function() {
        let id = $(this).attr('id');
        localStorage.setItem("data", JSON.stringify(data[id]));
        // let x = localStorage.getItem('data');
        // console.log(x);
        // console.log(JSON.parse(x).FullName);
        window.location.href = "http://localhost/KU-PALM-master/view/Water/WaterDetail.php";
    });

    $("#btn_search").on('click', function() {
        year = document.getElementById("year").value;
        name = document.getElementById("name").value;
        passport = document.getElementById("idcard").value;
        $(".getYear").html("ผลผลิตปี " + (year - 1))
        $(".getSelectYear").html("การใส่ปุ๋ยสวนปาล์มน้ำมันในระบบปี " + year)
        console.log(" [ " + year + " " + score_From + " " + score_To +
            " " + ID_Province + " " + ID_Distrinct + " " + name + " " + passport + " ] ");
        let data_search = "";
        if (ID_Province != null) {
            data_search += "&ID_Province=" + ID_Province;
        }
        if (ID_Distrinct != null) {
            data_search += "&ID_Distrinct=" + ID_Distrinct;
        }
        if (name != "") {
            data_search += "&name=" + name;
        }
        if (passport != "") {
            data_search += "&passport=" + passport;
        }
        if(score_From == 0 && score_To == 0)
        {
            
        }
        else
        {
            data_search += "&score_Form=" + score_From;
            data_search += "&score_To=" + score_To;
        }

        loadData(year, data_search);

        console.log(data_search);

        // +++
        $("#collapseOne").children().children().addClass("collapsed");
        document.getElementById("headingOne").setAttribute("aria-expanded", "false");
        $("#collapseOne").addClass("show");

    });
</script>