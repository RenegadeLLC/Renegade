<?php
/**
 * The template for displaying archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Renegade
 */

get_header(); ?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<div class="blog-page">

<div class="content-wrapper" style="background:#fff; overflow:hidden; padding-bottom:0px;">



<div class="blog-post-ct">
<div class="blog-header-ct">
<div class="outer-wrapper" style="background-color:#000;"><div class="wrapper">
<div class="headline-ct">
		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="white text-center">Saw a Good Idea<span class="gray"> -
					<?php
						if ( is_category() ) :
							single_cat_title();

						elseif ( is_tag() ) :
							single_tag_title();

						elseif ( is_author() ) :
							printf( __( ' %s', 'rmg' ), '<span class="vcard">' . get_the_author() . '</span>' );

						//elseif ( is_day() ) :
							//printf( __( 'Day: %s', 'rmg' ), '<span>' . get_the_date() . '</span>' );

						elseif ( is_month() ) :
							printf( __( '%s', 'rmg' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'rmg' ) ) . '</span>' );

						elseif ( is_year() ) :
							printf( __( '%s', 'rmg' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'rmg' ) ) . '</span>' );

						elseif ( is_tax( 'post_format', 'post-format-aside' ) ) :
							_e( '', 'rmg' );

						elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) :
							_e( '', 'rmg' );

						elseif ( is_tax( 'post_format', 'post-format-image' ) ) :
							_e( '', 'rmg' );

						elseif ( is_tax( 'post_format', 'post-format-video' ) ) :
							_e( '', 'rmg' );

						elseif ( is_tax( 'post_format', 'post-format-quote' ) ) :
							_e( '', 'rmg' );

						elseif ( is_tax( 'post_format', 'post-format-link' ) ) :
							_e( '', 'rmg' );

						elseif ( is_tax( 'post_format', 'post-format-status' ) ) :
							_e( '', 'rmg' );

						elseif ( is_tax( 'post_format', 'post-format-audio' ) ) :
							_e( '', 'rmg' );

						elseif ( is_tax( 'post_format', 'post-format-chat' ) ) :
							_e( 'Chats', 'rmg' );

						else :
							_e( '', 'rmg' );

						endif;
					?>
	
				<?php
					// Show an optional term description.
					$term_description = term_description();
					if ( ! empty( $term_description ) ) :
						printf( '<div class="taxonomy-description">%s </div>', $term_description );
					endif;
				?>		</span>
				</h1>
					</div><!-- blog-header-ct -->
				</div><!-- .headline-ct -->
				</div><!-- .wrapper -->
				</div><!-- .outer-wrapper -->
			</header><!-- .page-header -->
<div class="outer-wrapper" style="background-color:#e6e7e8;"><div class="wrapper">
<div class="grid-item-w-75" style="background:#fff !important;">
<div class="post-grid grid"><div class="post-grid-gutter"></div>		
			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
<div class="post-grid-item post-grid-item-w-25 blog-tile">
				<?php
					
					get_template_part( 'content', get_post_format() );
				?>
</div>
			<?php endwhile; ?>

			<?php rmg_paging_nav(); ?>

		<?php else : ?>

			<?php get_template_part( 'content', 'none' ); ?>

		<?php endif; ?>
		
		
	</div><!-- .post-grid -->	
</div><!-- .blog-post-ct -->	<div class="clearfix"></div>
		</div><!-- .left col 75 -->
		
		<div class="grid-item-w-25">
		<div id="blog-sidebar">
		<?php 
		get_sidebar();
		
		?>
		</div><!-- #blog-sidebar -->
		</div><!-- .page-grid-item-25 -->
		</div></div><!-- .outer-wrapper -->
		</main><!-- #main -->
	</section><!-- #primary -->

<script type="text/javascript">
$( function() {
	  
	  $('.post-grid').isotope({
		 percentPosition: true,
	  layoutMode: 'packery',
	  //   layoutMode: 'masonry',
	    itemSelector: '.post-grid-item',
	    packery: {
	  // masonry: {
	      gutter: '.post-grid-gutter'
	      }
	  });
	  
	});


</script>
<?php get_footer(); ?>
