<?php 
session_start();
require "../../dbConnect.php";
require "../../set-log-login.php";
$request = $_POST['request'];
// mkdir("path/to/my/dir", 0700);

switch($request){
    case 'select': //--------------------------case select ------------------------------
        $sql = "SELECT * FROM `db-fertilizer` join `dim-fertilizer` on (`dbID` = `db-fertilizer`.`FID`) WHERE `db-fertilizer`.`Name` = `dim-fertilizer`.`Name` AND `db-fertilizer`.`Alias` = `dim-fertilizer`.`Alias`";
        print_r(json_encode(select($sql)));
        break;
    case 'p':

        $Con = $_POST['condition'];
        $numCon = 0;
        $Condition = array();
        foreach($Con as $i=>$val){
            if($val != ''){
                $numCon++;
                $Condition[] = $val;
            }
        }
        $FID = $_POST['id'];
        $dataCondition = selectData(" SELECT * FROM `db-fercondition` WHERE `FID` = $FID");
        // echo"---". $numCon."=".$dataCondition[0]['numrow'];
        break;
    case 'update': //--------------------------case update ------------------------------
        $Name = preg_replace('/[[:space:]]+/', ' ', trim($_POST['name']));
        $Alias = preg_replace('/[[:space:]]+/', ' ', trim($_POST['alias']));
        $Unit = 1;
        // $Usage = $_POST['exampleRadios1'];
        $FID = $_POST['id'];
        $DIMID = $_POST['dimid'];
        $Icon = $_POST['icon'];

        // echo"---". "Iconnnnnn".$Icon;
        $dataI;
        
        // ------------------------------- check data to update
        $isIcon = false;
        $isCondition = false;
        $isData = true;

        $t=time();
        $sql = '';
        $Start = '';
        $End =  '';
        // ------------------------------------ CONDITION DATA ---------------------------------
        if(isset($_POST['start'])&&$_POST['exampleRadios2']==2){
            $Start = $_POST['start'];
            $End = $_POST['end'];
        }
        else{
            $Start = '0101';
            $End = '3112';
        }
        $EQ1 = $_POST['a'];
        $EQ2 = $_POST['b']; 
        // ------------------------------------ update db-fertilizer` ---------------------------------
        
        // $sql_insert = '';
        
        if(isset($_POST['imagebase64'])){
            $dataI = $_POST['imagebase64'];
            $img_array = explode(';',$dataI);
            $img_array2 = explode(",",$img_array[1]);
            $dataI = base64_decode($img_array2[1]);
            $Icon = time().'.png';
            $isIcon = true;
        }

        $IDInsert = $DIMID;
        $sql = "SELECT * FROM `db-fertilizer` WHERE `FID` = $FID";
        $dataSelect = select($sql);
        $dataAll = $dataSelect[1];

        $dataSelect = (select("SELECT * FROM `db-fertilizer` WHERE `FID` = $FID"))[1];
        if($Start==$dataSelect['Start']&&$End==$dataSelect['End']&&$Name==$dataSelect['Name']&&$Alias==$dataSelect['Alias']
        &&$EQ1==$dataSelect['EQ1']&&$EQ2==$dataSelect['EQ2']&&$Unit==$dataSelect['Unit']&&$isIcon==false){
            $isData = false;
        }
        else{
            $sql_update = "UPDATE `db-fertilizer` 
            SET `Start` = '$Start', `End`= '$End', `Name` = '$Name',`Alias` = '$Alias', `Usage` = 1,
            `EQ1` = $EQ1, `EQ2` = $EQ2 ,`Unit` = $Unit ,`Icon` = '$Icon'
            WHERE `FID` = $FID;";
            updateData($sql_update); 
        
        // ------------------------------------ insert log ---------------------------------
        
        $StartDD = intval(str_split($dataAll['Start'],2)[0]);
        $StartMM = intval(str_split($dataAll['Start'],2)[1]);
        $EndDD = intval(str_split($dataAll['End'],2)[0]);
        $EndMM = intval(str_split($dataAll['End'],2)[1]);
        
        $data = ['FID'=>$FID,'Name'=>$Name,'Alias'=>$Alias,'Unit'=>['Unit'],'Usage'=>$dataAll['Usage'],'EQ1'=>$dataAll['EQ1'],
        'EQ2'=>$dataAll['EQ2'], 'StartDD' => $StartDD,'StartMM' => $StartMM,'EndDD' => $EndDD,
        'EndMM' => $EndMM];

        

        updateLog($DIMID);
        $IDInsert = insertLog($data);
        }
        
         // ------------------------------------ update db fer condition` ---------------------------------
        $Con = $_POST['condition'];
        $numCon = 0;
        $Condition = array();
        foreach($Con as $i=>$val){
            if($val != ''){
                
                $Condition[$numCon] = preg_replace('/[[:space:]]+/', ' ', trim($val));
                // echo"---". trim($val)."-----";
                $numCon++;
            }
        }
        $dataCondition = selectData(" SELECT * FROM `db-fercondition` WHERE `FID` = $FID");
        if(sizeof($Condition)>0){
           if($dataCondition[0]['numrow']>0){
            if($dataCondition[0]['numrow'] == $numCon){
                foreach($dataCondition as $i => $val){
                    if($i>0){
                       if($dataCondition[$i]['Condition'] != $Condition[($i-1)]){
                        $isCondition = true;
                        // break;
                    } 
                    }
                    
                }
                if($isCondition){
                    $sql_del = "DELETE FROM `db-fercondition` WHERE `FID` = $FID;";
                    deletedata($sql_del);
                    $size = 1;
                    updateLogCon($DIMID);
                    foreach($Condition as $i=>$val){
                        $val = trim($val);
                            $sql_insert = "INSERT INTO `db-fercondition` (`FID`,`Order`,`Condition`) VALUES ($FID,$size,'$val');";
                            addinsertData($sql_insert);
                            insertLogCon($Condition[$i],$IDInsert,$size);
                            $size++;
                }
                }else{
                    if($DIMID!=$IDInsert){
                        $IDCon = $DIMID;
                        updateLogCon($DIMID);
                        $size = 1;
                        foreach($Condition as $i=>$val){
                            insertLogCon($Condition[$i],$IDInsert,$size);
                            $size++;
                        }
                    }
                    // else break;
                }
            }
            else{
                 $sql_del = "DELETE FROM `db-fercondition` WHERE `FID` = $FID;";
                deletedata($sql_del);
                $size = 1;
                updateLogCon($DIMID);
                foreach($Condition as $i=>$val){
                        $sql_insert = "INSERT INTO `db-fercondition` (`FID`,`Order`,`Condition`) VALUES ($FID,$size,'$val');";
                        addinsertData($sql_insert);
                        insertLogCon($Condition[$i],$IDInsert,$size);
                        $size++;
                }
                
            }
        } 
        else{
            $size = 1;
            foreach($Condition as $i=>$val){
                            $sql_insert = "INSERT INTO `db-fercondition` (`FID`,`Order`,`Condition`) VALUES ($FID,$size,'$val');";
                            addinsertData($sql_insert);
                            insertLogCon($Condition[$i],$IDInsert,$size);
                            // insertLogCon($Condition[$i],$DIMID);
                            $size++;
                    }
        }
        }
        else{
            $sql_del = "DELETE FROM `db-fercondition` WHERE `FID` = $FID;";
            deletedata($sql_del);
            updateLogCon($DIMID);
        }
        // ---------------------------------------update Icon ----------------------------------
        // if($isData == false)
        if($isIcon){
            if(!file_exists("../../icon/fertilizer/$FID")){
                mkdir("../../icon/fertilizer/$FID");
        }   
            

            file_put_contents("../../icon/fertilizer/$FID/$Icon",$dataI);

            $dataIcon = [];
            $StartT = time();
            $StartID = getDIMDate()[1]['ID'];
            $path = "icon/fertilizer/$FID";
            $dataIcon = ['Path' =>  $path,'FileName' => $Icon];
            // $dataIcon['StartT'] = $StartT;
            // $dataIcon['LOGloginID'] =  $_SESSION[md5('LOG_LOGIN')][1]['ID'];;
            // $dataIcon['StartID'] = $StartID; 
            $dataIcon['DIMIconID'] = $IDInsert;

            updateLogIcon($DIMID);
            insertLogIcon($dataIcon);
        }
        else{
            if($DIMID!=$IDInsert){
                // echo"---"."insertttttttttttt";
                $StartT = time();
                $StartID = getDIMDate()[1]['ID'];
                $IDICON = $DIMID;
                // $sql = "SELECT * FROM `db-fertilizer` WHERE `FID` = '$FID'";
                // echo"---". $sql;
                // $data = select($sql);
                // echo"---". $data;

                $dataIcon = [];
                $dataIcon['FileName'] = "$Icon";
                // $fileName = $Icon;
                // $dataIcon['Type'] = 2;
                $dataIcon['Path'] = "icon/fertilizer/$FID";
                // $dataIcon['StartT'] = $StartT;
                // $dataIcon['LOGloginID'] =  $_SESSION[md5('LOG_LOGIN')][1]['ID'];
                // $dataIcon['StartID'] = $StartID; 
                $dataIcon['DIMIconID'] = $IDInsert;

                updateLogIcon($DIMID);
                insertLogIcon($dataIcon);
            }
        }
        
        break;
    case 'insert':
        $Name =  preg_replace('/[[:space:]]+/', ' ', trim($_POST['name_insert']));
        $Alias = preg_replace('/[[:space:]]+/', ' ', trim($_POST['alias_insert']));
        $isIcon = false;
        $Icon = NULL;
        $dataI;
        $path;
       
        if($_POST['imagebase64']!=''){
            $data = $_POST['imagebase64'];
            $img_array = explode(';',$data);
            $img_array2 = explode(",",$img_array[1]);
            $dataI = base64_decode($img_array2[1]);
            
            $Icon = time().'.png';
            $isIcon = true;
        }
        
        $sql = "INSERT INTO `db-fertilizer` (`Name`,`Alias`,`Icon`) VALUES ('$Name','$Alias','$Icon');";
        $id = addinsertData($sql);

       
        // ------------------------------------ insert log ---------------------------------
        $sql = "SELECT * FROM `db-fertilizer` WHERE `FID` = $id";
        $dataSelect = select($sql);
        $dataAll = $dataSelect[1];
        $StartDD = intval(str_split($dataAll['Start'],2)[0]);
        $StartMM = intval(str_split($dataAll['Start'],2)[1]);
        $EndDD = intval(str_split($dataAll['End'],2)[0]);
        $EndMM = intval(str_split($dataAll['End'],2)[1]);
        
        $data = ['FID'=>$id,'Name'=>$Name,'Alias'=>$Alias,'Unit'=>['Unit'],'Usage'=>$dataAll['Usage'],'EQ1'=>$dataAll['EQ1'],
        'EQ2'=>$dataAll['EQ2'], 'StartDD' => $StartDD,'StartMM' => $StartMM,'EndDD' => $EndDD,
        'EndMM' => $EndMM];

        $DIMID = insertLog($data);
        
        if($isIcon){
            if(!file_exists("../../icon/fertilizer/$id")){
                mkdir("../../icon/fertilizer/$id");
        }   
            $path = "../../icon/fertilizer/$id";
            // mkdir($path);
            file_put_contents("../../icon/fertilizer/$id/$Icon",$dataI);

            $path = "icon/fertilizer/$id";
            $dataIcon = ['Path' =>  $path,'DIMIconID'=>$DIMID,'FileName' => $Icon];
            insertLogIcon($dataIcon);
        }
        
        break;
    case 'selectCondition':
        $id = $_POST['id'];
        $sql = "SELECT * FROM `db-fercondition` WHERE `FID` = $id";
        
        print_r(json_encode(select($sql)));
        break;
    case 'delete': //--------------------------case delete ------------------------------
        $FID = $_POST['id'];
        $DIMID = $_POST['dimid'];
        updateLog($DIMID);
        updateLogCon($DIMID);
        updateLogIcon($DIMID);
        $sql = "DELETE FROM `db-fercondition` WHERE `FID` = $FID";
        delete($sql);
        $sql = "DELETE FROM `db-fertilizer` WHERE `FID` = $FID";
        $result = delete($sql);
        print_r($_POST);
        break;
}
function insertLog($data){
    $FID = $data['FID'];
    $Name = $data['Name'];
    $Alias = $data['Alias'];
    $StartT = time();
    $StartDD = $data['StartDD'];
    $StartMM = $data['StartMM'];
    $EndDD = $data['EndDD'];
    $EndMM = $data['EndMM'];
    $Usage = $data['Usage'];
    $EQ1 = $data['EQ1'];
    $EQ2 = $data['EQ2'];
    $Unit = $data['Unit'];
    $DIMfertID = '';
    $LOGloginID = $_SESSION[md5('LOG_LOGIN')][1]['ID'];
    $StartID = getDIMDate()[1]['ID'];
    // if(sizeof($dataIcon)>0){
    //     $dataIcon['StartT'] = $StartT;
    //     $dataIcon['LOGloginID'] = 5;
    //     $dataIcon['StartID'] = $StartID; 
    // }
   
    $sql = "SELECT * FROM `dim-fertilizer` WHERE `dbID` = $FID  AND `Name` = '$Name' AND`Alias` = '$Alias'";
    // $DIMfertID = selectData($sql)[1]['ID'];
    // echo"---". $DIMfertID;
    $checkDIM = selectData($sql);
    if($checkDIM[0]['numrow']>0){
        $DIMfertID = $checkDIM[1]['ID'];
    }else{
        // echo"---". "elsessssss";
    $sqlDIM_Fertilizer = "INSERT INTO `dim-fertilizer` (`dbID`,`Name`,`Alias`) VALUE ($FID,'$Name','$Alias')";
    $DIMfertID = addinsertData($sqlDIM_Fertilizer);
    // echo"---". "insertDIM";
    // echo"---". $sqlDIM_Fertilizer;
    }

    $sqlLog_Fertilizer = "INSERT INTO `log-fertilizer` (`LOGloginID`,`StartT`,`StartID`,`DIMfertID`,`StartDD`,`StartMM`,`EndDD`
    ,`EndMM`,`Usage`,`EQ1`,`EQ2`) 
    VALUES ($LOGloginID,$StartT,$StartID,$DIMfertID,$StartDD,$StartMM,$EndDD,$EndMM,$Usage,$EQ1,$EQ2);";
    // echo"---". "insert       $DIMfertID";
    addinsertData($sqlLog_Fertilizer);
    // echo"---". "insertdata";
    return $DIMfertID;
}
function insertLogIcon($data){
    $LOGloginID = $_SESSION[md5('LOG_LOGIN')][1]['ID'];
    $StartT = time();
    $StartID = getDIMDate()[1]['ID'];
    $DIMIconID = $data['DIMIconID'];
    $Type = 2;
    $FileName = $data['FileName'];
    $Path = $data['Path'];
    $sql = "INSERT INTO `log-icon` (`LOGloginID`,`StartT`,`StartID`,`DIMIconID`,`Type`,`FileName`,`Path`)
    VALUES ($LOGloginID,$StartT,$StartID,$DIMIconID,2,'$FileName','$Path');";
    // echo"---". $sql;
    addinsertData($sql);
    //  $sql;
    // echo"---". "insertLogIcon";
}

