<?php
/**
 * @package Renegade
 */
?>


<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<?php 
$single_url = esc_url( get_permalink() );

	if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
			
				$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
				$blogHTML .= '<a href="' . $single_url . '"><img class="post-image circle" src="' . $image[0] . '"></a>';

			} else{
				//$image = '';
			}

$blogHTML .= '<div class="date icon-calendar">' . the_time(get_option('date_format')) . '</div>';
$blogHTML .= '<div class="blog-title-ct">' . the_title( sprintf( '<h2><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); 

$blogHTML .= '</div><header class="entry-header">';

if ( 'post' == get_post_type() ) : 
	$blogHTML .= '<div class="entry-meta">';

$blogHTML .= '<span class="categories">';

	foreach((get_the_category()) as $category) {
	    if ($category->cat_name != 'Uncategorized') {
	   $blogHTML .=  '<a href="' . get_category_link( $category->term_id ) . '" title="' . sprintf( __( "View all posts in %s" ), $category->name ) . '" ' . '>' . $category->name.'</a> ';
		}
}
$blogHTML .= '</span>';

if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		$blogHTML .=  '<span class="comments-link">';
		//comments_popup_link( __( 'Leave a comment', 'rmg' ), __( '1 Comment', 'rmg' ), __( '% Comments', 'rmg' ) );
		$blogHTML .=  '</span>';
	}

	edit_post_link( __( 'Edit', 'rmg' ), '<span class="edit-link">', '</span>' );

		
	$blogHTML .= 	'</div><!-- .entry-meta -->';
endif; 
	$blogHTML .=  '</header><!-- .entry-header -->';

	$blogHTML .= '<div class="entry-content">';
	
	/*	
		the_excerpt(sprintf(
		__( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'ad' ),
		the_title( '<span class="screen-reader-text">"', '"</span>', false )
		));*/
		
			/* translators: %s: Name of current post */
			/*the_content( sprintf(
				__( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'rmg' ), 
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			) );*/
	
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'rmg' ),
				'after'  => '</div>',
			) );
	
	

	$blogHTML .=  '<footer class="entry-footer"></footer><!-- .entry-footer --></article><!-- #post-## -->';
		
	


return $blogHTML;