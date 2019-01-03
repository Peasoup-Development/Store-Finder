define(['uiComponent', 'ko','Peasoup_Storefinder/js/storefinder','jquery',"jquery/ui"], function ( Component, ko,storefinder,$) {
    'use strict';
    var self;
    return Component.extend({
        postCode: ko.observable(""),


    initialize: function () {
            self = this;
            this._super();
            this.subscribeToChange();
        },


        subscribeToChange: function() {
            this.postCode.subscribe(function(newValue) {

            });
        },

        getNearestStores:function(){
            var distance = $('[data-role=to-label]').html();
            var miles = distance.charAt(0) + distance.charAt(1);
            var self = this;
            $.ajax({
                url:'/storefinder/index/search',
                type:'GET',
                dataType:'json',
                data: { postcode: "nn1 5ng"}
                }).done(function (data) {

                    self.clearMap();
                    self.refreshMap(data);


            });


        },


        clearMap:function(data){
            $('#map').html("");
        },

        refreshMap:function(data) {

            var myLatLngdef = {lat:parseFloat(data[0].Latitude), lng:parseFloat(data[0].Longitude)};
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom:8,
                styles:[ { "elementType": "geometry", "stylers": [ { "color": "#f5f5f5" } ] }, { "elementType": "labels.icon", "stylers": [ { "visibility": "off" } ] }, { "elementType": "labels.text.fill", "stylers": [ { "color": "#616161" } ] }, { "elementType": "labels.text.stroke", "stylers": [ { "color": "#f5f5f5" } ] }, { "featureType": "administrative.land_parcel", "elementType": "labels.text.fill", "stylers": [ { "color": "#bdbdbd" } ] }, { "featureType": "administrative.province", "elementType": "geometry", "stylers": [ { "color": "#718593" } ] }, { "featureType": "landscape.natural.terrain", "elementType": "geometry", "stylers": [ { "color": "#e5e7d1" } ] }, { "featureType": "poi", "elementType": "geometry", "stylers": [ { "color": "#afd2aa" } ] }, { "featureType": "poi", "elementType": "labels.text.fill", "stylers": [ { "color": "#757575" } ] }, { "featureType": "poi.park", "elementType": "geometry", "stylers": [ { "color": "#b7d9ba" } ] }, { "featureType": "poi.park", "elementType": "labels.text.fill", "stylers": [ { "color": "#545454" } ] }, { "featureType": "road", "elementType": "geometry", "stylers": [ { "color": "#ffffff" } ] }, { "featureType": "road.arterial", "elementType": "geometry", "stylers": [ { "color": "#e1c99d" }, { "visibility": "simplified" }, { "weight": 1 } ] }, { "featureType": "road.arterial", "elementType": "labels.text.fill", "stylers": [ { "color": "#757575" } ] }, { "featureType": "road.highway", "stylers": [ { "visibility": "simplified" } ] }, { "featureType": "road.highway", "elementType": "geometry", "stylers": [ { "color": "#daba95" } ] }, { "featureType": "road.highway", "elementType": "labels.text.fill", "stylers": [ { "color": "#616161" } ] }, { "featureType": "road.local", "elementType": "geometry", "stylers": [ { "color": "#f3d39b" }, { "visibility": "simplified" }, { "weight": 1 } ] }, { "featureType": "road.local", "elementType": "labels.text.fill", "stylers": [ { "color": "#9e9e9e" } ] }, { "featureType": "transit.line", "elementType": "geometry", "stylers": [ { "color": "#e5e5e5" } ] }, { "featureType": "transit.station", "elementType": "geometry", "stylers": [ { "color": "#eeeeee" } ] }, { "featureType": "water", "elementType": "geometry", "stylers": [ { "color": "#9bb3bd" } ] }, { "featureType": "water", "elementType": "labels.text.fill", "stylers": [ { "color": "#ffffff" } ] } ],
                center: myLatLngdef,
                mapTypeId: 'roadmap'
            });

            for(var i =0;i<data.length;i++) {
                console.log(data[i])
                var myLatLng = {lat:parseFloat(data[i].Latitude), lng:parseFloat(data[i].Longitude)};
                var marker = new google.maps.Marker({
                    position: myLatLng,
                });
                marker.setMap(map);

            }

        }

    });
});