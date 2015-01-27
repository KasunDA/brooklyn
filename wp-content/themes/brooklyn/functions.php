<?php 


//カスタムメニュー
register_nav_menus(
	array(
		'place_global' => 'グローバル',
		'place_utility' => 'ユーティリティー',
	)
 );

//アイキャッチ画像を利用できるようにします
add_theme_support( 'post-thumbnails' );
/*アイキャッチ画像サイズ設定*/
set_post_thumbnail_size(1500, 1900, true );
/*サムネイル*/
add_image_size( 'thumbnail', 880, 1120, true );







?>