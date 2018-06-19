<?php

/*

 * add option page

 */

add_action('admin_menu', 'waq_plugin_settings');
function waq_plugin_settings(){
    add_menu_page('Quick Ajax', 'Quick Ajax', 'administrator', 'waq_settings', 'waq_display_settings');
}
function register_waq_setting() {
	register_setting( 'waq_options_group', 'waq_options_group', 'waq_options_validate' );
	//Appearance settings
	add_settings_section('waq_settings_appe','','waq_settings_appe_html','waq_settings');
	add_settings_field('layout',__('Choose Layout','waq'),'waq_layout_html','waq_settings','waq_settings_appe');
	add_settings_field('col_width',__('Column Width','waq'),'waq_col_width_html','waq_settings','waq_settings_appe');
	//add_settings_field('waq_main_color',__('Main Color','waq'),'waq_main_color_html','waq_settings','waq_settings_appe');
	//Ajax settings
	add_settings_section('waq_settings_ajax','','waq_settings_ajax_html','waq_settings');
	add_settings_field('waq_ajax_style',__('Choose Ajax Style','waq'),'waq_ajax_style_html','waq_settings','waq_settings_ajax');
	add_settings_field('waq_button',__('Load More Button','waq'),'waq_button_html','waq_settings','waq_settings_ajax');
	add_settings_field('waq_button_icon',__('Load More Icon','waq'),'waq_button_icon_html','waq_settings','waq_settings_ajax');
	add_settings_field('waq_loading_image',__('Loading Image','waq'),'waq_loading_image_html','waq_settings','waq_settings_ajax');
	//post settings
	add_settings_section('waq_settings_post','','waq_settings_post_html','waq_settings');
	add_settings_field('waq_thumb_size',__('Thumbnail Size','waq'),'waq_thumb_size_html','waq_settings','waq_settings_post');
	add_settings_field('waq_post_title',__('Post Title','waq'),'waq_post_title_html','waq_settings','waq_settings_post');
	add_settings_field('waq_post_excerpt',__('Post Excerpt','waq'),'waq_post_excerpt_html','waq_settings','waq_settings_post');
	add_settings_field('waq_post_meta',__('Post Meta','waq'),'waq_post_meta_html','waq_settings','waq_settings_post');
	//add_settings_field('waq_post_background',__('Post background','waq'),'waq_post_background_html','waq_settings','waq_settings_post');
	add_settings_field('waq_thumb_hover',__('Thumbnail Hover Icon','waq'),'waq_thumb_hover_html','waq_settings','waq_settings_post');
	add_settings_field('waq_popup_theme',__('Popup Theme','waq'),'waq_popup_theme_html','waq_settings','waq_settings_post');
	add_settings_field('waq_border_hover',__('Hover Border','waq'),'waq_border_hover_html','waq_settings','waq_settings_post');
	//query settings
	add_settings_section('waq_settings_query','','waq_settings_query_html','waq_settings');
	add_settings_field('waq_cat',__('Choose category','waq'),'waq_cat_html','waq_settings','waq_settings_query');
	add_settings_field('waq_tag',__('Enter tags','waq'),'waq_tag_html','waq_settings','waq_settings_query');
	add_settings_field('waq_post_type',__('Post type','waq'),'waq_post_type_html','waq_settings','waq_settings_query');
	add_settings_field('waq_orderby',__('Order by','waq'),'waq_orderby_html','waq_settings','waq_settings_query');
	add_settings_field('waq_posts_per_page',__('Posts per page','waq'),'waq_posts_per_page_html','waq_settings','waq_settings_query');
	//other settings
	add_settings_section('waq_settings_other','','waq_settings_other_html','waq_settings');
	add_settings_field('waq_fontawesome',__('Turn off Font Awesome','waq'),'waq_fontawesome_html','waq_settings','waq_settings_other');
} 
add_action( 'admin_init', 'register_waq_setting' );

/*
 * render option page
 */
function waq_display_settings(){
$waq_options = get_option('waq_options_group');
$waq_button_font = isset($waq_options['button_font'])?$waq_options['button_font']:'';
$waq_post_title_font = isset($waq_options['post_title_font'])?$waq_options['post_title_font']:'';
$waq_post_excerpt_font = isset($waq_options['post_excerpt_font'])?$waq_options['post_excerpt_font']:'';
$waq_post_meta_font = isset($waq_options['post_meta_font'])?$waq_options['post_meta_font']:'';
?>
</pre>
<div class="wrap">
  <div class="mip-setting-page">
    <h1 class="mip-head"><i class="icon-cogs"></i> Quick Ajax Query Settings</h1>
    <div class="mip-setting-content">
    <?php if(isset($_GET['settings-updated'])&&$_GET['settings-updated']==true) {?>
    	<div class="form-group">
            <div class="form-label"></div>
            <div class="form-control">
            	<i class="icon-ok"></i> Settings were saved.
            </div>
         </div>
    <?php } ?>
    <form action="options.php" method="post" name="options" id="mip-form" class="waq-data">
    	<?php settings_errors('med-settings-errors'); ?>
        <?php
			settings_fields('waq_options_group');
			do_settings_sections('waq_settings');
		?>
      	<div class="form-group">
            <div class="form-label"></div>
            <div class="form-control">
            	<button type="submit" title="Update Default Setting" name="submit" class="button"><i class="icon-ok"></i> Update</button>
                <a href="#" title="Generate shortcode with current settings" class="button" id="waq-generate"><i class="icon-edit"></i> Generate shortcode</a>
                <span>Use generate shortcode if you want to create Ajax Query with overwrite default settings</span>
                <br />
                <textarea id="shortcode-area" style="width:94%;height:140px; margin-top:10px; display:none"></textarea>
            </div>
      	</div>
        <script type="text/javascript">
		jQuery(document).ready(function(){ 
			jQuery.getJSON('<?php echo WAQ_PATH ?>core/googlefont.php', function(data){
				var item1 = item2 = item3 = item4 ='';
				jQuery.each(data.items, function(key, val){
					if(val.family=='<?php echo $waq_button_font ?>'){
						item1 += '<option value="'+ val.family + '" selected="selected">'+val.family+'</option>';
					}else{
						item1 += '<option value="'+ val.family + '">'+val.family+'</option>';
					}
					if(val.family=='<?php echo $waq_post_title_font ?>'){
						item2 += '<option value="'+ val.family + '" selected="selected">'+val.family+'</option>';
					}else{
						item2 += '<option value="'+ val.family + '">'+val.family+'</option>';
					}
					if(val.family=='<?php echo $waq_post_excerpt_font ?>'){
						item3 += '<option value="'+ val.family + '" selected="selected">'+val.family+'</option>';
					}else{
						item3 += '<option value="'+ val.family + '">'+val.family+'</option>';
					}
					if(val.family=='<?php echo $waq_post_meta_font ?>'){
						item4 += '<option value="'+ val.family + '" selected="selected">'+val.family+'</option>';
					}else{
						item4 += '<option value="'+ val.family + '">'+val.family+'</option>';
					}
				});
				jQuery('select.font1').append(item1);
				jQuery('select.font2').append(item2);
				jQuery('select.font3').append(item3);
				jQuery('select.font4').append(item4);
				jQuery('.loading-font').remove();
				}); 
			});
		</script>
    </form>
    </div>
  </div>
</div>
<pre>
<?php
}

