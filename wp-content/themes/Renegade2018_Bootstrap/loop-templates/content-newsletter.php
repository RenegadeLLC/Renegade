<?php
/**
 * Partial template for content in page.php
 *
 * @package understrap
 */

?>




	<?php 
	/*
	
	$rn_title = get_the_title( $post->ID );
	$rn_date = get_field('rn_date');
	$rn_introduction= get_field('rn_introduction');
	$rn_banner = get_field('rn_banner');
	$rn_thumb = get_field('rn_thumb');
	$rn_size = "half";
	$rn_thumbnail_image = get_field('rn_thumbnail_image');
	$rn_link = get_permalink();
	$accent_color = get_field('accent_color');
	*/
	$rn_title = get_the_title( $post->ID );
	$rn_date = get_field('rn_date', $post -> ID);
	$rn_thumbnail_image= get_field('rn_banner', $post -> ID);
	$rn_link = get_permalink($post -> ID);
	$rn_introduction= get_field('rn_introduction' , $post -> ID);
	$rn_banner = get_field('rn_banner', $post -> ID);
	$rn_size = "half";
	?>

	

		<?php //the_content(); 
		
	   $post_edit_link = get_edit_post_link();
		$newsletter_html = '';
		
		
		//$newsletter_html.= '<style>li:before{background-color:' . $accent_color . ';}</style>';
		//$newsletter_html .= '<div class="feed-item post-item col-lg-4 col-md-6 col-sm-12 newsletter-excerpt resource-excerpt">';
		
		$newsletter_info= '';
		
		$newsletter_info .= '<h3>' . $rn_title . '</h3>';
		//$newsletter_info .= '<div class="date">' . $rn_date . '</div>';
		$newsletter_info .= '<div class="excerpt">' . $rn_introduction . '</div>';
		
		$newsletter_html .= '<div class="post-label-ct">NEWSLETTER</div>';
		$newsletter_html .= '<a href="' . $rn_link . '">';
		$newsletter_html .= '<div class="date">' . $rn_date . '</div>';
		$newsletter_html .= '<div>' . wp_get_attachment_image($rn_banner, $rn_size ) . '</div>';
	
		$newsletter_html .= '<div>' . $newsletter_info . '</div></a>';
		$newsletter_html .= '<div><a href="' . $post_edit_link  . '">' . 'Edit'  . '</a></div>';
		//$newsletter_html .= '</div><!-- .grid-item -->';
		
		
		
		
		echo($newsletter_html);
		?>

		<?php
		/*wp_link_pages( array(
			'before' => '<div class="page-links">' . __( 'Pages:', 'understrap' ),
			'after'  => '</div>',
		) );*/
		?>




