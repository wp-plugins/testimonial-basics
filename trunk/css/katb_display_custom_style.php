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
$katb_options = katb_get_options();
if( $katb_options['katb_use_formatted_display'] == 1 ) { ?>
	
	<style type="text/css" >
	
		<?php if ( $katb_options['katb_use_italic_style'] == 1 ) { ?>
				.katb_test_text,.katb_test_text_basic {font-style: italic;}
		<?php } ?>
		
		.katb_test_box,
		.katb_popup_wrap.katb_content,
		.katb_schema_summary_box,
		.katb_input_style
		{font-size: <?php echo $katb_options['katb_content_font_size']; ?>!important;}
		
		<?php if ($katb_options['katb_content_font'] != 'default font') { ?>
				.katb_test_wrap,.katb_test_wrap h1,.katb_test_wrap h2,.katb_test_wrap h3,.katb_test_wrap h4,.katb_test_wrap h5,.katb_test_wrap h6,
				.katb_popup_wrap.katb_content,.katb_popup_wrap.katb_content h1,.katb_popup_wrap.katb_content h2,.katb_popup_wrap.katb_content h3,
				.katb_popup_wrap.katb_content h4,.katb_popup_wrap.katb_content h5,.katb_popup_wrap.katb_content h6,
				.katb_schema_summary_wrap,.katb_paginate input
				{ font-family: <?php echo $katb_options['katb_content_font']; ?>!important; }
		<?php } else { ?>
			.katb_test_wrap,.katb_test_wrap h1,.katb_test_wrap h2,.katb_test_wrap h3,.katb_test_wrap h4,.katb_test_wrap h5,.katb_test_wrap h6,
				.katb_popup_wrap.katb_content,.katb_popup_wrap.katb_content h1,.katb_popup_wrap.katb_content h2,.katb_popup_wrap.katb_content h3,
				.katb_popup_wrap.katb_content h4,.katb_popup_wrap.katb_content h5,.katb_popup_wrap.katb_content h6,
				.katb_schema_summary_wrap,.katb_paginate input
				{ font-family: inherit; }
		<?php } ?>
		
		.katb_test_wrap,.katb_schema_summary_wrap {
			background-color: <?php echo $katb_options['katb_background_wrap_color']; ?>;
		}
		
		.katb_test_box,.katb_schema_summary_box {
			background-color: <?php echo $katb_options['katb_testimonial_box_color']; ?>;
			color: <?php echo $katb_options['katb_testimonial_box_font_color']; ?>;
		}
		
		.katb_author,.katb_date,.katb_location,.katb_website,.katb_title,.katb_meta_top,.katb_meta_bottom
		{color: <?php echo $katb_options['katb_author_location_color']; ?>;}
		.katb_test_box a,.katb_schema_summary_box a {color: <?php echo $katb_options['katb_website_link_color']; ?>!important;}
		.katb_test_box a:hover,.katb_schema_summary_box a:hover {color: <?php echo $katb_options['katb_website_link_hover_color']; ?>!important;}
		
		.katb_paginate input {
			background-color: <?php echo $katb_options['katb_testimonial_box_color']; ?>!important;
			color: <?php echo $katb_options['katb_testimonial_box_font_color']; ?>!important;
			font-size: <?php echo $katb_options['katb_content_font_size']; ?>!important;
		}
		
	</style>
	
<?php } else { ?>
	
	<style type="text/css" >
	
		<?php if( $katb_options['katb_use_italic_style'] == 1 ) { ?>
			.katb_test_text_basic {font-style: italic;} 
		<?php } ?>
		
		.katb_paginate input { font-family: inherit!important;}
		
		.katb_test_box_basic,
		.katb_popup_wrap.katb_content,
		.katb_schema_summary_box_basic,
		.katb_paginate input
		{font-size: <?php echo $katb_options['katb_content_font_size']; ?>!important;}
		
	</style>
	
<?php } ?>

<!-- Input Form Custom Styles -->
<style type="text/css" >

	.katb_input_style {
		font-size: <?php echo $katb_options['katb_content_input_font_size']; ?>!important;
	}

</style>