//header for setting section
function waq_settings_appe_html(){ ?>
	<h2 class="option-group"><i class="icon-laptop"></i> Appearance settings</h2>
<?php 

}

//header for setting section

function waq_settings_ajax_html(){ ?>

	<h2 class="option-group"><i class="icon-spinner"></i> Ajax settings</h2>

<?php 

}

//header for setting section

function waq_settings_play_html(){ ?>

	<h2 class="option-group"><i class="icon-play"></i> Play settings</h2>

<?php 

}

//header for setting section

function waq_settings_post_html(){ ?>

	<h2 class="option-group"><i class="icon-edit"></i> Post settings</h2>

<?php 

}

//header for setting section

function waq_settings_query_html(){ ?>



	<h2 class="option-group"><i class="icon-rss"></i> Query post settings</h2>

<?php 

}

//header for setting section

function waq_settings_other_html(){ ?>

	<h2 class="option-group"><i class="icon-plus-sign"></i> Other settings</h2>

<?php 

}

$waq_options = get_option('waq_options_group');

$waq_font_array=array('Arial','Tahoma','Verdana','Times New Roman','Lucida Sans Unicode');

//render options fields
function waq_layout_html(){
	global $waq_options;
	$layout = isset($waq_options['layout'])?$waq_options['layout']:'classic';
	$array = array(
		array(
			'name'=>'waq_options_group[layout]',
			'value' => 'classic',
			'label' => 'Classic',
			'icon' => 'icon-th-list icon-3x',
		),
		array(
			'name'=>'waq_options_group[layout]',
			'value' => 'modern',
			'label' => 'Modern',
			'icon' => 'icon-th-large icon-3x',
		),
		array(
			'name'=>'waq_options_group[layout]',
			'value' => 'combo',
			'label' => 'Combo',
			'icon' => 'icon-random icon-3x',
		)
	);
	mip_image_radio($layout,$array);?>
    <span> Choose a layout (Classic - list, Modern - masonry, Combo - switch 2 layouts)</span>
<?php
}

//render options fields

function waq_col_width_html(){

	global $waq_options;

	$col_width = isset($waq_options['col_width'])?$waq_options['col_width']:'225'; ?>

    <input type="number" name="waq_options_group[col_width]" title="Column width" placeholder="Column width" value="<?php echo $col_width ?>" />

    <span>px (Ex: 225) Uses for column width in Modern layout and Thumbnail width in Classic layout</span>

<?php

}

//render options fields

function waq_ajax_style_html(){

	global $waq_options;

	$ajax_style = isset($waq_options['ajax_style'])?$waq_options['ajax_style']:'button';

	$array = array(

		array(

			'name'=>'waq_options_group[ajax_style]',

			'value' => 'scroll',

			'label' => 'Infinity Scroll',

			'icon' => 'icon-sort-by-attributes icon-3x',

		),

		array(

			'name'=>'waq_options_group[ajax_style]',

			'value' => 'button',

			'label' => 'Next button',

			'icon' => 'icon-circle-arrow-right icon-3x',

		)

	);

	mip_image_radio($ajax_style,$array);?>

<?php

}

function waq_button_html(){

	global $waq_options;

	$waq_button_label = isset($waq_options['button_label'])?$waq_options['button_label']:'View more';

	$waq_button_text_color = isset($waq_options['button_text_color'])?$waq_options['button_text_color']:'ffffff';

	$waq_button_bg_color = isset($waq_options['button_bg_color'])?$waq_options['button_bg_color']:'35aa47';

	$waq_button_font = isset($waq_options['button_font'])?$waq_options['button_font']:'0';

	$waq_button_size = isset($waq_options['button_size'])?$waq_options['button_size']:'14';

?>

	<input type="text" name="waq_options_group[button_label]" placeholder="Label" value="<?php echo $waq_button_label ?>" title="Label" />

    <i class="icon-adjust"></i><span> Color:</span>

    <input class="color" placeholder="Text Color" name="waq_options_group[button_text_color]" value="<?php echo $waq_button_text_color ?>" title="Text color">

    <i class="icon-tint"></i><span> Background:</span>

    <input class="color" placeholder="Background Color" name="waq_options_group[button_bg_color]" value="<?php echo $waq_button_bg_color ?>" title="Background color">

    <i class="icon-font"></i>

    <select class="font font1" name="waq_options_group[button_font]" title="Font">

        <option value="0">Choose Font</option>

        <?php

		global $waq_font_array;

		foreach($waq_font_array as $font){ ?>

			<option value="<?php echo $font ?>" <?php echo $font==$waq_button_font?'selected="selected"':'' ?> ><?php echo $font ?></option>

		<?php } ?>

        <option class="loading-font" disabled="disabled">Loading google font list...</option>

    </select>

    <i class="icon-text-height"></i>

    <input type="number" class="mini" name="waq_options_group[button_size]" title="Font Size" placeholder="Font size" value="<?php echo $waq_button_size ?>" />

    <span>px</span>

<?php

}

