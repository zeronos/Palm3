<?php

session_start();

$idUT = $_SESSION[md5('typeid')];
$CurrentMenu = "OtherPestList";

/*
if (isset($_POST['insert'])) {
    try {
        $pdoConnect = new PDO("mysql:host=localhost;dbname=palmWeb2562;", "root", "",);
    } catch (PDOException $exc) {
        echo $exc->getMessage();
        exit();
    }

    $PL_NAME = $_POST['name'];
    $PL_NAME_OFFICE = $_POST['office-name'];
    $PL_CHAR = $_POST['style'];
    $PL_DANGER = $_POST['style-danger'];

    $pdoQuerry = "INSERT INTO `pest_lists`(`PL_ID`, `PL_NAME`, `PL_NAME_OFFICE`, `PT_ID`, `PL_CHAR`, `PL_DANGER`, `PL_IS_LOGO`, `PL_PIC_CHAR`, `PL_PIC_DANGER`) 
                    VALUES (:PL_ID,:PL_NAME,:PL_NAME_OFFICE,:PT_ID,:PL_CHAR,:PL_DANGER,:PL_IS_LOGO,:PL_PIC_CHAR,:PL_PIC_DANGER)";
    $pdoResult = $pdoConnect->prepare($pdoQuerry);
    $pdoExac = $pdoResult->execute(array(":PL_NAME=>$PL_NAME,:PL_NAME_OFFICE=>$PL_NAME_OFFICE,:PL_CHAR=>$PL_CHAR,:PL_DANGER=>$PL_DANGER"));

    if ($pdoExac) {
        echo 'data Inseted';
    } else {
        echo 'data not insert';
    }
}*/
?>

<?php include_once("../layout/LayoutHeader.php"); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.css">
<link rel="stylesheet" href="../../croppie/croppie.css">

<head>
    <link rel="stylesheet" href="read-more.css">
    <link rel="stylesheet" href="style.css">
</head>

<style>
    #serach {
        background-color: #E91E63;
        color: white;
        float: right;
    }

    #card-detail {
        border-color: #E91E63;
        border-top: none;
    }

    /* #carousel-item {
        width : 200px ;
        height : "120";
    } */
    .carouselExampleControls img {
        height: 200px;
    }
</style>

