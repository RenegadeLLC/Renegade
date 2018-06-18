<?php
/**
 * Class for making post types sortable.
 * Adds menu item for sorting posts.
 * They are not paged, so better not to add them to a post type
 * that will contain hundreds of items. More like something little used.
 *
 * Paremeters:
 * $location    - define path to js and css in __construct
 * $posttype	- the post type you want to be sortable
 * $title	- The title of the post type
 * $ppp		- the number of recent items to return - defaults to all (-1).
 *
 *		Define page template through:
 *			$sort = new dhfSortable($posttype, $title, 10)
 *
 * This class was heavily influenced by http://soulsizzle.com/jquery/create-an-ajax-sorter-for-wordpress-custom-post-types/
 */


if ( !class_exists( 'dhfSortable' ) ) :

class dhfSortable {

	var $location = ''; // path to css/js
	var $posttype = '';
	var $title = '';
	var $ppp = ''; // postsperpage

	function __construct($posttype, $title, $ppp = -1) {

		$this->location = get_stylesheet_directory_uri() . '/_inc/functions/'; // path to css/js
		$this->posttype = $posttype;
		$this->title = $title;
		$this->ppp = $ppp;

		add_filter('posts_orderby', array( $this, 'dhf_order_posts' ));
		add_action('admin_menu' , array( $this, 'dhf_enable_sort' )); 
		add_action('admin_print_scripts', array( $this, 'dhf_sort_scripts' ));
		add_action('wp_ajax_dhf_sort', array( $this, 'dhf_save_sort_order' ));
	}

	/**
	 * Alter the query on front and backend to order posts as desired.
	 */
	function dhf_order_posts($orderby) {
	    global $wpdb;
	
	    if ( is_post_type_archive( array($this->posttype)) ) {
			$orderby = "{$wpdb->posts}.menu_order, {$wpdb->posts}.post_date DESC";
		}
	    return($orderby);
	}

	/**
	 * Add Sort menu
	 */
	function dhf_enable_sort() {
	
		add_submenu_page('edit.php?post_type=' . $this->posttype, 'Sort Posts', 'Sort Order', 'edit_posts', 'sort_' . $this->posttype, array( $this, 'dhf_sort'));
	}

	/**
	 * Display Sort admin page
	 */
	function dhf_sort() {
	
		$sortable = new WP_Query('post_type=' . $this->posttype . '&posts_per_page=' . $this->ppp . '&orderby=menu_order&order=ASC');
	?>
		<div class="wrap">
	
			<div id="icon-edit" class="icon32"></div>
			<h2>Sort <?php echo $this->title; ?> <img src="<?php bloginfo('url'); ?>/wp-admin/images/loading.gif" id="loading-animation" /></h2>
	
			<ul id="sortable-list">
			<?php while ( $sortable->have_posts() ) : $sortable->the_post(); ?>
	
				<li id="<?php the_id(); ?>"><?php the_title(); ?></li>
	
			<?php endwhile; ?>

			<?php if ( $this->ppp != -1 ) echo '<p>Latest ' . $this->ppp . ' shown</p>'; ?>
	
		</div><!-- #wrap -->
	
	<?php
	}

	/**
	 * Add JS and CSS to admin
	 */
	function dhf_sort_scripts() {
		global $pagenow;
	
		$pages = array('edit.php');
		if (in_array($pagenow, $pages)) {
			wp_enqueue_script('jquery-ui-sortable');
			wp_enqueue_script('dhf_sort_js', $this->location . '/js/dhf_sort.js');
			wp_enqueue_style('dhf_sort_css', $this->location . '/css/dhf_sort.css');
		}
	}

	/**
	 * Save the sort order to database
	 */
	function dhf_save_sort_order() {
		global $wpdb;
	
		$order = explode(',', $_POST['order']);
		$counter = 0;
	
		foreach ($order as $post_id) {
			$wpdb->update($wpdb->posts, array( 'menu_order' => $counter ), array( 'ID' => $post_id) );
			$counter++;
		}
		return true;
	}

}

endif;
?>