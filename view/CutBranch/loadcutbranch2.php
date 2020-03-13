<?php
include_once("../../dbConnect.php");
    $nfarm = $_POST['name'];
    $year = $_POST['year'];
    
    $sql = "SELECT  `db-subfarm`.`Name` AS `nsf`,CONCAT(`dim-time`.`dd` , '/' , `dim-time`.`Month` , '/' ,`dim-time`.`Year2`) AS Date3
    FROM `log-activity` 
  
  	INNER JOIN `dim-farm` ON `dim-farm`.`ID` = `log-activity`.`DIMfarmID`
    INNER JOIN `db-subfarm` ON `db-subfarm`.`FSID` = `dim-farm`.`dbID` 
    INNER JOIN `db-farm` ON `db-farm`.`FMID` = `db-subfarm`.`FMID`
    INNER JOIN `dim-time` ON `dim-time`.`ID` =  `log-activity`.`DIMdateID`
    
    WHERE `log-activity`.`isDelete` = 0 AND `dim-time`.`Year2` ='$year' AND `db-farm`.`Name` LIKE  '$nfarm'
    GROUP BY `dim-time`.`ID`
    ORDER BY `dim-time`.`dd` DESC
    ";
    
    $data = selectAll($sql);
    echo json_encode($data);

    // print_r($data);


