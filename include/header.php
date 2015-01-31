<header>
    <div class="header_top">
        <div class="header_top-wrapper">
            <h1 class="ttl_h1">福岡市早良区西新にあるセレクトショップのBROOKLYN(ブルックリン)</h1>
            <ul>
                <li><a href="/<?php echo $shop?>/">BROOKLYN</a></li>
                <li><a href="/lotus/">LOTUS</a></li>
            </ul>
        </div>
    </div>
    <section class="header_bottom">
        <h1 class="ttl_h2"><a href="/<?php echo $shop?>/">BROOKLYN</a></h1>
        <p class="nav_menu"><span class="icon-menu"></span></p>
        <nav class="header_nav"> 
            <?php echo get_search_form(); ?>
            <ul class="nav_global">
                <li class="active"><a href="/<?php echo $shop?>/">Top</a></li>
                <li><a href="/<?php echo $shop?>/news/">News</a></li>
                <li><a href="/<?php echo $shop?>/blog/">Blog</a></li>
                <li><a href="/<?php echo $shop?>/shop-info/">Shop Info</a></li>
                <li><a href="/<?php echo $shop?>/list-brands/">List of brands</a></li>
            </ul>
            <ul class="nav_sns">
                <li class="nav_sns-rss"><a href=""><span class="icon-feed2"></span></a></li>
                <li class="nav_sns-contact"><a href=""><span class="icon-envelop"></span></a></li>
                <li class="nav_sns-twitter"><a href=""><span class="icon-twitter"></span></a></li>
                <li class="nav_sns-facebook"><a href=""><span class="icon-facebook"></span></a></li>
            </ul>
        </nav>
    </section>
</header>
<?php if($shopTop == true ) { ?>
<p class="visual_main"><img src="/assets/img/common/visual_brooklyn.png" width="960" alt=""></p>
<?php } else { ?>
<div class="breadcrumb">
    <ul id="breadcrumb_list">
        <li itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
            <a href="/" itemprop="url">
                <span itemprop="title">HOME</span>
            </a>&nbsp;&gt;&nbsp;
        </li>
        <li itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
            <a href="/<?php echo $shop?>/" itemprop="url">
                <span itemprop="title">BROOKLYN TOP</span>
            </a>&nbsp;&gt;&nbsp;
        </li>
        <li>News</li>
    </ul>
</div>
<?php } ?>