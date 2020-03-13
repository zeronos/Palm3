<div class="edit-modal" >
    <div class="modal fade mb-6" id="edit" tabindex="-1" tabindex="-1" role="dialog" aria-labelledby="smallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg2" role="document">
        <div class="modal-content">
        <!-- -----------------header------------------------------ -->
            <div class="modal-header header-modal" id="header-card"> 
                <h4 class="modal-title" id="largeModalLabel">แก้ไขปุ๋ย</h4>
            </div>
            <!-- start body ------------------------------------- -->
            <div class="modal-body">
            <!-- start grid body-------------------------------- -->
                <form class="modal-update" action="#" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="request" value="update" >
                    <input type="hidden" name="id" value="" >
                    <!-- grid name alias icon -------------------------------------- -->
                    <div class="divCU ">
                    <center>
                                        <!-- <input id='pic-logo' type='file' class='item-img file center-block' name='icon_insert' /> -->
                                        <!-- <img id="img-insert" src="https://via.placeholder.com/200x200.png" alt="" width="200" height="200"> -->
                                        <div id="upload-demo2" class="center-block"></div>
                                    </center>
                    </div>
                    <div class="divU grid-body-modal ">
                        <div  class="grid-icon-name"> 
                                    <label >ขื่อปุ๋ย<span class="ml-2"> *</span></label>
                                    <input type="text"  class="form-control col-8"id="nameF" name="name"  required=""
                                    oninput="setCustomValidity(' ')">
                                    <label  ">ขื่อย่อปุ๋ย<span class="ml-2"> *</span></label>
                                    <input type="text"  class="form-control col-8"id="aliasF" name="alias"  required=""
                                    oninput="setCustomValidity(' ')">
                                    <label for="iconF" >ไอคอน</label>
                                        <!-- <img id="icon" style="width : 100px;height : 150;"  src="" alt=""> -->
                                        <!-- <input  onchange="changeIcon(this);" type="file" accept=".jpg,.png"  id="iconF" name="icon" > -->
                                    <div class="upload-btn-wrapper">
                                        <!-- <button class="btn btn-warning">แก้ไขไอคอน</button> -->
                                        <img id="img-update" src="https://imbindonesia.com/images/placeholder/camera.jpg" alt="" width="200" height="200">
                                        <input  type="file" accept=".jpg,.png"  id="iconF" name="icon" />
                                    </div>
                        </div>
                        <!-- end grid name alias icon------------------------------------- -->
                        <!-- start usage             ------------------------------------- -->
                        <div class="grid-form-condition">
                            <!-- <div class="form-group" id="parm-age">
                                <label for="nameF">ปริมาณที่ใส่ตาม</label>
                                <div class="form-check ml-5" >
                                    <input class="form-check-input" type="radio" name="exampleRadios1" id="exampleRadios1" value="1">
                                    <label class="form-check-label" for="exampleRadios1">
                                        จำนวนต้นและอายุ
                                    </label>
                                </div>
                                <div class="form-check ml-5">
                                    <input class="form-check-input" type="radio" name="exampleRadios1" id="exampleRadios2" value="2">
                                    <label class="form-check-label" for="exampleRadios2">
                                        จำนวนต้นและผลผลิต
                                    </label>
                                </div>
                                <div class="form-check ml-5">
                                    <input class="form-check-input" type="radio" name="exampleRadios1" id="exampleRadios3" value="3" >
                                    <label class="form-check-label" for="exampleRadios3">
                                        จำนวนต้น
                                    </label>
                                </div>
                            </div> -->
                        
                            <!-- <div class="form-group" id="unit">
                                <label for="nameF">หน่วย</label>
                                <div class="form-check ml-5">
                                    <input class="form-check-input " type="radio" name="exampleRadios3" id="exampleRadios6" value="1" checked>
                                    <label class="form-check-label" for="exampleRadios6">
                                        กิโลกรัม/ต้น/ปี
                                    </label>
                                    </div>
                                <div class="form-check ml-5">
                                        <input class="form-check-input" type="radio" name="exampleRadios3" id="exampleRadios7" value="2">
                                        <label class="form-check-label" for="exampleRadios7">
                                        กิโลกรัม/ไร่/ปี
                                        </label>
                                </div>
                            </div> -->
                            <div class="form-group">
                                <label for="">ปริมาณที่ต้องใส่</label>
                                <div class="form-inline graph ml-5" >
                                    <div class="form-inline a"  >
                                        <label  for="" style="margin-right:10px;">a</label>
                                        <input type="text" class="form-control" style="width:100px; margin-right:10px;" name="a" id="" 
                                        required=""  min='0'  oninput="setCustomValidity('')">
                                    </div>
                                    <div class="form-inline b">
                                        <label for="" style="margin-right:10px;">b</label>
                                        <input type="text" class="form-control" style="width:100px;" name="b" id=""
                                        required=""  min='0'   oninput="setCustomValidity('')">
                                    </div>
                                </div>
                            
                            <small class = "validAB" style="color:red;"></small>
                                </div>
                                <div class="form-group" id="year-mount">
                                    <label for="nameF">ช่วงเดือนที่ใส่</label>
                                    <div class="form-check   ml-5">
                                        <input class="form-check-input" type="radio" name="exampleRadios2" id="exampleRadios4" value="1" >
                                        <label class="form-check-label" for="exampleRadios4">
                                            ทั้งปี
                                        </label>
                                    </div>
                                    <div class="form-check   ml-5">
                                        <input class="form-check-input" type="radio" name="exampleRadios2" id="exampleRadios5" value="2">
                                        <label class="form-check-label" for="exampleRadios5">
                                            ตั้งแต่เดือน
                                        </label>
                                        <div class="form-inline" id="add-mount-year" style="">
                                            
                                        </div>
                                    <!-- <small class = "validMountYear" style="color:red;">าันที่เริ่มต้องน้อยกว่า วันที่สิ้นสุดสุด</small> -->
            
                                    </div>
                                </div>
                            

                        </div>
                        <!-- end grid usage------------------------------------------------------ -->
                        <!-- start grid condition------------------------------------------------------ -->
                        <div class="grid-volume">
                            <div class="form-group">
                                <label for="">ข้อห้าม/คำเตือน</label>
                                <div class="form-inline" id="addCondition">
                            
                            </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- end grid comdition------------------------------------------------------ -->
                </div>
                <!-- end body----------------------------------------------------------- -->
                    

            <div class="modal-footer">
                <div class="divBU">
                     <button type="button"  class="btn btn-success editSubmit"  style="margin-left:15px;">ยืนยัน</button>
                <button type="button" class="btn btn-danger " data-dismiss="modal">ยกเลิก</button>               
                </div>
                <div class="divBCU">
                <button type="button" id="cropImageBtn2"  class="btn btn-primary">ยืนยัน</button>
                        <button type="button" class="btn btn-default" id="cancelCrop2">ยกเลิก</button>
                </div>
                
            </div>
            </form>
             <!--end grid body --------------------------------------------------------  -->
            </div>
           
        </div>
        <!-- end content----------------------------------------------- -->

    </div>
    <!-- end modal dialog---------------------------------------------- -->
    </div>
    <!-- end modal fade---------------------------------------------- -->
 </div>
 <!-- end modal ---------------------------------------------- -->