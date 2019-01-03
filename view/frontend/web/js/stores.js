define(['uiComponent', 'ko','Peasoup_Storefinder/js/distanceSlider','jquery',"jquery/ui"], function ( Component, ko,ds,$) {
    'use strict';
    var self;
    return Component.extend({

        stores : ko.observableArray([]),


        initialize: function () {
            self = this;
            this._super();
            this._getStores();
        },


        _getStores:function(){

        },



        refreshStores:function(data) {

        }
    });
});