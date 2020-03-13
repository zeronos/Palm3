<?php 
    session_start();
    $idUT = $_SESSION[md5('typeid')];
    $CurrentMenu = "UserProfile";

    include_once("../layout/LayoutHeader.php");
    include_once("../../dbConnect.php");

    $USER = $_SESSION[md5('user')];
    $id_u=$USER[1]['UID'];
    $did = $USER[1]['DID'];
    $etid = $USER[1]['ETID'];

    // echo $did;
    $sql = "SELECT * FROM `db-department` WHERE DID = $did ";
    $DEPARTMENT = selectData($sql);

    $sql1 = "SELECT * FROM `db-emailtype` WHERE ETID = $etid ";
    $EMIALTYPE= selectData($sql1);
 
    $sql2 ="SELECT * FROM `db-user` WHERE `UID`=$id_u";
    $get_user= selectData($sql2);
    $get_idUser=$get_user[1]['PWD'];

    $icon = $USER[1]['Icon'];
    if($icon == "default.jpg"){
        // echo "yes";
        $userId = 0;
        $icon = "default.jpg";
    }else{
        $userId = $USER[1]['UID'];
        $icon = $USER[1]['Icon'];
    }

    // echo $USER[1]['Icon']." ";

    // echo $userId." ";
    // echo $icon;

?>
<!-- ----------------------- crop photo ------------------------- -->
<link href="../../croppie/croppie.css" rel="stylesheet" />
<link href="style.css" rel="stylesheet" />

