<script>
    //  $('input').iCheck({
    //        checkboxClass: 'icheckbox_square-grey',
    //      radioClass: 'iradio_square-grey'
    //  });
    ///////rat yo plugin listing goes here////////////////////

    /////////Commented by waseem 12-dec-2024/// 

    // $(function () {
    //     $(".rateYo-sidebar-5").rateYo({
    //         rating: 5,
    //         spacing: "5px",
    //         readOnly: true,
    //         starWidth: "20px"
    //     });
    //     $(".rateYo-sidebar-4").rateYo({
    //         rating: 4,
    //         spacing: "5px",
    //         readOnly: true,
    //         starWidth: "20px"
    //     });
    //     $(".rateYo-sidebar-3").rateYo({
    //         rating: 3,
    //         spacing: "5px",
    //         readOnly: true,
    //         starWidth: "20px"
    //     });
    //     $(".rateYo-sidebar-2").rateYo({
    //         rating: 2,
    //         spacing: "5px",
    //         readOnly: true,
    //         starWidth: "20px"
    //     });
    //     $(".rateYo-sidebar-1").rateYo({
    //         rating: 1,
    //         spacing: "5px",
    //         readOnly: true,
    //         starWidth: "20px"
    //     });
    // });


    // function showRating(i, rating) {
    //     alert(i);
    //     $(".rateYo-" + i).rateYo({
    //         rating: rating,
    //         spacing: "5px",
    //         readOnly: true,
    //         starWidth: "20px"
    //     });
    // }

</script>
<script>
    $('#sort').change(function () {

        if ($(this).val() != '') {
            var segment = '<?php echo Request::segment(2)?>';
            var display_id = $(this).val();
           // alert(currentURL)
            if (segment=='search'){
                window.location = "<?php echo Request::fullUrl() ?>" + "&sort=" + $(this).val();

            }else{
                window.location = "<?php echo URL::current(); ?>" + "?sort=" + $(this).val();
            }

        }
    });
    //$('.stars').change(function () {
    $('#check_box :checked').each(function() {
        alert($(this).val());
        //allVals.push($(this).val());
    });
    $(document).on('click', '.stars', function() {
        alert('sadfd');
    });
</script>

<script>
    //$( document ).ready(function() {
    function initMap() {
        var map;
        var bounds = new google.maps.LatLngBounds();
        var mapOptions = {
            mapTypeId: 'roadmap'
        };

        // Display a map on the web page
        var map = new google.maps.Map(document.getElementById('mapCanvas'), {
            center: {lat:64.146582, lng:-21.942635399999972},
            zoom: 6,
        });
        map.setTilt(50);
       // alert(<?php echo @$marker_list;?>);
        console.log(<?php echo @$marker_list;?>);
        
        // Multiple markers location, latitude, and longitude
        var markers = <?php echo @$map_list;?>;
        //var markers = [["Reykjanesviti Lighthouse",63.81574556244,-22.70424385601],["Eldborg Crater",64.79602824905,-22.32185866085],["Vatnaleid (Vatnalei\u00f0) Mountain Pass",64.9015259,-22.8482298],["Grabrok (Gr\u00e1br\u00f3k) Crater and Glanni Waterfall",64.7816667,-21.5622223],["Hraunfossar and Barnafossar",64.7029006,-20.9771716],["Snaefellsnes (Sn\u00e6fellsnes) Peninsula",64.8702778,-23.1136112],["Arnarstapi Coastal Wonders and Wildlife",64.7691204,-23.6258982],["Budir (B\u00fa\u00f0ir) Church, Beach and Lava",64.82257135069,-23.38439927001],["Magical Snaefellsjokull (Sn\u00e6fellsj\u00f6kull)",64.8057023,-23.7730966],["Raudfeldsgja (Rau\u00f0feldsgj\u00e1) Ravine",64.79848574115,-23.63758119207],["Hellnar Hamlet",64.745796,-23.67584],["Hestfjordur and Seydisfjordur (Hestfj\u00f6r\u00f0ur and Sey\u00f0isfj\u00f6r\u00f0ur)",65.984779,-22.8287199],["Hornstrandir Nature Reserve",66.3933487544,-22.56953925469],["Mjoifjordur (Mj\u00f3ifj\u00f6r\u00f0ur)",65.19680339759,-13.96680262305],["Longufjorur (L\u00f6ngufj\u00f6rur) Golden Sand Beach",64.87,-22.2300001],["Langjokull (Langj\u00f6kull) Ice Cave",64.6561868,-20.1531476],["Ondverdanes (\u00d6ndver\u00f0arnes) The Tip of Snaefellsnes",64.0095478,-20.9245977],["Hnifsdalur (Hn\u00edfsdalur) and Bolungarv\u00edk",66.1101347,-23.1237122],["Kleifaheidi (Kleifahei\u00f0i\u2018s) Stone Man",65.505,-23.6983333],["Red Sands Beach",65.4653763,-23.9878441]];
        //alert(markers);
        // Info window content
        var infoWindowContent= <?php echo @$marker_list;?>;
       // alert(infoWindowContent);
        // Add multiple markers to map
        var infoWindow = new google.maps.InfoWindow(), marker, i;
        // Place each marker on the map
        var icon = {
            url: "<?php echo url('/assets/web/img/map_marker1.png');?>", // url
            //scaledSize: new google.maps.Size(65, 60)
            //labelOrigin: new google.maps.Point(5, 0)
            // scaledSize: new google.maps.Size(width, height), // size
            //origin: new google.maps.Point(0,0), // origin
            ///anchor: new google.maps.Point(anchor_left, anchor_top) // anchor
        };
         //alert(icon);   
        for( i = 0; i < markers.length; i++ ) {
           
            var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
            bounds.extend(position);
            marker = new google.maps.Marker({
                position: position,
                map: map,
                title: markers[i][0],
                //labelContent:'<div style="text-align:center;"><b>'+markers[i][3]+'</b></div>',
                // label: {
                //     //text: markers[i][3],
                //     text: 'Google map',
                //     color: 'black',
                //     fontSize:'18px',
                //     fontWeight:'bold',
                //     position:'relative',
                //     top:'-50'
                // },
                //labelClass: "labels",
                // label: markers[i][3],
                // color:black,
                // color:black,
                icon: icon

            });

            // Add info window to marker
            google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                    infoWindow.setContent(infoWindowContent[i][0]);
                    infoWindow.open(map, marker);
                }
            })(marker, i));

            // Center the map to fit all markers on the screen
            map.fitBounds(bounds);
        }




        // Set zoom level
        var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {
            this.setZoom(6);
            google.maps.event.removeListener(boundsListener);
        });

    }

    // Adds a marker to the map.
    //    function addMarker(location, map) {
    //        // Add the marker at the clicked location, and add the next-available label
    //        // from the array of alphabetical characters.
    //        var marker = new google.maps.Marker({
    //            position: location,
    //            label: labels[labelIndex++ % labels.length],
    //            map: map
    //        });
    //    }
    // Load initialize function
    //google.maps.event.addDomListener(window, 'load', initMap);
    //});
    $(document).ready(function ($) {
       // $('.content-left ').perfectScrollbar();
    });
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCR43v6jvHEpZN4QAd3mck0AIrkC2P1g0U&libraries=places&callback=initMap" async defer></script>

