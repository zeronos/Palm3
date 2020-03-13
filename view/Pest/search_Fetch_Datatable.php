<?php
include_once("../../dbConnect.php");

$year = $_POST['year'];
$ID_Pest = $_POST['ID_Pest'];
$ID_Province = $_POST['ID_Province'];
$ID_Distrinct = $_POST['ID_Distrinct'];
$name = $_POST['name'];
$passport = $_POST['passport'];

$sqlFarm = "";
$sqlPestAlarm = "";
$sql_Join_Pro_Dis = "";
$sqlProvince = "";
$sqlDistrinct = "";
$sqlPest = "";

if ($year == date("Y") + 543)
   $sqlFarm = "SELECT df.dbID AS 'FID',dfs.dbID AS 'SFID',dfs.ID AS 'DFSID',du.Alias AS 'Name',df.Name AS 'FName',dfs.Name AS 'SFName',lf.AreaTotal AS 'SumArea',lf.NumTree AS 'SumNumTree',ds.AD3ID,ds.Latitude,ds.Longitude
                  FROM `log-farm` AS lf 
                     JOIN `dim-farm` as df ON df.ID = lf.DIMfarmID
                     JOIN `dim-farm` as dfs ON dfs.ID = lf.DIMSubfID 
                     JOIN `db-subfarm` AS ds ON ds.FSID = dfs.dbID 
                     JOIN `dim-user` as du ON du.ID = lf.DIMownerID
                  WHERE lf.EndID IS NULL";
else
   $sqlFarm = "SELECT df.dbID AS 'FID',dfs.dbID AS 'SFID',dfs.ID AS 'DFSID',du.Alias AS 'Name',df.Name AS 'FName',dfs.Name AS 'SFName',ff.AreaTotal AS 'SumArea',ff.NumTree AS 'SumNumTree',ds.AD3ID,ds.Latitude,ds.Longitude
                  FROM `fact-farming` AS ff
                     JOIN `dim-farm` as df ON df.ID = ff.DIMfarmID
                     JOIN `dim-farm` as dfs ON dfs.ID = ff.DIMSubfID 
                     JOIN `db-subfarm` AS ds ON ds.FSID = dfs.dbID 
                     JOIN `dim-user` as du ON du.ID = ff.DIMownerID
                  WHERE ff.isDelete = 0 AND ff.TagetYear = $year-543";

if ($name != null)
   $sqlFarm = $sqlFarm . " AND du.Alias = '$name'";
if ($passport != null)
   $sqlFarm = $sqlFarm . " AND du.FormalID = '$passport'";


if ($ID_Province != "null") {
   $sql_Join_Pro_Dis = " JOIN `db-subdistrinct` AS dsd ON dsd.AD3ID = S.AD3ID
                         JOIN `db-distrinct` AS dd ON dd.AD2ID = dsd.AD2ID ";
   $sqlProvince = "AND dd.AD1ID = '$ID_Province' ";
}
if ($ID_Distrinct != null)
   $sqlDistrincts = "AND dd.AD2ID = '$ID_Distrinct' ";
if ($ID_Pest != "null")
   $sqlPest = "AND dp.dbpestTID = '$ID_Pest' ";


$sqlPestAlarm = "SELECT lpa.ID,dp.ID AS 'DIMpestID',dp.dbpestTID,dp.dbpestLID,S.FID,S.SFID AS 'SFID',S.Name,S.FName,S.SFName AS 'subFName',S.SumArea,S.SumNumTree,dp.TypeTH,dt.Date,dp.Name AS 'PName',dp.Alias AS 'PAlias',dp.Charactor,dp.Danger,dpl.Icon,lp.NumPicChar,lp.NumPicDanger,lpa.PICS,lpa.Note,S.Latitude,S.Longitude
                  FROM `log-pestalarm` AS lpa
                     INNER JOIN ($sqlFarm) AS S ON lpa.DIMSubfID = S.DFSID
                     JOIN `dim-pest` AS dp ON dp.ID = lpa.DIMpestID 
                     JOIN `dim-time` AS dt ON dt.ID = lpa.DIMdateID " . $sql_Join_Pro_Dis . "JOIN `log-pest` AS lp ON lp.DIMpestID = dp.ID
                     JOIN `db-pestlist` AS dpl ON dpl.PID = dp.dbpestLID
                  WHERE lpa.isDelete = 0 AND dt.Year2 = $year " . $sqlProvince . $sqlDistrinct . $sqlPest;

$data = selectAll($sqlPestAlarm);
echo json_encode($data);
// echo $sqlPestAlarm;