<body>
    <?php include_once("../../dbConnect.php"); ?>
    <div class="container">

        <div class="row">
            <div class="col-xl-12 col-12 mb-4">
                <div class="card-header card-bg">
                    <div class="row">
                        <div class="col-12">
                            <span class="link-active" style="color:#006664">รายชื่อศัตรูพืชอื่นๆ</span>
                            <span style="float:right;">
                                <i class="fas fa-bookmark"></i>
                                <a class="link-path" href="#">หน้าแรก</a>
                                <span> > </span>
                                <a class="link-path link-active" style="color:#006664" href="#">รายชื่อศัตรูพืช</a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">

            <?php
            $sql = "SELECT COUNT(`PTID`) c FROM `db-pestlist` WHERE `PTID` = 4";
            $myConDB = connectDB();
            $result = $myConDB->prepare($sql);
            $result->execute();
            ?>

            <div class="col-xl-3 col-12 mb-4">
                <div class="card border-left-primary card-color-one shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="font-weight-bold  text-uppercase mb-1" style="color:#6F9EF7">จำนวนชนิดศัตรูพืช</div>
                                <?php
                                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $row['c']; ?> ชนิด</div>

                                <?php
                                }
                                ?>

                            </div>
                            <div class="col-auto">
                                <i class="fas fa-bug fa-3x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-12 mb-4">
                <div class="card border-left-primary card-color-four shadow h-100 py-2" id="addInsect" style="cursor:pointer;">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center" role="button" id="addInsect" data-toggle="modal" data-target="#insert" aria-haspopup="true" aria-expanded="false">
                            <div class="col mr-2">
                                <div class="font-weight-bold  text-uppercase mb-1">เพิ่มชนิดศัตรูพืช</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">+1 ชนิด</div>
                            </div>
                            <div class="col-auto">
                                <!-- <i class="material-icons icon-big">add_location</i> -->
                                <i class="fas fa-plus-square fa-3x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
        $sql = "SELECT * FROM `db-pestlist` WHERE `PTID` = 4 ";
        $myConDB = connectDB();
        $result = $myConDB->prepare($sql);
        $result->execute();
        ?>
        <?php
        if ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        ?>
            <div class="card shadow mb-4" id="card-pest">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold" style="color:#006664">รายชื่อศัตรูพืช</h6>
                    <div class="dropdown no-arrow" align="right">
                        <!-- manage button -->
                        <button type="button" class="btn btn-warning btn-sm btn_edit" pid="<?php echo $row["PID"]; ?>" name="<?php echo $row["Name"]; ?>" alias="<?php echo $row["Alias"]; ?>" charstyle="<?php echo $row["Charactor"]; ?>" dangerstyle="<?php echo $row["Danger"]; ?>" data-icon="<?php echo $row["Icon"]; ?>" numPicChar="<?php echo $row["NumPicChar"]; ?>" numPicDanger="<?php echo $row["NumPicDanger"]; ?>">
                            <i class="fas fa-edit"></i></button>

                        <button type="button" class="btn btn-danger btn-sm" onclick="delfunction('<?php echo $row["PID"]; ?>' , '<?php echo $row["Alias"]; ?>')">
                            <i class="far fa-trash-alt"></i></button>
                    </div>
                </div>
                <div class="body">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 " style="text-align: center;">
                                <div style="text-align: center;">
                                    <img src=<?php echo $src = "../../icon/pest/" . $row["PID"] . "/" . $row["Icon"]; ?> width="120" height="120" alt="User" style="border-radius: 100px;">
                                    <br><br>
                                </div>
                                <h6 style="color:#006664">ชื่อ : <?php echo $row["Alias"]; ?> </h6>
                                <h6 style="color:#006664">ชื่อทางการ : <?php echo $row["Name"]; ?> </h6>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <h6 style="color:#006664">ลักษณะทั่วไป</h6>
                                <span class="more">
                                    <?php echo $row["Charactor"]; ?>
                                    <?php
                                    /*
                $string = strip_tags($row["Charactor"]);
                if (strlen($string) > 500) {

                    // truncate string
                    $stringCut = substr($string, 0, 500);
                    $endPoint = strrpos($stringCut, ' ');

                    //if the string doesn't contain any space then it will cut without word basis.
                    $string = $endPoint ? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
                    $string .= '...  <a href="#" class="show_hide" data-content="toggle-text">Read More</a>';
                }
                echo $string;
                */
                                    ?>
                                </span>
                                <br>
                                <br>
                                <br>
                                <div id="carouselExampleControls" class="carousel slide" data-ride="carousel" id="silder">
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <img class="d-block w-100" src=<?php echo  $src = "../../picture/Pest/other/style/" . $row["PID"] . "/" . $row["Icon"]; ?> style="height:200px;">

                                        </div>
                                        <?php for ($style_index = 0; $style_index < $row["NumPicChar"] - 1; $style_index++) { ?>
                                            <div class="carousel-item">
                                                <img class="d-block w-100" src=<?php echo  $src = "../../picture/Pest/other/style/" . $row["PID"] . "/" . $style_index . "_" . $row["Icon"]; ?> style="height:200px;">
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <h6 style="color:#006664">อันตรายของศัตรูพืช</h6>
                                <span class="more">
                                    <?php echo $row["Danger"]; ?>
                                </span>
                                <br>
                                <br>
                                <br>
                                <div id="carouselExampleControls2" class="carousel slide" data-ride="carousel" id="silder">
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <img class="d-block w-100" src=<?php echo  $src = "../../picture/Pest/other/danger/" . $row["PID"] . "/" . $row["Icon"]; ?> style="height:200px;">

                                        </div>
                                        <?php for ($danger_index = 0; $danger_index < $row["NumPicDanger"] - 1; $danger_index++) { ?>
                                            <div class="carousel-item">
                                                <img class="d-block w-100" src=<?php echo  $src = "../../picture/Pest/other/danger/" . $row["PID"] . "/" . $danger_index . "_" . $row["Icon"]; ?> style="height:200px;">
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <a class="carousel-control-prev" href="#carouselExampleControls2" role="button" data-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="carousel-control-next" href="#carouselExampleControls2" role="button" data-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        <?php } ?>
        <div>
            <div class="row">
                <?php
                $sql = "SELECT * FROM `db-pestlist` WHERE `PTID` = 4 ";
                $myConDB = connectDB();
                $result = $myConDB->prepare($sql);
                $result->execute();
                ?>

                <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)) { ?>

                    <?php require("itemInsect.php"); ?>

                <?php } ?>
            </div>
        </div>

        <div class="Modal"> </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <?php include_once("../layout/LayoutFooter.php"); ?>
    <?php require("modalInsert.php"); ?>
    <?php require("modalEdit.php"); ?>

    <script src="PestList.js"></script>
    <script src="../../croppie/croppie.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.js"></script>
    <!-- <script src="InsectListModal.js"></script> -->

    <script>
        $("#looks").val("xxxxxxxxxxx")
        $('#danger').val("xxxxxxxxxxx")
    </script>



</body>

</html>