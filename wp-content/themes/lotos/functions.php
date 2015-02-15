<?php 

//投稿画像のリンク削除
// ----------------------------------------------------------------------
add_filter( 'the_content', 'attachment_image_link_remove_filter' );
function attachment_image_link_remove_filter( $content ) {
	$content =  preg_replace(  array('{<a(.*?)(wp-att|wp-content/uploads)[^>]*><img}',  '{ wp-image-[0-9]*" /></a>}'), array('<img','" />'),  $content  );
	return $content;
}

//カスタムメニュー
// ----------------------------------------------------------------------
register_nav_menus(
	array(
		'place_global' => 'グローバル',
		'place_utility' => 'ユーティリティー',
	)
 );

//アイキャッチ画像を利用できるようにします
// ----------------------------------------------------------------------
add_theme_support( 'post-thumbnails' );
/*アイキャッチ画像サイズ設定*/
set_post_thumbnail_size(1500, 1900, true );
/*サムネイル*/
add_image_size( 'thumbnail', 880, 1120, true );


//ogp用ディスクプリション表示
// ----------------------------------------------------------------------
function get_ogp_txt($content) {
	$content = strip_tags($content);
	$content = mb_substr($content,0,120,'UTF-8');
	$content = preg_replace('/¥s¥s+/', '', $content);
	$content = preg_replace('/[¥r¥sn]/', '', $content);
	$content = esc_attr($content). '...';
	return $content;
}

//検索キーワードが未入力、または0の場合にsearch.phpをテンプレートとして使用する。
// ----------------------------------------------------------------------
function search_template_redirect() {
	global $wp_query;
	$wp_query->is_search = true;
	$wp_query->is_home = false;
	if (file_exists(TEMPLATEPATH . '/search.php')) {
		include(TEMPLATEPATH . '/search.php');
		}
		exit;
}
if (isset($_GET['s']) && $_GET['s'] == false) {
	add_action('template_redirect', 'search_template_redirect');
}

// パンくずリスト
// ----------------------------------------------------------------------
function breadcrumb(){
	global $post;
	$str ='';
	if(!is_front_page()&&!is_admin()){ /* !is_admin は管理ページ以外という条件分岐 */
		$str.= '<div class="breadcrumb">';
		$str.= '<ul id="breadcrumb_list">';
		$str.= '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
					<a href="'. home_url() .'/" itemprop="url">
						<span itemprop="title">HOME</span>
					</a>&nbsp;&gt;&nbsp;
				</li>';
		if(is_search()){
			$str.='<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb">「'. get_search_query() .'」で検索した結果</li>';
		} elseif(is_tag()){
			$str.='<li>タグ : '. single_tag_title( '' , false ). '</li>';
		} elseif(is_404()){
			$str.='<li>404 Not found</li>';
		} elseif(is_date()){
			if(get_query_var('monthnum') != 0){
				$category = get_the_category(); 
					if ( $category[0] ) {
					$str.='<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="' . get_category_link( $category[0]->term_id ) . '">' . $category[0]->cat_name . '</a>&nbsp;&gt;&nbsp;</li>';
					}
				$str.='<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb">'.get_query_var('year').'.'.get_query_var('monthnum'). '</li>';
			} else {
				$str.='<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb">'. get_query_var('year') .'年</li>';
			}
		} elseif(is_category()) {
			$cat = get_queried_object();
			if($cat -> parent != 0){
				$ancestors = array_reverse(get_ancestors( $cat -> cat_ID, 'category' ));
				foreach($ancestors as $ancestor){
					$str.='<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'. get_category_link($ancestor) .'"><span itemprop="title">'. get_cat_name($ancestor) .'</span></a>&nbsp;&gt;&nbsp;</li>';
			}
			}
			$str.='<li>'. $cat -> name . '</li>';
		} elseif(is_author()){
			$str .='<li>投稿者 : '. get_the_author_meta('display_name', get_query_var('author')).'</li>';
		} elseif(is_page()){
			if($post -> post_parent != 0 ){
				$ancestors = array_reverse(get_post_ancestors( $post->ID ));
				foreach($ancestors as $ancestor){
					$str.='<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'. get_permalink($ancestor).'">'. get_the_title($ancestor) .'</a><&nbsp;&gt;&nbsp;/li>';
			}
			}
			$str.= '<li>'. $post -> post_title .'</li>';
			
		} elseif(is_attachment()){
			if($post -> post_parent != 0 ){
				$str.= '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'. get_permalink($post -> post_parent).'"><span itemprop="title">'. get_the_title($post -> post_parent) .'</span></a>&nbsp;&gt;&nbsp;</li>';
			}
			$str.= '<li>' . $post -> post_title . '</li>';
		} elseif(is_single()){
			$categories = get_the_category($post->ID);
			$cat = $categories[0];
			if($cat -> parent != 0){
				$ancestors = array_reverse(get_ancestors( $cat -> cat_ID, 'category' ));
				foreach($ancestors as $ancestor){
					$str.='<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'. get_category_link($ancestor).'"><span itemprop="title">'. get_cat_name($ancestor). '</span></a>&nbsp;&gt;&nbsp;</li>';
			}
			}
			$str.='<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'. get_category_link($cat -> term_id). '"><span itemprop="title">'. $cat-> cat_name . '</span></a>&nbsp;&gt;&nbsp;</li>';
		$str.= '<li>'. $post -> post_title .'</li>';
		} else{
			$str.='<li>'. wp_title('', false) .'</li>';
		}
		$str.='</ul>';
		$str.='</div>';
	}
	echo $str;
}





