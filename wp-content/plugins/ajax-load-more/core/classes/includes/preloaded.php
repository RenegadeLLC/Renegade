<?php
// Preloaded
// Get preloaded posts and append to ajax load more object
if(has_action('alm_preload_installed') && $preloaded === 'true'){

   $preloaded_output = '';
   $preload_offset = $offset;

   // If $seo or $filters, set $preloaded_amount to $posts_per_page
   if((has_action('alm_seo_installed') && $seo === 'true' && !$users) || $filters){
      $preloaded_amount = $posts_per_page;
   }	            

   // Paging Add-on
   // Set $preloaded_amount to $posts_per_page
   if($paging === 'true'){
      $preloaded_amount = $posts_per_page;
      $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
      if($paged > 1){
	      $preload_offset = $preloaded_amount * ($paged - 1);
      }
   }

   // CTA Add-on
   // Parse $cta_position
   if($cta){
		$cta_pos_array = explode(":", $cta_position);
		$cta_pos = (string)$cta_pos_array[0];
		$cta_val = (string)$cta_pos_array[1];
		if($cta_pos != 'after'){
         $cta_pos = 'before';
      }
	}	
	
				
	// Create $preloaded_arr
	$preloaded_arr = array( 
		'post_id'        		=> $post_id,
		'acf'           		=> $acf,
		'acf_post_id'   		=> $acf_post_id,
		'acf_field_type'  	=> $acf_field_type,
		'acf_field_name'     => $acf_field_name,
		'users' 					=> $users,
		'users_include' 		=> $users_include,
		'users_exclude' 		=> $users_exclude,
		'users_per_page' 		=> $users_per_page,
		'users_order' 			=> $users_order,
		'users_orderby' 		=> $users_orderby,
		'comments_per_page'  => $comments_per_page,
		'comments_type'      => $comments_type,
		'comments_style'     => $comments_style,
		'comments_template'  => $comments_template,
		'comments_callback'  => $comments_callback,
		'comments_post_id'   => $comments_post_id,
		'post_type'          => $post_type,
		'sticky_posts'			=> $sticky_posts,
		'post_format'        => $post_format,
		'category'           => $category,
		'category__not_in'   => $category__not_in,
		'tag'                => $tag,
		'tag__not_in'        => $tag__not_in,
		'taxonomy'           => $taxonomy,
		'taxonomy_terms'     => $taxonomy_terms,
		'taxonomy_operator'  => $taxonomy_operator,
		'taxonomy_relation'  => $taxonomy_relation,
		'meta_key'           => $meta_key,
		'meta_value'         => $meta_value,
		'meta_compare'       => $meta_compare,
      'meta_relation'      => $meta_relation,
      'meta_type'          => $meta_type,
		'year'               => $year,
		'month'              => $month,
		'day'                => $day,
		'author'             => $author,
		'post__in'           => $post__in,
		'post__not_in'       => $post__not_in,
		'search'        		=> $search,
      'custom_args'        => $custom_args,
		'post_status'        => $post_status,
		'order'              => $order,
		'orderby'            => $orderby,
		'exclude'            => $exclude,
		'offset'             => $preload_offset,
		'posts_per_page'     => $preloaded_amount,
		'lang'               => $lang,
      'css_classes'        => $css_classes,
   );
   
   
   $type = alm_get_repeater_type($repeater);

   if($comments){ // Comments

		if(has_action('alm_comments_installed') && $comments){

   		/*
	   	 *	alm_comments_preloaded
	   	 *
	   	 * Preloaded Comments Filter
	   	 *
	   	 * @return $preloaded_comments;
	   	 */
		   $preloaded_comments = apply_filters('alm_comments_preloaded', $preloaded_arr); // located in comments add-on
         $preloaded_output .= '<'.$comments_style.' class="alm-listing alm-preloaded commentlist alm-comments-preloaded'. $classname . $css_classes .'">';
            
            $preloaded_output .= ($seo === "true") ? '<div class="alm-reveal alm-seo'. $transition_container_classes .'" data-page="1" data-url="'.$canonicalURL.'">' : '';
            	$preloaded_output .= $preloaded_comments;
            $preloaded_output .= ($seo === "true") ? '</div>' : '';
            
         $preloaded_output .= '</'.$container_element.'>';
      }

   }
    
   elseif($users){ // Users
      
      if(has_action('alm_users_preloaded') && $users){		         
			
			// Encrypt User Role
         if(!empty($users_role) && function_exists('alm_role_encrypt')){
            $preloaded_arr['users_role'] = alm_role_encrypt($users_role);
         }
         
         
      
      	/*
	   	 *	alm_users_preloaded
	   	 *
	   	 * Preloaded Users Filter
	   	 *
	   	 * @return $preloaded_users;
	   	 */
		   $preloaded_users = apply_filters('alm_users_preloaded', $preloaded_arr, $preloaded_amount, $repeater, $theme_repeater); // located in Users add-on
         $preloaded_output .= '<'.$container_element.' class="alm-listing alm-preloaded alm-users-preloaded'. $classname . $css_classes .'">';
         
            $preloaded_output .= ($seo === "true") ? '<div class="alm-reveal alm-seo'. $transition_container_classes .'" data-page="1" data-url="'.$canonicalURL.'">' : '';
            	$preloaded_output .= $preloaded_users;
            $preloaded_output .= ($seo === "true") ? '</div>' : '';
         
         $preloaded_output .= '</'.$container_element.'>';  
     
		}
   }

   elseif($acf && ($acf_field_type !== 'relationship')){ // Advanced Custom Fields

		if(has_action('alm_acf_installed') && $acf){

   		/*	alm_acf_preloaded
	   	 *
	   	 * Preloaded ACF Filter
	   	 *
	   	 * @return $preloaded_acf;
	   	 */
		   $preloaded_acf = apply_filters('alm_acf_preloaded', $preloaded_arr, $repeater, $theme_repeater); //located in ACF add-on
			$preloaded_output .= '<'.$container_element.' class="alm-listing alm-preloaded alm-acf-preloaded'. $classname . $css_classes .'" data-total-posts="'. apply_filters('alm_acf_total_rows', $preloaded_arr) .'">';
            
            $preloaded_output .= ($seo === "true") ? '<div class="alm-reveal alm-seo'. $transition_container_classes .'" data-page="1" data-url="'.$canonicalURL.'">' : '';
					$preloaded_output .= $preloaded_acf;
				$preloaded_output .=  ($seo === "true") ? '</div>' : '';

         $preloaded_output .= '</'.$container_element.'>';
      }

   }

   else { // Standard    			      


      /*
   	 *	alm_preload_args
   	 *
   	 * ALM Preloaded add-on Hook
   	 *
   	 * @return $args;
   	 */
      $args = apply_filters('alm_preload_args', $preloaded_arr); // Create preloaded $args



      /*
   	 *	alm_filters_preloaded_args
   	 *
   	 * ALM Filters add-on Hook
   	 *
   	 * @return $args;
   	 */
   	if($filters && has_action('alm_filters_preloaded_args')){
      	// $args = apply_filters('alm_filters_preloaded_args', $args); // Create filters $args
      }



		/*
   	 *	alm_modify_query_args
   	 *
   	 * ALM Core Filter Hook 
   	 *
   	 * @return $args;
   	 * Deprecated 2.10
   	 */
      $args = apply_filters('alm_modify_query_args', $args, $slug);
      

		/*
   	 *	alm_query_args_[id]
   	 *
   	 * ALM Core Filter Hook
   	 *
   	 * @return $args;
   	 */
      $args = apply_filters('alm_query_args_'.$id, $args, $post_id);


		$alm_preload_query = new WP_Query($args);
		
		$alm_total_posts = $alm_preload_query->found_posts - $offset;
		
      $output = $noscript = '';

		if ($alm_preload_query->have_posts()) :
		
			$alm_item = $alm_page = $alm_current = 0;
			$alm_found_posts = $alm_total_posts;
			
			// Filters Wrap [Open] 
			if($filters && has_filter('alm_filters_reveal_open')){   				
	         $output .= apply_filters('alm_filters_reveal_open', $transition_container_classes, $canonicalURL);
			}
			
		   while ($alm_preload_query->have_posts()) : $alm_preload_query->the_post();

		   	$alm_item++;
	         $alm_current++;	 

	         // Call to Action [Before]
				if($cta && has_action('alm_cta_inc') && $cta_pos == 'before'){
   	          $output .= ($alm_current == $cta_val) ? $output .= apply_filters('alm_cta_inc', $cta_repeater, $cta_theme_repeater, $alm_found_posts, $alm_page, $alm_item, $alm_current, true) : '';
			   }

		   	$output .= apply_filters('alm_preload_inc', $repeater, $type, $theme_repeater, $alm_found_posts, $alm_page, $alm_item, $alm_current);

		   	// Call to Action [After]
				if($cta && has_action('alm_cta_inc') && $cta_pos == 'after'){
   	         $output .= ($alm_current == $cta_val) ? apply_filters('alm_cta_inc', $cta_repeater, $cta_theme_repeater, $alm_found_posts, $alm_page, $alm_item, $alm_current, true) : '';
			   }		      			   

         endwhile; wp_reset_query();
         
         // Filters Wrap [close]
		   if($filters && has_filter('alm_filters_reveal_close')){
			   $output .= apply_filters('alm_filters_reveal_close', '</div>');
         }
			
         if(has_action('alm_seo_installed') && $seo === 'true'){ // If SEO, add noscript paging
            // Create noscript paging for SEO if preload and seo are enabled
            $noscript = alm_paging_no_script($alm_preload_query);
         }

		endif;
		
		
		if($filters && class_exists('ALMFILTERS')){
			// Maybe use this for Preloaded
			//$pg = ALMFILTERS::alm_filters_get_page_num();
			//$alm_total_posts = ($pg > 1 ) ? $alm_total_posts - ($preloaded_amount * $pg) + $preloaded_amount : $alm_total_posts;
		}

		$preloaded_output .= '<'.$container_element.' class="alm-listing alm-preloaded'. $classname . $css_classes .'" data-total-posts="'. $alm_total_posts .'">';
      	
      	// .alm-reveal
			if($seo === "true" && $paging === 'false'){
   			
   			// Get querystring to append to URL (Maybe in the future)
   			// $querystring = $_SERVER['QUERY_STRING'];
   			$querystring = '';
   			
   			if(is_search()){
      			// If search, append slug (?s=term) to data-url
   			   $preloaded_output .= '<div class="alm-reveal alm-seo'. $transition_container_classes .'" data-page="1" data-url="'. $canonicalURL .''. $slug . $querystring .'">';
   			}else{
      			// Append querystring to data-url
      			$querystring = ($querystring) ? '?'.$querystring : '';
   			   $preloaded_output .= '<div class="alm-reveal alm-seo'. $transition_container_classes .'" data-page="1" data-url="'. $canonicalURL . $querystring .'">';
   			}
         }
         
         if($seo === "false" && $paging === 'true' || $seo === "true" && $paging === 'true'){
            $preloaded_output .= '<div class="alm-reveal'. $transition_container_classes .'">';
         }
			
			// Preloaded output
			$preloaded_output .= $output;
			
			// Close .alm-reveal
			if($seo === "true" && $paging === 'false' || $seo === "true" && $paging === 'true'){
   			$preloaded_output .= '</div>';
         }

		$preloaded_output .= '</'.$container_element.'>';

		if(has_action('alm_seo_installed')){ // If SEO, add noscript paging
		   $preloaded_output .= $noscript;
		}
   }

	$ajaxloadmore .= $preloaded_output; // Add $preloaded_output data to $ajaxloadmore
}