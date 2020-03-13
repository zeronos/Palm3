<?php
require_once("../../dbConnect.php");
connectDB();
session_start();
$idUT = $_SESSION[md5('LOG_LOGIN')];
$farmID = $_SESSION["farmID"];
$DIMfarmID = $_SESSION["DIMfarmID"];
$ownerID = $_SESSION["ownerID"];
$DIMownerID = $_SESSION["DIMownerID"];
?>

<?php 
     $request = $_POST['request'];
     $sql = '';
     // echo $request;
     switch($request){
          case 'select':
               $sql = "SELECT * FROM `log-harvest` ";

               print_r(json_encode(select($sql)));
               break;
        
          case 'insert':
               $date =date_create( $_POST['date']);
               $modify = strtotime(date_format($date,'d F Y'));
               
               $DIMuserID = $DIMownerID;
               
               $LOGLoginID=$idUT[1]['ID'];

               $today=date('Y-m-d',time());
               echo $today;
               $sql = "SELECT `ID` FROM `dim-time` WHERE `Date`= '$today'";
               $myConDB = connectDB();
               $result = $myConDB->prepare( $sql ); 
               $result->execute();        
               while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    $DIMdateID = $row['ID'];
               }

               $fid= $farmID;

               $DIMSubfID=$_POST['SubFarmID'];
               $sql = "SELECT `ID` FROM `dim-farm` WHERE `isFarm` = 0 AND `dbID`=$DIMSubfID";
               $myConDB = connectDB();
               $result = $myConDB->prepare( $sql ); 
               $result->execute();        
               while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    $DIMSubfID = $row['ID'];
               }

               $weight = $_POST['weight'];
               $UnitPrice = $_POST['UnitPrice'];
               $TotalPrice = $weight * $UnitPrice;

               $PIC = "picture/activities/harvest/";

               $sql = "INSERT INTO `log-harvest`( `isDelete`, `GuessFrom`, `Modify`, `LOGloginID`, `DIMdateID`, `DIMownerID`, `DIMfarmID`, `DIMsubFID`, `Weight`, `UnitPrice`, `TotalPrice`, `PICs`) 
               VALUES (0,null,$modify,$LOGLoginID,$DIMdateID,$DIMownerID,$fid,$DIMSubfID,$weight,$UnitPrice,$TotalPrice,'$PIC')";

               echo $sql;
               $result = addinsertData($sql);
               echo $result;
               if ($result) {
                    header("location:OilPalmAreaVolDetail.php");
               } else {
                    echo "ERROR" . $sql . "<BR>" . $conn->error;
                    header("location:OilPalmAreaVolDetail.php");
               }
          break;

          case 'update':
               $fid =  $_POST['fid'];
               $sql ="UPDATE `log-harvest` SET `isDelete` = 1 WHERE ID = $fid";
               $text = updateData($sql);
               echo $text;
               header("location:OilPalmAreaVolDetail.php");
          break;

          case 'setFarmID':
               $_SESSION["farmID"] = $_POST['farmID'];
               header("location:OilPalmAreaVolDetail.php");
          break;

          case 'getYear':

               $month = null;
               $num=0;
               $year = $_POST['year'];
               $sql="SELECT * , `log-harvest`.`ID` as IDfarm , `db-subfarm`.`Alias` as Alias FROM `log-harvest`
                    JOIN `dim-farm` ON `log-harvest`.`DIMfarmID` = `dim-farm`.`ID`
                    JOIN `dim-user` ON `log-harvest`.`DIMownerID` = `dim-user`.`ID`
                    JOIN `db-subfarm` ON `dim-farm`.`dbID` = `db-subfarm`.`FMID` 
                    WHERE `dim-user`.`dbID` = $ownerID AND `dim-farm`.`dbID` = $farmID AND `db-subfarm`.`FMID` = $farmID AND `isDelete`= 0 AND `isFarm` = 1";
                $myConDB = connectDB();
                 $result = $myConDB->prepare( $sql ); 
                 $result->execute(); 
                          while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                              if((int)date('Y',$row["Modify"]) + 543==$year){
                                   $month["$num"]["ID"] = $row['IDfarm'];
                                   $month["$num"]["alias"] = $row['Alias'];
                                   $month["$num"]["modifyday"] = date('d',$row["Modify"]);
                                   $month["$num"]["modifymonth"] = date('n',$row["Modify"]);
                                   $month["$num"]["modifyyear"] = date('Y',$row["Modify"])+543;
                                   $month["$num"]["weight"] = $row['Weight'];
                                   $month["$num"]["price"] = $row['UnitPrice'];
                                   $month["$num"]["totalprice"] = $row['TotalPrice'];
                                   
                                   $num++;
                              }
                          }
               echo json_encode($month);
          break;

     } 

?>