//== Class definition
var FormControls = function () {
    //== Private functions
    var demo1 = function () {
        $( "#change_password" ).validate({
            // define validation rules
            rules: {
               
                password: {
                    minlength: 6,
                    required:true,
                },
                password_confirmation: {
                    minlength: 6,
                    equalTo: "#password"
                }
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
    var demo2 = function () {
        $( "#profile_update" ).validate({
            // define validation rules
            rules: {
               
                name: {
                   
                    required:true,
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