// LoadMap

let dataProvince;
let dataDistrinct;
let numProvince = 0;
let score_From = 0;
let score_To = 0;
let ID_Province = null;
let ID_Distrinct = null;
let name = null;
let FormalID = null;

document.getElementById("province").addEventListener("load", loadProvince());

// โหลดจังหวัด
function loadProvince() {
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            data = JSON.parse(this.responseText);
            console.table(data);
            let text = "<option value='0'>เลือกจังหวัด</option> ";
            for (i in data) {
                text += ` <option value='${data[i].AD1ID}'>${data[i].Province}</option> `
            }
            $("#province").append(text);

        }
    };
    xhttp.open("GET", "./loadProvince.php", true);
    xhttp.send();
}
// โหลดอำเภอ

$("#province").on('change', function() {
    $("#amp").empty();
    let x = document.getElementById("province").value;
    let y = document.getElementById("province");
    if (y.length == 78)
        y.remove(0);
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {

        if (this.readyState == 4 && this.status == 200) {
            data = JSON.parse(this.responseText);
            console.table(data);
            let text = "<option value='0' >เลือกอำเภอ</option>";
            for (i in data) {
                text += ` <option value ='${data[i].AD2ID}'>${data[i].Distrinct}</option> `
            }
            $("#amp").append(text);
        }
    };
    xhttp.open("GET", "./loadDistrinct.php?id=" + x, true);
    xhttp.send();
});

$("#btn_search").on('click', function() {
    let text = ""
    $("#example1").DataTable().destroy();
    ID_Province = document.getElementById("province").value;
    ID_Distrinct = document.getElementById("amp").value;
    name = document.getElementById("name").value;
    FormalID = document.getElementById("FormalID").value;
    document.getElementById("province").value = '0';
    document.getElementById("amp").value = '0';
    document.getElementById("name").value = "";
    document.getElementById("FormalID").value = "";
    if (ID_Province != 0) {
        text += "&province=" + ID_Province;
    }
    if (ID_Distrinct != 0) {
        text += "&amp=" + ID_Distrinct;
    }
    if (name != "") {
        text += "&name=" + name;
    }
    if (FormalID != "") {
        text += "&FormalID=" + FormalID;
    }

    console.log('search=search' + text);
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            data = JSON.parse(this.responseText);

            let text = "";

            for (i in data) {
                let a = data[i].Name;
                text += `<tr>
                            <td>${data[i].Province}</td>
                            <td>${data[i].Distrinct}</td>
                            <td>${data[i].Alias}</td>
                            <td>${data[i].Name}</td>
                            <td>${data[i].NumSubFarm}</td> 
                            <td>${data[i].AreaRai}</td>
                            <td>${data[i].NumTree}</td>
                            <td style='text-align:center;'>
                                <a href='OilPalmAreaListDetail.php?id=${data[i].Name}&fname=${data[i].Alias}&fmid=${data[i].FMID}&logid=${data[i].ID}'><button type='button' id='btn_info' class='btn btn-info btn-sm'><i class='fas fa-bars'></i></button></a>
                                <button type='button' id='btn_delete' class='btn btn-danger btn-sm' onclick="delfunction('${data[i].Name}' , '${data[i].FMID}')"><i class='far fa-trash-alt'></i></button>
                            </td>
                        </tr> `;

            }
            $("#getData").html(text);
            $('#example1').DataTable();
        }
    };
    xhttp.open("POST", "./manage.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send('search=search' + text);
});