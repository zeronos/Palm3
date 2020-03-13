<?php

//header("location:.././view/index/index.php");
$error = 0;
$username = "";
$password = "";

if (isset($_GET['error'])) {
    $error = $_GET['error'];
}
if (isset($_COOKIE['username']) and isset($_COOKIE['password'])) {
    $username = $_COOKIE['username'];
    $password = $_COOKIE['password'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <!-- Custom fonts for this template-->
    <link href="./lib/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="./css/sb-admin-2.min.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <link href="./css/customize.css" rel="stylesheet">

    <link href="./lib/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <!-- Range Slider Css -->
    <link href="./lib/ion-rangeslider/css/ion.rangeSlider.css" rel="stylesheet" />
    <link href="./lib/ion-rangeslider/css/ion.rangeSlider.skinFlat.css" rel="stylesheet" />

    <link href='./lib/calendar/css/fullcalendar.css' rel='stylesheet' />
    <link href='./lib/calendar/css/fullcalendar.print.css' rel='stylesheet' media='print' />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.css">

</head>
<style>
    body {
        background-color: #006664 !important;
    }

    .card-signin {
        background-color: white;
    }

    #login-header {
        color: white;
    }

    .card-signin {
        align: center;
    }

    .login-small {
        float: center;
    }
</style>

<body>

    <div style="float:center;">
        <form id="sign_in" method="POST" action="sign-in-verify.php">
            <br>
            <br>
            <br>
            <br>

            <div class="container" style="margin-left:16%">
                <div class="row" >
                    <img src="./icon/logo/KU.png" style="width:31%;height:40%;margin-top:45px">
                    <div class="col-sm-9 col-md-7 col-lg-5 ">
                        <div id="login-header">
                            <h5 class="text-center">ระบบบริหารจัดการแปลงปลูกปาล์มน้ำมัน </h5>
                            <h6 class="text-center login-small">© KU ศูนย์เทคโนโลยีชีวภาพเกษตร</h6>
                        </div>

                        <div class="card card-signin my-1">

                            <div class="card-body">
                                <form class="form-signin" method="POST" action='sign-in-verify.php'>
                                    <center>
                                        <h6>ล็อกอินเข้าสู่ระบบ</h6>
                                    </center>
                                    <br>
                                    <div class="form-label-group">
                                        <label for="inputEmail">ชื่อผู้ใช้</label>
                                        <div class="col-12">
                                            <input type="text" name="username" id="username" class="form-control" placeholder="username" value="<?php echo $username ?>" required autofocus>
                                        </div>


                                    </div>
                                    <br>
                                    <div class="form-label-group">
                                        <label for="inputPassword">รหัสผ่าน</label>

                                        <div class="col-12">
                                            <input class="form-control" type="password" name="password1" id="password1" placeholder="Password" value="<?php echo $password ?>" required>
                                            <i class="fa fa-eye-slash eye-setting" id="hide1"></i>
                                        </div>

                                    </div>
                                    <br>
                                    <?php
                                    if ($error == 1) {
                                        echo "
                                        <div class='form-label-group'>
                                            <label style='color:red'>ไม่มีชื่อผู้ใช้นี้อยู่ในระบบ</label>
                                        </div> ";
                                    } else if ($error == 2) {
                                        echo "
                                        <div class='form-label-group'>
                                            <label style='color:red'>username หรือ Password ไม่ถูกต้อง </label>
                                        </div> ";
                                    } else if ($error == 3) {
                                        echo "
                                        <div class='form-label-group'>
                                            <label style='color:red'>บัญชีของคุณถูก Block โปรดติดต่อผู้ดูแลระบบ</label>
                                        </div> ";
                                    } else if ($error == 4) {
                                        echo "
                                        <div class='form-label-group'>
                                            <label style='color:red'>ระยะเวลาในการเปลี่ยนPassword เกิน 5 นาที</label>
                                        </div> ";
                                    } else if ($error == 5) {
                                        echo "
                                        <div class='form-label-group'>
                                            <label style='color:red'>เปลี่ยนPasswordสำเร็จ</label>
                                        </div> ";
                                    }
                                    ?>

                                    <div class="custom-control custom-checkbox mb-1">
                                        <input type="checkbox" class="custom-control-input" id="remember" name="remember" <?php if (isset($_COOKIE['username']) and isset($_COOKIE['password'])) {
                                                                                                                                echo " checked ";
                                                                                                                            } ?>>
                                        <label class="custom-control-label" for="remember">บันทึกบัญชีผู้ใช้</label>
                                        <label style="margin-left: 20px;cursor:pointer;color: blue" id="pass_edit"> ลืมรหัสผ่าน?</label>
                                        <button class="btn btn-success btn-md" style="float:right;" type="submit">ล็อกอิน</button>


                                    </div>



                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </form>

    </div>


</body>

</html>
<!-- Modal -->
<div class="modal fade" id="ChangeModal" name="ChangeModal" tabindex="-1" role="dialog" style="margin-top: 10%;">
    <form method="post" id="formAdd" name="formAdd" action="manage.php">
        <div class="modal-dialog modal-lg" role="document" style="width: 30%">
            <div class="modal-content">
                <div class="changepass">
                    <div class="modal-header header-modal">
                        <h4 class="modal-title" style="color:white">ตั้ง Password ใหม่</h4>
                    </div>
                    <div class="modal-body" id="ChangeModalBody">
                        <div class="container">

                            <div class="row mb-4" style="margin-left: 10px">
                                <label for="inputEmail">ชื่อผู้ใช้</label>
                                <div class="col-12">
                                    <input type="text" name="username2" id="username2" class="form-control" placeholder="username" required autofocus>
                                </div>
                            </div>



                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" name="save" id="save" value="insert" class="btn btn-success save">ยืนยัน</button>
                        <button type="button" class="btn btn-danger cancel" id="a_cancel" data-dismiss="modal">ยกเลิก</button>
                    </div>
                </div>

            </div>
        </div>
    </form>

</div>
<script src="lib/jquery/jquery.min.js">
</script>
<script src="lib/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="lib/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="js/sb-admin-2.min.js"></script>

<script src="lib/datatables/jquery.dataTables.min.js"></script>
<script src="lib/datatables/dataTables.bootstrap4.min.js"></script>

<script type="text/javascript">
    var h1 = document.getElementById('hide1');
    h1.addEventListener('click', show_hide);

    function show_hide() {
        console.log("5555");

        h1.classList.toggle('active');
        if ($('#password1').attr("type") == "password") {
            $('#password1').attr('type', 'text');
            $('#hide1').removeClass("fa-eye-slash");
            $('#hide1').addClass("fa-eye");
        } else if ($('#password1').attr("type") == "text") {
            $('#password1').attr('type', 'password');
            $('#hide1').addClass("fa-eye-slash");
            $('#hide1').removeClass("fa-eye");
        }
    }
    $(document).ready(function() {
        $('#pass_edit').click(function() {

            $("#ChangeModal").modal();


        });
        $(document).on('click', '.save', function() {
            var user = document.getElementById("username2").value;
            changepassword(user);
        });
        $(document).on('click', '.cancel', function() {

            cancel();
        });

        function changepassword(username2) {

            $.ajax({
                type: "POST",

                data: {
                    username: username2
                },
                url: "view/ChangePassword/manage.php",
                async: false,

                success: function(result) {

                    $(".changepass").empty();
                    $(".changepass").append(result);
                }
            });
        }

        function cancel() {

            $.ajax({
                type: "POST",

                data: {
                    cancel: "ccc"
                },
                url: "view/ChangePassword/manage.php",
                async: false,

                success: function(result) {

                    $(".changepass").empty();
                    $(".changepass").append(result);
                }
            });
        }

    });
</script>