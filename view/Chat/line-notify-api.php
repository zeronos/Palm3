

<?php 
    session_start();
    include_once("../../dbConnect.php");
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
    <div class="row">
		<div class="col-xl-12 col-12 mb-4">
            <div class="card">
                <div class="card-header card-bg">
                    <div class="row">
                        <div class="col-12">
                            <span class="link-active">สนทนา</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<!--  -->
		<div class="row mt-4">
			<div class="col-xl-12 col-12">
				<div class="card">
					<div class="card-header card-bg">
						<div>
							<span>ส่งสนทนากับระบบ</span>
						</div>
					</div>
					<div class="card-body" style="overflow-x:scroll;">
					<form name="line-notify" action="line.php" method="post">
						<div class="row mb-4">
                            <div class="col-xl-3 col-12 text-right">
                                <span>ชื่อสวนปาล์ม</span>
                            </div>
                            <div class="col-xl-9 col-12">
								<select class="form-control" id="nameframe" name="nameframe">
									<option selected="" disabled="">เลือกเจ้าของสวน</option>
										<option value="FARM1">FARM1</option>
										<option value="FARM2">FARM2</option>
										<option value="FARM3">FARM3</option>
                                </select>
							</div>
							<div></div>
							<div class="col-xl-3 col-12 text-right">
                                <span>เลือกหัวข้อการแจ้งเตื่อน</span>
                            </div>
                            <div class="col-xl-9 col-12">
								<label class="radio-inline">
									<input type="radio" name="optradio" value="แจ้งเตื่อน"  checked>การแจ้งเตื่อน
								</label>
								<label class="radio-inline">
									<input type="radio" name="optradio" value="แจ้งให้ทราบ" >แจ้งให้ทราบ
								</label>
							</div>
								<div class="col-xl-3 col-12 text-right">
									<span>เนื้อหาการแจ้งเตื่อน</span>
								</div>
								<div class="col-xl-9 col-12" >
									
									<label class="radio-inline">
										<input type="radio" name="optradio2" value="สวนขาดน้ำ"  onclick="hiddenn('0')"checked>สวนขาดน้ำ
									</label>
									<label class="radio-inline">
										<input type="radio" name="optradio2" value="สวนขาดน้ำ" onclick="hiddenn('0')" >ฝนไม่ตกมาหลายวัน
									</label>
									<label class="radio-inline">
										<input type="radio" name="optradio2" value="มีแมลง" onclick="hiddenn('0')" >มีแมลง
									</label>
									<label class="radio-inline">
									<input type="radio" name="optradio2" value="other"  onclick="hiddenn('1')" /> อื่นๆ
									</label>
									<div class="col-xl-9 col-12">
                                		<input class="form-control" type="text" name="other" id="txt1" /> 
                           			</div>
								</div>		
						</div>
						<div class="modal-footer">
							<button class="btn btn-success btn-md" style="float:right;" type="submit">ยืนยัน</button>
							<button type="button" class="btn btn-danger" data-dismiss="modal">ยกเลิก</button>
                    	</div>
					</form>
					</div>
				</div>
			</div>
		</div>
		<!--  -->
    </div>
</div>


<?php include_once("../layout/LayoutFooter.php"); ?>

<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> -->
<script>
function hiddenn(pvar) {
	 if(pvar==0){
		document.getElementById("txt1").style.display = 'none';
	 }else{
	 document.getElementById("txt1").style.display = '';
	 }
	 
}
</script>