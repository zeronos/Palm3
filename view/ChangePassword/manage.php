<?php
require_once("../../dbConnect.php");
require_once("../../set-log-login.php");
session_start();
connectDB();
ini_set('display_errors', 1);

if (isset($_POST['cancel'])) {
    echo ' <div class="modal-header header-modal">
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
                <button type="button" class="btn btn-danger cancel"  id="a_cancel"  data-dismiss="modal">ยกเลิก</button>
            </div>';
} else if (isset($_POST['request'])) {
    $request = $_POST['request'];
    $sql = '';
    switch ($request) {
        case 'changepass':
            $pwd = trim($_POST['password1']);
            $uid = $_POST['uid'];
            $username = $_POST['username'];
            $DATA = getUser($uid);
            $title = $DATA[1]['Title'];
            $fname = $DATA[1]['FirstName'];
            $lname = $DATA[1]['LastName'];
            $DIM_user = getDIM($uid, $title, $fname, $lname);
            $id_dim = $DIM_user[1]['ID'];
            $username_up = strtoupper($username);
            $pwd_md5 = md5($uid . $username_up . $pwd);
            echo $uid . $username . $pwd;
            $time = time();
            $data_t =  getDIMDate();
            $id_t = $data_t[1]['ID'];
            $loglogin_id = -1;
            $ch_pwd = ch_pwd($DIM_user, $pwd_md5);
            if ($ch_pwd) {
                $sql = "UPDATE `log-password` 
                                SET EndT='$time', EndID='$id_t'
                                WHERE DIMuserID='$id_dim' AND EndT IS NULL ";
                $o_did = updateData($sql);


                $sql = "INSERT INTO `log-password` (DIMuserID,LOGloginID,StartT,StartID,PWD) 
                    VALUES ('$id_dim','$loglogin_id','$time','$id_t','$pwd_md5')";

                $did = addinsertData($sql);
            }
            $sql =   "UPDATE `db-user` 
            SET PWD='$pwd_md5'
            WHERE `UID`='$uid' ";

            $re = updateData($sql);
            header("location:../../index.php?error=5");
            break;
        case 'logpass':
            $uid = $_POST['uid'];
            // echo $uid;
            $get_idDim = getDIMu($uid);
            // echo $get_idDim;
            $sql = "SELECT * FROM `log-password` WHERE DIMuserID='$get_idDim'";

            print_r(json_encode(select($sql)));
            break;
    }
} else if (isset($_POST['username'])) {
    include_once("../../dbConnect.php");
    $username = $_POST['username'];
    $sql = "SELECT * FROM `db-user` INNER JOIN `db-emailtype` ON `db-user`.`ETID`=`db-emailtype`.`ETID` WHERE `UserName` = '" . $username . "'";
    $DATA = selectData($sql);

    if ($DATA[0]['numrow'] == 0) {
        echo ' <div class="modal-header header-modal">
        <h4 class="modal-title" style="color:white">ตั้ง Password ใหม่</h4>
        </div>
        <div class="modal-body" id="ChangeModalBody">
        <div class="container">
        
            <div class="row mb-4" style="margin-left: 10px">
                <label for="inputEmail">ชื่อผู้ใช้</label>
                <div class="col-12">
                    <input type="text" name="username2" id="username2" class="form-control" placeholder="username" required autofocus>
                </div>
                <div style="color:red;margin-top: 20px">ไม่พบผู้ใช้นี้ในระบบ</div>
            </div>
        </div>
        
        </div>
        <div class="modal-footer">
        <button type="button" name="save" id="save" value="insert" class="btn btn-success save">ยืนยัน</button>
        <button type="button" class="btn btn-danger cancel"  id="a_cancel" data-dismiss="modal">ยกเลิก</button>
        </div>';
    } else {
        $Email = $DATA[1]['EMAIL'] . '@' . $DATA[1]['Type'];
        echo '   <div class="modal-header header-modal">
        <h4 class="modal-title" style="color:white">ตั้ง Password ใหม่</h4>
        </div>
        <div class="modal-body" id="ChangeModalBody">
        <div class="container">
        
            <div class="row mb-4" style="margin-left: 10px">
               
                <div class="col-12">
                   ระบบได้ทำการส่ง link ไปยัง <br/>Email :' . $Email . '<br/>
                    กรุณาทำการเปลี่ยนรหัสภายใน 5 นาที
                </div>
              
            </div>
        </div>
        
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-danger cancel"  id="a_cancel " data-dismiss="modal">ปิด</button>
        </div>';
        $time = time() + (60 * 5);
        $IDKey = md5($DATA[1]['UID'] . $time);
        $strFileName = "logpassword.txt";
        $objFopen = fopen($strFileName, 'a');
        $strText1 = "$IDKey,{$DATA[1]['UID']},$time\r\n";
        fwrite($objFopen, $strText1);
        fclose($objFopen);
        require("../../lib/PHPMailer/PHPMailerAutoload.php");

        header('Content-Type: text/html; charset=utf-8');

        $mail = new PHPMailer;
        $mail->CharSet = "utf-8";
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->SMTPSecure = 'tls';
        $mail->SMTPAuth = true;


        $gmail_username = "plamserviceth@gmail.com"; // gmail ที่ใช้ส่ง
        $gmail_password = "PlamServiceTH1234"; // รหัสผ่าน gmail
        // ตั้งค่าอนุญาตการใช้งานได้ที่นี่ https://myaccount.google.com/lesssecureapps?pli=1


        $sender = "Plam IT Support"; // ชื่อผู้ส่ง
        $email_sender = "PlamServiceTH@gmail.com"; // เมล์ผู้ส่ง 
        $email_receiver = $Email; // เมล์ผู้รับ ***

        $subject = "เปลี่ยนรหัสผ่าน"; // หัวข้อเมล์ 


        $mail->Username = $gmail_username;
        $mail->Password = $gmail_password;
        $mail->setFrom($email_sender, $sender);
        $mail->addAddress($email_receiver);
        $mail->Subject = $subject;

        /* $email_content = "เปลี่ยน password คลิ๊กที่นี้ 
        < http://localhost/Palm-update/view/ChangePassword/ChangePassword.php?IDkey=$IDKey >";*/
        $email_content = "
        <!DOCTYPE html>
        <html>
            <head>
                <meta charset=utf-8'/>
            </head>
            <body>
                <h1 style='background: #E91E63;padding: 10px 0 20px 10px;margin-bottom:10px;font-size:30px;color:white;' >
                ระบบบริหารจัดการแปลงปลูกปาล์มน้ำมัน
                </h1>
                <div style='padding:20px;'>
                    
                    <div>             
                        <h2>การเปลี่ยนรหัสผ่าน <strong style='color:#0000ff;'></strong></h2>
                        <a href='http://203.150.37.208/Palm/view/ChangePassword/ChangePassword.php?IDkey=$IDKey' target='_blank'>
                            <h1><strong style='color:#3c83f9;'> >> กรุณาคลิ๊กที่นี่ เพื่อตั้งรหัสผ่านใหม่<< </strong> </h1>
                        </a>
                    </div>
                    
                </div>
                <div style='background: #E91E63;color: white;padding:30px;'>
                    <div style='text-align:center'> 
                        © KU ศูนย์เทคโนโลยีชีวภาพเกษตร
                    </div>
                </div>
            </body>
        </html>
    ";


        //  ถ้ามี email ผู้รับ
        if ($email_receiver) {
            $mail->msgHTML($email_content);


            if (!$mail->send()) {  // สั่งให้ส่ง email

                // กรณีส่ง email ไม่สำเร็จ
                //echo "<h3 class='text-center'>ระบบมีปัญหา กรุณาลองใหม่อีกครั้ง</h3>";
                //echo $mail->ErrorInfo; // ข้อความ รายละเอียดการ error
            } else {
                // กรณีส่ง email สำเร็จ
                //echo "ระบบได้ส่งข้อความไปเรียบร้อย";
            }
        }
    }
} else {
    header("location:../../index.php");
}
function getUser($uid)
{
    $sql = "SELECT * FROM `db-user` WHERE `UID`='$uid'";

    $DATA = selectData($sql);
    return $DATA;
}
function getDIM($uid, $title, $fname, $lname)
{
    if ($title == 1) {
        $fullname = "นาย ";
    } else if ($title == 2) {
        $fullname = "นาง ";
    } else {
        $fullname = "นางสาว ";
    }
    $fullname = $fullname . $fname . " " . $lname;
    $sql = "SELECT * FROM `dim-user` WHERE `dbID`='$uid' AND Title='$title' AND FullName='$fullname' AND Alias='$fname'";

    $DATA = selectData($sql);
    return $DATA;
}
function ch_pwd($DIM_user, $pwd_md5)
{
    $sql = "SELECT * FROM `log-password`";
    $DATA = selectData($sql);
    if ($DATA[1]['DIMuserID'] == $DIM_user && $DATA[1]['PWD'] == $pwd_md5) {
        return 0;
    }
    return 1;
}
function getDIMu($uid)
{
    $sql = "SELECT * FROM `db-user` WHERE `UID`='$uid'";
    $DATA = selectData($sql);

    $title = $DATA[1]['Title'];
    if ($title == 1) {
        $fullname = "นาย ";
    } else if ($title == 2) {
        $fullname = "นาง ";
    } else {
        $fullname = "นางสาว ";
    }
    $fname = $DATA[1]['FirstName'];
    $lname = $DATA[1]['LastName'];
    $fullname = $fullname . $fname . " " . $lname;

    $sql = "SELECT * FROM `dim-user` WHERE Title='$title' AND FullName='$fullname' AND Alias='$fname'";

    $DATA = selectData($sql);

    if (isset($DATA[1]['ID'])) {
        $IDdim_user = $DATA[1]['ID'];
    } else {
        $IDdim_user = 0;
    }
    return $IDdim_user;
}
