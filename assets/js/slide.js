$(function(){

    var slideUl = $('.visual_main'); // スライド対象
    var slideLi = slideUl.find('li');
    var slideImg = slideLi.find('img');
    var slideLiLast = slideLi.index();
    var slideLiFirst = slideUl.find('li:first');
    var interval = 6000; // 切り替わりの間隔（ミリ秒）
    var fade_speed = 2000; // フェード処理の早さ（ミリ秒）

    slideLi.hide();
    slideLiFirst.addClass("active").show();

    setInterval(function(){
    var active = slideUl.find('.active');
    var next = active.next("li").length ? active.next("li") : slideLiFirst;
        active.fadeOut(fade_speed).removeClass("active");
        next.fadeIn(fade_speed).addClass("active");
    },interval);

    $(window).bind("load resize", slideHeight);//ウィンドウが『読込み』もしくは『ウィンドウサイズ変更』された時、関数『slideHeight』を実行
    function slideHeight(){//下記の処理を関数『slideHeight』として定義する
        var activeImg = slideUl.find('.active').find('img');
        var height = activeImg.height();//slideimgの高さを取得
        slideUl.css( "height" , height );
    }

});



