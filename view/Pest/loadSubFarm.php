<?php
include_once("../../dbConnect.php");
$id = $_GET['farm'];
$sql = "SELECT * FROM `db-subfarm` WHERE FMID = $id";
$data = selectAll($sql);
echo json_encode($data);
