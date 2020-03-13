<?php
include_once("../../dbConnect.php");
if (!isset($_GET['IDkey'])) {
    header("location:../../index.php");
} else {
    $IDkey = $_GET['IDkey'];
    $time = "";
    $IDUser = "";

    $strFileName = "logpassword.txt";
    $objFopen = fopen($strFileName, 'r');
    if ($objFopen) {
        while (!feof($objFopen)) {
            $file = fgets($objFopen, 4096);
            $data = explode(",", $file);
            if ($data[0] ==  $IDkey) {

                $time = (string) $data[2];
                $IDUser = $data[1];



                break;
            }
        }
        fclose($objFopen);
    }

    if ($IDUser == NULL) {
        header("location:../../index.php");
    } else if (time() > $time) {
        header("location:../../index.php?error=4");
    } else {
        $sql = "SELECT * FROM `db-user` WHERE `UID` = '" . $IDUser . "'";
        $DATAUSER = selectData($sql);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Custom fonts for this template-->
    <link href="../../lib/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../../css/sb-admin-2.min.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <link href="../../css/customize.css" rel="stylesheet">

    <link href="../../lib/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <!-- Range Slider Css -->
    <link href="../../lib/ion-rangeslider/css/ion.rangeSlider.css" rel="stylesheet" />
    <link href="../../lib/ion-rangeslider/css/ion.rangeSlider.skinFlat.css" rel="stylesheet" />

    <link href='../../lib/calendar/css/fullcalendar.css' rel='stylesheet' />
    <link href='../../lib/calendar/css/fullcalendar.print.css' rel='stylesheet' media='print' />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.css">

</head>
<style>
    body {
        background-color: #E91E63 !important;
    }

    .card-signin {
        background-color: white;
    }

    #login-header {
        color: white;
    }



    .login-small {
        float: center;
    }
</style>

<body>

    <div style="float:center;">
        <br><br><br><br>
        <div class="container">
            <div class="row">

                <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
                    <div id="login-header">
                        <h5 class="text-center">ระบบบริหารจัดการแปลงปลูกปาล์มน้ำมัน </h5>
                        <h6 class="text-center login-small">© KU ศูนย์เทคโนโลยีชีวภาพเกษตร</h6>
                    </div>

                    <div class="card card-signin my-1">

                        <div class="card-body">
                            <form class="form-signin" method="POST" action='manage.php'>
                                <center>
                                    <h3>เปลี่ยนรหัสผ่าน</h3>
                                </center>
                                <br>
                                <div class="form-label-group">
                                    <label for="inputPassword">รหัสผ่านใหม่</label>
                                    <i class="fa fa-question-circle tt" style="color:red" data-toggle="tooltip" data-placement="bottom" title="-ต้องมีขนาดมากกว่า 7 ตัวอักษร -ต้องมีอักษรภาษาอังกฤษ ตัวเลข และอักขระพิเศษ"></i>
                                    <div class="col-12">
                                        <input class="form-control" type="password" name="password1" id="password1" placeholder="Password" required="" oninput="setCustomValidity('')">
                                        <i class="fa fa-eye-slash eye-setting" id="hide1"></i>
                                    </div>

                                </div>
                                <br>
                                <div class="form-label-group">
                                    <label for="inputPassword">ยืนยันรหัสผ่าน</label>
                                    <i class="fa fa-question-circle tt" style="color:red" data-toggle="tooltip" data-placement="bottom" title="-ต้องมีขนาดมากกว่า 7 ตัวอักษร -ต้องมีอักษรภาษาอังกฤษ ตัวเลข และอักขระพิเศษ"></i>
                                    <div class="col-12">
                                        <input class="form-control" type="password" name="password2" id="password2" placeholder="Password" required="" oninput="setCustomValidity('')">
                                        <i class="fa fa-eye-slash eye-setting" id="hide2"></i>

                                    </div>
                                </div>
                                <input type="text" hidden class="form-control" name="uid" id="uid" value="<?= $IDUser ?>">
                                <input type="text" hidden class="form-control" name="username" id="username" value="<?= $DATAUSER[1]['UserName'] ?>">
                                <input type="text" hidden class="form-control" name="request" id="request" value="changepass">
                                <br />
                                <br />
                                <button class="btn btn-danger btn-md" style="float:right;margin-left:10px" onclick="back()">ยกเลิก</button>
                                <button class="btn btn-success btn-md" id="edit_pass" style="float:right;" type="submit">ยืนยัน</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

<script src="../../lib/jquery/jquery.min.js">
</script>
<script src="../../lib/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="../../lib/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="../../js/sb-admin-2.min.js"></script>

<script src="../../lib/datatables/jquery.dataTables.min.js"></script>
<script src="../../lib/datatables/dataTables.bootstrap4.min.js"></script>

<script type="text/javascript">
    var h1 = document.getElementById('hide1');
    h1.addEventListener('click', show_hide1);
    var h2 = document.getElementById('hide2');
    h2.addEventListener('click', show_hide2);

    function show_hide1() {
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

    function show_hide2() {
        console.log("5555");
        h1.classList.toggle('active');
        if ($('#password2').attr("type") == "password") {
            $('#password2').attr('type', 'text');
            $('#hide2').removeClass("fa-eye-slash");
            $('#hide2').addClass("fa-eye");
        } else if ($('#password2').attr("type") == "text") {
            $('#password2').attr('type', 'password');
            $('#hide2').addClass("fa-eye-slash");
            $('#hide2').removeClass("fa-eye");
        }
    }

    function back() {
        window.location = '../../index.php'

    }
    $(document).ready(function() {
        let logP;
        let pwd_new_md5;
        $('.tt').tooltip();
        $('#pass_edit').click(function() {

            $("#ChangeModal").modal();


        });
        $('.save').click(function() {
            var user = document.getElementById("username2").value;
            changepassword(user);
        });

        function changepassword(username2) {
            console.log(username2);
            $.ajax({
                type: "POST",

                data: {
                    username: username2
                },
                url: "view/ChangePassword/manage.php",
                async: false,

                success: function(result) {
                    alert(result);
                    $(".changepass").empty();
                    $(".changepass").append(result);
                }
            });
        }
        $('#edit_pass').click(function() {
            let pwd = $("input[name = 'password1']");
            let pwd1 = $("input[name = 'password2']");
            let uid = $("input[name = 'uid']");
            let username = $("input[name = 'username']");
            let data = [pwd, pwd1];
            call(pwd, uid, username);
            pullLogPass(uid.val());
            if (!check_blankPass(data)) return;
            if (!check_long_pass(pwd)) return;
            if (!check_pass_format(pwd)) return;
            if (!check_pass(pwd, pwd1)) return;
            if (!check_passUsed(pwd)) return;
        })

        function check_passUsed(pwd) {
            // console.log(logP);
            // console.log("ch password");
            for (i in logP) {

                if (pwd_new_md5.trim() == logP[i].PWD.trim()) {
                    // console.log("*"+pwd_new_md5.trim()+'-'+logP[i].PWD.trim()+"*");
                    // console.log("รหัสผ่านนี้ถูกใช้แล้ว");
                    pwd[0].setCustomValidity('รหัสผ่านนี้ถูกใช้แล้ว');
                    return false;
                }
            }
            pwd[0].setCustomValidity('');
            return true;
        }

        function check_long_pass(pwd) {
            if (pwd.val().length < 8) {
                pwd[0].setCustomValidity('ความยาวต้อง >= 8 ตัวอักษร');
                return false;
            }
            pwd[0].setCustomValidity('');
            return true;
        }

        function check_pass_format(pwd) {
            if (pwd.val().match(
                    /([0-9].*[a-zA-Z].*[!,@,#,$,%,^,&,*,?,_,~])|([!,@,#,$,%,^,&,*,?,_,~].*[0-9].*[a-zA-Z])|([a-zA-Z].*[0-9].*[!,@,#,$,%,^,&,*,?,_,~])|([!,@,#,$,%,^,&,*,?,_,~].*[a-zA-Z].*[0-9])|([a-zA-Z].*[!,@,#,$,%,^,&,*,?,_,~].*[0-9])|([0-9].*[!,@,#,$,%,^,&,*,?,_,~].*[a-zA-Z])/
                )) {
                pwd[0].setCustomValidity('');
                return true;
            }
            pwd[0].setCustomValidity('ต้องมีทั้ง ตัวอักษรภาษาอังกฤษ ตัวเลข และ อักขระพิเศษ');
            return false;
        }

        function check_pass(pwd, pwd1) {
            if (pwd.val().trim() != pwd1.val().trim()) {
                pwd1[0].setCustomValidity('รหัสผ่านไม่ตรงกัน');
                return false;
            } else {
                pwd1[0].setCustomValidity('');
                return true;
            }
        }

        function check_blankPass(selecter) {
            for (i in selecter) {
                // console.log(selecter[i].val());
                if (selecter[i].val() == '') {
                    //  console.log("if");
                    selecter[i][0].setCustomValidity('กรุณากรอกข้อมูล');
                    return false;
                } else {
                    // console.log("else");
                    selecter[i][0].setCustomValidity('');
                }
            }
            return true;
        }

        function call(pwd, uid, username) {
            var us = username.val();
            // console.log(us.toUpperCase());
            var pwd = uid.val() + us.toUpperCase() + (pwd.val());
            makeNewmd5(pwd);
        }

        function makeNewmd5(pwd) {
            $.ajax({ // update data
                type: "POST",
                data: {
                    pwd: pwd,
                    request: 'md5'
                },
                url: "manage.php",
                async: false,

                success: function(result) {
                    pwd_new_md5 = result;
                    // console.log(pwd_md5); 
                }
            });
        }

        function pullLogPass(_uid) {
            // console.log("logpass");
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    logP = JSON.parse(this.responseText);
                    //  alert(this.responseText);       
                    //  alert(logP);        
                    // console.log("pull");
                };
            }
            xhttp.open("POST", "manage.php", false);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send(`uid=${_uid}&request=logpass`);
        }
    });
</script>