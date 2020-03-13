
$( document ).ready(function() {
    let dataU;
    $('.tt').tooltip();
    
    pullData();

    // $("#block").hover(function() {
    //     for(i in dataU){
    //         // console.log(dataU[i].Title);
    //         // console.log(title.val());
    //         if(dataU[i].IsBlock == 1){
    //             $(this).attr('title', 'กดเพื่อปลดบล็อค');
    //         }
    //         else{
    //             $(this).attr('title', 'กดเพื่อบล็อค');
    //         }
    //     }
               
    // });

    $('#addUser').click(function(){
        $("#addModal").modal();    
            
    });
    $('#province').click(function(){

        var e = document.getElementById("province");
        var select_id = e.options[e.selectedIndex].value;
        data_show(select_id,"distrinct",'');
            

    });
    $('#distrinct').click(function(){

        var e = document.getElementById("distrinct");
        var select_id = e.options[e.selectedIndex].value;
        data_show(select_id,"subdistrinct",'');
            

    });
    $('#e_province').click(function(){
        // console.log("e_pro");
        var e = document.getElementById("e_province");
        var select_id = e.options[e.selectedIndex].value;

        data_show(select_id,"e_distrinct",'');
            

    });
    $('#e_distrinct').click(function(){

        var e = document.getElementById("e_distrinct");
        var select_id = e.options[e.selectedIndex].value;
        data_show(select_id,"e_subdistrinct",'');
            

    });
    // ------------------------------------------------------------
    $('#s_province').click(function(){

        var e = document.getElementById("s_province");
        var select_id = e.options[e.selectedIndex].value;
        // console.log(select_id);
        data_show(select_id,"s_distrinct",'');
            

    });
    // $('#s_distrinct').click(function(){

    //     var e = document.getElementById("s_distrinct");
    //     var select_id = e.options[e.selectedIndex].value;
    //     data_show(select_id,"s_subdistrinct",'');
            

    // });
    // -------------------------------------------------------------
    function data_show(select_id,result,point_id){
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
              if (this.readyState == 4 && this.status == 200) {
                // console.log(this.responseText);
                // console.log(result);
                document.getElementById(result).innerHTML = xhttp.responseText;         
                
            };
            }
            xhttp.open("POST", "data.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send(`select_id=${select_id}&result=${result}&point_id=${point_id}`);
    }

    function pullData(){
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
    

    $('.btn_edit').click(function(){
        $("#editModal").modal();
        var uid = $(this).attr('uid');
        var title = $(this).attr('titles');
        var fname = $(this).attr('fname');
        var lname = $(this).attr('lname');
        var formalid = $(this).attr('formalid');
        var address = $(this).attr('address');
        var province = $(this).attr('province');
        var distrinct = $(this).attr('distrinct');
        var subdistrinct = $(this).attr('subdistrinct');

        // var mail = $(this).attr('mail');
        // var type = $(this).attr('type_email');
        
        $('#e_uid').val(uid);
        $('#e_fname').val(fname);
        $('#e_lname').val(lname);
        $('#e_formalid').val(formalid);
        $('#e_address').val(address);

        console.log(subdistrinct);
        // console.log(title);

        
        // console.log(province);
        // console.log(distrinct);
        // console.log(subdistrinct);
        data_show(province,'e_province',province);
        data_show(province,'e_distrinct',distrinct);
        data_show(distrinct,'e_subdistrinct',subdistrinct);
        document.getElementById("e_title").value = title;
    });
    // ------------------------------------------ insert data ------------------------------------------
    $('#save').click(function(){
        let title = $("select[name = 'title']");
        let fname = $("input[name = 'fname']");
        let lname = $("input[name = 'lname']");
        let formalid = $("input[name = 'formalid']");
        let address = $("input[name = 'address']");
        let st = $("[name='status']:checked").val();
        // alert(st);
        $('#st').val(st);

        var e1 = document.getElementById("province");
        var prov = e1.options[e1.selectedIndex].text;
        var id_prov = e1.options[e1.selectedIndex].value;
        var e2 = document.getElementById("distrinct");
        var dist = e2.options[e2.selectedIndex].text;
        var id_dist = e2.options[e2.selectedIndex].value;
        var e3 = document.getElementById("subdistrinct");
        var subdist = e3.options[e3.selectedIndex].text;
        var id_subdist = e3.options[e3.selectedIndex].value;

        $('#prov').val(prov);
        $('#dist').val(dist);
        $('#subdist').val(subdist);   

        $('#id_prov').val(id_prov);
        $('#id_dist').val(id_dist);
        $('#id_subdist').val(id_subdist);    
 
        
        let data = [fname,lname,formalid,address];
        let data1 = [fname,lname,formalid];

        document.getElementById("save").setAttribute("type","submit");

        if(!check_blank(data)) return;
        if(!check_blank_in(data1)) return;
        if(!check_lan(fname,lname)) return;
        if(!check_name(fname,lname)) return;
        if(!check_formatformalid(formalid)) return;
        if(!check_formalid(formalid)) return;
        if(!check_long(formalid)) return;
        if(!check_addr(id_prov,id_dist,id_subdist)) return;

    })
    function check_addr(id_prov,id_dist,id_subdist){
        // console.log("address");
        // console.log(id_prov);
        if(id_prov == 0){
            $('#f_province').removeAttr('hidden');
            document.getElementById("save").setAttribute("type","button");
            return false;
        }
        else if(id_dist == 0){
            // alert("dist = 0");
            $('#f_province').attr('hidden',true);
            $('#f_distrinct').removeAttr('hidden');
            document.getElementById("save").setAttribute("type","button");
            return false;
        }
        else if(id_subdist == 0){
            // alert("subdist = 0");
            $('#f_distrinct').attr('hidden',true);
            $('#f_subdistrinct').removeAttr('hidden');
            document.getElementById("save").setAttribute("type","button");
            return false;
        }else{
            // alert("else");
            $('#f_subdistrinct').attr('hidden',true);
            document.getElementById("save").setAttribute("type","submit");

        }
        return true;
    }
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
            // console.log("  //-"+lname.val().trim+"-");
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
   
    function check_long(formalid){
        // console.log("check long");
        if(formalid.val().trim().length != 13){
            formalid[0].setCustomValidity('ความยาว 13 หลักเท่านั้น');
                return false;
        }else{
            formalid[0].setCustomValidity('');
        }
        return true;
    }
    function check_mail(mail){

        let email=/^[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)?$/i;
        if(!mail.val().trim().match(email)){
            mail[0].setCustomValidity('กรอกอีเมลล์ไม่ถูกต้อง');
            return false;
        }else{
            mail[0].setCustomValidity('');
        }
        return true;
    }
    function check_blank(selecter){
        for(i in selecter){
            // console.log(selecter[i].val());
            if(selecter[i].val().trim() == ''){
                //  console.log("if");
                selecter[i][0].setCustomValidity('กรุณากรอกข้อมูล');
                return false;
            }else{
                // console.log("else");
                selecter[i][0].setCustomValidity('');
            }            
        }
        return true;
    }
    function check_name(fname,lname){
        for(i in dataU){
            // console.log(dataU[i].Title);
            // console.log(title.val());
            if(fname.val().trim() == dataU[i].FirstName && lname.val().trim() == dataU[i].LastName){
                fname[0].setCustomValidity('ชื่อ-นามสกุลซ้ำ');
                return false;
            }
            else{
                fname[0].setCustomValidity('');
            }
        }
   
        return true;
    }
    function check_formatformalid(formalid){
        let en = /^([0-9])+$/;
        if(!formalid.val().trim().match(en)){
            // console.log("ต้องเป็นภาษาอังกฤษ หรือ ตัวเลขเท่านั้น");
            formalid[0].setCustomValidity('ต้องเป็นตัวเลขเท่านั้น');
                return false;
        }else{
            formalid[0].setCustomValidity('');
        }
        return true;
    }
    function check_formalid(formalid){
        for(i in dataU){
            if(formalid.val().trim() == dataU[i].FormalID){
                formalid[0].setCustomValidity('หมายเลขประจำตัวประชาชนซ้ำ');
                return false;
            }
            else{
                formalid[0].setCustomValidity('');
            }
        }
   
        return true;
    }
    // ------------------------------------------ edit data ------------------------------------------
    $('#edit').click(function(){
        let uid = $("input[name = 'e_uid']");
        let fname= $("input[name = 'e_fname']");
        let lname = $("input[name = 'e_lname']");
        let formalid = $("input[name = 'e_formalid']");
        let address = $("input[name = 'e_address']");
        // let st = $("[name='e_status']:checked").val();
        // alert(st);
        // $('#e_st').val(st);
        var e = document.getElementById("e_province");
        var prov = e.options[e.selectedIndex].text;
        var id_prov = e.options[e.selectedIndex].value;
        var e = document.getElementById("e_distrinct");
        var dist = e.options[e.selectedIndex].text;
        var id_dist = e.options[e.selectedIndex].value;
        var e = document.getElementById("e_subdistrinct");
        var subdist = e.options[e.selectedIndex].text;
        var id_subdist = e.options[e.selectedIndex].value;

        $('#e_prov').val(prov);
        $('#e_dist').val(dist);
        $('#e_subdist').val(subdist);   

        $('#e_id_prov').val(id_prov);
        $('#e_id_dist').val(id_dist);
        $('#e_id_subdist').val(id_subdist);    
 
        
        let data = [fname,lname,formalid,address];
        let data1 = [fname,lname,formalid];
        // if(!check_checkbox()) return;
        document.getElementById("edit").setAttribute("type","submit");
        if(!check_editaddr(id_prov,id_dist,id_subdist)) return;

        if(!check_blank(data)) return;
        if(!check_blank_in(data1)) return;
        if(!check_lan(fname,lname)) return;
        if(!check_editName(fname,lname,uid)) return;
        if(!check_formalid(formalid)) return;
        if(!check_long(formalid)) return;
        
    })
    function check_editaddr(id_prov,id_dist,id_subdist){
        // console.log("address");
        // console.log(id_prov);
        if(id_prov == 0){
            $('#fe_province').removeAttr('hidden');
            document.getElementById("edit").setAttribute("type","button");
            return false;
        }
        else if(id_dist == 0){
            $('#fe_province').attr('hidden',true);
            $('#fe_distrinct').removeAttr('hidden');
            document.getElementById("edit").setAttribute("type","button");
            return false;
        }
        else if(id_subdist == 0){
            $('#fe_distrinct').attr('hidden',true);
            $('#fe_subdistrinct').removeAttr('hidden');
            document.getElementById("edit").setAttribute("type","button");
            return false;
        }else{
            $('#fe_subdistrinct').attr('hidden',true);
            document.getElementById("edit").setAttribute("type","submit");

        }
        return true;
    }
    function check_editName(fname,lname,uid){
        for(i in dataU){
            if(fname.val().trim() == dataU[i].FirstName && lname.val().trim() == dataU[i].LastName && dataU[i].UFID != uid.val()){
                fname[0].setCustomValidity('ชื่อ-นามสกุลซ้ำ');
                return false;
            }
            else{
                fname[0].setCustomValidity('');
            }
        }
   
        return true;
    }

    
   
});

    // ------------------------------------------ unblock ------------------------------------------
function unblock(_fname,_lname,_ufid) {

    swal({
            title: "คุณต้องการปลดบล็อค",
            text: `${_fname} ${_lname} หรือไม่ ?`,
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            cancelButtonClass: "btn-secondary",
            confirmButtonText: "ยืนยัน",
            cancelButtonText: "ยกเลิก",
            closeOnConfirm: false,
            closeOnCancel: function() {
                $('[data-toggle=tooltip]').tooltip({
                    boundary: 'window',
                    trigger: 'hover'
                });
                return true;
            }
        },
        function(isConfirm) {
            if (isConfirm) {
                unblock_1(_ufid)
                set_unblock(_ufid)
            } else {
    
            }
        });
    
    }
    function unblock_1(_ufid) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            window.location.href = 'FarmerListAdmin.php';
            // alert(this.responseText);
        }
    };
    xhttp.open("POST", "manage.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(`uid=${_ufid}&request=block&val=0`);
    
    }
    function set_unblock(_uid){
        // $(_uid).attr("class","btn btn-success btn-sm")
        document.getElementById(_uid).style.backgroundColor = "red";
    }
    // ------------------------------------------ block ------------------------------------------
