<script>
    $(document).ready(function () {
        $(document).on("click", ".HotelFacilities", function () {
            var hotel_id = ($(this).attr('hotel_id'));
            var hotel_name = ($(this).attr('hotel_name'));
            $('.title').html(hotel_name);
//            alert(hotel_id)
            $.ajax({
                type: "GET",
                url: web_url + "/hotels/get-facilities",
                data: {'hotel_id': hotel_id},

                success: function (data) {
                    $('.FacilitiesRecord').html(data);
                    //Do something
                }
            });
        });
    });
</script>

<script>
    $(document).ready(function () {
        $(document).on("click", ".map_modal_show", function () {
            var hotelName = ($(this).attr('hotelName'));
            var lat = ($(this).attr('lat'));
            var long = ($(this).attr('long'));
            // alert(hotelName);


            (function (A) {

                if (!Array.prototype.forEach)
                    A.forEach = A.forEach || function (action, that) {
                        for (var i = 0, l = this.length; i < l; i++)
                            if (i in this)
                                action.call(that, this[i], i, this);
                    };

            })(Array.prototype);

            var
                mapObject,
                markers = [],
                markersData = {
                    "Fastfood": [{
                        "name": hotelName,
                        "location_latitude": lat,
                        "location_longitude": long,
                        "name_point": hotelName,

                    }]

                };

            var mapOptions = {
                zoom: 14,
                center: new google.maps.LatLng(lat, long),
                mapTypeId: google.maps.MapTypeId.ROADMAP,

                mapTypeControl: false,
                mapTypeControlOptions: {
                    style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
                    position: google.maps.ControlPosition.LEFT_CENTER
                },
                panControl: false,
                panControlOptions: {
                    position: google.maps.ControlPosition.TOP_RIGHT
                },
                zoomControl: true,
                zoomControlOptions: {
                    style: google.maps.ZoomControlStyle.LARGE,
                    position: google.maps.ControlPosition.TOP_LEFT
                },
                scrollwheel: false,
                scaleControl: false,
                scaleControlOptions: {
                    position: google.maps.ControlPosition.TOP_LEFT
                },
                streetViewControl: true,
                streetViewControlOptions: {
                    position: google.maps.ControlPosition.LEFT_TOP
                },
                styles: [
                    {
                        "featureType": "landscape",
                        "stylers": [
                            {
                                "hue": "#FFBB00"
                            },
                            {
                                "saturation": 43.400000000000006
                            },
                            {
                                "lightness": 37.599999999999994
                            },
                            {
                                "gamma": 1
                            }
                        ]
                    },
                    {
                        "featureType": "road.highway",
                        "stylers": [
                            {
                                "hue": "#FFC200"
                            },
                            {
                                "saturation": -61.8
                            },
                            {
                                "lightness": 45.599999999999994
                            },
                            {
                                "gamma": 1
                            }
                        ]
                    },
                    {
                        "featureType": "road.arterial",
                        "stylers": [
                            {
                                "hue": "#FF0300"
                            },
                            {
                                "saturation": -100
                            },
                            {
                                "lightness": 51.19999999999999
                            },
                            {
                                "gamma": 1
                            }
                        ]
                    },
                    {
                        "featureType": "road.local",
                        "stylers": [
                            {
                                "hue": "#FF0300"
                            },
                            {
                                "saturation": -100
                            },
                            {
                                "lightness": 52
                            },
                            {
                                "gamma": 1
                            }
                        ]
                    },
                    {
                        "featureType": "water",
                        "stylers": [
                            {
                                "hue": "#0078FF"
                            },
                            {
                                "saturation": -13.200000000000003
                            },
                            {
                                "lightness": 2.4000000000000057
                            },
                            {
                                "gamma": 1
                            }
                        ]
                    },
                    {
                        "featureType": "poi",
                        "stylers": [
                            {
                                "hue": "#00FF6A"
                            },
                            {
                                "saturation": -1.0989010989011234
                            },
                            {
                                "lightness": 11.200000000000017
                            },
                            {
                                "gamma": 1
                            }
                        ]
                    }
                ]
            };
            var
                marker;
            mapObject = new google.maps.Map(document.getElementById('map_ItemView'), mapOptions);
            for (var key in markersData)
                markersData[key].forEach(function (item) {
                    marker = new google.maps.Marker({
                        position: new google.maps.LatLng(item.location_latitude, item.location_longitude),
                        map: mapObject,
                        icon: '<?php echo url('/'); ?>/assets/web/img/pin_maps.png',
                    });
                    if ('undefined' === typeof markers[key])
                        markers[key] = [];
                    markers[key].push(marker);
                    google.maps.event.addListener(marker, 'mouseover', (function () {
                        closeInfoBox();
                        getInfoBox(item).open(mapObject, this);
                        mapObject.setCenter(new google.maps.LatLng(item.location_latitude, item.location_longitude));
                    }));

                });

            function hideAllMarkers() {
                for (var key in markers)
                    markers[key].forEach(function (marker) {
                        marker.setMap(null);
                    });
            };

            function closeInfoBox() {
                $('div.infoBox').remove();
            };

            function getInfoBox(item) {


            };


        });
    });


</script>