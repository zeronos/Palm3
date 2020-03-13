<?php
    session_start();
    $idUT = $_SESSION[md5('typeid')];
    $CurrentMenu = "CutBranch";
?>

<?php
    include_once("../layout/LayoutHeader.php");
    require_once("../../dbConnect.php");
    $name = $_GET['name'];
    $nfarm = $_GET['nfarm'];
    $nsf = $_GET['nsf'];
    $Year2 = $_GET['Year2'];

    $data = selectData("SELECT  `db-farm`.`Name`,`db-subfarm`.`Name` AS nsf,`dim-time`.`Date` AS date2
        FROM `log-activity` 
        INNER JOIN `dim-user` ON `dim-user`.`ID` = `log-activity`.`DIMownerID`
        INNER JOIN `dim-farm` ON `dim-farm`.`ID` = `log-activity`.`DIMsubFID`
        INNER JOIN `db-subfarm` ON `db-subfarm`.`FSID` = `dim-farm`.`dbID` 
        INNER JOIN `db-farm` ON `db-farm`.`FMID` = `db-subfarm`.`FMID`
        INNER JOIN `dim-time` ON `dim-time`.`ID` =  `log-activity`.`DIMdateID`
        WHERE `log-activity`.`isDelete` = 0 AND `dim-time`.`Year2` = '$Year2' AND `db-farm`.`Name` = '$nfarm'
        GROUP BY nsf
        ORDER BY date2 DESC ");

    //echo $nfarm."  ".$Year2;
    // print_r($data);

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
    <div class="row">
        <div class="col-xl-12 col-12 mb-4">
            <div class="card">
                <div class="card-header card-bg">
                    <div class="row">
                        <div class="col-12">
                            <span class="link-active">รายละเอียดการล้างคอขวด</span>
                            <span style="float:right;">
                                <i class="fas fa-bookmark"></i>
                                <a class="link-path" href="#">หน้าแรก</a>
                                <span> > </span>
                                <a class="link-path" href="#">ล้างคอขวด</a>
                                <span> > </span>
                                <a class="link-path link-active" href="#">รายละเอียดการล้างคอขวด</a>
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
                <div class="card-body">
                    <div class="row">
                        <img class="img-radius img-profile" src="../../icon/farm/1/FM1.png">
                        <!-- <img class="img-radius" style="box-shadow: 2px 4px 10px #888888;" width="125px" height="125px" src="../../picture/default.jpg" /> -->
                    </div>
                    <div class="row mt-3 justify-content-center">
                        <div class="col-xl-3 col-3 text-right">
                            <span>ชื่อสวน : </span>
                        </div>
                        <div class="col-xl-3 col-3">
                            <span><?= $nfarm ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <img class="img-radius img-profile" src="../../icon/farmer/1/F1.png">
                        <!-- <img class="img-radius" style="box-shadow: 2px 4px 10px #888888;" width="125px" height="125px" src="../../picture/default.jpg" /> -->
                    </div>
                    <div class="row mt-3 justify-content-center">
                        <div class="col-xl-5 col-3 text-right">
                            <span>เกษตรกร : </span>
                        </div>
                        <div class="col-xl-4 col-3">
                            <span><?= $name ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-xl-12 col-12">
            <div class="card">
                <div class="card-header card-bg">
                    <div>
                        <span>การล้างคอขวดปาล์มน้ำมันในระบบ</span>
                        <!-- <span style="float:right;" class="getSelectYear">ปี <?php echo $currentYear; ?></span> -->
                        <button type="button" id="btn-modal4" style="float:right;" class="btn btn-success" data-toggle="modal" data-target="#modal-4"><i class="fas fa-plus"></i> เพิ่มการล้างคอขวด</button>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">ปฏิทินข้อมูล</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">ตารางข้อมูล</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent" style="margin-top:20px;">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <div class="row">
                                <div id='calendar' style="        
                                    margin: 0 auto;
                                    width: 100%;
                                    background-color: #FFFFFF;">
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <!-- <div class="row mb-2">
                                <div class="col-xl-3 col-12">
                                    <button type="button" id="btn_comfirm" class="btn btn-outline-success btn-sm"><i class="fas fa-file-excel"></i> Excel</button>
                                    <button type="button" id="btn_comfirm" class="btn btn-outline-danger btn-sm"><i class="fas fa-file-pdf"></i> PDF</button>
                                </div>
                            </div> -->
                            
                            <div class="table-responsive">
                                <table id="example" class="table table-bordered table-striped table-hover table-data" width="100%">
                                    <thead>
                                        <tr>
                                            <th>ชื่อแปลง</th>
                                            <th>วันที่</th>
                                            <th>จัดการ</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>ชื่อแปลง</th>
                                            <th>วันที่</th>
                                            <th>จัดการ</th>
                                        </tr>
                                    </tfoot>
                                    <tbody id="fetchDatatable2">
                                        <!-- <tr>
                                            <td>ไลอ้อน 1</td>
                                            <td>19/05/1996</td>
                                            <td style="text-align:center;">
                                                <button type="button" id="btn_image" class="btn btn-success btn-sm"><i class="far fa-images"></i></button>
                                                <button type="button" id="btn_delete" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></button>
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
    </div>

    <!--------------  Modal ADD ------------->
    <div class="modal fade" id="modal-4" role="dialog">
        <form method="post" enctype="multipart/form-data" id="form">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header header-modal">
                        <h4 class="modal-title">เพิ่มการล้างคอขวด</h4>
                    </div>
                    <div class="modal-body">
                        <div class="main">
                            <div class="row mb-4">
                                <div class="col-xl-3 col-12 text-right">
                                    <span>วันที่</span>
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
                                </div>
                                <div class="col-xl-8 col-12">
                                    <select class="js-example-basic-single" id="p_subfarm" name="p_subfarm">

                                    </select>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-xl-3 col-12 text-right">
                                    <span>หมายเหตุ</span>
                                </div>
                                <div class="col-xl-8 col-12">
                                    <!-- <input name="note" id="note" class="form-control"  cols="" rows=""></input> -->
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
                    <h4 class="modal-title">รูปภาพการล้างคอขวด</h4>
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
                    <h4 class="modal-title">ข้อมูลของการล้างคอขวด</h4>
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

<!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDwVxLnsuNM9mJUqDFkj6r7FSxVcQCh4ic&callback=map_create" async defer></script> -->
<script src="CutBranchJS/CutBranch.js"></script>
<script src="CutBranchJS/CutBranchModal.js"></script> 
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

        //date for modal
        $('#p_date').datepicker({
            showOtherMonths: true,
            format: 'yyyy-mm-dd'
        });

        $('#e_p_date').datepicker({
            showOtherMonths: true,
            format: 'yyyy-mm-dd'
        });

        // $('#example').DataTable({
        //     dom: '<"row"<"col-sm-6"B>>' +
        //         '<"row"<"col-sm-6 mar"l><"col-sm-6 mar"f>>' +
        //         '<"row"<"col-sm-12"tr>>' +
        //         '<"row"<"col-sm-5"i><"col-sm-7"p>>',
        //     buttons: [{
        //             extend: 'excel',
        //             text: '<i class="fas fa-file-excel"> <font> Excel</font> </i>',
        //             className: 'btn btn-outline-success btn-sm export-button'
        //         },
        //         {
        //             extend: 'pdf',
        //             text: '<i class="fas fa-file-pdf"> <font> PDF</font> </i>',
        //             className: 'btn btn-outline-danger btn-sm export-button',
        //             pageSize: 'A4',
        //             customize: function(doc) {
        //                 doc.defaultStyle = {
        //                     font: 'THSarabun',
        //                     fontSize: 16
        //                 };
        //             }
        //         }
        //     ]
        // });


    });


    let event = getByEvent();
    var calendar = $('#calendar').fullCalendar({
        header: {
            left: 'title',
            center: 'agendaDay,agendaWeek,month',
            right: 'prev,next today'
        },
        firstDay: 0, //  1(Monday) this can be changed to 0(Sunday) for the USA system
        selectable: true,
        defaultView: 'month',

        axisFormat: 'h:mm',
        columnFormat: {
            month: 'ddd', // Mon
            week: 'ddd d', // Mon 7
            day: 'dddd M/d', // Monday 9/7
            agendaDay: 'dddd d'
        },
        titleFormat: {
            month: 'MMMM yyyy', // September 2009
            week: "MMMM yyyy", // September 2009
            day: 'MMMM yyyy' // Tuesday, Sep 8, 2009
        },
        allDaySlot: false,
        selectHelper: true,

        events: event,

        eventClick: function(info) {

            let getModal;

            getModal = SubImageModalTemp("ไลอ้อน 2");

            $("body").append(getModal);
            $("#CutImageModal").modal('show');

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
        //$('#p_farm').val(-1).trigger('change').html("<option disabled selected>เลือกสวน</option>");
        $('#p_subfarm').html("<option disabled selected>เลือกแปลง</option>");
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

    $("#btn_image").click(function() {
        console.log("testdffe");
        $("body").append(imageModal);
        $("#imageModal").modal('show');
    });

    $("#btn_sub_image").click(function() {
        let getModal;
        getModal = SubImageModalTemp("ไลอ้อน 2");

        $("body").append(getModal);
        $("#CutImageModal").modal('show');
    });

    let data;
    //ข้อมูลในตาราง จากการค้นหา
    let Year2 = "<?php echo $Year2 ?>";
    let nfarm = "<?php echo $nfarm ?>";
    loadData()
    function loadData() {
        $('#example').DataTable().destroy();
        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                data = JSON.parse(this.responseText);
                //console.log(data)
                // console.log(ID_Province)
                // console.log(ID_Distrinct)
                // console.log(name)
                // console.log(passport)
                // console.log(this.responseText)
                let text = "";
                for (i in data) {
                    text += ` <tr>
                            <td class="text-left">${data[i].nsf}</td>
                            <td class="text-right">${data[i].date2}</td>
                            <td style="text-align:center;">

                                <button type="button" id= 'btn_edit' Pid='' class="btn btn-warning btn-sm btn-edit" data-toggle="modal" data-target="#modal-4"><i class="fas fa-edit"></i></button>          
                                <button type="button" id='btn_note' Pid='' class="btn btn-primary btn-sm btn-note" data-toggle="modal" data-target="#modal-3"><i class="far fa-sticky-note"></i></button>
                                <button type="button" id='btn_img' Pid='' class="btn btn-info btn-sm btn-photo" data-toggle="modal" data-target="#modal-2"><i class="far fa-images"></i></button>

                                <button type="button" id='btn_detlete' Pid='' class="btn btn-danger btn-sm btn-delete"><i class="far fa-trash-alt"></i></button>
                            </td>
                        </tr>`
                }
                $("#fetchDatatable2").html(text);
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
            }
        };
        xhttp.open("POST", "./loadcutbranch2.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send(`name=${nfarm}&Year2=${Year2}`);
    }

    // ---- delete ---- 

    // function delete_data(id, name_subfarm) {
    //     swal({
    //             title: "คุณต้องการลบ",
    //             text: name_subfarm+" หรือไม่",
    //             icon: "warning",
    //             buttons:{
    //                 confirm:"ยืนยัน",
    //                 cancel:"ยกเลิก"
    //             },
    //             buttons: true,
    //             dangerMode: true,
    //         })
    //         .then((willDelete) => {
    //             if (willDelete) {
    //                 swal("ดำเนินการลบสำเร็จ!!", {
    //                     icon: "success",
    //                 });
    //             } else {
    //                 swal("ยกเลิกการดำเนินการลบ !!");
    //             }
    //         });
    // }

    // $("#btn_delete").click(function() {
    //     swal({
    //             title: "คุณต้องการลบ",
    //             text: name_subfarm+" หรือไม่",
    //             icon: "warning",
    //             buttons:{
    //                 confirm:"ยืนยัน",
    //                 cancel:"ยกเลิก"
    //             },
    //             buttons: true,
    //             dangerMode: true,
    //         })
    //         .then((willDelete) => {
    //             if (willDelete) {
    //                 swal("ดำเนินการลบสำเร็จ!!", {
    //                     icon: "success",
    //                 });
    //             } else {
    //                 swal("ยกเลิกการดำเนินการลบ !!");
    //             }
    //         });
    // });

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


</script>