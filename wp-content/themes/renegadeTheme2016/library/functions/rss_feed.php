<?php



function get_rss_func($atts, $content = null){
	
	shortcode_atts( array('excerpts' => '', 'feed' => '', 'numberposts' => 0, ), $atts);
	$excerpts = isset($atts['excerpts']);
	$numberposts = $atts['numberposts'];
	$feed = $atts['feed'];
	$text_color = $atts['text_color'];
	
	//$feed->set_timeout(60);
	
	//$rss = fetch_feed( 'http://www.thedrewblog.com/index.php/feed/' );
	
	$rss = fetch_feed( $feed );
	$rssHtml = '';

	$rssHtml .= '<ul class="rss"';
	$rssHtml .= '>';
	
	if ( ! is_wp_error( $rss ) ) : // Checks that the object is created correctly
	
	// Figure out how many total items there are, but limit it to a certain number.
	$maxitems = $rss->get_item_quantity( $numberposts );
	
	// Build an array of all the items, starting with element 0 (first element).
	$rss_items = $rss->get_items( 0, $maxitems );
	
	endif;

	if($rss_items):
	
		foreach ( $rss_items as $item ) :
		
		//$post_categories = get_the_category();
		
		//$post_category = get_the_category_rss( 'rss' );
		
	
		
	/*	foreach($post_categories as $category):
		
			$content_category = get_category_by_slug( 'content-sections' );
		
			$category_slug = $category->slug;
			//$rssHtml .= $category_slug;
			
			if(cat_is_ancestor_of( $content_category, $category  )):
				$category_slug = $category->slug;
				$rssHtml .= $category_slug;
			endif;
			
			
		
		endforeach;*/
		
		$rssHtml .= '<li';
		
		if($text_color):
		
			$rssHtml .= ' style="color:' . $text_color . ';"';
		
		endif;
			
		$rssHtml .= '><h2><a href="' . esc_url( $item->get_permalink() ) . '">' . esc_html( $item->get_title() ) . '</a></h2>';
		$rssHtml .= '<div class="rss-date">';
		$rssHtml .= $item->get_date('j F Y | g:i a') . '</div>' ;
		$rssHtml .= $item->get_description();
		$rssHtml .= '<br><a href="' . esc_url( $item->get_permalink() ) . '"><div class="bt-black">Read It</div></a>';
		$rssHtml .= '</li>';
		
		endforeach;
	endif;
	$rssHtml .= '</ul>';
	return $rssHtml;
}

?>
