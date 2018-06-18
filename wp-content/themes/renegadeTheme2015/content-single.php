<?php
/**
 * @package Renegade
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<div class="date"><?php the_time(get_option('date_format'));?></div>
<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	<div class="blog-post">
<header class="entry-header">
<div class="entry-meta">
	<span class="categories"><?php
foreach((get_the_category()) as $category) {
    if ($category->cat_name != 'Uncategorized') {
    //echo '<a href="' . get_category_link( $category->term_id ) . '" title="' . sprintf( __( "View all posts in %s" ), $category->name ) . '" ' . '>' . $category->name.'</a> ';
}
}?></span>


	
		
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'rmg' ),
				'after'  => '</div>',
			) );
		?>
		
	</div><!-- .entry-content -->
</div><!-- .blog-post -->
	<footer class="entry-footer">
		<?php //rmg_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
