<!DOCTYPE html>
<html lang="en" style="overflow-y: hidden;">

<!-- Setting Session Variable -->
<?php
include_once("../../dbConnect.php");
//Set log-login
include_once("../../set-log-login.php");
UpdateLogLogin();
IsBlock();

$USER = $_SESSION[md5('user')];
$iconpic = $USER[1]['Icon'];
$userId = $USER[1]['UID'];
if ($iconpic != "default.jpg") {
  $userIdicon = $USER[1]['UID'];
} else {
  $userIdicon = '0';
}

if (!isset($_SESSION[md5('LOG_LOGIN')])) {
  header("location:../../index.php");
}
$sql = "SELECT * FROM `db-user` WHERE `UID` = '" . $userId . "'";
$DATA = selectData($sql);
if ($DATA[0]['numrow'] == 0) {
  header("location:../../index.php");
}

//get user info 
$DATAUSER = $_SESSION[md5('user')];
$sql = "SELECT * FROM `user-type` WHERE UTID = " . $idUT;
$DATATPYEUSER = selectData($sql);
$sql = "SELECT * FROM `user-type` ORDER BY UTID";
$DATATPYE = selectData($sql);
$color = "#006664";
//Set pointer menu
$sql = "SELECT `mm-mainmenu`,`mm-submenu` ";
$sql = $sql . " FROM `main-menu-list` as L INNER JOIN `web-menu` as M ";
$sql = $sql . " ON L.`wm-id`= M.`wm-id` ";
$sql = $sql . " WHERE `ut-id`='" . $idUT . "'";
$sql = $sql . " && `wm-alias`='" . $CurrentMenu. "'";

//echo $sql."<br>";
$DATA = selectData($sql);

$selectedMenu1 = $DATA[1]['mm-mainmenu'];
$selectedMenu2 = $DATA[1]['mm-submenu'];

//Create menu list
$sql = "SELECT `mm-mainmenu`,`mm-submenu`,`wm-name`, `wm-alias`, `wm-page`, `wm-icon`, `wm-note`";
$sql = $sql . " FROM `main-menu-list` as L JOIN `web-menu` as M ";
$sql = $sql . " ON L.`wm-id`=M.`wm-id` ";
$sql = $sql . " WHERE L.`ut-id`=" . $idUT;
$sql = $sql . " ORDER BY L.`mm-mainmenu`,L.`mm-submenu`";

//echo $sql;

$DATA = selectData($sql);


$strMenu = "";

for ($i = 1; $i <= $DATA[0]['numrow']; $i++) {
  
  if ($DATA[$i]['mm-submenu'] == 0) {
    // main menu
    $activeStyle = "";
    $isActive = "";
    if ($DATA[$i]['mm-mainmenu'] == $selectedMenu1) {
      // active main menu
      $classType = " class='nav-item active' ";
      $isActive = " id='activityList' ";
      if($DATA[$i]['mm-mainmenu'] != $DATA[$i + 1]['mm-mainmenu'])
        $activeStyle = " style='background-color:yellow; color:#006664;' ";
    } else {
      //$activeStyle = " style='background-color:red; color:#006664;' ";
      $classType = " class='nav-item' ";
    }

    if ($DATA[$i]['wm-icon'] == "") {
      $icon = "favorite";
    } else {
      $icon =  $DATA[$i]['wm-icon'];
    }
    $url = $DATA[$i]['wm-alias']."/".$DATA[$i]['wm-page'];
    
    if ($DATA[$i]['mm-mainmenu'] != $DATA[$i + 1]['mm-mainmenu']){
      $strMenu .= "
      <li ".$classType." ".$isActive." >
        <a class='nav-link' href='../".$url."' ".$activeStyle." >
          <i class='material-icons' ".$activeStyle.">".$icon."</i>
          <span>".$DATA[$i]['wm-name']."</span>
        </a>
      </li> ";
    }else{
      $strMenu .= " 
      <li ".$classType." ".$isActive." >
        <a class='nav-link collapsed' href='#' 
          data-toggle='collapse' data-target='#link-".$i."' 
          aria-expanded='true' aria-controls='link-" .$i."'>
            <i class='material-icons'>".$icon."</i>
            <span>".$DATA[$i]['wm-name']."</span>
        </a>
        <div id='link-".$i."' class='collapse' 
          aria-labelledby='headingTwo' data-parent='#accordionSidebar'>
        <div class=' py-2 collapse-inner rounded' 
          style='border-left: 2px solid white; border-radius: 0% !important;'>";
      //$strMenu .= "</div></div></li>";
    }

  }else{ // sub menu
    if ($DATA[$i]['mm-mainmenu'] == $selectedMenu1 && $DATA[$i]['mm-submenu'] == $selectedMenu2) {
      // active sub menu
      $classType = "class='collapse-item active' style='background-color:yellow'";
    } else {
      $classType = "class='collapse-item'";
    }
    $url = $DATA[$i]['wm-alias']."/".$DATA[$i]['wm-page'];
    $strMenu .= "<a ". $classType." href='../".$url."' 
    style='color:white;'>". $DATA[$i]['wm-name']."</a>";
    
    if ($DATA[$i]['mm-mainmenu'] != $DATA[$i + 1]['mm-mainmenu']) 
      $strMenu .= "</div></div></li>"; 

  }
}

