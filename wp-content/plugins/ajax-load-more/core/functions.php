<?php


/*
*  alm_masonry_after
*  Masonry HTML wrapper open
*
*  @param $transition string
*  @since 3.1.0
*/
function alm_masonry_before($transition){
	return ($transition === 'masonry') ? '<div class="alm-masonry" style="opacity: 0;">' : '';
}
add_filter('alm_masonry_before', 'alm_masonry_before');



/*
*  alm_masonry_after
*  Masonry HTML wrapper close
*
*  @param $transition string
*  @since 3.1.0
*/
function alm_masonry_after($transition){
	return ($transition === 'masonry') ? '</div>' : '';
}
add_filter('alm_masonry_after', 'alm_masonry_after');



/*
*  alm_progress_css
*  If progress bar, add the CSS styles for the bar.
*
*  @param $counter              int
*  @param $progress_bar         string
*  @param $progress_bar_color   string
*  @since 3.1.0
*/
function alm_progress_css($counter, $progress_bar, $progress_bar_color){
	if($counter == 1 && $progress_bar === 'true'){
		$style = '
<style>
.pace {
	-webkit-pointer-events: none;
	pointer-events: none;
	-webkit-user-select: none;
	-moz-user-select: none;
	user-select: none;
}
.pace-inactive {
	display: none;
}
.pace .pace-progress {
	background: #'. $progress_bar_color .';
	position: fixed;
	z-index: 2000;
	top: 0;
	right: 100%;
	width: 100%;
	height: 5px;
	-webkit-box-shadow: 0 0 3px rgba(255, 255, 255, 0.3);
	box-shadow: 0 0 2px rgba(255, 255, 255, 0.3);
}
</style>';
		return $style;
	}
}
add_filter('alm_progress_css', 'alm_progress_css', 10, 3);



/*
*  alm_css_disabled
*  Has core ALM CSS disabled?
*
*  @param $setting name of the setting field
*  @return boolean
*  @since 3.3.1
*/

function alm_css_disabled($setting) {
	$options = get_option( 'alm_settings' );
	$disabled = true;
	if(!isset($options[$setting]) || $options[$setting] != '1'){
		$disabled = false;
	}
	return $disabled;
}



/*
*  alm_do_inline_css
*  Load ALM CSS inline
*
*
*  @param $setting name of the setting field
*  @return boolean
*  @since 3.3.1
*/

function alm_do_inline_css($setting) {
	$options = get_option( 'alm_settings' );
	$inline = false;
	if(!isset($options[$setting]) || $options[$setting] === '1'){
		$inline = true;
	}
	return $inline;
}



/*
*  alm_get_current_repeater
*  Get the current repeater template file
*
*  @param $repeater string current repater name*
*  @param $type string The type of template
*  @return $include (file path)
*  @since 2.5.0
*/

function alm_get_current_repeater($repeater, $type) {

	$template = $repeater;
	$include = '';

	// If is Custom Repeaters (Custom Repeaters v1)
	if( $type == 'repeater' && has_action('alm_repeater_installed' )){
		$include = ALM_REPEATER_PATH . 'repeaters/'. $template .'.php';

		if(!file_exists($include)){ //confirm file exists
		   alm_get_default_repeater();
		}

	}
   // If is Unlimited Repeaters (Custom Repeaters v2)
	elseif( $type == 'template_' && has_action('alm_unlimited_installed' )){
		global $wpdb;
		$blog_id = $wpdb->blogid;

		if($blog_id > 1){
			$include = ALM_UNLIMITED_PATH. 'repeaters/'. $blog_id .'/'.$template .'.php';
		}else{
			$include = ALM_UNLIMITED_PATH. 'repeaters/'.$template .'.php';
		}

		if(!file_exists($include)){ //confirm file exists
		   $include = alm_get_default_repeater();
		}
	}
	// Default repeater
	else{
		$include = alm_get_default_repeater();
	}

	// Security check
	// check if $template contains relative path. So, set include to default
	if ( false !== strpos( $template, './' ) ) {
	   $include = alm_get_default_repeater();
	}

	return $include;

}



