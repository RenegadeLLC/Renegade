<?php
//[foobar]

function foobar_func( $atts ){
 return "foo and bar";
}
add_shortcode( 'foobar', 'foobar_func' );

?>

<?php
//[foobar]

function onehalf1_func( $atts ){
 
}
add_shortcode( 'one_half1', 'onehalf1_func' );

?>