/*
for ($i = 1; $i <= $DATA[0]['numrow']; $i++) {
  if ($DATA[$i]['mm-submenu'] == 0) {
    // main menu
    if ($DATA[$i]['mm-mainmenu'] == $selectedMenu1) {
      // active main menu
      $classType = " class='nav-item active' ";
    } else {
      $classType = " class='nav-item' ";
    }

    if ($DATA[$i]['wm-icon'] == "") {
      $icon = "favorite";
    } else {
      $icon =  $DATA[$i]['wm-icon'];
    }


    if (($i + 1 <= $DATA[0]['numrow'] && 
          $DATA[$i]['mm-mainmenu'] != $DATA[$i + 1]['mm-mainmenu']) || 
          $DATA[$i]['wm-name'] == "ออกจากระบบ") {
      $url  = $DATA[$i]['wm-alias'] . "/" . $DATA[$i]['wm-page'];

      if ($DATA[$i]['wm-name'] == "กิจกรรมต่างๆ" || 
          $DATA[$i]['wm-name'] == "การจัดการผู้ใช้" || 
          $DATA[$i]['wm-name'] == "การจัดการศัตรูพืช") {
        $strMenu .= " <li " . $classType . " id='activityList'>
                            <a class='nav-link' href='../" . $url . "'>
                              <i class='material-icons'>" . $icon . "</i>
                              <span>" . $DATA[$i]['wm-name'] . "</span>
                            </a>
                          </li>";
      } else {
        $strMenu .= " <li " . $classType . ">
                            <a class='nav-link' href='../" . $url . "'>
                              <i class='material-icons'>" . $icon . "</i>
                              <span>" . $DATA[$i]['wm-name'] . "</span>
                            </a>
                          </li>";
      }
    } else {

      if ($DATA[$i]['wm-name'] == "กิจกรรมต่างๆ" || 
          $DATA[$i]['wm-name'] == "การจัดการผู้ใช้" || 
          $DATA[$i]['wm-name'] == "การจัดการศัตรูพืช") {
        $strMenu .= " <li class='nav-item' id='activityList'>
                            <a class='nav-link collapsed' href='#' data-toggle='collapse' data-target='#link-" . $i . "' aria-expanded='true' aria-controls='link-" . $i . "'>
                              <i class='material-icons'>" . $icon . "</i>
                              <span>" . $DATA[$i]['wm-name'] . "</span>
                            </a>
                            <div id='link-" . $i . "' class='collapse' aria-labelledby='headingTwo' data-parent='#accordionSidebar'>
                              <div class=' py-2 collapse-inner rounded' style='border-left: 2px solid white; border-radius: 0% !important;'>";
      } else {
        $strMenu .= " <li class='nav-item'>
                            <a class='nav-link collapsed' href='#' data-toggle='collapse' data-target='#link-" . $i . "' aria-expanded='true' aria-controls='link-" . $i . "'>
                              <i class='material-icons'>" . $icon . "</i>
                              <span>" . $DATA[$i]['wm-name'] . "</span>
                            </a>
                            <div id='link-" . $i . "' class='collapse' aria-labelledby='headingTwo' data-parent='#accordionSidebar'>
                              <div class=' py-2 collapse-inner rounded' style='border-left: 2px solid white; border-radius: 0% !important;'>";
      }
    }
  } else {
    //sub menau
    if ($DATA[$i]['mm-submenu'] == $selectedMenu2) {
      // active sub menu
      $classType = "class='collapse-item active'";
    } else {
      $classType = "class='collapse-item'";
    }

    $strMenu .= "<a " . $classType . " href='../" . $DATA[$i]['wm-alias'] . "/" . $DATA[$i]['wm-page'] . " ' style='color:white;'>" . $DATA[$i]['wm-name'] . "</a>";

    if ($DATA[$i]['mm-mainmenu'] != $DATA[$i + 1]['mm-mainmenu']) {
      $strMenu .= "</div>
                      </div>
                    </li>";
    }
  }
} //each menu  
*/

