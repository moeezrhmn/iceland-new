//== Class definition
var FormControls = function () {
    //== Private functions
    var demo1 = function () {
        $( "#form_sample_3" ).validate({
            // define validation rules
            rules: {
                category_name: {
                    required: true
                },
                place_id: {
                    required: true
                },
                deal_name: {
                    required: true
                },
                  valid_from: {
                    required: true
                },
                valid_to: {
                    required: true
                },

                discount_price: {
                    required: true
                },
                  currency: {
                    required: true
                },
                valid_to: {
                    required: true
                },

            },

            //display error alert on form submit
            invalidHandler: function(event, validator) {
                var alert = $('#m_form_msg');
                alert.removeClass('m--hide').show();
                mApp.scrollTo(alert, -200);
            },

            submitHandler: function (form) {
                form[0].submit(); // submit the form
            }
        });
    }



    return {
        // public functions
        init: function() {
            demo1();
        }
    };
}();

jQuery(document).ready(function() {
    FormControls.init();
});

        $(document).on('change', "#category", function () {
            var cat_id = $(this).val();
          
            $.ajax
            ({
                type: "GET",
                url: admin_url + "/admin/deals/get_places",
                data: {'id': cat_id},
                success: function (data) {
                    $("#select2-multiple-input-sm1").html(data);
                   
                }
            });
        });
        //        on change desi

