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
    <dt>Name<span>*</span></dt>
    <dd>[text* your-name]</dd>
    <dt>Kana<span>*</span></dt>
    <dd>[text* furigana]</dd>
    <dt>Gender<span>*</span></dt>
    <dd>[radio gender use_label_element "男性" "女性"]</dd>
    <dt>Tel</dt>
    <dd>[tel tel]</dd>
    <dt>Mailaddress<span>*</span></dt>
    <dd>[email* your-email]</dd>
    <dt>Title<span>*</span></dt>
    <dd>[text your-subject]</dd>
    <dt>Message<span>*</span></dt>
    <dd>[textarea your-message]</dd>
</dl>
                        [submit class:btn_send]



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