// change Type
$strtpye = "";
$AmountChangeType = 0;

if ($DATAUSER[1]['IsAdmin'] == 1 && $idUT != 1) {
  $strtpye = $strtpye . "<a class='dropdown-item' href='../../changeType.php?UTID=1'>
    <i class='fas fa-user fa-sm fa-fw mr-2 text-gray-400'></i>
    " . $DATATPYE[1]['UTName'] . "
    </a>";
  $AmountChangeType++;
}
if ($DATAUSER[1]['IsAdmin2'] == 1 && $idUT != 6) {
  $strtpye = $strtpye . "<a class='dropdown-item' href='../../changeType.php?UTID=6'>
  <i class='fas fa-user fa-sm fa-fw mr-2 text-gray-400'></i>
  " . $DATATPYE[6]['UTName'] . "
  </a>";
  $AmountChangeType++;
}
if ($DATAUSER[1]['IsResearch'] == 1 && $idUT != 2) {
  $strtpye = $strtpye . "<a class='dropdown-item' href='../../changeType.php?UTID=2'>
  <i class='fas fa-user fa-sm fa-fw mr-2 text-gray-400'></i>
  " . $DATATPYE[2]['UTName'] . "
  </a>";
  $AmountChangeType++;
}
if ($DATAUSER[1]['IsOperator'] == 1 && $idUT != 3) {
  $strtpye = $strtpye . "<a class='dropdown-item' href='../../changeType.php?UTID=3'>
  <i class='fas fa-user fa-sm fa-fw mr-2 text-gray-400'></i>
  " . $DATATPYE[3]['UTName'] . "
  </a>";
  $AmountChangeType++;
}

?>

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <!-- <link rel="icon" href="../../picture/cowicon.png"> -->
  <link href="https://fonts.googleapis.com/css?family=Kanit&display=swap" rel="stylesheet">

  <title>ระบบติดตามงานจัดการสวนปาล์มน้ำมัน</title>

  <?php include_once("MainCSS.php"); ?>
  <style>
    h1,
    h2,
    h3,
    h4,
    h5,
    h6,
    span,
    p,
    label,
    div {
      font-family: 'Kanit', sans-serif;
    }

    #accordionSidebar {
      background-color: <?= $color ?>;
    }
  </style>

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav  sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#" style="cursor:default;">
        <div class="sidebar-brand-icon rotate-n-15">
          <!-- <i class="fas fa-laugh-wink"></i>ระบบบริหารจัดการแปลงปลูก -->
          <img src="../../icon/logo/KU.png" style="width:50px; transform: rotate(15deg);">
        </div>
        <div class="sidebar-brand-text mx-3">ปาล์มน้ำมัน</div>
      </a>


      <!-- Divider -->
      <hr class="sidebar-divider my-0">
      <div style="overflow-y: scroll; overflow-x: hidden; max-height:75vh; margin-right: 1%;" id="barP">
        <?php echo $strMenu; ?>
      </div>
      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>


    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content" style="background-color: #EBF5FB;">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <ul>
            <div class="text-left" style="padding-top:20px;color:<?= $color ?>">
              <h5>ระบบติดตามงานจัดการสวนปาล์มน้ำมัน</h5>
            </div>
          </ul>
          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">


            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $DATAUSER[1]['UserName'] . " (" . $DATATPYEUSER[1]['UTName'] . ")"; ?></span>

                <img class="img-radius img-profile" src="../../icon/user/<?php echo $userIdicon; ?>/<?php echo $iconpic; ?>" />
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="../UserProfile/UserProfile.php">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  <span style="color: black;">บัญชีผู้ใช้</span>
                </a>
                <div class="dropdown-divider"></div>
                <?php if ($AmountChangeType != 0) { ?>
                  <a class="dropdown-item " data-toggle="dropdown" id="userDropdown2">
                    <i class="fas fa-cog fa-sm fa-fw mr-2 text-gray-400"></i>
                    <span style="color: black;">เปลี่ยนสถานะ</span>
                  </a>
                  <!-- Dropdown subInformation -->
                  <div class="dropdown-menu dropdown-menu-left shadow animated--grow-in" aria-labelledby="userDropdown2">
                    <?php echo $strtpye; ?>
                  </div>
                  <div class="dropdown-divider"></div>
                <?php } ?>

                <a class="dropdown-item" href="../../Logout.php">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  <span style="color: black;">ออกจากระบบ</span>
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid" style="overflow-y:scroll; max-height:100vh; padding-top: 1.5rem!important; padding-bottom: 6.5rem!important;">