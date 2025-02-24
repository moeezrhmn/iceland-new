
<script>
    $(document).ready(function () {
        $('#htl_name').focus();
    });
    $(document).ready(function () {
        $("#rest_name").autocomplete({
            source: web_url + "/restaurants/search",
            select: function (event, ui) {
                var e = ui.item;
                $('input[name=city_id]').val(e.id);
                $('input[name=type]').val(e.type);
            },
            change: function (event, ui) {
                var noRecord = 'No records found';
                if (ui.item == null || ui.item == undefined || $('#rest_name').val() === 'No records found') {
                    $("#rest_name").val("");
                    $("#rest_name").attr("disabled", false);
                }
            }
        });
        ////////////////////////////// activity search
        $("#activity_auto_search").autocomplete({
            source: web_url + "/activities/ActivityAutoSearch",

            select: function (event, ui) {
                var e = ui.item;
                $('input[name=city_activity_id]').val(e.id);
                $('input[name=search_type]').val(e.type);

            },
            change: function (event, ui) {
                var noRecord = 'No records found';
                if (ui.item == null || ui.item == undefined || $('#activity_auto_search').val() === 'No records found') {
                    $("#activity_auto_search").val("");
                    $("#activity_auto_search").attr("disabled", false);
                }
                // else {
                //     $("#supcode").attr("disabled", true);
                // }
            }
        });
        $("#htl_name").autocomplete({
            source: web_url + "/hotels/auto-search",
            select: function (event, ui) {
                var e = ui.item;
                $('input[name=city_id]').val(e.id);
                $('input[name=search_type]').val(e.type);
            },
            change: function (event, ui) {
                var noRecord = 'No records found';
                if (ui.item == null || ui.item == undefined || $('#htl_name').val() === 'No records found') {
                    $("#htl_name").val("");
                    $("#htl_name").attr("disabled", false);
                }
            }

        });
        $("#plc_name").autocomplete({
            source: web_url + "/search/SearchPlcAutoName",
            select: function (event, ui) {
                var e = ui.item;
                $('#place_city_id').val(e.id);
                $('input[name=search_type]').val(e.type);
            },
            change: function (event, ui) {
                var noRecord = 'No records found';
                if (ui.item == null || ui.item == undefined || $('#plc_name').val() === 'No records found') {
                    $("#plc_name").val("");
                    $("#plc_name").attr("disabled", false);
                }
            }

        });
    });
</script>

<!--Validation-->

<script>

    $(document).ready(function () {
        $("#form_search_rest").validate();
    });
    $(document).ready(function () {
        $("#form_search_hotel").validate();
    });
    $(document).ready(function () {
        $("#form_search_places").validate();
    });
    $(document).ready(function () {
        $("#form_search_activity").validate();
    });
</script>

