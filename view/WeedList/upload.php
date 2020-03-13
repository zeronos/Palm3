<?php
session_start();

function getImg($img)
{
  if ($img != null) {
    $data = $img;
    $img_array = explode(';', $data);
    $img_array2 = explode(",", $img_array[1]);
    $dataI = base64_decode($img_array2[1]);

    return $dataI;
  } else return null;
}
require "../../dbConnect.php";
$request = $_POST['request'];
require_once("../../set-log-login.php");

$loglogin = $_SESSION[md5('LOG_LOGIN')];
$loglogin_id = $loglogin[1]['ID'];
$startID = $loglogin[1]['StartID'];

switch ($request) {

  case 'select':
    $sql = "SELECT * FROM `db-pestlist`";

    print_r(json_encode(select($sql)));
    break;
  case 'insert2':
    $a = explode('manu20', $_POST['pic2']);
    $b = sizeof($a) - 1;
    for ($i = 0; $i < $b; $i++) {
      echo $a[$i];
    }
    break;
  case 'insert':

    $Name =  $_POST['name_insert'];
    $Alias = $_POST['alias_insert'];
    $Charactor = $_POST['charactor_insert'];
    $Danger = $_POST['danger_insert'];

    $t = time();

    $dataLogo = getImg($_POST['pic1']);
    $nameImg1 = null;
    if ($dataLogo != null) {
      $nameImg1 = time() . ".png";
    }

    $dataPic2 = explode('manu20', $_POST['pic2']);
    $countfiles_style = sizeof($dataPic2) - 1;

    $dataPic3 = explode('manu20', $_POST['pic3']);
    $countfiles_danger = sizeof($dataPic3) - 1;

    $sql = "INSERT INTO `db-pestlist` (`PID`, `Name`, `Alias`, `PTID`, `Charactor`, `Danger`, `Icon` , `NumPicChar`, `NumPicDanger`)
          VALUES ('','$Alias','$Name','3','$Charactor','$Danger','$nameImg1','$countfiles_style','$countfiles_danger')";
    //echo $sql;
    $insertData = addinsertData($sql);
    echo $insertData;
    $sql = "SELECT `PID` FROM `db-pestlist` ORDER BY `PID` DESC LIMIT 1";
    $id = selectDataOne($sql)['PID'];



    //-------------------------------------------------------- log and dim --------------------------------------------------------


    $path = "../../icon/pest/$id";
    if (!file_exists($path)) {
      mkdir("../../icon/pest/$id");
      mkdir("../../picture/Pest/weed/style/$id");
      mkdir("../../picture/Pest/weed/danger/$id");
    }
    if ($dataLogo != null) {
      file_put_contents("../../icon/pest/$id/$nameImg1", $dataLogo);
    }
    if ($countfiles_style > 0) {
      for ($i = 0; $i < $countfiles_style; $i++) {
        if ($i == 0)
          $nameImg2 = $nameImg1;
        else $nameImg2 = ($i - 1) . "_" . $nameImg1;
        $Pic2 = getImg($dataPic2[$i]);
        file_put_contents("../../picture/Pest/weed/style/$id/$nameImg2", $Pic2);
      }
    }

    if ($countfiles_danger > 0) {
      for ($i = 0; $i < $countfiles_danger; $i++) {
        if ($i == 0)
          $nameImg3 = $nameImg1;
        else $nameImg3 = ($i - 1) . "_" . $nameImg1;
        $Pic3 = getImg($dataPic3[$i]);
        file_put_contents("../../picture/Pest/weed/danger/$id/$nameImg3", $Pic3);
      }
    }
    $did = addinsertData($sql);
    $dptid = addinsertData($sql);
    $DATA = select_dimPest();
    //$pesttype = T_STRING_CAST"SELECT `TypeTH` FROM `db-pesttype` WHERE `PTID` = 1";
    $i = 1;
    $check_dim = 1;
    for ($i = 1; $i <= $DATA[0]['numrow']; $i++) {
      if ($DATA[$i]['dbpestLID'] == $did && $DATA[$i]['dbpestTID'] == $dptid && $DATA[$i]['Name'] == $Name && $DATA[$i]['Alias'] == $Alias  && $DATA[$i]['Charactor'] == $Charactor && $DATA[$i]['Danger'] == $Danger && $DATA[$i]['TypeTH'] == $type) {
        $check_dim = 0;
        break;
      }
    }
    echo   "<script>
                            console.log('$check_dim');
                            </script>";
    if ($check_dim) {

      $sql = "SELECT `TypeTH` FROM `db-pesttype` WHERE `PTID` = 3";

      $myConDB = connectDB();
      $result = $myConDB->prepare($sql);
      $result->execute();
      while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $ptid = $row['TypeTH'];
      }
      $last_id = last_id();

      //echo $last_id;
      //echo toString($ptid);
      $sql = "INSERT INTO `dim-pest` (`ID`,`dbpestLID`,`dbpestTID`,`Name`,`Alias`,`Charactor`,`Danger`,`TypeTH`) 
                  VALUES ('','$last_id','3','$Name','$Alias','$Charactor','$Danger','$ptid')";
      echo "
      <script>
        alert($sql)
      </script>";


      $id_d = addinsertData($sql);
      // echo $id_d;
      $data_t =  getDIMDate();
      $id_t = last_id();
      // echo $id_t;

      // echo $id_t[1]['ID'];

      echo   "<script>
                            console.log($loglogin_id );
                            </script>";
      $sql = "INSERT INTO `log-pest` (`ID`,`DIMpestID`,`LOGloginID`,`StartT`,`StartID`,`EndT`,`EndID`,`NumPicChar`,`NumPicDanger`) 
                      VALUES ('','$id_d','$loglogin_id','$t','$startID',NULL,NULL,'$countfiles_style','$countfiles_danger')";
      echo $sql;
      $did = addinsertData($sql);
      echo $did;
    }

    header("location:WeedList.php");
    break;

  case 'delete';
    $pid = $_POST['pid'];

    // echo   "$department";
    // echo   "$alias";
    // echo   "$note";
    $sql = "DELETE FROM `db-pestlist` WHERE `PID`='" . $pid . "'";
    delete($sql);

    break;

  case 'update':
    echo   "<script>
      console.log('sfdsf');
      </script>";

    $pid = $_POST['e_pid'];
    $nameinsect =  trim($_POST['e_name']);
    $alias = trim($_POST['e_alias']);
    $charstyle = trim($_POST['e_charactor']);
    $dangerInsect = trim($_POST['e_danger']);

    $nameinsect = preg_replace('/[[:space:]]+/', ' ', trim($nameinsect));
    $alias = preg_replace('/[[:space:]]+/', ' ', trim($alias));

    $o_nameinsect = trim($_POST['e_o_name']);
    $o_alias = trim($_POST['e_o_alias']);
    $o_charstyle = trim($_POST['e_o_charcator']);
    $o_dangerInsect = trim($_POST['e_o_danger']);

    echo "$pid";
    $sql =   "UPDATE `db-pestlist` 
                  SET `Name`='$alias', `Alias`='$nameinsect', `Charactor`='$charstyle' , `Danger`='$dangerInsect'
                  WHERE `PID`=$pid ";
    echo $sql;
    $re = updateData($sql);
    echo $re;

    // ------------------------------------- DIM AND LOG -------------------------------------
    $DATA = select_dimPest();
    $i = 1;
    $check_dim = 1;
    for ($i = 1; $i <= $DATA[0]['numrow']; $i++) {
      if ($DATA[$i]['dbpestLID'] == $re && $DATA[$i]['dbpestTID'] == $dptid && $DATA[$i]['Name'] == $Name && $DATA[$i]['Alias'] == $Alias  && $DATA[$i]['Charactor'] == $Charactor && $DATA[$i]['Danger'] == $Danger && $DATA[$i]['TypeTH'] == $type) {
        $check_dim = 0;
        break;
      }
    }
    // ------------------------------------- if DIM don't duplicated -------------------------------------
    if ($check_dim) {

      $sql = "SELECT `TypeTH` FROM `db-pesttype` WHERE `PTID` = 3";

      $myConDB = connectDB();
      $result = $myConDB->prepare($sql);
      $result->execute();
      while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $ptid = $row['TypeTH'];
      }
      $last_id = last_id();

      //echo $last_id;
      //echo toString($ptid);
      $sql = "INSERT INTO `dim-pest` (`ID`,`dbpestLID`,`dbpestTID`,`Name`,`Alias`,`Charactor`,`Danger`,`TypeTH`) 
                  VALUES ('','$last_id','3','$nameinsect','$alias','$charstyle','$dangerInsect','$ptid')";
      echo "
        <script>
          alert($sql)
        </script>";
      $id_d = addinsertData($sql);
    }

    $time = time();
    $data_t =  getDIMDate();
    $id_t = $data_t[1]['ID'];
    $loglogin = $_SESSION[md5('LOG_LOGIN')];
    $loglogin_id = $loglogin[1]['ID'];

    if ($o_nameinsect == $nameinsect && $o_alias == $alias && $o_charstyle == $charstyle && $o_dangerInsect == $o_dangerInsect) {
    } else {
      echo $o_log_id;
      $sql = "UPDATE `log-pest` 
                    SET EndT='$time', EndID='$id_t'
                    WHERE ID='$o_log_id' AND EndT IS NULL";

      $re = updateData($sql);

      $sql = "INSERT INTO `log-pest` (`ID`,`DIMpestID`,`LOGloginID`,`StartT`,`StartID`,`EndT`,`EndID`,`NumPicChar`,`NumPicDanger`) 
          VALUES ('','$id_d','$loglogin_id','$time','$startID',NULL,NULL,'$countfiles_style','$countfiles_danger')";
      echo $sql;
      $did = addinsertData($sql);
      echo $did;

      echo   "<script>
                            console.log($loglogin_id );
                            </script>";

      $did = addinsertData($sql);
      echo $did;
    }
    header("location:WeedList.php");
    break;
}

function last_id()
{
  $sql = "SELECT MAX(`PID`)as max FROM `db-pestlist`";
  $myConDB = connectDB();
  $result = $myConDB->prepare($sql);
  $result->execute();
  while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $max =  $row['max'];
  }
  //$max = selectData($sql);
  return $max;
}
function select_dimPest()
{
  $sql = "SELECT * FROM `dim-pest`";

  $DATA = selectData($sql);
  return $DATA;
}
function getDIM($did, $o_name, $o_alias, $o_char, $o_dan, $o_ptid, $o_type)
{
  $sql = "SELECT * FROM `dim-pest` WHERE `dbpestLID`='$did' AND `Name`='$o_name' AND `Alias`='$o_alias' 
                AND `Charactor`='$o_char' AND `Danger`='$o_dan' AND `dbpestTID`='$o_ptid' AND `TypeTH`='$o_type'";

  $DATA = selectData($sql);
  return $DATA;
}
function getLog($dim_id)
{
  $sql = "SELECT * FROM `log-pest` WHERE `DIMpestID`='$dim_id' AND `EndT` IS NULL";

  $DATA = selectData($sql);
  return $DATA;
}
