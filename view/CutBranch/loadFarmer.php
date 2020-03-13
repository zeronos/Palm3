<?php
include_once("../../dbConnect.php");
$sql = "SELECT * FROM `db-farmer`";
$data = selectAll($sql);
echo json_encode($data);
