<?php
include_once("./../../dbConnect.php");

function creatCard( $styleC, $headC, $textC, $iconC ) { 
    echo "<div class='col-xl-3 col-12 mb-4'>
        <div class='card border-left-primary $styleC shadow h-100 py-2'>
            <div class='card-body'>
                <div class='row no-gutters align-items-center'>
                    <div class='col mr-2'>
                        <div class='font-weight-bold  text-uppercase mb-1'>$headC</div>
                        <div class='h5 mb-0 font-weight-bold text-gray-800'>$textC</div>
                    </div>
                    <div class='col-auto'>
                        <i class='material-icons icon-big'>$iconC</i>
                    </div>
                </div>
            </div>
        </div>
    </div>";
}

function createForm($text,$class,$name)
{
    echo " <div class='row mb-4'>
                <div class='col-xl-3 col-12 text-right'>
                    <span>$text</span>
                        <span class='text-danger'> *</span>
                </div>
                <div class='col-xl-8 col-12'>";
                    switch($class)
                    {
                        case "js-example-basic-single":
                            echo "<select class='js-example-basic-single' id= $name name= $name>
                                  </select>";
                        break;
                        case "form-control vol":
                            echo " <input placeholder= $text type='text' class='form-control vol' id= $name name=$name onblur='checkInvalidNum()' value=''>

                            </input>";
                        break;
                        default:
                            echo "<input class= $class width='auto' id= $name name= $name />";
                        break;
                    }
    echo        "</div>
            </div>";
}

function createPhoto()
{
    echo "  <div class='row mb-4'>
                <div class='col-xl-3 col-12 text-right'>
                    <span>รูปภาพ</span>
                </div>
                <div class='col-xl-9 col-12'>
                    <div class='grid-img-multiple' id='p_insert_img'>

                    </div>
                 </div>
            </div>
            <input type='hidden' name='pestAlarmID' id='pestAlarmID' value='0' />";
}

function createCropImg()
{
    echo "      <div class='crop-img'>
                <center>
                    <div id='upload-demo' class='center-block'></div>
                </center>
                </div>
                <input type='hidden' id='hidden_id' name='photo' value='insert' />";
}

function createFertilizingTable()
{
    echo "<table id='example' class='table table-bordered table-striped table-hover table-data' width='100%'>

    <thead style='text-align:center;'>
        <tr>
            <th rowspan='2'>ชื่อเกษตรกร</th>
            <th rowspan='2'>ชื่อสวน</th>
            <th rowspan='2'>จำนวนแปลง</th>
            <th rowspan='2'>พื้นที่ปลูก (ไร่)</th>
            <th rowspan='2'>จำนวนต้น</th>
            <th rowspan='2'>ชนิดปุ๋ย</th>
            <th class='getYear'>ผลผลิตปี"; echo getYear("back"); echo"</th> <!-- พ.ศ.ปีที่ผ่านมา  -->
            <th colspan='3'>ปริมาณปุ๋ย(ก.ก.)</th>
            <th rowspan='2'>รายละเอียด</th>
        </tr>
        <tr>
            <th>(ก.ก./ไร่)</th>
            <th>ที่ควรใส่</th>
            <th>ที่ใส่</th>
            <th>ที่ควรใส่เพิ่ม</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th>ชื่อเกษตรกร</th>
            <th>ชื่อสวน</th>
            <th>จำนวนแปลง</th>
            <th>พื้นที่ปลูก <br>(ไร่)</th>
            <th>จำนวนต้น</th>
            <th>ชนิดปุ๋ย</th>
            <th class='getYear'>ผลผลิตปี"; echo getYear("back"); echo"</th>
            <th>ปริมาณปุ๋ยที่ควรใส่</th>
            <th>ปริมาณปุ๋ยที่ใส่</th>
            <th>ปริมาณที่ควรใส่เพิ่ม</th>
            <th>รายละเอียด</th>
        </tr>
    </tfoot>

    <!-- Loop fet data -->
    <tbody id='fetchDatatable1'>

    </tbody>
    <!-- Loop fet data -->

</table>";

}

