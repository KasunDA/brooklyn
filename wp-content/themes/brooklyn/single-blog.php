<?php get_template_part('html-head'); ?>
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

                <?php

                    //チェックするURL
                    $url = get_the_permalink();
                    //$url = "http://creatorclip.info/2014/01/sns-btn-original-design/";  

                    //ツイッター
                    //-------------------------------------------
                    //JSONデータを取得
                    $json_twitter = @file_get_contents("http://urls.api.twitter.com/1/urls/count.json?url=".rawurlencode($url));
                    //JSONデータを連想配列に直す
                    $array_twitter = json_decode($json_twitter,true);
                    //カウント
                    $count_twitter = $array_twitter["count"];

                    //facebook
                    //-------------------------------------------
                    //JSONデータを取得
                    $json_facebook = @file_get_contents("http://graph.facebook.com/?id=".rawurlencode($url));
                    //JSONデータを連想配列に直す
                    $array_facebook = json_decode($json_facebook,true);
                    //カウント(プロパティが存在しない場合は0扱い)
                    if(isset($array_facebook["shares"])){
                        $count_facebook = $array_facebook["shares"];
                    }else{
                        $count_facebook = 0;
                    }

                    //google
                    //-------------------------------------------
                    //CURLを利用してJSONデータを取得
                    $ch = curl_init();
                    curl_setopt( $ch, CURLOPT_URL, "https://clients6.google.com/rpc?key=AIzaSyCKSbrvQasunBoV16zDH9R33D88CeLr9gQ" );
                    curl_setopt( $ch, CURLOPT_POST, 1 );
                    curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
                    curl_setopt( $ch, CURLOPT_POSTFIELDS, '[{"method":"pos.plusones.get","id":"p","params":{"nolog":true,"id":"' . $url . '","source":"widget","userId":"@viewer","groupId":"@self"},"jsonrpc":"2.0","key":"p","apiVersion":"v1"}]' );
                    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
                    curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Content-type: application/json' ) );
                    $result = curl_exec( $ch );
                    curl_close( $ch );
                    //JSONデータからカウント数を取得
                    $obj = json_decode( $result, true );
                    //カウント(データが存在しない場合は0扱い)
                    if(!isset($obj[0]['result']['metadata']['globalCounts']['count'])){
                        $count_google = 0;
                    }else{
                        $count_google = $obj[0]['result']['metadata']['globalCounts']['count'];
                    }

                ?>              

                <div class="box_sns">
                    <ul>
                        <li class="sns_twitter">
                            <span class="count"><?php echo number_format($count_twitter) ?></span>
                            <a href="http://twitter.com/share?count=horizontal&original_referer=<?php echo the_permalink(); ?>&text=<?php the_title(); ?>&url=<?php echo the_permalink(); ?>" onclick="window.open(encodeURI(decodeURI(this.href)), 'tweetwindow', 'width=550, height=450, personalbar=0, toolbar=0, scrollbars=1, resizable=1' ); return false;" target="_blank"><span class="icon-twitter"></span></a></a>
                        </li>
                        <li class="sns_facebook">
                            <span class="count"><?php echo number_format($count_facebook) ?></span>
                            <a href="http://www.facebook.com/share.php?u=<?php the_title(); ?>" onclick="window.open(this.href, 'window', 'width=550, height=450,personalbar=0,toolbar=0,scrollbars=1,resizable=1'); return false;"><span class="icon-facebook"></span></a>
                        </li>
                        <li class="sns_google">
                            <span class="count"><?php echo number_format($count_google) ?></span>
                            <a href="https://plus.google.com/share?url=<?php echo the_permalink(); ?>" onclick="window.open(this.href, 'Gwindow', 'width=650, height=450, menubar=no, toolbar=no, scrollbars=yes'); return false;"><span class="icon-google-plus"></span></a>
                        </li>
                    </ul>
                </div>
            </section>
        </div>
        <?php get_sidebar('blog'); ?>
    </div>
    <?php get_footer(); ?>
</body>
</html>