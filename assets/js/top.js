$(window).on('load resize', function(){
	var footerHeight = $("footer").height();
	var height = $(window).height() - footerHeight;
		$(".visual").css( "height" , height );
		$(".visual a").css( "line-height" , height+"px" );
});
$(function(){
    var slideUl = $('.box_bg'); // スライド対象
    var slideLi = slideUl.find('li');
    var slideLiLast = slideLi.index();
    var slideLiFirst = slideUl.find('li:first');
    var delay = 2000; // 遅延時間
    var interval = 10000; // 切り替わりの間隔（ミリ秒）
    var fade_speed = 2000; // フェード処理の早さ（ミリ秒）
	function loopSlide() {
		slideLi.hide();
		slideLiFirst.addClass("active").show();
        var slide = setInterval(function(){
            var active = slideUl.find('.active');
            var next = active.next("li").length ? active.next("li") : slideLiFirst;
            active.fadeOut(fade_speed,function(){
                $(this).removeClass("active");
            });
            next.fadeIn(fade_speed).addClass("active");
        },interval);
    };
    loopSlide();
});