/*
*  alm_get_default_repeater
*  Get the default repeater template for current blog
*
*  @return $include (file path)
*  @since 2.5.0
*/

function alm_get_default_repeater() {

	global $wpdb;
	$file = null;
	$template_dir = 'alm_templates';

	// Allow user to load template from theme directory
	// Since 2.8.5

    // load repeater template from current theme folder
	if(is_child_theme()){
		$template_theme_file = get_stylesheet_directory().'/'. $template_dir .'/default.php';
		// if child theme does not have repeater template, then use the parent theme dir
		if(!file_exists($template_theme_file)){
			$template_theme_file = get_template_directory().'/'. $template_dir .'/default.php';
		}
	}
	else{
		$template_theme_file = get_template_directory().'/'. $template_dir .'/default.php';
	}
	// if theme or child theme contains the template, use that file
	if(file_exists($template_theme_file)){
		$file = $template_theme_file;
	}

	// Since 2.0
	// Updated 3.5
	if($file == null){
   	$file = AjaxLoadMore::alm_get_repeater_path() .'/default.php';
	}

	return $file;
}



/*
*  alm_get_taxonomy
*  Query by custom taxonomy values
*
*  @return $args = array();
*  @since 2.5.0
*
*  @deprecated in 2.5.0
*/
function alm_get_taxonomy($taxonomy, $taxonomy_terms, $taxonomy_operator){
   if(!empty($taxonomy) && !empty($taxonomy_terms) && !empty($taxonomy_operator)){
      $the_terms = explode(",", $taxonomy_terms);
      $args = array(
		   'taxonomy' => $taxonomy,
			'field' => 'slug',
			'terms' => $the_terms,
			'operator' => $taxonomy_operator,
		);
		return $args;
	}
}



/*
*  alm_get_post_format
*  Query by post format
*
*  @return $args = array();
*  @since 2.5.0
*  @updated 2.8.5
*/
function alm_get_post_format($post_format){
   if(!empty($post_format)){
	   $format = "post-format-$post_format";
	   //If query is for standard then we need to filter by NOT IN
	   if($format == 'post-format-standard'){
      	if (($post_formats = get_theme_support('post-formats')) && is_array($post_formats[0]) && count($post_formats[0])) {
            $terms = array();
            foreach ($post_formats[0] as $format) {
               $terms[] = 'post-format-'.$format;
            }
         }
	      $return = array(
            'taxonomy' => 'post_format',
            'terms' => $terms,
            'field' => 'slug',
            'operator' => 'NOT IN',
         );
	   }else{
			$return = array(
			   'taxonomy' => 'post_format',
			   'field' => 'slug',
			   'terms' => array($format),
			);
		}
		return $return;
	}
}



/*
*  alm_get_taxonomy_query
*  Query for custom taxonomy
*
*  @return $args = array();
*  @since 2.8.5
*/
function alm_get_taxonomy_query($taxonomy, $taxonomy_terms, $taxonomy_operator){
   if(!empty($taxonomy) && !empty($taxonomy_terms)){
      $taxonomy_term_values = alm_parse_tax_terms($taxonomy_terms);
      $return = array(
         'taxonomy' => $taxonomy,
         'field' => 'slug',
         'terms' => $taxonomy_term_values,
         'operator' => $taxonomy_operator
      );
      return $return;
   }
}



/*
*  alm_parse_tax_terms
*  Parse the taxonomy terms for multiple vals
*
*  @helper function @alm_get_taxonomy_query()
*  @return array;
*  @since 2.8.5
*/
function alm_parse_tax_terms($taxonomy_terms){
	// Remove all whitespace for $taxonomy_terms because it needs to be an exact match
	$taxonomy_terms = preg_replace('/\s+/', ' ', $taxonomy_terms); // Trim whitespace
	$taxonomy_terms = str_replace(', ', ',', $taxonomy_terms); // Replace [term, term] with [term,term]
	$taxonomy_terms = explode(",", $taxonomy_terms);
   return $taxonomy_terms;
}



