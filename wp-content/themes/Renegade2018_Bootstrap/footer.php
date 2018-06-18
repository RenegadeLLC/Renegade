<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package understrap
 */
$footer_logo = get_field('footer_logo', 'option');
$footer_background_color = get_field('footer_background_color', 'option');
$footer_text_color = get_field('footer_text_color' ,'option');
$footer_link_color = get_field('footer_link_color', 'option');
$footer_address = get_field('footer_address', 'option');
$footer_phone_number = get_field('footer_phone_number','option');
$footer_social_channels = get_field('footer_social_channels', 'option');
$copyright_text = get_field('copyright_text', 'option');

$container = get_field('container_width', 'option');

$footer_channels = get_field('footer_social_channels', 'option');
$socialHTML = '';

$socialHTML .= '<ul class="social-icons">';
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
        
        $socialHTML .= ' <li><a href="' . $social_channel_link . '" target="_blank" ><div class="' . $social_class . ' social-icon"></div></a></li>';
        //$headerHTML .= '<a href="' . $social_channel_link . '" target="_blank"><div class="social-facebook header-social-icons"></div></a>';
    }//end if
}//end foreach

$socialHTML .= '</ul><!-- .social-icons -->';

$the_theme = wp_get_theme();
//$container = get_theme_mod( 'understrap_container_type' );
?>
</div><!-- .container -->

<style>
  ul#footer li a{
 color:<?php echo $footer_link_color?>;
 }
 
  ul.social-icons a{
 color:<?php echo $footer_link_color?> !important;
 }
 
</style>
<?php get_sidebar( 'footerfull' ); ?>

<div class="wrapper" id="wrapper-footer" >
<?php if ($container == 'Fixed Width Container'):?>
<div class="container" >
<?php elseif ($container == 'Full Width Container'):?>
<div class="container-fluid" >

<?php endif;?>
<div class="footer-ct" style="background-color:<?php echo $footer_background_color; ?>; color:<?php echo $footer_text_color; ?>;">
		<div class="row">

			<div class="col-md-12">

				<footer class="site-footer" id="colophon">

					<div class="site-info">
					<div class="footer-left">
	<?php if($footer_logo):?>
					<a href=""><img src="<?php echo $footer_logo; ?>" width="124" alt="">	</a><br>
	<?php endif;?>
	
	<?php if($footer_address):?>
	<div class="footer-address"><?php echo $footer_address; 
	if($footer_phone_number): ?><br>
	<strong><a href="tel:"<?php echo $footer_phone_number; ?>" style="color:<?php echo $footer_link_color; ?>;"><?php echo $footer_phone_number; ?></a></strong>
	<?php endif;?>
	
	</div><!--  .footer-address -->
	<?php endif;?>
	</div>
	<div class="footer-right">
	<div class="footer-nav">
	<!-- The WordPress Menu goes here -->
	<?php 
				
				wp_nav_menu(
				    array(
				        'theme_location'  => 'footer',
				        'container_class' => 'footer-menu',
				        'container_id'    => 'footer-menu',
				      //  'menu_class'      => 'navbar-nav',
				        //'fallback_cb'     => '',
				        'menu_id'         => 'footer',
				      // 'walker'          => new understrap_WP_Bootstrap_Navwalker(),
				    )
				    
				    ); ?>
	</div><!--  .footer-nav -->
	<div class="footer-social-ct">
	<?php echo ($socialHTML); ?></div><!--  .footer-social-ct -->
	</div><!-- .footer-right -->
					</div><!-- .site-info -->

				</footer><!-- #colophon -->

			</div><!--col end -->

		</div><!-- row end -->

</div><!-- .footer-ct -->

</div><!-- wrapper end -->

</div><!-- #page we need this extra closing tag here -->
</div><!-- .container -->
<?php wp_footer(); ?>

</body>

</html>

