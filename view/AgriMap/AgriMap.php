<?php
session_start();
$idUT = $_SESSION[md5('typeid')];
$CurrentMenu = "AgriMap";
?>

<?php
include('connect_db.php');
$default = array("lat" => 0.0, "lng" => 0.0);
//print_r ($default);
$coordinate = array(
    array("lat" => 0.0, "lng" => 0.0),
    array("lat" => 0.0, "lng" => 0.0),
    array("lat" => 0.0, "lng" => 0.0),
    array("lat" => 0.0, "lng" => 0.0),
);
$i = 0;
//print_r ($coordinate[1]['lng']);
$sql = "SELECT * FROM `db-coorfarm`";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {

    while ($i < sizeof($coordinate)) {
        $coordinate[$i]['lat'] = $row['Latitude'];
        $coordinate[$i]['lng'] = $row['Longitude'];
        $i++;
        break;
    }
}

$sql_province = "SELECT * FROM `db-province`";
$result_province = $conn->query($sql_province);

$sql_year = "SELECT DISTINCT(`TagetYear`) FROM `fact-fertilizer` ORDER BY `fact-fertilizer`.`TagetYear` DESC";
$result_year = $conn->query($sql_year);


//print_r($coordinate);


//print_r($lat);
//print_r($lng);
?>



<?php include_once("../layout/LayoutHeader.php"); ?>

<style>
    #map {
        width: 100%;
        height: 600px;
    }

    #find {
        max-width: 500px;
    }
</style>

