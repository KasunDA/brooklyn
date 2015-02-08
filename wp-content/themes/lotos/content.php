<?php if (is_page()): ?>
<h1 class="ttl_h3"><?php the_title(); ?></h1>
<?php else: ?>
<h1 class="ttl_h3"><?php the_title(); ?><time datetime="<?php echo the_time('Y-m-d'); ?>"><?php the_time('Y.m.d'); ?></time></h1>
<?php endif; ?>
<?php the_content(); ?>