/*function map_create()
{
    var startLatLng = new google.maps.LatLng(13.736717, 100.523186);
    
    var map = new google.maps.Map(document.getElementById('map_area'), {
        // center: { lat: 13.7244416, lng: 100.3529157 },
        center:  startLatLng ,
        zoom: 8,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    map.markers = [];
    marker = new google.maps.Marker({
        position: new google.maps.LatLng(13.736717, 100.523186),
        map: map,
        title:"test"
    });
    map.markers.push(marker);
    marker = new google.maps.Marker({
        position: new google.maps.LatLng(13.814029, 100.037292),
        map: map,
        title:"test"
    });
    map.markers.push(marker);
    marker = new google.maps.Marker({
        position: new google.maps.LatLng(13.361143, 100.984673),
        map: map,
        title:"test"
    });
    map.markers.push(marker);

    var citymap = {
        chicago: {
          center: {lat: 13.736717, lng: 100.523186},
          population: 90000,
          color: '#e74a3b'
        },
        newyork: {
          center: {lat: 13.814029, lng: 100.037292},
          population: 90000,
          color: '#f6c23e'
        },
        losangeles: {
          center: {lat: 13.361143, lng: 100.984673},
          population: 90000,
          color: '#1cc88a'
        },
      };

    for (var city in citymap) {
        // Add the circle for this city to the map.
        var cityCircle = new google.maps.Circle({
          strokeColor: citymap[city].color,
          strokeOpacity: 0.8,
          strokeWeight: 2,
          fillColor: citymap[city].color,
          map: map,
          center: citymap[city].center,
          radius: Math.sqrt(citymap[city].population) * 100
        });
      }


}

$("#palmvolsilder").ionRangeSlider({
    type: "double",
    grid: true,
    from: 1,
    to: 5,
    values: [0, 10, 100, 1000, 10000, 100000, 1000000]
});*/
/*
// LoadMap
function initMap() {
  // The location of Uluru
  //alert(coordinate[0].lat);
  var marker = {
      lat: 12.815300,
      lng: 101.490997
  };

  // The map, centered at Uluru
  var map = new google.maps.Map(
      document.getElementById('map'), {
          zoom: 16,
          center: marker
      });
  // The marker, positioned at Uluru
  var marker = new google.maps.Marker({
      position: marker,
      map: map
  });
  // Construct the polygon.
  var area = new google.maps.Polygon({
      paths: zone,
      strokeColor: '#FF0000',
      strokeOpacity: 0.8,
      strokeWeight: 2,
      fillColor: '#FF0000',
      fillOpacity: 0.35
  });
  area.setMap(map);
}

let dataProvince;
let dataDistrinct;
let numProvince = 0;
let data;

let year = null;
let score_From = 0;
let score_To = 0;
let ID_Province = null;
let ID_Distrinct = null;
let name = null;
let passport = null;

$("#palmvolsilder").ionRangeSlider({
  type: "double",
  from: 0,
  to: 0,
  step: 1,
  min: 0,
  max: 100,
  grid: true,
  grid_num: 10,
  grid_snap: false,
  onFinish: function(data) {
      score_From = data.from;
      score_To = data.to;
      console.log(score_From + " " + score_To);
  }
});

document.getElementById("province").addEventListener("load", loadProvince());

// โหลดจังหวัด
function loadProvince() {
  let xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
          dataProvince = JSON.parse(this.responseText);
          let text = "";
          for (i in dataProvince) {
              text += ` <option value="${dataProvince[i].AD1ID}">${dataProvince[i].Province}</option> `
              numProvince++;
          }
          $("#province").append(text);

      }
  };
  xhttp.open("GET", "./loadProvince.php", true);
  xhttp.send();
}
// โหลดอำเภอ
function loadDistrinct(id) {
  let xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
          dataDistrinct = JSON.parse(this.responseText);
          let text = "<option disabled selected>เลือกอำเภอ</option>";
          for (i in dataDistrinct) {
              text += ` <option value="${dataDistrinct[i].AD2ID}">${dataDistrinct[i].Distrinct}</option> `
          }
          $("#amp").append(text);
      }
  };
  xhttp.open("GET", "./loadDistrinct.php?id=" + id, true);
  xhttp.send();
}

$("#province").on('change', function() {
  $("#amp").empty();
  let x = document.getElementById("province").value;
  for (let i = 0; i < numProvince; i++)
      if (dataProvince[i].AD1ID == x) {
          ID_Province = x;
          ID_Distrinct = null;
          loadDistrinct(dataProvince[i].AD1ID);
      }
});

$("#amp").on('change', function() {
  let x = document.getElementById("amp").value;
  ID_Distrinct = x;
});

$("#btn_search").on('click', function() {
  year = document.getElementById("year").value;
  name = document.getElementById("name").value;
  passport = document.getElementById("idcard").value;
  console.log(" [ " + year + " " + score_From + " " + score_To +
      " " + ID_Province + " " + ID_Distrinct + " " + name + " " + passport + " ] ");
  loadData();
});*/


  //ผลผลิตรายเดือน
  function loadYear() {
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            $("#card-productPerYear").append(text);
        }
    };
    xhttp.open("POST", "./getProductPerYear.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(`year=${_year}`);
}
  function makeTable(result){
    let text = ''
    for(i in result){
      text += `<tr>
                  <td>${result[i].alias}</td>
                  <td>${result[i].modifyday} / ${result[i].modifymonth} / ${result[i].modifyyear}</td>
                  <td style="text-align:right;">${result[i].weight}</td>
                  <td style="text-align:right;">${result[i].price}</td>
                  <td style="text-align:right;">${result[i].totalprice}</td>
                  <td style="text-align:center;">
                    <button type="button" class="btn btn-info btn-sm picture" data-fid="${result[i].ID}" data-toggle="tooltip" title="รูปภาพ" ><i class="fas fa-images"></i></button>
                    <button type="button" class="btn btn-danger btn-sm delete" data-fid="${result[i].ID}"  data-alias = "${result[i].alias}" data-toggle="tooltip" title="ลบ" ><i class="far fa-trash-alt"></i></button>
                  </td>
                </tr>`
    }
    $('#table').html(text)
  }

  function rightbox(result){
  
    let year = parseInt(result[0].modifyyear)
    let weight = 0
    let price = 0
    for(i in result){
      weight = parseFloat(weight) + parseFloat(result[i].weight)
      price = parseFloat(price) + parseFloat(result[i].totalprice)
    }
    weight=weight.toFixed(1)
    price=price.toFixed(2)
    // text += weight 
    $('#sumyear').html(year)
    $('#sumweight').html(weight)
    $('#sumprice').html(price)
  }

  function leftgraph(result){
    $('.productMonth').html(` <canvas id="productMonth" style="height:200px;"></canvas>`)
    let year = result[i].modifyyear;
    let data = [0,0,0,0,0,0,0,0,0,0,0,0]
    let text = ''
    let weight = 0
    let x = countObject(result);
    for(let i = 0 ; i < x ; i++){
      if(result[i] != undefined){
        weight = parseFloat(result[i].weight)
        data[parseInt(result[i].modifymonth)-1] = parseFloat(data[parseInt(result[i].modifymonth)-1]) + weight
      }
      // if(result[i]!=undefined){
      //   data.push(result[i].modifymonth)
      //  if(year!=undefined)
      //     year = (result[i].modifyyear)-1
      // }
      // else data.push(0)
    }

      $('#productMonth').html(text)
      var chartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        legend: {
          display: true,
          position: 'top',
          labels: {
            boxWidth: 80,
            fontColor: 'black'
          }
        },
        scales: {
          yAxes: [{
            scaleLabel: {
              display: true,
              labelString: 'ผลผลิต (ก.ก.)'
            },
            gridLines: {
                display:true
            }
          }],
          xAxes: [{
            scaleLabel: {
              display: true,
              labelString: 'รายเดือน'
            },
            gridLines: {
                display:false
            }
          }],
        }
      };
    
      var speedData = {
    
        labels: ["ม.ค.", "ก.พ.", "มี.ค.", 
                "เม.ย", "พ.ค.", "มิ.ย.",
                "ก.ค.", "ส.ค.", "ก.ย.",
                "ต.ค.", "พ.ย.", "ธ.ค."],
        datasets: [{
    
          label: "ปี "+year,
          data:data,
          backgroundColor: '#05acd3'
        }]
      };
    
        var ctx = $("#productMonth");
        var plantPie = new Chart(ctx, {
            type: 'bar',
            data: speedData,
            options: chartOptions
        });
  }

  function countObject(object){
    var length = 0;
    for( var key in object ) {
        if( object.hasOwnProperty(key) ) {
            ++length;
        }
    }
    return length;
  }


  $(document).ready(function () {
    var d = new Date();
    var n = d.getFullYear()+543-1;
    loadChart(n)
    function loadChart(year){
      $.ajax({
        type: "POST",
        datatype: 'json',
        url: "manage.php",
        data: {
          year:year,
          // year:2562,
          request:'getYear'
        },
        async: false,
        success: function (result) {
          // let a = "{a:'p'}"
          // a = JSON.parse(a)
          console.log(result)
          result = JSON.parse(result)
            makeTable(result)
            rightbox(result)
            leftgraph(result)
          // alert(result[0].ID)
        }
      })
    }
    $(document).on('change', '#productPerYear', function () {
     loadChart( $(this).val())
    });
    
    //ปุ่ม
    $(document).on('click','.delete',function(){
      delfunction($(this).attr('data-fid'),$(this).attr('data-alias'))
    })

    $(document).on('click','.picture',function(){
      $("#imageModal").modal();
    })
    
    function delfunction(fid,alias) {
      swal({
              title: "คุณต้องการลบ",
              text: `"ผลผลิตแปลง ${alias} หรือไม่ ?"`,
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
                      console: "Delete",
                      title: "ลบข้อมูลสำเร็จ",
                      type: "success",
                      confirmButtonClass: "btn-danger",
                      confirmButtonText: "ตกลง",
                      closeOnConfirm: false,
                  }, function(isConfirm) {
                      if (isConfirm) {
                        delete_1(fid);
                      }
                  });
              } else {
                
              }
          });
      }
      function delete_1(fid) {
      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            console.log("delete_1");
            window.location.href = 'OilPalmAreaVolDetail.php';
            // alert(this.responseText);
          }
      };
      xhttp.open("POST", "manage.php", true);
      xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhttp.send(`request=update&fid=${fid}`);
      
      }

  
    $('.btn_image').click(function(){
        $("#imageModal").modal();
        var fid = $(this).attr('fid'); 
        $('')
    });

    $("#btn_add_product").click(function () {
      $("body").append(addProductModal);
      $("#addProductModal").modal();
    });



    //การกรอกข้อมูล
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

    $('#save').click(function(){
      // console.log("save");
      let FarmID = $("input[name = 'SubFarmID']");
      let weight = $("input[name = 'weight']");
      let UnitPrice = $("input[name = 'UnitPrice']");
      let data = [weight,UnitPrice];

      if(!checkEmpty(data)) return;
      if(!checkMinus(data)) return;
      if(!checkzero(data)) return;
      if(!checkDupicate(data)) return;
      if(!checkSameChar(weight)) return;
      if(!checkSameChar(UnitPrice)) return;

    }) 

    function checkMinus(selecter)
    {
      for( i in selecter){
        if(selecter[i].val() < 0){
            selecter[i][0].setCustomValidity('ค่าต้องไม่ติดลบ');
            return false;
        }
        else  selecter[i][0].setCustomValidity('');
      }
        return true;
    }
    function checkzero(selecter)
    {
      for( i in selecter){
        if(selecter[i].val() == 0){
            selecter[i][0].setCustomValidity('กรุณาใส่ค่าที่ไม่ใช่ 0');
            return false;
        }
        else  selecter[i][0].setCustomValidity('');
      }
        return true;
    }
    function checkFuture(selecter)
    {
      var d = new Date()
      var thisyear = d.getFullYear()+543
      var thismonth = d.getMonth()+1
      var thisday = d.getDay()
      for( i in selecter){
        if(selecter[i].val() > thisyear ){
            selecter[i][0].setCustomValidity('ไม่สามารถบันทึกข้อมูลในอนาคต');
            return false;
        }
        else  selecter[i][0].setCustomValidity('');
      }
        return true;
    }
    function checkDupicate(data)
    {
      pullData()
      for(i in dataD){
        if(checkName(name) && checkYear(name) && checkPrice(name) && checkWeight(name)){
            name[0].setCustomValidity('ข้อมูลซ้ำ');
            return false;
        }
        else{
            name[0].setCustomValidity('');
        }
    }

    return true;
    }
    function checkEmpty(selecter)
    {
      for(i in selecter){
        if(selecter[i].val().trim() == ''){
            selecter[i][0].setCustomValidity('กรุณากรอกข้อมูล');
            return false;
        }else{
            selecter[i][0].setCustomValidity('');
        }            
    }
    return true;
    }
    function checkSameChar(selecter)
    {
      for(i in selecter){
        if(selecter[i].val){
          selecter[i][0].setCustomValidity('อักษรพิเศษซ้ำ');
          return false;
        }else{
          selecter[i][0].setCustomValidity('');
        } 
      }
    }

    function checkName(name)
    {
      for(i in dataD){
        console.log(dataD[i].Name);
        if(name.val().trim() == dataD[i].DIMsubFID ){
            name[0].setCustomValidity('');
            return false;
        }
        else{
            name[0].setCustomValidity('');
        }
      }
      return true;
    }
    function checkYear(name)
    {
      for(i in dataD){
        console.log(dataD[i].Name);
        if(name.val().trim() == dataD[i].Modify ){
            name[0].setCustomValidity('');
            return false;
        }
        else{
            name[0].setCustomValidity('');
        }
      }
      return true;
    }
    function checkPrice(name)
    {
      for(i in dataD){
        console.log(dataD[i].Name);
        if(name.val().trim() == dataD[i].UnitPrice ){
            name[0].setCustomValidity('');
            return false;
        }
        else{
            name[0].setCustomValidity('');
        }
      }
      return true;
    }
    function checkWeight(name)
    {
      for(i in dataD){
        console.log(dataD[i].Name);
        if(name.val().trim() == dataD[i].Weight ){
            name[0].setCustomValidity('');
            return false;
        }
        else{
            name[0].setCustomValidity('');
        }
      }
      return true;
    }

    
  });