function block(_fname,_lname,_ufid) {

    swal({
            title: "คุณต้องการบล็อค",
            text: `${_fname} ${_lname} หรือไม่ ?`,
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            cancelButtonClass: "btn-secondary",
            confirmButtonText: "ยืนยัน",
            cancelButtonText: "ยกเลิก",
            closeOnConfirm: false,
            closeOnCancel: function() {
                $('[data-toggle=tooltip]').tooltip({
                    boundary: 'window',
                    trigger: 'hover'
                });
                return true;
            }
        },
        function(isConfirm) {
            if (isConfirm) {
                block_1(_ufid)
                set_block(_ufid)
            } else {
    
            }
        });
    
    }
    function block_1(_ufid) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            window.location.href = 'FarmerListAdmin.php';
            // alert(this.responseText);
        }
    };
    xhttp.open("POST", "manage.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(`uid=${_ufid}&request=block&val=1`);
    
    }
    function set_block(_ufid){
        // $(_uid).attr("class","btn btn-danger btn-sm")
        document.getElementById(_ufid).style.backgroundColor = "red";
    }
    // ------------------------------------------ delete data ------------------------------------------
function delfunction(_fname,_lname,_ufid) {

    swal({
            title: "คุณต้องการลบ",
            text: `${_fname} ${_lname} หรือไม่ ?`,
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            cancelButtonClass: "btn-secondary",
            confirmButtonText: "ยืนยัน",
            cancelButtonText: "ยกเลิก",
            closeOnConfirm: false,
            closeOnCancel: function() {
                $('[data-toggle=tooltip]').tooltip({
                    boundary: 'window',
                    trigger: 'hover'
                });
                return true;
            }
        },
        function(isConfirm) {
            if (isConfirm) {
    
                swal({
    
                    title: "ลบข้อมูลสำเร็จ",
                    type: "success",
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "ตกลง",
                    closeOnConfirm: false,
    
                }, function(isConfirm) {
                    if (isConfirm) {
                        delete_1(_ufid)
                    }
    
                });
            } else {
    
            }
        });
    
    }
    function delete_1(_ufid) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            window.location.href = 'FarmerListAdmin.php';
            // alert(this.responseText);
        }
    };
    xhttp.open("POST", "manage.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(`uid=${_ufid}&request=delete`);
    
    }