// 月間アーカイブ
// ----------------------------------------------------------------------
function wp_get_archives2( $args = '' ) {
	global $wpdb, $wp_locale;

	$defaults = array(
		'type' => 'monthly', 'limit' => '',
		'format' => 'html', 'before' => '',
		'after' => '', 'show_post_count' => false,
		'echo' => 1, 'order' => 'DESC',
	);

	$r = wp_parse_args( $args, $defaults );

	if ( '' == $r['type'] ) {
		$r['type'] = 'monthly';
	}

	if ( ! empty( $r['limit'] ) ) {
		$r['limit'] = absint( $r['limit'] );
		$r['limit'] = ' LIMIT ' . $r['limit'];
	}

	$order = strtoupper( $r['order'] );
	if ( $order !== 'ASC' ) {
		$order = 'DESC';
	}

	// this is what will separate dates on weekly archive links
	$archive_week_separator = '&#8211;';

	// over-ride general date format ? 0 = no: use the date format set in Options, 1 = yes: over-ride
	$archive_date_format_over_ride = 0;

	// options for daily archive (only if you over-ride the general date format)
	$archive_day_date_format = 'Y/m/d';

	// options for weekly archive (only if you over-ride the general date format)
	$archive_week_start_date_format = 'Y/m/d';
	$archive_week_end_date_format	= 'Y/m/d';

	if ( ! $archive_date_format_over_ride ) {
		$archive_day_date_format = get_option( 'date_format' );
		$archive_week_start_date_format = get_option( 'date_format' );
		$archive_week_end_date_format = get_option( 'date_format' );
	}

	/**
	 * Filter the SQL WHERE clause for retrieving archives.
	 *
	 * @since 2.2.0
	 *
	 * @param string $sql_where Portion of SQL query containing the WHERE clause.
	 * @param array  $r         An array of default arguments.
	 */
	$where = apply_filters( 'getarchives_where', "WHERE post_type = 'post' AND post_status = 'publish'", $r );

	/**
	 * Filter the SQL JOIN clause for retrieving archives.
	 *
	 * @since 2.2.0
	 *
	 * @param string $sql_join Portion of SQL query containing JOIN clause.
	 * @param array  $r        An array of default arguments.
	 */
	$join = apply_filters( 'getarchives_join', '', $r );

	$output = '';

	$last_changed = wp_cache_get( 'last_changed', 'posts' );
	if ( ! $last_changed ) {
		$last_changed = microtime();
		wp_cache_set( 'last_changed', $last_changed, 'posts' );
	}

	$limit = $r['limit'];

	if ( 'monthly' == $r['type'] ) {
		$query = "SELECT YEAR(post_date) AS `year`, MONTH(post_date) AS `month`, count(ID) as posts FROM $wpdb->posts $join $where GROUP BY YEAR(post_date), MONTH(post_date) ORDER BY post_date $order $limit";
		$key = md5( $query );
		$key = "wp_get_archives2:$key:$last_changed";
		if ( ! $results = wp_cache_get( $key, 'posts' ) ) {
			$results = $wpdb->get_results( $query );
			wp_cache_set( $key, $results, 'posts' );
		}
		if ( $results ) {
			$after = $r['after'];
			foreach ( (array) $results as $result ) {
				$url = get_month_link( $result->year, $result->month );
				/* translators: 1: month name, 2: 4-digit year */
				$text = sprintf( __( '%1$s %2$d' ), $wp_locale->get_month( $result->month ), $result->year );
				if ( $r['show_post_count'] ) {
					$r['after'] = '&nbsp;(' . $result->posts . ')' . $after;
				}
				$output .= get_archives_link2( $url, $text, $r['format'], $r['before'], $r['after'] );
			}
		}
	} elseif ( 'yearly' == $r['type'] ) {
		$query = "SELECT YEAR(post_date) AS `year`, count(ID) as posts FROM $wpdb->posts $join $where GROUP BY YEAR(post_date) ORDER BY post_date $order $limit";
		$key = md5( $query );
		$key = "wp_get_archives2:$key:$last_changed";
		if ( ! $results = wp_cache_get( $key, 'posts' ) ) {
			$results = $wpdb->get_results( $query );
			wp_cache_set( $key, $results, 'posts' );
		}
		if ( $results ) {
			$after = $r['after'];
			foreach ( (array) $results as $result) {
				$url = get_year_link( $result->year );
				$text = sprintf( '%d', $result->year );
				if ( $r['show_post_count'] ) {
					$r['after'] = '&nbsp;(' . $result->posts . ')' . $after;
				}
				$output .= get_archives_link2( $url, $text, $r['format'], $r['before'], $r['after'] );
			}
		}
	} elseif ( 'daily' == $r['type'] ) {
		$query = "SELECT YEAR(post_date) AS `year`, MONTH(post_date) AS `month`, DAYOFMONTH(post_date) AS `dayofmonth`, count(ID) as posts FROM $wpdb->posts $join $where GROUP BY YEAR(post_date), MONTH(post_date), DAYOFMONTH(post_date) ORDER BY post_date $order $limit";
		$key = md5( $query );
		$key = "wp_get_archives2:$key:$last_changed";
		if ( ! $results = wp_cache_get( $key, 'posts' ) ) {
			$results = $wpdb->get_results( $query );
			$cache[ $key ] = $results;
			wp_cache_set( $key, $results, 'posts' );
		}
		if ( $results ) {
			$after = $r['after'];
			foreach ( (array) $results as $result ) {
				$url  = get_day_link( $result->year, $result->month, $result->dayofmonth );
				$date = sprintf( '%1$d-%2$02d-%3$02d 00:00:00', $result->year, $result->month, $result->dayofmonth );
				$text = mysql2date( $archive_day_date_format, $date );
				if ( $r['show_post_count'] ) {
					$r['after'] = '&nbsp;(' . $result->posts . ')' . $after;
				}
				$output .= get_archives_link2( $url, $text, $r['format'], $r['before'], $r['after'] );
			}
		}
	} elseif ( 'weekly' == $r['type'] ) {
		$week = _wp_mysql_week( '`post_date`' );
		$query = "SELECT DISTINCT $week AS `week`, YEAR( `post_date` ) AS `yr`, DATE_FORMAT( `post_date`, '%Y-%m-%d' ) AS `yyyymmdd`, count( `ID` ) AS `posts` FROM `$wpdb->posts` $join $where GROUP BY $week, YEAR( `post_date` ) ORDER BY `post_date` $order $limit";
		$key = md5( $query );
		$key = "wp_get_archives2:$key:$last_changed";
		if ( ! $results = wp_cache_get( $key, 'posts' ) ) {
			$results = $wpdb->get_results( $query );
			wp_cache_set( $key, $results, 'posts' );
		}
		$arc_w_last = '';
		if ( $results ) {
			$after = $r['after'];
			foreach ( (array) $results as $result ) {
				if ( $result->week != $arc_w_last ) {
					$arc_year       = $result->yr;
					$arc_w_last     = $result->week;
					$arc_week       = get_weekstartend( $result->yyyymmdd, get_option( 'start_of_week' ) );
					$arc_week_start = date_i18n( $archive_week_start_date_format, $arc_week['start'] );
					$arc_week_end   = date_i18n( $archive_week_end_date_format, $arc_week['end'] );
					$url            = sprintf( '%1$s/%2$s%3$sm%4$s%5$s%6$sw%7$s%8$d', home_url(), '', '?', '=', $arc_year, '&amp;', '=', $result->week );
					$text           = $arc_week_start . $archive_week_separator . $arc_week_end;
					if ( $r['show_post_count'] ) {
						$r['after'] = '&nbsp;(' . $result->posts . ')' . $after;
					}
					$output .= get_archives_link2( $url, $text, $r['format'], $r['before'], $r['after'] );
				}
			}
		}
	} elseif ( ( 'postbypost' == $r['type'] ) || ('alpha' == $r['type'] ) ) {
		$orderby = ( 'alpha' == $r['type'] ) ? 'post_title ASC ' : 'post_date DESC ';
		$query = "SELECT * FROM $wpdb->posts $join $where ORDER BY $orderby $limit";
		$key = md5( $query );
		$key = "wp_get_archives2:$key:$last_changed";
		if ( ! $results = wp_cache_get( $key, 'posts' ) ) {
			$results = $wpdb->get_results( $query );
			wp_cache_set( $key, $results, 'posts' );
		}
		if ( $results ) {
			foreach ( (array) $results as $result ) {
				if ( $result->post_date != '0000-00-00 00:00:00' ) {
					$url = get_permalink( $result );
					if ( $result->post_title ) {
						/** This filter is documented in wp-includes/post-template.php */
						$text = strip_tags( apply_filters( 'the_title', $result->post_title, $result->ID ) );
					} else {
						$text = $result->ID;
					}
					$output .= get_archives_link2( $url, $text, $r['format'], $r['before'], $r['after'] );
				}
			}
		}
	}
	if ( $r['echo'] ) {
		echo $output;
	} else {
		return $output;
	}
}
function get_archives_link2($url, $text, $format = 'html', $before = '', $after = '') {
	$text = wptexturize($text);
	$url = esc_url($url);

	if ('link' == $format)
		$link_html = "\t<link rel='archives' title='" . esc_attr( $text ) . "' href='$url' />\n";
	elseif ('option' == $format)
		$link_html = "\t<option value='$url'>$before $text $after</option>\n";
	elseif ('html' == $format)
		$link_html = "\t<li>$before<a href='$url'><span class='icon-triangle-right'></span>$text</a>$after</li>\n";
	else // custom
		$link_html = "\t$before<a href='$url'>$text</a>$after\n";

	/**
	 * Filter the archive link content.
	 *
	 * @since 2.6.0
	 *
	 * @param string $link_html The archive HTML link content.
	 */
	$link_html = apply_filters( 'get_archives_link2', $link_html );

	return $link_html;
}

