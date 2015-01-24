<?php
$title = "Shop Info";
$keywords = "";
$description = "";
$home = false;
$shopTop = false;
$map = false;
$shop = "brooklyn";
?>
<?php require_once(getenv('DOCUMENT_ROOT')."/include/html-head.php"); ?>
<body>
    <?php require_once(getenv('DOCUMENT_ROOT')."/include/header.php"); ?>
    <div class="container">
        <div class="clm_main">
            <section class="section_block">
                <h1 class="ttl_h3">CONTACT</h1>
                <article>
                    <h4>電話でのお問い合わせ</h4> 
                    <p class="contact_tel"><span class="f16">TEL.</span><span class="tel_link f28">092-843-8186</span>11:00〜20:00</p>
                                       
                </article>
                <article>
                    <h4>お問い合わせフォーム</h4>
                    <form action="contact_submit" method="get" accept-charset="utf-8">
                        <dl class="list list_table">
                            <dt>住所</dt>
                            <dd>福岡市早良区西新5-4-20　<a href="https://www.google.co.jp/maps/place/%E3%80%92814-0002+%E7%A6%8F%E5%B2%A1%E7%9C%8C%E7%A6%8F%E5%B2%A1%E5%B8%82%E6%97%A9%E8%89%AF%E5%8C%BA%E8%A5%BF%E6%96%B0%EF%BC%95%E4%B8%81%E7%9B%AE%EF%BC%94%E2%88%92%EF%BC%92%EF%BC%90/@33.5816187,130.3569246,17z/data=!3m1!4b1!4m2!3m1!1s0x354193a47bdf29cf:0xfcb548c1e541b70" target="_blank">Googlemap<span class="icon-new-tab"></span></a></dd>
                            <dt>TEL/FAX</dt>
                            <dd class="tel_link">092-843-8186</dd>
                            <dt>営業時間</dt>
                            <dd>11:00～20:00</dd>
                            <dt>定休日</dt>
                            <dd>不定休</dd>
                        </dl>
                        <input type="submit" value="送信する" class="btn_send">
                    </form>



                    <p class="caption box_caption">お客様から送信いただく個人情報は、送信内容の確認とご相談・資料請求・お問い合わせに対する回答に利用を限定させていただき、責任をもって管理し第三者への開示や他の目的には使用しません。当社の個人情報保護方針についてご理解・同意のうえご記入（送信）ください。</p> 
                </article>   
            </section>
        </div>
        <?php require_once(getenv('DOCUMENT_ROOT')."/include/side.php"); ?>
    </div>
    <?php require_once(getenv('DOCUMENT_ROOT')."/include/footer.php"); ?>
</body>
</html>