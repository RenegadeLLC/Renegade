<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Renegade
 */

$footer_phone_number = get_field('footer_phone_number', 'option');
$footer_address = get_field('footer_address', 'option');

?>
	</div><!-- #content -->
<div class="outer-wrapper" style="background-color:#000;">
	<footer id="colophon" class="site-footer" role="contentinfo">
		 <div class="site-info">
		<div class="footer-ct">
		<div class="wrapper">
		<div class="footer-logo">
		<img src="<?php echo bloginfo('template_url'); ?>/library/images/saw_footer.png"></div>
		<div class="footer-text">Renegade<div class="footer-info">  <?php echo($footer_address); ?> <a class="phone-number" href="tel:+1<?php echo($footer_phone_number); ?>"><?php echo($footer_phone_number); ?></a></div></div>
	
		</div></div><div class="footer-social-channels-ct"><?php 
	$footer_channels = get_field('footer_social_channels', 'option');
	$socialHTML = '';
	
	foreach($footer_channels as $channel){
	$social_channel_link = '';
	$social_class = '';
	
	switch($channel){
				
			case 'Facebook':
				$social_channel_link = get_field('facebook_url', 'option');
				$social_class = 'social-facebook';
			break;
			
			case 'Twitter':
				$social_channel_link = get_field('twitter_url', 'option');
				$social_class = 'social-twitter';
			break;
			
			case 'Instagram':
				$social_channel_link = get_field('instagram_url', 'option');
				$social_class = 'social-instagram';
			break;
					
			case 'YouTube':
				$social_channel_link = get_field('youtube_url', 'option');
				$social_class = 'social-youtube';
			break;
			
			case 'LinkedIn':
				$social_channel_link = get_field('linkedin_url', 'option');
				$social_class = 'social-linkedin';
				break;
					
			case 'Pinterest':
				$social_channel_link = get_field('pinterest_url', 'option');
				$social_class = 'social-pinterest';
			break;
			
			case 'GooglePlus':
				$social_channel_link = get_field('googleplus_url', 'option');
				$social_class = 'social-googleplus';
			break;
			
			case 'SlideShare':
				$social_channel_link = get_field('slideshare_url', 'option');
				$social_class = 'social-slideshare';
			break;
							
		}//end switch
	
		if( in_array($channel, $footer_channels) ) {
			
			$socialHTML .= ' <a href="' . $social_channel_link . '" target="_blank" ><div class="' . $social_class . ' header-social-icons"></div></a>';
			//$headerHTML .= '<a href="' . $social_channel_link . '" target="_blank"><div class="social-facebook header-social-icons"></div></a>';
		}//end if
	}//end foreach
	echo ($socialHTML);
?></div></div><!-- .site-info -->
	</footer><!-- #colophon -->
<?php 
	$copyright_text = get_field('copyright_text', 'option');
	$copyright_year = date('Y');
?><div style="font-size:.7em; text-align:center; margin:24px auto;">
&copy; <?php echo  $copyright_year . ' Renegade LLC. All rights reserved.';
echo $copyright_text; ?></div>
</div><!-- #page -->
<?php wp_footer(); ?>

<?php 

//$google_analytics_code = get_field('google_analytics_code', 'option');

	//echo($google_analytics_code);

?>

</body>
</html>
