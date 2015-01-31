<?php get_template_part('html-head'); ?>
<body>
    <?php get_header(); ?>
    <div class="container">
        <div class="clm_main">
            <section class="section_block">
                <h1 class="ttl_h3">News<span class="more"><a href="<?php echo get_term_link('news','category'); ?>"><span class="icon-arrow"></span>News Top</a></span></h1>
                <ul class="list list_news">
                    <?php query_posts('posts_per_page=5&category_name=news');
                        if(have_posts()):
                            while(have_posts()):
                                the_post();
                                get_template_part('content-archive');
                            endwhile;
                        endif;
                    ?>
                </ul>
            </section>
            <section class="section_block">
                <h1 class="ttl_h3">Blog<span class="more"><a href="<?php echo get_term_link('blog','category'); ?>"><span class="icon-arrow"></span>Blog Top</a></span></h1>
                <div class="wrapper_blog">
                    <?php query_posts('posts_per_page=6&category_name=blog');
                        if(have_posts()):
                            while(have_posts()):
                                the_post();
                                get_template_part('content-archive');
                            endwhile;
                        endif;
                    ?>
                </div>
            </section>
        </div>
        <?php get_sidebar(); ?>
    </div>
    <?php get_footer(); ?>
</body>
</html>