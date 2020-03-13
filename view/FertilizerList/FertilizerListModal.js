let equation = ``;
let equation2= ``;
let equation3= ``;



let editModal = `<div class="edit-modal" >
                            <div class="modal fade" id="edit-Modal" tabindex="-1" role="dialog">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header header-modal" id="header-card">
                                        <h4 class="modal-title" id="largeModalLabel">แก้ไขปุ๋ย</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">                                                
                                                <center>
                                                    <img src="../../picture/ปูนขาว.jpg" id="pic-Fertilizer" class="w-100" style="border-radius: 50%"; ">
                                                    <br>
                                                    <br>
                                                    <button type="button" class="btn btn-warning mb-4" id="edit-pic">
                                                        Edit
                                                    </button>
                                                </center>
                                            </div>
                                        
                                            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12"> 
                                                <div class='row'>
                                                    <div class='col-lg-1 col-md-1 col-sm-1 col-xs-1 form-control-label'>
                                                                <label>ชื่อ</label>
                                                    </div>
                                                    <div class='col-lg-8 col-md-8 col-sm-8 col-xs-8'>
                                                        <div class='form-group'>
                                                            <div class='form-line'>
                                                                <input type='text' id='user-email' name='user-email' class='form-control' placeholder='' onchange="checkUemail();" >
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <label>เงื่อนไขการใส่</label>
                                                <div class='row'>
                                                    <div class='col-lg-1 col-md-1 col-sm-1 col-xs-1 form-control-label'>
                                                                
                                                    </div>
                                                    <div class='col-lg-8 col-md-8 col-sm-8 col-xs-8'>
                                                        <label>1. ปริมาณที่ใส่ตาม</label>
                                                    </div>
                                                </div>
                                                <div class='row'>
                                                    <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2 form-control-label'>
                                                                
                                                    </div>
                                                    <div class='col-lg-8 col-md-8 col-sm-12 col-xs-12'>
                                                        <input type="radio" name="gender" value="male"> จำนวนต้นและอายุ<br>

                                                    </div>
                                                </div>
                                                <div class='row'>
                                                    <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2 form-control-label'>
                                                                
                                                    </div>
                                                    <div class='col-lg-8 col-md-8 col-sm-12 col-xs-12'>
                                                        <input type="radio" name="gender" value="male"> จำนวนต้นและผลผลิต<br>

                                                    </div>
                                                </div>
                                                <div class='row'>
                                                    <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2 form-control-label'>
                                                                
                                                    </div>
                                                    <div class='col-lg-8 col-md-8 col-sm-12 col-xs-12'>
                                                        <input type="radio" name="gender" value="male"> จำนวนต้น<br>

                                                    </div>
                                                </div>
                                                <div class='row'>
                                                    <div class='col-lg-1 col-md-1 col-sm-1 col-xs-1 form-control-label'>
                                                                
                                                    </div>
                                                    <div class='col-lg-8 col-md-8 col-sm-8 col-xs-8'>
                                                        <label>2. ช่วงเดือนที่ใส่</label>
                                                    </div>
                                                </div>
                                                <div class='row'>
                                                    <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2 form-control-label'>
                                                                
                                                    </div>
                                                    <div class='col-lg-8 col-md-8 col-sm-12 col-xs-12'>
                                                        <input type="radio" name="gender" value="male"> ทั้งปี<br>

                                                    </div>
                                                </div>
                                                <div class='row'>
                                                    <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2 form-control-label'>
                                                                
                                                    </div>
                                                    <div class='col-lg-3 col-md-3 col-sm-12 col-xs-12'>
                                                        <input type="radio" name="gender" value="male"> ตั้งแต่เดือน<br>

                                                    </div>
                                                    <div class='col-lg-2 col-md-2 col-sm-12 col-xs-12'>
                                                        <div class='form-group'>
                                                            <div class='form-line'>
                                                                <input type='text' id='user-email' name='user-email' class='form-control' placeholder='' onchange="" >
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class='col-lg-1 col-md-1 col-sm-1 col-xs-1'>
                                                        ถึง
                                                    </div>
                                                    <div class='col-lg-2 col-md-2 col-sm-12 col-xs-12'>
                                                        <div class='form-group'>
                                                            <div class='form-line'>
                                                                <input type='text' id='user-email' name='user-email' class='form-control' placeholder='' onchange="" >
                                                            </div>
                                                        </div>
                                                    </div>


                                                </div>

                                                <div class='row'>
                                                    <div class='col-lg-1 col-md-1 col-sm-1 col-xs-1 form-control-label'>
                                                                
                                                    </div>
                                                    <div class='col-lg-8 col-md-8 col-sm-8 col-xs-8'>
                                                        <label>3. ข้อห้าม/คำเตือน</label>
                                                        <button type="button" class="btn btn-success btn-sm" id="add-interdict">
                                                            เพิ่ม
                                                        </button>
                                                       
                                                    </div>
                                                </div>
                                                <div class='row'>
                                                    <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2 form-control-label'>
                                                                
                                                    </div> 
                                                    <div class='col-lg-8 col-md-8 col-sm-12 col-xs-12 interdict' >
                                                        <input type='text' id='user-email' name='user-email' class='form-control' placeholder='' onchange="" >
                                                    </div>
                                                </div>

                                                <label>ปริมาณปุ๋ยที่ต้องใส่</label>
                                                <div class='row'>
                                                    <div class='col-lg-1 col-md-1 col-sm-1 col-xs-1 form-control-label'>
                                                                
                                                    </div>
                                                    <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2 '>
                                                        หน่วย :
                                                    </div>
                                                    <div class='col-lg-8 col-md-8 col-sm-8 col-xs-8'>
                                                        <div class="form-check form-check-inline">
                                                            <input type="radio" class="form-check-input" id="exampleCheck1" checked disabled> 
                                                            <label class="form-check-label" for="exampleCheck1">ผู้ดูแลระบบ</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input type="radio" class="form-check-input" id="exampleCheck1" disabled>
                                                            <label class="form-check-label" for="exampleCheck1">นักวิจัย</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class='row'>
                                                    <div class='col-lg-1 col-md-1 col-sm-1 col-xs-1 form-control-label'>
                                                                
                                                    </div>
                                                    <div class='col-lg-3 col-md-3 col-sm-3 col-xs-3 '>
                                                        ปริมาณที่ต้องใส่
                                                    </div>
                                                    <div class='col-lg-1 col-md-1 col-sm-1 col-xs-1'>
                                                        y= 
                                                    </div>
                                                    <div class="equation">
                                                        <div class='col-lg-4 col-md-4 col-sm-4 col-xs-4'>
                                                            <div class='form-group'>
                                                                <div class='form-line'>
                                                                    <input type='text' id='user-email' name='user-email' class='form-control' placeholder='' onchange="" >
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class='row'>
                                                <div class='col-lg-1 col-md-1 col-sm-1 col-xs-1 form-control-label'>
                                                            
                                                </div>
                                                <div class='col-lg-3 col-md-3 col-sm-3 col-xs-3 '>
                                                    
                                                </div>
                                                <div class='col-lg-1 col-md-1 col-sm-1 col-xs-1'>
                                                    y= 
                                                </div>
                                                <div class='col-lg-3 col-md-3 col-sm-3 col-xs-3'>
                                                    <div class='form-group'>
                                                        <div class='form-line'>
                                                            <input type='text' id='user-email' name='user-email' class='form-control' placeholder='' onchange="" >
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'>
                                                    * อายุ + 
                                                </div>
                                                <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'>
                                                    <div class='form-group'>
                                                        <div class='form-line'>
                                                            <input type='text' id='user-email' name='user-email' class='form-control' placeholder='' onchange="" >
                                                            
                                                        </div>
                                                    </div>
                                                </div>

                                              
                                               

                                            </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-success">ยืนยัน</button>
                                        <button type="button" class="btn btn-danger " data-dismiss="modal">ปิด</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <div>`;  

