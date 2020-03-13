<?php
include_once("../../dbConnect.php");
    $nfarm = $_POST['name'];
    $Year2 = $_POST['Year2'];
    
    $sql = "SELECT  `db-farm`.`Name`,`db-subfarm`.`Name` AS `nsf`,`dim-time`.`Date` AS `date2`,`dim-time`.`Year2`

    FROM `log-activity` 
    INNER JOIN `dim-user` ON `dim-user`.`ID` = `log-activity`.`DIMownerID`
    INNER JOIN `dim-farm` ON `dim-farm`.`ID` = `log-activity`.`DIMsubFID`
    INNER JOIN `db-subfarm` ON `db-subfarm`.`FSID` = `dim-farm`.`dbID` 
    INNER JOIN `db-farm` ON `db-farm`.`FMID` = `db-subfarm`.`FMID`
    INNER JOIN `dim-time` ON `dim-time`.`ID` =  `log-activity`.`DIMdateID`
    
    WHERE `log-activity`.`isDelete` = 0 AND `dim-time`.`Year2` = '$Year2' AND `db-farm`.`Name` LIKE  '%$nfarm%'
    GROUP BY `nsf`
    ORDER BY `date2` DESC ";
    
    $data = selectAll($sql);
    echo json_encode($data);

    // print_r($data);


