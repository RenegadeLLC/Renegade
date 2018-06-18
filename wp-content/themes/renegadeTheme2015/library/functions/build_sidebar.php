<?php /******************  BUILD SIDEBAR *********************/


	//	$sidebar_item = get_field('sidebar_item', get_option('page_for_posts'));
		
		$sidebarHTML = '';

		if( have_rows('sidebar_item', get_option('page_for_posts')) ):
	
   		 while ( have_rows('sidebar_item', get_option('page_for_posts')) ) : the_row();
		
			$sidebar_content_type = get_sub_field('sidebar_content_type');
			$sidebar_headline = get_sub_field('sidebar_headline');
			$background_color = get_sub_field('background_color');
			$background_image = get_sub_field('sidebar_background_image');
			$text_color = get_sub_field('text_color');
			$sidebar_headline_color = get_sub_field('sidebar_headline_color');
			$link_color = get_sub_field('link_color');

			$sidebarBlockHTML = '';
			
			$sidebarBlockHTML .= '<div class="square"><div class="sidebar-block" style="';
			
			
			if($background_color):
				$sidebarBlockHTML .= 'background-color:' . $background_color . '; '; 
			endif;
			
			if($background_image):
				$sidebarBlockHTML .= 'background-image:url(' . $background_image . '); background-repeat:no-repeat; background-size:cover; background-position:center; ';
			endif;
			
			if($text_color):
				$sidebarBlockHTML .= 'color:' . $text_color . '; ';
			endif;
			
			$sidebarBlockHTML .= '">';//CLOSE CUSTSOM STYLING
			
			$sidebarBlockHTML .= '<div class="mark"></div>';
			
			$sidebarBlockHTML .= 	'<h1 style="color:' . $sidebar_headline_color . ';">' . $sidebar_headline . '</h1>';

			switch ($sidebar_content_type) {
				
				case 'Inline Navigation':
					echo 'Inline Navigation';
					break;
					
				case 'Subscribe to List':
					$signup_form_shortcode = get_sub_field('signup_form_shortcode', get_option('page_for_posts'));
					
				//	echo $signup_form_shortcode;
					//[acf field='signup_form_shortcode']
					$sidebarBlockHTML .= do_shortcode($signup_form_shortcode);
					 
					break;
				
				case 'Archives':
					$sidebarBlockHTML .= '<ul class="archive">';
					
					 $args = array(
						'type'            => 'monthly',
						'limit'           => '',
						'format'          => 'custom', 
						'before'          => '',
						'after'           => '<br />',
						'show_post_count' => false,
						'echo'            => 0,
						'order'           => 'DESC'
					);
					
					$archives = wp_get_archives( $args );
					
					$sidebarBlockHTML .= $archives . '</ul>';
					
					break;
					
				case 'Categories':
					
					$category_args = array(
							'type'                     => 'post',
							'child_of'                 => 0,
							'parent'                   => '',
							'orderby'                  => 'name',
							'order'                    => 'ASC',
							'hide_empty'               => 1,
							'hierarchical'             => 1,
							'exclude'                  => '',
							'include'                  => '',
							'number'                   => '',
							'taxonomy'                 => 'category',
							'pad_counts'               => false
					
					);
					
					$categories = get_the_category_list();
					
					$sidebarBlockHTML .= $categories;
					
					break;
					
				case 'Tags':
						echo 'Tags';
						break;
						
				case 'Image':
						echo 'Image';
						break;
						
				case 'Custom':
						//echo 'Custom';
						break;
			}
			
		$sidebarBlockHTML .='</div></div>'; //CLOSE SIDEBAR BLOCK

		$sidebarHTML .= $sidebarBlockHTML;
		
		endwhile;
		echo $sidebarHTML;
else :

    // no rows found

endif;
		?>