/*function creatAdvanceSearch()
{
    echo "<div class='col-xl-6 col-12'>
            <div id='map' style='width:auto; height:75vh;'></div>
        </div>
<div class='col-xl-6 col-12' id='forMap'>
    <div class='row'>
        <div class='col-12'>
            <span>ปี</span>
        </div>
    </div>
    <div class='row mb-2'>
        <div class='col-12'>
            <select id='year' class='form-control'>";
                    getYear("all");
        echo "/select>";
        echo "</div>
    </div>
    <div class='row'>
        <div class='col-xl-12 col-12'>
            <div class='irs-demo'>
                <b>ปริมาณการใส่ปุ๋ย (%)</b>
                <input type='text' id='palmvolsilder' value=' />
            </div>
        </div>
    </div>

    <div class='row'>
        <div class='col-12'>
            <span>จังหวัด</span>
        </div>
    </div>
    <div class='row mb-2'>
        <div class='col-12'>
            <select id='province' class='js-example-basic-single'>
                <option disabled selected>เลือกจังหวัด</option>
            </select>
        </div>
    </div>
    <div class='row'>
        <div class='col-12'>
            <span>อำเภอ</span>
        </div>
    </div>
    <div class='row mb-2'>
        <div class='col-12'>
            <select id='amp' class='js-example-basic-single'>
                <option disabled selected>เลือกอำเภอ</option>
            </select>
        </div>
    </div>

    <div class='row'>
        <div class='col-12'>
            <span>ชื่อเกษตรกร</span>
        </div>
    </div>
    <div class='row mb-2'>
        <div class='col-12'>
            <input type='text' class='form-control' id='name'>
        </div>
    </div>
    <div class='row'>
        <div class='col-12'>
            <span>หมายเลขบัตรประชาชน</span>
        </div>
    </div>
    <div class='row mb-2'>
        <div class='col-12'>
            <input type='password' class='form-control input-setting' id='idcard'>
            <i class='far fa-eye-slash eye-setting'></i>
        </div>
    </div>
    <div class='row mb-2 padding'>
        <div class='col-12'>
            <button type='button' id='btn_search' class='btn btn-success btn-sm form-control'>ค้นหา</button>
        </div>
    </div>
</div>";
}*/

function getCountFertilising()
{
    $sql = "SELECT SUM(`log-fertilising`.`Vol`) AS sumFertilising FROM `log-fertilising`
    INNER JOIN `dim-time`ON `dim-time`.`ID` = `log-fertilising`.`DIMdateID`
    WHERE  `log-fertilising`.`isDelete` = 0";
    $sumFertilizing = selectDataOne($sql);
    return  number_format($sumFertilizing['sumFertilising']);
}

function getYear($period)
{
    switch($period)
    {
        case "current":
            return $year = date("Y") + 543;
        break;
        case "back":
            return $year = date("Y") + 543 - 1;
        break;
        case "all":
            $totalYear = selectData("SELECT `dim-time`.`Year2` FROM `log-fertilising`
                        INNER JOIN `dim-time`ON `dim-time`.`ID` = `log-fertilising`.`DIMdateID`
                        WHERE `log-fertilising`.`isDelete`= 0 
                        GROUP BY `dim-time`.`Year2` 
                        ORDER BY `dim-time`.`Year2` DESC");
            for ($i = 1; $i <= $totalYear[0]['numrow']; $i++) {
                echo "<option value='{$totalYear[$i]['Year2']}'>{$totalYear[$i]['Year2']}</option>";
            }
        break;
    }

}

function getSumHarvest()
{
    $sql = "SELECT SUM(`fact-farming`.`HarvestVol`) AS sumHarvest FROM `fact-farming` 
    INNER JOIN `dim-time` ON `dim-time`.`ID` = `fact-farming`.`DIMdateID` 
    WHERE `dim-time`.`Year2` = YEAR(CURDATE())+543-1 AND `fact-farming`.`isDelete` = 0 AND `fact-farming`.`DIMsubFID` IS NULL";
    $sumHarvest = selectDataOne($sql);
    return number_format($sumHarvest['sumHarvest']);
}

function getTotalArea()
{
    $sql = "SELECT SUM(`db-subfarm`.`AreaRai`) AS totalArea FROM `db-subfarm`WHERE 1";
    $totalArea = selectDataOne($sql);
    return number_format($totalArea['totalArea']);
}

function getTotalPalm()
{
    $sql = "SELECT (SUM(`log-planting`.`NumGrowth1`)+SUM(`log-planting`.`NumGrowth2`))-SUM(`log-planting`.`NumDead`) AS totalPalm FROM `log-planting` 
    WHERE `log-planting`.`isDelete` = 0";
    $totalPalm = selectDataOne($sql);
    return number_format($totalPalm['totalPalm']);
}
