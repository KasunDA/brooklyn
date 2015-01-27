<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<?php if (is_front_page()): ?>
<title><?php bloginfo('name'); ?></title>
<?php else: ?>
<title><?php bloginfo('name'); ?>｜福岡市早良区西新にあるセレクトショップのBROOKLYN(ブルックリン)</title>
<?php endif; ?>
<meta name="Keywords" content="<?php echo $keywords; ?>">
<meta name="Description" content="<?php bloginfo('description'); ?>">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<meta name="format-detection" content="telephone=no">
<meta name="format-detection" content="email=no">
<?php if (is_front_page()): ?>
<meta property="og:title" content="福岡市早良区西新にあるセレクトショップのBROOKLYN(ブルックリン)" >
<?php else: ?>
<meta property="og:title" content="<?php bloginfo('name'); ?>｜福岡市早良区西新にあるセレクトショップのBROOKLYN(ブルックリン)" >
<?php endif; ?>
<meta property="og:description" content="<?php echo $description; ?>" >
<?php if (is_front_page()): ?>
<meta property="og:image" content="/assets/img/common/ogp.png" >
<?php endif; ?>
<meta property="og:type" content="website">
<meta property="og:site_name" content="福岡市早良区西新にあるセレクトショップのBROOKLYN(ブルックリン)" >
<meta property="fb:app_id" content="1557803174470199" >
<?php if (is_front_page()): ?>
<link rel="canonical" href="000000000000">
<?php endif; ?>
<link href="/assets/css/normalize.css" rel="stylesheet" type="text/css">
<link href="/assets/css/util.css" rel="stylesheet" type="text/css">
<link href="/assets/css/font.css" rel="stylesheet" type="text/css">
<link href="/assets/css/style.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="http://i.icomoon.io/public/temp/aa147e695b/brooklyn/style.css">
<link rel="shortcut icon" type="image/vnd.microsoft.icon" href="/favicon.ico">
<script src="/assets/js/jquery-1.8.3.min.js"></script>
<script src="/assets/js/jquery.tile.js"></script>
<script src="/assets/js/common.js"></script>
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

    ga('create', 'UA-000000000000', '000000000000');
    ga('send', 'pageview');
</script>
<?php wp_head(); ?>
</head>