

<?php 
    session_start();
	include_once("../../dbConnect.php");
	require_once("../../set-log-login.php");
    $idUT = $_SESSION[md5('typeid')];
    $CurrentMenu = "Chat";
?>

<?php include_once("../layout/LayoutHeader.php"); ?>

<style>
	#card-detail{
		color:white;
    	background-color:#F44336;
	}
	#calendar{

	}
	/* input[type="checkbox"]{
		position: absolute;
		right: 9000px;
	} */
	input[type=checkbox]{
		background-color:#F44336;
		color:#F44336;
	}

</style>

<body onload="hiddenn('0')">
<div class="container" >
    <div>
		<div class="row">
			<div class="col-xl-12 col-12 mb-4">
				<div class="card">
					<div class="card-header card-bg">
						<div class="row">
							<div class="col-12">
								<span class="link-active font-weight-bold" style="color:<?=$color?>;">ระบบแจ้งเตือน</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--div class="row mt-4"-->
		<div class="row">
			<div class="col-xl-12 col-12">
				<div class="card">
					<div class="card-header card-bg">
						<div>
							<span class="link-active font-weight-bold" style="color:<?=$color?>;">ส่งแจ้งเตือนเข้ากลุ่ม</span>
						</div>
					</div>
					<div class="card-body card-bg" style="overflow-x:scroll;">
						<form name="line-notify" action="line.php" method="post">
							<div class="row mb-4">
								<div class="col-xl-3 col-12 text-right">
									<span>ชื่อสวนปาล์ม</span>
								</div>
								<div class="col-xl-9 col-12">
									<select class="form-control" id="nameframe" name="nameframe" required>
										<option selected="" disabled="" value="" >เลือกสวน</option>
										<?php
										$data = getAll();
										foreach ($data as $key => $val) {
											echo "<option value='".$data[$key]['Name']."'>".$data[$key]['Name']."</option>";
										 }
										?>
									</select>
								</div>
								<br>
								<div class="col-xl-3 col-12 text-right">
									<span>เลือกหัวข้อที่ต้องการส่ง</span>
								</div>
								<div class="col-xl-9 col-12">
									<label class="radio-inline">
										<input type="radio" name="optradio" value="แจ้งเตื่อน"  checked> แจ้งแตือน
									</label> &nbsp;&nbsp;&nbsp;&nbsp;
									<label class="radio-inline">
										<input type="radio" name="optradio" value="แจ้งให้ทราบ" > แจ้งให้ทราบ
									</label>
								</div>
									<div class="col-xl-3 col-12 text-right">
										<span>เนื้อหาการแจ้งเตื่อน</span>
									</div>
									<div class="col-xl-9 col-12" >
										<label class="radio-inline">
											<input type="radio" name="optradio2" value="สวนขาดน้ำ"  
												onclick="hiddenn('0')"checked> สวนขาดน้ำ
										</label> &nbsp;&nbsp;&nbsp;
										<label class="radio-inline">
											<input type="radio" name="optradio2" value="ฝนไม่ตกมาหลายวัน" 
												onclick="hiddenn('0')" > ฝนไม่ตกมาหลายวัน
										</label> &nbsp;&nbsp;&nbsp;
										<label class="radio-inline">
											<input type="radio" name="optradio2" value="มีศัตรูพืชในบริเวณข้างเคียง" 
												onclick="hiddenn('0')" > มีศัตรูพืชในบริเวณข้างเคียง
										</label> &nbsp;&nbsp;&nbsp;
										<label class="radio-inline">
											<input type="radio" name="optradio2" value="other"  
												onclick="hiddenn('1')" /> อื่นๆ
										</label>
									</div>	
									<div class="col-xl-3 col-12 text-right" >
										<span id="txt1">ข้อความ
									</div>
									<div class="col-xl-9 col-12" >
											<input class="form-control" type="text" name="other" id="txt2" /> 
									</div>	
							</div>
							<div class="modal-footer">
								<button class="btn btn-success btn-md" style="float:right;" type="submit" >ส่งข้อความ</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<!--  -->
    </div>
</div>
</body>
<?php include_once("../layout/LayoutFooter.php"); ?>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> -->
<script>
function hiddenn(pvar) {
	 if(pvar==0){
		document.getElementById("txt1").style.display = 'none ' ; 
		document.getElementById("txt2").style.display = 'none ' required; 
	 }else{
	 document.getElementById("txt1").style.display = '';
	 document.getElementById("txt2").style.display = '';
	 }
	 
}

<?php
    function getAll(){
        $sql = "SELECT DISTINCT `dim-farm`.`Name`,`dim-user`.`FullName` FROM `log-farm` INNER JOIN `dim-farm`ON `dim-farm`.`ID` = `log-farm`.`DIMfarmID` INNER JOIN `dim-user` ON `dim-user`.`ID` = `log-farm`.`DIMownerID` WHERE ISNULL(`log-farm`.`EndT`) AND ISNULL(`log-farm`.`EndID`)";
        $data = selectAll($sql);
        return $data;
    }
?>
</script>