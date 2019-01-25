/*
 *  * @author Robert Mark Williamson <robert@peasoup-development.com>
 *  * @company Peasoup Development Limited
 *
 */

define(
    ['ko'],
    function (ko) {
        'use strict';
        var latLng = ko.observableArray();

        return {
            latLng :  latLng,
        };
    }
);