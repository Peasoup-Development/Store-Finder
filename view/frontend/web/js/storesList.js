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
                    storesModel.refreshStores(data,'list');
                });
            }
            else {
                $.ajax({
                    url:'/storefinder/index/stores',
                    type:'GET',
                    data: 'id='+this.id,
                    dataType:'json',
                }).done(function (data) {
                    storesModel.refreshStores(data,'view');
                });
            }
        },

        _subscribeToStoreChange: function() {
            storesModel.storeChange.subscribe(function() {
                if(storesModel.storeChange()==1){
                    self._updateArray(storesModel.stores);
                }
            });
        },

        _updateArray:function(stores) {
            this.stores.removeAll();
            for(var i in stores){
                this.stores.push({
                    id:stores[i].store_id,
                    name:stores[i].name,
                    address1:stores[i].address1,
                    address2:stores[i].address2,
                    town:stores[i].town,
                    country:stores[i].country,
                    postcode:stores[i].postcode,
                    url:"/storefinder/vape-shop-"+stores[i].name.replace(/\s+/g, '-').toLowerCase(),
                    image: this._baseMediaUrl + stores[i].image,
                })
            }
        },
    });
});