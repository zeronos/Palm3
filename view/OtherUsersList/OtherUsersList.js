//let modalAdd = 
$( document ).ready(function() {
    let dataU;
    let logP;
    let pwd_md5 = 5;
    let pwd_new_md5 = 5;

    $('.tt').tooltip();
    
    pullData();
    
    $('#addUser').click(function(){
        $("#addModal").modal();    
            
    });
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
    function pullLogPass(_uid){
        // console.log("logpass");
        var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
              if (this.readyState == 4 && this.status == 200) {
                logP = JSON.parse(this.responseText);
                //  alert(this.responseText);       
                //  alert(logP);        
                // console.log("pull");
            };
            }
            xhttp.open("POST", "manage.php", false);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send(`uid=${_uid}&request=logpass`);
    
    }
   
    

    $('.pass_edit').click(function(){
        $("#passModal").modal();
        var uid = $(this).attr('uid');
        var username = $(this).attr('username');
        var pass_old = $(this).attr('pass');

        var title = $(this).attr('titles');
        var fname = $(this).attr('fname');
        var lname = $(this).attr('lname');
        // console.log(title);
        // console.log(fname);
        // console.log(lname);


        $('#pass_uid').val(uid);
        $('#pass_username').val(username);
        $('#pass_old').val(pass_old);

        $('#p_title').val(title);
        $('#p_fname').val(fname);
        $('#p_lname').val(lname);

        // console.log(uid);
        // console.log(username);
       
        
    });

    $('#edit_cancel').click(function(){
        // console.log("fff");
        $('#old_pwd').val("");
        $('#e_pwd').val("");
        $('#e_pwd1').val("");

// ---------------------------------- set default old_pwd ---------------------------------- 
        $('#old_pwd').attr('type', 'password');
        $('#hide_1').removeClass( "fa-eye" );
        $('#hide_1').addClass( "fa-eye-slash" );
// ---------------------------------- set default e_pwd ---------------------------------- 
        $('#e_pwd').attr('type', 'password');
        $('#hide_2').removeClass( "fa-eye" );
        $('#hide_2').addClass( "fa-eye-slash" );
// ---------------------------------- set default e_pwd1 ---------------------------------- 
        $('#e_pwd1').attr('type', 'password');
        $('#hide_3').removeClass( "fa-eye" );
        $('#hide_3').addClass( "fa-eye-slash" );
       
        
    });

    $('.btn_edit').click(function(){
        $("#editModal").modal();
        var uid = $(this).attr('uid');
        
        // alert(uid);
        //set all false
        document.getElementById("e_admin").checked = false;
        document.getElementById("e_admin2").checked = false;
        document.getElementById("e_research").checked = false;
        document.getElementById("e_operator").checked = false;
        document.getElementById("e_farmer").checked = false;

        var title = $(this).attr('titles');
        var fname = $(this).attr('fname');
        var lname = $(this).attr('lname');
        var username = $(this).attr('username');
        var mail = $(this).attr('mail');
        var type = $(this).attr('type_email');
        var department = $(this).attr('department');
        var admin = $(this).attr('admin');
        var admin2 = $(this).attr('admin2');
        var research = $(this).attr('research');
        var operator = $(this).attr('operator');
        var farmer = $(this).attr('farmer');
        
        $('#uid').val(uid);
        $('#e_fname').val(fname);
        $('#e_lname').val(lname);
        $('#e_username').val(username);
        $('#e_username1').val(username);
        $('#e_mail').val(mail);

        // console.log(title);
        document.getElementById("e_title").value = title;
        document.getElementById("e_type").value = type;
        document.getElementById("e_department").value = department;
        if(admin == 1){
            // alert("admin");
            document.getElementById("e_admin").checked = true;
        }
        if(admin2 == 1){
            // alert("admin");
            document.getElementById("e_admin2").checked = true;
        }
        if(research == 1){
            document.getElementById("e_research").checked = true;
        }
        if(operator == 1){
            document.getElementById("e_operator").checked = true;
        }
        if(farmer == 1){
            document.getElementById("e_farmer").checked = true;
        }
    });
    // ------------------------------------------ insert data ------------------------------------------
    $('#save').click(function(){
        let title = $("select[name = 'title']");
        let fname = $("input[name = 'fname']");
        let lname = $("input[name = 'lname']");
        let username = $("input[name = 'username']");
        let pwd = $("input[name = 'pwd']");
        let pwd1 = $("input[name = 'pwd1']");
        let mail = $("input[name = 'mail']");
        let admin = $("input[name = 'admin']");
        let admin2 = $("input[name = 'admin2']");
        let research = $("input[name = 'research']");
        let operator = $("input[name = 'operator']");
        let farmer = $("input[name = 'farmer']");
        let error = $("input[name = 'error']");
        
        let data = [fname,lname,username,pwd,pwd1,mail];
        let data1 = [fname,lname,username,mail];
        // if(!check_checkbox()) return;
        document.getElementById("save").setAttribute("type","submit");

        if(!check_blank(data)) return;
        if(!check_blank_in(data1)) return;
        if(!check_lan(fname,lname)) return;
        if(!check_name(fname,lname)) return;
        if(!check_user(username)) return;
        if(!check_long(username)) return;
        if(!check_userName(username)) return;
        if(!check_long_pass(pwd)) return;
        if(!check_pass_format(pwd)) return;
        if(!check_pass(pwd,pwd1)) return;
        if(!check_mail(mail)) return;
        if(!check_checkbox(admin,admin2,research,operator,farmer,error)) return;
        
            
    })
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
    function check_long_pass(pwd){
        if(pwd.val().trim().length<8){
            pwd[0].setCustomValidity('ความยาวต้อง >= 8 ตัวอักษร');
            return false;

        }
        pwd[0].setCustomValidity('');
        return true;
        
    }
    function check_pass_format(pwd){
        if(pwd.val().trim().match(/([0-9].*[a-zA-Z].*[!,@,#,$,%,^,&,*,?,_,~])|([!,@,#,$,%,^,&,*,?,_,~].*[0-9].*[a-zA-Z])|([a-zA-Z].*[0-9].*[!,@,#,$,%,^,&,*,?,_,~])|([!,@,#,$,%,^,&,*,?,_,~].*[a-zA-Z].*[0-9])|([a-zA-Z].*[!,@,#,$,%,^,&,*,?,_,~].*[0-9])|([0-9].*[!,@,#,$,%,^,&,*,?,_,~].*[a-zA-Z])/)){
            pwd[0].setCustomValidity('');
            return true;

        }
        pwd[0].setCustomValidity('ต้องมีทั้ง ตัวอักษรภาษาอังกฤษ ตัวเลข และ อักขระพิเศษ');
        return false;
        
    }
    function check_long(username){
        // console.log("check long");
        if(username.val().trim().length<5 || username.val().trim().length>25 ){
            username[0].setCustomValidity('ความยาว 5 - 25 ตัวอักษรเท่านั้น');
                return false;
        }else{
            username[0].setCustomValidity('');
        }
        return true;
    }
    function check_checkbox(){
        // console.log("check box");
        if(document.formAdd.admin.checked == false && document.formAdd.admin2.checked == false && document.formAdd.research.checked == false 
            && document.formAdd.operator.checked == false && document.formAdd.farmer.checked == false)
        {
            $('#error').removeAttr('hidden');
            document.getElementById("save").setAttribute("type","button");
            return false;
        }else{
            document.getElementById("save").setAttribute("type","submit");
        }	
        
        return true;
    }
    function check_userName(username){
        // console.log("check userName");
        // let en= /([a-zA-Z])|([a-zA-Z].*[0-9])|([0-9].*[a-zA-Z])/; 
        // [A-Z]{3}|[0-9]{4}
        // ^(0|[1-9][0-9]*)$
        // let en = /^([a-zA-Z]{1}[0-9]|[a-zA-Z])/;
        let en = /^([a-zA-Z]{1}[0-9]*)+$/;
        if(!username.val().trim().match(en)){
            // console.log("ต้องเป็นภาษาอังกฤษ หรือ ตัวเลขเท่านั้น");
            username[0].setCustomValidity('ต้องเป็นภาษาอังกฤษหรือภาษาอังกฤษและตัวเลขเท่านั้น');
                return false;
        }else{
            username[0].setCustomValidity('');
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
    function check_pass(pwd,pwd1){
        if(pwd.val().trim() != pwd1.val().trim()){
            pwd1[0].setCustomValidity('รหัสผ่านไม่ตรงกัน');
            return false;
        }
        else{
            pwd1[0].setCustomValidity('');
            return true;
        }
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
    function check_user(name){
        for(i in dataU){
            if(name.val().trim() == dataU[i].UserName){
                name[0].setCustomValidity('ชื่อผู้ใช้งานซ้ำ');
                return false;
            }
            else{
                name[0].setCustomValidity('');
            }
        }
   
        return true;
    }
    // ------------------------------------------ edit data ------------------------------------------
    $('#edit').click(function(){
        let title = $("select[name = 'e_title']");
        let fname = $("input[name = 'e_fname']");
        let lname = $("input[name = 'e_lname']");
        let username = $("input[name = 'e_username1']");
        let mail = $("input[name = 'e_mail']");
        let uid = $("input[name = 'uid']");
        
        let data = [fname,lname,username,mail];

        document.getElementById("edit").setAttribute("type","submit");

        if(!check_blank(data)) return;
        if(!check_blank_in(data)) return;
        if(!check_lan(fname,lname)) return;
        if(!check_editName(fname,lname,uid)) return;
        if(!check_editUser(username,uid)) return;
        if(!check_mail(mail)) return;
        if(!check_checkboxEdit()) return;
        
    })
    function check_checkboxEdit(){
         console.log("check box edit");
        if(document.formEdit.e_admin.checked == false && document.formEdit.e_admin2.checked == false && document.formEdit.e_research.checked == false 
            && document.formEdit.e_operator.checked == false && document.formEdit.e_farmer.checked == false)
        {
            // console.log("well box");
            $('#e_error').removeAttr('hidden');
            document.getElementById("edit").setAttribute("type","button");
            return false;
        }else{
            document.getElementById("edit").setAttribute("type","submit");
        }	
        
        return true;
    }
    function check_editName(fname,lname,uid){
        for(i in dataU){
            if(fname.val().trim() == dataU[i].FirstName && lname.val().trim() == dataU[i].LastName && dataU[i].UID != uid.val()){
                fname[0].setCustomValidity('ชื่อ-นามสกุลซ้ำ');
                return false;
            }
            else{
                fname[0].setCustomValidity('');
            }
        }
   
        return true;
    }
    function check_editUser(name,uid){
        for(i in dataU){
            if(name.val().trim() == dataU[i].UserName && dataU[i].UID != uid.val()){
                name[0].setCustomValidity('ชื่อผู้ใช้งานซ้ำ');
                return false;
            }
            else{
                name[0].setCustomValidity('');
            }
        }
   
        return true;
    }
    // ------------------------------------------ edit password ------------------------------------------
    $('#edit_pass').click(function(){
        let old_pwd = $("input[name = 'old_pwd']");
        let pwd = $("input[name = 'e_pwd']");
        let pwd1 = $("input[name = 'e_pwd1']");
        let uid = $("input[name = 'pass_uid']");
        let username = $("input[name = 'pass_username']");
        let pass_old = $("input[name = 'pass_old']");
        
        let data = [old_pwd,pwd,pwd1];

        
  
        call(old_pwd,uid,username,0);
        call(pwd,uid,username,1);

        // console.log(i);
        pullLogPass(uid.val());
        
        
        // console.log(old_pwd.val().trim());
        // console.log(pwd.val().trim());
        // if(!check_dup(old_pwd,pwd)) return;
        if(!check_blankPass(data)) return;
        if(!check_oldPass(old_pwd,pass_old)) return;
        if(!check_long_pass(pwd)) return;
        if(!check_pass_format(pwd)) return;
        if(!check_pass(pwd,pwd1)) return;
        if(!check_passUsed(pwd)) return;
        
        
    })

    function check_passUsed(pwd){
        // console.log(logP);
        // console.log("ch password");
        for(i in logP){
            
            if(pwd_new_md5.trim() == logP[i].PWD.trim()){
                // console.log("*"+pwd_new_md5.trim()+'-'+logP[i].PWD.trim()+"*");
                // console.log("รหัสผ่านนี้ถูกใช้แล้ว");
                pwd[0].setCustomValidity('รหัสผ่านนี้ถูกใช้แล้ว');
                return false;
            }
            
        }
        pwd[0].setCustomValidity('');
        return true;
    }
    function check_blankPass(selecter){
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
    function call(old_pwd,uid,username,ch){
        var us = username.val();
        // console.log(us.toUpperCase());
        var pwd = uid.val()+us.toUpperCase()+(old_pwd.val().trim());
        if(ch == 0){
            makemd5(pwd);
        }else{
            makeNewmd5(pwd);
        }
                

    }
    function check_oldPass(old_pwd,pass_old){
            // console.log(pwd_md5.trim());
            // console.log(pass_old.val().trim());
            
                    if(pwd_md5.trim() != (pass_old.val().trim())){
                        // console.log("password duplicate");
                        old_pwd[0].setCustomValidity('รหัสผ่านไม่ถูกต้อง');
                        return false;
                    }
                    else{
                        old_pwd[0].setCustomValidity('');
                    }
                    return true;           
        
    }
    function makeNewmd5(pwd){
        $.ajax({    // update data
            type: "POST",
            data: {pwd: pwd,request:'md5'},
            url: "manage.php",
            async: false,
            
            success: function(result) {
                pwd_new_md5 = result;
                // console.log(pwd_md5); 
            }
            });
    }
    function makemd5(pwd){
        $.ajax({    // update data
            type: "POST",
            data: {pwd: pwd,request:'md5'},
            url: "manage.php",
            async: false,
            
            success: function(result) {
                pwd_md5 = result;
                // console.log(pwd_md5); 
            }
            });
    }
 

});

    // ------------------------------------------ unblock ------------------------------------------
function unblock(_username,_uid) {

    swal({
            title: "คุณต้องการปลดบล็อค",
            text: `${_username} หรือไม่ ?`,
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
                unblock_1(_uid)
                set_unblock(_uid)
            } else {
    
            }
        });
    
    }
    function unblock_1(_uid) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            window.location.href = 'OtherUsersList.php';
            // alert(this.responseText);
        }
    };
    xhttp.open("POST", "manage.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(`uid=${_uid}&request=block&val=0`);
    
    }
    function set_unblock(_uid){
        // $(_uid).attr("class","btn btn-success btn-sm")
        document.getElementById(_uid).style.backgroundColor = "red";
    }
    // ------------------------------------------ block ------------------------------------------
function block(_username,_uid) {

    swal({
            title: "คุณต้องการบล็อค",
            text: `${_username} หรือไม่ ?`,
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
                block_1(_uid)
                set_block(_uid)
            } else {
    
            }
        });
    
    }
    function block_1(_uid) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            window.location.href = 'OtherUsersList.php';
            // alert(this.responseText);
        }
    };
    xhttp.open("POST", "manage.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(`uid=${_uid}&request=block&val=1`);
    
    }
    function set_block(_uid){
        // $(_uid).attr("class","btn btn-danger btn-sm")
        document.getElementById(_uid).style.backgroundColor = "red";
    }
    // ------------------------------------------ delete data ------------------------------------------
