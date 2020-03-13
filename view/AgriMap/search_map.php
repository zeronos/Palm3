<?php
include('connect_db.php');

$distrinct = $_REQUEST['distrinct'];
$fertilizer = $_POST['fertilizer'];
$product = $_POST['product'];
$year =  $_POST['year'];

//echo $distrinct.$fertilizer.$product.$year;

$product_mean = 100.254;

$coordinates = array();

if ($distrinct == 0) {
    $sql = "SELECT  `fact-fertilizer`.`TagetYear`,`dim-farm`.`Name`,`db-farm`.`Address`,`fact-farming`.`HarvestVol` AS product ,`db-farm`.`Latitude`,`db-farm`.`Longitude`,`db-subdistrinct`.`Latitude` AS AID3Lat,`db-subdistrinct`.`Longitude` AS  AID3Lng FROM `fact-fertilizer`
    JOIN `fact-farming` ON `fact-farming`.`ID` = `fact-fertilizer`.`FACTfarmID`
    JOIN `dim-farm` ON `fact-farming`.`DIMfarmID` = `dim-farm`.`ID`
    JOIN  `db-farm` ON `dim-farm`.`dbID` = `db-farm`.`FMID`
    JOIN `db-subdistrinct` ON `db-farm`.`AD3ID` = `db-subdistrinct`.`AD3ID`
    JOIN  `db-distrinct` ON `db-subdistrinct`.`AD2ID` =  `db-distrinct`.`AD2ID`
    WHERE `fact-fertilizer`.`isDelete` = 0 AND `fact-fertilizer`.`TagetYear` = $year";
} 
else {
    $sql = "SELECT  `fact-fertilizer`.`TagetYear`,`dim-farm`.`Name`,`db-farm`.`Address`,`fact-farming`.`HarvestVol` AS product ,`db-farm`.`Latitude`,`db-farm`.`Longitude`,`db-subdistrinct`.`Latitude` AS AID3Lat,`db-subdistrinct`.`Longitude` AS  AID3Lng FROM `fact-fertilizer`
    JOIN `fact-farming` ON `fact-farming`.`ID` = `fact-fertilizer`.`FACTfarmID`
    JOIN `dim-farm` ON `fact-farming`.`DIMfarmID` = `dim-farm`.`ID`
    JOIN  `db-farm` ON `dim-farm`.`dbID` = `db-farm`.`FMID`
    JOIN `db-subdistrinct` ON `db-farm`.`AD3ID` = `db-subdistrinct`.`AD3ID`
    JOIN  `db-distrinct` ON `db-subdistrinct`.`AD2ID` =  `db-distrinct`.`AD2ID`
    WHERE `fact-fertilizer`.`isDelete` = 0 AND `fact-fertilizer`.`TagetYear` = $year AND `db-distrinct`.`AD2ID` = $distrinct";
}

//print_r($coordinates);

