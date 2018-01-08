var mapLoaded = false, map, marker;

function googlemaps(latitude,longitude) {

	if (latitude == 0 || longitude == 0 || latitude == null || longitude == null) {
		latitude = 27.6787735585;
		longitude = 85.3132359682;
	}	

	if (mapLoaded == true) {
		var newLatLng = new google.maps.LatLng(latitude, longitude);
		marker.setPosition(newLatLng);
		map.setCenter(newLatLng);
		map.setZoom(17);
		return;
	}

	$("#latitude").jqxNumberInput('val', latitude);
	$("#longitude").jqxNumberInput('val', longitude);

	mapLoaded = true;
    if (typeof navigator.geolocation == "undefined") {
      $("#error").text("Your browser doesn't support the Geolocation API");
      return;
    }

	var latLng = new google.maps.LatLng(latitude, longitude);
	var myOptions = {
		zoom: 17,
	    center: latLng,
	    mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	map = new google.maps.Map(document.getElementById("mapCanvas"), myOptions);

	input = document.getElementById('pac-input');
	map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

	autocomplete = new google.maps.places.Autocomplete(input);
  	autocomplete.bindTo('bounds', map);

  	marker = new google.maps.Marker({
		position: latLng,
		map: map,
		draggable: true
	});

  	autocomplete.addListener('place_changed', function() {
    	var place = autocomplete.getPlace();
    
    	if (!place.geometry) {
      		window.alert("Autocomplete's returned place contains no geometry");
      		return;
    	}

    	map.setCenter(place.geometry.location);
		$("#latitude").jqxNumberInput('val', place.geometry.location.lat());
		$("#longitude").jqxNumberInput('val', place.geometry.location.lng());

    	map.setZoom(17);
		marker.setPosition(place.geometry.location);
		marker.setVisible(true);
    });

	google.maps.event.addListener(marker, 'dragend', function (event) {
       $("#latitude").jqxNumberInput('val', event.latLng.lat());
       $("#longitude").jqxNumberInput('val', event.latLng.lng());
    });
};


$(function() {
	$('#latitude, #longitude').on('change', function (event) {
    	var value = event.args.value;
    	googlemaps($('#latitude').jqxNumberInput('val'), $('#longitude').jqxNumberInput('val'));
    });
});