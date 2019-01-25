/*
 *  * @author Robert Mark Williamson <robert@peasoup-development.com>
 *  * @company Peasoup Development Limited
 *
 */

define(["jquery","storesModel", 'ko'], function ($,storesModel,ko) {

    "use strict";

    var map;

    var radiusCircle;

    var markers = new Array();

    var myLatLng = {lat: 1, lng: 1};

    var defaultZoom = 14;

    var circleExists = 0;

    var geocoder;



    $.widget('storefinder.googleMap', {

        _create: function () {
            var long =  $("[name='mapsettings[longitude]']").val();
            var lat =  $("[name='mapsettings[latitude]']").val();
            if( long!="" && lat!=""){
                myLatLng = {lat: parseFloat(lat), lng: parseFloat(long)};
            }
            this._createMap();
            this._addMarkers(myLatLng);
            this._postcodeButtonListener();
        },

        _postcodeButtonListener: function(){
            self = this;
            $( document ).on( "click", "#postcodeButton", function() {
                var postcode = $("[name='mapsettings[postcodeSearch]']").val();
                self._getPostCodeLatLang(postcode);
            });
        },


        _createMap: function() {
            self = this;
            map = new google.maps.Map(document.getElementById('map'), {
                center: myLatLng,
                styles:[ { "elementType": "geometry", "stylers": [ { "color": "#f5f5f5" } ] }, { "elementType": "labels.icon", "stylers": [ { "visibility": "off" } ] }, { "elementType": "labels.text.fill", "stylers": [ { "color": "#616161" } ] }, { "elementType": "labels.text.stroke", "stylers": [ { "color": "#f5f5f5" } ] }, { "featureType": "administrative.land_parcel", "elementType": "labels.text.fill", "stylers": [ { "color": "#bdbdbd" } ] }, { "featureType": "administrative.province", "elementType": "geometry", "stylers": [ { "color": "#718593" } ] }, { "featureType": "landscape.natural.terrain", "elementType": "geometry", "stylers": [ { "color": "#e5e7d1" } ] }, { "featureType": "poi", "elementType": "geometry", "stylers": [ { "color": "#afd2aa" } ] }, { "featureType": "poi", "elementType": "labels.text.fill", "stylers": [ { "color": "#757575" } ] }, { "featureType": "poi.park", "elementType": "geometry", "stylers": [ { "color": "#b7d9ba" } ] }, { "featureType": "poi.park", "elementType": "labels.text.fill", "stylers": [ { "color": "#545454" } ] }, { "featureType": "road", "elementType": "geometry", "stylers": [ { "color": "#ffffff" } ] }, { "featureType": "road.arterial", "elementType": "geometry", "stylers": [ { "color": "#e1c99d" }, { "visibility": "simplified" }, { "weight": 1 } ] }, { "featureType": "road.arterial", "elementType": "labels.text.fill", "stylers": [ { "color": "#757575" } ] }, { "featureType": "road.highway", "stylers": [ { "visibility": "simplified" } ] }, { "featureType": "road.highway", "elementType": "geometry", "stylers": [ { "color": "#daba95" } ] }, { "featureType": "road.highway", "elementType": "labels.text.fill", "stylers": [ { "color": "#616161" } ] }, { "featureType": "road.local", "elementType": "geometry", "stylers": [ { "color": "#f3d39b" }, { "visibility": "simplified" }, { "weight": 1 } ] }, { "featureType": "road.local", "elementType": "labels.text.fill", "stylers": [ { "color": "#9e9e9e" } ] }, { "featureType": "transit.line", "elementType": "geometry", "stylers": [ { "color": "#e5e5e5" } ] }, { "featureType": "transit.station", "elementType": "geometry", "stylers": [ { "color": "#eeeeee" } ] }, { "featureType": "water", "elementType": "geometry", "stylers": [ { "color": "#9bb3bd" } ] }, { "featureType": "water", "elementType": "labels.text.fill", "stylers": [ { "color": "#ffffff" } ] } ],
                zoom: defaultZoom
            });
        },

        _getPostCodeLatLang: function(postCodeIn = null) {
            self = this;
            geocoder = new google.maps.Geocoder();
            var postcode = postCodeIn

            geocoder.geocode({
                componentRestrictions: {
                    country: 'GB',
                    postalCode: postcode
                }
            }, function(results, status) {
                if (status == 'OK') {
                    var longitudelocation = results[0].geometry.location.lng();
                    var latitudelocation = results[0].geometry.location.lat();
                    var locationLatLang = {lat: latitudelocation.toFixed(6), lng:longitudelocation.toFixed(6)};
                    self._clearMarkers();
                    self._addMarkers(locationLatLang);
                    self._setMapCenter(locationLatLang);
                    self._updateForm(locationLatLang);

                }
            });
        },

        _removeRadiusCircle: function() {
            this.radiusCircle.setMap(null);
        },


        _clearMarkers: function() {
            for(var i=0; i < markers.length; i++) {
                markers[i].setMap(null);
            }
            markers = [];
        },


        _addMarkers: function(data) {

            var marker = new google.maps.Marker({
                position: new google.maps.LatLng(data.lat, data.lng),
                map: map,
                draggable: true,

            });
            markers.push(marker);
            var infoWindow = this._addInfoWindow(marker, data);
            this._getInfoWindowContent(infoWindow, data);
            this._setMarkerListener(marker);
        },


        _setMarkerListener: function(markerobject) {
            google.maps.event.addListener(markerobject, 'dragend', function(evt){
                $("[name='mapsettings[longitude]']").val(evt.latLng.lng().toFixed(6)).trigger( "change" ) ;
                $("[name='mapsettings[latitude]']").val(evt.latLng.lat().toFixed(6)).trigger( "change" ) ;

            });

        },

        _updateForm: function(data) {
            $("[name='mapsettings[longitude]']").val(data.lng).trigger( "change" )
            $("[name='mapsettings[latitude]']").val(data.lat).trigger( "change" ) ;
        },

        _setMapCenter: function(data) {
            map.setCenter(new google.maps.LatLng(data.lat, data.lng));
        },

        _addInfoWindow: function(marker,data) {
            var infowindow = new google.maps.InfoWindow({
                content: data.name
            });
            marker.addListener('click', function() {
                infowindow.open(map, marker);
            });
            return infowindow;
        },

        _getInfoWindowContent: function(infoWindow,data){

        },

    });

    return $.storefinder.googleMap;
});
