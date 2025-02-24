


<script>
//  $('input').iCheck({
//        checkboxClass: 'icheckbox_square-grey',
//      radioClass: 'iradio_square-grey'
//  });
    ///////rat yo plugin listing goes here////////////////////
    $(function () {
        $(".rateYo-sidebar-5").rateYo({
            rating: 5,
            spacing: "5px",
            readOnly: true,
            starWidth: "20px"
        });
        $(".rateYo-sidebar-4").rateYo({
            rating: 4,
            spacing: "5px",
            readOnly: true,
            starWidth: "20px"
        });
        $(".rateYo-sidebar-3").rateYo({
            rating: 3,
            spacing: "5px",
            readOnly: true,
            starWidth: "20px"
        });
        $(".rateYo-sidebar-2").rateYo({
            rating: 2,
            spacing: "5px",
            readOnly: true,
            starWidth: "20px"
        });
        $(".rateYo-sidebar-1").rateYo({
            rating: 1,
            spacing: "5px",
            readOnly: true,
            starWidth: "20px"
        });
    });

    function showRating(i, rating) {
        $(".rateYo-" + i).rateYo({
            rating: rating,
            spacing: "5px",
            readOnly: true,
            starWidth: "20px"
        });
    }

</script>

<script>
    $(document).ready(function() {
        initialize();
        function initialize()
        {
            var myLatLng = new google.maps.LatLng( <?php echo @$lat ; ?>,<?php echo @$long ; ?>);
            var map = new google.maps.Map(document.getElementById("mapId"),
                {
                    zoom: 8,
                    center: myLatLng,
                    mapTypeId: google.maps.MapTypeId.ROADMAP,

                });
            var marker = new google.maps.Marker(
                {
                    position: myLatLng,
                    map: map,
                    title: '<?php echo @$name; ?>',
               
                    icon: '<?php echo url('/assets/web/img/map_marker1.png');?>'
                });
        }


    });
</script>

