<?php include (TEMPLATEPATH.'/library/get-theme-options.php'); ?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title>
<?php if ( is_home() ) { ?><?php bloginfo('name'); ?>&nbsp;<?php } ?>
    <?php if ( is_search() ) { ?><?php bloginfo('name'); ?>&nbsp;|&nbsp;Search Results<?php } ?>
    <?php if ( is_author() ) { ?><?php bloginfo('name'); ?>&nbsp;|&nbsp;Author Archives<?php } ?>
    <?php if ( is_single() || is_page() ) { ?><?php $title = get_post_meta($post->ID, 'Title', true);  if ($title) { ?>  
		<?php echo get_post_meta($post->ID, "Title", true); ?>&nbsp;|&nbsp;<?php bloginfo('name'); ?>
		<?php } else { ?> 
		<?php wp_title(''); ?>&nbsp;|&nbsp;<?php bloginfo('name'); ?>
		<?php } ?> 		
		<?php } ?>
    <?php if ( is_category() ) { ?><?php bloginfo('name'); ?>&nbsp;|&nbsp;Archive&nbsp;|&nbsp;<?php single_cat_title(); ?><?php } ?>
    <?php if ( is_month() ) { ?><?php bloginfo('name'); ?>&nbsp;|&nbsp;Archive&nbsp;|&nbsp;<?php the_time('F'); ?><?php } ?>
    <?php if (function_exists('is_tag')) { if ( is_tag() ) { ?><?php bloginfo('name'); ?>&nbsp;|&nbsp;Tag Archive&nbsp;|&nbsp;<?php  single_tag_title("", true); } } ?>
</title>

<?php if (is_single() || is_page() ) : if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
<meta name="description" content="<?php $description = get_post_meta($post->ID, 'Description', true);  if ($description) { ?><?php echo get_post_meta($post->ID, "Description", true); ?>
<?php } else { ?><?php the_excerpt_rss(); ?><?php } ?>" />
<?php endwhile; endif; elseif(is_home()) : ?>
<meta name="description" content="<?php bloginfo('description'); ?>" />
<?php endif; ?>

<?php if(is_search()) { ?>
<meta name="robots" content="noindex, nofollow" /> 
<?php }?>

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen,projection" />
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/print.css" type="text/css" media="print" />

<?php if ($blt_two_column == "true") {?>
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/2column.css" type="text/css" media="screen,projection" />
<?php }?>

<?php if ($blt_two_column_wide == "true") {?>
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/2column-wide.css" type="text/css" media="screen,projection" />
<?php }?>

<?php if ($blt_two_column_really_wide == "true") {?>
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/2column-really-wide.css" type="text/css" media="screen,projection" />
<?php }?>

<link rel="shortcut icon" href="<?php bloginfo('template_url'); ?>/images/favicon.ico" />
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?>" href="<?php echo $blt_feedburner;?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/dropdowns.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/domtab.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jquery.easing.1.2.js"></script>
<script src="<?php bloginfo('template_url'); ?>/js/jquery.anythingslider.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">

	function formatText(index, panel) {
	  return index + "";
	}

	$(function () {
	
		$('.anythingSlider').anythingSlider({
			easing: "easeInOutExpo",        // Anything other than "linear" or "swing" requires the easing plugin
			autoPlay: true,                 // This turns off the entire FUNCTIONALY, not just if it starts running or not.
			delay: 3000,                    // How long between slide transitions in AutoPlay mode
			startStopped: false,            // If autoPlay is on, this can force it to start stopped
			animationTime: 600,             // How long the slide transition takes
			hashTags: true,                 // Should links change the hashtag in the URL?
			buildNavigation: true,          // If true, builds and list of anchor links to link to each slide
			pauseOnHover: true,             // If true, and autoPlay is enabled, the show will pause on hover
			startText: "Go",             // Start text
			stopText: "Stop",               // Stop text
			navigationFormatter: formatText       // Details at the top of the file on this use (advanced use)
		});
		
		$("#slide-jump").click(function(){
			$('.anythingSlider').anythingSlider(6);
		});
		
	});
</script>

<?php if ( is_singular() ) wp_enqueue_script('comment-reply'); // support for comment threading ?>
<?php wp_head(); ?>

</head>