<?php
$id = $_GET['id'];
include_once("../../dbConnect.php");
$sql = "SELECT * FROM `db-distrinct` WHERE AD1ID = $id";
$data = selectAll($sql);
echo json_encode($data);
