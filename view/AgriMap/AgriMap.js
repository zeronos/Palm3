
  function initMap() {
    // The location of Uluru
    var uluru = {
        lat: 15.076367,
        lng: 101.006522
    };
    // The map, centered at Uluru
    var map = new google.maps.Map(
        document.getElementById('map'), {
            zoom: 4,
            center: uluru
        });
    // The marker, positioned at Uluru
    var marker = new google.maps.Marker({
        position: uluru,
        map: map
    });
}

/*$('#fertilizer_check').change(function(){
    if($('#fertilizer_check').is(':checked'))
    {
        $("#fertilizer").prop('disabled', false);

    }
    else
    {
        $("#fertilizer").prop('disabled', true);

    }
    

})

$('#product_check').change(function(){
    if($('#product_check').is(':checked'))
    {
        $("#product").prop('disabled', false);

    }
    else
    {
        $("#product").prop('disabled', true);

    }
    

})*/
