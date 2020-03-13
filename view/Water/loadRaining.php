<?php
include_once("../../dbConnect.php");
$id = $_GET['id'];
$sql = "SELECT lr.ID,dt.Date,lr.StartTime,lr.StopTime,lr.Period,lr.Level,lr.Vol 
FROM `log-raining` AS lr 
JOIN `dim-time` AS dt ON dt.ID = lr.DIMdateID
WHERE  lr.isDelete = 0 AND lr.DIMSubFID = $id";
$data = selectAll($sql);
echo json_encode($data);
