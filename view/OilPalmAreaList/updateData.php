<?php
require_once("../../dbConnect.php");
require_once("../../set-log-login.php");
session_start();

// ค่า ID ของสวนจาก DB 
   $fmid =  $_POST['fmid'];
   echo "fmid[".$fmid."]";
// ค่า ID[logid] จากของเอาไปว่าใครเข้ามาใช่งาน
   $logid =  $_POST['logid'];
   echo "logid[".$logid."]";
// ซื่อ แปลง
   $namefarm = $_POST['namefarm'];
   echo "namefarm[".$namefarm."]";
// ชื่อย่อ แปลง
   $initials = $_POST['initials'];
   echo "initials[".$initials."]";
// จำนวน ไร่
   $farm = $_POST['farm'];
   echo "farm[".$farm."]";
// จำนวน งาน
   $work = $_POST['work'];
   echo "work[".$work."]";
// จำนวน วา
   $wah = $_POST['wah'];
   echo "wah[".$wah."]";
// จำนวนรวมของพิ้นที่
    $sum = (($farm * 400) + ($work * 100) + $wah);
    echo "sum[".$sum."]";
// จังหวัด
   $province = $_POST['province'];
   echo "province[".$province."]";
// อำเภอ
   $amphur = $_POST['amphur'];
   echo "amphur[".$amphur."]";
// ตำบล
   $subdistrinct = $_POST['subdistrinct'];
   echo "subdistrinct[".$subdistrinct."]";