function delfunction(_username,_uid) {

    swal({
            title: "คุณต้องการลบ",
            text: `${_username} หรือไม่ ?`,
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
                        delete_1(_uid)
                    }
    
                });
            } else {
    
            }
        });
    
    }
    function delete_1(_uid) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            window.location.href = 'OtherUsersList.php';
            // alert(this.responseText);
        }
    };
    xhttp.open("POST", "manage.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(`uid=${_uid}&request=delete`);
    
    }
    // --------------------------------------- old_pwd ---------------------------------------

    var h1 = document.getElementById('hide_1');
    h1.addEventListener('click',show_hide1);

    function show_hide1(){
        
        h1.classList.toggle('active');
        
        if($('#old_pwd').attr("type") == "text"){
            // console.log("pwd");
                    $('#old_pwd').attr('type', 'password');
                    $('#hide_1').removeClass( "fa-eye" );
                    $('#hide_1').addClass( "fa-eye-slash" );
        }else if($('#old_pwd').attr("type") == "password"){
                    // console.log("txt");
                    $('#old_pwd').attr('type', 'text');
                    $('#hide_1').removeClass( "fa-eye-slash" );
                    $('#hide_1').addClass( "fa-eye" );
        }
    }
    // --------------------------------------- e_pwd ---------------------------------------
    var h2 = document.getElementById('hide_2');
    h2.addEventListener('click',show_hide2);

    function show_hide2(){
        
        h2.classList.toggle('active');
        
        if($('#e_pwd').attr("type") == "text"){
            // console.log("pwd");
                    $('#e_pwd').attr('type', 'password');
                    $('#hide_2').removeClass( "fa-eye" );
                    $('#hide_2').addClass( "fa-eye-slash" );
        }else if($('#e_pwd').attr("type") == "password"){
                    // console.log("txt");
                    $('#e_pwd').attr('type', 'text');
                    $('#hide_2').removeClass( "fa-eye-slash" );
                    $('#hide_2').addClass( "fa-eye" );
        }
    }
    // --------------------------------------- e_pwd1 ---------------------------------------
    var h3 = document.getElementById('hide_3');
    h3.addEventListener('click',show_hide3);

    function show_hide3(){
        
        h3.classList.toggle('active');
        
        if($('#e_pwd1').attr("type") == "text"){
            // console.log("pwd");
                    $('#e_pwd1').attr('type', 'password');
                    $('#hide_3').removeClass( "fa-eye" );
                    $('#hide_3').addClass( "fa-eye-slash" );
        }else if($('#e_pwd1').attr("type") == "password"){
                    // console.log("txt");
                    $('#e_pwd1').attr('type', 'text');
                    $('#hide_3').removeClass( "fa-eye-slash" );
                    $('#hide_3').addClass( "fa-eye" );
        }
    }
    // --------------------------------------- pwd ---------------------------------------

    var h_insert_1 = document.getElementById('h_1');
    h_insert_1.addEventListener('click',show_h1);

    function show_h1(){
        
        h_insert_1.classList.toggle('active');
        
        if($('#pwd').attr("type") == "text"){
            // console.log("pwd");
                    $('#pwd').attr('type', 'password');
                    $('#h_1').removeClass( "fa-eye" );
                    $('#h_1').addClass( "fa-eye-slash" );
        }else if($('#pwd').attr("type") == "password"){
                    // console.log("txt");
                    $('#pwd').attr('type', 'text');
                    $('#h_1').removeClass( "fa-eye-slash" );
                    $('#h_1').addClass( "fa-eye" );
        }
    }
    // --------------------------------------- pwd1 ---------------------------------------
    var h_insert_2 = document.getElementById('h_2');
    h_insert_2.addEventListener('click',show_h2);

    function show_h2(){
        
        h_insert_2.classList.toggle('active');
        
        if($('#pwd1').attr("type") == "text"){
            // console.log("pwd");
                    $('#pwd1').attr('type', 'password');
                    $('#h_2').removeClass( "fa-eye" );
                    $('#h_2').addClass( "fa-eye-slash" );
        }else if($('#old_pwd').attr("type") == "password"){
                    // console.log("txt");
                    $('#pwd1').attr('type', 'text');
                    $('#h_2').removeClass( "fa-eye-slash" );
                    $('#h_2').addClass( "fa-eye" );
        }
    }