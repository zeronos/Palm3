<?php
session_start();
include_once("../../set-log-login.php");
include_once("../../dbConnect.php");
UpdateLogLogin();
session_destroy();
header("location:../../index.php");
