//let modalAdd = 
$( document ).ready(function() {
    let dataU;
    $('#addUser').click(function(){
        $("#addModal").modal();
        var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
              if (this.readyState == 4 && this.status == 200) {
                dataU = JSON.parse(this.responseText);
                console.log(dataU);  
               
            };
            }
            xhttp.open("POST", "manage.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send(`request=select`);

    });
    $('.pass_edit').click(function(){
        $("#passModal").modal();
    });

    $('.btn_edit').click(function(){
        $("#editModal").modal();
        var uid = $(this).attr('uid');
        // alert(uid);
        //set all false
        document.getElementById("e_admin").checked = false;
        document.getElementById("e_research").checked = false;
        document.getElementById("e_operator").checked = false;
        document.getElementById("e_farmer").checked = false;

        var title = $(this).attr('title');
        var fname = $(this).attr('fname');
        var lname = $(this).attr('lname');
        var username = $(this).attr('username');
        var mail = $(this).attr('mail');
        var type = $(this).attr('type_email');
        var department = $(this).attr('department');
        var admin = $(this).attr('admin');
        var research = $(this).attr('research');
        var operator = $(this).attr('operator');
        var farmer = $(this).attr('farmer');
        
        $('#uid').val(uid);
        $('#e_fname').val(fname);
        $('#e_lname').val(lname);
        $('#e_username').val(username);
        $('#e_mail').val(mail);
        // alert(admin);
        document.getElementById("e_title").value = title;
        document.getElementById("e_type").value = type;
        document.getElementById("e_department").value = department;
        if(admin == 1){
            // alert("admin");
            document.getElementById("e_admin").checked = true;
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

    $('#save').click(function(){
        let title = $("select[name = 'title']");
        let fname = $("input[name = 'fname']");
        let lname = $("input[name = 'lname']");
        let username = $("input[name = 'username']");
        let pwd = $("input[name = 'pwd']");
        let pwd1 = $("input[name = 'pwd1']");
        let mail = $("input[name = 'mail']");
        let type = $("select[name = 'type']");
        let department = $("select[name = 'department']");
        let admin = $("input[name = 'admin']");
        let research = $("input[name = 'research']");
        let operator = $("input[name = 'operator']");
        let farmer = $("input[name = 'farmer']");

        // console.log(admin.val());
        let data = [fname,lname,username,pwd,pwd1,mail];
  
        if(!check_blank(data)) return;
        if(!check_name(title,fname,lname)) return;
        if(!check_user(username)) return;
        // if(!check_pass(pwd,pwd1)) return;
        
            var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                console.log(this.responseText);
            
                // window.location.href = 'OtherUserList.php';
                
                                               
                }
            };
            xhttp.open("POST", "manage.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send(`title=${title.val()}
            &fname=${fname.val()}&lname=${lname.val()}
            &username=${username.val()}&pwd=${pwd.val()}
            &mail=${mail.val()}&type=${type.val()}
            &department=${department.val()}&request=insert`);
            // xhttp.send(`title=${title.val()}
            // &fname=${fname.val()}&lname=${lname.val()}
            // &username=${username.val()}&pwd=${pwd.val()}
            // &mail=${mail.val()}&type=${type.val()}
            // &department=${department.val()}&admin=${admin.val()}
            // &research=${research.val()}&operator=${operator.val()}
            // &farmer=${farmer.val()}&request=insert`);
        
    })
    function check_pass(pwd,pwd1){
        if(pwd.val() != pwd1.val()){
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
    function check_name(title,fname,lname){
        for(i in dataU){
            // console.log(dataU[i].Title);
            // console.log(title.val());
            if(title.val() == dataU[i].Title && fname.val().trim() == dataU[i].FirstName && lname.val().trim() == dataU[i].LastName){
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
            // console.log(dataU[i].UserName);
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

        $('#editModal').on('submit',function(event){
            // alert("oo");
            event.preventDefault();
            $.ajax({
                url : "manage.php",
                type: "post",
                data:$('#formEdit').serialize(),
                success:function(data){
                    // alert(data);
                    
                    // if($('#department').val().trim() == ''){
                    //     //alert("blank");
                    //     document.getElementById("department").style.borderColor = "red";
                    //     document.getElementById("alias").style.borderColor = "";
                    //     document.getElementById("note").style.borderColor = "";
                    // }else if($('#alias').val().trim() == ''){
                    //     document.getElementById("department").style.borderColor = "";
                    //     document.getElementById("alias").style.borderColor = "red";
                    //     document.getElementById("note").style.borderColor = "";
                    // // }else if($('#note').val().trim() == ''){
                    // //     document.getElementById("department").style.borderColor = "";
                    // //     document.getElementById("alias").style.borderColor = "";
                    // //     document.getElementById("note").style.borderColor = "red";
                    // }else{
                        window.location.href='OtherUsersList.php';
                    // }
                    
                }
                })
            })

});
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