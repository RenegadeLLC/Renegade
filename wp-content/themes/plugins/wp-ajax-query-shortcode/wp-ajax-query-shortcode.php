<?php
   /*
   Plugin Name: WP Ajax Query Shortcode
   Plugin URI: http://leafcolor.com/wp-quick-ajax/
   Description: A plugin to create awesome ajax query post for your WP site (with Filter)
   Version: 1.5
   Author: Leafcolor
   Author URI: http://leafcolor.com
   License: GPL2
   */
define( 'WAQ_PATH', plugin_dir_url( __FILE__ ) );

require_once ('core/plugin-options.php');

// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

$waq_id = 0;

/*
 * Setup shortcode
 * Get default settings
 * Call template render
 */
function wp_ajax_shortcode($atts,$content=""){
	$waq_options = waq_get_all_option();
	$atts = shortcode_atts( array(
		//query param
		'author' => NULL,
		'author_name' => '',
		'cat' => implode(",",$waq_options['cat']),
		'category_name' => '',
		'tag' => $waq_options['tag'],
		'tag_id' => NULL,
		'p' => NULL,
		'name' => '',
		'page_id' => '',
		'pagename' => '',
		'post_parent' => '',
		'post_type' => implode(",",$waq_options['post_type']),
		'post_status' => 'publish',
		'posts_per_page' => $waq_options['posts_per_page'],
		'posts_per_archive_page' => '',
		//'paged' => get_query_var('paged')?get_query_var('paged'):get_query_var('page')?get_query_var('page'):1,
		'offset' => 0,
		'order' => $waq_options['order'],
		'orderby' => $waq_options['orderby'],
		'ignore_sticky_posts' => true,
		'year' => NULL,
		'monthnum' => NULL,
		'm' => NULL,
		'w' =>  NULL,
		'day' => NULL,
		'meta_key' => '',
		'meta_value' => '',
		'meta_compare' => '',
		//plugin param
		'layout' => $waq_options['layout'],
		'col_width' => $waq_options['col_width'],
		'ajax_style' => $waq_options['ajax_style'],
		//button
		'button_label' => $waq_options['button_label'],
		'button_text_color' => $waq_options['button_text_color'],
		'button_bg_color' => $waq_options['button_bg_color'],
		'button_font' => $waq_options['button_font'],
		'button_size' => $waq_options['button_size'],
		'button_icon' => $waq_options['button_icon'],
		
		'loading_image' => $waq_options['loading_image'],
		
		'thumb_size' => $waq_options['thumb_size'],
		
		'post_title_color' => $waq_options['post_title_color'],
		'post_title_font' => $waq_options['post_title_font'],
		'post_title_size' => $waq_options['post_title_size'],
		
		'post_excerpt_color' => $waq_options['post_excerpt_color'],
		'post_excerpt_font' => $waq_options['post_excerpt_font'],
		'post_excerpt_size' => $waq_options['post_excerpt_size'],
		'post_excerpt_limit' => $waq_options['post_excerpt_limit'],
		
		'post_meta_color' => $waq_options['post_meta_color'],
		'post_meta_font' => $waq_options['post_meta_font'],
		'post_meta_size' => $waq_options['post_meta_size'],
		
		'thumb_hover_icon' => $waq_options['thumb_hover_icon'],
		'thumb_hover_color' => $waq_options['thumb_hover_color'],
		'thumb_hover_bg' => $waq_options['thumb_hover_bg'],
		'thumb_hover_popup' => $waq_options['thumb_hover_popup'],
		'popup_theme' => $waq_options['popup_theme'],

		'border_hover_color' => $waq_options['border_hover_color'],
		'border_hover_width' => $waq_options['border_hover_width'],
		//extra param
		'full_post' => '0',
		'global_query' => '0',
		'related_query' => '0',
	), $atts );
	if($atts['post_type']=='attachment'){
		$atts['post_status']='inherit';
	}
	if($atts['global_query']=='1'){
		global $wp_query;
		$atts_old = $atts;
		$atts = array_merge( $atts, $wp_query->query_vars );
		$atts['posts_per_page'] = $atts_old['posts_per_page'];
		$atts['paged'] = 1;
	}
	if($atts['related_query']=='1'){
		global $post;
		$related_arg = array(
			'category__in' => wp_get_post_categories($post->ID),
			'post__not_in' => array($post->ID) 
		);
		$atts = array_merge( $atts, $related_arg );
	}
	if(is_multisite()){
		$atts['multisite']=get_current_blog_id();
	}
	return wp_ajax_template($atts);
}
add_shortcode('wpajax', 'wp_ajax_shortcode');

