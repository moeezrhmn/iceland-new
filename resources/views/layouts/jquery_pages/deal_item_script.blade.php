<script>
    function showRating(i, rating) {

        $(".rateYo-" + i).rateYo({
            rating: rating,
            spacing: "5px",
            readOnly: true,
            starWidth: "20px"
        });
    };
    $(function () {
        //rate yo initialize for static
        $("#topBannerRating").rateYo({
            rating: <?=(isset($item->stars) && !empty($item->stars)) ? @$item->stars : 0?>,
            spacing: "5px",
            readOnly: true,
            starWidth: "20px"
        });
//rate yo initialize for static
        $(".rateYo").rateYo({
            rating: 5,
            spacing: "5px",
            readOnly: true,
            starWidth: "20px"
        });
// rate yo initilze for review form;
        $("#rateYo").rateYo({
            fullStar: true,
            onSet: function (rating, rateYoInstance) {
                $('#rating_val').val(rating);
            }
        });

    });

</script>

<script>

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
                "name": "<?php echo $name ?>",
                "location_latitude": "<?php echo @$item->latitude?>",
                "location_longitude": "<?php echo @$item->longitude?>",
                "map_image_url": "<?php echo url('uploads/' . @$item->photo[0]->photo)?>",
                "name_point": '<?php echo $name ?>',
                "get_directions_start_address": "",
                "phone": "+3934245255",
                "city_point": "<?php echo @$item->city?>"
            }]

        };

    var mapOptions = {
        zoom: 14,
        center: new google.maps.LatLng(<?php echo $item->latitude?>, <?php echo $item->longitude?>),
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
    mapObject = new google.maps.Map(document.getElementById('map'), mapOptions);
    for (var key in markersData)
        markersData[key].forEach(function (item) {
            marker = new google.maps.Marker({
                position: new google.maps.LatLng(item.location_latitude, item.location_longitude),
                map: mapObject,
                icon: '<?php echo url('/assets/web/img/map_marker.png');?>',
            });
            if ('undefined' === typeof markers[key])
                markers[key] = [];
            markers[key].push(marker);
            google.maps.event.addListener(marker, 'click', (function () {
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
        return new InfoBox({
            content: '<div class="marker_info" id="marker_info">' +
            '<img src="' + item.map_image_url + '" alt="Image"/>' +
            '<div class="marker_div">' +
            '<h3>' + item.name_point + '</h3>' +
            '<div class="marker_tools">' +
            '<form action="http://maps.google.com/maps" method="get" target="_blank" style="display:inline-block"">' +
            '<input name="lat" value="' + item.get_directions_start_address + '" type="hidden">' +
            '<input type="hidden" name="long" value="' + item.location_latitude + ',' + item.location_longitude + '">' +
            '<button type="submit" value="Get directions" class="btn_infobox_get_directions">Directions</button></form>' +
            '<a href="tel://' + item.phone + '" class="btn_infobox_phone">' + item.phone + '</a>' +
            '</div>' +
            '<div class="city-point">' + item.city_point + '</div>' +
            '</div>' +
            '</div>',
            disableAutoPan: false,
            maxWidth: '18px',
            minWidth: '18px',
            width: '18px',
            pixelOffset: new google.maps.Size(10, 125),
            closeBoxMargin: '5px -20px 2px 2px',
            closeBoxURL: "   <?php echo url('/'); ?>/assets/web/img/pins/close.gif",
            isHidden: false,
            alignBottom: true,
            pane: 'floatPane',
            enableEventPropagation: true
        });


    };


</script>