function updateLogIcon($ID){
    $EndID = getDIMDate()[1]['ID'];
    $t = time();
    $sql = "UPDATE `log-icon` 
    SET `EndT`= $t ,`EndID` = $EndID
    WHERE `DIMIconID` = $ID AND `EndID` IS NULL;";
    updateData($sql);
    // echo"---". "updateLogIcon";
}
function insertLogCon($item,$id,$Order){
    $StartID = getDIMDate()[1]['ID'];
    // $StartID = 1;
    $LOGloginID = $_SESSION[md5('LOG_LOGIN')][1]['ID'];
    $t = time();
    $sqlLog_FerCondition = "INSERT INTO `log-fercondition` (`LOGloginID`,`StartT`,`StartID`,`DIMfertID`,`Order`,`Condition`)
    VALUES ($LOGloginID,$t,$StartID,$id,$Order,'$item');";
    // addinsertData($sqlLog_FerCondition);
   addinsertData($sqlLog_FerCondition);
    // echo"---". "insertLogCon";
}

function updateLog($ID){
    $EndID = getDIMDate()[1]['ID'];
    $t = time();
    $sql = "UPDATE `log-fertilizer` 
    SET `EndT`= $t ,`EndID` = $EndID
    WHERE `DIMfertID` = $ID AND `EndID` IS NULL;";
    updateData($sql);
    // echo"---". "updateLog";
}
function updateLogCon($ID){
    $EndID = getDIMDate()[1]['ID'];
    $t = time();
    $sql = "UPDATE `log-fercondition` 
    SET `EndT`= $t ,`EndID` = $EndID
    WHERE `DIMfertID` = $ID AND `EndID` IS NULL;";
    updateData($sql);
    // echo"---". "updateLogCon";

}
?>