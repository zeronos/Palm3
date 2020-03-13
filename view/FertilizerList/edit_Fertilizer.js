let idF; // value data in fertilizer and fer condition
let startF;
let endF;
let nameF;
let iconF;
let usageF;
let conditionF;
let unitF;
let aF;
let bF;
let orderF;
let aliasF;
let DIMID;
let dataF; // data fertilizer

let mountYearChecked = false;
let abCheck = false; // IF true, input show one column 

let a2; // value a in graph
let b2; // value b in graph
let check_IU = false
let check_II = false

$(document).ready(function(){

    loadDataF() // init load page

    $(document).on('click','.editF',function(){ // set data in edit modal
        let index = $(this).attr('index');
        console.log('edit')
        setValue(index);
        $("input[name='id']").val(idF);
        $("input[name='name']").val(nameF);
        $("input[name='alias']").val(aliasF);
        $("#img-update").attr('src',`../../icon/fertilizer/${idF}/${iconF}`);
        $('#addCondition').empty();

        let j = 0;
        // console.log("numcon :"+Object.keys(conditionF).length); // fetch data condition
        if(conditionF != null){
            for(i in conditionF){
                if(j>0){
                    $('#addCondition').append(`
            <input type="text" class="form-control conditionInput" name="condition[]" id="">
            <button type="button"  class="btn btn-danger btn-removeCondition">x</button>
            `)
                }
                else{
                    $('#addCondition').append(`
            
            <input type="text" class="form-control conditionInput" name="condition[]" id="">
            <button type="button" id="btn-addCondition" class="btn btn-success" ">+</button>
    
                `)
                }

                $(".conditionInput:last").val(conditionF[i].Condition);
                j++;
            }
        }
        else{
            $('#addCondition').append(`
            
        <input type="text" class="form-control conditionInput" name="condition[]" id="">
        <button type="button" id="btn-addCondition" class="btn btn-success" s>+</button>
            `)
        }
        if(startF == '0101' && endF == '3112'){ // set start end
            console.log('set4');
            $("#exampleRadios4").prop('checked', true);
            mountYearChecked = false;
            $("#add-mount-year").empty()
        }
        else{
            $("#exampleRadios5").prop('checked', true);
            var date1 = startF.substr(0,2);
            var date2 = endF.substr(0,2);
            var mount1 = startF.substr(2,2);
            var mount2  = endF.substr(2,2);
            inputMountYear(parseInt(mount1),parseInt(mount2),parseInt(date1),parseInt(date2));

        }
        $("input[name='start']").val(startF);
        $("input[name='end']").val(endF);
        // $(`#exampleRadios${usageF}`).prop('checked', true);

        if(usageF == 3){
            abCheck = false;
            inputAb();
        }
        else{

            abCheck = true;
            inputAb();
        }

        // if(unitF==1)
        // $(`#exampleRadios6`).prop('checked', true);
        // else
        // $(`#exampleRadios7`).prop('checked', true);
        $("input[name='a']").val(aF);
        $("input[name='b']").val(bF);
        console.log('succes')
    })
    function setZero(number){
        if(parseInt(number) < 10){
            return '0'+String(number)
        }
        return String(number)
    }
    $(document).on('click','.editSubmit',function(){ // submit to update
        $('.editSubmit').attr('type','submit')
        // check_dep(name,alias,a,b,start,end)
        // let re = /^[0-9]/
        let name = $("input[name='name']");
        let alias = $("input[name='alias']");
        let a = $("input[name='a']");
        let b = $("input[name='b']");
        let d1 = setZero($('#D1').val());
        let d2 = setZero($('#D2').val());
        let m1 = setZero($('#M1').val());
        let m2 = setZero($('#M2').val());
        let start = d1+m1
        let end = d2+m2
        // alert(end)
        let con = $("input[name='condition[]']").map(function(){return $(this).val().trim();}).get();
        let condition = []
        // let unit = $("input")

        // console.log("test"+re.test(name.val()))
        let dataNull = [name,alias,a,b]
        let dataStartNum = [name,alias]
        if(start != undefined ){
            dataNull.push[start,end]
        }
        let dataNegative = [a,b]

        // console.log("connnnnn"+String(con[1]).trim())
        // console.log(name.val().trim())
        // alert('ss')
        if(!checkNull(dataNull)) return;
        if(startInputNum(dataStartNum)) return;
        if(isNaN(a.val())){
            a[0].setCustomValidity('ต้องใส่ตัวเลขเท่านั้น');
            return;
        }
        if(isNaN(b.val())){
            b[0].setCustomValidity('ต้องใส่ตัวเลขเท่านั้น');
            return;
        }
        if(!checkNegative(dataNegative)) return;
        if(!checkSameName(name,idF)) return;
        if(!checkSameAlias(alias,idF)) return;
        // if(!checkSameName(alias,idF)) return;
        // event.preventDefault();
        // $('#edit').attr("data-dismiss","modal")
        // $('#edit').modal('hide')


        let form = new FormData($('.modal-update')[0]);
        if(check_IU){
            form.append('imagebase64', $('#img-update').attr('src'))
            check_IU = false
        }
        form.append('start',start)
        form.append('end',end)
        form.append('dimid',DIMID)
        form.append('icon',iconF)
        // $('.modal').hide();
        // $('.modal-backdrop').hide()
        $.ajax({    // update data
            type: "POST",
            data: form,
            url: "dbF.php",
            async: false,
            cache: false,
            contentType: false,
            processData: false,

            success: function(result) {
                // alert(result)
                loadDataF();
                //   $('.modal').show();
                //   $('.modal-backdrop').show()
            }
        });
        console.log("update");


    })
    $(document).on('click','.insertSubmit',function(e){ // insert submit
        // console.log('sss');
        // e.preventdefault()

        let name = $("input[name='name_insert']");
        // let name = $(this).parent().prev().children().children().children().children().first().next()
        let alias = $("input[name='alias_insert']");
        let icon = $("#pic-logo");
        // console.log("name = "+name)

        let dataNull = [name,alias]
        let dataStartNum = [name,alias]
        if(!checkNull(dataNull)) return;
        if(startInputNum(dataStartNum)) return;
        // console.log('sssssssssssssssss');

        // console.log('pppp');
        if(!checkSameName(name,-1)) return;
        if(!checkSameAlias(alias,-1)) return;
        // console.log('bb');
        // // if(!checkSameName(alias,-1)) return;

        // console.log('insert');
        let form = new FormData($('#form-insert')[0]);
        if(check_II){
            form.append('imagebase64', $('#img-insert').attr('src'))
            check_II = false
        }

        insertF(form); // insert data
    })
    function loadDataF(){ // load all data in database and fetch data on wep page
        $('.bodyF').empty();
        $('.amount-fer').html(`0 ชนิด`)
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "dbF.php",
            data: {
                request:'select'
            },
            async:false,
            success: function(result) {
                dataF = result;


                // alert(data)
                let text = '';
                let j =0
                if(dataF!=null){
                    for(i in dataF){
                        j++
                        let icon = `<img src="../../icon/fertilizer/${dataF[i].FID}/${dataF[i].Icon}" id="pic-Fertilizer" class="" style="border-radius: 150px;width:200px;"; >`;
                        if(dataF[i].Icon == ''){
                            icon = `<img src="https://imbindonesia.com/images/placeholder/camera.jpg" id="pic-Fertilizer" class="" width="150px" height="200px" >`;
                        }
                        text += `
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between header-fertilizer"  >
                <h6 class="m-0 font-weight-bold text-white">${dataF[i].Name}</h6>
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle editF" index=${i}  id="FID${dataF[i].FID}" data-toggle="modal" data-target="#edit" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-cog fa-lg mr-3 curser"  style="color:#FDFEFE"></i>
                    </a>
                    <a class="dropdown-toggle deleteF" index=${i}  id=${dataF[i].FID} DIMID = ${dataF[i].ID} data-name=${dataF[i].Name}>
                        <i class="fas fa-trash-alt curser" style="color:#FDFEFE"></i>
                    </a>
                </div>
            </div>
            <!-- Card Body -->
            <div class="card-body shadow" id="card1-detail">
                <div class="grid-fer-card">
                    <div class="fer-column1">
                    <br>
                        <center>
                        <div class="upload-btn-wrapper">
                            ${icon}
                            
                        </div>
                            
                            <br>
                            <br>
        
                            <h5>${dataF[i].Name}</h5>
                        </center>
                    </div>
                    <div class="fer-column2">
                        <h4> เงื่อนไข </h4>
                        <div>
                        `
                        loadCondition(dataF[i].FID);
                        if(conditionF!=null){
                            for(k in conditionF){
                                text += `
                                <h5>${conditionF[k].Order}. ${conditionF[k].Condition}</h5>
                                `
                            }
                        }
                        else{
                            text += `<h5>ไม่มีเงื่อนไข</h5>`
                        }

                        text+=`
                        </div>
                    </div>
                    <div class = "fer-column3">
                        <div class="card shadow mb-4" >                
                            <div class="card-body chart-fer" >
                            <div class="">
                                <canvas id="lineChart${i}"  style="max-width:500px;" ></canvas>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><br>
                `
                    }
                    // console.log("a " +dataF[i].EQ1+"b" +dataF[i].EQ2)
                    $('.bodyF').append(text);

                    for(i in dataF){
                        let unitY = ''
                        let unitX = ''
                        // console.log("Usage"+dataF[i].Usage)
                        switch('1'){
                            case '1':
                                unitX = "อายุ (ปี)"
                                break;
                            case '2':
                                unitX = "ผลผลิต (กิโลกรัม)"
                                break;
                            case '3':
                                unitX = "อายุ(ปี)"
                                break;
                        }
                        switch('1'){
                            case '1':
                                unitY = "ปริมาณการใส่ (กิโลกรัม/ต้น/ปี)"
                                break;
                            case '2':
                                unitY = "ปริมาณการใส่ (กิโลกรัม/ไร่/ปี)"
                                break;
                        }
                        a2 = dataF[i].EQ1
                        b2 = dataF[i].EQ2
                        // console.log("b"+b2);
                        new Chart(document.getElementById("lineChart"+i).getContext("2d"), getChartJs2('line',unitY,unitX));
                    }
                }

                $('.amount-fer').html(`${j} ชนิด`)
            }
        });


    }
    function getChartJs2(type,unitY,unitX) { // set graph in wep page
        if (type === 'line') {
            config = {
                type: 'line',
                data: {
                    labels: [1, 2, 3, 4, 5, 6,7],
                    datasets: [{
                        label: "y = ax + b",
                        data: [(a2*1) + b2*1, (a2*2) + b2*1,  (a2*3) + b2*1, (a2*4) + b2*1, (a2*5) + b2*1,(a2*6) + b2*1,(a2*7) + b2*1],
                        borderColor: 'rgba(0, 188, 212, 0.75)',
                        backgroundColor: 'rgba(0, 188, 212, 0.3)',
                        pointBorderColor: 'rgba(0, 188, 212, 0)',
                        pointBackgroundColor: 'rgba(0, 188, 212, 0.9)',
                        pointBorderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    legend: false,
                    scales: {
                        xAxes: [{
                            display: true,
                            scaleLabel: {
                                display: true,
                                labelString: unitX
                            }
                        }],
                        yAxes: [{
                            display: true,
                            scaleLabel: {
                                display: true,
                                labelString: unitY
                            }
                        }]
                    }
                }
            }
        }
        console.log("b"+b2);
        return config;
    }

    function insertF(data){ // function insert data
        $.ajax({
            type: "POST",
            data: data,
            url: "dbF.php",
            async: false,
            cache: false,
            contentType: false,
            processData: false,

            success: function(result) {
                // alert(result);
                loadDataF();
            }
        });
    }
    function deleteF(id){ // function delete is not working
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                loadDataF();
            }
        };
        xhttp.open("POST", "dbF.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send(`id=${id}`);
    }
    function setValue(i){ // function set value when click edit modal

        DIMID = dataF[i].ID;
        idF = dataF[i].FID;
        startF = dataF[i].Start;
        endF = dataF[i].End;
        nameF = dataF[i].Name;
        //   usageF = dataF[i].Usage;
        unitF = dataF[i].Unit;
        aF = dataF[i].EQ1;
        bF = dataF[i].EQ2;
        iconF = dataF[i].Icon;
        aliasF = dataF[i].Alias;
        //   conditionF = "";
        console.log("DIMID "+DIMID);
        loadCondition(idF)


    }
    function changeIcon(input){ // change icon in form
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#icon')
                    .attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
    $(document).on('change','#exampleRadios1',function(){ // set check usage
        abCheck = true;
        inputAb();
    })
    $(document).on('change','#exampleRadios2',function(){ // set check usage
        abCheck = true;
        inputAb();
    })
    $(document).on('change','#exampleRadios3',function(){ // set check usage
        abCheck = false;
        inputAb();
    })
    function inputAb(){ // set input x y
        // $('.graph').empty()
        if(abCheck){
            $('.a').show();
            $('.b').show();
            $("input[name='a']").val(aF);
            $("input[name='b']").val(bF);
        }
        else{
            $('.a').hide();
            $('.b').show();
            $("input[name='a']").val(0);
            $("input[name='b']").val(bF);
        }

    }
    $(document).on('change','#exampleRadios5',function(){ // set check start end
        let d1 = startF.substr(0,2)
        let m1 = startF.substr(2,2)
        let d2 = endF.substr(0,2)
        let m2 = endF.substr(2,2)
        inputMountYear(parseInt(m1),parseInt(m2),parseInt(d1),parseInt(d2));


    })
    $(document).on('change','#exampleRadios4',function(){ // set check start end
        mountYearChecked = false;
        $("#add-mount-year").empty()
    })
    $(document).on('click','#btn-addCondition',function(){ // more condition
        $('#addCondition').append(`
        <input type="text" class="form-control" name="condition[]"  id="">
        <button type="button" class="btn btn-danger btn-removeCondition" ">x</button>
    `)
    })
    $(document).on('click','.btn-removeCondition',function(){ // delete condition
        $(this).prev().remove();
        $(this).remove();
    })
    function dateOfMount(mount){
        let dateM;
        if(mount==1||mount==3||mount==5||mount==7||mount==8||mount==10||mount==12){
            dateM = 31
        }
        else if(mount == 2){
            dateM = 28
        }
        else dateM = 30
        return dateM;
    }
    function getDateAll(mount1,mount2,date1,date2,isStart){
        if(isStart){
            if(mount2!=mount1) return [1,dateOfMount(mount1)]
            else{
                if(dateOfMount(mount1)>date2){
                    return [1,date2-1];
                }
                return [1,dateOfMount(mount1)]
            }
        }else{
            if(mount2!=mount1) return [1,dateOfMount(mount2)]
            else return [date1+1,dateOfMount(mount2)]
        }
    }
    function getMountAll(date,date3,mount1,mount2,isStart){
        let arrMount = [1,2,3,4,5,6,7,8,9,10,11,12];
        let arrDate;
        if(isStart){
            if(date >= date3) arrMount[mount2-1] = undefined
        }
        else{
            if(date <= date3) arrMount[mount1-1] = undefined
        }
        if(date<=28 && isStart){
            arrMount =  arrMount.filter(function(item){
                if(item <= parseInt(mount2)){
                    // console.log(item+" "+mount2)
                    return item;
                }
            });
            return arrMount
        }
        else if(date<=28 && !isStart){
            arrMount = arrMount.filter(function(item){
                if(item >= mount1){
                    return item;
                }
            });
            return arrMount
        }
        if(isStart) {

            arrMount =  arrMount.filter(function(item){
                if(item < parseInt(mount2)){
                    // console.log(item+" "+mount2)
                    return item;
                }
            });
        }
        else{
            arrMount = arrMount.filter(function(item){
                if(item >= mount1){
                    return item;
                }

            });

        }


        if(date>28){
            for(i = 0 ; i < 12 ; i++){
                if(arrMount[i] == 2){
                    arrMount[i] = undefined
                }
            }
        }
        if(date>30){
            for(i = 0 ; i < 12 ; i++){
                if(arrMount[i] == 4 || arrMount[i] == 6 || arrMount[i] == 9 || arrMount[i] == 11){
                    arrMount[i] = undefined
                }
            }
        }

        return arrMount;
    }
    function getTextYearMount(text_mount,text_mount2,text_date,text_date2){
        let text = ` <label for=""  class="">ตั้งแต่</label>
                    <div class="inner-MY">
                        <p for=""  class="">เดือน</p>
                        <select id="M1" class="form-control ">
                            ${text_mount}
                        </select>
                        <p for=""  class="">วันที่</p>
                        <select id="D1" class="form-control ">
                            ${text_date}
                        </select>
                    </div>
                    <label for=""  class="">ถึง</label>
                    <div class="inner-MY">
                        <p for=""  class="">เดือน</p>
                        <select id="M2" class="form-control ">
                            ${text_mount2}
                        </select>
                        <p for=""  class="">วันที่</p>
                        <select id="D2" class="form-control ">
                            ${text_date2}
                        </select>     
                    </div>`;
        return text
    }
    function setInputYearMount(arrMount1,arrDate1,arrMount2,arrDate2){
        let mount  = {1:"มกราคม",2:"กุมภาพันธ์",3:"มีนาคม",4:"เมษายน",5:"พฤษภาคม",6:"มิถุนายน",7:"กรกฎาคม",8:"สิงหาคม",9:"กันยายน",10:"ตุลาคม",11:"พฤศจิกายน",12:"ธันวาคม"};
        let radio =  $("#add-mount-year");
        let text_date,text_date2,text_mount,text_mount2
        for(i in arrMount1){
            if(arrMount1[i]!=undefined)
                text_mount += `
                    <option value=${arrMount1[i]}>${mount[arrMount1[i]]}</option>
                `
        }
        for(i in [...Array(arrDate1[1]+1).keys()]){
            if(i>=arrDate1[0]){
                text_date += `
                    <option value=${i}>${i}</option>
            `
            }
        }
        for(i in arrMount2){
            if(arrMount2[i]!=undefined)
                text_mount2 += `
                    <option value=${arrMount2[i]}>${mount[arrMount2[i]]}</option>
                `
        }
        for(i in [...Array(arrDate2[1]+1).keys()]){
            if(i>=arrDate2[0]){
                text_date2 += `
                    <option value=${i}>${i}</option>
            `
            }
        }
        let text = getTextYearMount(text_mount,text_mount2,text_date,text_date2)
        radio.html(text)

    }
    function setInputAll(m1,m2,d1,d2){
        $('#M1').val(m1)
        $('#M2').val(m2)
        $('#D1').val(d1)
        $('#D2').val(d2)
    }
    $(document).on('change','#M1,#M2,#D1,#D2',function(){
        // alert('s')
        let d1 = parseInt($('#D1').val())
        let d2 = parseInt($('#D2').val())
        let m1 = parseInt($('#M1').val())
        let m2 = parseInt($('#M2').val())
        let arrMount1 = getMountAll(d1,d2,m1,m2,true)
        let arrDate1 = getDateAll(m1,m2,d1,d2,true)
        let arrMount2 = getMountAll(d2,d1,m1,m2,false)
        let arrDate2 = getDateAll(m1,m2,d1,d2,false)
        setInputYearMount(arrMount1,arrDate1,arrMount2,arrDate2)
        setInputAll(m1,m2,d1,d2)
    })

    function inputMountYear(m1,m2,d1,d2){ // set input start end
        let arrMount1 = getMountAll(d1,d2,m1,m2,true)
        let arrDate1 = getDateAll(m1,m2,d1,d2,true)
        let arrMount2 = getMountAll(d2,d1,m1,m2,false)
        let arrDate2 = getDateAll(m1,m2,d1,d2,false)
        setInputYearMount(arrMount1,arrDate1,arrMount2,arrDate2)
        setInputAll(m1,m2,d1,d2)
        mountYearChecked = true;
    }
    function loadCondition(FID){ // load condition from database
        conditionF =  "";
        $.ajax({
            type: "POST",
            dataType: 'json',

            data: {
                request:'selectCondition',
                id:FID,
            },
            async:false,
            url: "dbF.php",
            success: function(result) {
                conditionF  =  result;
                // alert("sss")
            }
        });
    }



    function checkSameName(name,id){ // check same name

        for(i in dataF){
            console.log(dataF[i].Name);
            if(name.val().trim().replace(/\s\s+/g,' ')== dataF[i].Name && dataF[i].FID != id){
                name[0].setCustomValidity('ชื่อนี้ซ้ำ');
                return false;
            }
            else{
                name[0].setCustomValidity('');
            }
        }



        return true;

    }
    function checkSameAlias(name,id){ // check same Alias

        for(i in dataF){
            console.log(dataF[i].Alias);
            if(name.val().trim().replace(/\s\s+/g,' ')== dataF[i].Alias && dataF[i].FID != id){
                name[0].setCustomValidity('ชื่อนี้ซ้ำ')
                return false;
            }
            else{
                name[0].setCustomValidity('');
            }
        }



        return true;

    }
    function startInputNum(selecter){
        let re = /^([ก-ไ๑-๙A-Za-z0-9])/
        // let re
        for(i in selecter){
            if(!(re.test(selecter[i].val().trim()))){
                selecter[i][0].setCustomValidity('ต้องขึ้นต้นด้วยตัวอักษร');
                return true;
            }
            else{
                selecter[i][0].setCustomValidity('');
            }
        }
        return false
    }
    function checkNull(selecter){  // check name null

        for( i in selecter){
            if(selecter[i].val() == ''){
                console.log('key')
                selecter[i][0].setCustomValidity('กรุณากรอกข้อมูล');
                return false;
            }else  selecter[i][0].setCustomValidity('');
        }

        return true;
    }
    function checkNegative(selecter){ // check negative
        for( i in selecter){
            if(selecter[i].val() < 0){
                selecter[i][0].setCustomValidity('ค่าต้องไม่ติดลบ');
                return false;
            }
            else  selecter[i][0].setCustomValidity('');
        }
        return true;
    }
    function cropImage(input,imgCrop,imgOutput){
        let rawImg
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                rawImg = e.target.result;
                check_II = true;
                loadIm(rawImg,imgCrop,imgOutput);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $('.divCrop').hide()
    $('.buttonCrop').hide()
    function loadIm(rawImg,imgCrop,imgOutput){
        $('.divName').hide()
        $('.divHolder').hide()
        $('.divCrop').show()
        $('.buttonCrop').show()
        $('.buttonSubmit').hide()
        let $uploadCrop = $(imgCrop).croppie({
            viewport: {
                width: 200,
                height: 200,
                type:'circle'
            },
            enforceBoundary: false,
            enableExif: true
        });
        $uploadCrop.croppie('bind', {
            url: rawImg
        }).then(function(){
            console.log('jQuery bind complete');
        });
        $(imgOutput).val('');

    }
    $(document).on('change','.item-img', function () {
        cropImage(this,'#upload-demo','.item-img')

    });
    $(document).on('click','#cropImageBtn', function (ev) {

        $('#upload-demo').croppie('result',
            {type:'canvas',size:'viewport'})
            .then(function(r) {
                $('.buttonSubmit').show()
                $('.divName').show()
                $('.buttonCrop').hide()
                $('.divHolder').show()
                $('#img-insert').attr('src', r);
                $('.divCrop').hide()
            });
        $('#upload-demo').croppie('destroy')

    });
    $(document).on('click','#cancelCrop',function(){
        $('#upload-demo').croppie('destroy')
        $('.divName').show()
        $('.divHolder').show()
        $('.divCrop').hide()
        $('.buttonCrop').hide()
        $('.buttonSubmit').show()
        // $('#img-insert').attr('src', "https://via.placeholder.com/200x200.png");
    })
    $('.divCU').hide()
    $('.divBCU').hide()
    let IMG;
    let UC;
    function IU(){

        $('.divU').hide()
        $('.divBU').hide()
        $('.divCU').show()
        $('.divBCU').show()
        // $('.UI').append(`<div id="upload-demo" class="center-block"></div>`)
        UC = $('#upload-demo2').croppie({
            viewport: {
                width: 200,
                height: 200,
                type:'circle'
            },
            enforceBoundary: false,
            enableExif: true
        });
        UC.croppie('bind', {
            url: IMG
        }).then(function(){
            console.log('jQuery bind complete');
        });
        $('#iconF').val('');
    }
    $(document).on('change','#iconF', function () {

        let input = this

        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                IMG = e.target.result;
                IU()
                check_IU = true;
            }
            reader.readAsDataURL(input.files[0]);
        }
        else {
            //    swal("Sorry - you're browser doesn't support the FileReader API");
        }

    });
    $(document).on('click','#cropImageBtn2', function (ev) {

        $('#upload-demo2').croppie('result',
            {type:'canvas',size:'viewport'})
            .then(function(r) {
                $('.divU').show()
                $('.divBU').show()
                $('.divCU').hide()
                $('.divBCU').hide()
                $('#img-update').attr('src', r);
            });
        $('#upload-demo2').croppie('destroy')

    });
    $(document).on('click','#cancelCrop2',function(){
        $('#upload-demo2').croppie('destroy')
        $('.divU').show()
        $('.divBU').show()
        $('.divCU').hide()
        $('.divBCU').hide()
    })
    $(document).on('click','.deleteF',function(){
        delClick($(this))
    })
    function delClick(me){
        let id = me.attr('id');
        let name = me.attr('data-name')
        let dimid = me.attr('DIMID')
        swal({
            title: "คุณต้องการลบ",
            text: "ปุ๋ย "+name+" หรือไม่?",
            icon: "warning",
            dangerMode: true,
            confirmButtonColor:'red',
            buttons: {
                confirm:"ยืนยัน",
                cancel:"ยกเลิก"
            },
            closeOnConfirm: false,
        })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        type: "POST",
                        data: {
                            request:'delete',
                            id:id,
                            dimid:dimid
                        },
                        async:false,
                        url: "dbF.php",
                        success: function(result) {
                            // alert(result)
                            loadDataF(result)
                            // alert("sss")
                        }
                    });
                    swal("ปุ๋ย " +me.attr('data-name') +" ถูกลบเรียบร้อย", {
                        icon: "success",
                        button:"เรียบร้อย"

                    });
                } else {
                    swal("ปุ๋ย " +me.attr('data-name') +" ปุ๋ยไม่ถูกลบ",{
                            button:"ตกลง"
                        }
                    );
                }
            })

    }
})