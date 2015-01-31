<?php get_template_part('html-head'); ?>
<body>
    <?php get_header(); ?>
    <div class="container">
        <div class="clm_main">
            <section class="section_block">
                <h1 class="ttl_h3">News<span class="more"><a href="/<?php echo $shop?>/news/"><span class="icon-arrow"></span>News Top</a></span></h1>
                <ul class="list list_news">
                    <li><a href=""><span class="indent"><time>2012.12.22</time><span>冬期休暇のお知らせ冬期休暇のお知らせ冬期休暇のお知らせ冬期休暇のお知らせ</span></span></a></li>
                    <li><a href=""><span class="indent"><time>2012.12.22</time><span>冬期休暇のお知らせ</span></span></a></li>
                    <li><a href=""><span class="indent"><time>2012.12.22</time><span>冬期休暇のお知らせ</span></span></a></li>
                </ul>
            </section>
            <section class="section_block">
                <h1 class="ttl_h3">Blog<span class="more"><a href="/<?php echo $shop?>/news/"><span class="icon-arrow"></span>Blog Top</a></span></h1>
                <div class="wrapper_blog">
                    <div class="block_bolg">
                        <figure><a href=""><span class="icon_new">New</span><img src="/assets/img/common/img_sample.png" width="220" alt=""></a></figure>
                        <time>2012.12.22</time>
                        <p class="ttl_blog"><a href="">新作入荷しました。</a></p>
                        <p>新作の人気バックを入荷いたしました。場所を選ばないデザインでどこでも持ち運びOKな一品になって...</p>
                        <p class="tag"><a href="">カバン</a>,<a href="">カバン</a>,<a href="">カバン</a>,<a href="">カバン</a></p>
                    </div>
                    <div class="block_bolg">
                        <figure><a href=""><span class="icon_new">New</span><img src="/assets/img/common/img_sample.png" width="220" alt=""></a></figure>
                        <time>2012.12.22</time>
                        <p class="ttl_blog"><a href="">新作入荷しました。</a></p>
                        <p>新作の人気バックを入荷いたしました。場所を選ばないデザインでどこでも持ち運びOKな一品になって...</p>
                        <p class="tag"><a href="">カバン</a>,<a href="">カバン</a>,<a href="">カバン</a>,<a href="">カバン</a></p>
                    </div>
                    <div class="block_bolg">
                        <figure><a href=""><span class="icon_new">New</span><img src="/assets/img/common/img_sample.png" width="220" alt=""></a></figure>
                        <time>2012.12.22</time>
                        <p class="ttl_blog"><a href="">新作入荷しました。</a></p>
                        <p>新作の人気バックを入荷いたしました。場所を選ばないデザインでどこでも持ち運びOKな一品になって...</p>
                        <p class="tag"><a href="">カバン</a>,<a href="">カバン</a>,<a href="">カバン</a>,<a href="">カバン</a></p>
                    </div>
                </div>
            </section>
        </div>
        <?php get_sidebar(top); ?>
    </div>
    <?php get_footer(); ?>
</body>
</html>