<?php get_template_part('html-head'); ?>
<body>
    <?php get_header(); ?>
    <div class="container">
        <div class="clm_main">
            <section class="section_block">
                <?php 
                    if (have_posts()) :
                        while (have_posts()) :
                            the_post();
                            get_template_part('content');
                        endwhile;
                    endif;
                ?>
            </section>
        </div>
        <?php get_sidebar(); ?>
    </div>
    <?php get_footer(); ?>
</body>
</html>