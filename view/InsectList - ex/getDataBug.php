<head>
    <link rel="stylesheet" href="read-more.css">
</head>

<?php
require('../../dbConnect.php');
$id = $_POST['id'];
$sql = "SELECT * FROM `db-pestlist` WHERE `PID` = $id";
$myConDB = connectDB();
$result = $myConDB->prepare($sql);
$result->execute();

?>

<?php while ($row = $result->fetch(PDO::FETCH_ASSOC)) { ?>
    
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold" style="color:#006664">รายชื่อแมลง</h6>
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
                        </span>
                        <br>
                        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel" id="silder">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img class="d-block w-100" src=<?php echo  $src = "../../picture/Pest/insect/style/" . $row["PID"] . "/" . $row["Icon"]; ?> style="height:200px;">

                                </div>
                                <?php for ($style_index = 0; $style_index < $row["NumPicChar"] - 1; $style_index++) { ?>
                                    <div class="carousel-item">
                                        <img class="d-block w-100" src=<?php echo  $src = "../../picture/Pest/insect/style/" . $row["PID"] . "/" . $style_index . "_" . $row["Icon"]; ?> style="height:200px;">
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
                        <h6 style="color:#006664">อันตรายของแมลง</h6>
                        <span class="more">
                            <?php echo $row["Danger"]; ?>
                        </span>
                        <br>
                        <div id="carouselExampleControls2" class="carousel slide" data-ride="carousel" id="silder">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img class="d-block w-100" src=<?php echo  $src = "../../picture/Pest/insect/danger/" . $row["PID"] . "/" . $row["Icon"]; ?> style="height:200px;">

                                </div>
                                <?php for ($danger_index = 0; $danger_index < $row["NumPicDanger"] - 1; $danger_index++) { ?>
                                    <div class="carousel-item">
                                        <img class="d-block w-100" src=<?php echo  $src = "../../picture/Pest/insect/danger/" . $row["PID"] . "/" . $danger_index . "_" . $row["Icon"]; ?> style="height:200px;">
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

<?php } ?>

<script src="PestList.js"></script>