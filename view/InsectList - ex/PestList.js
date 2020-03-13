$(document).ready(function() {

    $(document).on('click', '.card-item', function() {
        $.ajax({
            type: "POST",
            datatype: 'json',
            url: "getDataBug.php",
            data: {
                id: $(this).attr('id')
            },
            async: false,
            success: function(result) {
                dataF = result;

                console.log(result)
                $("#card-pest").empty();
                $("#card-pest").append(dataF);
            }
        })
    });

    function pullData() {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                dataD = JSON.parse(this.responseText);
                console.log(dataD);

            };
        }
        xhttp.open("POST", "upload.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send(`request=select`);
    }

    // insert submit
    $(document).on('click', '.insertSubmit', function(e) {
        // alert('55555555')
        let name = $("input[name='name_insert']");
        let alias = $("input[name='alias_insert']");
        let styleChar = $("input[name='charactor_insert']");
        let styleDanger = $("input[name='danger_insert']");
        // let icon = $("#pic-logo");
        // let picstyle = $("#pic-style-char");
        // let picdan = $("#pic-danger");

        let dataNull = [name, alias, styleChar, styleDanger]

        if (!checkNull(dataNull)) return;
        if (!checkSameName(name, -1)) return;

        // console.log('insert');
        let form = new FormData($('#form-insert')[0]);
        let pic_sc = new Array()
        let pic_photo = new Array()
        let pic_logo
        pic_logo = $('#img-pic-logo').attr('src')
        $('.pic-SC').each(function(i, obj) {
            pic_sc.push($(this).attr('src') + 'manu20')
        });
        $('.pic-photo').each(function(i, obj) {
            pic_photo.push($(this).attr('src') + 'manu20')
        });
        form.append('pic1', pic_logo)
        form.append('pic2', pic_sc)
        form.append('pic3', pic_photo)
        $.ajax({ // update data
            type: "POST",
            data: form,
            url: "upload.php",
            async: false,
            cache: false,
            contentType: false,
            processData: false,

            success: function(result) {
                location.reload();
                // alert(result)
            }
        });
        //if (!checkNull(dataNull)) return;
        //if (!checkSameName(name, -1)) return;
    });

    function checkSameName(name, id) { // check same name
        for (i in dataF) {
            console.log(dataF[i].Name);
            if (name.val().trim() == dataF[i].Name && dataF[i].FID != id) {
                name[0].setCustomValidity('ชื่อนี้ซ้ำ');
                return false;
            } else {
                name[0].setCustomValidity('');
            }
        }
        return true;
    }

    function checkNull(selecter) { // check name null
        for (i in selecter) {
            if (selecter[i].val() == '') {
                console.log('key')
                selecter[i][0].setCustomValidity('กรุณากรอกข้อมูล');
                return false;
            } else selecter[i][0].setCustomValidity('');
        }
        return true;
    }

    function setImgEdit(icon, pid, num, footer) {
        var textPicChar = ''
        console.log("num" + num)
        for (let i = 0; i < num; i++) {
            let num2 = i
            textPicChar += `<div class="card" width="70px" hight="70px">
                                <div class="card-body" style="padding:0;">
         `;
            let path;
            console.log("i" + i)
            if (i == 0)
                path = `../../picture/Pest/insect/style/${pid}/${icon}`
            else
                path = `../../picture/Pest/insect/style/${pid}/${num2-1}_${icon}`

            textPicChar += `<img class="" src = "${path}" id="img-${(+new Date)}" width="100%" hight="100%" />`
            textPicChar += `</div>
            <div class="card-footer">
                <button  type="button" class="btn btn-warning edit-img">แก้ไข</button>
                <button  type="button" class="btn btn-danger delete-img">ลบ</button>
            </div>
        </div>`
        }
        textPicChar += footer
        return textPicChar;

    }
    $('.btn_edit').click(function() {
        $("#editModal").modal();
        var pid = $(this).attr('pid');
        var nameinsect = $(this).attr('name');
        var alias = $(this).attr('alias');
        var charstyle = $(this).attr('charstyle');
        var dangerInsect = $(this).attr('dangerstyle');
        var numPicChar = $(this).attr('numPicChar')
        var numPicDanger = $(this).attr('numPicDanger')
        var icon = $(this).attr('data-icon')
        var footer;


        console.log("icon = " + icon)

        $('#img-pic-logo-edit').attr('src', "../../icon/pest/" + pid + "/" + icon)
        footer = `<div class="img-reletive">

        <img width="100px" height="100px" src="https://ast.kaidee.com/blackpearl/v6.18.0/_next/static/images/gallery-filled-48x48-p30-6477f4477287e770745b82b7f1793745.svg" width="50px" height="50px" alt="">
        <input type="file" id="pic-style-char-edit" name="picstyle_insert-edit[]" accept=".jpg" multiple>
    </div>`
        $('#grid-pic-style-char-edit').html(setImgEdit(icon, pid, numPicChar, footer))


        footer = `<div class="img-reletive">
        <img width="100px" height="100px" src="https://ast.kaidee.com/blackpearl/v6.18.0/_next/static/images/gallery-filled-48x48-p30-6477f4477287e770745b82b7f1793745.svg" width="50px" height="50px" alt="">
        <input type="file" class="form-control" id="p_photo-edit" name="p_photo-edit[]" accept=".jpg,.png" multiple>
    </div>`
        $('#grid-p_photo-edit').html(setImgEdit(icon, pid, numPicDanger, footer))

        $('#e_name').val(alias);
        $('#e_alias').val(nameinsect);
        $('#e_charactor').text(charstyle);
        $('#e_danger').text(dangerInsect);
        //document.getElementById("e_charactor").value = charstyle;
        //document.getElementById("e_danger").value = dangerInsect;
        $('#e_pid').val(pid);

        $('#e_o_name').val(alias);
        $('#e_o_alias').val(nameinsect);
        $('#e_o_charcator').text(charstyle);
        $('#e_o_danger').text(dangerInsect);
        // document.getElementById("e_o_charactor").value = charstyle;
        //document.getElementById('e_o_alias').value = dangerInsect;
    });

    $('#save').click(function() {
        // console.log("save");
        let nameinsect = $("input[name = Name]");
        let alias = $("input[name = 'Alias']");
        let charstyle = $("input[name = 'Charactor']");
        let dangerInsect = $("input[name = 'Danger']");

        let data = [nameinsect, alias];
        if (!check_blank(data)) return;
        if (!check_name(nameinsect)) return;
        if (!check_alias(alias)) return;
    })

    function check_blank(selecter) {
        for (i in selecter) {
            // console.log(selecter[i]);
            if (selecter[i].val().trim() == '') {
                //  console.log("if");
                selecter[i][0].setCustomValidity('กรุณากรอกข้อมูล');
                return false;
            } else {
                // console.log("else");
                selecter[i][0].setCustomValidity('');
            }
        }
        return true;
    }

    function check_name(name) {
        for (i in dataD) {
            console.log(dataD[i].Department);
            if (name.val().trim() == dataD[i].Department) {
                name[0].setCustomValidity('ชื่อซ้ำ');
                return false;
            } else {
                name[0].setCustomValidity('');
            }
        }

        return true;
    }

    function check_alias(name) {

        for (i in dataD) {
            console.log(dataD[i].Alias);
            if (name.val().trim() == dataD[i].Alias) {
                name[0].setCustomValidity('ชื่อสามัญซ้ำ');
                return false;
            } else {
                name[0].setCustomValidity('');
            }
        }

        return true;
    }

    $('#edit').click(function() {
        console.log("edit");

        let nameinsect = $("input[name = 'e_name']");
        let alias = $("input[name = 'e_alias']");
        let charstyle = $("input[name = 'e_charactor']");
        let dangerInsect = $("input[name = 'e_danger']");
        let did = $("input[name = 'e_pid']");

        let o_nameinsect = $("input[name = 'e_o_name']");
        let o_alias = $("input[name = 'e_o_alias']");
        let o_charstyle = $("input[name = 'e_o_charcator']");
        let o_dangerInsect = $("input[name = 'e_o_danger']");

        let data = [nameinsect, alias];
        if (!check_duplicate(o_nameinsect, o_alias, o_charstyle, o_dangerInsect, nameinsect, alias, charstyle, dangerInsect)) return;
        if (!check_blank(data)) return;
        if (!check_editpest(nameinsect, pid)) return;
        if (!check_editAlias(alias, pid)) return;

    })

    function check_duplicate(o_nameinsect, o_alias, o_charstyle, o_dangerInsect, nameinsect, alias, charstyle, dangerInsect) {
        if (o_nameinsect == nameinsect && o_alias == alias && o_charstyle == charstyle && o_dangerInsect == dangerInsect) {
            return false;
        }
        return true;
    }

    function check_editpest(name, pid) {
        console.log("check_de");
        for (i in dataD) {
            console.log(dataD[i].Department);
            if (name.val().trim() == dataD[i].Department && dataD[i].DID != did.val()) {
                console.log("du");
                name[0].setCustomValidity('ชื่อซ้ำ');
                return false;
            } else {
                name[0].setCustomValidity('');
            }
        }

        return true;
    }

    function check_editAlias(name, pid) {
        console.log("check_ali");
        for (i in dataD) {
            console.log(dataD[i].Alias);
            if (name.val().trim() == dataD[i].Alias && dataD[i].DID != did.val()) {
                name[0].setCustomValidity('ชื่อสามัญซ้ำ');
                return false;
            } else {
                name[0].setCustomValidity('');
            }
        }

        return true;
    }

    // Configure/customize these variables.
    var showChar = 100; // How many characters are shown by default
    var ellipsestext = "...";
    var moretext = "Show more";
    var lesstext = "Show less";

    $('.more').each(function() {
        var content = $(this).html();

        if (content.length > showChar) {

            var c = content.substr(0, showChar);
            var h = content.substr(showChar, content.length - showChar);

            var html = c + '<span class="moreellipses">' + ellipsestext + '&nbsp;</span><span class="morecontent"><span>' + h +
                '</span>&nbsp;&nbsp;<a href="" class="morelink">' + moretext + '</a></span>';

            $(this).html(html);
        }

    });

    $(".morelink").click(function() {
        if ($(this).hasClass("less")) {
            $(this).removeClass("less");
            $(this).html(moretext);
        } else {
            $(this).addClass("less");
            $(this).html(lesstext);
        }
        $(this).parent().prev().toggle();
        $(this).prev().toggle();
        return false;

    });

    $('#addInsect').click(function() {
        console.log('fffff')
        $('.Modal').append(addModal);
        $('#addModal').modal('show');
    });
});

$(document).on('click', '.delete', function() {
    delfunction($(this).attr('data-pid'), $(this).attr('data-alias'))
})

function delfunction(_sid, _alias) {
    // alert(_did);
    swal({
            title: "คุณต้องการลบ",
            text: `${_alias} หรือไม่ ?`,
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
                console.log(1)
                swal({

                    title: "ลบข้อมูลสำเร็จ",
                    type: "success",
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "ตกลง",
                    closeOnConfirm: false,

                }, function(isConfirm) {
                    if (isConfirm) {
                        delete_1(_sid)
                    }

                });
            } else {

            }
        });
}

function delete_1(_sid) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            window.location.href = 'InsectList.php';
            //alert(this.responseText);
        }
    };
    xhttp.open("POST", "upload.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(`request=delete&pid=${_sid}`);

}