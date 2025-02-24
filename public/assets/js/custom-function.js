$('#navbarSupportedContent li').hover(function () {
	console.log($(this).has('div'));
	$(this).parent().find('.active').addClass('realactive').removeClass('active');
}).mouseout(function(){
	$(this).parent().find('.realactive').addClass('active').removeClass('realactive');
});
