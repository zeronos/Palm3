<?php
include_once("../../dbConnect.php");
$DIMdate = $_POST['DIMdate'];
$DSFID = $_POST['DSFID'];
$sql = "SELECT lw.ID,dt.Date,lw.StartTime,lw.StopTime,lw.Period FROM `log-watering` AS lw 
JOIN `dim-time` AS dt ON dt.ID = lw.DIMdateID
WHERE lw.isDelete = 0 AND lw.DIMSubFID = $DSFID AND lw.DIMdateID = $DIMdate";
$data = selectAll($sql);
echo json_encode($data);