function waq_button_icon_html(){

	global $waq_options;

	$waq_button_icon = isset($waq_options['button_icon'])?$waq_options['button_icon']:'icon-double-angle-right';

?>

    <select style="font-family: 'FontAwesome', 'Helvetica';" name="waq_options_group[button_icon]">

    	<option value="0">Select icon...</option>

		<?php waq_font_awesome_option($waq_button_icon); ?>

	</select>

<?php

}

function waq_loading_image_html(){
	global $waq_options;
	$waq_loading_image = isset($waq_options['loading_image'])?$waq_options['loading_image']:'1';
	$array = array(
		array(
			'name'=>'waq_options_group[loading_image]',
			'value' => '1',
			'label' => '',
			'icon' => '<img src="'.WAQ_PATH.'images/gray.gif" width="88px" height="8px" />',
		),
		array(
			'name'=>'waq_options_group[loading_image]',
			'value' => '2',
			'label' => '',
			'icon' => '<i class="icon-spinner icon-spin icon-large"></i>',
		),
		array(
			'name'=>'waq_options_group[loading_image]',
			'value' => '3',
			'label' => '',
			'icon' => '<i class="icon-refresh icon-spin icon-large"></i>',
		),
		array(
			'name'=>'waq_options_group[loading_image]',
			'value' => '4',
			'label' => '',
			'icon' => '<i class="icon-cog icon-spin icon-large"></i>',
		)
	);
	mip_image_radio_custom($waq_loading_image,$array);
}

function waq_thumb_size_html(){

	global $waq_options;

	$waq_thumb_size = isset($waq_options['thumb_size'])?$waq_options['thumb_size']:'thumbnail';

?>

    <select name="waq_options_group[thumb_size]">

    <?php 

    $sizes = waq_list_thumbnail_sizes();

    foreach( $sizes as $size => $atts ): ?>

        <option value="<?php echo $size ?>" <?php echo $waq_thumb_size==$size?'selected':'' ?> ><?php echo $size . ' ' . implode( 'x', $atts ) ?></option>

    <?php endforeach; ?>

    </select>

<?php	

}

function waq_post_title_html(){

	global $waq_options;

	$waq_post_title_color = isset($waq_options['post_title_color'])?$waq_options['post_title_color']:'35aa47';

	$waq_post_title_font = isset($waq_options['post_title_font'])?$waq_options['post_title_font']:'';

	$waq_post_title_size = isset($waq_options['post_title_size'])?$waq_options['post_title_size']:'18';

	?>

    <i class="icon-adjust"></i>

    <input class="color" placeholder="Color" name="waq_options_group[post_title_color]" value="<?php echo $waq_post_title_color ?>" title="Text color">

    <i class="icon-font"></i>

    <select class="font font2" name="waq_options_group[post_title_font]" title="Font">

        <option value="0">Choose Font</option>

        <?php

        global $waq_font_array;

		foreach($waq_font_array as $font){ ?>

                <option value="<?php echo $font ?>" <?php echo $font==$waq_post_title_font?'selected="selected"':'' ?> ><?php echo $font ?></option>

            <?php }

        ?>

        <option class="loading-font" disabled="disabled">Loading google font list...</option>

    </select>

    <i class="icon-text-height"></i>

    <input type="number" class="mini" name="waq_options_group[post_title_size]" title="Font Size" placeholder="Font size" value="<?php echo $waq_post_title_size ?>" />

<?php

}

function waq_post_excerpt_html(){
	global $waq_options;
	$waq_post_excerpt_color = isset($waq_options['post_excerpt_color'])?$waq_options['post_excerpt_color']:'444444';
	$waq_post_excerpt_font = isset($waq_options['post_excerpt_font'])?$waq_options['post_excerpt_font']:'';
	$waq_post_excerpt_size = isset($waq_options['post_excerpt_size'])?$waq_options['post_excerpt_size']:'14';
	$waq_post_excerpt_limit = isset($waq_options['post_excerpt_limit'])?$waq_options['post_excerpt_limit']:'0';
?>
    <i class="icon-adjust"></i>
    <input class="color" placeholder="Color" name="waq_options_group[post_excerpt_color]" value="<?php echo $waq_post_excerpt_color ?>" title="Text color">
    <i class="icon-font"></i>
    <select class="font font3" name="waq_options_group[post_excerpt_font]" title="Font">
        <option value="0">Choose Font</option>
        <?php
		global $waq_font_array;
		foreach($waq_font_array as $font){ ?>
			<option value="<?php echo $font ?>" <?php echo $font==$waq_post_excerpt_font?'selected="selected"':'' ?> ><?php echo $font ?></option>
		<?php } ?>
        <option class="loading-font" disabled="disabled">Loading google font list...</option>
    </select>
    <i class="icon-text-height"></i>
    <input type="number" class="mini" name="waq_options_group[post_excerpt_size]" title="Font Size" placeholder="Font size" value="<?php echo $waq_post_excerpt_size ?>" />
    <span> Limit:</span>
    <input type="number" class="mini" name="waq_options_group[post_excerpt_limit]" title="Exerpt limit words number" placeholder="Limit words number" value="<?php echo $waq_post_excerpt_limit ?>" />
	<span> "0" for default<i> (This is global variable, effect all Quick Ajax Shortcodes)</i></span>
<?php
}

function waq_post_meta_html(){
	global $waq_options;
	$waq_post_meta_color = isset($waq_options['post_meta_color'])?$waq_options['post_meta_color']:'999999';
	$waq_post_meta_font = isset($waq_options['post_meta_font'])?$waq_options['post_meta_font']:'';
	$waq_post_meta_size = isset($waq_options['post_meta_size'])?$waq_options['post_meta_size']:'11';
?>

    <i class="icon-adjust"></i>

    <input class="color" placeholder="Color" name="waq_options_group[post_meta_color]" value="<?php echo $waq_post_meta_color ?>" title="Text color">

    <i class="icon-font"></i>

    <select class="font font4" name="waq_options_group[post_meta_font]" title="Font">

        <option value="0">Choose Font</option>

        <?php

		global $waq_font_array;

		foreach($waq_font_array as $font){ ?>

			<option value="<?php echo $font ?>" <?php echo $font==$waq_post_meta_font?'selected="selected"':'' ?> ><?php echo $font ?></option>

		<?php } ?>

        <option class="loading-font" disabled="disabled">Loading google font list...</option>

    </select>

    <i class="icon-text-height"></i>

    <input type="number" class="mini" name="waq_options_group[post_meta_size]" title="Font Size" placeholder="Font size" value="<?php echo $waq_post_meta_size ?>" />

<?php	

}

