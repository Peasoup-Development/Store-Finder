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

define(["jquery", 'Magento_Catalog/js/price-utils', 'mage/template', "storesModel", "jquery/ui"], function ($, priceUtil, mageTemplate,storesModel) {

    "use strict";

    $.widget('storefinder.distanceSlider', {

        options: {
            fromLabel   : '[data-role=from-label]',
            toLabel     : '[data-role=to-label]',
            sliderBar   : '[data-role=slider-bar]',
            message     : '[data-role=message-box]',
            applyButton : '[data-role=apply-range]',
            defaultSliderValue : 15,

            messageTemplates : {
                "displayCount": '<span class="msg"><%- count %> items</span>',
                "displayEmpty": '<span class="msg-error">No items in the current range.</span>'
            }
        },


        _create: function () {
            this.from = 1;
            this.to   = 100;
            this._createSlider();
        },

        _createSlider: function() {
            this.element.find(this.options.sliderBar).slider({
                min: this.from,
                max: this.to,
                value:this.options.defaultSliderValue,
                step: 3,
                slide: this._onSliderChange.bind(this),
                start: this._onSliderStart.bind(this),
                stop: this._onSliderStop.bind(this),
            });

            var formattedValue = 15 + ' Miles';
            if ($('[data-role=to-label]')) {
                $('[data-role=to-label]').html( formattedValue);
            }
        },


        _onSliderStart : function (ev, ui) {
            storesModel.toggleSliderChange("yes",ui.value);
        },

        _onSliderStop : function (ev, ui) {
            storesModel.toggleSliderChange("no",ui.value);
            this._getNearestStores();
        },

        _onSliderChange : function (ev, ui) {
            storesModel.toggleSliderChange("no",ui.value);
            storesModel.toggleSliderChange("yes",ui.value);
            this._refreshDisplay(ui.value);

        },


        _getNearestStores:function() {
            var distance = $('[data-role=to-label]').html();
            var postCode = $('#postcodeSearch').val();
            var miles = $("[data-role=slider-bar]").slider("value");
            var self = this;
            if(postCode != "")
            {
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

        _refreshDisplay: function(value) {
            var formattedValue = value;
            formattedValue = formattedValue + ' Miles';
            if ($('[data-role=to-label]')) {
                $('[data-role=to-label]').html( formattedValue);
            }
        },
    });

    return $.storefinder.distanceSlider;
});
