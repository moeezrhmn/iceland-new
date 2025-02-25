 var btnOffset;
 $(document).ready(function () {

 	$("a[href='#']").click(function (e) {
 		e.preventDefault();
 	});

 	$('.datepicker').datetimepicker();

 	$('[data-toggle="tooltip"]').tooltip();
 	$('.alert').alert();

 	$('.custom_alert').delay(2000).fadeOut(1000);

 	$(".navbar-toggler").click(function () {
 		$(".navbar-collapse").toggleClass("slide_right");
 		$(".navbar-collapse").removeClass("collapsing");
 	});
 	// wow js
 	new WOW().init();

 	// contact form fade out

 	$(".delete_order").click(function () {
 		$(this).parents(".myOrders_grid > div").fadeOut(500);
 	});

 	$(".delete_row").click(function () {
 		$(this).parents("tr").fadeOut(500);
 	});


 	// bootstrap select
 	$('.selectpicker').selectpicker();

 	// navbar toggle class

 	$(".navbar-toggler").click(function () {
 		$(this).find("i").toggleClass("fa-times");
 	});

 	// toggle list 
 	$(".show_all").click(function () {
 		$(".toggle_list").slideToggle();
 		if ($(this).text() == "View All") {
 			$(this).text("View Less");
 		} else {
 			$(this).text("View All");
 		}
 	});

 	// toggle class on scroll 
 	function header_size() {
 		$(window).scroll(function () {
 			var scroll = $(window).scrollTop();

 			if (scroll > 0) {
 				$("body").addClass("scroll");
 			} else {
 				$("body").removeClass("scroll");
 			}
 		});
 	}
 	header_size();

 	// light slider

 	$('.gallery').lightSlider({
 		gallery: true,
 		item: 1,
 		thumbItem: 6,
 		slideMargin: 0,
 		speed: 500,
 		auto: true,
 		loop: true,
 		mode: "fade",
 		onSliderLoad: function () {
 			$('.gallery').removeClass('cS-hidden');
 		}
 	});

 	$('.modal').on('shown.bs.modal', function (e) {
 		$('.popular1').slick({
 			dots: false,
 			arrows: false,
 			infinite: true,
 			speed: 300,
 			autoplay: true,
 			slidesToShow: 1,
 			slidesToScroll: 1,
 			centerMode: false
 		});
 	})

 	// search page slider for popular destinations
 	$('.popular').slick({
 		dots: true,
 		arrows: false,
 		infinite: true,
 		speed: 300,
 		autoplay: true,
 		slidesToShow: 3,
 		slidesToScroll: 1,
 		centerMode: true,
 		centerPadding: '60px',
 		responsive: [
 			{
 				breakpoint: 991,
 				settings: {
 					slidesToShow: 3,
 					slidesToScroll: 1
 				}
    },
 			{
 				breakpoint: 767,
 				settings: {
 					slidesToShow: 2,
 					slidesToScroll: 1
 				}
    },
 			{
 				breakpoint: 480,
 				settings: {
 					slidesToShow: 1,
 					slidesToScroll: 1,
 					centerMode: false
 				}
    }
  ]
 	});


 });


 function delete_form(del_url){
     $form = $('<form>').attr({'action': del_url, 'method': 'POST'}).addClass('hide');
     $form.append('<input type="hidden" name="_token" value="' + $('[name="csrf_token"]').attr('content') + '">');
     $form.append('<input type="hidden" name="_method" value="DELETE">');
     $form.appendTo('body');
     $form.submit();
 }

