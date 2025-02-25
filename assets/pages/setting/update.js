//== Class definition
var FormControls = function () {
    //== Private functions
    var demo1 = function () {
        $( "#setting_form_sample_3" ).validate({
            // define validation rules
            rules: {
                support_email: {
                    required: true
                },
                sale_email: {
                    required: true
                },
                contact_no: {
                    required: true
                },
                  address: {
                    required: true
                },
               
                  city: {
                    required: true
                },
                   state: {
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