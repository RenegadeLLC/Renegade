<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package Renegade
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>

<div id="secondary" class="widget-area" role="complementary">

	<?php dynamic_sidebar( 'articles-sidebar' ); ?>
</div><!-- #secondary -->
