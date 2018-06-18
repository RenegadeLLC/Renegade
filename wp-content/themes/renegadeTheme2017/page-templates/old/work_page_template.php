<?php
/**
 * Template Name: Work Page Template
 *
 *
 * @package Renegade
 * @subpackage Renegade
 * @since 2015
 */

get_header(); ?>

<script>

</script>


<?php
//VARIABLE THAT HOLDS PRIMARY CONTENT HTML
$sidebarHTML = '';


//IF THERE IS SIDEBAR CONTENT RENDER IT

if($wk_sidebar == 'Yes'){

	//$wk_sidebar_html = '<div class="sidebar-left">';
	//$wk_sidebar_html .=  $wk_sidebar_content;
	//echo $wk_sidebar_html . '</div>';
}

//GET THE CUSTOM FIELD VARIABLES
$wk_header = get_field('header');
$wk_subheader = get_field('subheader');
$wk_intro_content = get_field('intro_copy');

	
//START HTML BUILD

	$workHTML .= '<div class="work-page"><div class="content-wrapper" style="background:#fff; overflow:hidden; padding-bottom:64px;">';
	$workHTML .= '<div class="headline-ct">';
	
	if($wk_header){
		$workHTML .= '<h1>'. $wk_header . '</h1>';
	}
	
	if($wk_subheader){
		$workHTML .= '<h2>'. $wk_subheader . '</h2>';
	}
	
	$workHTML .= '</div>';//END headline-ct
	
	
	$workHTML .= '<div class="clearfix"></div>';
	
//BUILD CONTENT SECTIONS

		$workHTML .= '<div class="content-diag brdr">';
		$workHTML .= '<div class="section" id="' . $section_name . '"><div class="saw-sep"></div>';
		$workHTML .= '<div class="section-inner">'; 
	
		$workHTML .= '<div class="one-col">';
	
		
			if($wk_intro_content){
				$workHTML .= $wk_intro_content;
			}
	
		$workHTML .= '</div>';//END ONE COLUMN DIV, one col inner and section-content


$workHTML .= '</div></div></div>';//end content-diag, section-inner, section

//QUERY CLIENTS POST TYPES FOR LOGO GRID
$workHTML .='<h2 style="text-align:center; padding:0px;">A Selecton of Clients Served</h2><h3 style="text-align:center;">(Past & Present)</h3>';
$workHTML .= '<div class="client-logo-grid"><div id="freewall">';
$rc_args = array( 'post_type' => 'clients', 'posts_per_page' => -1 , 'orderby' => 'meta_value', 'meta_key' => $meta_key, 'order' => 'ASC');
$rc_loop = new WP_Query( $rc_args );

	while ( $rc_loop->have_posts() ) : $rc_loop->the_post();
		$client_id = get_the_ID();
		$client_logo = get_field('client_logo');
		$workHTML .= '<div class="client-logo-ct circ"><div class="client-logo-border"></div><div class="client-logo"><img src="' . $client_logo . '" alt=""></div></div>';
	endwhile;
	
	$workHTML .= '</div></div>';

echo $workHTML;

?>

</div><!-- .content-wrapper -->
</div><!-- .company -->
<script type="text/javascript">
$(function() {

	$("#freewal2l").each(function() {
		
		var wall = new freewall(this);
		wall.reset({
			selector: '.client-logo-ct',
			cellW: 'auto',
			cellH: 'auto',
			fixSize: 0,
			gutterY: 16,
			gutterX: 16,
			onResize: function() {
				wall.fitWidth();
			}
		});
		wall.fitWidth();
	});
	$(window).trigger("resize");
});
		</script>
<?php get_footer(); ?>