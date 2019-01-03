define(
    ['ko'],
    function (ko) {
        'use strict';

        var stores = [];

        var storeChange = ko.observable();
        var postCode = ko.observable();

        var sliderChange = ko.observable(0);

        var sliderMiles = ko.observable(15);

        function addStore(data) {
            this.stores.push({
                'store_id'   : data.store_id,
                'name'       : data.name,
                'address1'    : data.address1,
                'address2'    : data.address2,
                'town'       : data.town,
                'country'    : data.country,
                'postcode'   : data.postcode,
                'telephone'  : data.telephone,
                'email'      : data.email,
                'monday'     : data.monday,
                'tuesday'    : data.tuesday,
                'wednesday'  : data.wednesday,
                'thursday'   : data.thursday,
                'friday'     : data.friday,
                'saturday'   : data.saturday,
                'sunday'     : data.sunday,
                'bank'       : data.bank,
                'synopsis'   : data.synopsis,
                'longitude'  : data.longitude,
                'latitude'   : data.latitude,
                'image'      : data.image
                }
            );
            this.storeChange(1);
            this.storeChange(0);
        }

        function setPCAStores(data) {
            this.stores = [];
            var self = this;
            if(data!==null) {

                for (var i in data) {
                    self.addStore(data[i]);
                }
            }else {
                this.stores = [];
                this.storeChange(1);
                this.storeChange(0);
            }
        }

        function refreshStores(data,pageType) {
            var self = this;
            if(pageType=='list') {
                for(var i in data.items) {
                    self.addStore(data.items[i]);
                }
            } else {
                self.addStore(data);
            }
        }

        function toggleSliderChange(sliderChangeIn,miles) {
            this.sliderChange(sliderChangeIn);
            this.sliderMiles(miles);
        }

        return {
            refreshStores :  refreshStores,
            setPCAStores :  setPCAStores,
            toggleSliderChange : toggleSliderChange,
            addStore : addStore,
            stores :  stores,
            storeChange : storeChange,
            postCode : postCode,
            sliderChange : sliderChange,
            sliderMiles : sliderMiles
        };
    }
);