function waq_thumb_hover_html(){

	global $waq_options;

	$waq_thumb_hover_icon = isset($waq_options['thumb_hover_icon'])?$waq_options['thumb_hover_icon']:'icon-search';

	$waq_thumb_hover_color = isset($waq_options['thumb_hover_color'])?$waq_options['thumb_hover_color']:'35aa47';

	$waq_thumb_hover_bg = isset($waq_options['thumb_hover_bg'])?$waq_options['thumb_hover_bg']:'ffffff';

	$waq_thumb_hover_popup = isset($waq_options['thumb_hover_popup'])?$waq_options['thumb_hover_popup']:'1';

	?>

    <select style="font-family: 'FontAwesome', 'Helvetica';" name="waq_options_group[thumb_hover_icon]">

    	<option value="0">No icon</option>

		<?php waq_font_awesome_option($waq_thumb_hover_icon); ?>

	</select>

    <i class="icon-adjust"></i><span> Icon color:</span>

    <input class="color" placeholder="Icon Color" name="waq_options_group[thumb_hover_color]" value="<?php echo $waq_thumb_hover_color ?>" title="Icon color">

    <i class="icon-tint"></i><span> Background:</span>

    <input class="color" placeholder="Background Color" name="waq_options_group[thumb_hover_bg]" value="<?php echo $waq_thumb_hover_bg ?>" title="Background color">

    <span>&nbsp;&nbsp;&nbsp;When click thumb? </span>

<?php

	$array = array(

		array(

			'name'=>'waq_options_group[thumb_hover_popup]',

			'value' => '1',

			'label' => 'Popup Image',

			'icon' => 'icon-picture',

		),

		array(

			'name'=>'waq_options_group[thumb_hover_popup]',

			'value' => '0',

			'label' => 'Go to post',

			'icon' => 'icon-link',

		)

	);

	mip_image_radio($waq_thumb_hover_popup,$array);

}

function waq_popup_theme_html(){

	global $waq_options;

	$waq_popup_theme = isset($waq_options['popup_theme'])?$waq_options['popup_theme']:'0';

	?>

    <select name="waq_options_group[popup_theme]">

		<option value="0" <?php echo $waq_popup_theme=='0'?'selected="selected"':'' ?>>Default</option>

        <option value="facebook" <?php echo $waq_popup_theme=='facebook'?'selected="selected"':'' ?>>Facebook</option>

        <option value="light_rounded" <?php echo $waq_popup_theme=='light_rounded'?'selected="selected"':'' ?>>Light rounded</option>

        <option value="light_square" <?php echo $waq_popup_theme=='light_square'?'selected="selected"':'' ?>>Light square</option>

        <option value="dark_rounded" <?php echo $waq_popup_theme=='dark_rounded'?'selected="selected"':'' ?>>Dark rounded</option>

        <option value="dark_square" <?php echo $waq_popup_theme=='dark_square'?'selected="selected"':'' ?>>Dark square</option>

	</select>

<?php

}

function waq_border_hover_html(){

	global $waq_options;

	$waq_border_hover_color = isset($waq_options['border_hover_color'])?$waq_options['border_hover_color']:'35AA47';

	$waq_border_hover_width = isset($waq_options['border_hover_width'])?$waq_options['border_hover_width']:'1';

?>

    <i class="icon-adjust"></i>

    <input class="color" placeholder="Border" name="waq_options_group[border_hover_color]" value="<?php echo $waq_border_hover_color ?>" title="Border color">

    <span><i class="icon-resize-horizontal"></i> Border width</span>

    <input class="mini" type="number" max="100" min="0" name="waq_options_group[border_hover_width]" title="Border width" value="<?php echo $waq_border_hover_width ?>" /><span> px</span>

<?php

}

function waq_cat_html(){

	global $waq_options;

	$waq_cat = isset($waq_options['cat'])?$waq_options['cat']:array();

	$cats = get_terms( 'category', 'hide_empty=0' );

	echo '<div class="waq_cat_checkbox">';

	if($cats){

		foreach ($cats as $acat){

			$checked = in_array($acat->term_id,$waq_cat)?'checked':'';

			echo '<div class="checkbox-item"><input type="checkbox" name="waq_options_group[cat][]" value="'.$acat->term_id.'" '.$checked.'/><span> '.$acat->name.' </span></div>';

		}

	}

	echo '</div>';

}

function waq_tag_html(){

	global $waq_options;

	$waq_tag = isset($waq_options['tag'])?$waq_options['tag']:'';

	?>

    <input type="text" name="waq_options_group[tag]" placeholder="Tags to include" value="<?php echo $waq_tag ?>" /><span> Ex: foo,bar,sample-tag (Uses tag slug)</span>

<?php

}

function waq_post_type_html(){
	global $waq_options;
	$waq_post_type = isset($waq_options['post_type'])?$waq_options['post_type']:array();
	$pargs = array(
		'public'   => true,
		'publicly_queryable' => true,
		'_builtin' => false
	);
	$output = 'names'; // names or objects, note names is the default
	$operator = 'and'; // 'and' or 'or'
	$post_types = get_post_types( $pargs, $output, $operator ); 
	$post_types[] = 'post';
	$post_types[] = 'attachment';
	sort($post_types);
	echo '<div class="waq_posttype_checkbox">';
	foreach ( $post_types  as $post_type ) {
		$checked = in_array($post_type,$waq_post_type)?'checked':'';
		echo '<div class="checkbox-item"><input type="checkbox" name="waq_options_group[post_type][]" value="'.$post_type.'" '.$checked.'/><span> '.$post_type.' </span></div>';
	}
	echo '</div>';
}

