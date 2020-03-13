<?php
    $year = $_GET['year'];
    include_once("../../dbConnect.php");
    $sql = "SELECT * FROM `fact-fertilizer` WHERE  `Tagetyear` = $year ";
    $data = selectData($sql);
    $text = "t";
    if($data[0]['numrow'] == 0){
        $text = "f";
    }
    echo $text;
    
?>