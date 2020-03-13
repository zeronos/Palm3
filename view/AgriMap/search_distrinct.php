<?php
    include('connect_db.php');
    $province = $_POST['province'];

   
    if($province == 0)
    {
        $sql = "SELECT * FROM `db-distrinct`";
        $result = $conn->query($sql);
        echo "<option value = 0>"."ทั้งหมด"."</option>";
    }
    else
    {
        $sql = "SELECT * FROM `db-distrinct` WHERE `AD1ID` = '$province' ";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) 
        {
            echo "<option value =".$row['AD2ID'].">".$row['Distrinct']."</option>";
        }
    }


?>
