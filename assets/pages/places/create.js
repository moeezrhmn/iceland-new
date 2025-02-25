//== Class definition
var FormControls = function () {
    //== Private functions
    var demo1 = function () {
        $( "#place_form_sample_3" ).validate({
            // define validation rules
            rules: {
                place_name: {
                    required: true
                },
                order_no: {
                    required: true
                },
                search_address: {
                    required: true
                },
                  description: {
                    required: true
                },
               
                  locality: {
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