// ดึงค่า ID ของแปลงมา
    $suid = $_POST['suid'];
    echo "suid[".$suid."]";
   
    // เวลาเริ่มต้น
    $StartT =  time();
    date_default_timezone_set('Asia/Bangkok');
    $Stime = date("Y-m-d", $StartT);
    $sql = "SELECT * FROM `dim-time` WHERE `Date` = '$Stime'";
    $StartID = selectData($sql);

    // เวลาสุดท้าย ใช้ในตอนลบ
    $EndT = time();
    date_default_timezone_set('Asia/Bangkok');
    $Endtime = date("Y-m-d", $EndT);
    $sql = "SELECT * FROM `dim-time` WHERE `Date` = '$Endtime'";
    $EndID = selectData($sql);

    // เวลาที่เอาไปเพิ่มไน DB
    $ModifyDT = date("Y-m-d H:i:s" ,$StartT);
    echo "ModifyDT[".$ModifyDT."]";

    // ดึงตำแหน่งจากตำบน
    $sql = "SELECT * FROM `db-subdistrinct` WHERE AD3ID='$subdistrinct'";
    $dataAddress = selectData($sql);

    // ค่า Latitude Longitude
    echo "Latitude[".$dataAddress[1]['Latitude']."]";
    echo "Longitude[".$dataAddress[1]['Longitude']."]";


    // ค่าเก่าของ แปลงก่อนการเปลี่ยน
    $sql = "SELECT * FROM `db-subfarm` WHERE `FSID` = '$suid'";
    $dataSubfarm_o = selectData($sql);
    echo "FSIDName[".$dataSubfarm_o[1]['Name']."]";
    echo "FSIDAlias[".$dataSubfarm_o[1]['Alias']."]";

    // เก็บข้อมูลเข้า DB  *********************************************
    // $sql = "INSERT INTO `db-subfarm` (`FSID`, `Name`, `Alias`, `Icon`, `AD3ID`, `FMID`, `IsCoordinate`, `Latitude`, `Longitude`, `AreaRai`, `AreaNgan`, `AreaWa`, `AreaTotal`, `ModifyDT`) 
    // VALUES (NULL, '$namefarm', '$initials', '', '$subdistrinct', '$fmid', '0', '{$dataAddress[1]['Latitude']}', '{$dataAddress[1]['Longitude']}', '$farm', '$work', '$wah', '$sum', '$ModifyDT')";

    $sql ="UPDATE `db-subfarm` SET `Name` = '$namefarm', `Alias` = '$initials', `AD3ID` = '$subdistrinct', 
    `Latitude` = '{$dataAddress[1]['Latitude']}', `Longitude` = '{$dataAddress[1]['Longitude']}', `AreaRai` = '$farm', `AreaNgan` = '$work', `AreaWa` = '$wah', `AreaTotal` = '$sum', `ModifyDT` = '$ModifyDT' 
    WHERE `db-subfarm`.`FSID` = '$suid'";
    addinsertData($sql);

    // ดึงค่า FSID จาก db-subfarm
    $sql = "SELECT * FROM `db-subfarm` WHERE `Name` ='$namefarm' AND `Alias`= '$initials'AND `ModifyDT`='$ModifyDT'";
    $dataSubfarm = selectData($sql);
    echo "FSID[".$dataSubfarm[1]['FSID']."]";

    // เก็บข้อมูลเข้า dim *********************************************
    $sql = "INSERT INTO `dim-farm` (`ID`, `IsFarm`, `dbID`, `Name`, `Alias`) VALUES (NULL, '0', '{$dataSubfarm[1]['FSID']}', '$namefarm', '$initials')";
    addinsertData($sql);

    // ID ของเจ้าของสวน แต่มีข้อมูลของสวนมาด้วย ดูใน db-farm
    $sql ="SELECT * FROM `db-farm` WHERE `FMID`= $fmid";
    $datafarm = selectData($sql);
    echo "FSID[".$datafarm[1]['FMID']."]";
    

    // หาค่า DIMFarmer หรือ DIMownerID ใน log-farm ในส่วนของแปลง
    $DIMownerID = getDIMFarmer($datafarm[1]['FMID']);
    echo "DIMownerID[".$DIMownerID[1]['ID']."]";

    // หาค่า DIMFarm หรือ DIMfarmID ใน log-farm ในส่วนของแปลง
    $DIMfarmID = getDIMFarm($fmid);
    echo "DIMfarmID[".$DIMfarmID[1]['ID']."]";

    // ดึงค่า DIMSubfID จาก db-farm แต่เป็นค่าของแปลง
    $sql = "SELECT * FROM `dim-farm` WHERE `IsFarm`= '0' AND `dbID`='{$dataSubfarm[1]['FSID']}' AND `Name` = '$namefarm' AND `Alias`='$initials'";
    $DIMSubfID = selectData($sql);
    echo "DIMSubfID[".$DIMSubfID[1]['ID']."]";

    // ดึงค่า DIMaddrID เอาไว้ใส่ใน log-farm ที่อยู่
    $DIMaddrID = getDIMAddr($subdistrinct,$datafarm[1]['Address']);
    echo "DIMaddrID[".$DIMaddrID[1]['ID']."]";

    // ค่าของ IsCoordinate
    echo "IsCoordinate[".$datafarm[1]['IsCoordinate']."]";

    

   // ข้อมูล เก่าก่อนการแก้ไข
    $sql = "SELECT * FROM `dim-farm` WHERE `IsFarm`= '0' AND `dbID`='$suid' AND `Name` = '{$dataSubfarm_o[1]['Name']}' AND `Alias`='{$dataSubfarm_o[1]['Alias']}'";
    echo $sql . "<br/>";
    // $sql = "SELECT * FROM `log-farm` WHERE ISNULL(`EndT`) AND ISNULL(`EndID`) AND `DIMSubfID`= AND `DIMownerID` = '{$DIMownerID[1]['ID']}' AND `DIMfarmID` = '{$DIMfarmID[1]['ID']}'";
    $DIMSubfID_o = selectData($sql);
    echo "DIMSubfID_o[".$DIMSubfID_o[1]['ID']."]";



   // ทำการปิด log-farm เก่ง
   $sql ="UPDATE `log-farm` SET `EndT` = '$EndT', `EndID` = '{$EndID[1]['ID']}' WHERE `log-farm`.`DIMSubfID` = '{$DIMSubfID_o[1]['ID']}' AND DIMfarmID = '{$DIMfarmID[1]['ID']}' AND ISNULL(`EndT`) AND ISNULL(`EndID`)";
   echo $sql . "<br/>";
   addinsertData($sql);


    // เพิ่มค่าใน log-farm ในส่วนของแปลง
    $sql = "INSERT INTO `log-farm` (`ID`, `LOGloginID`, `StartT`, `StartID`, `EndT`, `EndID`, `DIMownerID`, `DIMfarmID`, `DIMSubfID`, `DIMaddrID`, `IsCoordinate`, `Latitude`, `Longitude`, `NumSubFarm`, `NumTree`, `AreaRai`, `AreaNgan`, `AreaWa`, `AreaTotal`) 
    VALUES (NULL, '$logid', ' $StartT', '{$StartID[1]['ID']}', NULL, NULL, '{$DIMownerID[1]['ID']}', '{$DIMfarmID[1]['ID']}', '{$DIMSubfID[1]['ID']}', '{$DIMaddrID[1]['ID']}', '{$datafarm[1]['IsCoordinate']}', '{$dataAddress[1]['Latitude']}', '{$dataAddress[1]['Longitude']}', '1', '0', '$farm', '$work', '$wah', '$sum')";
    addinsertData($sql);



    // // ส่วนต่อไปจะเป็น log ของสวน***********************************************************************

       // เอาไว้ดึงค่า log-farm มาทั้งหมด สวน เดิม
       $sql = "SELECT * FROM `log-farm` WHERE ISNULL(`EndT`) AND ISNULL(`EndID`) AND ISNULL(`DIMSubfID`) AND `DIMownerID` = '{$DIMownerID[1]['ID']}' AND `DIMfarmID` = '{$DIMfarmID[1]['ID']}'";
       $LOGfarm = selectData($sql);
       // ค่าจาก log-fram ค่าของ สวน เดิม
       $NumSubFarm = $LOGfarm[1]['NumSubFarm']+1;
       $AreaRai = $LOGfarm[1]['AreaRai']+$farm;
       $AreaNgan = $LOGfarm[1]['AreaNgan']+$work;
       $AreaWa = $LOGfarm[1]['AreaWa']+$wah;
       $AreaTotal = $LOGfarm[1]['AreaTotal']+$sum;
   
       // เพิ่มค่า ใน log-farm
       $sql ="UPDATE `log-farm` SET `NumSubFarm` = '$NumSubFarm', `AreaRai` = '$AreaRai', `AreaNgan` = '$AreaNgan', `AreaWa` = '$AreaWa', `AreaTotal` = '$AreaTotal' WHERE `log-farm`.`ID` = {$LOGfarm[1]['ID']}";
       addinsertData($sql);


    //    กลับหน้าเดิม
    header("location:./OilPalmAreaListSubDetail.php?OilPalmAreaListSubDetail.php?fmid=7&SFID=$suid&nfarm=C&nsubfarm=$namefarm&farmer={$DIMfarmID[1]['ID']}&logid=$logid&numtree=0");

    // fmid=1&SFID=5&nfarm=FARM1&nsubfarm=T1&farmer=โสภณ&logid=10&numtree=0
   





    







    //====================================================================================================================
   

