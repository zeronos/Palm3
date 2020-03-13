<?php
$activity = array();
$drying = array();
$province = '';
$distinct = '';
$farmer = ''; 
$year = '';
if(!empty($_POST['activity']))
    $activity = explode(',',$_POST['activity']);
if(!empty($_POST['drying']))
    $drying = explode(',',$_POST['drying']);
if(!empty($_POST['province']))
    $province = $_POST['province'];
if(!empty($_POST['distinct']))
    $distinct = $_POST['distinct'];
if(!empty($_POST['farmer']))
    $farmer = $_POST['farmer'];
if(!empty($_POST['year']))
    $year = $_POST['year'];
$sql;
$event = array();
$data = array();
include('../../dbConnect.php');
connectDB();
if(sizeof($activity)>0 || sizeof($drying)>0){
    if(sizeof($activity)>0){
        $sql = getSqlActivity($year,$province,$distinct,$farmer);
        $sql .= getLoopActivity($activity);
        $data = selectData($sql);
        setEvent($data,'activity',$event);
    }
    if(sizeof($drying) > 0){
        $sql = getSqlDrying($year,$province,$distinct,$farmer);
         $data2 = selectData($sql);
         setEvent($data2,'drying',$event); 
        }
}else{
    // $sql = getSqlActivity($year,$province,$distinct,$farmer);
    // $data = selectData($sql);
    // setEvent($data,'activity',$event);
    // $sql = getSqlDrying($year,$province,$distinct,$farmer);
    // $data2 = selectData($sql);
    // setEvent($data2,'drying',$event); 
}



function getSqlActivity($year,$province,$distinct,$farmer){
    $sql = "SELECT DISTINCT `db-farmer`.`FirstName`,`db-farmer`.`LastName`, `db-farm`.`Name` as `farmName`,`db-subfarm`.`Name` as `subfarmName`,`dim-address`.`FullAddress` as `address`,`db-activity`.`Activity` as `activity`,`db-activity`.`Note` as `activityDescription`,`dim-time`.`Date` as `date`
    FROM `log-farm` join `dim-farm` on `log-farm`.`DIMfarmID` = `dim-farm`.`ID` 
    join `db-farm` on `db-farm`.`FMID` = `dim-farm`.`dbID`
    join `db-subfarm` on `db-subfarm`.`FSID`=`db-farm`.`FMID`
    join `dim-address` on `log-farm`.`DIMaddrID` = `dim-address`.`ID`
    join `log-activity` on `log-activity`.`DIMfarmID` = `log-farm`.`DIMfarmID`
    join `db-activity` on `db-activity`.`ID` = `log-activity`.`DBactID`
    join `dim-user`on `dim-user`.`ID` = `log-farm`.`DIMownerID`
    join `db-farmer` on `db-farmer`.`UFID` = `dim-user`.`dbID`
    join `dim-time` on `dim-time`.`ID` = `log-activity`.`DIMdateID`
    WHERE `log-farm`.`EndID` is null AND `log-activity`.`isDelete` = 0 ";
    $sql .= getYear($year);
    $sql .= getSqlProDis($province,$distinct);
    $sql .= getSqlFarmer($farmer);
    return $sql;
}
function getSqlDrying($year,$province,$distinct,$farmer){
    $sql = "SELECT DISTINCT `db-farmer`.`FirstName`,`db-farmer`.`LastName`, `db-farm`.`Name` as `farmName`,`db-subfarm`.`Name` as `subfarmName`,`dim-address`.`FullAddress` as `address`,
    `fact-drying`.`DIMstartDID`,`dim-time`.`Date` as `date`
    FROM `log-farm` join `dim-farm` on `log-farm`.`DIMfarmID` = `dim-farm`.`ID` 
    join `db-farm` on `db-farm`.`FMID` = `dim-farm`.`dbID`
    join `db-subfarm` on `db-subfarm`.`FSID`=`db-farm`.`FMID`
    join `dim-address` on `log-farm`.`DIMaddrID` = `dim-address`.`ID`
    join `dim-user`on `dim-user`.`ID` = `log-farm`.`DIMownerID`
    join `db-farmer` on `db-farmer`.`UFID` = `dim-user`.`dbID`
    join `fact-drying` on `fact-drying`.`DIMfarmID` = `log-farm`.`DIMfarmID`
    join `dim-time` on `dim-time`.`ID` = `fact-drying`.`DIMstartDID`
    WHERE `log-farm`.`EndID` is null AND `fact-drying`.`DIMstopDID` is  null ";
    $sql .= getYear($year);
    $sql .= getSqlProDis($province,$distinct);
    $sql .= getSqlFarmer($farmer);
    return $sql;
}
function getSqlProDis($province,$distinct){
    $sql = '';
    if($province!=''){
        $sql .= " AND `dim-address`.`dbprovID` = '$province' ";
    }
    if($distinct!=''){
        $sql .= " AND `dim-address`.`dbDistID` = '$distinct' ";
    }
    return $sql;
}
function getYear($year){
    $sql = '';
    if($year!=''){
        $sql .= " AND `dim-time`.`Year2` = '$year' ";
    }
    return $sql;
}
function getSqlFarmer($farmer){
    $sql = '';
    if($farmer!=''){
        $sql .= " AND `db-farmer`.`FirstName` LIKE '%$farmer%' OR `db-farmer`.`LastName` LIKE '%$farmer%' ";
    }
    return $sql;
}
function getLoopActivity($activity){
    $sql = ' AND (';
    for($i = 0; $i < sizeof($activity); $i++){
        $sql .= "`db-activity`.`Activity` = '$activity[$i]'";
        if($i != sizeof($activity)-1)
            $sql .= "OR";
        
    }
    $sql .= ")";
    return $sql;
}
function setEvent($data,$type,&$event){
    $num = sizeof($event);
    for($i = 0; $i < sizeof($data); $i++ ){
        $color;
        if($i > 0){
            $event[$num]['id'] = "$type"."$i";
            $event[$num]['title'] = ($type=="activity") ?  $data[$i]["$type"]: 'ขาดน้ำ';
            $event[$num]['start'] = $data[$i]['date'];
            $event[$num]['end'] = $data[$i]['date'];
            $event[$num]['color'] = '#42f554';
            $event[$num]['extendedProps'] = ['name_farmer'=>$data[$i]['FirstName'],'name_farm'=>$data[$i]['farmName'],'name_subfarm'=>$data[$i]['subfarmName'],'address'=>$data[$i]['address']]; 
            $num++;
        }
        
    }
}
echo json_encode($event);