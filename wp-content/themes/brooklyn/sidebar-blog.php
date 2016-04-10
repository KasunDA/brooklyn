<div class="clm_side">
    <?php get_sidebar('top'); ?>
    <section class="section_block">
        <h3 class="ttl_h3">Recent</h3>
        <ul class="list list_archives">
            <?php query_posts('posts_per_page=3&category_name=blog');
                if(have_posts()):
                    while(have_posts()):
                        the_post();
            ?>
                        <li><a href="<?php the_permalink() ?>"><span class="icon-triangle-right"></span><time datetime="<?php echo the_time('Y-m-d'); ?>"><?php the_time('Y.m.d'); ?></time><br><?php the_title(); ?></a></li>
            <?php
                    endwhile;
                endif;
            ?>
        </ul>
    </section>
    <?php get_sidebar('bottom'); ?> 
</div>