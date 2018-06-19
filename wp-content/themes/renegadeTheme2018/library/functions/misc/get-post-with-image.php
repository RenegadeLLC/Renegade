<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<div class="clearfloat recent-excerpts">
	<?php $postimageurl = get_post_meta($post->ID, 'Image', true);  
		if ($postimageurl) {  
		?>  
		<img src="/wp-content/themes/NomeMag/scripts/timthumb.php?src=<?php echo get_post_meta($post->ID, "Image", true); ?>&h=250&w=250&zc=1" alt="">  		
	<?php } else { ?>  
		<img src="<?php bloginfo('template_url'); ?>/images/noimage.jpg" alt="No image available" />
	<?php } ?> 	
	<h2 class="posttitle"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a> </h2>
	<h4>Written by <?php the_author(); ?> on <?php the_time('n/d/y'); ?>, with  <?php comments_number('no', 'one', '%'); ?> comments</h4>
	<?php the_excerpt(); ?>
</div>
	
<?php endwhile; ?>

<?php else : ?>
<p>Sorry, no posts were found.</p>
<?php endif; ?>
