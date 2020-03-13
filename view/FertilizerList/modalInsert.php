   <!-- modal add -->
   <div class="modal fade" id="insert" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content body-insert">
            <!-- header-------------------------------------------------- -->
                <div class="modal-header header-modal"> 
                    <h4 class="modal-title" id="largeModalLabel" style="color:white">เพิ่มปุ๋ย</h4>
                </div>
                <!-- start body----------------------------------------- -->
                <div class="modal-body ">
                    <!-- start form----------------------------------------- -->
                    <form action="#" method="post" enctype="multipart/form-data" id="form-insert" >
                       <!-- .insert-collap -->
                       <div class="divName" >
                            <div class="form-group">
                                <div class="form-inline">
                                    <label for="" class="col-4">ชื่อปุ๋ย <span class="ml-2"> *</span></label>
                                    <input   id='name' name='name_insert' 
                                        class='form-control col-8'  required=""
                                    oninput="setCustomValidity(' ')" placeholder="ใส่ชื่อปุ๋ย">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-inline">
                                    <label for="" class="col-4">ชื่ย่อปุ๋ย <span class="ml-2"> *</span></label>
                                    <input type='text' id='alias' name='alias_insert' 
                                        class='form-control col-8'   required=""
                                        oninput="setCustomValidity(' ')" Placeholder="ใส่ชื่อย่อ">
                                </div>
                            </div>
                        </div> 
                        <div class="form-group divHolder">
                                <div class="form-inline">
                                    <label for="" class="col-4">ชื่อปุ๋ย</label>
                                    <div class="UI">
                                        <input id='pic-logo' type='file' class='item-img file center-block'  accept=".jpg,.png" name='icon_insert' />
                                        <img id="img-insert" src="https://imbindonesia.com/images/placeholder/camera.jpg" alt="" width="200" height="200">
                                        <!-- <div id="upload-demo" class="center-block"></div> -->
                                    </div>
                                </div>
                        </div>
                        <div class="form-group divCrop">
                                <!-- <div class="form-inline"> -->
                                    <!-- <label for="" class="col-4"></label> -->
                                    <center>
                                        <!-- <input id='pic-logo' type='file' class='item-img file center-block' name='icon_insert' /> -->
                                        <!-- <img id="img-insert" src="https://via.placeholder.com/200x200.png" alt="" width="200" height="200"> -->
                                        <div id="upload-demo" class="center-block"></div>
                                    </center>
                                <!-- </div> -->
                        </div>
                        
                            <!-- <center>
                               
                            </center> -->
                            
                               
                            <!-- <div class="collapse cl" id="multiCollapseExample2">
                                <center><div id="upload-demo" class="center-block"></div></center>
                            </div> -->
                                                
                        
                           
                       <input type="hidden" id="imagebase64" name="imagebase64">
                      
                        <input type="hidden" id="hidden_id" name="request" value="insert" />
                </div>
                <!-- end  body---------------------------------------------- -->
                <div class="modal-footer footer-insert">
                    <div class="buttonSubmit" >
                        <button type="submit" class="btn btn-success waves-effect insertSubmit" id="add-data" >ยืนยัน</button>
                        <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal" >ยกเลิก</button>
                    </div>
                    <div class="buttonCrop" >
                                <!-- <div class="form-inline">
                                    <div  class="col-4"></div>
                                    <div class="col-6"> -->
                        <button type="button" id="cropImageBtn"  class="btn btn-primary">ยืนยัน</button>
                        <button type="button" class="btn btn-default" id="cancelCrop">ยกเลิก</button>
                                    <!-- </div>
                                </div> -->
                    </div>
                </div>
                    </form>
                    <!-- end form---------------------------------------- -->
            </div> 
            <!-- end content -->
        </div>
        <!-- end dialog -->
    </div>
    <!-- end fade -->

<!-- 

    <div class="modal fade" id="cropImagePop" tabindex="-1" role="dialog" >
    <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
               
            </div>
            <div class="modal-body">
                <div id="upload-demo" class="center-block"></div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" id="cropImageBtn" class="btn btn-primary">Crop</button>
            </div>
        </div>
    </div> -->