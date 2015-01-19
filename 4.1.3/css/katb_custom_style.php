<?php
/**
 * Custom testimonial display styles in content area
 *
 * This file is called by katb_add_custom_styles() in testimonial-basics.php.
 * It loads the custom styles used in the content display area 
 *
 * @package		Testimonial Basics WordPress Plugin
 * @copyright	Copyright (c) 2012, Kevin Archibald
 * @license		http://www.gnu.org/licenses/quick-guide-gplv3.html  GNU Public License
 * @author		Kevin Archibald <www.kevinsspace.ca/contact/>
 */

/* Get the user choices for the plugin options */
$katb_options = katb_get_options(); ?>
	
<style type="text/css" >
	/* ================================================================
	 *          Testimonial Basics Custom Styles
	 * ================================================================ */
	/* content custom styles
	 * ---------------------------------------------------------------- */
	<?php if ( $katb_options['katb_use_italic_style'] == 1 ) { ?>
		.katb_test_text,.katb_test_text_basic {font-style: italic;}
	<?php } ?>
	
	.katb_test_box,.katb_test_box_basic,
	.katb_test_box_side_meta,.katb_test_box_basic_side_meta,
	.katb_test_box_side_meta,.katb_test_box_basic_side_meta,
	.katb_schema_summary_box_basic,.katb_schema_summary_box_basic_side_meta,
	.katb_schema_summary_box,.katb_schema_summary_box_side_meta,
	.katb_paginate
	{ font-size: <?php echo $katb_options['katb_content_font_size']; ?>; }

	<?php if ($katb_options['katb_content_font'] != 'default font') { ?>
		.katb_test_wrap *,.katb_test_wrap_basic *,
		.katb_test_wrap_side_meta *,.katb_test_wrap_basic_side_meta *,
		.katb_popup_wrap.katb_content *,.katb_paginate *
		.katb_schema_summary_wrap *,.katb_schema_summary_wrap *
		{ font-family: <?php echo $katb_options['katb_content_font']; ?> }
	<?php } else { ?>
		.katb_test_wrap *,.katb_test_wrap_basic *,
		.katb_test_wrap_side_meta *,.katb_test_wrap_basic_side_meta *,
		.katb_popup_wrap.katb_content *,
		.katb_schema_summary_wrap *,.katb_paginate *
		{ font-family: inherit; }
	<?php } ?>
	
	.katb_test_wrap,.katb_schema_summary_wrap,
	.katb_test_wrap_side_meta .katb_left_box,
	.katb_schema_summary_box_side_meta .katb_schema_company_wrap_side_meta
	{
		background-color: <?php echo $katb_options['katb_background_wrap_color']; ?>;
		color: <?php echo $katb_options['katb_testimonial_box_font_color']; ?>;
	}
	
	.katb_test_box,.katb_schema_summary_box,
	.katb_test_wrap_side_meta .katb_right_box,
	.katb_schema_summary_box_side_meta .katb_aggregate_wrap_side_meta,
	.katb_test_text *
	{
		background-color: <?php echo $katb_options['katb_testimonial_box_color']; ?>;
		color: <?php echo $katb_options['katb_testimonial_box_font_color']; ?>;
	}
	
	.katb_test_text h1,.katb_test_text h2,
	.katb_test_text h3,.katb_test_text h4,.katb_test_text h5,.katb_test_text h6 {
		color: <?php echo $katb_options['katb_testimonial_box_font_color']; ?>!important;
	}
	
	/*author,location, and date custom colors */
	.katb_test_box .katb_author,.katb_test_box_side_meta .katb_author,
	.katb_test_box .katb_date,.katb_test_box_side_meta .katb_date,
	.katb_test_box .katb_location,.katb_test_box_side_meta .katb_location
	{color: <?php echo $katb_options['katb_author_location_color']; ?>!important;}
	
	.katb_test_box a,.katb_schema_summary_box a,.katb_test_box_side_meta a,
	.katb_schema_summary_box_side_meta a
	{color: <?php echo $katb_options['katb_website_link_color']; ?>!important;}
	.katb_test_box a:hover,.katb_schema_summary_box a:hover ,.katb_test_box_side_meta a:hover,
	.katb_schema_summary_box_side_meta a:hover
	{color: <?php echo $katb_options['katb_website_link_hover_color']; ?>!important;}
	
	.katb_paginate input {
		background-color: <?php echo $katb_options['katb_testimonial_box_color']; ?>!important;
		color: <?php echo $katb_options['katb_testimonial_box_font_color']; ?>!important;
		font-size: <?php echo $katb_options['katb_content_font_size']; ?>!important;
	}
	
	.katb_input_style 
	{font-size: <?php echo $katb_options['katb_content_input_font_size']; ?>!important;}

	/* Widget Display Custom Styles
	 * -------------------------------------------------- */
	<?php if ( $katb_options['katb_widget_use_italic_style'] == 1 ) { ?>
		.katb_widget_text,.katb_widget_text_basic {font-style: italic;}
	<?php } ?>
	
	.katb_widget_box,.katb_widget_box_basic,
	.katb_widget_rotator_box,.katb_widget_rotator_box_basic
	{font-size: <?php echo $katb_options['katb_widget_font_size']; ?>;}
	
	<?php if ( $katb_options['katb_widget_font'] != 'default font' ) { ?>
		.katb_widget_wrap *,.katb_widget_wrap_basic *,
		.katb_widget_rotator_wrap *,.katb_widget_rotator_wrap_basic *,
		.katb_popup_wrap.katb_widget *
		{ font-family: <?php echo $katb_options['katb_widget_font']; ?>; }
	<?php } else { ?>
		.katb_widget_wrap *,.katb_widget_wrap_basic *,
		.katb_widget_rotator_wrap *,.katb_widget_rotator_wrap_basic *,
		.katb_popup_wrap.katb_widget *
		{ font-family: inherit; }
	<?php } ?>

	.katb_widget_rotator_wrap,.katb_widget_box {
		background-color: <?php echo $katb_options['katb_widget_background_color']; ?>;
	}
	
	.katb_widget_title_bar,.katb_widget_text * {
		color: <?php echo $katb_options['katb_widget_font_color']; ?>!important;
	}
	
	
	.katb_widget_box .katb_widget_meta_bottom,.katb_widget_box .katb_widget_meta_top,
	.katb_widget_box .katb_widget_meta_above_or_below,.katb_widget_rotator_box .katb_widget_meta_bottom,
	.katb_widget_rotator_box .katb_widget_meta_top,.katb_widget_rotator_box .katb_widget_meta_above_or_below 
		{color: <?php echo $katb_options['katb_widget_author_location_color']; ?>;}
	.katb_widget_box a,.katb_widget_rotator_box a 
		{color: <?php echo $katb_options['katb_widget_website_link_color']; ?>!important;}
	.katb_widget_box a:hover,.katb_widget_rotator_box a:hover 
		{color: <?php echo $katb_options['katb_widget_website_link_hover_color']; ?>!important;}
	
	/* divider color */
	.katb_widget_box .katb_image_meta_bottom,
	.katb_widget_rotator_box .katb_image_meta_bottom,
	.katb_widget_box .katb_centered_image_meta_bottom,
	.katb_widget_rotator_box .katb_centered_image_meta_bottom
	{border-top: 1px solid <?php echo $katb_options['katb_widget_divider_color']; ?>}
	
	.katb_widget_box .katb_image_meta_top,
	.katb_widget_rotator_box .katb_image_meta_top,
	.katb_widget_box .katb_centered_image_meta_top,
	.katb_widget_rotator_box .katb_centered_image_meta_top
	{border-bottom: 1px solid <?php echo $katb_options['katb_widget_divider_color']; ?>}
	
	/* Widget Input Form
	 * ------------------------------------------------------------------------ */ 
	.katb_widget_form {
		font-size: <?php echo $katb_options['katb_widget_input_font_size']; ?>!important;
	}
	
	/* Other Custom Styles
	 * ---------------------------------------------------------------- */
	<?php if( $katb_options['katb_use_css_ratings'] == 1 ){
			
		$shadow_color = katb_hex_to_rgba( $katb_options[ 'katb_star_shadow_color']); ?>
			
		.katb_css_rating i { 
			color: <?php echo $katb_options['katb_star_color']; ?>!important;
			text-shadow: 2px 2px 2px rgba( <?php echo $shadow_color[0]; ?>, <?php echo $shadow_color[1]; ?>, <?php echo $shadow_color[2]; ?>, 0.5)!important;
		}
		
	<?php } ?>
		
</style>