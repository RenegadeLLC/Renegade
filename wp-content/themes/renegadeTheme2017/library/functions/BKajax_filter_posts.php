<?php



/*
function ajax_filter_posts_scripts() {
	$JSdir = get_template_directory_uri();
	$JSdir .= '/library/js/';
	echo $JSdir;
	// Enqueue script
	wp_register_script('afp_script', $JSdir . 'ajax-filter-post.js', false, null, false);
	wp_enqueue_script('afp_script');

	wp_localize_script( 'afp_script', 'afp_vars', array(
	'afp_nonce' => wp_create_nonce( 'afp_nonce' ), // Create nonce which we later will use to verify AJAX request
	'afp_ajax_url' => admin_url( 'admin-ajax.php' ),
	)
	);
}



add_action('wp_enqueue_scripts', 'ajax_filter_posts_scripts', 100);
*/	
$scriptdir = get_template_directory_uri();
$scriptdir .= '/library/js/';

wp_register_script('afp_script', $scriptdir  . 'ajax-filter-post.js', false, null, false);
	wp_enqueue_script('afp_script');
	
	wp_localize_script( 'afp_script', 'afp_vars', array(
	'afp_nonce' => wp_create_nonce( 'afp_nonce' ), // Create nonce which we later will use to verify AJAX request
	'afp_ajax_url' => admin_url( 'admin-ajax.php' ),
	//'afp_ajax_url' => $functiondir . 'admin-ajax.php',
	)
	);

function tags_filter($taxType){
	$tax = $taxType;
	$terms = get_terms( $tax );
	$count = count( $terms );
	//var_dump($terms);
	
    if ( $count > 0 ):
   
       $listHTML = '<div class="post-tags">';

        foreach ( $terms as $term ) {
            $term_link = get_term_link( $term, $tax );
            $listHTML .= '<a href="' . $term_link . '" class="tax-filter" title="' . $term->slug . '">' . $term->name . '</a> ';
        }
        
      	$listHTML .= '</div>';
      	
		endif;
		
return $listHTML;
}

$result = array();

// Script for getting posts
function ajax_filter_get_posts( $taxonomy ) {
	echo('yah');
  // Verify nonce
  if( !isset( $_POST['afp_nonce'] ) || !wp_verify_nonce( $_POST['afp_nonce'], 'afp_nonce' ) )
    die('Permission denied');

  $taxonomy = $_POST['taxonomy'];
  $term = $_POST['term'];
  $action = $_POST['action'];
  /*
  $fucker = array(
  		$taxonomy => $_POST['taxonomy'],
  		$term => $_POST['term'],
  		$action => $_POST['action']
  );
*/
 // var_dump($fucker);
  //var_dump($taxonomy);
  // WP Query
  $filter_args = array(
'tag' => $taxonomy,
    'post_type' => 'articles',
    'posts_per_page' => 10,
  	/*	'tax_query' => array(
  				array(
  						'taxonomy' => 'category',
  						'field'    => 'slug',
  						'terms'    => $term,
  				),
  		),*/
  );

  // If taxonomy is not set, remove key from array and get all posts
  if( !$taxonomy ) {
  unset( $filter_args['tax_query'] );
  
  }
 
  $query = new WP_Query( $filter_args );
  
  if ( $query->have_posts() ) : 


  while ( $query->have_posts() ) : $query->the_post(); 

  $result['response'][] = '<h2><a href="'.get_permalink().'">'. get_the_title().'</a></h2>';
  $result['status']     = 'success';
  
  
	$article_title = get_the_title();
	$ra_author = get_field('ra_author');
	$ra_publication = get_field('ra_publication');
	$ra_date = get_field('ra_date');
	$ra_url = get_field('ra_url');
	$ra_blurb = get_field('ra_blurb');



	$filteredHTML .=  '<div class="article-item">';

		if($ra_date){
			$filteredHTML .=  '<div class="ra-date">' . $ra_date . '</div>';
		}
		
		if($ra_author){
			$filteredHTML .=  '<div class="ra-author">' . $ra_author;
		}
		
		if($ra_publication ){
			$filteredHTML .=  ' for ' . $ra_publication . '</div>';
		}
		
		if($ra_url){
			$filteredHTML .=  '<a href="' . $ra_url . '" target=_blank>';
		}
		
		
		$filteredHTML .= '<h3>' .  $article_title . '</h3>';
		
		if($ra_url){
			$filteredHTML .=  '</a>';
		}
		if($ra_blurb){
			$filteredHTML .=  '<div class="ra-blurb">' . $ra_blurb . '</div><div style="clear:both"></div>';
		}
		
		$filteredHTML .=  '</div>';//END ARTICLES ITEM
		
		endwhile;

//echo $filteredHTML;
else:
$result['response'] = '<h2>No posts found</h2>';
$result['status']   = '404';
  		//echo('<h2>No posts found</h2>');  

endif;
$result = json_encode($result);
echo $result;
  die();
}
 
add_action('wp_ajax_filter_posts', 'ajax_filter_get_posts');
add_action('wp_ajax_nopriv_filter_posts', 'ajax_filter_get_posts');
/**/
?>