/*
*  alm_get_tax_query
*  Query by custom taxonomy values
*
*  @return $args = array();
*  @since 2.5.0

*  @deprecated in 2.8.5
*/
function alm_get_tax_query($post_format, $taxonomy, $taxonomy_terms, $taxonomy_operator){

   // Taxonomy [ONLY]
   if(!empty($taxonomy) && !empty($taxonomy_terms) && !empty($taxonomy_operator) && empty($post_format)){
      $the_terms = explode(",", $taxonomy_terms);
      $args = array(
		   'taxonomy' => $taxonomy,
			'field' => 'slug',
			'terms' => $the_terms,
			'operator' => $taxonomy_operator,
		);
		return $args;
	}

	// Post Format [ONLY]
   if(!empty($post_format) && empty($taxonomy)){
	   $format = "post-format-$post_format";

	   //If query is for standard then we need to filter by NOT IN
	   if($format == 'post-format-standard'){
      	if (($post_formats = get_theme_support('post-formats')) && is_array($post_formats[0]) && count($post_formats[0])) {
            $terms = array();
            foreach ($post_formats[0] as $format) {
               $terms[] = 'post-format-'.$format;
            }
         }
	      $args = array(
            'taxonomy' => 'post_format',
            'terms' => $terms,
            'field' => 'slug',
            'operator' => 'NOT IN',
         );
	   }else{
			$args = array(
			   'taxonomy' => 'post_format',
			   'field' => 'slug',
			   'terms' => array($format),
			);
		}
		return $args;
	}

	// Taxonomy && Post Format [COMBINED]
	if(!empty($post_format) && !empty($taxonomy) && !empty($taxonomy_terms) && !empty($taxonomy_operator)){
   	$the_terms = explode(",", $taxonomy_terms);
	   $args = array(
			'taxonomy' => $taxonomy,
			'field' => 'slug',
			'terms' => $the_terms,
			'operator' => $taxonomy_operator,
		);
	   $format = "post-format-$post_format";
		//If query is for standard then we need to filter by NOT IN
	   if($format == 'post-format-standard'){
      	if (($post_formats = get_theme_support('post-formats')) && is_array($post_formats[0]) && count($post_formats[0])) {
            $terms = array();
            foreach ($post_formats[0] as $format) {
               $terms[] = 'post-format-'.$format;
            }
         }
	      $format_args = array(
            'taxonomy' => 'post_format',
            'terms' => $terms,
            'field' => 'slug',
            'operator' => 'NOT IN',
         );
	   }else{
			$format_args = array(
			   'taxonomy' => 'post_format',
			   'field' => 'slug',
			   'terms' => array($format),
			);
		}
		$args[] = $format_args; // Combined format and tax $args
		return $args;
	}
}



/*
*  alm_get_meta_query
*  Query by custom field values
*
*  @return $args = array();
*  @since 2.5.0
*/
function alm_get_meta_query($meta_key, $meta_value, $meta_compare, $meta_type){
   if(!empty($meta_key)){
      $meta_values = alm_parse_meta_value($meta_value, $meta_compare);
      if(!empty($meta_values)){
         $return = array(
            'key' => $meta_key,
            'value' => $meta_values,
            'compare' => $meta_compare,
            'type' => $meta_type
         );
      }else{
         // If $meta_values is empty, don't query for 'value'
         $return = array(
            'key' => $meta_key,
            'compare' => $meta_compare,
            'type' => $meta_type
         );
      }
      return $return;
   }
}



/*
*  alm_parse_meta_value
*  Parse the meta value for multiple vals
*
*  @helper function @alm_get_meta_query()
*  @return array;
*  @since 2.6.4
*/
function alm_parse_meta_value($meta_value, $meta_compare){
   // See the docs (http://codex.wordpress.org/Class_Reference/WP_Meta_Query)
   if($meta_compare === 'IN' || $meta_compare === 'NOT IN' || $meta_compare === 'BETWEEN' || $meta_compare === 'NOT BETWEEN'){
   	// Remove all whitespace for meta_value because it needs to be an exact match
   	$mv_trimmed = preg_replace('/\s+/', ' ', $meta_value); // Trim whitespace
   	$meta_values = str_replace(', ', ',', $mv_trimmed); // Replace [term, term] with [term,term]
   	$meta_values = explode(",", $meta_values);
   }else{
   	$meta_values = $meta_value;
   }
   return $meta_values;
}



