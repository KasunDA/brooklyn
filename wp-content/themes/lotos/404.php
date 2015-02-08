<?php get_template_part('html-head'); ?>
<body>
    <?php get_header(); ?>
    <div class="container">
        <div class="clm_main">
            <section class="section_block">
                <article>
                    <h1 class="ttl_h3">404 Not found</h1>
                    <p>お探しのページは見つかりません。<br>一時的にアクセスできない状況か移動もしくは削除されてしまった可能性があります。</p>
                    <p><a href="<?php echo home_url('/') ?>">TOPページに戻る</a></p>                  
                </article>
            </section>
        </div>
        <?php get_sidebar(); ?>
    </div>
    <?php get_footer(); ?>
</body>
</html>