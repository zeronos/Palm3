<?php
session_start();
include_once("../../dbConnect.php");
$idUT = $_SESSION[md5('typeid')];
$CurrentMenu = "OilPalmAreaList";
$rai1 = selectDataOne("SELECT SUM(`db-subfarm`.`AreaRai`) AS sumRai FROM `db-subfarm`");
$sfarm1 = selectDataOne("SELECT COUNT(`db-subfarm`.`FSID`) AS totalSubfarm FROM `db-subfarm`");
$tree1 = selectDataOne("SELECT sum(`log-farm`.`NumTree`) as sumTree FROM `log-farm`
where `log-farm`.`EndT` is null AND `log-farm`.`DIMSubfID` is null");
$farm1 = selectDataOne("SELECT COUNT(`db-farm`.`FMID`) AS totalFarm FROM `db-farm`");
?>


<?php include_once("../layout/LayoutHeader.php"); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.css">

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

    #map {
        width: 100%;
        height: 700px;
    }

    #find {
        max-width: 500px;
    }
</style>

<div class="container">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <div class="row">
        <div class="col-xl-12 col-12 mb-4">
            <div class="card">
                <div class="card-header card-bg">
                    <div class="row">
                        <div class="col-12">
                            <span class="link-active">รายชื่อสวนปาล์มน้ำมัน</span>
                            <span style="float:right;">
                                <i class="fas fa-bookmark"></i>
                                <a class="link-path" href="#">หน้าแรก</a>
                                <span> > </span>
                                <a class="link-path link-active" href="#">รายชื่อสวนปาล์มน้ำมัน</a>
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
                            <div class="font-weight-bold  text-uppercase mb-1">จำนวนสวน</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $farm1['totalFarm'] ?> สวน</div>
                        </div>
                        <div class="col-auto">
                            <i class="material-icons icon-big">group</i>
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
                            <div class="font-weight-bold  text-uppercase mb-1">จำนวนแปลง</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $sfarm1['totalSubfarm'] ?> แปลง</div>
                        </div>
                        <div class="col-auto">
                            <i class="material-icons icon-big">waves</i>
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
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $rai1['sumRai'] ?> ไร่</div>
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
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $tree1['sumTree'] ?> ต้น</div>
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
                    <div class="card-header collapsed" id="headingOne" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne" style="cursor:pointer; background-color: #E91E63; color: white;">
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
</div>
<div class="row mt-4">
    <div class="col-xl-12 col-12">
        <div class="card">
            <div class="card-header card-bg">
                <div>
                    <span>สวนปาล์มน้ำมันในระบบ</span>
                    <button type="button" style="float:right;" class="btn btn-success" data-toggle="modal" data-target="#modal-1"><i class="fas fa-plus"></i> เพิ่มสวน</button>
                </div>
            </div>
            <div class="card-body" style="overflow-x:scroll;">

                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped table-hover table-data" width="100%">
                        <thead>
                            <tr>
                                <th>จังหวัด</th>
                                <th>อำเภอ</th>
                                <th>ชื่อเกษตรกร</th>
                                <th>ชื่อสวน</th>
                                <th>จำนวนแปลง</th>
                                <th>พื้นที่ปลูก (ไร่)</th>
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
                                <th>พื้นที่ปลูก (ไร่)</th>
                                <th>จำนวนต้น</th>
                                <th>รายละเอียด</th>
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
<div class="modal" id="modal-1">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form class="form-signin" method="POST" action='manage.php'>
                <div class="modal-header header-modal">
                    <h4 class="modal-title">เพิ่มสวนปาล์ม</h4>
                </div>
                <div class="modal-body" id="addModalBody">
                    <div class="row mb-4">
                        <div class="col-xl-3 col-12 text-right">
                            <span>ชื่อสวนปาล์ม</span>
                        </div>
                        <div class="col-xl-9 col-12">
                            <input type="text" class="form-control" name="namefarm" id="rank3">
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-xl-3 col-12 text-right">
                            <span>ชื่อย่อสวนปาล์ม</span>
                        </div>
                        <div class="col-xl-9 col-12">
                            <input type="text" class="form-control" name="aliasfarm" id="rank4">
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-xl-3 col-12 text-right">
                            <span>ที่อยู่</span>
                        </div>
                        <div class="col-xl-9 col-12">
                            <input type="text" class="form-control" name="addfarm" id="rrr">
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


                    <div class="row mb-4">
                        <div class="col-xl-3 col-12 text-right">
                            <span>เจ้าของสวนปาล์ม</span>
                        </div>
                        <div class="col-xl-9 col-12">
                            <select class="form-control" id="farmer" name="farmer">
                                <option selected="" disabled="">เลือกเจ้าของสวน</option>

                            </select>
                        </div>
                    </div>
                    <input type="hidden" name="add">

                </div>
                <div class="modal-footer">
                    <button class="btn btn-success btn-md" style="float:right;" type="submit">ยืนยัน</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">ยกเลิก</button>
                </div>
            </form>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.js"></script>
