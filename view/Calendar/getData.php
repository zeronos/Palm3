<?php
    // include('../../dbConnect.php');
    // connectDB();
    function getYear(){
        $sqlYear =  "SELECT DISTINCT(`Year2`) FROM `dim-time` ORDER BY Year2 DESC";
        $data = selectData($sqlYear);
        return $data;
    }
    function getProvince(){
        $sql_province = "SELECT * FROM `db-province`";
        $data = selectData($sql_province);
        // $data = ['id'=>'ss','pro'=>'s'];
        return $data;
    }

    function getDistrict($id){
        include('../../dbConnect.php');
        $sql = "SELECT * FROM `db-distrinct` WHERE `AD1ID` = $id"; 
        return selectData($sql);
    }
    if(isset($_POST['request'])){
        if($_POST['request']=='getDistrict'){
            echo json_encode(getDistrict($_POST['id']));
        }
    }
    
    
?>