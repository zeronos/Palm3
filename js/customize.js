$(".table-data").DataTable(  {
    "scrollY": "350px",
    "scrollX": "1000px",
    "scrollCollapse": true,
    "paging":         true,
    "iDisplayLength": 25,
} );

$('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
    $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
});

$(".eye-setting").click(function() {
    if($(this).hasClass('fa-eye'))
    {
        $(this).removeClass('fa-eye');
        $(this).addClass('fa-eye-slash');
    }
    else if($(this).hasClass('fa-eye-slash'))
    {
        $(this).removeClass('fa-eye-slash');
        $(this).addClass('fa-eye');
    }

    let inputThis = $(".input-setting");
    let inputNext = $(".input-setting").next();
    for(let i = 0; i < inputNext.length; i++)
    {
        if($(inputNext[i]).hasClass('fa-eye'))
        {
            $(inputThis[i]).prop("type", "text");
        }
        else if($(inputNext[i]).hasClass('fa-eye-slash'))
        {
            $(inputThis[i]).prop("type", "password");
        }
    }
});

$('.carousel').carousel();


var child = $($("#activityList")[0].childNodes[3].children[0].childNodes);
//console.log($("#activityList")[0])

for(let i=0 ; i < child.length; i++)
{
    if($(child[i]).hasClass('active'))
    {
        let forceShowA = $($("#activityList")[0].childNodes[1]);
        let forceShowDiv = $($("#activityList")[0].childNodes[3]);
        
        forceShowA.removeClass('collapsed');
        forceShowA.attr('aria-expanded', true);
        forceShowDiv.addClass('show');

        break;
    }
}
