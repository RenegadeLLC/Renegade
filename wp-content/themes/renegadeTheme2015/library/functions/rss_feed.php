<?php



function get_rss_func($atts, $content = null){
	
	shortcode_atts( array('excerpts' => '', 'feed' => '', 'numberposts' => 0, ), $atts);
	$excerpts = isset($atts['excerpts']);
	$numberposts = $atts['numberposts'];
	$feed = $atts['feed'];
	$text_color = $atts['text_color'];
	
	//$rss = fetch_feed( 'http://www.thedrewblog.com/index.php/feed/' );
	
	$rss = fetch_feed( $feed );
	$rssHtml = '';

	$rssHtml .= '<ul class="rss"';
	$rssHtml .= '>';
	
	if ( ! is_wp_error( $rss ) ) : // Checks that the object is created correctly
	
	// Figure out how many total items there are, but limit it to 5.
	$maxitems = $rss->get_item_quantity( $numberposts );
	
	// Build an array of all the items, starting with element 0 (first element).
	$rss_items = $rss->get_items( 0, $maxitems );
	
	endif;
	
	
	foreach ( $rss_items as $item ) :
	
	$rssHtml .= '<li';
	
	if($text_color):
	
	$rssHtml .= ' style="color:' . $text_color . ';"';
	
	endif;
	
	$rssHtml .= '><h2><a href="' . esc_url( $item->get_permalink() ) . '">' . esc_html( $item->get_title() ) . '</a></h2>';
	$rssHtml .= '<div class="rss-date">';
	$rssHtml .= $item->get_date('j F Y | g:i a') . '</div>' ;
	$rssHtml .= $item->get_description();
	$rssHtml .= '</li>';
	
	endforeach;
	
	$rssHtml .= '</ul>';
	return $rssHtml;
}



?>
