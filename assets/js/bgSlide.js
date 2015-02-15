$(function(){
	$.ajaxSetup({cache:false});

	$('body').prepend(
		'<div id="fullbg_base"><div id="fullbg_stretch">' +
		'<img src="img/photo1.jpg">' +
		'<img src="img/photo2.jpg">' +
		'<img src="img/photo3.jpg">' +
		'<img src="img/photo4.jpg">' +
		'<img src="img/photo5.jpg">' +
		'</div></div>'
	);

	$(window).load(function(){
		var fadeSpeed = 1500;
		var switchDelay = 5000;

		var baseId = '#fullbg_base';
		var stretchId = '#fullbg_stretch';
		var stretchImg = $(stretchId).children('img');

		$(baseId).css({top:'0',left:'0',position:'absolute',zIndex:'-1'});
		$(stretchId).css({top:'0',left:'0',position:'fixed',zIndex:'-1',overflow:'hidden'});
		$(stretchImg).css({top:'0',left:'0',position:'absolute',visibility:'hidden'});
		selfWH = stretchImg.width() / stretchImg.height();

		function bgAdjust(){
			var bgWidth = $(window).width(),
			bgHeight = bgWidth / selfWH;

			if(bgHeight < $(window).height()){
				bgHeight = $(window).height();
				bgWidth = bgHeight * selfWH;
			}
			$(stretchId).css({width:bgWidth,height:bgHeight});
			$(stretchImg).css({width:bgWidth,height:bgHeight});
		}
		bgAdjust();
		$(window).bind('load resize',function(){bgAdjust()});

		$(stretchId).children('img').css({visibility:'visible',opacity:'0'});
		$(stretchId + ' img:first').stop().animate({opacity:'1',zIndex:'10'},fadeSpeed);

		setInterval(function(){
			$(stretchId + ' :first-child').animate({opacity:'0'},fadeSpeed).next('img').animate({opacity:'1'},fadeSpeed).end().appendTo(stretchId);
		},switchDelay);

		// コンテンツ部分の背景オーバーレイ
		var contentsHeight = $('#contents').height();
		$('#contents').prepend('<div id="overlaybg"></div>');
		$('#overlaybg').css({height:(contentsHeight),opacity:'0.3'});
	});
});
