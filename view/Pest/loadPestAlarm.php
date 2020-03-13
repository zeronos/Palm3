<?php
include_once("../../dbConnect.php");
$sql = "SELECT lpa.ID,dp.ID AS 'DIMpestID',dp.dbpestTID,dp.dbpestLID,S.FID,S.SFID AS 'SFID',S.Name,S.FName,S.SFName AS 'subFName',S.SumArea,S.SumNumTree,dp.TypeTH,dt.Date,dp.Name AS 'PName',dp.Alias AS 'PAlias',dp.Charactor,dp.Danger,dpl.Icon,lp.NumPicChar,lp.NumPicDanger,lpa.PICS,lpa.Note,S.Latitude,S.Longitude
FROM `log-pestalarm` AS lpa
   INNER JOIN (
   SELECT df.dbID AS 'FID',dfs.dbID AS 'SFID',dfs.ID AS 'DFSID',du.Alias AS 'Name',df.Name AS 'FName',dfs.Name AS 'SFName',lf.AreaTotal AS 'SumArea',lf.NumTree AS 'SumNumTree',ds.Latitude,ds.Longitude
               FROM `log-farm` AS lf 
                  JOIN `dim-farm` as df ON df.ID = lf.DIMfarmID
                  JOIN `dim-farm` as dfs ON dfs.ID = lf.DIMSubfID 
                  JOIN `db-subfarm` AS ds ON ds.FSID = dfs.dbID 
                  JOIN `dim-user` as du ON du.ID = lf.DIMownerID
               WHERE lf.EndID IS NULL
   ) AS S ON lpa.DIMSubfID = S.DFSID
   JOIN `dim-pest` AS dp ON dp.ID = lpa.DIMpestID 
   JOIN `dim-time` AS dt ON dt.ID = lpa.DIMdateID
   JOIN `log-pest` AS lp ON lp.DIMpestID = dp.ID
   JOIN `db-pestlist` AS dpl ON dpl.PID = dp.dbpestLID
WHERE lpa.isDelete = 0 AND dt.Year2 = YEAR(CURDATE())+543
";
$data = selectAll($sql);
echo json_encode($data);
