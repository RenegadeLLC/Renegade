<?php
function renegade_customize_register( $wp_customize ) {
	//All our sections, settings, and controls will be added here
	
	//CUSTOMIZE COLORS
	
	$colors = array();
	
	$colors[] = array(
	'slug'=>'content_text_color', 
	'default' => '#333',
	'label' => __('Content Text Color', 'renegade')
	);
	
	$colors[] = array(
	'slug'=>'content_link_color', 
	'default' => '#88C34B',
	'label' => __('Content Link Color', 'renegade')
	);

	foreach( $colors as $color ) {
	
	// SETTINGS
	$wp_customize->add_setting(
		$color['slug'], array(
			'default' => $color['default'],
			'type' => 'option', 
			'capability' => 
			'edit_theme_options'
		)
	);
	
	// CONTROLS
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			$color['slug'], 
			array('label' => $color['label'], 
			'section' => 'colors',
			'settings' => $color['slug'])
		)
	);
	
	}/*end for each*/


/********* FOOTER TEXT ***********/

	$wp_customize->add_section(
        'footerSection',
        array(
            'title' => 'Footer',
            'description' => 'This is a settings section.',
            'priority' => 35,
        )
    );
	
	$wp_customize->add_setting(
    'copyright_textbox',
    array(
        'default' => '&#169;',
    )
	);
	
	$wp_customize->add_control(
    'copyright_textbox',
    array(
        'label' => 'Copyright text',
        'section' => 'footerSection',
        'type' => 'text',
    )
	);
	
/********* PHONE NUMBER ***********/

	$wp_customize->add_section(
        'phone',
        array(
            'title' => 'Telephone Number',
            'description' => '',
            'priority' => 35,
        )
    );
	
	$wp_customize->add_setting(
    'phone_number',
    array(
        'default' => '',
    )
	);
	
	$wp_customize->add_control(
    'phone_number',
    array(
        'label' => 'Telephone Number',
        'section' => 'phone',
        'type' => 'text',
    )
	);
	
	

/********* SOCIAL LINKS ***********/

	$wp_customize->add_section('socialLinks', array(
            'title' => 'Social Media Links',
            'description' => 'Select which social media channels to display and assign links.',
            'priority' => 35,
        )
    	);
	
	
	$wp_customize->add_setting('facebook',array(
        'default' => '',
    )
	);
	
	$wp_customize->add_control( 'facebook', array(
    'label' => 'Facebook',
    'type' => 'text',
    'section' => 'socialLinks',
	) );


	$wp_customize->add_setting(
    'twitter',
    array(
        'default' => '',
    )
	);
	
	$wp_customize->add_control( 'twitter', array(
    'label' => 'Twitter',
    'type' => 'text',
    'section' => 'socialLinks',
	) );


	$wp_customize->add_setting(
    'instagram',
    array(
        'default' => '',
    )
	);
	
	$wp_customize->add_control( 'instagram', array(
    'label' => 'Instagram',
    'type' => 'text',
    'section' => 'socialLinks',
	) );


	$wp_customize->add_setting(
    'pinterest',
    array(
        'default' => '',
    )
	);
	
	$wp_customize->add_control( 'pinterest', array(
    'label' => 'Pinterest',
    'type' => 'text',
    'section' => 'socialLinks',
	) );

	
	$wp_customize->add_setting(
    'youTube',
    array(
        'default' => '',
    )
	);
	
	$wp_customize->add_control( 'youTube', array(
    'label' => 'YouTube',
    'type' => 'text',
    'section' => 'socialLinks',
	) );


	$wp_customize->add_setting(
    'googlePlus',
    array(
        'default' => '',
    )
	);
	
	$wp_customize->add_control( 'googlePlus', array(
    'label' => 'Google+',
    'type' => 'text',
    'section' => 'socialLinks',
	) );


	$wp_customize->add_setting(
    'linkedIn',
    array(
        'default' => '',
    )
	);
	
	$wp_customize->add_control( 'linkedIn', array(
    'label' => 'Linked In',
    'type' => 'text',
    'section' => 'socialLinks',
	) );


	$wp_customize->add_setting(
    'slideShare',
    array(
        'default' => '',
    )
	);
	
	$wp_customize->add_control( 'slideShare', array(
    'label' => 'Slideshare',
    'type' => 'text',
    'section' => 'socialLinks',
	) );

}/* end customizer function */

add_action( 'customize_register', 'renegade_customize_register' );
?>