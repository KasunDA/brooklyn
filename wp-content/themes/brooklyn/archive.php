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
        <div class="clm_main">
            <section class="section_block">
                <h1 class="ttl_h3"><?php single_cat_title(); ?></h1>
                <?php if(is_category('news')): ?>
                <ul class="list list_news">
                <?php else: ?>
                <div class="wrapper_blog">
                <?php endif; ?>
                    <?php 
                        if (have_posts()) :
                            while (have_posts()) :
                                the_post();
                                get_template_part('content-archive');
                            endwhile;
                        endif;
                    ?>
                <?php if(is_category('news')): ?>
                </ul>
                <?php else: ?>
                </div>
                <?php endif; ?>   
            </section>
            <?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } ?>
        </div>
        <?php get_sidebar(); ?>
    </div>
    <?php get_footer(); ?>
</body>
</html>