function wp_ajax_filter($filter_atts){
	$filter_atts = shortcode_atts( array(
			'cat' => 1,
			'tag' => 1,
			'month' => 1,
			'author' => 1,
			'format' => 1
		),
		$filter_atts
	);
	ob_start();
	$cats = get_terms( 'category', 'hide_empty=0' );
	$tags = get_terms( 'post_tag', 'hide_empty=0' );
	?>
    <div class="waq-filter">
    	<form id="waq-filter-form">
        	<input type="hidden" value="<?php echo home_url("/");?>" name="home_url" />
            <?php if($filter_atts['cat']){ ?>
    		<div class="waq-form-item">
        		<select class="waq-form-select" name="cat">
                	<option value="-1">Browse by Category</option>
                    <?php
					if($cats){
						foreach ($cats as $acat){
							echo '<option value="'.$acat->term_id.'">'.$acat->name.'</option>';
						}
					}
					?>
                </select>
        	</div>
            <?php }?>
            <?php if($filter_atts['tag']){ ?>
            <div class="waq-form-item">
        		<select class="waq-form-select" name="tag">
                	<option value="-1">Browse by Tag</option>
                    <?php
					if($tags){
						foreach ($tags as $atag){
							echo '<option value="'.$atag->term_id.'">'.$atag->name.'</option>';
						}
					}
					?>
                </select>
        	</div>
            <?php }?>
            <?php if($filter_atts['month']){ ?>
            <div class="waq-form-item">
        		<select class="waq-form-select" name="month">
                	<option value="-1">Browse by Month</option>
                    <?php 
					$args = array(
						'type'            => 'monthly',
						'format'          => 'option',
					);
					wp_get_archives( $args ); ?>
                </select>
        	</div>
            <?php }?>
            <?php if($filter_atts['author']){ ?>
            <div class="waq-form-item">
                <?php wp_dropdown_users(array('name' => 'author','class'=>"waq-form-select" , 'show_option_none' => 'Browse by Author')); ?>
        	</div>
            <?php }?>
            <?php if($filter_atts['format']){ ?>
            <div class="waq-form-item">
        		<select class="waq-form-select" name="format">
                	<option value="-1">Browse by Type</option>
                    <?php
					if ( current_theme_supports( 'post-formats' ) ) {
						$post_formats = get_theme_support( 'post-formats' );
						if ( is_array( $post_formats[0] ) ) {
							foreach($post_formats[0] as $post_format){
								echo '<option value="'.$post_format.'">'.$post_format.'</option>';
							}
						}
					}
					?>
                </select>
        	</div>
            <?php }?>
        </form>
    </div><!--/waq-filter-->
    <?php
	$html_filter = ob_get_clean();
	return $html_filter;
}
add_shortcode('wpajaxfilter', 'wp_ajax_filter');
add_filter('widget_text', 'do_shortcode');
/*
 * Render template
 *
 * Return HTML
 */
