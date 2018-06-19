<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<div class="clearfloat recent-excerpts">


		<?php
		$Image = get_post_custom_values("Image");
		if ( is_array($Image) ) { ?>
		<img src="<?php bloginfo('template_url'); ?>/scripts/timthumb.php?src=<?php echo get_post_meta($post->ID, "Image", true); ?>&h=250&w=250&zc=1" alt="<?php the_title(); ?>">  		
		<?php }	else { ?>
		<img class="entry-preview" src="<?php bloginfo('template_url'); ?>/images/noimage.jpg" alt="">
		<?php }	?>
	<h2 class="posttitle"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a> </h2>
	<div class="meta">Published on <?php the_time('n/d/y'); ?> by <?php the_author(); ?>, with  <?php comments_number('no', 'one', '%'); ?> comments</div>
	<?php the_excerpt(); ?>
</div>
	
<?php endwhile; ?>

<?php else : ?>
<p>Sorry, no posts were found.</p>
<?php endif; ?>
