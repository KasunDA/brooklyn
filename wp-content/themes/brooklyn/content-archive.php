<?php if(is_category('news')): ?>
<li><a href="<?php the_permalink(); ?>"><span class="indent"><time datetime="<?php echo the_time('Y-m-d'); ?>"><?php the_time('Y.m.d'); ?></time><span><?php the_title(); ?></span></span></a></li>
<?php else: ?>
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
<?php endif; ?>
