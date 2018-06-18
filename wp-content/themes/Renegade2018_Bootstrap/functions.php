<?php
/**
 * Understrap functions and definitions
 *
 * @package understrap
 */

/**
 * Initialize theme default settings
 */
require get_template_directory() . '/inc/theme-settings.php';

/**
 * Theme setup and custom theme supports.
 */
require get_template_directory() . '/inc/setup.php';

/**
 * Register widget area.
 */
require get_template_directory() . '/inc/widgets.php';

/**
 * Enqueue scripts and styles.
 */
require get_template_directory() . '/inc/enqueue.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/pagination.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Custom Comments file.
 */
require get_template_directory() . '/inc/custom-comments.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Load custom WordPress nav walker.
 */
require get_template_directory() . '/inc/bootstrap-wp-navwalker.php';

/**
 * Load WooCommerce functions.
 */
require get_template_directory() . '/inc/woocommerce.php';

/**
 * Load Editor functions.
 */
require get_template_directory() . '/inc/editor.php';

/********  DEFINE FILE PATHS ********/

define('LIBRARY', TEMPLATEPATH . '/library');
define('IMAGES', TEMPLATEPATH . '/library/images');
define('FUNCTIONS', TEMPLATEPATH . '/library/functions');

/*****ADD FILES THAT LOAD JAVASCRIPT AND CSS *****/
require_once (LIBRARY . '/javascript_loader.php');
require_once (LIBRARY. '/css_loader.php');
require_once (LIBRARY. '/functions_loader.php');
//require_once (LIBRARY. '/shortcode_loader.php');
//require_once (LIBRARY. '/functions/clean_link_name.php');
//require_once( FUNCTIONS . 'ajax_filter_posts.php' );
//require_once( FUNCTIONS . 'archive_getter.php' );
//require_once( FUNCTIONS . 'query_custom_posts.php' );
//require_once (FUNCTIONS . '/color_link.php');


// Save ACF custom field to date-time post
function change_date( $post_id ) {
    $post_type = get_post_type();
    global $acfDate;
    if($post_type == 'newsletters'):
        $acfDate = get_field('rn_date', $post_id);
    elseif($post_type == 'articles'):
        $acfDate = get_field('ra_date', $post_id);
    elseif($post_type == 'podcasts'):
        $acfDate = get_field('podcast_date', $post_id);
    elseif($post_type == 'posts'):
    $acfDate = get_the_date();
    endif;
    
    //Test if you receive the data field correctly:
    //echo $acfDate;
    //exit (-1);
    $my_post = array();
    $my_post['ID'] = $post_id;
    $my_post['post_date'] = $acfDate;
    wp_update_post( $my_post );
}
//add_action('acf/save_post', 'change_date', 20);
//add_action('pre_get_posts','change_date', 20);


/**
 * Javascript for Load More
 *
 */
/*
function be_load_more_js() {
    global $wp_query;
    $args = array(
        'nonce' => wp_create_nonce( 'be-load-more-nonce' ),
        'url'   => admin_url( 'admin-ajax.php' ),
        'query' => $wp_query->query,
    );
    
    wp_enqueue_script( 'be-load-more', get_stylesheet_directory_uri() . '/library/js/load-more.js', array( 'jquery' ), '1.0', true );
    wp_localize_script( 'be-load-more', 'beloadmore', $args );
    
}
add_action( 'wp_enqueue_scripts', 'be_load_more_js' );

*/

/**
 * AJAX Load More
 * @link http://www.billerickson.net/infinite-scroll-in-wordpress
 */

/*
function be_ajax_load_more() {
    $args = isset( $_POST['query'] ) ? array_map( 'esc_attr', $_POST['query'] ) : array();
    $args['post_type'] = isset( $args['post_type'] ) ? esc_attr( $args['post_type'] ) : 'newsletter';
    $args['paged'] = esc_attr( $_POST['page'] );
    $args['post_status'] = 'publish';
    ob_start();
    $loop = new WP_Query( $args );
    if( $loop->have_posts() ): while( $loop->have_posts() ): $loop->the_post();
         //be_post_summary();
    endwhile; endif; wp_reset_postdata();
    $data = ob_get_clean();
    wp_send_json_success( $data );
    wp_die();
}
add_action( 'wp_ajax_be_ajax_load_more', 'be_ajax_load_more' );
add_action( 'wp_ajax_nopriv_be_ajax_load_more', 'be_ajax_load_more' );
*/
 


