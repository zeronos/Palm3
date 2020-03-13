<?php
include_once("../../dbConnect.php");
$logid = $_GET['id'];

$sql = "SELECT  `dim-farm`.`dbID` 
FROM `log-farm` 
INNER JOIN `dim-farm` ON `log-farm`.`DIMfarmID`=`dim-farm`.`ID` 
WHERE `log-farm`.`ID` ='$logid'";

$IDFarm = selectData($sql);
$sql = "SELECT`log-farm`.`ID`,dim2.`dbID`,`dim-user`.`FullName`, `dim-user`.`Alias`, dim2.`Name`,
`log-farm`.`AreaRai`, `log-farm`.`AreaNgan`,`log-farm`.`NumTree`, `dim-farm`.`Name`AS nFarm ,
`log-farm`.`DIMfarmID`, `log-farm`.`DIMSubfID`
FROM `dim-farm` 
INNER JOIN `log-farm` ON `dim-farm`.`ID` = `log-farm`.`DIMfarmID` 
INNER JOIN `dim-farm`AS dim2 
ON dim2.`ID`= `log-farm`.`DIMSubfID` 
INNER JOIN `dim-user` ON `dim-user`.`ID` =`log-farm`.`DIMownerID` 
WHERE `dim-farm`.`dbID` = '{$IDFarm[1]['dbID']}' AND `log-farm`.`EndT` IS NULl AND `log-farm`.`DIMSubfID` IS NOT NULL
 ORDER BY dim2.`Name`";

$DATA2 = selectData($sql);
for ($i = 1; $i <= $DATA2[0]['numrow']; $i++) {
    $nsubfarm = $DATA2[$i]['Name'];
    $sql = "SELECT `dim-farm`.`Name` , `log-planting`.`DIMdateID` ,
    FLOOR(TIMESTAMPDIFF(DAY,`dim-time`.`Date`,CURRENT_TIME)% 30.4375 )as day,
    FLOOR(TIMESTAMPDIFF( MONTH,`dim-time`.`Date`,CURRENT_TIME)% 12 )as month,
    FLOOR(TIMESTAMPDIFF( YEAR,`dim-time`.`Date`,CURRENT_TIME))as year 
    from `dim-farm` 
    INNER JOIN `log-planting` ON `dim-farm`.`ID` =`log-planting`.`DIMsubFID` 
    INNER JOIN `dim-time` on `log-planting`.`DIMdateID` = `dim-time`.`ID`
     where `dim-farm`.`Name` = '$nsubfarm' group by `dim-farm`.`Name`,`dim-time`.`ID`";

    $DATA3 = selectData($sql);
    if ($DATA3[0]['numrow'] == 0) {
        $DATA2[$i]['day'] = "NaN";
        $DATA2[$i]['month'] = "NaN";
        $DATA2[$i]['year'] = "NaN";
    } else {
        $DATA2[$i]['day'] = $DATA3[1]['day'];
        $DATA2[$i]['month'] = $DATA3[1]['month'];
        $DATA2[$i]['year'] = $DATA3[1]['year'];
    }
}
//print_r($DATA2);
echo json_encode($DATA2);
