<?php get_template_part('facebook'); ?>
<header>
    <div class="header_top">
        <div class="header_top-wrapper">
            <h1 class="ttl_h1">福岡市早良区西新にあるセレクトショップのBROOKLYN(ブルックリン)</h1>
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
            <form role="search" method="get" id="searchform" class="searchform nav_search" action="http://brooklyn/brooklyn/">
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
                <li class="nav_sns-twitter"><a href=""><span class="icon-twitter"></span></a></li>
                <li class="nav_sns-facebook"><a href=""><span class="icon-facebook"></span></a></li>
            </ul>
        </nav>
    </section>
</header>
<?php if (is_front_page()): ?>
<p class="visual_main"><img src="/assets/img/common/visual_brooklyn.png" width="960" alt=""></p>
<?php endif; ?>
<?php breadcrumb(); ?>

