//let modalAdd = 
$( document ).ready(function() {
    
    $('#addUser').click(function(){
        $("#addModal").modal()
    });

    $('.btn_edit').click(function(){
        $("#editModal").modal()
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

    $('#addModal').on('submit',function(event){
        // alert("oo");
        event.preventDefault();
        $.ajax({
            url : "manage.php",
            type: "post",
            data:$('#formAdd').serialize(),
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

        document.getElementById(_uid).style.backgroundColor = "#1cc88a";
        document.getElementById(_uid).style.borderColor = "#1cc88a";

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // window.location.href = 'OtherUsersList.php';
                // alert(this.responseText);
            }
        };
        xhttp.open("POST", "manage.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send(`uid=${_uid}&request=block&val=0`);
}
function block(_username,_uid) {

    document.getElementById(_uid).style.backgroundColor = "#e74a3b";
    document.getElementById(_uid).style.borderColor = "#e74a3b";

    var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // window.location.href = 'OtherUsersList.php';
                // alert(this.responseText);
            }
        };
        xhttp.open("POST", "manage.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send(`uid=${_uid}&request=block&val=1`);
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