define(['uiComponent', 'ko','storesModel','jquery',"jquery/ui"], function ( Component, ko, storesModel, $) {
    'use strict';
    var self;
    return Component.extend({

        stores : ko.observableArray([]),

        _baseMediaUrl : null,

        initialize: function (config) {
            self = this;
            this._baseMediaUrl = config.baseUrl;
            this._super();
            this._getStores();
            this._subscribeToStoreChange();
        },

        _getStores:function() {
            var self = this;
            if(typeof this.id === 'undefined') {
                $.ajax({
                    url:'/storefinder/index/stores',
                    type:'GET',
                    dataType:'json',
                }).done(function (data) {
                    for(var i in data ){
                        storesModel.storeCollection.push(data[i]);
                    }

                });
            }
            else {

                $.ajax({
                    url:'/storefinder/index/stores',
                    type:'GET',
                    data: 'id='+this.id,
                    dataType:'json',
                }).done(function (data) {
                    for(var i in data ){
                        storesModel.storeCollection.push(data[i]);
                    }
                });
            }
        },

        _subscribeToStoreChange: function() {
            storesModel.storeCollection.subscribe(function() {
                self._updateArray();
            });
        },

        _updateArray:function(stores) {
            var data = storesModel.storeCollection();
            this.stores.removeAll();
            for(var i in data){
                this.stores.push({
                    id:data[i].store_id,
                    name:data[i].name,
                    address1:data[i].address1,
                    address2:data[i].address2,
                    town:data[i].town,
                    country:data[i].country,
                    postcode:data[i].postcode,
                    telephone:data[i].telephone,
                    url:"/storefinder/vape-shop-"+data[i].name.replace(/\s+/g, '-').toLowerCase(),
                    image: this._baseMediaUrl + data[i].images[0].image,
                })
            }

        },
    });
});