<div class="container">
    <div class="row">
        <div class="col-xl-12 col-12 mb-6">
            <div class="card">
                <div class="card-header card-bg" style="background-color: #E91E63; color: white;">
                    <i class="fas fa-search"> ค้นหาขั้นสูง</i>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 mb-2">
            <div class="card">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="card-body">
                            <br>
                            <div class="row mb-2">
                                <div class="col-12">
                                    <span>ปีที่จัดการสวน</span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <select id="year" class="form-control selectpicker" data-live-search="true" title="กรุณาเลือกปี">
                                        <?php while ($row = $result_year->fetch_assoc()) { ?>
                                            <option value='<?php echo $row['TagetYear']; ?>'> <?php echo $row['TagetYear'] + 543; ?> </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-12">
                                    <span>จังหวัด</span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <select id="province" class="form-control selectpicker" data-live-search="true" title="กรุณาเลือกจังหวัด">
                                        <option value="" hidden>กรุณาเลือกจังหวัด</option>
                                        <option value=0>ทั้งหมด</option>
                                        <?php while ($row = $result_province->fetch_assoc()) { ?>
                                            <option value='<?php echo $row['AD1ID']; ?>'> <?php echo $row['Province']; ?> </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-12">
                                    <span>อำเภอ</span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <select id="distrinct" class="form-control selectpicker" data-live-search="true" title="กรุณาเลือกอำเภอ">
                                        <option value="" hidden>กรุณาเลือกอำเภอ</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="card-body">
                        <br>
                            <div class="row mb-2">
                                <div class="col-12">
                                    <span>ชื่อเกษตรกร</span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <input type="text" class="form-control" id="farmer">
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-12">
                                    <input type="checkbox" name="check" id="check1">
                                    <span>ผลผลิต</span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <select id="product" class="form-control" disabled>
                                        <option value=0 selected>ทั้งหมด</option>
                                        <option value=1>เกินค่าเฉลี่ย</option>
                                        <option value=2>ไม่เกินค่าเฉลี่ย</option>
                                        <option value=3>ไม่มีผลผลิต</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-12">
                                    <input type="checkbox" name="check2" id="check2">
                                    <span>ใส่ปุ๋ย</span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <select id="fertilizer" class="form-control" disabled>
                                        <option value=0 selected>ทั้งหมด</option>
                                        <option value=1>ใส่ครบ</option>
                                        <option value=2>ใส่ไม่ครบ</option>
                                        <option value=3>ไม่ใส่</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-12">
                                    <input type="checkbox" name="check3" id="check3">
                                    <span>ให้น้ำ (วัน)</span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <input type="text" id="water" value="" />
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-12">
                                    <input type="checkbox" name="check4" id="check4">
                                    <span>ขาดน้ำ (วัน)</span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <input type="text" id="waterlack" value="" />
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-12">
                                    <input type="checkbox" name="check5" id="check5">
                                    <span>ล้างคอขวด (ครั้ง)</span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <input type="text" id="wash" value="" />
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-12">
                                    <input type="checkbox" name="check6" id="check6">
                                    <span>ศัตรูพืช</span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <select id="pest" class="form-control" disabled>
                                        <option value=0>ไม่พบ</option>
                                        <option value=1 selected>ทั้งหมด</option>
                                        <option value=2>แมลง</option>
                                        <option value=3>โรคพืช</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
               
                    <div class="col-12">
                        <div class="card-footer">
                            <button type="button" id="search" class="btn" style="background-color:#E91E63; color:white;margin-left:40%; height:50px;width:100px;">ค้นหา <i class="fas fa-search"></i> </button>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>

<div class="col-12 mb-2">
    <div class="card">
        <div class="card-header card-bg">
            ตำแหน่งสวนปาล์ม
        </div>
        <div class="card-body">
            <div class="col-12 mb-2">
                <div>
                    <div id="map"></div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<?php include_once("../layout/LayoutFooter.php"); ?>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBMLhtSzox02ZCq2p9IIuihhMv5WS2isyo&callback=initMap&language=th" async defer></script>


<script>
    $(document).ready(function() {
        $(document).on('change', '#province', function() {
            $.ajax({
                url: 'search_distrinct.php',
                data: "province=" + $('#province').val(),
                type: "POST",
                async: false,
                success: function(data) {
                    //alert(data);
                    $('#distrinct').html(data);
                    //$('#distrinct').selectpicker('refresh');
                },
                error: function(xhr, status, exception) {
                    alert(status);

                }
            });
        });

        $("#search").click(function() {
            $.ajax({
                url: 'search_map.php',
                data: {
                    "distrinct": $('#distrinct').val(),
                    "fertilizer": $('#fertilizer').val(),

                    "product": $('#product').val(),
                    "year": $('#year').val()
                },
                type: "POST",
                async: false,
                success: function(data) {
                    //alert(data);
                    initMap(data);
                },
                error: function(xhr, status, exception) {
                    alert(status);
                }
            })
        });

    });
</script>

<script>
    function initMap(data) {
        //The location of Uluru
        if (data) {

            var th = {
                lat: 15.8700,
                lng: 100.9925
            };

            var map = new google.maps.Map(
                document.getElementById('map'), {
                    zoom: 4,
                    center: th
                });

            var location = JSON.parse(data);

            var marker, i, info;

            //console.log("dododod");



            for (i = 0; i < location.length; i++) {
                console.log(location[i].name, location[i].lat, location[i].lng);
                marker = new google.maps.Marker({
                    position: new google.maps.LatLng(location[i].lat, location[i].lng),
                    title: location[i].name,
                    map: map
                });

                info = new google.maps.InfoWindow();
                google.maps.event.addListener(marker, 'click', (function(marker, i) {
                    return function() {
                        info.setContent(location[i].name + "<br/>" + location[i].address + "<br/>" + "ปริมาณผลผลิต " + location[i].product + " กิโลกรัม" + "<br/>" + '<a href = "../OilPalmAreaVol/OilPalmAreaVol.php">เพิ่มเติม</a>');
                        info.open(map, marker);
                    }
                })(marker, i));

            }

        } else {
            var th = {
                lat: 15.8700,
                lng: 100.9925
            };
            // The map, centered at Uluru
            var map = new google.maps.Map(
                document.getElementById('map'), {
                    zoom: 4,
                    center: th
                });
            // The marker, positioned at Uluru
        }

        //location.length=0;
    }

    $("#check1").click(function() {
        $("#product").attr("disabled", !this.checked);
    });

    $("#check2").click(function() {
        $("#fertilizer").attr("disabled", !this.checked);
    });

    $("#check3").change(function() {
        $("#water").data("ionRangeSlider").update({
            "disable": !$(this).is(':checked')
        });
    });

    $("#check4").change(function() {
        $("#waterlack").data("ionRangeSlider").update({
            "disable": !$(this).is(':checked')
        });
    });

    $("#check5").change(function() {
        $("#wash").data("ionRangeSlider").update({
            "disable": !$(this).is(':checked')
        });
    });

    $("#check6").click(function() {
        $("#pest").attr("disabled", !this.checked);
    });


    $("#water").ionRangeSlider({
        type: "double",
        from: 1,
        to: 1,
        step: 1,
        min: 0,
        max: 365,
        grid: true,
        grid_num: 5,
        grid_snap: false,
        disable: true,
        postfix: " วัน",
        onFinish: function(data) {
            console.log(data.to + " " + data.from);
        }
    });
    $("#waterlack").ionRangeSlider({
        type: "double",
        from: 1,
        to: 5,
        step: 1,
        min: 0,
        max: 60,
        grid: true,
        grid_num: 10,
        grid_snap: false,
        disable: true,
        postfix: " วัน",
        onFinish: function(data) {
            console.log(data.to + " " + data.from);
        }
    });
    $("#wash").ionRangeSlider({
        type: "double",
        from: 1,
        to: 5,
        step: 1,
        min: 0,
        max: 30,
        grid: true,
        grid_num: 5,
        grid_snap: false,
        disable: true,
        postfix: " ครั้ง",
        onFinish: function(data) {
            console.log(data.to + " " + data.from);
        }
    });
</script>
