<?php
session_start();
$UTID = $_GET['UTID'];
$_SESSION[md5('typeid')] = $UTID;

include_once("./set-log-login.php");
include_once("./dbConnect.php");
UpdateLogLogin();
NewLogLogin();
header("location:./view/UserProfile/UserProfile.php");
