<?php
/**
 * Template Name: Podcasts
 *
 * Template for displaying a page without sidebar even if a sidebar widget is published.
 *
 * @package understrap
 */

get_header();
$container = get_theme_mod( 'understrap_container_type' );

$paged = get_query_var('paged');

$rpd_args = array( 'post_type' => 'podcasts', 'posts_per_page' => 4, 'post_status' => 'publish', 'order' => 'DESC', 'orderby' => 'date', 'paged' => $paged  );

$wp_query = new WP_Query( $rpd_args );

?>

<div class="wrapper" id="full-width-page-wrapper">

	<div class="<?php echo esc_attr( $container ); ?>" id="content">

		<div class="row">

			<div class="col-md-12 content-area" id="primary">

				<main class="site-main" id="main" role="main">
				<div class=" post-listing">
<div class="grid row"  id="post-grid"><div class="grid-gutter"></div>
					<?php while ($wp_query->have_posts() ) : $wp_query->the_post(); ?>

						<?php get_template_part( 'loop-templates/content', 'podcast' ); ?>

						<?php
						// If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) :

							//comments_template();

						endif;
						?>

					<?php endwhile; // end of the loop. ?>
</div><!-- .grid -->
<div class="pagination">
        <?php //understrap_pagination(); ?>
        
             <?php previous_posts_link( '« Newer posts' ); ?>
        <?php next_posts_link( 'Older posts »', $wp_query->max_num_pages ); ?>
        
    </div>
</div><!-- .post-listing -->
				</main><!-- #main -->

			</div><!-- #primary -->

		</div><!-- .row end -->

	</div><!-- Container end -->

</div><!-- Wrapper end -->


	<script type="text/javascript">
	
	var $container = $('#post-grid');

	$(window).on('load', function () {
	    // Fire Isotope only when images are loaded
	    $container.imagesLoaded(function () {
	        $container.isotope({
	            itemSelector: '.grid-item', 
	       	 	percentPosition: true,
	       		isOriginTop: true,
	   	  		layoutMode: 'packery',
	            	packery: {
	          	  // masonry: {
	      	      gutter: '.grid-gutter'
	      	      }
	           
	        });
	    });

	

	    // Infinite Scroll
	    $('#post-grid').infinitescroll({
	            navSelector: 'div.pagination',
	            nextSelector: 'div.pagination a:first',
	            itemSelector: '.grid-item',
	            bufferPx: 200,
	            loading: {
	                finishedMsg: 'We\'re done here.',
	                //img: +templateUrl+'ajax-loader.gif'
	            },
	        },

	        // Infinite Scroll Callback
	        function (newElements) {
	            var $newElems = jQuery(newElements).hide();
	            $newElems.imagesLoaded(function () {
	                $newElems.fadeIn();
	                $container.isotope('appended', $newElems);
	            });
	        });
	});
	$( function() {
	  
	  $('.grid4').isotope({
		 percentPosition: true,
	  layoutMode: 'packery',
	  //   layoutMode: 'masonry',
	    itemSelector: '.grid-item',
	    isOriginTop: true,
	    packery: {
	  // masonry: {
	      gutter: '.grid-gutter4'
	      }
	  });
	  
	});


	</script>
<?php get_footer(); ?>