<div class="container">
    
    <div class="row">
        <div class="col-xl-12 col-12 mb-4">
            <div class="card">
                <div class="card-header card-bg">
                    <div class="row">
                        <div class="col-12">
                            <span class="link-active font-weight-bold" style="color:<?=$color?>;">บัญชีผู้ใช้</span>
                            <span style="float:right;">
                                <i class="fas fa-bookmark"></i>
                                <a class="link-path" href="#">หน้าแรก</a>
                                <span> > </span>
                                <a class="link-path link-active" href="#" style="color:<?=$color?>;">บัญชีผู้ใช้</a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-4 col-12 mb-4">
            <div class="row">
                <div class="col-xl-12 col-12">
                    <div class="card">
                        <div class="card-header card-bg font-weight-bold" style="color:<?=$color?>;">
                            รูปโปรไฟล์
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <img class="img-radius img-profile"
                                    <?php
                                    if($icon == "default.jpg"){
                                        if( $USER[1]['Title'] ==1 )
                                            echo 'src="../../icon/user/0/defaultM.jpg" />';
                                        else 
                                            echo 'src="../../icon/user/0/defaultM.jpg" />';
                                    }else{
                                        echo 'src="../../icon/user/'.$userId.'/'.$icon.'" />';
                                    }
                                    ?>
                            </div>
                            <div class="row mt-3">
                                <div class="col-xl-12 col-12"><center>
                                    <button type="button" id="edit_photo"
                                        class="btn btn-primary btn-sm tt"
                                        title='เปลี่ยนรูปโปรไฟล์'
                                        uid="<?php echo $USER[1]['UID']; ?>" >
                                        <i class="fas fa-image"></i>
                                    </button>
                                    <button type="button" id="btn_info"
                                        class="btn btn-warning btn-sm tt"
                                        title='เปลี่ยนข้อมูลบัญชี'
                                        uid="<?php echo $USER[1]['UID']; ?>" 
                                        titles="<?php echo $USER[1]['Title']; ?>"
                                        username="<?php echo $USER[1]['UserName']; ?>"
                                        fname="<?php echo $USER[1]['FirstName']; ?>"
                                        lname="<?php echo $USER[1]['LastName']; ?>"
                                        mail="<?php echo $USER[1]['EMAIL']; ?>"
                                        type_email="<?php echo $USER[1]['ETID']; ?>"
                                        department="<?php echo $USER[1]['DID']; ?>"
                                        admin="<?php echo $USER[1]['IsAdmin']; ?>"
                                        research="<?php echo $USER[1]['IsResearch']; ?>"
                                        operator="<?php echo $USER[1]['IsOperator']; ?>"
                                        farmer="<?php echo $USER[1]['IsFarmer']; ?>">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" id="btn_pass"
                                        class="btn btn-success btn-sm pass_edit tt"
                                        title='เปลี่ยนรหัสผ่าน'
                                        uid="<?php echo $USER[1]['UID']; ?>"
                                        username="<?php echo $USER[1]['UserName']; ?>" 
                                        pass="<?php echo $get_idUser; ?>"
                                        titles="<?php echo $USER[1]['Title']; ?>"
                                        fname="<?php echo $USER[1]['FirstName']; ?>"
                                        lname="<?php echo $USER[1]['LastName']; ?>">
                                        <i class="fa fa-cog"></i>
                                    </button>
                                </center></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="row mt-3">
                <div class="col-xl-12 col-12">
                    <div class="card">
                        <div class="card-header card-bg">
                            ตำแหน่งสวนปาล์ม
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-12 col-12 mb-2">
                                    <div id="map_area" style="width:auto; height:200px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
        <div class="col-xl-8 col-12 mb-4">
            <div class="card">
                <div class="card-header card-bg font-weight-bold" style="color:<?=$color?>;">
                    รายละเอียดบัญชี
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-xl-3 col-12 text-right">
                            <span>คำนำหน้า</span>
                        </div>
                        <div class="col-xl-9 col-12">
                            <input type="text" class="form-control" id="title" value=<?php
                            if($USER[1]['Title'] ==1){
                                echo "นาย";
                            }else if($USER[1]['Title'] ==2){
                                echo "นาง";
                            }else{
                                echo "นางสาว";
                            }
                            ?> disabled>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-xl-3 col-12 text-right">
                            <span>ชื่อ</span>
                        </div>
                        <div class="col-xl-9 col-12">
                            <input type="text" class="form-control" id="firstname"
                                value='<?php echo $USER[1]['FirstName']; ?>'' disabled>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-xl-3 col-12 text-right">
                            <span>นามสกุล</span>
                        </div>
                        <div class="col-xl-9 col-12">
                            <input type="text" class="form-control" id="lastname"
                                value='<?php echo $USER[1]['LastName'] ?>'disabled>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-xl-3 col-12 text-right">
                            <span>อีเมล์</span>
                        </div>
                        <div class="col-xl-9 col-12">
                            <input type="text" class="form-control" id="mail"
                                value="<?php echo $USER[1]['EMAIL']?>@<?php echo $EMIALTYPE[1]['Type']?>" disabled>
                        </div>
                    </div>
                    <!-- <div class="row mb-4">
                        <div class="col-xl-3 col-12 text-right">
                            <span>เบอร์โทรศัพท์</span>
                        </div>
                        <div class="col-xl-9 col-12">
                            <input type="text" class="form-control" id="mail" value="0866221212" disabled>
                        </div>
                    </div> -->
                    <div class="row mb-4">
                        <div class="col-xl-3 col-12 text-right">
                            <span>ชื่อบัญชี</span>
                        </div>
                        <div class="col-xl-9 col-12">
                            <input type="text" class="form-control" id="username"
                                value=<?php echo $USER[1]['UserName'] ?> disabled>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-xl-3 col-12 text-right">
                            <span>หน่วยงาน</span>
                        </div>
                        <div class="col-xl-9 col-12">
                            <input type="text" class="form-control" id="department"
                                value=<?php echo $DEPARTMENT[1]['Department']; ?> disabled>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-right">
                            <span>สิทธิการเข้าใช้งาน</span>
                        </div>
                        <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="admin" name="admin" value="option1"
                                    disabled <?php if($USER[1]['IsAdmin'] == 1) echo "checked"; ?>>
                                <label class="form-check-label" for="inlineCheckbox1">ผู้ดูแลระบบ</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="admin" name="admin" value="option1"
                                    disabled <?php if($USER[1]['IsAdmin2'] == 1) echo "checked"; ?>>
                                <label class="form-check-label" for="inlineCheckbox1">ผู้ดูแลระบบ2</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="research" name="research"
                                    value="option2" disabled <?php if($USER[1]['IsResearch'] == 1) echo "checked"; ?>>
                                <label class="form-check-label" for="inlineCheckbox2">นักวิจัย</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="operator" name="operator"
                                    value="option3" disabled <?php if($USER[1]['IsOperator'] == 1) echo "checked"; ?>>
                                <label class="form-check-label" for="inlineCheckbox3">พนักงานทั่วไป</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="farmer" name="farmer"
                                    value="option4" disabled <?php if($USER[1]['IsFarmer'] == 1) echo "checked"; ?>>
                                <label class="form-check-label" for="inlineCheckbox4">เกษตรกร</label>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once("../layout/LayoutFooter.php"); ?>
