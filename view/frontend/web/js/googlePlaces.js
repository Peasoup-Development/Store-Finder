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

define(["jquery"], function ($) {

    "use strict";

    $.widget('storefinder.googlePlaces', {

        defaults: {
            placeId: 'ChIJTfWa82kAd0gRKPq7S9aucRs' // placeId provided by google api documentation
            , render: ['reviews']
            , min_rating: 4
            , max_rows: 4
            , rotateTime: false
            , place_data :0
        },

        $element :$('#google-reviews'),
        place_data: {},

        _create: function () {
            var self = this;
            this._super();
            self.defaults.placeId = self.options.placeId;

            this.$element.html("<div id='map-plug'></div>"); // create a plug for google to load data into
            this.initialize_place(function(place){
                self .place_data = place;
                // render specified sections
                if(self .defaults.render.indexOf('reviews') > -1){
                    self .renderReviews(self .place_data.reviews);
                    if(!!self .defaults.rotateTime) {
                        self .initRotation();
                    }
                }
            });
        },


        renderStars:function(rating){
            var stars = "<div class='review-stars'><ul>";

            // fill in gold stars
            for (var i = 0; i < rating; i++) {
                stars = stars+"<li><i class='star'></i></li>";
            };

            // fill in empty stars
            if(rating < 5){
                for (var i = 0; i < (5 - rating); i++) {
                    stars = stars+"<li><i class='star inactive'></i></li>";
                };
            }
            stars = stars+"</ul></div>";
            return stars;
        },

        convertTime :function(UNIX_timestamp){
            var a = new Date(UNIX_timestamp * 1000);
            var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
            var time = months[a.getMonth()] + ' ' + a.getDate() + ', ' + a.getFullYear();
            return time;
        },

        initRotation: function() {
            var $reviewEls = $element.children('.review-item');
            var currentIdx = $reviewEls.length > 0 ? 0 : false;
            $reviewEls.hide();
            if(currentIdx !== false) {
                $($reviewEls[currentIdx]).show();
                setInterval(function(){
                    if(++currentIdx >= $reviewEls.length) {
                        currentIdx = 0;
                    }
                    $reviewEls.hide();
                    $($reviewEls[currentIdx]).fadeIn('slow');
                }, this.defaults.rotateTime);
            }
        },

        renderReviews :function(reviews) {
            var self = this;
            reviews = self.sort_by_date(reviews);
            reviews = self.filter_minimum_rating(reviews);
            var html = "";
            var row_count = (this.defaults.max_rows > 0)? this.defaults.max_rows - 1 : reviews.length - 1;
            // make sure the row_count is not greater than available records
            row_count = (row_count > reviews.length-1)? reviews.length -1 : row_count;
            for (var i = row_count; i >= 0; i--) {
                var stars = this.renderStars(reviews[i].rating);
                var date = this.convertTime(reviews[i].time);
                html = html+
                    "<div class='col-md-3'>" +
                    "<div class='review-item'>" +
                    "<div class='review-meta'>" +
                    "<span class='review-author'>"+reviews[i].author_name+"</span>" +
                    "<span class='review-sep'>, </span>" +
                    "<span class='review-date'>"+date+"</span>" +
                    "</div>"+stars+"<p class='review-text'>"+reviews[i].text+"</p></div>" +
                    "</div>"
            };
            this.$element.append(html);
        },

        filter_minimum_rating :function(reviews){
            for (var i = reviews.length -1; i >= 0; i--) {
                if(reviews[i].rating < this.defaults.min_rating){
                    reviews.splice(i,1);
                }
            }
            return reviews;
        },

        sort_by_date: function(ray) {
            ray.sort(function(a, b){
                var keyA = new Date(a.time),
                    keyB = new Date(b.time);
                // Compare the 2 dates
                if(keyA < keyB) return -1;
                if(keyA > keyB) return 1;
                return 0;
            });
            return ray;
        },


        initialize_place: function(c){
            var map = new google.maps.Map(document.getElementById('map-plug'));

            var request = {
                placeId: this.defaults.placeId
            };

            var service = new google.maps.places.PlacesService(map);

            service.getDetails(request, function(place, status) {
                if (status == google.maps.places.PlacesServiceStatus.OK) {
                    c(place);
                }
            });
        },

    });

    return $.storefinder.googlePlaces;
});
