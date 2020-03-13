<?php
include_once("../../dbConnect.php");
$sql = "SELECT * FROM `db-farm`";
$data = selectAll( $sql );
echo json_encode($data);
