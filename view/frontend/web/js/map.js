/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Smile Elastic Suite to newer
 * versions in the future.
 *
 *
 * @category  Smile
 * @package   Smile\ElasticsuiteCatalog
 * @author    Aurelien FOUCRET <aurelien.foucret@smile.fr>
 * @copyright 2016 Smile
 * @license   Open Software License ("OSL") v. 3.0
 */


/*jshint browser:true jquery:true*/
/*global alert*/

define(['uiComponent', 'ko','storesModel','jquery','jquery/ui'], function ( Component, ko, storesModel, $) {

    "use strict";

    $.widget('storefinder.googlemap', {
        _create: function () {
            this._createMap();
        },

        _createMap: function() {
            var map = new google.maps.Map($('#mapArea'), {
                zoom:8,
                styles:[ { "elementType": "geometry", "stylers": [ { "color": "#f5f5f5" } ] }, { "elementType": "labels.icon", "stylers": [ { "visibility": "off" } ] }, { "elementType": "labels.text.fill", "stylers": [ { "color": "#616161" } ] }, { "elementType": "labels.text.stroke", "stylers": [ { "color": "#f5f5f5" } ] }, { "featureType": "administrative.land_parcel", "elementType": "labels.text.fill", "stylers": [ { "color": "#bdbdbd" } ] }, { "featureType": "administrative.province", "elementType": "geometry", "stylers": [ { "color": "#718593" } ] }, { "featureType": "landscape.natural.terrain", "elementType": "geometry", "stylers": [ { "color": "#e5e7d1" } ] }, { "featureType": "poi", "elementType": "geometry", "stylers": [ { "color": "#afd2aa" } ] }, { "featureType": "poi", "elementType": "labels.text.fill", "stylers": [ { "color": "#757575" } ] }, { "featureType": "poi.park", "elementType": "geometry", "stylers": [ { "color": "#b7d9ba" } ] }, { "featureType": "poi.park", "elementType": "labels.text.fill", "stylers": [ { "color": "#545454" } ] }, { "featureType": "road", "elementType": "geometry", "stylers": [ { "color": "#ffffff" } ] }, { "featureType": "road.arterial", "elementType": "geometry", "stylers": [ { "color": "#e1c99d" }, { "visibility": "simplified" }, { "weight": 1 } ] }, { "featureType": "road.arterial", "elementType": "labels.text.fill", "stylers": [ { "color": "#757575" } ] }, { "featureType": "road.highway", "stylers": [ { "visibility": "simplified" } ] }, { "featureType": "road.highway", "elementType": "geometry", "stylers": [ { "color": "#daba95" } ] }, { "featureType": "road.highway", "elementType": "labels.text.fill", "stylers": [ { "color": "#616161" } ] }, { "featureType": "road.local", "elementType": "geometry", "stylers": [ { "color": "#f3d39b" }, { "visibility": "simplified" }, { "weight": 1 } ] }, { "featureType": "road.local", "elementType": "labels.text.fill", "stylers": [ { "color": "#9e9e9e" } ] }, { "featureType": "transit.line", "elementType": "geometry", "stylers": [ { "color": "#e5e5e5" } ] }, { "featureType": "transit.station", "elementType": "geometry", "stylers": [ { "color": "#eeeeee" } ] }, { "featureType": "water", "elementType": "geometry", "stylers": [ { "color": "#9bb3bd" } ] }, { "featureType": "water", "elementType": "labels.text.fill", "stylers": [ { "color": "#ffffff" } ] } ],
                center: myLatLngdef,
                mapTypeId: 'roadmap'
            });
        },

        _onSliderChange : function (ev, ui) {
            this._refreshDisplay(ui.value);
        },


        _refreshDisplay: function(value) {
            var formattedValue = value;
            formattedValue = formattedValue + ' Miles';
            if ($('[data-role=to-label]')) {
                $('[data-role=to-label]').html( formattedValue);
            }
        },
    });

    return $.storefinder.googlemap;
});