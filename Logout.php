<?php
session_start();
include_once("./set-log-login.php");
include_once("./dbConnect.php");
UpdateLogLogin();
echo "out";
session_destroy();
header("location:index.php");