function wp_ajax_template($atts){
	global $waq_id;
	$waq_id++;
	$atts['waq_id']=$waq_id;
	ob_start(); ?>

    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=<?php echo str_replace(" ", "+", $atts['button_font']) ?>|<?php echo str_replace(" ", "+", $atts['post_title_font']) ?>|<?php echo str_replace(" ", "+", $atts['post_excerpt_font']) ?>|<?php echo str_replace(" ", "+", $atts['post_meta_font']) ?>" >

    <style>
		<?php if($atts['layout']=='modern'||$atts['layout']=='combo'){ ?>
		#waq<?php echo $waq_id; ?> .ajax-item{width:<?php echo $atts['col_width'] ?>px}
        <?php } ?>
        #waq<?php echo $waq_id; ?> .ajax-item-head a{
			color:#<?php echo $atts['post_title_color'] ?>;
			<?php if($atts['post_title_font']){ ?>font-family:"<?php echo $atts['post_title_font'] ?>", sans-serif;<?php } ?>
			font-size:<?php echo $atts['post_title_size'] ?>px;
		}
		#waq<?php echo $waq_id; ?> .ajax-item-meta {
			color:#<?php echo $atts['post_meta_color'] ?>;
			<?php if($atts['post_meta_font']){ ?>font-family:"<?php echo $atts['post_meta_font'] ?>", sans-serif;<?php } ?>
			font-size:<?php echo $atts['post_meta_size'] ?>px;
		}
		#waq<?php echo $waq_id; ?> .ajax-item-content, #waq<?php echo $waq_id; ?> .ajax-item-content p {
			color:#<?php echo $atts['post_excerpt_color'] ?>;
			<?php if($atts['post_excerpt_font']){ ?>font-family:"<?php echo $atts['post_excerpt_font'] ?>", sans-serif;<?php } ?>
			font-size:<?php echo $atts['post_excerpt_size'] ?>px;
		}
		#waq<?php echo $waq_id; ?> .wp-ajax-query-button a, #waq<?php echo $waq_id; ?> .wp-ajax-query-button a:visited{
			background:#<?php echo $atts['button_bg_color'] ?>;
			color:#<?php echo $atts['button_text_color'] ?>;
			<?php if($atts['button_font']){ ?>font-family:"<?php echo $atts['button_font'] ?>", sans-serif;<?php } ?>
			font-size:<?php echo $atts['button_size'] ?>px;
			padding: 1px <?php echo $atts['button_size'] ?>px;
		}
		#waq<?php echo $waq_id; ?> .link-overlay:before {
			color: #<?php echo $atts['thumb_hover_color'] ?>;
			background: #<?php echo $atts['thumb_hover_bg'] ?>;
		}
		<?php if($atts['layout']=='classic'){ ?>
		#waq<?php echo $waq_id; ?> .ajax-item:hover{
			box-shadow:inset -<?php echo $atts['border_hover_width'] ?>px 0px 0px #<?php echo $atts['border_hover_color'] ?>;
		}
		<?php }else{ ?>
		#waq<?php echo $waq_id; ?>.modern .ajax-item:hover .ajax-item-content-wrap{
			box-shadow:inset 0px -<?php echo $atts['border_hover_width'] ?>px 0px #<?php echo $atts['border_hover_color'] ?>, 0 0px 1px rgba(0,0,0,0.075), 0 1px 2px rgba(0,0,0,0.075);
		}
		<?php } ?>
		<?php if($atts['layout']=='combo'){ ?>
		.wp-ajax-query-shortcode.comboed .ajax-item:hover{
			box-shadow:inset -1px 0px 0px #<?php echo $atts['border_hover_color'] ?>;
		}
		<?php } ?>
    </style>

    <div id="waq<?php echo $waq_id; ?>" class="wp-ajax-query-shortcode <?php echo $atts['layout']=='combo'?$atts['layout'].' modern comboed':$atts['layout'] ?>">
    	<div class="wp-ajax-query-wrap">
        	<?php if($atts['layout']=='combo'){ ?>
            	<center><button class="ajax-layout-toggle">Switch layout  <i class="icon-random"></i></button></center>
            <?php } ?>
        	<div class="wp-ajax-query-inner">
            	<div class="wp-ajax-query-content">
    				<?php echo wp_ajax_query($atts); ?>
            	</div>
                <div class="clear"></div>
                <div class="wp-ajax-loading-images">
                	<?php if($atts['loading_image']=='1'){ ?>
                    	<img src="<?php echo WAQ_PATH.'images/gray.gif'; ?>" width="88px" height="8px" />
                    <?php }elseif($atts['loading_image']=='2'){ ?>
                    	<i class="icon-spinner icon-spin"></i>
                    <?php }elseif($atts['loading_image']=='3'){ ?>
                    	<i class="icon-refresh icon-spin"></i>
                    <?php }elseif($atts['loading_image']=='4'){ ?>
                    	<i class="icon-cog icon-spin"></i>
                    <?php }else{ ?>
                    	<img src="<?php echo WAQ_PATH.'images/gray.gif'; ?>" width="88px" height="8px" />
                    <?php } ?>
                </div>
                <div class="wp-ajax-query-button <?php echo $atts['ajax_style']=='scroll'?'hide-button':'' ?>"><a href="#"><?php echo $atts['button_label']; echo $atts['button_icon']?' &nbsp;<i class="'.$atts['button_icon'].'"></i>':'' ?></a></div>
            </div>
        </div>
    </div>
    <div class="clear"></div>
    <script>
	jQuery(function(){
		ajax_running=0;
		ajax_nomore=0;
		<?php if($atts['ajax_style']=='scroll'){ ?>
		jQuery(window).scroll(function(){
			if(jQuery('#waq<?php echo $atts['waq_id']; ?> .wp-ajax-query-button a').length && waq_isScrolledIntoView(jQuery('#waq<?php echo $waq_id; ?> .wp-ajax-query-button a')) && ajax_running==0 && ajax_nomore==0){
				if(window.ajaxParam){
					ajaxParam = jQuery.extend({}, ajaxParam, window.ajaxParam);
				}else{
					ajaxParam = <?php echo json_encode($atts); ?>;
				}
				ajaxParam['home_url'] = "<?php echo home_url("/");?>";
				ajaxParam['waq_id'] = "<?php echo $atts['waq_id']; ?>";
				wp_ajax_query_shortcode<?php echo $atts['layout']=='combo'?'modern':$atts['layout'] ?>(ajaxParam);
			}
		});
		<?php }else{ ?>
		jQuery('#waq<?php echo $atts['waq_id']; ?> .wp-ajax-query-button a').on('click',function(){
			if(window.ajaxParam){
				ajaxParam = jQuery.extend({}, ajaxParam, window.ajaxParam);
			}else{
				ajaxParam = <?php echo json_encode($atts); ?>;
			}
			ajaxParam['home_url'] = "<?php echo home_url("/");?>";
			ajaxParam['waq_id'] = "<?php echo $atts['waq_id']; ?>";
			if(ajax_nomore==0){
				wp_ajax_query_shortcode<?php echo $atts['layout']=='combo'?'modern':$atts['layout'] ?>(ajaxParam);
			}
			return false;
		});
		<?php } ?>
	});
	<?php if($atts['thumb_hover_popup']){?>
	jQuery("#waq<?php echo $waq_id; ?> a[rel^='prettyPhoto']").prettyPhoto({
		<?php echo $atts['popup_theme']?'theme:"'.$atts['popup_theme'].'"':'' ?>
	});
	<?php }?>
	jQuery(document).ready(function(){
		wp_ajax_query_resize();
		$columnwidth = jQuery('#waq<?php echo $waq_id; ?> .ajax-item').width();
		$container = jQuery('#waq<?php echo $waq_id; ?>.modern .wp-ajax-query-content');
		$container.imagesLoaded( function(){
			wp_ajax_query_resize();
		});
		$container.masonry({
			// options
			itemSelector : '.ajax-item',
			columnWidth : $columnwidth,
			isFitWidth: true,
			gutter: 0
		});
	});
	jQuery(window).load(function(e) {
		$container.imagesLoaded( function(){
			wp_ajax_query_resize();
			$container.masonry( 'reload' );
		});
    });
	</script>
	<?php
	$html = ob_get_clean();
	return $html;
}

