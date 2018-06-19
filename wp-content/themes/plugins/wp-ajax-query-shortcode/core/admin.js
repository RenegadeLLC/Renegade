jQuery(document).ready(function(e) {
	jQuery('#mip-form .image-select input:radio').addClass('input_hidden');
	jQuery('#mip-form .image-select label').click(function(){
	jQuery(this).addClass('selected').siblings().removeClass('selected');
});
jQuery('#waq-generate').on('click',function(){
	waq_data = jQuery('form.waq-data').serializeArray();
	//alert(ecs_data);
	var shortcode='[wpajax ';
	jQuery.each(waq_data, function(i, field){
	if(field.name=='waq_options_group[layout]') shortcode += 'layout ="'+field.value+'" ';
	if(field.name=='waq_options_group[col_width]') shortcode += 'col_width ="'+field.value+'" ';
	if(field.name=='waq_options_group[ajax_style]') shortcode += 'ajax_style ="'+field.value+'" ';
	
	if(field.name=='waq_options_group[button_label]') shortcode += 'button_label ="'+field.value+'" ';
	if(field.name=='waq_options_group[button_text_color]') shortcode += 'button_text_color ="'+field.value+'" ';
	if(field.name=='waq_options_group[button_bg_color]') shortcode += 'button_bg_color ="'+field.value+'" ';
	if(field.name=='waq_options_group[button_font]') shortcode += 'button_font ="'+field.value+'" ';
	if(field.name=='waq_options_group[button_size]') shortcode += 'button_size ="'+field.value+'" ';
	if(field.name=='waq_options_group[button_icon]') shortcode += 'button_icon ="'+field.value+'" ';
	
	if(field.name=='waq_options_group[loading_image]') shortcode += 'loading_image ="'+field.value+'" ';
	
	if(field.name=='waq_options_group[thumb_size]') shortcode += 'thumb_size ="'+field.value+'" ';
	if(field.name=='waq_options_group[post_title_color]') shortcode += 'post_title_color ="'+field.value+'" ';
	if(field.name=='waq_options_group[post_title_font]') shortcode += 'post_title_font ="'+field.value+'" ';
	if(field.name=='waq_options_group[post_title_size]') shortcode += 'post_title_size ="'+field.value+'" ';
	
	if(field.name=='waq_options_group[post_excerpt_color]') shortcode += 'post_excerpt_color ="'+field.value+'" ';
	if(field.name=='waq_options_group[post_excerpt_font]') shortcode += 'post_excerpt_font ="'+field.value+'" ';
	if(field.name=='waq_options_group[post_excerpt_size]') shortcode += 'post_excerpt_size ="'+field.value+'" ';
	
	if(field.name=='waq_options_group[post_meta_color]') shortcode += 'post_meta_color ="'+field.value+'" ';
	if(field.name=='waq_options_group[post_meta_font]') shortcode += 'post_meta_font ="'+field.value+'" ';
	if(field.name=='waq_options_group[post_meta_size]') shortcode += 'post_meta_size ="'+field.value+'" ';
	
	if(field.name=='waq_options_group[thumb_hover_icon]') shortcode += 'thumb_hover_icon ="'+field.value+'" ';
	if(field.name=='waq_options_group[thumb_hover_color]') shortcode += 'thumb_hover_color ="'+field.value+'" ';
	if(field.name=='waq_options_group[thumb_hover_bg]') shortcode += 'thumb_hover_bg ="'+field.value+'" ';
	if(field.name=='waq_options_group[thumb_hover_popup]') shortcode += 'thumb_hover_popup ="'+field.value+'" ';
	if(field.name=='waq_options_group[popup_theme]') shortcode += 'popup_theme ="'+field.value+'" ';
	
	if(field.name=='waq_options_group[border_hover_color]') shortcode += 'border_hover_color ="'+field.value+'" ';
	if(field.name=='waq_options_group[border_hover_width]') shortcode += 'border_hover_width ="'+field.value+'" ';

	//if(field.name=='waq_options_group[ecs_cat]') shortcode += 'cat ="'+field.value.join(',')+'" ';
	if(field.name=='waq_options_group[tag]') shortcode += 'tag ="'+field.value+'" ';
	//if(field.name=='waq_options_group[ecs_post_type]') shortcode += 'post_type ="'+field.value+'" ';
	if(field.name=='waq_options_group[orderby]') shortcode += 'orderby ="'+field.value+'" ';
	if(field.name=='waq_options_group[order]') shortcode += 'order ="'+field.value+'" ';
	if(field.name=='waq_options_group[posts_per_page]') shortcode += 'posts_per_page ="'+field.value+'" ';
});
	var catIDs = jQuery('.ecs_cat_checkbox input:checked').map(function(){
		return jQuery(this).val();
	}).get();
	shortcode += 'cat ="'+catIDs.join(',')+'" ';
	var posttypes = jQuery('.ecs_posttype_checkbox input:checked').map(function(){
		return jQuery(this).val();
	}).get();
	shortcode += 'post_type ="'+posttypes.join(',')+'" ';
	//var rtl = (jQuery('.ecs_rtl_checkbox input:checked').val()=='1')?1:0;
	//shortcode += 'rtl ="'+rtl+'" ';
	shortcode += '/]';
	jQuery('#shortcode-area').val(shortcode).fadeIn('slow');
		return false;
	});
});