function waq_orderby_html(){
	global $waq_options;
	$waq_orderby = isset($waq_options['orderby'])?$waq_options['orderby']:'date';
	$waq_order = isset($waq_options['order'])?$waq_options['order']:'DESC';
	?>
    <select name="waq_options_group[orderby]">
    	<?php
			$options = array('ID','date','title','name','parent','author','modified','comment_count','menu_order','rand');
			foreach($options as $option){
				$selected = $option==$waq_orderby?'selected="selected"':'';
				echo '<option value="'.$option.'" '.$selected.' >'.$option.'</option>';
			}
		?>
    </select>
    <span> Order:</span>
    <select name="waq_options_group[order]">
    	<?php
			$options = array('ASC','DESC');
			foreach($options as $option){
				$selected = $option==$waq_order?'selected="selected"':'';
				echo '<option value="'.$option.'" '.$selected.' >'.$option.'</option>';
			}
		?>
    </select>
<?php

}
function waq_posts_per_page_html(){
	global $waq_options;
	$waq_posts_per_page = isset($waq_options['posts_per_page'])?$waq_options['posts_per_page']:'12';
	?>
    <input type="number" value="<?php echo $waq_posts_per_page ?>" name="waq_options_group[posts_per_page]" placeholder="Default = 12" />
<?php
}

function waq_rtl_html(){
	global $waq_options;
	$waq_rtl = isset($waq_options['waq_rtl'])?$waq_options['waq_rtl']:'0';
	?>
    <div class="waq_rtl_checkbox">
    <input type="checkbox" <?php echo $waq_rtl?'checked':'' ?> name="waq_options_group[waq_rtl]" value="1" /><span> Enable RTL mode</span>
    </div>
<?php
}

function waq_fontawesome_html(){

	global $waq_options;

	$waq_fontawesome = isset($waq_options['fontawesome'])?$waq_options['fontawesome']:'0';

	?>

    <div class="waq_fontawesome_checkbox">

    <input type="checkbox" <?php echo $waq_fontawesome?'checked':'' ?> name="waq_options_group[fontawesome]" value="1" /><span> Turn off loading plugin's Font Awesome. Check if your theme has already loaded this library</span>

    </div>

<?php

}



//validate

function waq_options_validate( $input ) {

    return $input;  

}



/*
 * build radio image select
 */
function mip_image_radio($option,$array){
?>
<span class="image-select">
	<?php foreach($array as $item){ ?>
    <input type="radio" name="<?php echo $item['name'] ?>" id="<?php echo $item['name'] ?>-<?php echo $item['value'] ?>" value="<?php echo $item['value'] ?>" <?php echo ($option==$item['value'])?'checked':'' ?> />
    <label for="<?php echo $item['name'] ?>-<?php echo $item['value'] ?>" class="<?php echo ($option==$item['value'])?'selected':'' ?>" ><i class="<?php echo $item['icon'] ?> icon-large"></i><br>
    <?php echo $item['label'] ?></label>
    <?php } ?>
</span>
<?php
}
function mip_image_radio_custom($option,$array){
?>
<span class="image-select">
	<?php foreach($array as $item){ ?>
    <input type="radio" name="<?php echo $item['name'] ?>" id="<?php echo $item['name'] ?>-<?php echo $item['value'] ?>" value="<?php echo $item['value'] ?>" <?php echo ($option==$item['value'])?'checked':'' ?> />
    <label for="<?php echo $item['name'] ?>-<?php echo $item['value'] ?>" class="<?php echo ($option==$item['value'])?'selected':'' ?>" ><?php echo $item['icon'] ?><br>
    <?php echo $item['label'] ?></label>
    <?php } ?>
</span>
<?php
}

/*
 * enqueue admin scripts
 */

function waq_admin_scripts() {
    wp_enqueue_script('jquery');
	wp_enqueue_script('jscolor', WAQ_PATH.'js/jscolor/jscolor.js', array('jquery'));
	wp_enqueue_script('wpajax_admin', plugins_url( 'admin.js', __FILE__ ), array('jquery'));
	wp_enqueue_style('wpajax_admin', plugins_url( 'admin.css', __FILE__ ));
	wp_enqueue_style('font-awesome', WAQ_PATH.'font-awesome/css/font-awesome.min.css');
}
add_action( 'admin_enqueue_scripts', 'waq_admin_scripts' );

/*
 * get list image sizes
 */
function waq_list_thumbnail_sizes(){
	global $_wp_additional_image_sizes;
	$sizes = array();
	foreach( get_intermediate_image_sizes() as $s ){
		$sizes[ $s ] = array( 0, 0 );
		if( in_array( $s, array( 'thumbnail', 'medium', 'large' ) ) ){
			$sizes[ $s ][0] = get_option( $s . '_size_w' );
			$sizes[ $s ][1] = get_option( $s . '_size_h' );
		}else{
			if( isset( $_wp_additional_image_sizes ) && isset( $_wp_additional_image_sizes[ $s ] ) )
			$sizes[ $s ] = array( $_wp_additional_image_sizes[ $s ]['width'], $_wp_additional_image_sizes[ $s ]['height'], );
		}
	}
	return $sizes;
}

//add tinyMCE button
// init process for registering our button
add_action('init', 'waq_shortcode_button_init');
function waq_shortcode_button_init() {
	//Abort early if the user will never see TinyMCE
	if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') && get_user_option('rich_editing') == 'true')
	   return;
	//Add a callback to regiser our tinymce plugin   
	add_filter("mce_external_plugins", "waq_register_tinymce_plugin"); 
	// Add a callback to add our button to the TinyMCE toolbar
	add_filter('mce_buttons', 'waq_add_tinymce_button');
}

//This callback registers our plug-in
function waq_register_tinymce_plugin($plugin_array) {
    $plugin_array['waq_button'] = WAQ_PATH . 'js/button.js';
    return $plugin_array;
}

//This callback adds our button to the toolbar
function waq_add_tinymce_button($buttons) {
    //Add the button ID to the $button array
    $buttons[] = "waq_button";
    return $buttons;
}