function getDIMFarmer($FID)
{
    $sql = "SELECT * FROM `db-farmer` WHERE UFID = '$FID' ";
    $DataFarmer = selectData($sql);
    $title = "";
    if ($DataFarmer[1]['Title'] == 1) {
        $title = "นาย";
    } else if ($DataFarmer[1]['Title'] == 2) {
        $title = "นาง";
    } else {
        $title = "นางสาว";
    }
    $sql = "SELECT * FROM `dim-user` WHERE`dbID`='$FID' AND `Type`='F' AND `Title`='{$DataFarmer[1]['Title']}'  AND `FullName` ='$title {$DataFarmer[1]['FirstName']} {$DataFarmer[1]['LastName']}' AND `Alias`='{$DataFarmer[1]['FirstName']}' AND `FormalID`='{$DataFarmer[1]['FormalID']}'";
    //echo $sql . "<br/>";
    $DIMFarmer = selectData($sql);
    if ($DIMFarmer[0]['numrow'] == 0) {
        $sql = "INSERT INTO `dim-user` (`ID`, `dbID`, `Type`, `Title`, `FullName`, `Alias`, `FormalID`) VALUES (NULL, '$FID', 'F', '{$DataFarmer[1]['Title']}', '$title {$DataFarmer[1]['FirstName']} {$DataFarmer[1]['LastName']}', '{$DataFarmer[1]['FirstName']}', '{$DataFarmer[1]['FormalID']}');";
        $IDDIMF = addinsertData($sql);
        $sql = "SELECT * FROM `dim-user` WHERE`ID`='$IDDIMF'";
        //echo $sql . "<br/>";
        $DIMFarmer = selectData($sql);
    }
    print_r($DIMFarmer);
    return  $DIMFarmer;
}