/*
 * Do the query with parameters
 *
 */
function wp_ajax_query($atts=''){
	global $waq_id;
	$is_ajax = 0;
	if($atts==''){
		$is_ajax=1;
		$atts=$_GET;
		if($atts['global_query']){
			unset($atts['no_found_rows']);
			unset($atts['suppress_filters']);
			unset($atts['cache_results']);
			unset($atts['update_post_term_cache']);
			unset($atts['update_post_meta_cache']);
			unset($atts['nopaging']);
		}
	}
	if($atts['post_excerpt_limit']>0){
		add_filter( 'excerpt_length', 'waq_custom_excerpt_length', 999 );
	}
	if($atts['multisite']){
		switch_to_blog($atts['multisite']);
	}
	if(isset($atts['format_type'])&&$atts['format_type']!='-1'){
		$atts['tax_query'] = array(
			array(                
				'taxonomy' => 'post_format',
				'field' => 'slug',
				'terms' => array( 
					'post-format-'.$atts['format_type']
				),
				'operator' => 'IN'
			)
		);
	}
	foreach($atts as $key => $val){
		if ( $atts[$key] == null || $atts[$key] == 'null' || $atts[$key] == '' ) unset($atts[$key]);
	}
	$my_query = null;
	$my_query = new WP_Query($atts);
	$html = '';
	if( $my_query->have_posts() ){
		ob_start();
		if($atts['layout']=='classic') echo '<div>'; //fix firefox append
		while ($my_query->have_posts()) {
			$my_query->the_post();
			if($atts['post_type']=='attachment'){
				$thumb = wp_get_attachment_image_src( get_the_ID(), $atts['thumb_size'] );
				$full = wp_get_attachment_image_src( get_the_ID(), 'large' );
			}else{
				$thumb = wp_get_attachment_image_src( get_post_thumbnail_id(), $atts['thumb_size'] );
				$full = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' );
			}
			?>
            <div class="ajax-item">
            	<div class="ajax-item-pad">
				<?php if ( has_post_thumbnail() || $atts['post_type']=='attachment') {
                    if($atts['thumb_hover_popup']){?>
                    <a rel="prettyPhoto[waq<?php echo $atts['waq_id']; ?>]" href="<?php echo $full['0']; ?>" title="<?php the_title() ?>">
                    <?php }else{ ?>
                    <a href="<?php echo get_permalink() ?>" title="<?php the_title() ?>">
                    <?php } ?>
                    <div class="ajax-item-thumb">
                    	<img src="<?php echo $thumb['0']; ?>" title="<?php the_title(); ?>" alt="<?php the_title(); ?>" width="<?php echo $atts['col_width']?>" />
                        <?php if($atts['thumb_hover_icon']){ ?>
                        <div class="link-overlay <?php echo $atts['thumb_hover_icon']?>"></div>
                        <?php } ?>
                    </div>
                    </a>
                    <?php } ?>
                    <div class="ajax-item-content-wrap <?php echo has_post_thumbnail()?'':'no-thumb' ?>">
                      <?php if($atts['post_title_size']){ ?>
                      <h2 class="ajax-item-head">
                        <a href="<?php echo get_permalink() ?>" title="<?php the_title() ?>">
                        <?php the_title(); ?>
                        </a>
                      </h2>
                      <br />
                      <?php }?>
                      <?php if($atts['post_meta_size']){ ?>
                      <div class="ajax-item-meta">
						<span><i class="icon-time"></i> <?php the_time('F j, Y'); ?> &nbsp;&nbsp;<i class="icon-user"></i> <?php the_author_link(); ?></span>
                      </div>
                      <br />
                      <?php }?>
                      <?php if($atts['post_excerpt_size']){ ?>
                      <div class="ajax-item-content">
                        <?php
                        if($atts['full_post']==1){
                            the_content();
                        }elseif($atts['fullpost']==-1){
                            echo '';
                        }else{
                            the_excerpt();
                        } ?>
                      </div>
                      <?php }?>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
			<?php
		}
		wp_reset_postdata();
		if($atts['layout']=='classic') echo '</div>'; //fix firefox append
		$html = ob_get_clean();
		if($is_ajax==1){
			echo $html; 
			exit();
		}
		remove_filter( 'excerpt_length', 'waq_custom_excerpt_length' );
		return $html;
	}else{
		if($is_ajax==1){
			echo '-11';
			exit();
		}
		remove_filter( 'excerpt_length', 'waq_custom_excerpt_length' );
		return 'No post';
	}
	if($atts['multisite']){
		restore_current_blog();
	}
}
add_action("wp_ajax_wp_ajax_query", "wp_ajax_query");
add_action("wp_ajax_nopriv_wp_ajax_query", "wp_ajax_query");

