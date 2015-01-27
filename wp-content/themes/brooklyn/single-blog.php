<?php
$title = "ああ";
$keywords = "";
$description = "";
$home = false;
$shopTop = true;
$shop = "brooklyn";
?>
<?php require_once(getenv('DOCUMENT_ROOT')."/wp-content/themes/brooklyn/html-head.php"); ?>
<body>
    <?php get_header(); ?>
    <div class="container">
        <div class="clm_main clm_blog">
            <div class="clm_blog-left">
                <h1 class="ttl_h2-blog"><img src="/assets/img/blog/ttl_brooklyn.png" width="149" alt=""><br>福岡市早良区西新にある<br>
                ブルックリンのブログです。<br>
                トップス、ボトムスから<br>
                バッグ、小物まで幅広く<br>
                紹介させていただきます。</h1>
            </div>
            <section class="section_block clm_blog-right">
                <article>
                    <h2 class="ttl_h3 ttl_h3-blog"><?php the_title(); ?></h2>
                    <ul class="post_meta">
                        <li><time datetime="<?php echo the_time('Y-m-d'); ?>"><?php the_time('Y.m.d'); ?></time></li>
                        <li class="tag"><?php the_tags(""); ?></li>
                    </ul>
                    <?php the_post_thumbnail(); ?>
                    <?php 
                        if ( have_posts() ) {
                            while ( have_posts() ) {
                                the_post(); 
                                the_content();
                            }
                        }
                    ?>      
                </article>
            </section>
        </div>
        <?php get_sidebar(); ?>
    </div>
    <?php get_footer(); ?>
</body>
</html>