function getDIMAddr($AID, $addfarm)
{
    $sql = "SELECT subDistrinct ,Distrinct,Province,`AD3ID`,`db-distrinct`.`AD2ID`,`db-province`.`AD1ID` FROM `db-subdistrinct`INNER JOIN `db-distrinct` ON  `db-subdistrinct`.`AD2ID`=`db-distrinct`.`AD2ID`
    INNER JOIN `db-province` ON `db-distrinct`.`AD1ID`=`db-province`.`AD1ID` WHERE `AD3ID`=$AID";
    $DataFarm = selectData($sql);
    $distrinct = "";
    $subdistrinct = "แขวง";
    if ($DataFarm[1]['AD1ID'] != 1) {
        $distrinct = "อ.";
        $subdistrinct = "ต.";
    }
    $Fulltext = $addfarm . " " . $subdistrinct . $DataFarm[1]['subDistrinct'] . " " . $subdistrinct . $DataFarm[1]['Distrinct'] . " จ." . $DataFarm[1]['Province'];
    $sql = "SELECT * FROM `dim-address` WHERE `FullAddress`='" . $Fulltext . "' ";
    $DIMFarm = selectData($sql);
    if ($DIMFarm[0]['numrow'] == 0) {
        $sql = "INSERT INTO `dim-address` (`ID`, `FullAddress`, `dbsubDID`, `dbDistID`, `dbprovID`, `SubDistrinct`, `Distrinct`, `Province`) VALUES (NULL, '$Fulltext', '{$DataFarm[1]['AD3ID']}', '{$DataFarm[1]['AD2ID']}', '{$DataFarm[1]['AD1ID']}', '{$DataFarm[1]['subDistrinct']}', '{$DataFarm[1]['Distrinct']}', '{$DataFarm[1]['Province']}');";
        $IDDIMF = addinsertData($sql);
        $sql = "SELECT * FROM `dim-address` WHERE`ID`='$IDDIMF'";
        $DIMFarm = selectData($sql);
    }
    return  $DIMFarm;
}
function getDIMFarm($FID)
{
    $sql = "SELECT * FROM `db-farm` WHERE FMID = '$FID' ";
    echo $sql . "<br/>";
    $DataFarm = selectData($sql);
    $sql = "SELECT * FROM `dim-farm` WHERE `IsFarm`='1' AND `dbID`='{$DataFarm[1]['FMID']}' AND `Name` ='{$DataFarm[1]['Name']}' AND `Alias`='{$DataFarm[1]['Alias']}'";
    //echo $sql . "<br/>";
    $DIMFarm = selectData($sql);
    if ($DIMFarm[0]['numrow'] == 0) {
        $sql = "INSERT INTO `dim-farm` (`ID`, `IsFarm`, `dbID`, `Name`, `Alias`) VALUES (NULL, '1', '{$DataFarm[1]['FMID']}', '{$DataFarm[1]['Name']}', '{$DataFarm[1]['Alias']}')";
        $IDDIMF = addinsertData($sql);
        $sql = "SELECT * FROM `dim-user` WHERE`ID`='$IDDIMF'";
        //echo $sql . "<br/>";
        $DIMFarm = selectData($sql);
    }
    return  $DIMFarm;
}
// เอาไว้ดึงค่า log-farm มาทั้งหมด สวน
function getLOGfarm($DIMownerID,$DIMfarmID)
{
    $sql = "SELECT * FROM `log-farm` WHERE ISNULL(`EndT`) AND ISNULL(`EndID`) AND ISNULL(`DIMSubfID`) AND `DIMownerID` = '$DIMownerID' AND `DIMfarmID` = '$DIMfarmID'";
    $LOGfarm = selectData($sql);
    return  $LOGfarm;
}
