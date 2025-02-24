<script>

    $(document).ready(function() {
        $('#summernote').summernote({
            shortcuts: false
        });
    });
</script>
<script>
    $(document).on('change', ".continent_code", function () {
        var token = $("input[name='_token']").val();
        var $select_city_base = $("#country_code").select2();
        $select_city_base.val(null).trigger("change");
        var continent_code = $(this).val();
        $("#loader").css("display", "block");
        $.ajax
        ({
            type: "POST",
            url: admin_url + "/admin/city/get_countries",
            data: {'id': continent_code, '_token': token},
            success: function (data) {
                $("#country_code").html(data);
                $("#loader").css("display", "none");
            }
        });
    });

  /*  $(document).on('change', ".country_code", function () {
        var token = $("input[name='_token']").val();
        var $select_city_base = $("#city_name").select2();
        $select_city_base.val(null).trigger("change");
        var country_base = $(this).val();
        $("#loader").css("display", "block");
        $.ajax
        ({
            type: "POST",
            url: admin_url + "/admin/city/get_cities",
            data: {'id': country_base, '_token': token},
            success: function (data) {
                $("#city_name").html(data);
                $("#loader").css("display", "none");
            }
        });
    });*/
</script>
<script>

    $(document).ready(function() {
        var max_fields      = 50; //maximum input boxes allowed
        var wrapper         = $(".input_fields_wrap"); //Fields wrapper
        var add_button      = $(".add_field_button"); //Add button ID
        var x = 1; //initlal text box count
        var i = 1;

        $(add_button).click(function(){ //on add input button click

            i += 1;
          //          alert(i)

            //var cat_id = $("#country_list").val();
            //alert(cat_id);
//                    $("#loader").css("display", "block");
            if(x < max_fields){ //max input box allowed
                x++; //text box increment
                var div =  $(wrapper).append(
                    '<div class="city_detail_div">'+
                    '<div class="col-md-6">'+
                    '<div class="form-group">'+
                    '<label class="control-label">Category</label>'+
                    '<select name="city_category_id[]" class="form-control">'+
                        '<option value="1">Money</option>'+
                        '<option value="2">Communications</option>'+
                        '<option value="3">Health & safety</option>'+
                        '<option value="4">Driving</option>'+
                        '<option value="5">Alcohol, drugs & prostitution </option>'+
                        '<option value="6">Other</option>'+
                        '</select>'+
                    '</div>'+
                    '</div>'+
                    '<div class="col-md-6">'+
                    '<div class="form-group">'+
                    '<label class="control-label">Title</label>'+
                    '<input type="text" name="title[]" class="form-control" placeholder="Title">'+
                    '</div>'+
                    '</div>'+
                    '<div class="col-md-10">'+
                    '<div class="form-group">'+
                    '<label class="control-label">Description</label>'+
                    '<textarea value="" id="summernote'+i+'"  class="summernote_1" name="more_city_description[]" placeholder="Description"></textarea>'+
                    '</div>'+
                    '</div>'+
                     '<div class="col-md-2">'+
                    '<a class="btn btn-danger remove_city_btn" id="'+i+'" ><i class="icon-cancel-circled2-1 cancel_city">Remove</i></a>'+
                    '</div>'+
                    '</div>'+
                    '</div>'

                );
                $('#summernote'+ i).summernote({height: 300});
            }
        });
        $(wrapper).on("click",".cancel_city", function(e){ //user click on remove text
            //  e.preventDefault();
            $(this).closest('.city_detail_div').remove();
            $(this).parent('div').parent('.city_detail_div').remove();
        })
    });
</script>
<script>
    $(document).ready(function() {
        $(document).on('click', ".delete_city", function () {
            var city_detail_id= $(this).attr('city_detail_id');
            //alert(city_detail_id);
            $.ajax
            ({
                type: "get",
                url: admin_url + "/admin/city/delete_city_detail/"+city_detail_id,
                success: function (data) {
                    if(data){
                        $("#city_"+city_detail_id).remove();
                    }
                }
            });
    });
    });
</script>