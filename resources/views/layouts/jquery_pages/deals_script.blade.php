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
            rating: <?=(isset($detail->stars) && !empty($detail->stars)) ? @$detail->stars : 0?>,
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
    $('input').iCheck({
        checkboxClass: 'icheckbox_square-grey',
        radioClass: 'iradio_square-grey'
    });
</script>
<script>
    $(document).ready(function () {
        $(".carousel").owlCarousel({
            items: 4,
            itemsDesktop: [1199, 3],
            itemsDesktopSmall: [979, 3]
        });
    });
</script>





