<?php
include_once("./dbConnect.php");
//$username = $_POST['username'];
//$password = $_POST['password'];
session_start();
session_unset();
$username = $_POST['username'];
$password = $_POST['password']; 

print "user $username passwd $password-".$password."'";
$sql = "SELECT * FROM `db-user` WHERE `UserName` = '".$username."' AND `PWD` = '".$password."'";
//echo $sql ;
$DATA = selectData( $sql );
print_r($DATA);
// print($DATA[1]['u-is-admin']);
// print($DATA[1]['u-is-researcher']);
// print($DATA[1]['u-is-officer']);
// print($DATA[1]['u-is-farmer']);
//echo "<br>";
//echo (sizeof($DATA));
if(sizeof($DATA) == 2)
{
    
    if($DATA[1]['IsAdmin'] == 1)
    {
        header("location:./view/UserProfile/UserProfile.php");
        $typeid = 1 ;
    }
    else if($DATA[1]['IsResearch'] == 1)
    {
        header("location:./view/UserProfile/UserProfile.php");
        $typeid = 2;
    }
    else if($DATA[1]['IsOperator'] == 1)
    {
        header("location:./view/UserProfile/UserProfile.php");
        $typeid = 3 ;
    }
    else if($DATA[1]['IsFarmer']== 1)
    {   
        header("location:./view/UserProfile/UserProfile.php");
        $typeid = 4;
    }
    else {
        //header("location:index.php");

    }
    $_SESSION[md5('LAST_ACTIVITY')] = $_SERVER['REQUEST_TIME'];

    $_SESSION[md5('username')] = $username;
    $_SESSION[md5('typeid')] = $typeid;
    $_SESSION[md5('user')]   = $DATA;
    //print_r($_SESSION[md5('user')]);
}
else
{
    //echo "xxxx";
    header("location:index.php");
}
//print $_SESSION[md5('username')];
//$_SESSION[md5('userid')]   = $userid;
//header("location:OtherUsersList.php");
?>
