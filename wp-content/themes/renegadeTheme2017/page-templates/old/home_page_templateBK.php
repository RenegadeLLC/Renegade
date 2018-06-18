<?php
/**
 * Template Name:BK Home Page Template
 *
 *
 * @package Renegade
 * @subpackage Renegade
 * @since 2014
 */

get_header(); ?>

<?php 
$company_slides;
$work_slides;
$news_slides;
$blog_slides;

$num_company_slides = 0;
$num_work_slides = 0;
$num_news_slides = 0;
$num_blog_slides = 0;
// check if the repeater field has rows of data
if( have_rows('home_section') ):

// loop through the rows of data
while ( have_rows('home_section') ) : the_row();

	$hm_slide_category = get_sub_field('hm_slide_category');
	$hm_slide_name = get_sub_field('hm_slide_name');
	$hm_slide_name = get_sub_field('hm_slide_name');
	$hm_slide_layout = get_sub_field('hm_slide_layout');
	$hm_one_column_content = get_sub_field('hm_one_column_content');
	$hm_left_column_content = get_sub_field('hm_left_column_content');
	$hm_right_column_content = get_sub_field('hm_right_column_content');

	


	switch ($hm_slide_category) {
		
		case 'Company';
		if($hm_slide_layout == 'One Column'){
			
		$company_slides .= '<div class="one-col">' . $hm_one_column_content . '</div>';
		
		$num_company_slides ++;
	
	} else if($hm_slide_layout == 'Two Columns'){
	
		$company_slides .= '<div class="left-col">' . $hm_left_column_content . '</div><div class="right-col">' . $hm_right_column_content . '</div>';
		$num_company_slides ++;
	}
	
		
		break;
		
		case 'Work';
		if($hm_slide_layout == 'One Column'){
	
		$work_slides .= '<div class="one-col">' . $hm_one_column_content . '</div>';
	
	} else if($hm_slide_layout == 'Two Columns'){
	
		$work_slides .= '<div class="left-col">' . $hm_left_column_content . '</div><div class="right-col">' . $hm_right_column_content . '</div>';
	
	}
		break;
		
		case 'News';
		
		if($hm_slide_layout == 'One Column'){
		
			$news_slides .= '<div class="one-col">' . $hm_one_column_content . '</div>';
		
		} else if($hm_slide_layout == 'Two Columns'){
		
			$news_slides .= '<div class="left-col">' . $hm_left_column_content . '</div><div class="right-col">' . $hm_right_column_content . '</div>';
		
		}
		
		break;
		
		case 'Blog';
			if($hm_slide_layout == 'One Column'){
	
		$blog_slides .= '<div class="one-col">' . $hm_one_column_content . '</div>';
	
	} else if($hm_slide_layout == 'Two Columns'){
	
		$blog_slides .= '<div class="left-col">' . $hm_left_column_content . '</div><div class="right-col">' . $hm_right_column_content . '</div>';
	
	}
		break;
	}
	



	
	endwhile;
	
	else :
	
	// no rows found
	
	endif;
	


?>

<div class="home-row bk-green">
<div class="content-wrapper" style="background:#fff; overflow:hidden; padding-bottom:64px;">
<?php 
echo $company_slides;
?>
</div><!-- .content-wrapper -->
</div><!-- .home-row -->

<div class="home-row bk-red">
<div class="content-wrapper" style="background:#fff; overflow:hidden; padding-bottom:64px;">
<?php  echo $work_slides;?>
</div><!-- .content-wrapper -->
</div><!-- .home-row -->

<div class="home-row bk-blue">
<div class="content-wrapper" style="background:#fff; overflow:hidden; padding-bottom:64px;">
<?php echo $news_slides;?>
</div><!-- .content-wrapper -->
</div><!-- .home-row -->

<div class="home-row bk-pink">
<div class="content-wrapper" style="background:#fff; overflow:hidden; padding-bottom:64px;">
<?php echo $blog_slides;?>
</div><!-- .content-wrapper -->
</div><!-- .home-row -->


<?php get_footer(); ?>