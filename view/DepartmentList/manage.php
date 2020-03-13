<?php
require_once("../../dbConnect.php");
connectDB();
session_start(); 
require_once("set-log-login.php");
// echo $_POST['did'];
// echo "come";
// echo $_POST['request'];

if(isset($_POST['request'])){
    $request = $_POST['request'];
    $sql ='';
    
    
    // $dateUpdate = json_decode($_POST['dataUpdate']);
    // $ateInsert = json_decode($_POST['dataInsert']);
    // $dateDelete = json_decode($_POST['dataDelete']);
   

    switch($request){
        case 'select' :
            $sql = "SELECT * FROM `db-department`";

            print_r(json_encode(select($sql)));
            break;

        case 'insert' :
            $department = trim($_POST['department']);
            $alias = trim($_POST['alias']);
            $note = trim($_POST['note']);
            $time = time();
            
                    // echo $time;
                    $department = preg_replace('/[[:space:]]+/', ' ', trim($department));
                    $alias = preg_replace('/[[:space:]]+/', ' ', trim($alias));
                    $note = preg_replace('/[[:space:]]+/', ' ', trim($note));
                    
                    $i = 1;

                    $last_id = last_id();

                    $array = check_de_du($department,$alias,$note);
                    $check_dim = $array[0];
                    $id_data = $array[1];
                    $id_de = $array[2];
                    if($check_dim == 1){
                        $id_d = $last_id+1;
                    }else{
                        $id_d = $id_de;
                    }
                    echo   "<br>check_dim = ".$check_dim;
                    echo   "<br>id_d = ".$id_d;

                            $sql = "INSERT INTO `db-department` (DID,Department,Alias,Note) 
                            VALUES ('$id_d','$department','$alias','$note')";
        
                            $did = addinsertData($sql);
                    echo   "<br>did add = ".$did;

                    $array = check_de_du($department,$alias,$note);
                    $check_dim = $array[0];
                    $id_data = $array[1];
                    $id_de = $array[2];

                    if($check_dim){
                        $sql = "INSERT INTO `dim-department` (ID,`dbID`,Department,Alias,Note) 
                        VALUES ('','$did','$department','$alias','$note')";  
    
                        $id_d = addinsertData($sql);
                        // echo $id_d;
                        
                    }else{
                        $id_d = $id_data;
                    }
                    $data_t =  getDIMDate();
                        $id_t = $data_t[1]['ID'];
                        // echo $id_t;

                        // echo $id_t[1]['ID'];
                        $loglogin = $_SESSION[md5('LOG_LOGIN')];
                        $loglogin_id = $loglogin[1]['ID'];
                        echo   "<script>
                            console.log($loglogin_id );
                            </script>";
                        $sql = "INSERT INTO `log-department` (ID,DIMdeptID,LOGloginID,StartT,StartID) 
                        VALUES ('','$id_d','$loglogin_id','$time','$id_t')";

                        $did = addinsertData($sql);
                    
                
                    header("location:DepartmentList.php");


 
            break;
        
        case 'delete' ;
            $did = $_POST['did'];
            $department = trim($_POST['department']);
            $alias = trim($_POST['alias']);
            $note = trim($_POST['note']);
            // echo   "$department";
            // echo   "$alias";
            // echo   "$note";
            $dim=getDIM($did,$department,$alias,$note);
            $dim_id = $dim[1]['ID'];
            // echo   "$dim_id";
            $o_log=getLog($dim_id);
            $o_log_id = $o_log[1]['ID'];
            // echo   "$o_log_id";
            $time = time();
            $data_t =  getDIMDate();
            $id_t = $data_t[1]['ID'];
            $sql="UPDATE `log-department` 
                        SET EndT='$time', EndID='$id_t'
                        WHERE ID='$o_log_id' ";
            $o_did = updateData($sql);
            $sql = "DELETE FROM `db-user` WHERE `DID`='".$did."'";  
            delete($sql);
            $sql = "DELETE FROM `db-department` WHERE `DID`='".$did."'";  
            delete($sql);
            
            break;
            
        case 'update' :
            echo   "<script>
            console.log('sfdsf');
            </script>";
            $did = $_POST['e_did'];
            $department = trim($_POST['e_department']);
            $alias = trim($_POST['e_alias']);
            $note = trim($_POST['e_note']);

            $department = preg_replace('/[[:space:]]+/', ' ', trim($department));
            $alias = preg_replace('/[[:space:]]+/', ' ', trim($alias));
            $note = preg_replace('/[[:space:]]+/', ' ', trim($note));

            $o_department = trim($_POST['e_o_department']);
            $o_alias = trim($_POST['e_o_alias']);
            $o_note = trim($_POST['e_o_note']);
            // echo   "<script>
            // console.log('$o_department $o_alias $o_note');
            // </script>";
            $dim=getDIM($did,$o_department,$o_alias,$o_note);
            $dim_id = $dim[1]['ID'];

            $o_log=getLog($dim_id);
            $o_log_id = $o_log[1]['ID'];
            // echo   "<script>
            //             console.log('$o_log_id');
            //             </script>";

            echo "$did";
                $sql=   "UPDATE `db-department` 
                        SET Department='$department', Alias='$alias', Note='$note'
                        WHERE DID='$did' ";

                $re = updateData($sql);
                $DATA = select_dimDepartment();
                $i = 1;
                $check_dim = 1;
                for($i = 1;$i <= $DATA[0]['numrow'];$i++){
                    if($DATA[$i]['Department'] == $department && $DATA[$i]['Alias'] == $alias  && $DATA[$i]['Note'] == $note ){
                        $id_d=$DATA[$i]['ID'];
                        $check_dim = 0;
                        break;
                    }
                }
// ------------------------------------- if DIM don't duplicated ----------------------------
                if($check_dim){
                    $sql = "INSERT INTO `dim-department` (ID,`dbID`,Department,Alias,Note) 
                    VALUES ('','$did','$department','$alias','$note')";  

                    $id_d = addinsertData($sql);
                    
                   
                }
                $time = time();
                $data_t =  getDIMDate();
                $id_t = $data_t[1]['ID'];
                $loglogin = $_SESSION[md5('LOG_LOGIN')];
                $loglogin_id = $loglogin[1]['ID'];

                if($o_department == $department && $o_alias ==$alias && $o_note == $note){

                }else{
                    echo $o_log_id;
                    $sql="UPDATE `log-department` 
                    SET EndT='$time', EndID='$id_t'
                    WHERE ID='$o_log_id' AND EndT IS NULL";
    
                    $o_did = updateData($sql);
    
                    $sql = "INSERT INTO `log-department` (ID,DIMdeptID,LOGloginID,StartT,StartID) 
                    VALUES ('','$id_d','$loglogin_id','$time','$id_t')";
    
                    $did = addinsertData($sql);
                }
              


                header("location:DepartmentList.php");
            break;

           
    }
    
   
    
}
function last_id(){
    $sql = "SELECT MAX(`dbID`)as max FROM `dim-department`";
    $max = selectData($sql);
    return $max[1]['max'];
}
function check_de_du($department,$alias,$note){
    $DATA = select_dimDepartment();
    $array[0] = 1;
    $array[1] = 0;
    $array[2] = 0;

    for($i = 1;$i <= $DATA[0]['numrow'];$i++){                        
        if($DATA[$i]['Department'] == $department && $DATA[$i]['Alias'] == $alias  && $DATA[$i]['Note'] == $note ){
            $array[0] = 0;
            $array[1]=$DATA[$i]['ID'];
            $array[2]=$DATA[$i]['dbID'];
            break;
        }
    }   
    return $array;
}
function select_dimDepartment(){
    $sql = "SELECT * FROM `dim-department`";

   $DATA = selectData($sql);
   return $DATA;

}
function getDIM($did,$o_department,$o_alias,$o_note){
    $sql = "SELECT * FROM `dim-department` WHERE Department='$o_department' AND Alias='$o_alias' AND Note='$o_note' ";

   $DATA = selectData($sql);
   return $DATA;

}
function getLog($dim_id){
    $sql = "SELECT * FROM `log-department` WHERE DIMdeptID='$dim_id' AND EndT IS NULL";

    $DATA = selectData($sql);
    return $DATA;

}

?>