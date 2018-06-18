<?php
/**
 * AJAX posts filter
 *
 */
function tags_filter($taxType){
	$tax = $taxType;
	$terms = get_terms( $tax );
	$count = count( $terms );
	//var_dump($terms);

	if ( $count > 0 ):
	 
	$listHTML = '<div class="post-tags">';

	foreach ( $terms as $term ) {
		$term_link = get_term_link( $term, $tax );
		$listHTML .= '<a href="' . $term_link . '" class="tax-filter ' . $tax . '" title="' . $term->slug . '">' . $term->name . '</a> ';
	}

	$listHTML .= '</div>';
	 
	endif;

	return $listHTML;
}

// Enqueue script
function ajax_filter_posts_scripts() {
  // Enqueue script
	$scriptdir = get_template_directory_uri();
	$scriptdir .= '/library/js/';
	
  wp_register_script('afp_script', $scriptdir  . 'ajax-filter-post.js', false, null, false);
  wp_enqueue_script('afp_script');

 
  
  wp_localize_script( 'afp_script', 'afp_vars', array(
        'afp_nonce' => wp_create_nonce( 'afp_nonce' ), // Create nonce which we later will use to verify AJAX request
        'afp_ajax_url' => admin_url( 'admin-ajax.php' ),
  //'afp_ajax_url' => FUNCTIONS . 'ajax_filter_posts.php',
      )
  );
}

add_action('wp_enqueue_scripts', 'ajax_filter_posts_scripts', 100);


// Script for getting posts
function filter_posts( ) {

//if ( isset($_REQUEST) ) {
	$taxonomy = $_REQUEST['taxonomy'];
//}

$result = json_encode($taxonomy);
echo($result);
$wtf = 'wtf';
//return $result;
//
  // Verify nonce
  //if( !isset( $_POST['afp_nonce'] ) || !wp_verify_nonce( $_POST['afp_nonce'], 'afp_nonce' ) )
   // die('Permission denied');
  /*
  
  if ( isset($_POST) ) {
  	$taxonomy = $_POST['taxonomy'];
  }

  $result = 'taxonomy';
  // WP Query
 
  $args = array(
    //'tag'            => $taxonomy,
  //	'tag'            => 'social-media',
    'post_type'      => 'articles',
    'posts_per_page' => -1,
  );

  // If taxonomy is not set, remove key from array and get all posts
 // if( !$taxonomy ) {
 //   unset( $args['tag'] );
 // }

  $query = new WP_Query( $args );

  if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();

  echo('hi');

  endwhile; else:

  endif;

 $result = json_encode($result);
  return $result;*/

  die(); 
}

add_action('wp_ajax_filter_posts', 'filter_posts');
add_action('wp_ajax_nopriv_filter_posts', 'filter_posts');
