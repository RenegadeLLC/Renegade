<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
<title>The Drew Blog</title>

<meta http-equiv="content-type" content="<?php bloginfo('html_type') ?>; charset=<?php bloginfo('charset') ?>" />
<meta name="description" content="<?php bloginfo('description') ?>" />
<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>" media="screen" />
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<?php wp_head(); ?>
</head>
<body>
<!-- header START -->
<div class="container_12">

    <div id="search-bar">
      <?php include (TEMPLATEPATH . '/searchform.php'); ?>
    </div>
    
<div id="header-wrap">

  <div class="header">
    <div class="logo"><a href="<?php echo get_option('home'); ?>/"><img src="<?php bloginfo('template_url'); ?>/images/thedrewblog.gif"></a></div>
    <div class="description">
      <?php bloginfo('description'); ?>
    </div>
    
    <div style="clear: both"></div>
  </div>

</div>
<!-- header END -->
<div style="clear: both"></div>