<?php
include_once("../../dbConnect.php");
$sql = "SELECT fw.ID,dt.Date,S.FID,S.SFID AS 'SFID',S.DSFID,S.UID,S.Name,S.FName,S.SFName AS 'subFName',S.SumArea,S.SumNumTree,S.Latitude,S.Longitude,fw.WaterPeriod,fw.RainPeriod,fw.TotalPeriod
FROM `fact-watering` AS fw 
    INNER JOIN( SELECT df.dbID AS 'FID',dfs.dbID AS 'SFID',du.dbID AS 'UID',dfs.ID AS 'DSFID',du.Alias AS 'Name',df.Name AS 'FName',dfs.Name AS 'SFName',lf.AreaTotal AS 'SumArea',lf.NumTree AS 'SumNumTree',ds.Latitude,ds.Longitude
                    FROM `log-farm` AS lf 
                        JOIN `dim-farm` as df ON df.ID = lf.DIMfarmID
                        JOIN `dim-farm` as dfs ON dfs.ID = lf.DIMSubfID 
                        JOIN `db-subfarm` AS ds ON ds.FSID = dfs.dbID 
                        JOIN `dim-user` as du ON du.ID = lf.DIMownerID
                    WHERE lf.EndID IS NULL
               ) AS S ON S.DSFID = fw.DIMsubFID
    JOIN `dim-time` AS dt ON dt.ID = fw.DIMdateID
WHERE dt.Year2 = YEAR(CURDATE())+543
ORDER by S.SFID,dt.Date
";
$data = selectAll($sql);
echo json_encode($data);
