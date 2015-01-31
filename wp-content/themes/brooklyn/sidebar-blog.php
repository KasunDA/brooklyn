<div class="clm_side">
    <section class="section_block ">
        <form role="search" method="get" id="searchform" class="searchform" action="http://brooklyn/brooklyn/">
            <div>
                <input type="text" placeholder="Search..." name="s" id="s">
                <button type="submit" id="search_submit"><span class="icon-search"></span></button>
            </div>
        </form>
    </section>
    <section class="section_block">
        <h3 class="ttl_h3">Recent</h3>
        <ul class="list list_archives">
            <?php query_posts('posts_per_page=3&category_name=blog');
                if(have_posts()):
                    while(have_posts()):
                        the_post();
            ?>
                        <li><a href="<?php the_permalink() ?>"><span class="icon-triangle-right"></span><?php the_title(); ?></a></li>
            <?php
                    endwhile;
                endif;
            ?>
        </ul>
    </section>
    <section class="section_block">
        <h3 class="ttl_h3">Archives</h3>
        <ul class="list list_archives">
            <?php
            //IDを指定
              $cat_ID = 1;
              wp_get_cat_archives('type=monthly', $cat_ID);
            ?>
        </ul>
    </section>
    <section class="section_block">
        <h3 class="ttl_h3">Shop Info</h3>
        <dl class="list list_shop-info">
            <dt>Access</dt>
            <dd>福岡市早良区西新5-4-20</dd>
            <dt>Time</dt>
            <dd>11:00～20:00</dd>
            <dt>Tel/Fax</dt>
            <dd class="tel_link">092-843-8186</a></dd>            
        </dl>
    </section>
    <section class="section_block">
        <ul class="list_bnr">
            <li><a href=""><img src="/assets/img/common/bnr_lotus.png" width="200" alt=""></a></li>
            <li><a href=""><img src="/assets/img/common/bnr-inst_brooklyn.png" width="200" alt=""></a></li>
        </ul>   
    </section>  
</div>