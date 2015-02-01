$(window).on('load resize', function(){
	var footerHeight = $("footer").height() + 60;
	var height = $(window).height() - footerHeight;
		$(".visual").css( "height" , height );
		$(".visual a").css( "line-height" , height+"px" );
});