/*
*  alm_get_repeater_type
*  Get type of repeater
*
*  @return $type;
*  @since 2.9
*/
function alm_get_repeater_type($repeater){
	$type = preg_split('/(?=\d)/', $repeater, 2); // split $repeater value at number to determine type
   $type = $type[0]; // default | repeater | template_
	return $type;
}



/*
*  alm_get_canonical_url
*  Get current page base URL
*
*  @return $canonicalURL;
*  @since 2.12
*/
function alm_get_canonical_url(){

	$canonicalURL = '';

	// Date
   if(is_date()){
      // Is archive page
      $archive_year = get_the_date('Y');
      $archive_month = get_the_date('m');
      $archive_day = get_the_date('d');
      if(is_year()){
        $canonicalURL = get_year_link( $archive_year );
      }
      if(is_month()){
        $canonicalURL = get_month_link( $archive_year, $archive_month );
      }
      if(is_day()){
        $canonicalURL = get_month_link( $archive_year, $archive_month, $archive_day );
      }
   }
   // Frontpage
   elseif(is_front_page()){
	   if(function_exists('pll_home_url')){ // Polylang support
		   $canonicalURL = pll_home_url();
	   }else{
      	$canonicalURL = get_home_url().'/';
      }
   }
   // Home (Blog Default)
   elseif(is_home()){
      $canonicalURL = get_permalink(get_option('page_for_posts'));
   }
   // Category
   elseif(is_category()){
      $cur_cat_id = get_cat_id( single_cat_title('',false) );
      $canonicalURL = get_category_link($cur_cat_id);
   }
   // Tag
   elseif(is_tag()){
      $cur_tag_id = get_query_var('tag_id');
      $canonicalURL = get_tag_link($cur_tag_id);
   }
   // Author
   elseif(is_author()){
      $author_id = get_the_author_meta('ID');
      $canonicalURL = get_author_posts_url($author_id);
   }
   // Taxonomy
   elseif(is_tax()){
      $tax_term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy' ));
      $tax_id = $tax_term->term_id;
      $canonicalURL = get_term_link($tax_id);
   }
   // Post Type
   elseif(is_post_type_archive()){
      $post_type_archive = get_post_type();
      $canonicalURL = get_post_type_archive_link($post_type_archive);
   }
   // Search
   elseif(is_search()){
      $canonicalURL = get_home_url().'/';
   }
   else{
      $canonicalURL = get_permalink();
   }

	return $canonicalURL;
}



/*
*  alm_get_page_slug
*  Get current page slug
*
*  @return slug;
*  @since 2.13.0
*/
function alm_get_page_slug($post){

	if(!is_archive()){
		// If not an archive page, set the post slug
		if(is_front_page() || is_home()){
			$slug = 'home';
		}else{
   		// Search
   		if(is_search()){
      		$search_query = get_search_query();
      		if($search_query){
         		$slug = "?s=$search_query";
      		}else{
         		$slug = '?s=';
      		}
         }else{
		      $slug = $post->post_name;
		   }
      }
	}else{
		// Tax
		if(is_tax()){
			$queried_object = get_queried_object();
			$slug = $queried_object->slug;
		}
		// Category
		elseif(is_category()){
	      $cat = get_query_var('cat');
			$category = get_category($cat);
			$slug = $category->slug;
	   }
	   // Tag
	   elseif(is_tag()){
	      $slug = get_query_var('tag');
	   }
		// Author
		elseif(is_author()){
	      $slug = get_the_author_meta('ID');
	   }
		// Post Type Archive
		elseif(is_post_type_archive()){
			$slug = get_post_type();
		}
		elseif(is_date()){
			// Is archive page
	      $archive_year = get_the_date('Y');
	      $archive_month = get_the_date('m');
	      $archive_day = get_the_date('d');
	      if(is_year()){
	        $slug = $archive_year;
	      }
	      if(is_month()){
	        $slug = $archive_year.'-'.$archive_month;
	      }
	      if(is_day()){
	        $slug = $archive_year.'-'.$archive_month.'-'.$archive_day;
	      }
		}
		else{
			$slug = '';
		}
	}

	return $slug;
}


