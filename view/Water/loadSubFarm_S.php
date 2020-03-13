<?php
include_once("../../dbConnect.php");
$id = $_GET['SFID'];
$sql = "SELECT ds.FSID AS 'ID',ds.Name,ds.Icon FROM `db-subfarm` AS ds WHERE FSID = $id";
$data = selectAll($sql);
echo json_encode($data);
