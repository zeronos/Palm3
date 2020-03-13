<?php 
    include_once('../../dbConnect.php');
    $year = $_POST['year'];
    $nsub = $_POST['nsubfarm'];
    $sql = "SELECT t.Year2,t.`Month`,sum(t.`Weight`)as s FROM
    (SELECT `dim-time`.`Month`,`dim-time`.`Year2`,`dim-farm`.`Name`,`log-harvest`.`Weight` FROM `log-harvest` 
    INNER JOIN `dim-time` on `log-harvest`.`DIMdateID` = `dim-time`.`ID` 
    INNER JOIN `dim-farm` on `dim-farm`.`ID` = `log-harvest`.`DIMsubFID` 
    WHERE `dim-farm`.`Name` = '".$nsub."' ORDER BY `dim-time`.`Year2` ASC) as t 
    WHERE t.`Year2`='".$year."'
    GROUP BY t.`Month`";
    $data = selectAll($sql);
    echo json_encode($data);
?>