/*
*  alm_get_page_id
*  Get current page ID
*
*  @return $post_id;
*  @since 3.0.1
*/
function alm_get_page_id($post){

   $post_id = '';

	if(!is_archive()){
		// If not an archive page, set the post slug
		if(is_front_page() || is_home()){
			$post_id = '0';
		}else{
   		// Search
   		if(is_search()){
      		$search_query = get_search_query();
      		if($search_query){
         		$post_id = "$search_query";
      		}
         }else{
		      $post_id = $post->ID;
		   }
      }
	}else{
		// Tax
		if(is_tax() || is_tag() || is_category()){
			$queried_object = get_queried_object();
			$post_id = $queried_object->term_id;
		}
		// Author
		elseif(is_author()){
	      $post_id = get_the_author_meta('ID');
	   }
		// Post Type Archive
		elseif(is_post_type_archive()){
			$post_id = get_post_type();
		}
		elseif(is_date()){
			// Is archive page
	      $archive_year = get_the_date('Y');
	      $archive_month = get_the_date('m');
	      $archive_day = get_the_date('d');
	      if(is_year()){
	        $post_id = $archive_year;
	      }
	      if(is_month()){
	        $post_id = $archive_year.'-'.$archive_month;
	      }
	      if(is_day()){
	        $post_id = $archive_year.'-'.$archive_month.'-'.$archive_day;
	      }
		}
	}

	return $post_id;
}



/*
*  alm_get_startpage
*  Get query param of start page (paged, page)
*
*  @since 2.14.0
*/
function alm_get_startpage(){
   if ( get_query_var('paged') ) {
      $start_page = get_query_var('paged');
   } elseif ( get_query_var('page') ) {
      $start_page = get_query_var('page');
   } else {
      $start_page = 1;
   }
   return $start_page;
}



/*
*  alm_paging_no_script
*  Create paging navigation
*
*  @return html;
*  @since 2.8.3
*/
function alm_paging_no_script($alm_preload_query){
   $numposts = $alm_preload_query->found_posts;
   $max_page = $alm_preload_query->max_num_pages;
   if(empty($paged) || $paged == 0) {
      $paged = 1;
   }
   $pages_to_show = 8;
   $pages_to_show_minus_1 = $pages_to_show-1;
   $half_page_start = floor($pages_to_show_minus_1/2);
   $half_page_end = ceil($pages_to_show_minus_1/2);
   $start_page = $paged - $half_page_start;
   if($start_page <= 0) {
      $start_page = 1;
   }
   $end_page = $paged + $half_page_end;
   if(($end_page - $start_page) != $pages_to_show_minus_1) {
      $end_page = $start_page + $pages_to_show_minus_1;
   }
   if($end_page > $max_page) {
      $start_page = $max_page - $pages_to_show_minus_1;
      $end_page = $max_page;
   }
   if($start_page <= 0) {
      $start_page = 1;
   }
   $content = '';
   if ($max_page > 1) {
      $content .= '<noscript>';
      $content .= '<div>';
      $content .= '<span>'.__('Pages:', 'ajax-load-more').'  </span>';
      if ($start_page >= 2 && $pages_to_show < $max_page) {
         $first_page_text = "&laquo;";
         $content .= '<span class="page"><a href="'.get_pagenum_link().'">'.$first_page_text.'</a></span>';
      }
      for($i = $start_page; $i  <= $end_page; $i++) {
      if($i == $paged) {
         $content .= ' <span class="page current">'.$i.'</span> ';
      } else {
         $content .= ' <span class="page"><a href="'.get_pagenum_link($i).'">'.$i.'</a></span>';
      }
   }
   if ($end_page < $max_page) {
      $last_page_text = "&raquo;";
      $content .= '<span><a href="'.get_pagenum_link($max_page).'" title="'.$last_page_text.'">'.$last_page_text.'</a></span>';
   }
      $content .= '</div>';
      $content .= '</noscript>';
   }
   return $content;
}
