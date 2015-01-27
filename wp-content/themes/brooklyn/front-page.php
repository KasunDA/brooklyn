<?php require_once(getenv('DOCUMENT_ROOT')."/wp-content/themes/brooklyn/html-head.php"); ?>
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
                    ?>
                    <li><a href="<?php the_permalink(); ?>"><span class="indent"><time datetime="<?php echo the_time('Y-m-d'); ?>"><?php the_time('Y.m.d'); ?></time><span><?php the_title(); ?></span></span></a></li>
                    <?php 
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
                    ?>
                    <div class="block_bolg">
                        <figure><a href="<?php the_permalink(); ?>"><span class="icon_new">New</span><?php the_post_thumbnail('thumbnail'); ?></a></figure>
                        <time datetime="<?php echo the_time('Y-m-d'); ?>"><?php the_time('Y.m.d'); ?></time>
                        <p class="ttl_blog">
                            <a href="<?php the_permalink(); ?>">
                                <?php
                                if(mb_strlen($post->post_title)>12) { 
                                    $title= mb_substr($post->post_title,0,12) ; echo $title. "..." ;
                                } else {
                                    echo $post->post_title;
                                }?>
                            </a>
                        </p>
                        <p><?php echo mb_substr(get_the_excerpt(), 0, 40); ?>...</p>
                        <p class="tag"><?php the_tags(""); ?></p>
                    </div>
                    <?php 
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