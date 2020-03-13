<?php
require_once("../../dbConnect.php");
require_once("../../set-log-login.php");
session_start(); 
$myConDB = connectDB();
// echo $_POST['did'];
//   echo "come";
//  echo $_POST['request'];

if(isset($_POST['request'])){
    $request = $_POST['request'];
    $sql ='';

    switch($request){
        // case 'test' :
        //     echo "test";
        //     break;
        case 'photo' :
            if(isset($_POST['imagebase64'])){
                $uid = $_POST['p_uid'];
                // echo $uid;

                $data = $_POST['imagebase64'];
                // echo $data;
                $img_array = explode(';',$data);
                $img_array2 = explode(",",$img_array[1]);
                $data = base64_decode($img_array2[1]);

                // print_r ($img_array);
                // print_r ($img_array2);
                // print_r ($data);
                $id_dim = getDIMu($uid);
                $Icon = time().'.png';

                $sql=   "UPDATE `db-user` SET Icon='$Icon'
                WHERE `UID`='$uid' ";
    
                $re = updateData($sql);
                if(!file_exists("../../icon/user/$uid")){
                        mkdir("../../icon/user/$uid");
                }
               
                file_put_contents("../../icon/user/$uid/$Icon",$data);

                $time = time();
                $data_t =  getDIMDate();
                $id_t = $data_t[1]['ID'];
                $loglogin = $_SESSION[md5('LOG_LOGIN')];
                $loglogin_id = $loglogin[1]['ID'];
                $path = "icon/user/".$uid;

            
                $sql=   "UPDATE `log-icon` SET EndT='$time', EndID='$id_t'
                WHERE `DIMiconID`='$id_dim' AND EndT IS NULL AND `Type`='6'";
    
                $re = updateData($sql);

                $sql = "INSERT INTO `log-icon` (`ID`,LOGloginID,StartT,StartID,DIMiconID,`Type`,`FileName`,`Path`) 
                 VALUES ('','$loglogin_id','$time','$id_t','$id_dim','6','$Icon','$path')";
    
                addinsertData($sql);

                $sql = "SELECT * FROM `db-user` WHERE `UID` = $uid ";
                $USER = selectData($sql);
                $_SESSION[md5('user')] = selectData($sql);

                header("location:UserProfile.php");
            }
            break;
            case 'select' :
                $sql = "SELECT * FROM `db-user`";
    
                print_r(json_encode(select($sql)));
                break;
            case 'logpass' :
                $uid = $_POST['uid'];
                // echo $uid;
                $get_idDim = getDIMu($uid);
                // echo $get_idDim;
                $sql = "SELECT * FROM `log-password` WHERE DIMuserID='$get_idDim'";
    
                print_r(json_encode(select($sql)));
                break;
            case 'getDimU' :
                $uid = $_POST['uid'];
                $get_idDim = getDIMu($uid);
                echo $get_idDim;
                break;
            case 'insert' :
                $admin = 0;
                $research = 0;
                $operator = 0;
                $farmer = 0;
    
                $last_id = last_id();
    
                echo "now";
                if(isset($_POST['admin'])){
                    $admin = 1;
                    echo $_POST['admin'];
                }
                if(isset($_POST['research'])){
                    $research = 1;
                    echo $_POST['research'];
                }
                if(isset($_POST['operator'])){
                    $operator = 1;
                    echo $_POST['operator'];
                }
                if(isset($_POST['farmer'])){
                    $farmer = 1;
                    echo $_POST['farmer'];
                }
                $title = trim($_POST['title']);
                $fname = trim($_POST['fname']);
                // echo $fname;
                $lname = trim($_POST['lname']);
                $username = trim($_POST['username']);
                $pwd = trim($_POST['pwd']);
               
                $mail = trim($_POST['mail']);  
                $id_type = trim($_POST['type']);
                $id_department = trim($_POST['department']);
    
                $array = check_dim_user_du($title,$fname,$lname);
                $check_dim = $array[0];
                $id_data  =$array[1];
                $id_u = $array[2];
                echo "<br>check_dim = $check_dim <br>";
                echo "id data = $id_data <br>";
                
                if($check_dim == 1){
                    $uid = $last_id+1;
                }else{
                    $uid = $id_u;
                }
                echo "uid = $uid <br>";
                
                $sql = "INSERT INTO `db-user` (`UID`,Title,FirstName,LastName,UserName,PWD,Icon,EMAIL,ETID,DID,IsAdmin,IsResearch,IsOperator,IsFarmer,IsBlock) 
                 VALUES ('$uid','$title','$fname','$lname','$username','null','default.jpg','$mail','$id_type','$id_department','$admin','$research','$operator','$farmer','0')";
    
                addinsertData($sql);
       
                $username_up = strtoupper($username);
                $pwd_md5 = md5($uid.$username_up.$pwd);
                
                $sql=   "UPDATE `db-user` SET PWD='$pwd_md5'
                WHERE `UID`='$uid' ";
    
                $re = updateData($sql);
               
                // $DATA =  select_dimUser();  //get DIM_user for check ADD duplicate dim-user
                    
                //     if($title == 1){
                //         $title_show = "นาย";
                //     }else if($title == 2){
                //         $title_show = "นาง";
                //     }else{
                //         $title_show = "นางสาว";
                //     }
        
                //     $fullname = $title_show." ".$fname." ".$lname;
                //     $i = 1;
                //     $check_dim = 1;
                
                //     for($i = 1;$i <= $DATA[0]['numrow'];$i++){
                //         if($DATA[$i]['Title'] == $title && $DATA[$i]['FullName'] == $fullname  && $DATA[$i]['Alias'] == $fname ){
                //             $check_dim = 0;
                //             $id_data = $DATA[$i]['ID'] ;
                //             // $get_idDim_du = getDIMu($uid);   //id-dim ที่ซ้ำ
                //             break;
                //         }
                //     }
    
                $array = check_dim_user_du($title,$fname,$lname);
                $check_dim = $array[0];
                $id_data  =$array[1];
                $id_u = $array[2];
                $fullname = $array[3];
    
                if($check_dim == 1){
                    $sql = "INSERT INTO `dim-user` (ID,`dbID`,`Type`,Title,FullName,Alias) 
                        VALUES ('','$uid','U','$title','$fullname','$fname')";
    
                    $id_u=addinsertData($sql);
                }else{
                    $id_u=$id_data;
                    echo "ซ่ำ ";
                    echo $id_u;
                }
                
    
                $time = time();
                    $data_t =  getDIMDate();
                $id_t = $data_t[1]['ID'];
                    $loglogin = $_SESSION[md5('LOG_LOGIN')];
                $loglogin_id = $loglogin[1]['ID'];
                
                $sql = "INSERT INTO `log-password` (ID,DIMuserID,LOGloginID,StartT,StartID,PWD) 
                            VALUES ('','$id_u','$loglogin_id','$time','$id_t','$pwd_md5')";
                $did = addinsertData($sql);
    
                $dimd_id = get_DIMd($id_department);
                
    
                $sql = "INSERT INTO `log-user` (ID,DIMuserID,DIMdeptID,LOGloginID,StartT,StartID,IsAdmin,IsResearch,IsOperator,IsFarmer,IsBlock) 
                            VALUES ('','$id_u','$dimd_id','$loglogin_id','$time','$id_t','$admin','$research','$operator','$farmer','0')";
                $did = addinsertData($sql);
    
                $sql = "SELECT * FROM  `db-emailtype` WHERE ETID='$id_type'";
                $DATA = selectData($sql);
                $type= $DATA[1]['Type'];
                $fullemail = $mail.'@'.$type;
    
                $sql = "INSERT INTO `log-email` (ID,DIMuserID,LOGloginID,StartT,StartID,dbETID,FullEmail,`Type`) 
                            VALUES ('','$id_u','$loglogin_id','$time','$id_t','$id_type','$fullemail','$type')";
                $did = addinsertData($sql);
                
                header("location:UserProfile.php");
                
                break;
            
            case 'delete' ;
                $uid = $_POST['uid'];
                $get_idDim = getDIMu($uid);
    
                $time = time();
                    $data_t =  getDIMDate();
                $id_t = $data_t[1]['ID'];
    
                $sql="UPDATE `log-user` 
                SET EndT='$time', EndID='$id_t'
                WHERE DIMuserID='$get_idDim' AND EndT IS NULL ";
                $o_did = updateData($sql);
    
                $sql="UPDATE `log-email` 
                SET EndT='$time', EndID='$id_t'
                WHERE DIMuserID='$get_idDim' AND EndT IS NULL ";
                $o_did = updateData($sql);
    
                $sql="UPDATE `log-password` 
                SET EndT='$time', EndID='$id_t'
                WHERE DIMuserID='$get_idDim' AND EndT IS NULL ";
                $o_did = updateData($sql);
    
                // echo $get_idDim;
                $sql="UPDATE `log-icon` 
                SET EndT='$time', EndID='$id_t'
                WHERE DIMiconID='$get_idDim' AND EndT IS NULL AND `Type`='6' ";
                $o_did = updateData($sql);
    
                $sql = "DELETE FROM `db-user` WHERE `UID`='".$uid."'";  
                delete($sql);
    
    
                break;
    
            case 'block' ;
                $val = $_POST['val'];
                $uid = $_POST['uid'];
    
                $get_idDim = getDIMu($uid);
    
                $time = time();
                    $data_t =  getDIMDate();
                $id_t = $data_t[1]['ID'];
                    $loglogin = $_SESSION[md5('LOG_LOGIN')];
                $loglogin_id = $loglogin[1]['ID'];
    
                $sql = "SELECT * FROM `log-user`  WHERE DIMuserID='$get_idDim' AND EndT IS NULL ";
                $DATA = selectData($sql);
                $id_old = $DATA[1]['ID'];
    
                $id_dim = $DATA[1]['DIMuserID'];
                $dimd_id = $DATA[1]['DIMdeptID'];
                $admin = $DATA[1]['IsAdmin'];
                $research = $DATA[1]['IsResearch'];
                $operator = $DATA[1]['IsOperator'];
                $farmer = $DATA[1]['IsFarmer'];
    
                $sql = "INSERT INTO `log-user` (ID,DIMuserID,DIMdeptID,LOGloginID,StartT,StartID,IsAdmin,IsResearch,IsOperator,IsFarmer,IsBlock) 
                        VALUES ('','$id_dim','$dimd_id','$loglogin_id','$time','$id_t','$admin','$research','$operator','$farmer','$val')";
                $did = addinsertData($sql);
             
                            
                $sql="UPDATE `log-user` 
                    SET EndT='$time', EndID='$id_t'
                    WHERE ID='$id_old'";
                $o_did = updateData($sql);
                           
                $sql=   "UPDATE `db-user` SET IsBlock=$val
                    WHERE `UID`='$uid' ";
                $re = updateData($sql);
    
                break;
            case 'md5' ;
                $pwd = $_POST['pwd'];
                $pwd_md5 = md5($pwd);
                echo $pwd_md5;
    
                break;
                case 'changePass' ;
                
                $pwd = trim($_POST['e_pwd']);
                $uid = $_POST['pass_uid'];
                $username = $_POST['pass_username'];
                $o_pwd = trim($_POST['pass_old']);
    
                // echo   "<script>
                //         console.log('$o_pwd');
                //         </script>";
                $title = $_POST['p_title'];
                $fname = $_POST['p_fname'];
                $lname = $_POST['p_lname'];
    
                $DIM_user = getDIM($uid,$title,$fname,$lname);
                $id_dim = $DIM_user[1]['ID'];
                $username_up = strtoupper($username);
                
                $DATA = getUser($uid);
                $pwd_DATA = $DATA[1]['PWD'];
                $pwd_md5 = md5($uid.$username_up.$pwd);
                
                if($o_pwd == $pwd_md5){
                    
                    header("location:UserProfile.php");
                }else{
    
                
                $time = time();
                    $data_t =  getDIMDate();
                $id_t = $data_t[1]['ID'];
                    $loglogin = $_SESSION[md5('LOG_LOGIN')];
                $loglogin_id = $loglogin[1]['ID'];
                $ch_pwd = ch_pwd($DIM_user,$pwd_md5);
                if($ch_pwd){
                    $sql="UPDATE `log-password` 
                                SET EndT='$time', EndID='$id_t'
                                WHERE DIMuserID='$id_dim' AND EndT IS NULL ";
                    $o_did = updateData($sql);
    
                
                    $sql = "INSERT INTO `log-password` (DIMuserID,LOGloginID,StartT,StartID,PWD) 
                    VALUES ('$id_dim','$loglogin_id','$time','$id_t','$pwd_md5')";
    
                    $did = addinsertData($sql);
                }
                
    
                 $sql=   "UPDATE `db-user` 
                            SET PWD='$pwd_md5'
                            WHERE `UID`='$uid' ";
    
                    $re = updateData($sql);
    
                    $data_u =$_SESSION[md5('user')];
    
                    if($data_u[1]['UID'] == $uid){
                        $sql = "SELECT * FROM `db-user` WHERE `UID` = $uid ";
                        $USER = selectData($sql);
                        $_SESSION[md5('user')] = selectData($sql);
                    }
    
                    header("location:UserProfile.php");
                
                }
                break;
            case 'update' :
                $uid = $_POST['uid'];
                // echo $uid;
            $admin = 0;
            $admin2 = 0;
            $research = 0;
            $operator = 0;
            $farmer = 0;
            $set = 0;
        
            if(isset($_POST['e_admin'])){
                $admin = 1;
            }
            if(isset($_POST['e_admin2'])){
                $admin2 = 1;
            }
            if(isset($_POST['e_research'])){
                $research = 1;
            }
            if(isset($_POST['e_operator'])){
                $operator = 1;
            }
            if(isset($_POST['e_farmer'])){
                $farmer = 1;
            }
            $title = trim($_POST['e_title']);
            $fname = trim($_POST['e_fname']);
            $lname = trim($_POST['e_lname']);
            $username = strtolower(trim($_POST['e_username1']));
            $mail = trim($_POST['e_mail']);
            $id_type = trim($_POST['e_type']);
            $id_department = trim($_POST['e_department']);
                $get_User = getUser($uid);
                $o_mail = $get_User[1]['EMAIL'];
                $o_etid = $get_User[1]['ETID'];

                $o_idd = $get_User[1]['DID'];
                $o_title = $get_User[1]['Title'];
                $o_fname = $get_User[1]['FirstName'];
                $o_lname = $get_User[1]['LastName'];
                $o_username = $get_User[1]['UserName'];
                $o_admin = $get_User[1]['IsAdmin'];
                $o_admin2 = $get_User[1]['IsAdmin2'];
                $o_research = $get_User[1]['IsResearch'];
                $o_operator = $get_User[1]['IsOperator'];
                $o_farmer = $get_User[1]['IsFarmer'];

                $o_block = $get_User[1]['IsBlock'];
                
                // echo $o_title." ";
                // echo $o_fname." ";
                // echo $o_lname." ";
                // echo $o_username." ";
                // echo $o_idd." ";
                // echo $o_admin." ";
                // echo $o_research." ";
                // echo $o_operator." ";
                // echo $o_farmer." ";
                $dt=getUser($uid);
                $pwd_md5=$dt[1]['PWD'];

                $get_idDim = getDIMu($uid);     //id-dim ตัวเก่า
                // $get_o_idDim = getDIMu($uid); 
                $time = time();
                $data_t =  getDIMDate();
                $id_t = $data_t[1]['ID'];
                $loglogin = $_SESSION[md5('LOG_LOGIN')];
                $loglogin_id = $loglogin[1]['ID'];

                $sql=   "UPDATE `db-user` 
                        SET Title='$title', FirstName='$fname', LastName='$lname',UserName='$username', EMAIL='$mail', ETID='$id_type',
                        DID='$id_department', IsAdmin='$admin',IsAdmin2='$admin2', IsResearch='$research',IsOperator='$operator', IsFarmer='$farmer'
                        WHERE `UID`='$uid' ";

                $re = updateData($sql);
               
                $array = check_dim_user_du($title,$fname,$lname);
                $check_dim = $array[0];
                $id_data  =$array[1];
                $id_u = $array[2];
                $fullname = $array[3];

                // echo "id_d = ".$id_department;
                // echo "O_idd = ".$o_idd;
               echo "<br>/ch dim = ".$check_dim."<br>";
                $sql = "SELECT * FROM  `db-emailtype` WHERE ETID='$id_type'";
                        $DATA = selectData($sql);
                        $type= $DATA[1]['Type'];
                        $fullemail = $mail.'@'.$type;


                if($o_title == $title && $o_fname == $fname && $o_lname == $lname && $o_username == $username &&
                $o_idd == $id_department && $o_admin == $admin && $o_admin2 == $admin2 && $o_research == $research && $o_operator == $operator 
                && $o_farmer == $farmer){
                    $id_dim=$get_idDim;
                }else{
                    if($check_dim == 1){
                        // header("location:test.php");
                        echo   "<script>
                            console.log('ไม่ซ้ำ');
                            </script>";
//    --------------------------------------------------- update dim-user ---------------------------------------------------
                        $sql = "INSERT INTO `dim-user` (ID,`dbID`,`Type`,Title,FullName,Alias) 
                        VALUES ('','$uid','U','$title','$fullname','$fname')";

                        $id_dim = addinsertData($sql);
                                    
//    ------------------------------------------------ update and Add log-login ---------------------------------------------------                       
                        $sh = $_SESSION[md5('user')];
                        $row = $sh[0]['numrow'];
                        UpdateLogLogin();
                        NewLogLogin();

                        // $id_dim = $get_idDim ; 
                        $set = 1;


               }else{
                        $id_dim=$id_data;
                        echo   "<script>
                        console.log('ซ้ำ');
                        </script>";
                        // header("location:UserProfile.php");
                        if($o_title == $title && $o_fname == $fname && $o_lname == $lname){
                            $set=0;
                        }else{
                            $set=1;
                        }
                        
               }
                }
               

                if($set == 1){
                    echo " เข้ามา ";
                    $sql="UPDATE `log-email` 
                            SET EndT='$time', EndID='$id_t'
                            WHERE DIMuserID='$get_idDim' AND EndT IS NULL ";
                        $o_did = updateData($sql);
                        echo "getDim =".$get_idDim."<br>";
                        $sql = "INSERT INTO `log-email` (ID,DIMuserID,LOGloginID,StartT,StartID,dbETID,FullEmail,`Type`) 
                        VALUES ('','$id_dim','$loglogin_id','$time','$id_t','$id_type','$fullemail','$type')";
                        $did = addinsertData($sql);
                        
                        $sql="UPDATE `log-password` 
                        SET EndT='$time', EndID='$id_t'
                        WHERE DIMuserID='$get_idDim' AND EndT IS NULL ";
                        $o_did = updateData($sql);

                        $sql="SELECT * FROM `log-password` 
                        WHERE DIMuserID='$get_idDim'";
                        $result = $myConDB->prepare($sql); 
                        $result->execute();
                        echo "<br>";
                           echo $get_idDim;

                        while ($row = $result->fetch(PDO::FETCH_ASSOC)){
                            $loglogin_id1 = $row["LOGloginID"];
                            $time1 = $row["StartT"];
                            $id_t1 = $row["StartID"];
                            $endTime1 = $row["EndT"];
                            $id_et1 = $row["EndID"];
                            $pwd_md51 =  $row["PWD"];
                            
                            $duplicate = 0;
                            $sql1="SELECT * FROM `log-password` 
                            WHERE DIMuserID='$id_dim'";
                            $result1 = $myConDB->prepare($sql1); 
                            $result1->execute();
                            while ($row1 = $result1->fetch(PDO::FETCH_ASSOC)){
                                if($row1["PWD"] == $row["PWD"] && $row1["StartT"] == $row["StartT"]){
                                    echo "<br>pass du<br>";
                                    $duplicate = 1;
                                    break;
                                }else{
                                    $duplicate = 0;
                                }
                            }

                            echo "<br>";
                           echo $pwd_md51;
                            if($duplicate == 0){
                                $sql = "INSERT INTO `log-password` (DIMuserID,LOGloginID,StartT,StartID,EndT,EndID,PWD) 
                                VALUES ('$id_dim','$loglogin_id1','$time1','$id_t1','$endTime1','$id_et1','$pwd_md51')";
    
                                $did = addinsertData($sql);
                                
                            }
                            
                        }
                        $sql = "INSERT INTO `log-password` (DIMuserID,LOGloginID,StartT,StartID,PWD) 
                            VALUES ('$id_dim','$loglogin_id','$time','$id_t','$pwd_md5')";

                            $did = addinsertData($sql);
                        
                        
                        $sql = "SELECT * FROM `log-icon` WHERE DIMiconID='$get_idDim' AND EndT IS NULL AND `Type`='6'" ;
                            $LogIcon = selectData($sql);
                        
                            $sql=   "UPDATE `log-icon` SET EndT='$time', EndID='$id_t'
                            WHERE `DIMiconID`='$get_idDim' AND EndT IS NULL AND `Type`='6'";
                
                            $re = updateData($sql);
                            $Icon = $LogIcon[1]['FileName'];
                            $path = $LogIcon[1]['Path'];
                            echo "<br> $get_idDim <br>icon = $Icon<br>path = $path";

                            $sql = "INSERT INTO `log-icon` (`ID`,LOGloginID,StartT,StartID,DIMiconID,`Type`,`FileName`,`Path`) 
                             VALUES ('','$loglogin_id','$time','$id_t','$id_dim','6','$Icon','$path')";
                
                            addinsertData($sql);
                }
//    --------------------------------------------------- get for log -------------------------------------------------------
               
                if($o_title == $title && $o_fname == $fname && $o_lname == $lname && $o_username == $username &&
                $o_idd == $id_department && $o_admin == $admin && $o_admin2 == $admin2 && $o_research == $research && $o_operator == $operator 
                && $o_farmer == $farmer){
                    echo " o_title= ".$o_title;
                    echo " title= ".$title;
                
                }else{
//    --------------------------------------------------- update log-user ---------------------------------------------------
                    echo " iddim = ".$get_idDim;
                    $sql="UPDATE `log-user` 
                            SET EndT='$time', EndID='$id_t'
                            WHERE DIMuserID='$get_idDim' AND EndT IS NULL ";
                $o_did = updateData($sql);

            //    echo "";

//    --------------------------------------------------- insert log-user ---------------------------------------------------

                $dimd_id = get_DIMd($id_department);  //get ID_DIM_department for Add log-user

                $sql = "INSERT INTO `log-user` (ID,DIMuserID,DIMdeptID,LOGloginID,StartT,StartID,IsAdmin,IsAdmin2,IsResearch,IsOperator,IsFarmer,IsBlock) 
                            VALUES ('','$id_dim','$dimd_id','$loglogin_id','$time','$id_t','$admin','$admin2','$research','$operator','$farmer','$o_block')";
                $did = addinsertData($sql);
                }
                

                $sql = "SELECT * FROM  `db-emailtype` WHERE ETID='$id_type'";
                $DATA = selectData($sql);
                $type= $DATA[1]['Type'];
                $fullemail = $mail.'@'.$type;

                echo $o_mail." ".$mail."--";
                echo $o_etid." ".$id_type;
                if($o_mail == $mail && $o_etid == $id_type ){

                }else if($set == 0){

                $id_dim = $get_idDim; 
                $sql="UPDATE `log-email` 
                            SET EndT='$time', EndID='$id_t'
                            WHERE DIMuserID='$id_dim' AND EndT IS NULL ";
                $o_did = updateData($sql);
                echo "id set 0 = ".$id_dim."<br>";

                $sql = "INSERT INTO `log-email` (ID,DIMuserID,LOGloginID,StartT,StartID,dbETID,FullEmail,`Type`) 
                            VALUES ('','$id_dim','$loglogin_id','$time','$id_t','$id_type','$fullemail','$type')";
                $did = addinsertData($sql);
                }

                $data_u =$_SESSION[md5('user')];

                if($data_u[1]['UID'] == $uid){
                    $sql = "SELECT * FROM `db-user` WHERE `UID` = $uid ";
                    $USER = selectData($sql);
                    $_SESSION[md5('user')] = selectData($sql);
                }
                
                
                   header("location:UserProfile.php");
                
               
            break;

            // }
    }

    
}
function check_dim_user_du($title,$fname,$lname){
            $DATA =  select_dimUser();  //get DIM_user for check ADD duplicate dim-user
            // print_r($DATA);
            $array[0] = 1;
            $array[1] = 0;
            $array[2] = 0;
                if($title == 1){
                    $title_show = "นาย";
                }else if($title == 2){
                    $title_show = "นาง";
                }else{
                    $title_show = "นางสาว";
                }
    
                $fullname = $title_show." ".$fname." ".$lname;
                $i = 1;
                $check_dim = 1;
            
                $array[3] = $fullname;
                for($i = 1;$i <= $DATA[0]['numrow'];$i++){
                    // echo "/6";
                    if($DATA[$i]['Title'] == $title && $DATA[$i]['FullName'] == $fullname  && $DATA[$i]['Alias'] == $fname ){
                        $array[0] = 0;
                        $array[1] = $DATA[$i]['ID'] ;
                        $array[2] = $DATA[$i]['dbID'];
                        // $get_idDim_du = getDIMu($uid);   //id-dim ที่ซ้ำ
                        break;
                    }
                }
                echo "* $array[0] <br>";
            return $array;
}
function last_id(){
    $sql = "SELECT MAX(`dbID`)as max FROM `dim-user` WHERE `Type`='U'";
    $max = selectData($sql);
    return $max[1]['max'];
}
function ch_pwd($DIM_user,$pwd_md5){
    $sql = "SELECT * FROM `log-password`";
    $DATA = selectData($sql);
    if($DATA[1]['DIMuserID'] == $DIM_user && $DATA[1]['PWD'] == $pwd_md5){
        return 0;
    }
    return 1;
    
}
function getDIMu($uid){
    $sql = "SELECT * FROM `db-user` WHERE `UID`='$uid'";
    $DATA = selectData($sql);
    
    $title = $DATA[1]['Title'];
    if($title == 1){
        $fullname = "นาย ";
    }else if($title == 2){
        $fullname = "นาง ";
    }else{
        $fullname = "นางสาว ";
    }
    $fname = $DATA[1]['FirstName'];
    $lname = $DATA[1]['LastName'];
    $fullname = $fullname.$fname." ".$lname;

    $sql = "SELECT * FROM `dim-user` WHERE Title='$title' AND FullName='$fullname' AND Alias='$fname' AND `Type`='U'";

    $DATA = selectData($sql);
    
    if(isset($DATA[1]['ID'])){
        $IDdim_user = $DATA[1]['ID'];
    }else{
        $IDdim_user=0;
    }
    return $IDdim_user;

}
function get_DIMd($id_department){
    $sql = "SELECT * FROM `db-department` WHERE `DID`='$id_department'";
    $DATA = selectData($sql);
    $department = $DATA[1]['Department'];
    $alias = $DATA[1]['Alias'];
    $note = $DATA[1]['Note'];

    // echo $department;

    $sql = "SELECT * FROM `dim-department` WHERE `Department`='$department' AND Alias='$alias' AND Note='$note'";
    $DATA = selectData($sql);
    $dimd_id = $DATA[1]['ID'];

   return $dimd_id;
}
function getDIM($uid,$title,$fname,$lname){
    if($title == 1){
        $fullname = "นาย ";
    }else if($title == 2){
        $fullname = "นาง ";
    }else{
        $fullname = "นางสาว ";
    }
    $fullname = $fullname.$fname." ".$lname;
    $sql = "SELECT * FROM `dim-user` WHERE `dbID`='$uid' AND Title='$title' AND FullName='$fullname' AND Alias='$fname' AND `Type`='U'";

   $DATA = selectData($sql);
   return $DATA;
}
function select_dimUser(){
    $sql = "SELECT * FROM `dim-user` WHERE `Type`='U'";

   $DATA = selectData($sql);
   return $DATA;

}
function getUser($uid){
    $sql = "SELECT * FROM `db-user` WHERE `UID`='$uid'";

   $DATA = selectData($sql);
   return $DATA;
}

?>