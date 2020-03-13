$('#example').DataTable({
    dom: '<"row"<"col-sm-6"B>>' +
        '<"row"<"col-sm-6 mar"l><"col-sm-6 mar"f>>' +
        '<"row"<"col-sm-12"tr>>' +
        '<"row"<"col-sm-5"i><"col-sm-7"p>>',
    buttons: [{
            extend: 'excel',
            text: '<i class="fas fa-file-excel"> <font> Excel</font> </i>',
            className: 'btn btn-outline-success btn-sm export-button'
        },
        {
            extend: 'pdf',
            text: '<i class="fas fa-file-pdf"> <font> PDF</font> </i>',
            className: 'btn btn-outline-danger btn-sm export-button',
            pageSize: 'A4',
            customize: function(doc) {
                doc.defaultStyle = {
                    font: 'THSarabun',
                    fontSize: 16
                };
            }
        }
    ],
    language: {
        emptyTable: "ไม่พบข้อมูลที่ต้องการค้นหา !!"
    }
});