<script src="OilPalmAreaList.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBMLhtSzox02ZCq2p9IIuihhMv5WS2isyo&callback=initMap&language=th" async defer></script>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> -->
<script>
    document.getElementById("province1").addEventListener("load", loadProvince1());

    var h1 = document.getElementById('hide1');
    h1.addEventListener('click', show_hide);

    function show_hide() {
        console.log("5555");

        h1.classList.toggle('active');
        if ($('#FormalID').attr("type") == "password") {
            $('#FormalID').attr('type', 'text');
            $('#hide1').removeClass("fa-eye-slash");
            $('#hide1').addClass("fa-eye");
        } else if ($('#FormalID').attr("type") == "text") {
            $('#FormalID').attr('type', 'password');
            $('#hide1').addClass("fa-eye-slash");
            $('#hide1').removeClass("fa-eye");
        }
    }

    let data;

    // โหลดจังหวัด
    function loadProvince1() {
        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                data = JSON.parse(this.responseText);
                console.table(data);
                let text = "<option value='0'>เลือกจังหวัด</option> ";
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
                console.table(data);
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
        $("#subamp").empty();
        let x = document.getElementById("amp1").value;
        let y = document.getElementById("amp1");
        if (y.length == 78)
            y.remove(0);
        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {

                data = JSON.parse(this.responseText);
                console.table(data);
                let text = "<option value='0'>เลือกตำบล</option>";
                for (i in data) {
                    text += ` <option value ='${data[i].AD3ID}'>${data[i].subDistrinct}</option> `
                }

                $("#subamp").append(text);
            }
        };
        xhttp.open("GET", "./loadSubDistrinct.php?id=" + x, true);
        xhttp.send();
    });



    $(document).ready(function() {
        let data;
        loadData();
        loadFarmer();
        $('.js-example-basic-single').select2();



        function loadFarmer() {
            $("#farmer");
            let xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    data = JSON.parse(this.responseText);
                    console.table(data);
                    let text = "";
                    for (i in data) {
                        text += ` <option value="${data[i].UFID}">${data[i].FirstName}</option> `
                    }
                    $("#farmer").append(text);
                }
            };
            xhttp.open("GET", "./loadFarmer.php", true);
            xhttp.send();
        }

        function loadFarmer2() {
            $("#farmer1");
            let xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    data = JSON.parse(this.responseText);
                    let text = "";
                    for (i in data) {
                        text += ` <option>${data[i].FirstName}</option> `
                    }
                    $("#farmer1").append(text);
                }
            };
            xhttp.open("GET", "./loadFarmer.php", true);
            xhttp.send();
        }

        function loadData() {
            $("#example1").DataTable().destroy();
            let xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    data = JSON.parse(this.responseText);

                    let text = "";
                    console.table(data);
                    for (i in data) {
                        let a = data[i].Name;
                        text += `<tr>
                                    <td class="text-left">${data[i].Province}</td>
                                    <td class="text-left">${data[i].Distrinct}</td>
                                    <td class="text-left">${data[i].Alias}</td>
                                    <td class="text-left">${data[i].Name}</td>
                                    <td class="text-right">${data[i].NumSubFarm}</td> 
                                    <td class="text-right">${data[i].AreaRai}</td>
                                    <td class="text-right">${data[i].NumTree}</td>
                                    <td style='text-align:center;'>
                                        <a href='OilPalmAreaListDetail.php?id=${data[i].Name}&fname=${data[i].Alias}&fmid=${data[i].FMID}&logid=${data[i].ID}'><button type='button' id='btn_info' class='btn btn-info btn-sm'><i class='fas fa-bars'></i></button></a>
                                        <button type='button' id='btn_delete' class='btn btn-danger btn-sm' onclick="delfunction('${data[i].Name}' , '${data[i].FMID}')"><i class='far fa-trash-alt'></i></button>
                                    </td>
                                </tr> `;

                    }
                    $("#getData").html(text);
                    $('#example1').DataTable();
                }
            };
            xhttp.open("POST", "./getData.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send();
        }

        pdfMake.fonts = {
            THSarabun: {
                normal: 'THSarabun.ttf',
                bold: 'THSarabun-Bold.ttf',
                italics: 'THSarabun-Italic.ttf',
                bolditalics: 'THSarabun-BoldItalic.ttf'
            }
        }

        $('#example1').DataTable({
            dom: '<"row"<"col-sm-12"B>>' +
                '<"row"<"col-sm-6"l><"col-sm-6"f>>' +
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

                    swal({

                        title: "ลบข้อมูลสำเร็จ",
                        type: "success",
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "ตกลง",
                        closeOnConfirm: false,

                    }, function(isConfirm) {
                        if (isConfirm) {
                            delete_1(_uid)
                        }

                    });
                } else {

                }
            });

    }

    function delete_1(_fid) {
        var xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                window.location.href = './OilPalmAreaList.php';

            }
        };
        xhttp.open("POST", "manage.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send(`fid=${_fid}&delete=delete`);

    }

    function yesnoCheck() {
        if (document.getElementById('yesCheck').checked) {
            document.getElementById('ifYes').style.visibility = 'visible';
        } else document.getElementById('ifYes').style.visibility = 'hidden';

    }
</script>
<script>
    function initMap() {
        var startLatLng = new google.maps.LatLng(13.736717, 100.523186);

        mapdetail = new google.maps.Map(document.getElementById('map'), {
            // center: { lat: 13.7244416, lng: 100.3529157 },
            center: startLatLng,
            zoom: 8,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        mapdetail.markers = [];
        marker = new google.maps.Marker({
            position: new google.maps.LatLng(13.736717, 100.523186),
            //icon: "http://maps.google.com/mapfiles/kml/paddle/grn-circle.png",
            map: mapdetail,
            title: "test"
        });
    }
</script>