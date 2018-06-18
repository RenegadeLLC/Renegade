<?php
/**
 * @package Renegade
 */
?>


<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<?php 
$single_url = esc_url( get_permalink() );

$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
	if ( $image ) { // check if the post has a Post Thumbnail assigned to it.
			
				//echo '<a href="' . $single_url . '"><div class="circle" style="background:url(' . $image[0] . ') no-repeat cover center;"><img class="post-image" src="' . $image[0] . '"></div></a>';

			} else{
				//echo '<a href="' . $single_url . '"><div class="saw-circle"><img src="http://localhost:8888/Renegade/wp-content/uploads/saw_400_grey.png"></div></a>';
			}
?>


<div class="blog-title-ct"><?php the_title( sprintf( '<h2><a href="%s" rel="bookmark" class="blog-title-ct">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
</div>
<div class="date icon-calendar"><?php the_time(get_option('date_format'));?></div>
	<header class="entry-header">
	
		<?php if ( 'post' == get_post_type() ) : ?>
		<div class="entry-meta">
<?php //rmg_posted_on(); ?>
<span class="categories"><?php

	foreach((get_the_category()) as $category) {
	    if ($category->cat_name != 'Uncategorized') {
	   // echo '<a href="' . get_category_link( $category->term_id ) . '" title="' . sprintf( __( "View all posts in %s" ), $category->name ) . '" ' . '>' . $category->name.'</a> ';
		}
}?></span>
		
	
		<?php 	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		//comments_popup_link( __( 'Leave a comment', 'rmg' ), __( '1 Comment', 'rmg' ), __( '% Comments', 'rmg' ) );
		echo '</span>';
	}

	edit_post_link( __( 'Edit', 'rmg' ), '<span class="edit-link">', '</span>' );
	?>
		
		</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
		
		the_excerpt(sprintf(
	//	__( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'ad' ),
		the_title( '<span class="screen-reader-text">"', '"</span>', false )
		));
		
			/* translators: %s: Name of current post */
			/*the_content( sprintf(
				__( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'rmg' ), 
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			) );*/
		?>

		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'rmg' ),
				'after'  => '</div>',
			) );
		?>
	
</div>
	<footer class="entry-footer">
		<?php //rmg_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->

