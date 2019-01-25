define(["jquery","storesModel", 'searchModel','ko'], function ($,storesModel,searchModel,ko) {

    "use strict";

    var map;

    var radiusCircle;

    var markers = new Array();

    var myLatLng = {lat: 52.051532, lng: -0.798881};

    var defaultZoom = 9;

    var circleExists = 0;

    var geocoder;

    var locationLatLang = {lat: 52.051532, lng: -0.798881};

    $.widget('storefinder.googleMap', {

        options: {
            fromLabel   : '[data-role=from-label]',
            toLabel     : '[data-role=to-label]',
            sliderBar   : '[data-role=slider-bar]',
            message     : '[data-role=message-box]',
            applyButton : '[data-role=apply-range]',
            messageTemplates : {
                "displayCount": '<span class="msg"><%- count %> items</span>',
                "displayEmpty": '<span class="msg-error">No items in the current range.</span>'
            }
        },

        _create: function (config) {
            this._createMap();
            this._subscribeToStoreChange();
            this._subscribeToPostCode();
            this._subscribeToSliderChange();
            this._calculateDistance();
        },

        _createMap: function() {
            self = this;
            map = new google.maps.Map(document.getElementById('map'), {
                center: myLatLng,
                styles:[ { "elementType": "geometry", "stylers": [ { "color": "#f5f5f5" } ] }, { "elementType": "labels.icon", "stylers": [ { "visibility": "off" } ] }, { "elementType": "labels.text.fill", "stylers": [ { "color": "#616161" } ] }, { "elementType": "labels.text.stroke", "stylers": [ { "color": "#f5f5f5" } ] }, { "featureType": "administrative.land_parcel", "elementType": "labels.text.fill", "stylers": [ { "color": "#bdbdbd" } ] }, { "featureType": "administrative.province", "elementType": "geometry", "stylers": [ { "color": "#718593" } ] }, { "featureType": "landscape.natural.terrain", "elementType": "geometry", "stylers": [ { "color": "#e5e7d1" } ] }, { "featureType": "poi", "elementType": "geometry", "stylers": [ { "color": "#afd2aa" } ] }, { "featureType": "poi", "elementType": "labels.text.fill", "stylers": [ { "color": "#757575" } ] }, { "featureType": "poi.park", "elementType": "geometry", "stylers": [ { "color": "#b7d9ba" } ] }, { "featureType": "poi.park", "elementType": "labels.text.fill", "stylers": [ { "color": "#545454" } ] }, { "featureType": "road", "elementType": "geometry", "stylers": [ { "color": "#ffffff" } ] }, { "featureType": "road.arterial", "elementType": "geometry", "stylers": [ { "color": "#e1c99d" }, { "visibility": "simplified" }, { "weight": 1 } ] }, { "featureType": "road.arterial", "elementType": "labels.text.fill", "stylers": [ { "color": "#757575" } ] }, { "featureType": "road.highway", "stylers": [ { "visibility": "simplified" } ] }, { "featureType": "road.highway", "elementType": "geometry", "stylers": [ { "color": "#daba95" } ] }, { "featureType": "road.highway", "elementType": "labels.text.fill", "stylers": [ { "color": "#616161" } ] }, { "featureType": "road.local", "elementType": "geometry", "stylers": [ { "color": "#f3d39b" }, { "visibility": "simplified" }, { "weight": 1 } ] }, { "featureType": "road.local", "elementType": "labels.text.fill", "stylers": [ { "color": "#9e9e9e" } ] }, { "featureType": "transit.line", "elementType": "geometry", "stylers": [ { "color": "#e5e5e5" } ] }, { "featureType": "transit.station", "elementType": "geometry", "stylers": [ { "color": "#eeeeee" } ] }, { "featureType": "water", "elementType": "geometry", "stylers": [ { "color": "#9bb3bd" } ] }, { "featureType": "water", "elementType": "labels.text.fill", "stylers": [ { "color": "#ffffff" } ] } ],
                zoom: defaultZoom
            });
        },

        _calculateDistance: function() {
            var self = this;
            searchModel.postCode.subscribe(function() {
                var returnedLatLang =  self._getlatLang(searchModel.postCode());
            });

            searchModel.returnedlatlang.subscribe(function() {

                var testlatLng = new google.maps.LatLng(searchModel.returnedlatlang()[0].lat, searchModel.returnedlatlang()[0].lng);


                for(var j in storesModel.storeCollection()){
                    var markLatLng =  new google.maps.LatLng(storesModel.storeCollection()[j].latitude, storesModel.storeCollection()[j].longitude);
                    var result = google.maps.geometry.spherical.computeDistanceBetween(testlatLng, markLatLng);


                    var calculatedDistance = Math.round(result/1000);

                    if(calculatedDistance > 1){

                        storesModel.storeCollection.splice(j);

                    }
                }

            });
        },

        _subscribeToStoreChange: function() {
            var self = this;
            storesModel.storeCollection.subscribe(function() {
                self._clearMarkers();
                self._addMarkers();

            });
        },

        _subscribeToSliderChange: function() {
            var self = this;
            storesModel.sliderChange.subscribe(function() {

                if(circleExists==1){
                    self._removeRadiusCircle();
                }
                self._drawRadiusCircle(storesModel.sliderMiles(),locationLatLang);

            });
        },

        _drawRadiusCircle: function(miles,locationData) {
            self = this;
            this.radiusCircle = new google.maps.Circle({
                strokeColor: '#FF0000',
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: '#FF0000',
                fillOpacity: 0.35,
                map: map,
                center: locationData,
                radius: miles * 1609
            });
            circleExists=1;
        },

        _getlatLang: function(postCodeIn = null) {



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

                    var latlng =  {lat: latitudelocation, lng:longitudelocation};
                    searchModel.returnedlatlang.push(latlng);

                }
            });

        },

        _getPostCodeLatLang: function(postCodeIn = null) {

            geocoder = new google.maps.Geocoder();
            var postcode = postCodeIn



            geocoder.geocode({
                componentRestrictions: {
                    country: 'GB',
                    postalCode: postcode
                }
            }, function(results, status) {
                if (status == 'OK') {
                    var longitudelocation = results[0].geometry.viewport.b.b;
                    var latitudelocation = results[0].geometry.viewport.f.b;
                    locationLatLang = {lat: latitudelocation, lng:longitudelocation};
                    if(circleExists==1){
                        self._removeRadiusCircle();
                    }
                    self._drawRadiusCircle(storesModel.sliderMiles(),locationLatLang);
                } else {
                }
            });
        },

        _removeRadiusCircle: function() {
            this.radiusCircle.setMap(null);
        },

        _subscribeToPostCode: function() {
            var self = this;
            var directionsService = new google.maps.DirectionsService;
            var directionsDisplay = new google.maps.DirectionsRenderer;
            storesModel.postCode.subscribe(function() {
                //IF WE ARE ON THE VIEW PAGE ELSE WE ON LIST PAGE
                if ( $('#directions-panel').length ) {
                    directionsDisplay.setMap(map);
                    $('#directions-panel').empty();
                    directionsDisplay.setPanel(document.getElementById('directions-panel'));
                    self._calculateAndDisplayRoute(directionsService, directionsDisplay);
                }
                else {

                    self._getPostCodeLatLang(storesModel.postCode())
                }

            });
        },

        _calculateAndDisplayRoute: function(directionsService, directionsDisplay) {
            var self = this;
            var mode = self._getTravelMode();

            directionsService.route({
                origin: storesModel.postCode(),
                destination: new google.maps.LatLng(storesModel.storeCollection()[0].latitude,storesModel.storeCollection()[0].longitude),
                travelMode: mode
            }, function(response, status) {
                if (status === 'OK') {
                    directionsDisplay.setDirections(response);
                }
                else {
                }
            });

        },

        _getTravelMode: function() {
            var mode = "";
            $('.travel-mode').each(function() {
                if($(this).hasClass('active')){
                    mode = $(this).attr('class').split(' ')[0];
                }
            });
            return mode;
        },

        _clearMarkers: function() {
            for(var i=0; i < markers.length; i++) {
                markers[i].setMap(null);
            }
            markers = [];
        },

        _addMarkers: function() {
            var data = storesModel.storeCollection();
            if(data.length > 0) {
                this._setMapCenter(data[0]);
                for (var i in data) {
                    var marker = new google.maps.Marker({
                        position: new google.maps.LatLng(data[i].latitude, data[i].longitude),
                        map: map,
                        title: data[i].name
                    });
                    markers.push(marker);
                    var infoWindow = this._addInfoWindow(marker, data[i]);
                    this._getInfoWindowContent(infoWindow, data[i]);
                }
            }


        },

        _setMapCenter: function(data) {
            map.setCenter(new google.maps.LatLng(data.latitude, data.longitude));
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
            var self = this;
            $.ajax({
                url:'/storefinder/index/storeContent',
                type:'POST',
                data:{ "data" : data},
                dataType:'json',
            }).done(function (data) {
                infoWindow.setContent(data);
            });
        },
    });

    return $.storefinder.googleMap;
});