function waq_font_awesome_option($default=''){
	$icons = array(
		'icon-glass' => '&#xf000;',
		'icon-music' => '&#xf001;',
		'icon-search' => '&#xf002;',
		'icon-envelope-alt' => '&#xf003;',
		'icon-heart' => '&#xf004;',
		'icon-star' => '&#xf005;',
		'icon-star-empty' => '&#xf006;',
		'icon-user' => '&#xf007;',
		'icon-film' => '&#xf008;',
		'icon-th-large' => '&#xf009;',
		'icon-th' => '&#xf00a;',
		'icon-th-list' => '&#xf00b;',
		'icon-ok' => '&#xf00c;',
		'icon-remove' => '&#xf00d;',
		'icon-zoom-in' => '&#xf00e;',
		'icon-zoom-out' => '&#xf010;',
		'icon-off' => '&#xf011;',
		'icon-signal' => '&#xf012;',
		'icon-cog' => '&#xf013;',
		'icon-trash' => '&#xf014;',
		'icon-home' => '&#xf015;',
		'icon-file-alt' => '&#xf016;',
		'icon-time' => '&#xf017;',
		'icon-road' => '&#xf018;',
		'icon-download-alt' => '&#xf019;',
		'icon-download' => '&#xf01a;',
		'icon-upload' => '&#xf01b;',
		'icon-inbox' => '&#xf01c;',
		'icon-play-circle' => '&#xf01d;',
		'icon-repeat' => '&#xf01e;',
		'icon-refresh' => '&#xf021;',
		'icon-list-alt' => '&#xf022;',
		'icon-lock' => '&#xf023;',
		'icon-flag' => '&#xf024;',
		'icon-headphones' => '&#xf025;',
		'icon-volume-off' => '&#xf026;',
		'icon-volume-down' => '&#xf027;',
		'icon-volume-up' => '&#xf028;',
		'icon-qrcode' => '&#xf029;',
		'icon-barcode' => '&#xf02a;',
		'icon-tag' => '&#xf02b;',
		'icon-tags' => '&#xf02c;',
		'icon-book' => '&#xf02d;',
		'icon-bookmark' => '&#xf02e;',
		'icon-print' => '&#xf02f;',
		'icon-camera' => '&#xf030;',
		'icon-font' => '&#xf031;',
		'icon-bold' => '&#xf032;',
		'icon-italic' => '&#xf033;',
		'icon-text-height' => '&#xf034;',
		'icon-text-width' => '&#xf035;',
		'icon-align-left' => '&#xf036;',
		'icon-align-center' => '&#xf037;',
		'icon-align-right' => '&#xf038;',
		'icon-align-justify' => '&#xf039;',
		'icon-list' => '&#xf03a;',
		'icon-indent-left' => '&#xf03b;',
		'icon-indent-right' => '&#xf03c;',
		'icon-facetime-video' => '&#xf03d;',
		'icon-picture' => '&#xf03e;',
		'icon-pencil' => '&#xf040;',
		'icon-map-marker' => '&#xf041;',
		'icon-adjust' => '&#xf042;',
		'icon-tint' => '&#xf043;',
		'icon-edit' => '&#xf044;',
		'icon-share' => '&#xf045;',
		'icon-check' => '&#xf046;',
		'icon-move' => '&#xf047;',
		'icon-step-backward' => '&#xf048;',
		'icon-fast-backward' => '&#xf049;',
		'icon-backward' => '&#xf04a;',
		'icon-play' => '&#xf04b;',
		'icon-pause' => '&#xf04c;',
		'icon-stop' => '&#xf04d;',
		'icon-forward' => '&#xf04e;',
		'icon-fast-forward' => '&#xf050;',
		'icon-step-forward' => '&#xf051;',
		'icon-eject' => '&#xf052;',
		'icon-chevron-left' => '&#xf053;',
		'icon-chevron-right' => '&#xf054;',
		'icon-plus-sign' => '&#xf055;',
		'icon-minus-sign' => '&#xf056;',
		'icon-remove-sign' => '&#xf057;',
		'icon-ok-sign' => '&#xf058;',
		'icon-question-sign' => '&#xf059;',
		'icon-info-sign' => '&#xf05a;',
		'icon-screenshot' => '&#xf05b;',
		'icon-remove-circle' => '&#xf05c;',
		'icon-ok-circle' => '&#xf05d;',
		'icon-ban-circle' => '&#xf05e;',
		'icon-arrow-left' => '&#xf060;',
		'icon-arrow-right' => '&#xf061;',
		'icon-arrow-up' => '&#xf062;',
		'icon-arrow-down' => '&#xf063;',
		'icon-share-alt' => '&#xf064;',
		'icon-resize-full' => '&#xf065;',
		'icon-resize-small' => '&#xf066;',
		'icon-plus' => '&#xf067;',
		'icon-minus' => '&#xf068;',
		'icon-asterisk' => '&#xf069;',
		'icon-exclamation-sign' => '&#xf06a;',
		'icon-gift' => '&#xf06b;',
		'icon-leaf' => '&#xf06c;',
		'icon-fire' => '&#xf06d;',
		'icon-eye-open' => '&#xf06e;',
		'icon-eye-close' => '&#xf070;',
		'icon-warning-sign' => '&#xf071;',
		'icon-plane' => '&#xf072;',
		'icon-calendar' => '&#xf073;',
		'icon-random' => '&#xf074;',
		'icon-comment' => '&#xf075;',
		'icon-magnet' => '&#xf076;',
		'icon-chevron-up' => '&#xf077;',
		'icon-chevron-down' => '&#xf078;',
		'icon-retweet' => '&#xf079;',
		'icon-shopping-cart' => '&#xf07a;',
		'icon-folder-close' => '&#xf07b;',
		'icon-folder-open' => '&#xf07c;',
		'icon-resize-vertical' => '&#xf07d;',
		'icon-resize-horizontal' => '&#xf07e;',
		'icon-bar-chart' => '&#xf080;',
		'icon-twitter-sign' => '&#xf081;',
		'icon-facebook-sign' => '&#xf082;',
		'icon-camera-retro' => '&#xf083;',
		'icon-key' => '&#xf084;',
		'icon-cogs' => '&#xf085;',
		'icon-comments' => '&#xf086;',
		'icon-thumbs-up-alt' => '&#xf087;',
		'icon-thumbs-down-alt' => '&#xf088;',
		'icon-star-half' => '&#xf089;',
		'icon-heart-empty' => '&#xf08a;',
		'icon-signout' => '&#xf08b;',
		'icon-linkedin-sign' => '&#xf08c;',
		'icon-pushpin' => '&#xf08d;',
		'icon-external-link' => '&#xf08e;',
		'icon-signin' => '&#xf090;',
		'icon-trophy' => '&#xf091;',
		'icon-github-sign' => '&#xf092;',
		'icon-upload-alt' => '&#xf093;',
		'icon-lemon' => '&#xf094;',
		'icon-phone' => '&#xf095;',
		'icon-check-empty' => '&#xf096;',
		'icon-bookmark-empty' => '&#xf097;',
		'icon-phone-sign' => '&#xf098;',
		'icon-twitter' => '&#xf099;',
		'icon-facebook' => '&#xf09a;',
		'icon-github' => '&#xf09b;',
		'icon-unlock' => '&#xf09c;',
		'icon-credit-card' => '&#xf09d;',
		'icon-rss' => '&#xf09e;',
		'icon-hdd' => '&#xf0a0;',
		'icon-bullhorn' => '&#xf0a1;',
		'icon-bell' => '&#xf0a2;',
		'icon-certificate' => '&#xf0a3;',
		'icon-hand-right' => '&#xf0a4;',
		'icon-hand-left' => '&#xf0a5;',
		'icon-hand-up' => '&#xf0a6;',
		'icon-hand-down' => '&#xf0a7;',
		'icon-circle-arrow-left' => '&#xf0a8;',
		'icon-circle-arrow-right' => '&#xf0a9;',
		'icon-circle-arrow-up' => '&#xf0aa;',
		'icon-circle-arrow-down' => '&#xf0ab;',
		'icon-globe' => '&#xf0ac;',
		'icon-wrench' => '&#xf0ad;',
		'icon-tasks' => '&#xf0ae;',
		'icon-filter' => '&#xf0b0;',
		'icon-briefcase' => '&#xf0b1;',
		'icon-fullscreen' => '&#xf0b2;',
		'icon-group' => '&#xf0c0;',
		'icon-link' => '&#xf0c1;',
		'icon-cloud' => '&#xf0c2;',
		'icon-beaker' => '&#xf0c3;',
		'icon-cut' => '&#xf0c4;',
		'icon-copy' => '&#xf0c5;',
		'icon-paper-clip' => '&#xf0c6;',
		'icon-save' => '&#xf0c7;',
		'icon-sign-blank' => '&#xf0c8;',
		'icon-reorder' => '&#xf0c9;',
		'icon-list-ul' => '&#xf0ca;',
		'icon-list-ol' => '&#xf0cb;',
		'icon-strikethrough' => '&#xf0cc;',
		'icon-underline' => '&#xf0cd;',
		'icon-table' => '&#xf0ce;',
		'icon-magic' => '&#xf0d0;',
		'icon-truck' => '&#xf0d1;',
		'icon-pinterest' => '&#xf0d2;',
		'icon-pinterest-sign' => '&#xf0d3;',
		'icon-google-plus-sign' => '&#xf0d4;',
		'icon-google-plus' => '&#xf0d5;',
		'icon-money' => '&#xf0d6;',
		'icon-caret-down' => '&#xf0d7;',
		'icon-caret-up' => '&#xf0d8;',
		'icon-caret-left' => '&#xf0d9;',
		'icon-caret-right' => '&#xf0da;',
		'icon-columns' => '&#xf0db;',
		'icon-sort' => '&#xf0dc;',
		'icon-sort-down' => '&#xf0dd;',
		'icon-sort-up' => '&#xf0de;',
		'icon-envelope' => '&#xf0e0;',
		'icon-linkedin' => '&#xf0e1;',
		'icon-undo' => '&#xf0e2;',
		'icon-legal' => '&#xf0e3;',
		'icon-dashboard' => '&#xf0e4;',
		'icon-comment-alt' => '&#xf0e5;',
		'icon-comments-alt' => '&#xf0e6;',
		'icon-bolt' => '&#xf0e7;',
		'icon-sitemap' => '&#xf0e8;',
		'icon-umbrella' => '&#xf0e9;',
		'icon-paste' => '&#xf0ea;',
		'icon-lightbulb' => '&#xf0eb;',
		'icon-exchange' => '&#xf0ec;',
		'icon-cloud-download' => '&#xf0ed;',
		'icon-cloud-upload' => '&#xf0ee;',
		'icon-user-md' => '&#xf0f0;',
		'icon-stethoscope' => '&#xf0f1;',
		'icon-suitcase' => '&#xf0f2;',
		'icon-bell-alt' => '&#xf0f3;',
		'icon-coffee' => '&#xf0f4;',
		'icon-food' => '&#xf0f5;',
		'icon-file-text-alt' => '&#xf0f6;',
		'icon-building' => '&#xf0f7;',
		'icon-hospital' => '&#xf0f8;',
		'icon-ambulance' => '&#xf0f9;',
		'icon-medkit' => '&#xf0fa;',
		'icon-fighter-jet' => '&#xf0fb;',
		'icon-beer' => '&#xf0fc;',
		'icon-h-sign' => '&#xf0fd;',
		'icon-plus-sign-alt' => '&#xf0fe;',
		'icon-double-angle-left' => '&#xf100;',
		'icon-double-angle-right' => '&#xf101;',
		'icon-double-angle-up' => '&#xf102;',
		'icon-double-angle-down' => '&#xf103;',
		'icon-angle-left' => '&#xf104;',
		'icon-angle-right' => '&#xf105;',
		'icon-angle-up' => '&#xf106;',
		'icon-angle-down' => '&#xf107;',
		'icon-desktop' => '&#xf108;',
		'icon-laptop' => '&#xf109;',
		'icon-tablet' => '&#xf10a;',
		'icon-mobile-phone' => '&#xf10b;',
		'icon-circle-blank' => '&#xf10c;',
		'icon-quote-left' => '&#xf10d;',
		'icon-quote-right' => '&#xf10e;',
		'icon-spinner' => '&#xf110;',
		'icon-circle' => '&#xf111;',
		'icon-reply' => '&#xf112;',
		'icon-github-alt' => '&#xf113;',
		'icon-folder-close-alt' => '&#xf114;',
		'icon-folder-open-alt' => '&#xf115;',
		'icon-expand-alt' => '&#xf116;',
		'icon-collapse-alt' => '&#xf117;',
		'icon-smile' => '&#xf118;',
		'icon-frown' => '&#xf119;',
		'icon-meh' => '&#xf11a;',
		'icon-gamepad' => '&#xf11b;',
		'icon-keyboard' => '&#xf11c;',
		'icon-flag-alt' => '&#xf11d;',
		'icon-flag-checkered' => '&#xf11e;',
		'icon-terminal' => '&#xf120;',
		'icon-code' => '&#xf121;',
		'icon-reply-all' => '&#xf122;',
		'icon-mail-reply-all' => '&#xf122;',
		'icon-star-half-empty' => '&#xf123;',
		'icon-location-arrow' => '&#xf124;',
		'icon-crop' => '&#xf125;',
		'icon-code-fork' => '&#xf126;',
		'icon-unlink' => '&#xf127;',
		'icon-question' => '&#xf128;',
		'icon-info' => '&#xf129;',
		'icon-exclamation' => '&#xf12a;',
		'icon-superscript' => '&#xf12b;',
		'icon-subscript' => '&#xf12c;',
		'icon-eraser' => '&#xf12d;',
		'icon-puzzle-piece' => '&#xf12e;',
		'icon-microphone' => '&#xf130;',
		'icon-microphone-off' => '&#xf131;',
		'icon-shield' => '&#xf132;',
		'icon-calendar-empty' => '&#xf133;',
		'icon-fire-extinguisher' => '&#xf134;',
		'icon-rocket' => '&#xf135;',
		'icon-maxcdn' => '&#xf136;',
		'icon-chevron-sign-left' => '&#xf137;',
		'icon-chevron-sign-right' => '&#xf138;',
		'icon-chevron-sign-up' => '&#xf139;',
		'icon-chevron-sign-down' => '&#xf13a;',
		'icon-html5' => '&#xf13b;',
		'icon-css3' => '&#xf13c;',
		'icon-anchor' => '&#xf13d;',
		'icon-unlock-alt' => '&#xf13e;',
		'icon-bullseye' => '&#xf140;',
		'icon-ellipsis-horizontal' => '&#xf141;',
		'icon-ellipsis-vertical' => '&#xf142;',
		'icon-rss-sign' => '&#xf143;',
		'icon-play-sign' => '&#xf144;',
		'icon-ticket' => '&#xf145;',
		'icon-minus-sign-alt' => '&#xf146;',
		'icon-check-minus' => '&#xf147;',
		'icon-level-up' => '&#xf148;',
		'icon-level-down' => '&#xf149;',
		'icon-check-sign' => '&#xf14a;',
		'icon-edit-sign' => '&#xf14b;',
		'icon-external-link-sign' => '&#xf14c;',
		'icon-share-sign' => '&#xf14d;',
		'icon-compass' => '&#xf14e;',
		'icon-collapse' => '&#xf150;',
		'icon-collapse-top' => '&#xf151;',
		'icon-expand' => '&#xf152;',
		'icon-eur' => '&#xf153;',
		'icon-gbp' => '&#xf154;',
		'icon-usd' => '&#xf155;',
		'icon-inr' => '&#xf156;',
		'icon-jpy' => '&#xf157;',
		'icon-cny' => '&#xf158;',
		'icon-krw' => '&#xf159;',
		'icon-btc' => '&#xf15a;',
		'icon-file' => '&#xf15b;',
		'icon-file-text' => '&#xf15c;',
		'icon-sort-by-alphabet' => '&#xf15d;',
		'icon-sort-by-alphabet-alt' => '&#xf15e;',
		'icon-sort-by-attributes' => '&#xf160;',
		'icon-sort-by-attributes-alt' => '&#xf161;',
		'icon-sort-by-order' => '&#xf162;',
		'icon-sort-by-order-alt' => '&#xf163;',
		'icon-thumbs-up' => '&#xf164;',
		'icon-thumbs-down' => '&#xf165;',
		'icon-youtube-sign' => '&#xf166;',
		'icon-youtube' => '&#xf167;',
		'icon-xing' => '&#xf168;',
		'icon-xing-sign' => '&#xf169;',
		'icon-youtube-play' => '&#xf16a;',
		'icon-dropbox' => '&#xf16b;',
		'icon-stackexchange' => '&#xf16c;',
		'icon-instagram' => '&#xf16d;',
		'icon-flickr' => '&#xf16e;',
		'icon-adn' => '&#xf170;',
		'icon-bitbucket' => '&#xf171;',
		'icon-bitbucket-sign' => '&#xf172;',
		'icon-tumblr' => '&#xf173;',
		'icon-tumblr-sign' => '&#xf174;',
		'icon-long-arrow-down' => '&#xf175;',
		'icon-long-arrow-up' => '&#xf176;',
		'icon-long-arrow-left' => '&#xf177;',
		'icon-long-arrow-right' => '&#xf178;',
		'icon-apple' => '&#xf179;',
		'icon-windows' => '&#xf17a;',
		'icon-android' => '&#xf17b;',
		'icon-linux' => '&#xf17c;',
		'icon-dribbble' => '&#xf17d;',
		'icon-skype' => '&#xf17e;',
		'icon-foursquare' => '&#xf180;',
		'icon-trello' => '&#xf181;',
		'icon-female' => '&#xf182;',
		'icon-male' => '&#xf183;',
		'icon-gittip' => '&#xf184;',
		'icon-sun' => '&#xf185;',
		'icon-moon' => '&#xf186;',
		'icon-archive' => '&#xf187;',
		'icon-bug' => '&#xf188;',
		'icon-vk' => '&#xf189;',
		'icon-weibo' => '&#xf18a;',
		'icon-renren' => '&#xf18b;',
	);
	ksort($icons);
	foreach($icons as $name=>$icon){
		$selected = $default==$name?'selected="selected"':'';
		echo '<option value="'.$name.'" '.$selected.' >'.$icon.' '.$name.'</option>';
	}
}