function wp_ajax_filter_query(){
	$atts=$_GET;
	$waq_options = waq_get_all_option();
	$atts = shortcode_atts( array(
		//query param
		'author' => NULL,
		'author_name' => '',
		'cat' => implode(",",$waq_options['cat']),
		'category_name' => '',
		'tag' => $waq_options['tag'],
		'tag_id' => NULL,
		'p' => NULL,
		'name' => '',
		'page_id' => '',
		'pagename' => '',
		'post_parent' => '',
		'post_type' => implode(",",$waq_options['post_type']),
		'post_status' => 'publish',
		'posts_per_page' => $waq_options['posts_per_page'],
		'posts_per_archive_page' => '',
		//'paged' => get_query_var('paged')?get_query_var('paged'):get_query_var('page')?get_query_var('page'):1,
		'offset' => 0,
		'order' => $waq_options['order'],
		'orderby' => $waq_options['orderby'],
		'ignore_sticky_posts' => true,
		'year' => NULL,
		'monthnum' => NULL,
		'm' => NULL,
		'w' =>  NULL,
		'day' => NULL,
		'meta_key' => '',
		'meta_value' => '',
		'meta_compare' => '',
		//plugin param
		'layout' => $waq_options['layout'],
		'col_width' => $waq_options['col_width'],
		'ajax_style' => $waq_options['ajax_style'],
		//button
		'button_label' => $waq_options['button_label'],
		'button_text_color' => $waq_options['button_text_color'],
		'button_bg_color' => $waq_options['button_bg_color'],
		'button_font' => $waq_options['button_font'],
		'button_size' => $waq_options['button_size'],
		'button_icon' => $waq_options['button_icon'],
		
		'loading_image' => $waq_options['loading_image'],
		
		'thumb_size' => $waq_options['thumb_size'],
		
		'post_title_color' => $waq_options['post_title_color'],
		'post_title_font' => $waq_options['post_title_font'],
		'post_title_size' => $waq_options['post_title_size'],
		
		'post_excerpt_color' => $waq_options['post_excerpt_color'],
		'post_excerpt_font' => $waq_options['post_excerpt_font'],
		'post_excerpt_size' => $waq_options['post_excerpt_size'],
		'post_excerpt_limit' => $waq_options['post_excerpt_limit'],
		
		'post_meta_color' => $waq_options['post_meta_color'],
		'post_meta_font' => $waq_options['post_meta_font'],
		'post_meta_size' => $waq_options['post_meta_size'],
		
		'thumb_hover_icon' => $waq_options['thumb_hover_icon'],
		'thumb_hover_color' => $waq_options['thumb_hover_color'],
		'thumb_hover_bg' => $waq_options['thumb_hover_bg'],
		'thumb_hover_popup' => $waq_options['thumb_hover_popup'],
		'popup_theme' => $waq_options['popup_theme'],

		'border_hover_color' => $waq_options['border_hover_color'],
		'border_hover_width' => $waq_options['border_hover_width'],
		//extra param
		'full_post' => '0',
		'global_query' => '0',
		'related_query' => '0',
	), $atts );
	if($atts['post_type']=='attachment'){
		$atts['post_status']='inherit';
	}
	if($atts['global_query']=='1'){
		global $wp_query;
		$atts_old = $atts;
		$atts = array_merge( $atts, $wp_query->query_vars );
		$atts['posts_per_page'] = $atts_old['posts_per_page'];
		$atts['paged'] = 1;
	}
	if($atts['related_query']=='1'){
		global $post;
		$related_arg = array(
			'category__in' => wp_get_post_categories($post->ID),
			'post__not_in' => array($post->ID) 
		);
		$atts = array_merge( $atts, $related_arg );
	}
	if(is_multisite()){
		$atts['multisite']=get_current_blog_id();
	}
	if(isset($_GET['format_type'])&&$_GET['format_type']!=-1){
		$atts['format_type'] = $_GET['format_type'];
		$atts['tax_query'] = array(
			array(                
				'taxonomy' => 'post_format',
				'field' => 'slug',
				'terms' => array( 
					'post-format-'.$atts['format_type']
				),
				'operator' => 'IN'
			)
		);
	}
	echo wp_ajax_query($atts);
	exit();
}
add_action("wp_ajax_wp_ajax_filter_query", "wp_ajax_filter_query");
add_action("wp_ajax_nopriv_wp_ajax_filter_query", "wp_ajax_filter_query");

