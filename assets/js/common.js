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
});