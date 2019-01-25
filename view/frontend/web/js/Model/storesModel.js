define(
    ['ko'],
    function (ko) {
        'use strict';

        var postCode = ko.observable(24);

        var sliderChange = ko.observable(0);

        var sliderMiles = ko.observable(15);

        var storeCollection = ko.observableArray();



        function setPCAStores(data) {

            var self = this;
            if(data!==null) {

                for (var i in data) {
                    self.addStore(data[i]);
                }
            }else {
                this.stores = [];

            }
        }

        function refreshStores(data,pageType) {
            var self = this;
            if(pageType=='list') {
                for(var i in data) {
                    self.addStore(data[i]);
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

            storeCollection :  storeCollection,
            postCode : postCode,
            sliderChange : sliderChange,
            sliderMiles : sliderMiles
        };
    }
);