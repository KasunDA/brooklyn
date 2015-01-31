<?php get_template_part('html-head'); ?>
<body>
    <?php get_header(); ?>
    <div class="container">
        <div class="clm_main">
            <section class="section_block">
            <h1 class="ttl_h3">「<?php the_search_query(); ?>」の検索結果</h1>
                <ul class="list list_news">
                <?php 
                    if(have_posts() && get_search_query()) :
                        while (have_posts()) :
                            the_post();
                ?>
                            <li><a href="<?php the_permalink(); ?>"><span class="indent"><span><?php the_title(); ?></span></span></a></li>
                <?php
                        endwhile; ?>
                        </ul>
                <?php
                    else :
                 ?>
                <p>該当する記事が存在していません。</p>
                <?php
                    endif;
                ?>
            </section>
            <?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } ?>
        </div>
        <?php get_sidebar(); ?>
    </div>
    <?php get_footer(); ?>
</body>
</html>