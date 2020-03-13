<?php

require_once("../../dbConnect.php");
$myConDB = connectDB();

$select_id = $_POST["select_id"] ?? '';
$result = $_POST["result"] ?? '';
$point_id = $_POST["point_id"] ?? '';

// echo $select_id;
// echo $result;
// echo $point_id;

if($result == 'distrinct' || $result == 'e_distrinct' || $result =='s_distrinct'){
    if($select_id == 0){
        echo "<option selected value=0>เลือกอำเภอ</option>";
    }
    $sql = "SELECT * FROM `db-distrinct` WHERE `AD1ID` = '$select_id' ORDER BY `db-distrinct`.`Distrinct`  ASC ";
    $result = $myConDB->prepare( $sql ); 
    $result->execute();
    // if($result =='s_distrinct'){
    if($point_id == ''){
        echo "<option selected value=0>เลือกอำเภอ</option>";
    }
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) 
    {
        echo "<option value =".$row['AD2ID']." ";
        if($row['AD2ID'] == $point_id && $result !='s_distrinct'){ 
            echo " selected='selected' ";
        }
        echo ">".$row['Distrinct']."</option>";
    }
}
if($result == 'subdistrinct' || $result == 'e_subdistrinct'){
    if($select_id == 0){
        echo "<option selected value=0>เลือกตำบล</option>";
    }
    $sql = "SELECT * FROM `db-subdistrinct` WHERE `AD2ID` = '$select_id' ORDER BY `db-subdistrinct`.`subDistrinct`  ASC";
    $result = $myConDB->prepare( $sql ); 
    $result->execute();
    if($point_id == ''){        
     echo "<option selected value=0>เลือกตำบล</option>";

    }

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) 
    {
        echo "<option value =".$row['AD3ID']." ";
        if($row['AD3ID'] == $point_id){ 
            echo " selected";
        }
        echo ">".$row['subDistrinct']."</option>";

    }
}
if($result == 'e_province'){
    $sql = "SELECT * FROM `db-province` ORDER BY `db-province`.`Province`  ASC";
    $result = $myConDB->prepare( $sql ); 
    $result->execute();
    if($point_id == ''){
        echo "<option selected value=0>เลือกจังหวัด</option>";

    }
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) 
    {
        echo "<option value =".$row['AD1ID']." ";
        if($row['AD1ID'] == $point_id){ 
            echo " selected";
        }
        echo ">".$row['Province']."</option>";

    }
}

?>