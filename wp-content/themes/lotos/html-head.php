<!DOCTYPE html>
<html lang="ja">
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# article: http://ogp.me/ns/article#">
<meta charset="utf-8">
<?php if (is_front_page()): ?>
<title><?php bloginfo('name'); ?></title>
<?php else: ?>
<title><?php wp_title('',true); ?> | <?php bloginfo('name'); ?></title>
<?php endif; ?>
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<meta name="format-detection" content="telephone=no">
<meta name="format-detection" content="email=no">
<?php get_template_part('ogp'); ?>
<link rel="alternate" type="application/rss+xml" title="RSS Feed" href="<?php echo home_url('/feed/') ?>">
<link href="/assets/css/normalize.css" rel="stylesheet" type="text/css">
<link href="/assets/css/util.css" rel="stylesheet" type="text/css">
<link href="/assets/css/font.css" rel="stylesheet" type="text/css">
<link href="/assets/css/style-lotus.css" rel="stylesheet" type="text/css">
<link rel="shortcut icon" type="image/vnd.microsoft.icon" href="/favicon.ico">
<script src="/assets/js/jquery-1.8.3.min.js"></script>
<script src="/assets/js/jquery.tile.js"></script>
<script src="/assets/js/common.js"></script>
<?php if (is_front_page()): ?>
<script src="/assets/js/slide.js"></script>
<?php endif; ?>
<?php if (is_page('shop-info')): ?>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
<script src="/assets/js/map.js"></script>
<?php endif; ?>
<script src="//use.typekit.net/lxg8uzz.js"></script>
<script>try{Typekit.load();}catch(e){}</script>
<!--[if lt IE 9]>
    <script type="text/javascript" src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-59499337-1', 'auto');
  ga('send', 'pageview');

</script>
<script src="https://apis.google.com/js/platform.js" async defer>
  {lang: 'ja'}
</script>
<?php wp_head(); ?>
</head>