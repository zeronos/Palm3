"<?php echo session_start(); ?>"
$( document ).ready(function() {

    $('.tt').tooltip();
    
    pullData();
    let dataD;
    $('#addDept').click(function(){

            $("#addModal").modal();
           

    });
    function pullData(){
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            dataD = JSON.parse(this.responseText);
             console.log(dataD);  
           
        };
        }
        xhttp.open("POST", "manage.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send(`request=select`);
    }
    $('.btn_edit').click(function(){
        $("#editModal").modal();
        var did = $(this).attr('did');
        var department = $(this).attr('department');
        var alias = $(this).attr('alias');
        var note =$(this).attr('note');
        
        $('#e_department').val(department);
        $('#e_alias').val(alias);
        $('#e_note').val(note);
        $('#e_did').val(did);

        $('#e_o_department').val(department);
        $('#e_o_alias').val(alias);
        $('#e_o_note').val(note);

        

    });
    $('#save').click(function(){
        // console.log("save");
        let department = $("input[name = 'department']");
        let alias = $("input[name = 'alias']");
        let note = $("input[name = 'note']");
        
        let data = [department,alias];
        if(!check_blank(data)) return;
        if(!check_department(department)) return;
        if(!check_alias(alias)) return;

    
    })  
    function check_blank(selecter){
        for(i in selecter){
            // console.log(selecter[i]);
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
    function check_department(name){
        // console.log("check department");
        for(i in dataD){
            // console.log(name.val().trim().replace(/\s\s+/g, ' '));
            if(name.val().trim().replace(/\s\s+/g,' ') == dataD[i].Department){
                name[0].setCustomValidity('ชื่อหน่วยงานซ้ำ');
                return false;
            }
            else{
                name[0].setCustomValidity('');
            }
        }
   
        return true;
    }
    function check_alias(name){

        for(i in dataD){
            console.log(dataD[i].Alias);
            if(name.val().trim().replace(/\s\s+/g,' ') == dataD[i].Alias){
                name[0].setCustomValidity('ชื่อย่อหน่วยงานซ้ำ');
                return false;
            }
            else{
                name[0].setCustomValidity('');
            }
        }
   
        return true;
    }

    $('#edit').click(function(){
        console.log("edit");
        let department = $("input[name = 'e_department']");
        let alias = $("input[name = 'e_alias']");
        let note = $("input[name = 'e_note']");
        let did = $("input[name = 'e_did']");

        let o_department = $("input[name = 'e_o_department']");
        let o_alias = $("input[name = 'e_o_alias']");
        let o_note = $("input[name = 'e_o_note']");
        
        let data = [department,alias];
        if(!check_duplicate(o_department,o_alias,o_note,department,alias,note)) return;
        if(!check_blank(data)) return;
        if(!check_editDepartment(department,did)) return;
        if(!check_editAlias(alias,did)) return;
    
    })  
    function check_duplicate(o_department,o_alias,o_note,department,alias,note){
        if(o_department == department && o_alias == alias && o_note == note){
            return false;
        }
        return true;
    }
    function check_editDepartment(name,did){
        console.log("check_de");
        for(i in dataD){
            console.log(dataD[i].Department);
            if(name.val().trim().replace(/\s\s+/g,' ') == dataD[i].Department && dataD[i].DID != did.val()){
                console.log("du");
                name[0].setCustomValidity('ชื่อหน่วยงานซ้ำ');
                return false;
            }
            else{
                name[0].setCustomValidity('');
            }
        }
   
        return true;
    }
    function check_editAlias(name,did){
        console.log("check_ali");
        for(i in dataD){
            console.log(dataD[i].Alias);
            if(name.val().trim().replace(/\s\s+/g,' ') == dataD[i].Alias && dataD[i].DID != did.val()){
                name[0].setCustomValidity('ชื่อย่อหน่วยงานซ้ำ');
                return false;
            }
            else{
                name[0].setCustomValidity('');
            }
        }
   
        return true;
    }


});

function delfunction(_department,_did,_department,_alias,_note) {
    // alert(_did);
    swal({
            title: "คุณต้องการลบ",
            text: `${_department} หรือไม่ ?`,
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
                        delete_1(_did,_department,_alias,_note)
                    }
    
                });
            } else {
    
            }
        });
    
    }
    function delete_1(_did,_department,_alias,_note) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            window.location.href = 'DepartmentList.php';
            // alert(this.responseText);
        }
    };
    xhttp.open("POST", "manage.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(`did=${_did}&request=delete&department=${_department}&alias=${_alias}&note=${_note}`);
    
    }
    
 