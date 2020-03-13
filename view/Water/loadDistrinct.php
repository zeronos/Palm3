<?php
include_once("../../dbConnect.php");
$id = $_GET['id'];
$sql = "SELECT * FROM `db-distrinct` WHERE AD1ID = $id";
$data = selectAll($sql);
echo json_encode($data);