//load js and css
add_action( 'wp_enqueue_scripts', 'wp_ajax_shortcode_scripts' );
function wp_ajax_shortcode_scripts(){
	wp_enqueue_script('jquery');
	wp_enqueue_script('masonry', plugins_url( 'js/masonry.min.js', __FILE__ ), array('jquery'));
	wp_enqueue_script('prettyPhoto',  plugins_url( 'js/prettyPhoto/jquery.prettyPhoto.js', __FILE__ ), array('jquery'));
	wp_enqueue_script('wpajax', plugins_url( 'js/main.js', __FILE__ ), array('jquery'));
	wp_enqueue_style('font-awesome', plugins_url( 'font-awesome/css/font-awesome.min.css', __FILE__ ));
	wp_enqueue_style('prettyPhoto', plugins_url( 'js/prettyPhoto/css/prettyPhoto.css', __FILE__ ));
	wp_enqueue_style('wpajax', plugins_url( 'style.css', __FILE__ ));
}

/*
 * Get all plugin options
 */
function waq_get_all_option(){
	$waq_options = get_option('waq_options_group');
	$waq_options['layout'] = isset($waq_options['layout'])?$waq_options['layout']:'modern';
	$waq_options['col_width'] = isset($waq_options['col_width'])?$waq_options['col_width']:'225';
	$waq_options['ajax_style'] = isset($waq_options['ajax_style'])?$waq_options['ajax_style']:'button';
	//button
	$waq_options['button_label'] = isset($waq_options['button_label'])?$waq_options['button_label']:'View more';
	$waq_options['button_text_color'] = isset($waq_options['button_text_color'])?$waq_options['button_text_color']:'FFFFFF';
	$waq_options['button_bg_color'] = isset($waq_options['button_bg_color'])?$waq_options['button_bg_color']:'35aa47';
	$waq_options['button_font'] = isset($waq_options['button_font'])?$waq_options['button_font']:'0';
	$waq_options['button_size'] = isset($waq_options['button_size'])?$waq_options['button_size']:'14';
	$waq_options['button_icon'] = isset($waq_options['button_icon'])?$waq_options['button_icon']:'icon-search';
	$waq_options['loading_image'] = isset($waq_options['loading_image'])?$waq_options['loading_image']:'1';	
	$waq_options['thumb_size'] = isset($waq_options['thumb_size'])?$waq_options['thumb_size']:'thumbnail';
	$waq_options['post_title_color'] = isset($waq_options['post_title_color'])?$waq_options['post_title_color']:'35aa47';
	$waq_options['post_title_font'] = isset($waq_options['post_title_font'])?$waq_options['post_title_font']:'0';
	$waq_options['post_title_size'] = isset($waq_options['post_title_size'])?$waq_options['post_title_size']:'18';
	$waq_options['post_excerpt_color'] = isset($waq_options['post_excerpt_color'])?$waq_options['post_excerpt_color']:'444444';
	$waq_options['post_excerpt_font'] = isset($waq_options['post_excerpt_font'])?$waq_options['post_excerpt_font']:'0';
	$waq_options['post_excerpt_size'] = isset($waq_options['post_excerpt_size'])?$waq_options['post_excerpt_size']:'14';
	$waq_options['post_excerpt_limit'] = isset($waq_options['post_excerpt_limit'])?$waq_options['post_excerpt_limit']:'0';
	$waq_options['post_meta_color'] = isset($waq_options['post_meta_color'])?$waq_options['post_meta_color']:'999999';
	$waq_options['post_meta_font'] = isset($waq_options['post_meta_font'])?$waq_options['post_meta_font']:'0';
	$waq_options['post_meta_size'] = isset($waq_options['post_meta_size'])?$waq_options['post_meta_size']:'11';
	
	$waq_options['thumb_hover_icon'] = isset($waq_options['thumb_hover_icon'])?$waq_options['thumb_hover_icon']:'icon-search';
	$waq_options['thumb_hover_color'] = isset($waq_options['thumb_hover_color'])?$waq_options['thumb_hover_color']:'35aa47';
	$waq_options['thumb_hover_bg'] = isset($waq_options['thumb_hover_bg'])?$waq_options['thumb_hover_bg']:'ffffff';
	$waq_options['thumb_hover_popup'] = isset($waq_options['thumb_hover_popup'])?$waq_options['thumb_hover_popup']:'1';
	$waq_options['popup_theme'] = isset($waq_options['popup_theme'])?$waq_options['popup_theme']:'0';
	$waq_options['border_hover_color'] = isset($waq_options['border_hover_color'])?$waq_options['border_hover_color']:'35AA47';
	$waq_options['border_hover_width'] = isset($waq_options['border_hover_width'])?$waq_options['border_hover_width']:'1';
	$waq_options['cat'] = isset($waq_options['cat'])?$waq_options['cat']:array();
	$waq_options['tag'] = isset($waq_options['tag'])?$waq_options['tag']:'';
	$waq_options['post_type'] = isset($waq_options['post_type'])?$waq_options['post_type']:array();
	$waq_options['orderby'] = isset($waq_options['orderby'])?$waq_options['orderby']:'date';
	$waq_options['order'] = isset($waq_options['order'])?$waq_options['order']:'DESC';
	$waq_options['posts_per_page'] = isset($waq_options['posts_per_page'])&&$waq_options['posts_per_page']?$waq_options['posts_per_page']:'10';
	$waq_options['waq_rtl'] = isset($waq_options['waq_rtl'])?$waq_options['waq_rtl']:'0';
	$waq_options['waq_fontawesome'] = isset($waq_options['waq_fontawesome'])?$waq_options['waq_fontawesome']:'0';
	return $waq_options;
}
function waq_custom_excerpt_length( $length ) {
	$waq_options = waq_get_all_option();
	return $waq_options['post_excerpt_limit']?$waq_options['post_excerpt_limit']:$length;
}