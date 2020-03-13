<?php
include_once("./dbConnect.php");
//$username = $_POST['username'];
//$password = $_POST['password'];
session_start();
session_unset();
$username = $_POST['username'];
$password = $_POST['password1'];
$sql = "SELECT * FROM `db-user` WHERE `UserName` = '" . $username . "'";
$DATA = selectData($sql);
if ($DATA[0]['numrow'] == 1) {
    $UID = $DATA[1]['UID'];
    print "<br>UID $UID user $username passwd $password-" . md5($UID . strtoupper($username) . $password);
    $sql = "SELECT * FROM `db-user` WHERE `UserName` = '" . $username . "' AND `PWD` = '" . md5($UID . strtoupper($username) . $password) . "'";
    echo $sql;
    $DATA = selectData($sql);
    print_r($DATA);
    // print($DATA[1]['u-is-admin']);
    // print($DATA[1]['u-is-researcher']);
    // print($DATA[1]['u-is-officer']);
    // print($DATA[1]['u-is-farmer']);

    if (sizeof($DATA) == 2) {
        if (isset($_POST['remember'])) {
            echo  "<br> test:" . $username . $password . "<br>";
            setcookie("username", $username, time() + (10 * 365 * 24 * 60 * 60));
            setcookie("password", $password, time() + (10 * 365 * 24 * 60 * 60));
            echo  "<br> testcookie:" . $_COOKIE['username'] . $_COOKIE['password'] . "<br>";
        } else {
            setcookie("username");
            setcookie("password1");
        }
        if ($DATA[1]['IsBlock'] != 1) {
            if ($DATA[1]['IsOperator'] == 1) {
                header("location:./view/UserProfile/UserProfile.php");
                $typeid = 3;
            } else if ($DATA[1]['IsResearch'] == 1) {
                header("location:./view/UserProfile/UserProfile.php");
                $typeid = 2;
            } else if ($DATA[1]['IsAdmin2'] == 1) {
                header("location:./view/UserProfile/UserProfile.php");
                $typeid = 6;
            } else if ($DATA[1]['IsAdmin'] == 1) {
                header("location:./view/UserProfile/UserProfile.php");
                $typeid = 1;
            } else {
                header("location:index.php");
            }

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
            $sql = "INSERT INTO `log-login`(`AccessType`,`DIMuserID`,`dbUTID`,`StartT`,`StartID`,`EndT`,`EndID`,`IP`,`hrs`,`mins`,`Total`) VALUES ('W','" . $DIMUSER[1]['ID'] . "','" . $typeid . "','" . time() . "','" . $DIMTIME[1]['ID'] . "','" . time() . "','" . $DIMTIME[1]['ID'] . "','" . getUserIpAddr() . "','0','0','0')";
            $IDLOGIN = addinsertData($sql);

            $sql = "SELECT * FROM `log-login` WHERE ID='" . $IDLOGIN . "' ";
            $LOG_LOGIN = selectData($sql);

            $_SESSION[md5('LAST_ACTIVITY')] = $_SERVER['REQUEST_TIME'];
            $_SESSION[md5('username')] = $username;
            $_SESSION[md5('typeid')] = $typeid;
            $_SESSION[md5('user')]   = $DATA;
            $_SESSION[md5('LOG_LOGIN')] = $LOG_LOGIN;

            print_r($_SESSION[md5('user')]);
        } else {
            header("location:index.php?error=3");
        }
    } else {
        header("location:index.php?error=2");
    }
} else {
    header("location:index.php?error=2");
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

//print $_SESSION[md5('username')];
//$_SESSION[md5('userid')]   = $userid;
//header("location:OtherUsersList.php");
