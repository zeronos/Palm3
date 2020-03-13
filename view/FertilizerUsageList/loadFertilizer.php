<?php
include_once("../../dbConnect.php");
session_start();

$year = $_POST['year'];
$text = "";
$ID_Province = $_POST['ID_Province'] ?? "";
$ID_Distrinct = $_POST['ID_Distrinct'] ?? "";
$name = $_POST['name'] ?? "";
$passport = $_POST['passport'] ?? "";
$fer_form = $_POST['score_Form'] ?? "";
$fer_to = $_POST['score_To'] ?? "";



if ($ID_Province != "") { $text .= " AND A.`dbprovID` = '$ID_Province' "; }
if ($ID_Distrinct != "") { $text .= " AND A.`dbDistID`.`FSID` ='$ID_Distrinct' "; }
if ($name != "") { $text .= " AND `dim-user`.`Alias` LIKE '%$name%' "; }
if ($passport != "") { $text .= "AND `dim-user`.`FormalID` LIKE  '%$passport%' "; }
//$Vol1 = 1000;

$sql = "SELECT `dim-user`.`Alias`,`dim-farm`.`Name` as FarmName,A.`NumSubFarm`,A.`AreaRai`,A.`NumTree`,`dim-fertilizer`.`Name` as FerName,B.`Weight` AS `HarvestVol`,(SUM(`log-fertilising`.`Vol`)*2) AS `Vol1`,
    SUM(`log-fertilising`.`Vol`) AS `Vol2`,(SUM(`log-fertilising`.`Vol`)*2)-(SUM(`log-fertilising`.`Vol`)) AS `Vol3`,A.`dbprovID`,A.`dbDistID`,`dim-user`.`FormalID`
    ,A.`AreaNgan`,A.`AreaWa`   
    FROM `log-fertilising` 
    
    INNER JOIN `dim-fertilizer`ON `dim-fertilizer`.`ID` = `log-fertilising`.`DIMferID`
    INNER JOIN `dim-user`ON`dim-user`.`ID` = `log-fertilising`.`DIMownerID`
    INNER JOIN `dim-farm`ON `dim-farm`.`ID` = `log-fertilising`.`DIMfarmID`
    
    INNER JOIN  (SELECT `log-farm`.`DIMfarmID`,`log-farm`.`NumSubFarm`,`log-farm`.`NumTree`,`log-farm`.`AreaRai`,`dim-address`.`dbDistID`,`dim-address`.`dbprovID`
    ,`log-farm`.`AreaNgan`,`log-farm`.`AreaWa`
    FROM `log-farm`
    INNER JOIN `dim-address` ON `dim-address`.`ID` = `log-farm`.`DIMaddrID`
    WHERE `log-farm`.`DIMSubfID` IS NULL AND `log-farm`.`EndID` IS NULL  
    GROUP BY `log-farm`.`DIMfarmID`) AS A ON A.`DIMfarmID` = `log-fertilising`.`DIMfarmID`
    INNER JOIN (SELECT SUM(`log-harvest`.`Weight`) AS `Weight`,`log-harvest`.`DIMfarmID`
    FROM `log-harvest`
    WHERE  `log-harvest`.`DIMsubFID` IS NOT NULL AND  `log-harvest`.`isDelete` = 0
    GROUP BY  `log-harvest`.`DIMfarmID` ) AS B ON B.`DIMfarmID` = `log-fertilising`.`DIMfarmID`
    INNER JOIN `dim-time`ON `dim-time`.`ID` = `log-fertilising`.`DIMdateID`
    
    WHERE `log-fertilising`.`isDelete` = 0 AND `dim-time`.`Year2` = $year $text
    GROUP BY `log-fertilising`.`DIMfarmID`
    ";

$data = selectAll($sql);
echo json_encode($data);
