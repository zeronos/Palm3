<?php
include_once("../../dbConnect.php");
$id = $_GET['id'];
$sql = "SELECT * FROM `dim-pest` WHERE dbpestTID = $id";
$data = selectAll($sql);
echo json_encode($data);
