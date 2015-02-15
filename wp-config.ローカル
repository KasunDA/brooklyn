<?php
/**
 * WordPress の基本設定
 *
 * このファイルは、MySQL、テーブル接頭辞、秘密鍵、ABSPATH の設定を含みます。
 * より詳しい情報は {@link http://wpdocs.sourceforge.jp/wp-config.php_%E3%81%AE%E7%B7%A8%E9%9B%86 
 * wp-config.php の編集} を参照してください。MySQL の設定情報はホスティング先より入手できます。
 *
 * このファイルはインストール時に wp-config.php 作成ウィザードが利用します。
 * ウィザードを介さず、このファイルを "wp-config.php" という名前でコピーして直接編集し値を
 * 入力してもかまいません。
 *
 * @package WordPress
 */

// 注意: 
// Windows の "メモ帳" でこのファイルを編集しないでください !
// 問題なく使えるテキストエディタ
// (http://wpdocs.sourceforge.jp/Codex:%E8%AB%87%E8%A9%B1%E5%AE%A4 参照)
// を使用し、必ず UTF-8 の BOM なし (UTF-8N) で保存してください。

// ** MySQL 設定 - この情報はホスティング先から入手してください。 ** //
/** WordPress のためのデータベース名 */
define('DB_NAME', 'brooklyn');

/** MySQL データベースのユーザー名 */
define('DB_USER', 'root');

/** MySQL データベースのパスワード */
define('DB_PASSWORD', 'root');

/** MySQL のホスト名 */
define('DB_HOST', 'localhost');

/** データベースのテーブルを作成する際のデータベースの文字セット */
define('DB_CHARSET', 'utf8');

/** データベースの照合順序 (ほとんどの場合変更する必要はありません) */
define('DB_COLLATE', '');

/** マルチサイト */
define ('WP_ALLOW_MULTISITE', true);

/**#@+
 * 認証用ユニークキー
 *
 * それぞれを異なるユニーク (一意) な文字列に変更してください。
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org の秘密鍵サービス} で自動生成することもできます。
 * 後でいつでも変更して、既存のすべての cookie を無効にできます。これにより、すべてのユーザーを強制的に再ログインさせることになります。
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         ')U<R=@ogrXV_#kxi[wxwfBnR>~/4^4R^vyKHO_sq~K0ks8g|}> /`aH6{?;+2D:!');
define('SECURE_AUTH_KEY',  '91{t*v(s[x,3|Ip!#{fE::PFpK[fv<Ws|NHC7z@_X_>p8%+|w~T9 /hU&zT|.;[*');
define('LOGGED_IN_KEY',    'ZY]VL;HCab1<CB{6qE;6RYPq8}J4![`;PWOH1[<)[*AC$u%py8fI&<si06-vT?QS');
define('NONCE_KEY',        'X&k1xdH>N=85GaePT#,_k/[L24`VKQjuYXvDsP_mltXun[E]bJ97fl9I{Y)^n7Dc');
define('AUTH_SALT',        '`$j^u4g^|Ec$Et-%cr]y,n<Y_e;({Ii*D1cLL]k&ySi&uoEAJem{#~5RCzVUAH1~');
define('SECURE_AUTH_SALT', ')7gV>)#[Yz&5F>(DV_4Ej*$Y)3iUUd[PYKPJnK#}aX681PO;#BPc{Eb1Qoa0)m9?');
define('LOGGED_IN_SALT',   'q5o#k:Zwrk><F^bx=VY@4;gPkR1aDRjM;[B.n)pnYo-c1mtCW1zOAO1!2(O@RX[A');
define('NONCE_SALT',       ';gflX-w>jDq,UQOx<gy5#x$JixsA1es~I&_=/ueoc2x+Go}--C(R:2?/0?K^{Qny');

/**#@-*/

/**
 * WordPress データベーステーブルの接頭辞
 *
 * それぞれにユニーク (一意) な接頭辞を与えることで一つのデータベースに複数の WordPress を
 * インストールすることができます。半角英数字と下線のみを使用してください。
 */
$table_prefix  = 'wp_';

/**
 * 開発者へ: WordPress デバッグモード
 *
 * この値を true にすると、開発中に注意 (notice) を表示します。
 * テーマおよびプラグインの開発者には、その開発環境においてこの WP_DEBUG を使用することを強く推奨します。
 */
define('WP_DEBUG', true);

define('MULTISITE', true);
define('SUBDOMAIN_INSTALL', false);
define('DOMAIN_CURRENT_SITE', 'brooklyn');
define('PATH_CURRENT_SITE', '/');
define('SITE_ID_CURRENT_SITE', 1);
define('BLOG_ID_CURRENT_SITE', 1);

/* 編集が必要なのはここまでです ! WordPress でブログをお楽しみください。 */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
