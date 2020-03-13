<?php
    require_once("../../dbConnect.php");
    require_once("../../set-log-login.php");
    function getAll(){
        $sql = "SELECT DISTINCT `dim-farm`.`Name`,`dim-user`.`FullName` FROM `log-farm` INNER JOIN `dim-farm`ON `dim-farm`.`ID` = `log-farm`.`DIMfarmID` INNER JOIN `dim-user` ON `dim-user`.`ID` = `log-farm`.`DIMownerID` WHERE ISNULL(`log-farm`.`EndT`) AND ISNULL(`log-farm`.`EndID`)";
        $data = selectAll($sql);
        return $data;
    }

?>