let addModal = `
<div class="modal fade" id="addModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header header-modal">
                <h4 class="modal-title" id="largeModalLabel" style="color:white">เพิ่มปุ๋ย</h4>
            </div>
            <div class="modal-body">
                <div class='row clearfix'>
                    <div class='col-lg-3 col-md-3 col-sm-3 col-xs-6 form-control-label text-right'>
                        <label>ชื่อปุ๋ย<span class="text-danger"> *</span></label>
                    </div>
                    <div class='col-lg-8 col-md-8 col-sm-9 col-xs-6'>
                        <div class='form-group'>
                            <div class='form-line'>
                                <input type='text' id='name' name='tilename' class='form-control'  >
                            </div>
                        </div>
                    </div>
                </div>

               

                

                <form action="./DBfiles/dbUploadImageInsect.php" method="post" enctype="multipart/form-data">

                    <div class='row clearfix'>
                        <div class='col-lg-3 col-md-3 col-sm-3 col-xs-6 form-control-label text-right'>
                            <label>รูปปุ๋ย<span class="text-danger"> *</span></label>
                        </div>
                        <div class='col-lg-8 col-md-8 col-sm-9 col-xs-6'>
                            <div class='form-group'>
                                
                                <input type="file" id="pic-logo" name="pic-logo" >
                                
                            </div>
                        </div>
                    </div>

                   

                 
                    <input type="hidden" id="hidden_id" name="hidden_id" />
                    <input type="hidden" id="hidden_type" name="hidden_type" value="insect" />
                    <button type="submit" class="btn btn-success waves-effect" id="btn_submit" style="display:none;">ADD</button>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success waves-effect" id="add-data">ยืนยัน</button>
                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">ยกเลิก</button>
            </div>
        </div>
    </div>
</div>
`;

                    
                    
           