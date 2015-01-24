$(window).load(function(){
    /*高さ揃え*/
    // $(".point_txt").tile(2);
});
$(function(){

     $(function(){
        $(".nav_menu").on("click", function() {
            $(this).next().slideToggle();
        });
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
});