// enqueue_scripts: make sure to include ajaxurl, so we know where to send the post request
function dt_add_main_js(){
    
    wp_register_script( 'main-js', get_template_directory_uri() . '/library/js/load-more-script.js', array( 'jquery' ), '1.0', false );
    wp_enqueue_script( 'main-js' );
    wp_localize_script( 'main-js', 'headJS', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ), 'templateurl' => get_template_directory_uri(), 'posts_per_page' => get_option('posts_per_page') ) );
    
}
add_action( 'wp_enqueue_scripts', 'dt_add_main_js', 90);


add_action( "wp_ajax_load_more", "load_more_func" ); // when logged in
add_action( "wp_ajax_nopriv_load_more", "load_more_func" );//when logged out
//function return new posts based on offset and posts per page value
function load_more_func() {
    //verifying nonce here
    if ( !wp_verify_nonce( $_REQUEST['nonce'], "load_posts" ) ) {
        exit("No naughty business please");
    }
    $offset = isset($_REQUEST['offset'])?intval($_REQUEST['offset']):0;
    $posts_per_page = isset($_REQUEST['posts_per_page'])?intval($_REQUEST['posts_per_page']):10;
    //optional, if post type is not defined use regular post type
    $post_type = isset($_REQUEST['post_type'])?$_REQUEST['post_type']:'post';
    
    
    ob_start(); // buffer output instead of echoing it
    $args = array(
        'post_type'=>$post_type,
        'offset' => $offset,
        'posts_per_page' => $posts_per_page,
        'orderby' => 'date',
        'order' => 'DESC'
    );
    $posts_query = new WP_Query( $args );
    
    
    if ($posts_query->have_posts()) {
        //if we have posts:
        $result['have_posts'] = true; //set result array item "have_posts" to true
        
        while ( $posts_query->have_posts() ) : $posts_query->the_post(); ?>
			<article id="post-<?php the_ID(); ?>" class="single-article" >
				<?php //here goes your post content:?>
				<h1><?php the_title(); ?></h1>
				<?php the_content(); ?>
			</article>
			<?php endwhile;
		$result['html'] = ob_get_clean(); // put alloutput data into "html" item
  } else {
	  //no posts found
	  $result['have_posts'] = false; // return that there is no posts found
  } 
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $result = json_encode($result); // encode result array into json feed
            echo $result; // by echo we return JSON feed on POST request sent via AJAX
        }
        else { 
            header("Location: ".$_SERVER["HTTP_REFERER"]);
        }
  die();
}

/***** ADD NEW MENUS TO THEME ********/

function register_my_menus() {
    register_nav_menus(
        array(
            'footer' => __( 'Footer' ),
            'mobile' => __( 'Mobile' ),
           
        )
        );
}
add_action( 'init', 'register_my_menus' );


/***** ADD ACF STYLING ********/

function load_custom_wp_admin_style() {
    wp_register_style( 'custom_wp_admin_css', get_template_directory_uri() . '/admin-style.css', false, '1.0.0' );
    wp_enqueue_style( 'custom_wp_admin_css' );
}
add_action( 'admin_enqueue_scripts', 'load_custom_wp_admin_style' );

if( function_exists('acf_add_options_page') ) {
    
    acf_add_options_page(array(
        'page_title' 	=> 'Theme General Settings',
        'menu_title'	=> 'Theme Settings',
        'menu_slug' 	=> 'theme-general-settings',
        'capability'	=> 'edit_posts',
        'redirect'		=> false
    ));
    
    acf_add_options_sub_page(array(
        'page_title' 	=> 'Theme Header Settings',
        'menu_title'	=> 'Header',
        'parent_slug'	=> 'theme-general-settings',
    ));
    
    acf_add_options_sub_page(array(
        'page_title' 	=> 'Theme Footer Settings',
        'menu_title'	=> 'Footer',
        'parent_slug'	=> 'theme-general-settings',
    ));
    
    acf_add_options_sub_page(array(
        'page_title' 	=> 'Social Media Links',
        'menu_title'	=> 'Social Media Links',
        'parent_slug'	=> 'theme-general-settings',
    ));
    
}
