<?php get_template_part('facebook'); ?>
<!--[if lt IE 9]>
<div class="ie-prompt">
    <p>お使いのブラウザはバージョンが古いため、サイトを快適にご利用いただけないかもしれません。<br>
        <a href="http://www.whatbrowser.org/intl/ja/">新しいブラウザをお試しできます。
            ブラウザは無料、インストールも簡単です。</a>
    </p>
</div>
<![endif]-->
<header>
    <div class="header_top">
        <div class="header_top-wrapper">
        <?php if (is_front_page()): ?>
            <h1 class="ttl_h1"><?php bloginfo('name'); ?></h1>
        <?php else: ?>
            <h1 class="ttl_h1"><?php wp_title('',true); ?> | <?php bloginfo('name'); ?></h1>
        <?php endif; ?>
            <ul>
                <li><a href="/brooklyn/">BROOKLYN</a></li>
                <li><a href="/lotus/">LOTUS</a></li>
            </ul>
        </div>
    </div>
    <section class="header_bottom">
        <h1 class="ttl_h2"><a href="<?php echo home_url('/') ?>">BROOKLYN</a></h1>
        <p class="nav_menu"><span class="icon-menu"></span></p>
        <nav class="header_nav"> 
            <form role="search" method="get" id="searchform" class="searchform nav_search" action="<?php echo home_url('/') ?>">
                <div>
                    <input type="text" placeholder="Search..." name="s" id="s">
                    <button type="submit" id="search_submit"><span class="icon-search"></span></button>
                </div>
            </form>
            <?php wp_nav_menu(array(
                    'container' => 'nav',
                    'container_class' => 'nav_global',
                    'theme_location' => 'place_global',
                ));
            ?>
            <ul class="nav_sns">
                <li class="nav_sns-rss"><a href="<?php echo home_url('/feed/') ?>" target=_blank><span class="icon-feed2"></span></a></li>
                <li class="nav_sns-contact"><a href="<?php echo home_url('/contact/'); ?>"><span class="icon-envelop"></span></a></li>
                <li class="nav_sns-twitter"><a href="http://twitter.com/share?count=horizontal&original_referer=<?php echo home_url('/') ?>&text=<?php bloginfo('name'); ?>&url=<?php echo home_url('/') ?>" onclick="window.open(encodeURI(decodeURI(this.href)), 'tweetwindow', 'width=550, height=450, personalbar=0, toolbar=0, scrollbars=1, resizable=1' ); return false;" target="_blank"><span class="icon-twitter"></span></a></li>
                <li class="nav_sns-facebook"><a href="http://www.facebook.com/share.php?u=<?php echo home_url('/') ?>" onclick="window.open(this.href, 'window', 'width=550, height=450,personalbar=0,toolbar=0,scrollbars=1,resizable=1'); return false;"><span class="icon-facebook"></span></a></li>
                <li class="nav_sns-google"><a href="https://plus.google.com/share?url=<?php echo home_url('/') ?>" onclick="window.open(this.href, 'Gwindow', 'width=650, height=450, menubar=no, toolbar=no, scrollbars=yes'); return false;"><span class="icon-google-plus"></span></a></li>
            </ul>
        </nav>
    </section>
</header>
<?php if (is_front_page()): ?>
<div class="visual_main-wrapper">
    <ul class="visual_main">
        <li><img src="/assets/img/shop-top/visual_brooklyn01.png" width="960" alt=""></li>
        <li><img src="/assets/img/shop-top/visual_brooklyn02.png" width="960" alt=""></li>
        <li><img src="/assets/img/shop-top/visual_brooklyn03.png" width="960" alt=""></li>
        <li><img src="/assets/img/shop-top/visual_brooklyn04.png" width="960" alt=""></li>
        <li><img src="/assets/img/shop-top/visual_brooklyn05.png" width="960" alt=""></li>
    </ul>
</div>
<?php endif; ?>
<?php breadcrumb(); ?>

