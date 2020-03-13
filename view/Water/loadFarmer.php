<?php
include_once("../../dbConnect.php");
$id = $_GET['UID'];
$sql = "SELECT df.UFID AS 'ID',df.FirstName AS 'FName',df.LastName AS 'LName',df.Icon FROM `db-farmer` AS df WHERE df.UFID = $id";
$data = selectAll($sql);
echo json_encode($data);
