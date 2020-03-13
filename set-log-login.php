<?php
function UpdateLogLogin()
{
    // ######## UpdateTime log-login ##########
    $LOG_LOGIN = $_SESSION[md5('LOG_LOGIN')];
    $DIMDate = getDIMDate();
    date_default_timezone_set("Asia/Bangkok");
    $to_time = strtotime(date("Y-m-d H:i", $LOG_LOGIN[1]['StartT']));
    $EndT = time();
    $from_time = strtotime(date("Y-m-d H:i", $EndT));
    $Total = round(abs($to_time - $from_time) / 60, 0);
    $sql = "UPDATE `log-login` SET EndT='" . $EndT . "', EndID='" . $DIMDate[1]['ID'] . "', hrs='" . floor(($Total / 60)) . "', mins='" . ($Total % 60) . "', Total='" . $Total . "' WHERE ID =" . $LOG_LOGIN[1]['ID'];
    updateData($sql);
}

function getUserIpAddr()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        //ip from share internet
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        //ip pass from proxy
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}
function getDIMDate()
{
    $sql = "SELECT * FROM `dim-time` WHERE Date = '" . date('Y-m-d') . "'";
    $DIMTIME = selectData($sql);
    if ($DIMTIME[0]['numrow'] == 0) {
        $yearQuarter = ceil(date("n") / 3);
        date_default_timezone_set("Asia/Bangkok");
        $today = date("m-d");
        $summer = date("m-d", strtotime("2019-02-15"));
        $rainy = date("m-d", strtotime("2019-05-15"));
        $winter = date("m-d", strtotime("2019-10-15"));
        switch (true) {
            case $today >= $summer && $today < $rainy:
                $Season = 3;
                break;
            case $today >= $rainy && $today < $winter:
                $Season = 1;
                break;
            default:
                $Season = 2;
        }
        date_default_timezone_set("Asia/Bangkok");
        $yearQuarter = ceil(date("n") / 3);
        $sql = "INSERT INTO `dim-time`(`Date`,`dd`,`Day`,`Week`,`Season`,`Month`,`Quarter`,`Year1`,`Year2`) VALUES ('" . date("Y-m-d") . "','" . date("j") . "','" . date("w") . "','" . date("W") . "','" . $Season . "','" . date("n") . "','" . $yearQuarter . "','" . date("Y") . "','" . (date("Y") + 543) . "')";
        $idinsert = addinsertData($sql);
        $sql = "SELECT * FROM `dim-time` WHERE ID = '" . $idinsert . "'";
        $DIMTIME = selectData($sql);
    }
    return $DIMTIME;
}
function NewLogLogin()
{
    $idtype = $_SESSION[md5('typeid')];
    $DATA = $_SESSION[md5('user')];
    $sql = "SELECT * FROM `dim-user` WHERE dbID='" . $DATA[1]['UID'] . "' AND Type='U' AND Title='" . $DATA[1]['Title'] . "' AND FullName ='";
    if ($DATA[1]['Title'] == 1) {
        $sql = $sql . "นาย";
    } else if ($DATA[1]['Title'] == 2) {
        $sql = $sql . "นาง";
    } else {
        $sql = $sql . "นางสาว";
    }
    $sql = $sql . " " . $DATA[1]['FirstName'] . " " . $DATA[1]['LastName'] . "' AND Alias = '" . $DATA[1]['FirstName'] . "' ";
    $DIMUSER = selectData($sql);
    $DIMTIME = getDIMDate();
    $sql = "INSERT INTO `log-login`(`AccessType`,`DIMuserID`,`dbUTID`,`StartT`,`StartID`,`EndT`,`EndID`,`IP`,`hrs`,`mins`,`Total`) VALUES ('W','" . $DIMUSER[1]['ID'] . "','" . $idtype . "','" . time() . "','" . $DIMTIME[1]['ID'] . "','" . time() . "','" . $DIMTIME[1]['ID'] . "','" . getUserIpAddr() . "','0','0','0')";
    $IDLOGIN = addinsertData($sql);
    $sql = "SELECT * FROM `log-login` WHERE ID='" . $IDLOGIN . "' ";
    $LOG_LOGIN = selectData($sql);
    $_SESSION[md5('LOG_LOGIN')] = $LOG_LOGIN;
}
function IsBlock()
{
    $DATA = $_SESSION[md5('user')];
    $sql = "SELECT * FROM `db-user` WHERE `UID` = '" . $DATA[1]['UID'] . "'";
    $DATA = selectData($sql);
    if ($DATA[1]['IsBlock'] == 1) {
        header("location:../../index.php?error=3");
    }
}
