<?php

include('../../dbConnect.php');
$activity = null;
if(isset($_POST['activity']))
$activity = $_POST["activity"];

$event = array();

$sql;
// print_r($activity);

if(isset($activity))
{
    $sql = "SELECT DISTINCT `db-user`.`FirstName` as `firstName`,`db-user`.`LastName` as `lastName`, `db-farm`.`Name` as `farnName`,`db-subfarm`.`Name` as `subfarmName`,`dim-address`.`FullAddress` as `address`,`db-activity`.`Activity` as `activity`,`db-activity`.`Note` as `activityDescription`
    FROM `log-farm` join `dim-farm` on `log-farm`.`DIMfarmID` = `dim-farm`.`ID` 
    join `db-farm` on `db-farm`.`FMID` = `dim-farm`.`dbID`
    join `db-subfarm` on `db-subfarm`.`FSID`=`db-farm`.`FMID`
    join `dim-address` on `log-farm`.`DIMaddrID` = `dim-address`.`ID`
    join `log-activity` on `log-activity`.`DIMfarmID` = `log-farm`.`DIMfarmID`
    join `db-activity` on `db-activity`.`ID` = `log-activity`.`DBactID`
    join `dim-user`on `dim-user`.`ID` = `log-farm`.`DIMownerID`
    join `db-user` on `dim-user`.`dbID` = `db-user`.`UID`
    WHERE `log-farm`.`EndID` is null AND `log-activity`.`isDelete` = 0";
    
    for($i=0;$i<sizeof($activity);$i++)
    {
        if($i == sizeof($activity)-1)
        {
            $sql = $sql ." "."`db-activity`.`Activity` LIKE \"$activity[$i]\"";
        }
        else
        {
            $sql = $sql ." "."`db-activity`.`Activity` LIKE \"$activity[$i]\" OR";
        }
    }
}
else
{
    $sql = "
    SELECT DISTINCT `db-user`.`FirstName` as `firstName`,`db-user`.`LastName` as `lastName`, `db-farm`.`Name` as `farnName`,`db-subfarm`.`Name` as `subfarmName`,`dim-address`.`FullAddress` as `address`,`db-activity`.`Activity` as `activity`,`db-activity`.`Note` as `activityDescription`,`dim-time`.`Date` as `date`
    FROM `log-farm` join `dim-farm` on `log-farm`.`DIMfarmID` = `dim-farm`.`ID` 
    join `db-farm` on `db-farm`.`FMID` = `dim-farm`.`dbID`
    join `db-subfarm` on `db-subfarm`.`FSID`=`db-farm`.`FMID`
    join `dim-address` on `log-farm`.`DIMaddrID` = `dim-address`.`ID`
    join `log-activity` on `log-activity`.`DIMfarmID` = `log-farm`.`DIMfarmID`
    join `db-activity` on `db-activity`.`ID` = `log-activity`.`DBactID`
    join `dim-user`on `dim-user`.`ID` = `log-farm`.`DIMownerID`
    join `db-user` on `dim-user`.`dbID` = `db-user`.`UID`
    join `dim-time` on `dim-time`.`ID` = `log-activity`.`DIMdateID`
    WHERE `log-farm`.`EndID` is null AND `log-activity`.`isDelete` = 0";
}

//echo json_encode($sql);

// echo($sql);

$i = 0;

if($result = $conn->query($sql))
{
    while ($row = $result->fetch_assoc() ) 
    {
        $event[$i]['id'] = $i;
        $event[$i]['title'] = $row['activity'];
        $event[$i]['start'] = $row['date'];
        $event[$i]['end'] = $row['date'];
        $event[$i]['extendedProps'] = ['name-farmer'=>$row['firstName'],'name-farm'=>$row['farmName'],'name-subfarm'=>$row['subfarmName']];
        $event[$i]['color'] = '#000';

        $i++;
    }

    $result->free();

}


//echo sizeof($event);
// print_r($event);


echo json_encode($event);
