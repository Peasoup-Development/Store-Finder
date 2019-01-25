define(['uiComponent', 'ko','storesModel','searchModel','jquery',"jquery/ui"], function ( Component, ko, storesModel,searchModel, $) {
    'use strict';
    var self;
    return Component.extend({
        postCode: ko.observable(""),


        initialize: function () {
            self = this;
            this._super();
        },


        _getNearestStores:function() {
            console.log(searchModel);
            var distance = $('[data-role=to-label]').html();
            var postCode = $('#postcodeSearch').val();
            var miles = $("[data-role=slider-bar]").slider("value");
            var self = this;
            if (postCode != "") {
                alert("asdasdsdads")
                $.ajax({
                    url: '/storefinder/index/search',
                    type: 'GET',
                    dataType: 'json',
                    data: {postcode: postCode, miles: miles}
                }).done(function (data) {
                    storesModel.postCode(postCode);
                    storesModel.setPCAStores(data);
                });
            }

        },
    });
});