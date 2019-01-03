define(['uiComponent', 'ko','storesModel','googleMap','jquery',"jquery/ui"], function ( Component, ko,storesModel,map,$) {
    'use strict';
    var self;
    return Component.extend({

        initialize: function () {
            self = this;
            this._super();
            this._bindTravelModes();
        },

        _getDirections:function() {
            var self = this;
            storesModel.postCode("");
            if (!this._validateForm('#directions-form')) {
                storesModel.postCode("");
                return;
            }
            else {
                storesModel.postCode($('#searchRoute').val());
            }

        },

        _validateForm: function (form) {
            return $(form).validation() && $(form).validation('isValid');
        },

        _bindTravelModes:function() {
            $( document ).on( "click", ".travel-mode", function() {
                $( ".travel-mode" ).each(function() {
                    $( this ).removeClass('active') ;
                })
                $( this ).addClass('active') ;
            });
        }
    });
});