<?php
/**
 * Partial template for content in page.php
 *
 * @package understrap
 */
	
	//GET POST TYPE FIELDS
	global $orderby;
	$article_title = get_the_title();
	$ra_author = get_field('ra_author');
	$ra_publication = get_field('ra_publication');
	$ra_date = get_field('ra_date');
	//$ra_date = new DateTime(get_field('ra_date'));
	$ra_year = new DateTime(get_field('ra_date'));
	$ra_year = $ra_year->format('Y');
	//$ra_year = strtotime($ra_year);
	$ra_url = get_field('ra_url');
	$ra_blurb = get_field('ra_blurb');
	global $prevYear;
	global $prevPub;
	global $year_arr;
	global $pub_arr;
	
	?>

	

		<?php //the_content(); 
		
	   $post_edit_link = get_edit_post_link();
	   $article_html = '';
	 
	   if($ra_year != $prevYear && $orderby == 'date' && !in_array($ra_year, $year_arr)):
	   
	   $article_html .=  '<div class="grid-item grid-item-w-50 article-excerpt resource-excerpt">';
	   
	   $article_html .= '<h1 class="article-group">' . $ra_year . '</h1></div>';
	   array_push($year_arr, $ra_year);
	   
	   elseif($orderby != 'date' && $orderby != 'title' &&  $orderby == 'meta_value' && !in_array($ra_publication, $pub_arr)):
	   
	   $article_html .=  '<div class="article-item post-grid-item post-grid-item-w-100 article-excerpt resource-excerpt">';
	   $article_html .= '<h1 class="article-group">' . $ra_publication . '</h1></div>';
	   array_push($pub_arr, $ra_publication);
	   
	   else:
	   $article_html .= '<a href="' . $ra_url . '" target="_blank">';
	   $article_html .=  '<div class="grid-item grid-item-w-50 article-excerpt resource-excerpt">';
	   
	   if($ra_date){
	       $article_html .=  '<div class="date">' . $ra_date . '</div>';
	       
	   }
	   $article_html .= '<h2 class="article">' . $article_title . '</h2>';
	   
	   if($ra_url){
	       //$article_html .=  '</a>';
	   }
	   
	
	   
	   if($ra_author){
	       $article_html .=  '<div class="author">' . $ra_author . ' for <span class="semibold">' . $ra_publication . '</span></div>';
	   }

	   
	   if($ra_blurb){
	       $article_html .=  '<div class="excerpt">' . $ra_blurb . '</div><div style="clear:both"></div>';
	   }
	   
	   $article_html .=  '</a>';
	   
	   $article_html .= '<div><a href="' . $post_edit_link  . '">' . 'Edit'  . '</a></div>';
	   
	   $article_html .=  '</div>';//END ARTICLES ITEM
	   
	 endif;
	   
	   $prevYear = $ra_year;
	   $prevPub = $ra_publication;
	   
		
	   echo($article_html);
		?>

		<?php
		/*wp_link_pages( array(
			'before' => '<div class="page-links">' . __( 'Pages:', 'understrap' ),
			'after'  => '</div>',
		) );*/
		?>