if ($fertilizer == 0 && $product == 0) {

    $result = $conn->query($sql);

    $i = 0;

    while ($row = $result->fetch_assoc()) {
        $coordinates[$i]['name'] = $row['Name'];

        if ($row['Latitude'] && $row['Longitude'] != null) {
            $coordinates[$i]['lat'] = $row['Latitude'];
            $coordinates[$i]['lng'] = $row['Longitude'];
        } else {
            $coordinates[$i]['lat'] = $row['AID3Lat'];
            $coordinates[$i]['lng'] = $row['AID3Lng'];
        }

        $coordinates[$i]['address'] = $row['Address'];
        $coordinates[$i]['product'] = $row['product'];

        $i++;
    }

    echo json_encode($coordinates);
    //print_r($coordinates);
} elseif ($fertilizer == 0 && $product == 1) {

    $result = $conn->query($sql);

    $i = 0;

    while ($row = $result->fetch_assoc()) {

        if ($row['product'] > $product_mean) {
            $coordinates[$i]['name'] = $row['Name'];

            if ($row['Latitude'] && $row['Longitude'] != null) {
                $coordinates[$i]['lat'] = $row['Latitude'];
                $coordinates[$i]['lng'] = $row['Longitude'];
            } else {
                $coordinates[$i]['lat'] = $row['AID3Lat'];
                $coordinates[$i]['lng'] = $row['AID3Lng'];
            }

            $coordinates[$i]['address'] = $row['Address'];
            $coordinates[$i]['product'] = $row['product'];
            $i++;
        }
    }

    echo json_encode($coordinates);

    //print_r($coordinates);
} elseif ($fertilizer == 0 && $product == 2) {

    $result = $conn->query($sql);

    $i = 0;

    while ($row = $result->fetch_assoc()) {

        if ($row['product'] <= $product_mean) {
            $coordinates[$i]['name'] = $row['Name'];

            if ($row['Latitude'] && $row['Longitude'] != null) {
                $coordinates[$i]['lat'] = $row['Latitude'];
                $coordinates[$i]['lng'] = $row['Longitude'];
            } else {
                $coordinates[$i]['lat'] = $row['AID3Lat'];
                $coordinates[$i]['lng'] = $row['AID3Lng'];
            }

            $coordinates[$i]['address'] = $row['Address'];
            $coordinates[$i]['product'] = $row['product'];

            $i++;
        }
    }

    echo json_encode($coordinates);
} elseif ($fertilizer == 0 && $product == 3) {

    $result = $conn->query($sql);

    $i = 0;

    while ($row = $result->fetch_assoc()) {

        if ($row['product'] == 0) {
            $coordinates[$i]['name'] = $row['Name'];

            if ($row['Latitude'] && $row['Longitude'] != null) {
                $coordinates[$i]['lat'] = $row['Latitude'];
                $coordinates[$i]['lng'] = $row['Longitude'];
            } else {
                $coordinates[$i]['lat'] = $row['AID3Lat'];
                $coordinates[$i]['lng'] = $row['AID3Lng'];
            }

            $coordinates[$i]['address'] = $row['Address'];
            $coordinates[$i]['product'] = $row['product'];

            $i++;
        }
    }

    echo json_encode($coordinates);
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
elseif ($fertilizer == 1 && $product == 0) {

    $sql = $sql ." "."AND `fact-fertilizer`.`Vol1`-`fact-fertilizer`.`Vol2` = 0";
    $result = $conn->query($sql);

    $i = 0;

    while ($row = $result->fetch_assoc()) {
        $coordinates[$i]['name'] = $row['Name'];

        if ($row['Latitude'] && $row['Longitude'] != null) {
            $coordinates[$i]['lat'] = $row['Latitude'];
            $coordinates[$i]['lng'] = $row['Longitude'];
        } else {
            $coordinates[$i]['lat'] = $row['AID3Lat'];
            $coordinates[$i]['lng'] = $row['AID3Lng'];
        }

        $coordinates[$i]['address'] = $row['Address'];
        $coordinates[$i]['product'] = $row['product'];

        $i++;
    }

    echo json_encode($coordinates);
} elseif ($fertilizer == 1 && $product == 1) {

    $sql = $sql ." ". "AND `fact-fertilizer`.`Vol1`-`fact-fertilizer`.`Vol2` = 0";
    $result = $conn->query($sql);

    $i = 0;

    while ($row = $result->fetch_assoc()) {

        if ($row['product'] > $product_mean) {
            $coordinates[$i]['name'] = $row['Name'];

            if ($row['Latitude'] && $row['Longitude'] != null) {
                $coordinates[$i]['lat'] = $row['Latitude'];
                $coordinates[$i]['lng'] = $row['Longitude'];
            } else {
                $coordinates[$i]['lat'] = $row['AID3Lat'];
                $coordinates[$i]['lng'] = $row['AID3Lng'];
            }

            $coordinates[$i]['address'] = $row['Address'];
            $coordinates[$i]['product'] = $row['product'];
            $i++;
        }
    }

    echo json_encode($coordinates);
} elseif ($fertilizer == 1 && $product == 2) {

    $sql = $sql ." ". "AND `fact-fertilizer`.`Vol1`-`fact-fertilizer`.`Vol2` = 0";
    $result = $conn->query($sql);

    $i = 0;

    while ($row = $result->fetch_assoc()) {

        if ($row['product'] <= $product_mean) {
            $coordinates[$i]['name'] = $row['Name'];

            if ($row['Latitude'] && $row['Longitude'] != null) {
                $coordinates[$i]['lat'] = $row['Latitude'];
                $coordinates[$i]['lng'] = $row['Longitude'];
            } else {
                $coordinates[$i]['lat'] = $row['AID3Lat'];
                $coordinates[$i]['lng'] = $row['AID3Lng'];
            }

            $coordinates[$i]['address'] = $row['Address'];
            $coordinates[$i]['product'] = $row['product'];

            $i++;
        }
    }

    echo json_encode($coordinates);
} elseif ($fertilizer == 1 && $product == 3) {

    $sql = $sql ." ". "AND `fact-fertilizer`.`Vol1`-`fact-fertilizer`.`Vol2` = 0";
    $result = $conn->query($sql);

    $i = 0;

    while ($row = $result->fetch_assoc()) {

        if ($row['product'] == 0) {
            $coordinates[$i]['name'] = $row['Name'];

            if ($row['Latitude'] && $row['Longitude'] != null) {
                $coordinates[$i]['lat'] = $row['Latitude'];
                $coordinates[$i]['lng'] = $row['Longitude'];
            } else {
                $coordinates[$i]['lat'] = $row['AID3Lat'];
                $coordinates[$i]['lng'] = $row['AID3Lng'];
            }

            $coordinates[$i]['address'] = $row['Address'];
            $coordinates[$i]['product'] = $row['product'];

            $i++;
        }
    }

    echo json_encode($coordinates);
}


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
elseif ($fertilizer == 2 && $product == 0) {

    $sql = $sql ." ". "AND `fact-fertilizer`.`Vol1`-`fact-fertilizer`.`Vol2` <> 0";
    $result = $conn->query($sql);

    $i = 0;

    while ($row = $result->fetch_assoc()) {
        $coordinates[$i]['name'] = $row['Name'];

        if ($row['Latitude'] && $row['Longitude'] != null) {
            $coordinates[$i]['lat'] = $row['Latitude'];
            $coordinates[$i]['lng'] = $row['Longitude'];
        } else {
            $coordinates[$i]['lat'] = $row['AID3Lat'];
            $coordinates[$i]['lng'] = $row['AID3Lng'];
        }

        $coordinates[$i]['address'] = $row['Address'];
        $coordinates[$i]['product'] = $row['product'];

        $i++;
    }

    echo json_encode($coordinates);
} elseif ($fertilizer == 2 && $product == 1) {

    $sql = $sql ." ". "AND `fact-fertilizer`.`Vol1`-`fact-fertilizer`.`Vol2` <> 0";
    $result = $conn->query($sql);

    $i = 0;

    while ($row = $result->fetch_assoc()) {

        if ($row['product'] > $product_mean) {
            $coordinates[$i]['name'] = $row['Name'];

            if ($row['Latitude'] && $row['Longitude'] != null) {
                $coordinates[$i]['lat'] = $row['Latitude'];
                $coordinates[$i]['lng'] = $row['Longitude'];
            } else {
                $coordinates[$i]['lat'] = $row['AID3Lat'];
                $coordinates[$i]['lng'] = $row['AID3Lng'];
            }

            $coordinates[$i]['address'] = $row['Address'];
            $coordinates[$i]['product'] = $row['product'];
            $i++;
        }
    }

    echo json_encode($coordinates);
} elseif ($fertilizer == 2 && $product == 2) {
    $sql = $sql ." ". "AND `fact-fertilizer`.`Vol1`-`fact-fertilizer`.`Vol2` <> 0";

    $result = $conn->query($sql);

    $i = 0;

    while ($row = $result->fetch_assoc()) {

        if ($row['product'] <= $product_mean) {

            $coordinates[$i]['name'] = $row['Name'];

            if ($row['Latitude'] && $row['Longitude'] != null) {
                $coordinates[$i]['lat'] = $row['Latitude'];
                $coordinates[$i]['lng'] = $row['Longitude'];
            } else {
                $coordinates[$i]['lat'] = $row['AID3Lat'];
                $coordinates[$i]['lng'] = $row['AID3Lng'];
            }

            $coordinates[$i]['address'] = $row['Address'];
            $coordinates[$i]['product'] = $row['product'];

            $i++;
        }
    }

    echo json_encode($coordinates);
} elseif ($fertilizer == 2 && $product == 3) {
    $sql = $sql ." ". "AND `fact-fertilizer`.`Vol1`-`fact-fertilizer`.`Vol2` <> 0";
    $result = $conn->query($sql);

    $i = 0;

    while ($row = $result->fetch_assoc()) {

        if ($row['product'] == 0) {
            $coordinates[$i]['name'] = $row['Name'];

            if ($row['Latitude'] && $row['Longitude'] != null) {
                $coordinates[$i]['lat'] = $row['Latitude'];
                $coordinates[$i]['lng'] = $row['Longitude'];
            } else {
                $coordinates[$i]['lat'] = $row['AID3Lat'];
                $coordinates[$i]['lng'] = $row['AID3Lng'];
            }

            $coordinates[$i]['address'] = $row['Address'];
            $coordinates[$i]['product'] = $row['product'];

            $i++;
        }
    }

    echo json_encode($coordinates);
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

elseif ($fertilizer == 3 && $product == 0) {

    $sql = $sql ." ". "AND `fact-fertilizer`.`Vol2` = 0";

    $result = $conn->query($sql);

    $i = 0;

    while ($row = $result->fetch_assoc()) {
        $coordinates[$i]['name'] = $row['Name'];

        if ($row['Latitude'] && $row['Longitude'] != null) {
            $coordinates[$i]['lat'] = $row['Latitude'];
            $coordinates[$i]['lng'] = $row['Longitude'];
        } else {
            $coordinates[$i]['lat'] = $row['AID3Lat'];
            $coordinates[$i]['lng'] = $row['AID3Lng'];
        }

        $coordinates[$i]['address'] = $row['Address'];
        $coordinates[$i]['product'] = $row['product'];

        $i++;
    }

    echo json_encode($coordinates);
} elseif ($fertilizer == 3 && $product == 1) {

    $sql = $sql ." ". "AND `fact-fertilizer`.`Vol2` = 0";
    $result = $conn->query($sql);

    $i = 0;

    while ($row = $result->fetch_assoc()) {

        if ($row['product'] > $product_mean) {
            $coordinates[$i]['name'] = $row['Name'];

            if ($row['Latitude'] && $row['Longitude'] != null) {
                $coordinates[$i]['lat'] = $row['Latitude'];
                $coordinates[$i]['lng'] = $row['Longitude'];
            } else {
                $coordinates[$i]['lat'] = $row['AID3Lat'];
                $coordinates[$i]['lng'] = $row['AID3Lng'];
            }

            $coordinates[$i]['address'] = $row['Address'];
            $coordinates[$i]['product'] = $row['product'];
            $i++;
        }
    }

    echo json_encode($coordinates);
} elseif ($fertilizer == 3 && $product == 2) {

    $sql = $sql ." ". "AND `fact-fertilizer`.`Vol2` = 0";
    $result = $conn->query($sql);

    $i = 0;

    while ($row = $result->fetch_assoc()) {

        if ($row['product'] <= $product_mean) {
            $coordinates[$i]['name'] = $row['Name'];

            if ($row['Latitude'] && $row['Longitude'] != null) {
                $coordinates[$i]['lat'] = $row['Latitude'];
                $coordinates[$i]['lng'] = $row['Longitude'];
            } else {
                $coordinates[$i]['lat'] = $row['AID3Lat'];
                $coordinates[$i]['lng'] = $row['AID3Lng'];
            }

            $coordinates[$i]['address'] = $row['Address'];
            $coordinates[$i]['product'] = $row['product'];

            $i++;
        }
    }

    echo json_encode($coordinates);
} elseif ($fertilizer == 3 && $product == 3) {

    $sql = $sql ." ". "AND `fact-fertilizer`.`Vol2` = 0";

    $result = $conn->query($sql);

    $i = 0;

    while ($row = $result->fetch_assoc()) {

        if ($row['product'] == 0) {
            $coordinates[$i]['name'] = $row['Name'];

            if ($row['Latitude'] && $row['Longitude'] != null) {
                $coordinates[$i]['lat'] = $row['Latitude'];
                $coordinates[$i]['lng'] = $row['Longitude'];
            } else {
                $coordinates[$i]['lat'] = $row['AID3Lat'];
                $coordinates[$i]['lng'] = $row['AID3Lng'];
            }

            $coordinates[$i]['address'] = $row['Address'];
            $coordinates[$i]['product'] = $row['product'];

            $i++;
        }
    }

    echo json_encode($coordinates);
}

unset($coordinates);