<?php include_once("UserProfileModal.php"); ?>

<!-- <script src="UserProfile.js"></script> -->
<script src="../../croppie/croppie.js"></script>
<script>
// console.log("file");
$(document).ready(function() {
    // console.log("uu");
    let dataU;
    let logP;
    let pwd_md5 = 5;
    let pwd_new_md5 = 5;
    pullData();

    function pullData() {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                 dataU = JSON.parse(this.responseText);
                // console.log(dataU);               
            };
        }
        xhttp.open("POST", "manage.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send(`request=select`);
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
    $("#edit_photo").click(function() {
        console.log("photo");
        $("#photoModal").modal();
        var uid = $(this).attr('uid');
        $('#p_uid').val(uid);

    });

    $("#btn_info").click(function() {
        $("#editModal").modal();
        var uid = $(this).attr('uid');
        // console.log("this");
        // alert(uid);
        //set all false
        document.getElementById("e_admin").checked = false;
        document.getElementById("e_research").checked = false;
        document.getElementById("e_operator").checked = false;
        document.getElementById("e_farmer").checked = false;

        var title = $(this).attr('title');
        var fname = $(this).attr('fname');
        var lname = $(this).attr('lname');
        var username = $(this).attr('username');
        var mail = $(this).attr('mail');
        var type = $(this).attr('type_email');
        var department = $(this).attr('department');
        var admin = $(this).attr('admin');
        var research = $(this).attr('research');
        var operator = $(this).attr('operator');
        var farmer = $(this).attr('farmer');

        $('#uid').val(uid);
        $('#e_fname').val(fname);
        $('#e_lname').val(lname);
        $('#e_username').val(username);
        $('#e_username1').val(username);
        $('#e_mail').val(mail);

        // alert(admin);
        document.getElementById("e_title").value = titles;
        document.getElementById("e_type").value = type;
        document.getElementById("e_department").value = department;
        if (admin == 1) {
            // alert("admin");
            document.getElementById("e_admin").checked = true;
        }
        if (research == 1) {
            document.getElementById("e_research").checked = true;
        }
        if (operator == 1) {
            document.getElementById("e_operator").checked = true;
        }
        if (farmer == 1) {
            document.getElementById("e_farmer").checked = true;
        }
    });
    $('.pass_edit').click(function() {
        $("#passModal").modal();
        var uid = $(this).attr('uid');
        var username = $(this).attr('username');
        var pass_old = $(this).attr('pass');

        var title = $(this).attr('title');
        var fname = $(this).attr('fname');
        var lname = $(this).attr('lname');
        // console.log(pass_old);
        $('#pass_uid').val(uid);
        $('#pass_username').val(username);
        $('#pass_old').val(pass_old);
        console.log(pass_old);
        // console.log(username);
        $('#p_title').val(title);
        $('#p_fname').val(fname);
        $('#p_lname').val(lname);

    });
    // ------------------------------------------ edit password ------------------------------------------
    $('#edit_pass').click(function() {
        let old_pwd = $("input[name = 'old_pwd']");
        let pwd = $("input[name = 'e_pwd']");
        let pwd1 = $("input[name = 'e_pwd1']");
        let uid = $("input[name = 'pass_uid']");
        let username = $("input[name = 'pass_username']");
        let pass_old = $("input[name = 'pass_old']");

        let data = [old_pwd, pwd, pwd1];

        call(old_pwd, uid, username, 0);
        call(pwd, uid, username, 1);

        // console.log(i);
        pullLogPass(uid.val());


        if (!check_blankPass(data)) return;
        if (!check_oldPass(old_pwd, pass_old)) return;
        if (!check_long_pass(pwd)) return;
        if (!check_pass_format(pwd)) return;
        if (!check_pass(pwd, pwd1)) return;
        if(!check_passUsed(pwd)) return;

    })
    function check_passUsed(pwd){
        // console.log(logP);
        // console.log("ch password");
        for(i in logP){
            
            if(pwd_new_md5.trim() == logP[i].PWD.trim()){
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
        if (pwd.val().trim().length < 8) {
            pwd[0].setCustomValidity('ความยาวต้อง >= 8 ตัวอักษร');
            return false;

        }
        pwd[0].setCustomValidity('');
        return true;

    }

    function check_pass_format(pwd) {
        if (pwd.val().trim().match(
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
            if (selecter[i].val().trim() == '') {
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

    function call(old_pwd, uid, username, ch) {
        var us = username.val();
        // console.log(us.toUpperCase());
        var pwd = uid.val() + us.toUpperCase() + (old_pwd.val());
        if (ch == 0) {
            makemd5(pwd);
        } else {
            makeNewmd5(pwd);
        }


    }

    function check_oldPass(old_pwd, pass_old) {
        // console.log(pwd_md5.trim());
        // console.log(pass_old.val().trim());

        if (pwd_md5.trim() != (pass_old.val().trim())) {
            // console.log("password duplicate");
            old_pwd[0].setCustomValidity('รหัสผ่านไม่ถูกต้อง');
            return false;
        } else {
            old_pwd[0].setCustomValidity('');
        }
        return true;

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

    function makemd5(pwd) {
        $.ajax({ // update data
            type: "POST",
            data: {
                pwd: pwd,
                request: 'md5'
            },
            url: "manage.php",
            async: false,

            success: function(result) {
                pwd_md5 = result;
                // console.log(pwd_md5); 
            }
        });
    }
    // ------------------------------------------ edit data ------------------------------------------
    $('#edit').click(function() {
        let title = $("select[name = 'e_title']");
        let fname = $("input[name = 'e_fname']");
        let lname = $("input[name = 'e_lname']");
        let username = $("input[name = 'e_username1']");
        let mail = $("input[name = 'e_mail']");
        let uid = $("input[name = 'uid']");

        let data = [fname, lname, username, mail];

        document.getElementById("edit").setAttribute("type","submit");
        
        // console.log("edit");
        if (!check_blank(data)) return;
        if(!check_blank_in(data)) return;
        if(!check_lan(fname,lname)) return;
        if (!check_editName(fname, lname, uid)) return;
        // if(!check_editUser(username,uid)) return;
        if (!check_mail(mail)) return;
        if (!check_checkboxEdit()) return;

    })
    function check_blank_in(selecter){
        for(i in selecter){
            // console.log(selecter[i].val());
            var space = selecter[i].val().trim().split(" ").length - 1;
            // console.log(space);
            if(space > 0){
                //  console.log("if");
                selecter[i][0].setCustomValidity('ห้ามมีช่องว่าง');
                return false;
            }else{
                // console.log("else");
                selecter[i][0].setCustomValidity('');
            }            

        }
        return true;
    }
    function check_lan(fname,lname){
        const TH = /^[ก-๙]+$/;
        
        if(TH.test(fname.val().trim()) && TH.test(lname.val().trim())){
            fname[0].setCustomValidity('');
            lname[0].setCustomValidity('');
            return true;
        }else if(TH.test(fname.val().trim())){
            // console.log("last name not thi");
            lname[0].setCustomValidity('กรุณากรอกนามสกุลเป็นภาษาไทย');
            return false;
        }else if(TH.test(lname.val().trim())){
            // console.log("name not thi");
            fname[0].setCustomValidity('กรุณากรอกชื่อเป็นภาษาไทย');
            return false;
            
        }else{
            // console.log("name not thi");
            fname[0].setCustomValidity('กรุณากรอกชื่อเป็นภาษาไทย');
            return false;
        }

    }
    function check_checkboxEdit() {
        // console.log("check box");
        if (document.formEdit.e_admin.checked == false && document.formEdit.e_research.checked == false &&
            document.formEdit.e_operator.checked == false && document.formEdit.e_farmer.checked == false) {
            $('#error').removeAttr('hidden');
            document.getElementById("edit").setAttribute("type", "button");
            return false;
        } else {
            document.getElementById("edit").setAttribute("type", "submit");
        }

        return true;
    }

    function check_mail(mail) {

        let email = /^[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)?$/i;
        if (!mail.val().trim().match(email)) {
            mail[0].setCustomValidity('กรอกอีเมลล์ไม่ถูกต้อง');
            return false;
        } else {
            mail[0].setCustomValidity('');
        }
        return true;
    }

    function check_blank(selecter) {
        for (i in selecter) {
            // console.log(selecter[i].val());
            if (selecter[i].val().trim() == '') {
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

    function check_editName(fname, lname, uid) {
        // console.log("editname");
        for (i in dataU) {
            // console.log(dataU[i].FirstName);
            // console.log(fname.val().trim());
            if (fname.val().trim() == dataU[i].FirstName && lname.val().trim() == dataU[i].LastName && dataU[i].UID != uid.val()) {
                // console.log("ซ้ำ");
                fname[0].setCustomValidity('ชื่อ-นามสกุลซ้ำ');
                return false;
            } else {
                fname[0].setCustomValidity('');
            }
        }

        return true;
    }
    // function check_editUser(name,uid){
    //     for(i in dataU){
    //         if(name.val().trim() == dataU[i].UserName && dataU[i].UID != uid.val()){
    //             name[0].setCustomValidity('ชื่อผู้ใช้งานซ้ำ');
    //             return false;
    //         }
    //         else{
    //             name[0].setCustomValidity('');
    //         }
    //     }

    //     return true;
    // }

    $("#btn_upload").click(function() {
        $("#input_upload").click();
    });

    // ---------------------------------- set default password ------------------------------- 
    $('#edit_cancel').click(function() {
        // console.log("fff");
        $('#old_pwd').val("");
        $('#e_pwd').val("");
        $('#e_pwd1').val("");

        // ---------------------------------- set default old_pwd ---------------------------------- 
        $('#old_pwd').attr('type', 'password');
        $('#hide_1').removeClass("fa-eye");
        $('#hide_1').addClass("fa-eye-slash");
        // ---------------------------------- set default e_pwd ---------------------------------- 
        $('#e_pwd').attr('type', 'password');
        $('#hide_2').removeClass("fa-eye");
        $('#hide_2').addClass("fa-eye-slash");
        // ---------------------------------- set default e_pwd1 ---------------------------------- 
        $('#e_pwd1').attr('type', 'password');
        $('#hide_3').removeClass("fa-eye");
        $('#hide_3').addClass("fa-eye-slash");


    });
});


// --------------------------------------- old_pwd ---------------------------------------

var h1 = document.getElementById('hide_1');
h1.addEventListener('click', show_hide1);

function show_hide1() {

    h1.classList.toggle('active');

    if ($('#old_pwd').attr("type") == "text") {
        // console.log("pwd");
        $('#old_pwd').attr('type', 'password');
        $('#hide_1').removeClass("fa-eye");
        $('#hide_1').addClass("fa-eye-slash");
    } else if ($('#old_pwd').attr("type") == "password") {
        // console.log("txt");
        $('#old_pwd').attr('type', 'text');
        $('#hide_1').removeClass("fa-eye-slash");
        $('#hide_1').addClass("fa-eye");
    }
}
// --------------------------------------- e_pwd ---------------------------------------
var h2 = document.getElementById('hide_2');
h2.addEventListener('click', show_hide2);

function show_hide2() {

    h2.classList.toggle('active');

    if ($('#e_pwd').attr("type") == "text") {
        // console.log("pwd");
        $('#e_pwd').attr('type', 'password');
        $('#hide_2').removeClass("fa-eye");
        $('#hide_2').addClass("fa-eye-slash");
    } else if ($('#e_pwd').attr("type") == "password") {
        // console.log("txt");
        $('#e_pwd').attr('type', 'text');
        $('#hide_2').removeClass("fa-eye-slash");
        $('#hide_2').addClass("fa-eye");
    }
}
// --------------------------------------- e_pwd1 ---------------------------------------
var h3 = document.getElementById('hide_3');
h3.addEventListener('click', show_hide3);

function show_hide3() {

    h3.classList.toggle('active');

    if ($('#e_pwd1').attr("type") == "text") {
        // console.log("pwd");
        $('#e_pwd1').attr('type', 'password');
        $('#hide_3').removeClass("fa-eye");
        $('#hide_3').addClass("fa-eye-slash");
    } else if ($('#e_pwd1').attr("type") == "password") {
        // console.log("txt");
        $('#e_pwd1').attr('type', 'text');
        $('#hide_3').removeClass("fa-eye-slash");
        $('#hide_3').addClass("fa-eye");
    }
}

// --------------------------------------- crop photo ------------------------------------------------------

$(document).on('change', '.item-img', function() {
    console.log("ssssssssss")
    // $('.cl').collapse('toggle')
    // $('#insert').modal('show');
    imageId = $(this).data('id');
    tempFilename = $(this).val();

    // $('.add-button').append(`<center>
    //                             <button id='cancelCrop' type="button" class="btn btn-default" >Close</button>
    //                             <button type="button" id="cropImageBtn"  class="btn btn-primary">Crop</button>
    //                         </center>`)
    // item_output = $(this).prev();																 
    // $('#cancelCropBtn').data('id', imageId);  
    readFile(this);

});

function readFile(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#cropImagePop').addClass('show');
            console.log("lllllllll")
            rawImg = e.target.result;

            loadIm();
        }
        reader.readAsDataURL(input.files[0]);
    } else {
        //    swal("Sorry - you're browser doesn't support the FileReader API");
    }
}
$('.divCrop').hide()
$('.buttonCrop').hide()

function loadIm() {
    $('.divName').hide()
    $('.divHolder').hide()
    $('.divCrop').show()
    $('.buttonCrop').show()
    $('.buttonSubmit').hide()
    // $('.UI').append(`<div id="upload-demo" class="center-block"></div>`)
    $uploadCrop = $('#upload-demo').croppie({
        viewport: {
            width: 200,
            height: 200,
            type: 'circle'
        },
        enforceBoundary: false,
        enableExif: true
    });
    $uploadCrop.croppie('bind', {
        url: rawImg
    }).then(function() {
        console.log('jQuery bind complete');
    });
    $('.item-img').val('');

}
$(document).on('click', '#cropImageBtn', function(ev) {

    $('#upload-demo').croppie('result', {
            type: 'canvas',
            size: 'viewport'
        })
        .then(function(r) {
            $('.buttonSubmit').show()
            $('.divName').show()
            $('.buttonCrop').hide()
            $('.divHolder').show()
            $('#img-insert').attr('src', r);
            $('#imagebase64').val(r);
            $('.divCrop').hide()
        });
    $('#upload-demo').croppie('destroy')

});
$(document).on('click', '#cancelCrop', function() {
    $('#upload-demo').croppie('destroy')
    $('.divName').show()
    $('.divHolder').show()
    $('.divCrop').hide()
    $('.buttonCrop').hide()
    $('.buttonSubmit').show()
    // $('#img-insert').attr('src', "https://via.placeholder.com/200x200.png");
})

$(document).on('click', '.insertSubmit', function(e) { // insert submit
    console.log('sss');

    let icon = $("#pic-logo");

    if (!checkNull(icon)) return;

    // let form = new FormData($('#formPhoto')[0]);
    // form.append('imagebase64', $('#img-insert').attr('src'))
    // insertPh(form); // insert data
})

function checkNull(icon) {
    if (icon == '') {
        return false;
    }
    return true;
}

function insertPh(data) { // function insert data
    $.ajax({
        type: "POST",
        data: data,
        url: "manage.php",
        async: false,
        cache: false,
        contentType: false,
        processData: false,

        success: function(result) {
            // alert(result);
        }
    });
}
</script>