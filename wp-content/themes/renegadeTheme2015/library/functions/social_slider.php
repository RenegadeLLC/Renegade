<?php

/**
Plugin Name: WordPress Social Slider Plugin
Version: 1.0
Author: Anne Rothschild
Copyright: 2013 Renegade
**/

function social_slider(){
	//return do_shortcode('[foobar]');
	//return "SOCIAL SLIDER GOES HERE";
	
	//loadFB('27090525088');
	

$facebook = new Facebook(array(
  'appId'  => '<499207920147796>',
  'secret' => '<c55774fd928a6b4f9db4637ac3b1c45f>'
));

$query = 'SELECT post_id, message, permalink, likes, type, created_time FROM stream WHERE source_id = <27090525088> AND actor_id = <27090525088> LIMIT 3';
$facebook_data = $facebook->api(array(
                           'method' => 'fql.query',
                           'query' => $query,
                        ));
}

add_shortcode( 'socialSlider', 'social_slider' );
 
 
 ?>