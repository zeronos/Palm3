<?php
include_once("../../dbConnect.php");
$sql = "SELECT * FROM `db-province`";
$data = selectAll($sql);
echo json_encode($data);
