<?php
include_once("../../dbConnect.php");
$sql = "SELECT `log-farm`.`ID`,`dim-farm`.`dbID` AS FMID ,
`dim-address`.`Province`,`dim-address`.`Distrinct`,
`dim-user`.`FullName`, `dim-user`.`Alias`, `dim-farm`.`Name`, `log-farm`.`NumSubFarm`,
`log-farm`.`AreaRai`, `log-farm`.`AreaNgan`,`log-farm`.`NumTree` 
FROM `log-farm` 
INNER JOIN `dim-user`ON `dim-user`.`ID` = `log-farm`.`DIMownerID`
INNER JOIN `dim-address`ON `dim-address`.`ID` =`log-farm`.`DIMaddrID`
INNER JOIN `dim-farm`ON `dim-farm`.`ID` = `log-farm`.`DIMfarmID`
WHERE `log-farm`.`DIMSubfID` IS NULL AND`log-farm`.`EndT`IS NULL
ORDER BY `dim-address`.`Province`,`dim-address`.`Distrinct`,`dim-user`.`Alias`";
$data = selectAll($sql);
echo json_encode($data);
