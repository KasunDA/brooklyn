$(window).load(function(){
    /*高さ揃え*/
    $(".point_txt").tile(2);
    $(".block_qa dt").tile(3);
    $(".block_qa dd").tile(3);
});
$(function(){
    /*ページトップ*/
    var pagetop = $('.footer_middle-pagetop');
    pagetop.click(function () {
        $('body, html').animate({ scrollTop: 0 }, 500);
            return false;
    });

    /*クリックボックス*/
    $(".clickbox").click(function(){
         if($(this).find("a").attr("target")=="_blank"){
             window.open($(this).find("a").attr("href"), '_blank');
         }else{
             window.location=$(this).find("a").attr("href");
         }
     return false;
     });

    /*スクロールバー*/
    $('.area_scroll').jScrollPane();

    /*フッターバナー*/
    // var $elem = $(".footer_top"), //表示の操作をするオブジェクト(フッター)
    //     $content = $(".footer"), //表示を変更する基準となるオブジェクト
    //     $win = $(window); //windowオブジェクト
    // var contentTop = 0; //表示変更をする基準点
    // $win.load(function(){
    //     updatePosition();
    //     update();
    // })
    // .resize(function(){
    //     updatePosition();
    //     update();
    // })
    // .scroll(function(){
    //     update();
    // });
    // // HTMLが動的に変わることを考えて、contentTopを最新の状態に更新します
    // function updatePosition(){
    //     contentTop = $content.offset().top + $elem.outerHeight();
    // }
    // // スクロールのたびにチェック
    // function update(){
    //     // 現在のスクロール位置 + 画面の高さで画面下の位置を求めます
    //     if( $win.scrollTop() + $win.height() > contentTop ){
    //         $elem.addClass("static");
    //     }else if( $elem.hasClass("static") ){
    //         $elem.removeClass("static");
    //     }
    // }
    // $elem.hide();
    // $(window).scroll(function () {
    //     if ($(this).scrollTop() > 300) {
    //         $elem.fadeIn();
    //     } else {
    //         $elem.fadeOut();
    //     }
    // });
});