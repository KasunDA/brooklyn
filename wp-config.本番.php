<?php
/** 
 * WordPress 基本設定
 *
 * このファイルは、MySQL、テーブル接頭辞、秘密鍵、言語、ABSPATH の設定を含みます。
 * より詳しい情報は {@link http://wpdocs.sourceforge.jp/wp-config.php_%E3%81%AE%E7%B7%A8%E9%9B%86 
 * wp-config.php の編集} を参照してください。MySQL の設定情報はホスティング先より入手できます。
 *
 * このファイルはインストール時に wp-config.php 作成ウィザードが利用します。
 * ウィザードを介さず、このファイルを "wp-config.php" という名前でコピーして直接編集し値を
 * 入力しても構いません。
 *
 * @package WordPress
 */

// 注意:
// Windows の "メモ帳" でこのファイルを編集しないでください !
// 問題なく使えるテキストエディタ
// (http://wpdocs.sourceforge.jp/Codex:%E8%AB%87%E8%A9%B1%E5%AE%A4 参照)
// を使用し必ず UTF-8 の BOM なし (UTF-8N) で保存してください。

// ** MySQL 設定 - こちらの情報はホスティング先から入手してください。 ** //
/** WordPress のデータベース名 */
define('DB_NAME', 'LAA0584772-4nrgt0');

/** MySQL のユーザー名 */
define('DB_USER', 'LAA0584772');

/** MySQL のパスワード */
define('DB_PASSWORD', 'yHnCejuB');

/** MySQL のホスト名 (ほとんどの場合変更する必要はありません。) */
define('DB_HOST', 'mysql027.phy.lolipop.lan');

/** データベーステーブルのキャラクターセット (ほとんどの場合変更する必要はありません。) */
define('DB_CHARSET', 'utf8');

/** データベースの照合順序 (ほとんどの場合変更する必要はありません。) */
define('DB_COLLATE', '');

/**#@+
 * 認証用ユニークキー
 *
 * それぞれを異なるユニーク (一意) な文字列に変更してください。
 * {@link https://api.wordpress.org/secret-key/1.1/ WordPress.org の秘密鍵サービス}
 * で自動生成することもできます。
 * 後でいつでも変更して、既存のすべての cookie を無効にできます。これにより、
 * すべてのユーザーを強制的に再ログインさせることができます。
 *
 * @since 2.6.0
 */
define('AUTH_KEY', 'K^{e"iR!!3x1]{H>n!f5Z(L=Fkj~^qI$:rbMs$.k7#(Y6RWm0,N`*Lt`!<N$KUBY');
define('SECURE_AUTH_KEY', '?yxqB39Vf77E:Yvzxm,vYPc[~/9oboogx>ZcvcU|@9B6GHyy!L)V2r7,r)_<pZ/9');
define('LOGGED_IN_KEY', 'a`+/;pbz58j*qm}Bdf<>Oc/^u;*:sazGr{yTcR(x-H]`"%5_vmnjTs%c=qwlrGPs');
define('NONCE_KEY', 'A8:K_9NQ1rOug9fF3v=^#(vb%3@aC^XZ>>d}2=d/CiT;S;qt,JiCIwnWQ5u-7v#j');
define( 'AUTH_SALT', '_{[K|&IG[^oSZU mY909Ww|mZV6hj5f,fmgc++)dpqttZj5!vS|wuNTg4|uKQbZH' );
define( 'SECURE_AUTH_SALT', '(vA(4O%!v9{!h>rm)hu8 s=q|+&^f.Fl+|/s9(D9;kcw|Etg0W>SgLr|3O SKo.6' );
define( 'LOGGED_IN_SALT', 'rLErxP~r@1f*ZXnF?4ss8oKu&?:Wfs8c8f1Dv`kX7^W+&brWtBMce3eD 5/tGWZP' );
define( 'NONCE_SALT', 'sLT?Hb8}SwzLY.l8KG< 7r|nKxE2`Gi!1{0BflK}lhAZ7Ib]RRRhuP1sP%jF3PC>' );
/**#@-*/

/**
 * WordPress データベーステーブルの接頭辞
 *
 * それぞれにユニーク (一意) な接頭辞を与えることで一つのデータベースに複数の WordPress を
 * インストールすることができます。半角英数字と下線のみを使用してください。
 */
$table_prefix  = 'wp1_';

/**
 * ローカル言語 - このパッケージでは初期値として 'ja' (日本語 UTF-8) が設定されています。
 *
 * WordPress のローカル言語を設定します。設定した言語に対応する MO ファイルが 
 * wp-content/languages にインストールされている必要があります。例えば de.mo を 
 * wp-content/languages にインストールし WPLANG を 'de' に設定することでドイツ語がサポートされます。
 */
define ('WPLANG', 'ja');
define('WP_DEBUG', true);

define('MULTISITE', true);
define('SUBDOMAIN_INSTALL', false);
define('DOMAIN_CURRENT_SITE', 'brooklyn-fukuoka.main.jp');
define('PATH_CURRENT_SITE', '/');
define('SITE_ID_CURRENT_SITE', 1);
define('BLOG_ID_CURRENT_SITE', 1);

// 編集が必要なのはここまでです ! WordPress でブログをお楽しみください。

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
