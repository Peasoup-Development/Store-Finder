define(['jquery'], function ($) {

    var initMap = function(config)
    {
        var myLatLngdef = {lat:parseFloat(config[0]['latitude']), lng:parseFloat(config[0]['longitude']) };

        var map = new google.maps.Map(document.getElementById('map'), {
            zoom:8,
            styles:[ { "elementType": "geometry", "stylers": [ { "color": "#f5f5f5" } ] }, { "elementType": "labels.icon", "stylers": [ { "visibility": "off" } ] }, { "elementType": "labels.text.fill", "stylers": [ { "color": "#616161" } ] }, { "elementType": "labels.text.stroke", "stylers": [ { "color": "#f5f5f5" } ] }, { "featureType": "administrative.land_parcel", "elementType": "labels.text.fill", "stylers": [ { "color": "#bdbdbd" } ] }, { "featureType": "administrative.province", "elementType": "geometry", "stylers": [ { "color": "#718593" } ] }, { "featureType": "landscape.natural.terrain", "elementType": "geometry", "stylers": [ { "color": "#e5e7d1" } ] }, { "featureType": "poi", "elementType": "geometry", "stylers": [ { "color": "#afd2aa" } ] }, { "featureType": "poi", "elementType": "labels.text.fill", "stylers": [ { "color": "#757575" } ] }, { "featureType": "poi.park", "elementType": "geometry", "stylers": [ { "color": "#b7d9ba" } ] }, { "featureType": "poi.park", "elementType": "labels.text.fill", "stylers": [ { "color": "#545454" } ] }, { "featureType": "road", "elementType": "geometry", "stylers": [ { "color": "#ffffff" } ] }, { "featureType": "road.arterial", "elementType": "geometry", "stylers": [ { "color": "#e1c99d" }, { "visibility": "simplified" }, { "weight": 1 } ] }, { "featureType": "road.arterial", "elementType": "labels.text.fill", "stylers": [ { "color": "#757575" } ] }, { "featureType": "road.highway", "stylers": [ { "visibility": "simplified" } ] }, { "featureType": "road.highway", "elementType": "geometry", "stylers": [ { "color": "#daba95" } ] }, { "featureType": "road.highway", "elementType": "labels.text.fill", "stylers": [ { "color": "#616161" } ] }, { "featureType": "road.local", "elementType": "geometry", "stylers": [ { "color": "#f3d39b" }, { "visibility": "simplified" }, { "weight": 1 } ] }, { "featureType": "road.local", "elementType": "labels.text.fill", "stylers": [ { "color": "#9e9e9e" } ] }, { "featureType": "transit.line", "elementType": "geometry", "stylers": [ { "color": "#e5e5e5" } ] }, { "featureType": "transit.station", "elementType": "geometry", "stylers": [ { "color": "#eeeeee" } ] }, { "featureType": "water", "elementType": "geometry", "stylers": [ { "color": "#9bb3bd" } ] }, { "featureType": "water", "elementType": "labels.text.fill", "stylers": [ { "color": "#ffffff" } ] } ],
            center: myLatLngdef,
            mapTypeId: 'roadmap'
        });

        for(var i =0;i<config.length;i++){
            var myLatLng = {lat:parseFloat(config[i]['latitude']), lng:parseFloat(config[i]['longitude']) };
            var marker = new google.maps.Marker({
                position: myLatLng,
            });
            marker.setMap(map);
        }
    };

    return initMap;
});