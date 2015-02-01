$(window).load(function(){
    $(".block_bolg").tile(3);
    $(".txt_blog").tile(3);
    $(".ttl_blog").tile(3);
    var ua = navigator.userAgent;
    if(ua.indexOf('iPhone') > 0 || ua.indexOf('Android') > 0){
       $(".block_bolg").tile(2);
       $(".txt_blog").tile(2);
       $(".ttl_blog").tile(2);
    }
});
$(function(){
    //menuアコーディオン
    $(".nav_menu").on("click", function() {
        $(this).next().slideToggle();
    });
    /*ページトップ*/
    var pagetop = $('.pagetop');
    pagetop.click(function () {
        $('body, html').animate({ scrollTop: 0 }, 500);
            return false;
    });
    /*クリックボックス*/
    // $(".clickbox").click(function(){
    //      if($(this).find("a").attr("target")=="_blank"){
    //          window.open($(this).find("a").attr("href"), '_blank');
    //      }else{
    //          window.location=$(this).find("a").attr("href");
    //      }
    //  return false;
    //  });
    //スマホ時に電話リンク追加
    var ua = navigator.userAgent;
    if(ua.indexOf('iPhone') > 0 || ua.indexOf('Android') > 0){
        $('.tel_link').each(function(){
            var str = $(this).text();
            $(this).html($('<a class="inline">').attr('href', 'tel:' + str.replace(/-/g, '')).append(str + '</a>'));
        });
    }
    $(window).bind("load resize", init);//ウィンドウが『読込み』もしくは『ウィンドウサイズ変更』された時、関数『init』を実行
    function init(){//下記の処理を関数『init』として定義する
        var _width = $(window).width();//デバイス（ウィンドウ）幅を取得
        if(_width <= 768){
            //デバイス（ウィンドウ）幅が768px以下の時の処理
            $(".txt_blog").tile(2); 
            $(".block_bolg").tile(2);
            $(".ttl_blog").tile(2);
        }else{
            //『デバイス（ウィンドウ）幅が768px以下』以外のときの時の処理  
            $(".block_bolg").tile(3);
            $(".txt_blog").tile(3);
            $(".ttl_blog").tile(3);
        }
    }//init
});