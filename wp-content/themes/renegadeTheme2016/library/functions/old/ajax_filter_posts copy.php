<?php
/**
 * AJAX posts filter
 *
 */
function tags_filter($taxType){
	
	$taxargs = array(
			'orderby'           => 'name',
			'order'             => 'DESC',
			'hide_empty'        => 1,
	);
	
	$tax = $taxType;
	$terms = get_terms( $tax, $taxargs );
	$count = count( $terms );

	if ( $count > 0 ):
	 
	$listHTML = '<div class="post-tags">';

	foreach ( $terms as $term ) {
	
		$term_link = get_term_link( $term, $tax );
		$listHTML .= '<div class="' . $tax . '"><a href="' . $term_link . '" class="tax-filter" title="' . $term->slug . '">' . $term->name . '</a></div> ';
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
	$taxonomy_type = $_REQUEST['taxonomy_type'];
//}

$selected_taxonomy = json_encode($taxonomy);



  // Verify nonce
  //if( !isset( $_POST['afp_nonce'] ) || !wp_verify_nonce( $_POST['afp_nonce'], 'afp_nonce' ) )
   // die('Permission denied');
  if($taxonomy_type == 'post_tag'){
  	$taxonomy_type = 'tag';
  } elseif($taxonomy_type == 'category'){
  	$taxonomy_type = 'category_name';
  	
  }
  
  // WP Query

 
  $filter_args = array(
    $taxonomy_type   => $selected_taxonomy,
 //	'tag'            => 'social-media',
    'post_type'      => 'articles',
    'posts_per_page' => -1,
  );
 
  // If taxonomy is not set, remove key from array and get all posts
 // if( !$taxonomy ) {
 //   unset( $filter_args['tag'] );
 // }
 
  $articlesHTML = '';

$query = new WP_Query( $filter_args );
  /**/
  if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();

  
  $article_title = get_the_title();
  $ra_author = get_field('ra_author');
  $ra_publication = get_field('ra_publication');
  $ra_date = get_field('ra_date');
  $ra_url = get_field('ra_url');
  $ra_blurb = get_field('ra_blurb');
  
  
  
  $articlesHTML .=  '<div class="article-item">';
  
  if($ra_date){
  	$articlesHTML .=  '<div class="ra-date">' . $ra_date . $taxonomy_type . '</div>';
  }
  
  if($ra_author){
  	$articlesHTML .=  '<div class="ra-author">' . $ra_author;
  }
  
  if($ra_publication ){
  	$articlesHTML .=  ' for ' . $ra_publication . '</div>';
  }
  
  if($ra_url){
  	$articlesHTML .=  '<a href="' . $ra_url . '" target=_blank>';
  }
  
  
  $articlesHTML .= '<h3>' .  $article_title . '</h3>';
  
  if($ra_url){
  	$articlesHTML .=  '</a>';
  }
  if($ra_blurb){
  	$articlesHTML .=  '<div class="ra-blurb">' . $ra_blurb . '</div><div style="clear:both"></div>';
  }
  
  $articlesHTML .=  '</div>';//END ARTICLES ITEM
  
  
  
 

  endwhile; else:
  //echo('hi');
  endif;

$articlesHTML = json_encode($articlesHTML);
 
  echo(   $articlesHTML );
  die(); 
}

add_action('wp_ajax_filter_posts', 'filter_posts');
add_action('wp_ajax_nopriv_filter_posts', 'filter_posts');