// wp_get_archives2の年表記を置き換える
// ----------------------------------------------------------------------
function my_archives_link($html){
  $html = str_replace('年','.',$html);
  $html = str_replace('月','',$html);
  return $html;
}
add_filter('get_archives_link2', 'my_archives_link');
 
 
// アーカイブウィジェットの年表記を置き換える
// ---------------------------------------------------------------------- 
function my_archives( $html ){
  $html = str_replace('年',' . ',$html);
  $html = str_replace('月','',$html);
  return $html;
}
add_filter( 'widget_archives_args','my_archives');

// カテゴリー別アーカイブ　一旦停止
// ----------------------------------------------------------------------
// function extend_date_archives_flush_rewrite_rules(){
// 	global $wp_rewrite;
// 	$wp_rewrite->flush_rules();
// }
// add_action('init', 'extend_date_archives_flush_rewrite_rules');

// function extend_date_archives_add_rewrite_rules($wp_rewrite) {
// 	$rules = array();
// 	$structures = array(
// 		$wp_rewrite->get_category_permastruct() . $wp_rewrite->get_date_permastruct(),
// 		$wp_rewrite->get_category_permastruct() . $wp_rewrite->get_month_permastruct(),
// 		$wp_rewrite->get_category_permastruct() . $wp_rewrite->get_year_permastruct(),
// 	);
// 	foreach( $structures as $s ){
// 		$rules += $wp_rewrite->generate_rewrite_rules($s);
// 	}
// 	$wp_rewrite->rules = $rules + $wp_rewrite->rules;
// }
// add_action('generate_rewrite_rules', 'extend_date_archives_add_rewrite_rules');

// function wp_get_cat_archives($opts, $cat) {
//   $args = wp_parse_args($opts, array('echo' => '4')); // default echo is 1.
//   $echo = $args['echo'] != '0'; // remember the original echo flag.
//   $args['echo'] = 0;
//   $args['cat'] = $cat;

//   $archives = wp_get_archives2(build_query($args));
//   $archs = explode('</li>', $archives);
//   $links = array();

//   $cat0 = get_the_category();
//   $cat_slug = $cat0[0]->category_nicename;

//   foreach ($archs as $archive) {
//     $link = preg_replace("/\/date\//", "/category/{$cat_slug}/date/", $archive);
//     array_push($links, $link);
//   }
//   $result = implode('</li>', $links);

//   if ($echo) {
//     echo $result;
//   } else {
//     return $result;
//   }
// }









?>