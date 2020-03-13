<?php
session_start();
$idUT = $_SESSION[md5('typeid')];
$CurrentMenu = "Water";
$type = $_GET['type'];


// $url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'] . "?" . $_SERVER['QUERY_STRING'];
// echo "[  " . $_SERVER['HTTP_HOST'] . "  ]";
// echo "[  " . $_SERVER['SCRIPT_NAME'] . "  ]";
// echo "[  " . $_SERVER['QUERY_STRING'] . "  ]";
?>

<?php include_once("../layout/LayoutHeader.php"); ?>
<link href='../Calendar/packages/core/main.css' rel='stylesheet' />
<link href='../Calendar/packages/daygrid/main.css' rel='stylesheet' />
<link href='../Calendar/packages/timegrid/main.css' rel='stylesheet' />
<link href='../Calendar/packages/list/main.css' rel='stylesheet' />
<link href='../Calendar/packages/bootstrap/main.css' rel='stylesheet' />

<link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />

<style>
    /* #calendar1 {
        max-width: 850px;
        margin: 0 auto;
        background-color: white;
        color: black;
    }

    #calendar2 {
        max-width: 850px;
        margin: 0 auto;
        background-color: white;
        color: black;
    } */

    .text-left {
        align: left;
    }

    .text-right {
        align: right;
    }

    .gj-icon {
        padding-top: 6px;
        padding-right: 6px;
    }

    .mar {
        margin-top: 5px;
    }

    .padding {
        padding-top: 10px;
    }

    .export-button {
        background: white;
        margin-right: 7px;
        margin-bottom: 10px;
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

    <!------------ Start Head ------------>
    <div class="row">
        <div class="col-xl-12 col-12 mb-4">
            <div class="card">
                <div class="card-header card-bg">
                    <div class="row">
                        <div class="col-12">
                            <span class="link-active" id="detail1" style="color: <?= $color ?>;"></span>
                            <span style="float:right;">
                                <i class="fas fa-bookmark"></i>
                                <a class="link-path" href="../UserProfile/UserProfile.php">หน้าแรก</a>
                                <span> > </span>
                                <a class="link-path" href="Water.php">การให้น้ำ</a>
                                <span> > </span>
                                <a class="link-path link-active" id="detail2" href="" style="color: <?= $color ?>;"></a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!------------ Start Card ------------>
    <div class="row mb-3">
        <div class="col-xl-6 col-12">
            <div class="card">
                <div class="card-body" height="166px" id="for_card">
                    <div class="row">
                        <img class="img-radius" id="subfarm-img" width="250px" height="166px" src="" />
                    </div>
                    <div class="row mt-3 justify-content-center">
                        <div class="col-xl-3 col-3 text-right">
                            <span id="span_name1"></span>
                        </div>
                        <div class="col-xl-3 col-3">
                            <span id="span_name2"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-12">
            <div class="card">
                <div class="card-body" height="166px" id="card_height">
                    <div class="row">
                        <img class="img-radius" id="farmer-img" width="35%" height="166px" src="" />
                    </div>
                    <div class="row mt-3 justify-content-center">
                        <div class="col-xl-3 col-3 text-right">
                            <span>เกษตรกร : </span>
                        </div>
                        <div class="col-xl-4 col-3">
                            <span id="Fname"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!------------ Start Calender ------------>
    <div class="row mt-3">
        <div class="col-xl-12 col-12">
            <div class="card">
                <!------------ Head ------------>
                <div class="card-header card-bg">
                    <div id="add-btn-modal">

                    </div>
                </div>
                <div class="card-body">

                    <!------------  Tab Bar ------------>
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">ปฏิทินข้อมูล</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#table" role="tab" aria-controls="profile" aria-selected="false">ตารางข้อมูล</a>
                        </li>
                    </ul>

                    <!------------ Body ------------>
                    <div class="tab-content" id="myTabContent" style="margin-top:20px;">

                        <!------------ Start Calender ------------>
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

                        </div>

                        <!------------ Start Table ------------>
                        <div class="tab-pane fade" id="table" role="tabpanel" aria-labelledby="profile-tab">

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
<!------------ Start Modal ------------>
<div class="modal" id="modal-1">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header header-modal">
                <h4 class="modal-title">เพิ่มปริมาณฝนตก</h4>
            </div>
            <div class="modal-body" id="addModalBody1">

                <div class="row mb-4">
                    <div class="col-xl-3 col-12 text-right">
                        <span>วันที่</span>
                    </div>
                    <div class="col-xl-9 col-12">
                        <input class="form-control" width="auto" class="" id="r_date1" />
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-xl-3 col-12 text-right">
                        <span>เวลาที่ฝนเริ่มตก</span>
                    </div>
                    <div class="col-xl-9 col-12 timepicker">
                        <input id="r1_timepicker1" type="text" class="form-control input-small">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-xl-3 col-12 text-right">
                        <span>เวลาที่ฝนหยุดตก</span>
                    </div>
                    <div class="col-xl-9 col-12 timepicker">
                        <input id="r2_timepicker1" type="text" class="form-control input-small">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-xl-3 col-12 text-right">
                        <span>ระดับฝนตก</span>
                    </div>
                    <div class="col-xl-9 col-12">
                        <select class="form-control" id="r_rank1">
                            <option>เบา (ปริมาณ 0.1 มม. ถึง 10.0 มม.)</option>
                            <option>ปานกลาง (ปริมาณ 10.1 มม. ถึง 35.0 มม.)</option>
                            <option>หนัก (ปริมาณ 35.1 มม. ถึง 90.0 มม.)</option>
                            <option>หนักมาก (ปริมาณ 90.1 มม. ขึ้นไป)</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-xl-3 col-12 text-right">
                        <span>ปริมาณน้ำฝน / ลิตร</span>
                    </div>
                    <div class="col-xl-9 col-12">
                        <input type="number" class="form-control" id="r_raining1">
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button id="m_success1" type="button" class="btn btn-success">ยืนยัน</button>
                <button id="m_not_success1" type="button" class="btn btn-danger" data-dismiss="modal">ยกเลิก</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="modal-2">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header header-modal">
                <h4 class="modal-title">เพิ่มระบบการให้น้ำ</h4>
            </div>
            <div class="modal-body" id="addModalBody2">
                <div class="row mb-4">
                    <div class="col-xl-3 col-12 text-right">
                        <span>วันที่</span>
                    </div>
                    <div class="col-xl-9 col-12">
                        <input class="form-control" width="auto" class="" id="r_date2" />
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-xl-3 col-12 text-right">
                        <span>เวลาที่เริ่มให้น้ำ</span>
                    </div>
                    <div class="col-xl-9 col-12  timepicker">
                        <input id="r1_timepicker2" type="text" class="form-control input-small">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-xl-3 col-12 text-right">
                        <span>เวลาที่หยุดให้น้ำ</span>
                    </div>
                    <div class="col-xl-9 col-12  timepicker">
                        <input id="r2_timepicker2" type="text" class="form-control input-small">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-xl-3 col-12 text-right">
                        <span>ปริมาณการให้น้ำ / ลิตร</span>
                    </div>
                    <div class="col-xl-9 col-12">
                        <input type="number" class="form-control" id="r_raining2">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="m_success2" type="button" class="btn btn-success">ยืนยัน</button>
                <button id="m_not_success2" type="button" class="btn btn-danger" data-dismiss="modal">ยกเลิก</button>
            </div>
        </div>
    </div>
</div>
<!------------ Stop Modal ------------>
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
<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>

<script src='../Calendar/packages/core/main.js'></script>
<script src='../Calendar/packages/interaction/main.js'></script>
<script src='../Calendar/packages/daygrid/main.js'></script>
<script src='../Calendar/packages/timegrid/main.js'></script>
<script src='../Calendar/packages/list/main.js'></script>
<script src='../Calendar/packages/bootstrap/main.js'></script>

<script>
    let type = "<?php echo $type; ?>"
    let UID = parseInt(localStorage.getItem('UID'));
    let SFID = parseInt(localStorage.getItem('SFID'));
    let DSFID = parseInt(localStorage.getItem('DSFID'));
    let DIMdate;

    let dataSubFarm_S;
    let dataFarmer;
    let dataRain;
    let dataWater;

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

        $('#r_date1').datepicker({
            showOtherMonths: true,
            format: 'yyyy-mm-dd'
        });
        $('#r_date2').datepicker({
            showOtherMonths: true,
            format: 'yyyy-mm-dd'
        });

        $('#r1_timepicker1').timepicker();
        $('#r2_timepicker1').timepicker();
        $('#r1_timepicker2').timepicker();
        $('#r2_timepicker2').timepicker();

        loadSubfarm_S(SFID);
        loadFarmer(UID);
    });

    // โหลด Subfarm Small
    function loadSubfarm_S(id) {
        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                dataSubFarm_S = JSON.parse(this.responseText);
                console.log(dataSubFarm_S)
                document.getElementById('span_name1').innerHTML = "ชื่อแปลง : ";
                document.getElementById('span_name2').innerHTML = dataSubFarm_S[0].Name;
                document.getElementById("subfarm-img").src = "../../icon/subfarm/" + dataSubFarm_S[0].ID + "/" + dataSubFarm_S[0].Icon;
            }
        };
        xhttp.open("GET", "./loadSubFarm_S.php?SFID=" + id, true);
        xhttp.send();
    }
    // โหลด User
    function loadFarmer(id) {
        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                dataFarmer = JSON.parse(this.responseText);
                console.log(dataFarmer)
                document.getElementById('Fname').innerHTML = dataFarmer[0].FName + " " + dataFarmer[0].LName;
                document.getElementById("farmer-img").src = "../../icon/farmer/" + dataFarmer[0].ID + "/" + dataFarmer[0].Icon;
            }
        };
        xhttp.open("GET", "./loadFarmer.php?UID=" + id, true);
        xhttp.send();
    }
    // โหลด Raining
    function loadRaining() {
        $('#dataTable').DataTable().destroy();
        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                dataRain = JSON.parse(this.responseText);
                console.log(dataRain)
                let text = "";
                for (i in dataRain) {
                    text += `<tr>
                                <th style="text-align:center;">${dataRain[i].Date}</th>
                                <th class="text-right">${dataRain[i].StartTime}</th>
                                <th class="text-right">${dataRain[i].StopTime}</th>
                                <th class="text-right">${dataRain[i].Period}</th>
                                <th class="text-right">${dataRain[i].Vol} (ลบ.ม.)</th>
                                <th style="text-align:center;"> 
                                    <button type="button" id='${i}' rid='${dataRain[i].ID}' class="btn btn-danger btn-sm btn-delete">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                </th>
                            </tr>`;
                }
                $("#fetchdata1").html(text);
                $('#dataTable').DataTable({
                    dom: '<"row"<"col-sm-6"B>>' +
                        '<"row"<"col-sm-6 mar"l><"col-sm-6 mar"f>>' +
                        '<"row"<"col-sm-12"tr>>' +
                        '<"row"<"col-sm-5"i><"col-sm-7"p>>',
                    buttons: [{
                            extend: 'excel',
                            title: 'รายละเอียดปริมาณฝน / แปลง',
                            text: '<i class="fas fa-file-excel"> <font> Excel</font> </i>',
                            className: 'btn btn-outline-success btn-sm export-button'
                        },
                        {
                            extend: 'pdf',
                            title: 'รายละเอียดปริมาณฝน / แปลง',
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
        xhttp.open("GET", "./loadRaining.php?id=" + DSFID, true);
        xhttp.send();
    }
    // โหลด Watering
    function loadWatering() {
        $('#dataTable').DataTable().destroy();
        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                dataWater = JSON.parse(this.responseText);
                console.log(dataWater);
                let text = "";
                for (i in dataWater) {
                    text += `<tr>
                                <th style="text-align:center;">${dataWater[i].Date}</th>
                                <th class="text-right">${dataWater[i].StartTime}</th>
                                <th class="text-right">${dataWater[i].StopTime}</th>
                                <th class="text-right">${dataWater[i].Period}</th>
                                <th style="text-align:center;"> 
                                    <button type="button" id='${i}' rid='${dataWater[i].ID}' class="btn btn-danger btn-sm btn-delete">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                </th>
                            </tr>`;
                }
                $("#fetchdata1").html(text);
                $('#dataTable').DataTable({
                    dom: '<"row"<"col-sm-6"B>>' +
                        '<"row"<"col-sm-6 mar"l><"col-sm-6 mar"f>>' +
                        '<"row"<"col-sm-12"tr>>' +
                        '<"row"<"col-sm-5"i><"col-sm-7"p>>',
                    buttons: [{
                            extend: 'excel',
                            title: 'รายละเอียดระบบการให้น้ำ / แปลง',
                            text: '<i class="fas fa-file-excel"> <font> Excel</font> </i>',
                            className: 'btn btn-outline-success btn-sm export-button'
                        },
                        {
                            extend: 'pdf',
                            title: 'รายละเอียดระบบการให้น้ำ / แปลง',
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
        xhttp.open("POST", "./loadWatering.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send(`DIMdate=${DIMdate}&DSFID=${DSFID}`);
    }


    if (type == 1) {
        $("#home").html(`<div class='row'>
                            <div class='col-12 mb-3'>
                                <h4>ปฏิทินข้อมูล - ช่วงเวลาที่ฝนตก</h4>
                                <div id='calendar1' style="        
                                    margin: 0 auto;
                                    width: 100%;
                                    background-color: #FFFFFF;" >
                                </div>
                            </div>
                        </div><br>
                        <div class='row'>
                            <div class='col-12 mb-3'>
                                <h4>ปฏิทินข้อมูล - ช่วงเวลาที่ฝนทิ้งช่วง</h4>
                                <div id='calendar2' style="        
                                    margin: 0 auto;
                                    width: 100%;
                                    background-color: #FFFFFF;" >
                                </div>
                            </div>
                        </div>`);
        var calendarEl1 = document.getElementById('calendar1');
        var calendar1 = new FullCalendar.Calendar(calendarEl1, {
            plugins: ['interaction', 'dayGrid', 'timeGrid', 'list', 'bootstrap'],
            themeSystem: 'bootstrap',
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
            },
            defaultDate: '2020-01-09',
            navLinks: true, // can click day/week names to navigate views
            businessHours: true, // display business hours
            editable: true,
            events: [{
                    title: 'Business Lunch',
                    start: '2019-08-03T13:00:00',
                    constraint: 'businessHours'
                },
                {
                    title: 'Meeting',
                    start: '2019-08-13T11:00:00',
                    constraint: 'availableForMeeting', // defined below
                    color: '#257e4a'
                },
                { //******************************************************************************************************* */
                    title: 'Conference',
                    start: '2019-08-18',
                    end: '2019-08-20'
                },
                {
                    title: 'Party',
                    start: '2019-08-29T20:00:00'
                },

                // areas where "Meeting" must be dropped
                {
                    groupId: 'availableForMeeting',
                    start: '2019-08-11T10:00:00',
                    end: '2019-08-11T16:00:00',
                    rendering: 'background'
                },
                {
                    groupId: 'availableForMeeting',
                    start: '2019-08-13T10:00:00',
                    end: '2019-08-13T16:00:00',
                    rendering: 'background'
                },

                // red areas where no events can be dropped
                {
                    start: '2019-08-24',
                    end: '2019-08-28',
                    overlap: false,
                    rendering: 'background',
                    color: '#ff9f89'
                },
                {
                    start: '2019-08-06',
                    end: '2019-08-08',
                    overlap: false,
                    rendering: 'background',
                    color: '#ff9f89'
                }
            ]
        });
        calendar1.render();
        var calendarEl2 = document.getElementById('calendar2');
        var calendar2 = new FullCalendar.Calendar(calendarEl2, {
            plugins: ['interaction', 'dayGrid', 'timeGrid', 'list', 'bootstrap'],
            themeSystem: 'bootstrap',
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
            },
            defaultDate: '2020-01-09',
            navLinks: true, // can click day/week names to navigate views
            businessHours: true, // display business hours
            editable: true,
            events: [{
                    title: 'Business Lunch',
                    start: '2019-08-03T13:00:00',
                    constraint: 'businessHours'
                },
                {
                    title: 'Meeting',
                    start: '2019-08-13T11:00:00',
                    constraint: 'availableForMeeting', // defined below
                    color: '#257e4a'
                },
                {
                    title: 'Conference',
                    start: '2019-08-18',
                    end: '2019-08-20'
                },
                {
                    title: 'Party',
                    start: '2019-08-29T20:00:00'
                },

                // areas where "Meeting" must be dropped
                {
                    groupId: 'availableForMeeting',
                    start: '2019-08-11T10:00:00',
                    end: '2019-08-11T16:00:00',
                    rendering: 'background'
                },
                {
                    groupId: 'availableForMeeting',
                    start: '2019-08-13T10:00:00',
                    end: '2019-08-13T16:00:00',
                    rendering: 'background'
                },

                // red areas where no events can be dropped
                {
                    start: '2019-08-24',
                    end: '2019-08-28',
                    overlap: false,
                    rendering: 'background',
                    color: '#ff9f89'
                },
                {
                    start: '2019-08-06',
                    end: '2019-08-08',
                    overlap: false,
                    rendering: 'background',
                    color: '#ff9f89'
                }
            ]
        });
        calendar2.render();
        $('#add-btn-modal').html(`<span>สวนปาล์มน้ำมันในระบบ</span>
            <button id="btn-modal1" type="button" style="float:right;" class="btn btn-success" data-toggle="modal" data-target="#modal-1"><i class="fas fa-plus"></i> เพิ่มปริมาณฝนตก</button>`);
        document.getElementById('detail1').innerHTML = 'รายละเอียดปริมาณฝน / แปลง';
        document.getElementById('detail2').innerHTML = 'รายละเอียดปริมาณฝน / แปลง';
        $('#table').html(`<div class='table-responsive'>
                            <table id="dataTable" class='table table-bordered table-striped table-hover table-data' width='100%'>
                                <thead>
                                    <tr>
                                        <th>วันที่</th>
                                        <th>ช่วงเวลาฝนเริ่มตก</th>
                                        <th>ช่วงเวลาฝนหยุดตก</th>
                                        <th>ระยะเวลาฝนตก</th>
                                        <th>ปริมาณฝน (ลบ.ม.)</th>
                                        <th>จัดการ</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>วันที่</th>
                                        <th>ช่วงเวลาฝนเริ่มตก</th>
                                        <th>ช่วงเวลาฝนหยุดตก</th>
                                        <th>ระยะเวลาฝนตก</th>
                                        <th>ปริมาณฝน (ลบ.ม.)</th>
                                        <th>จัดการ</th>
                                    </tr>
                                </tfoot>
                                <tbody id="fetchdata1">
                                    
                                </tbody>
                            </table>
                        </div>`);
        loadRaining();

    } else {
        DIMdate = parseInt(localStorage.getItem('DIMdate'));
        $("#home").html(`<div class='row'>
                            <div class='col-12 mb-3'>
                                <h4>ปฏิทินข้อมูล - ช่วงเวลาการให้น้ำ</h4>
                                <div id='calendar3' style='        
                                    margin: 0 auto;
                                    width: 100%;
                                    background-color: #FFFFFF;' >
                                </div>
                            </div>
                        </div>`);
        var calendarEl3 = document.getElementById('calendar3');
        var calendar3 = new FullCalendar.Calendar(calendarEl3, {
            plugins: ['interaction', 'dayGrid', 'timeGrid', 'list', 'bootstrap'],
            themeSystem: 'bootstrap',
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
            },
            defaultDate: '2020-01-09',
            navLinks: true, // can click day/week names to navigate views
            businessHours: true, // display business hours
            editable: true,
            events: [{
                    title: 'Business Lunch',
                    start: '2019-08-03T13:00:00',
                    constraint: 'businessHours'
                },
                {
                    title: 'Meeting',
                    start: '2019-08-13T11:00:00',
                    constraint: 'availableForMeeting', // defined below
                    color: '#257e4a'
                },
                {
                    title: 'Conference',
                    start: '2019-08-18',
                    end: '2019-08-20'
                },
                {
                    title: 'Party',
                    start: '2019-08-29T20:00:00'
                },

                // areas where "Meeting" must be dropped
                {
                    groupId: 'availableForMeeting',
                    start: '2019-08-11T10:00:00',
                    end: '2019-08-11T16:00:00',
                    rendering: 'background'
                },
                {
                    groupId: 'availableForMeeting',
                    start: '2019-08-13T10:00:00',
                    end: '2019-08-13T16:00:00',
                    rendering: 'background'
                },

                // red areas where no events can be dropped
                {
                    start: '2019-08-24',
                    end: '2019-08-28',
                    overlap: false,
                    rendering: 'background',
                    color: '#ff9f89'
                },
                {
                    start: '2019-08-06',
                    end: '2019-08-08',
                    overlap: false,
                    rendering: 'background',
                    color: '#ff9f89'
                }
            ]
        });
        calendar3.render();
        $('#table').html(`<div class='table-responsive'>
                            <table id="dataTable" class='table table-bordered table-striped table-hover table-data' width='100%'>
                                <thead>
                                    <tr>
                                        <th>วันที่</th>
                                        <th>เวลาให้น้ำ</th>
                                        <th>เวลาหยุดให้น้ำ</th>
                                        <th>ระยะเวลาให้น้ำ (นาที)</th>
                                        <th>จัดการ</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>วันที่</th>
                                        <th>เวลาให้น้ำ</th>
                                        <th>เวลาหยุดให้น้ำ</th>
                                        <th>ระยะเวลาให้น้ำ (นาที)</th>
                                        <th>จัดการ</th>
                                    </tr>
                                </tfoot>
                                <tbody id="fetchdata1">
                                    
                                </tbody>
                            </table>
                        </div>`);
        loadWatering();
        $('#add-btn-modal').html(`<span>สวนปาล์มน้ำมันในระบบ</span>
            <button id="btn-modal2" type="button" style="float:right;" class="btn btn-success" data-toggle="modal" data-target="#modal-2"><i class="fas fa-plus"></i> เพิ่มระบบให้น้ำ</button>`);
        document.getElementById('detail1').innerHTML = 'รายละเอียดระบบการให้น้ำ / แปลง';
        document.getElementById('detail2').innerHTML = 'รายละเอียดระบบการให้น้ำ / แปลง';

    }



    $(document).on('click', '#btn-modal1', function() {
        let current_datetime = new Date()
        let formatted_date = (current_datetime.getFullYear() + "-" + (current_datetime.getMonth() + 1) + "-" + current_datetime.getDate());
        $('#r_date1').val(formatted_date);
    });
    $(document).on('click', '#btn-modal2', function() {
        let current_datetime = new Date()
        let formatted_date = (current_datetime.getFullYear() + "-" + (current_datetime.getMonth() + 1) + "-" + current_datetime.getDate());
        $('#r_date2').val(formatted_date);
    });
    $(document).on('click', '.btn-delete', function() {
        let id = $(this).attr('id');
        let rid = $(this).attr('rid');
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
                        if (type == 1) {
                            $('#dataTable').DataTable().destroy();
                            let xhttp = new XMLHttpRequest();
                            xhttp.onreadystatechange = function() {
                                if (this.readyState == 4 && this.status == 200) {
                                    dataRain.splice(id, 1);
                                    let text = "";
                                    for (i in dataRain) {
                                        text += `<tr>
                                                <th class="text-right">${dataRain[i].Date}</th>
                                                <th class="text-right">${dataRain[i].StartTime}</th>
                                                <th class="text-right">${dataRain[i].StopTime}</th>
                                                <th class="text-right">${dataRain[i].Period}</th>
                                                <th class="text-right">${dataRain[i].Vol} (ลบ.ม.)</th>
                                                <th style="text-align:center;"> 
                                                    <button type="button" id='${i}' rid='${dataRain[i].ID}' class="btn btn-danger btn-sm btn-delete">
                                                        <i class="far fa-trash-alt"></i>
                                                    </button>
                                                </th>
                                            </tr>`;
                                    }
                                    $("#fetchdata1").html(text);
                                    $('#dataTable').DataTable({
                                        dom: '<"row"<"col-sm-6"B>>' +
                                            '<"row"<"col-sm-6 mar"l><"col-sm-6 mar"f>>' +
                                            '<"row"<"col-sm-12"tr>>' +
                                            '<"row"<"col-sm-5"i><"col-sm-7"p>>',
                                        buttons: [{
                                                extend: 'excel',
                                                title: 'รายละเอียดระบบการให้น้ำ / แปลง',
                                                text: '<i class="fas fa-file-excel"> <font> Excel</font> </i>',
                                                className: 'btn btn-outline-success btn-sm export-button'
                                            },
                                            {
                                                extend: 'pdf',
                                                title: 'รายละเอียดระบบการให้น้ำ / แปลง',
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
                            xhttp.open("POST", "./deleteRain.php", true);
                            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                            xhttp.send(`ID=${rid}`);
                        } else if (type == 2) {
                            $('#dataTable').DataTable().destroy();
                            let xhttp = new XMLHttpRequest();
                            xhttp.onreadystatechange = function() {
                                if (this.readyState == 4 && this.status == 200) {
                                    dataWater.splice(id, 1);
                                    let text = "";
                                    for (i in dataWater) {
                                        text += `<tr>
                                                    <th style="text-align:center;">${dataWater[i].Date}</th>
                                                    <th class="text-right">${dataWater[i].StartTime}</th>
                                                    <th class="text-right">${dataWater[i].StopTime}</th>
                                                    <th class="text-right">${dataWater[i].Period}</th>
                                                    <th style="text-align:center;"> 
                                                        <button type="button" id='${i}' rid='${dataWater[i].ID}' class="btn btn-danger btn-sm btn-delete">
                                                            <i class="far fa-trash-alt"></i>
                                                        </button>
                                                    </th>
                                                </tr>`;
                                    }
                                    $("#fetchdata1").html(text);
                                    $('#dataTable').DataTable({
                                        dom: '<"row"<"col-sm-6"B>>' +
                                            '<"row"<"col-sm-6 mar"l><"col-sm-6 mar"f>>' +
                                            '<"row"<"col-sm-12"tr>>' +
                                            '<"row"<"col-sm-5"i><"col-sm-7"p>>',
                                        buttons: [{
                                                extend: 'excel',
                                                title: 'รายละเอียดระบบการให้น้ำ / แปลง',
                                                text: '<i class="fas fa-file-excel"> <font> Excel</font> </i>',
                                                className: 'btn btn-outline-success btn-sm export-button'
                                            },
                                            {
                                                extend: 'pdf',
                                                title: 'รายละเอียดระบบการให้น้ำ / แปลง',
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
                            xhttp.open("POST", "./loadWatering.php", true);
                            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                            xhttp.send(`ID=${rid}`);
                        }
                    });
                } else {
                    swal("ยกเลิกการดำเนินการลบ !!");
                }
            });
    });
</script>