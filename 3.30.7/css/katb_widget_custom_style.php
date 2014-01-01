<?php
/**
 * Custom testimonial display styles in widget area
 *
 * This file is called by katb_add_custom_styles() in testimonial-basics.php.
 * It loads the custom styles used in the widget display area 
 *
 * @package		Testimonial Basics WordPress Plugin
 * @copyright	Copyright (c) 2012, Kevin Archibald
 * @license		http://www.gnu.org/licenses/quick-guide-gplv3.html  GNU Public License
 * @author		Kevin Archibald <www.kevinsspace.ca/contact/>
 */

/* Get the user choices for the plugin options */
$katb_options = katb_get_options();
if( $katb_options['katb_widget_use_formatted_display'] ==1 ) { ?>
	
	<style type="text/css" >
	
		<?php if ( $katb_options['katb_widget_use_italic_style'] == 1 ) { ?>
			.katb_widget_text {font-style: italic;}
		<?php } ?>
		
		.katb_widget_box,
		.katb_widget_rotator_box,
		.katb_popup_wrap.katb_widget 
		{font-size: <?php echo $katb_options['katb_widget_font_size']; ?>!important;}
		
		<?php if ( $katb_options['katb_widget_font'] != 'default font' ) { ?>
			.katb_widget_box,.katb_widget_box h1,.katb_widget_box h2,.katb_widget_box h3,
			.katb_widget_box h4,.katb_widget_box h5,.katb_widget_box h6,
			.katb_popup_wrap.katb_content,.katb_popup_wrap.katb_content h1,.katb_popup_wrap.katb_content h2,.katb_popup_wrap.katb_content h3,
			.katb_popup_wrap.katb_content h4,.katb_popup_wrap.katb_content h5,.katb_popup_wrap.katb_content h6, {
					font-family: <?php echo $katb_options['katb_widget_font']; ?>;
			}
		<?php } ?>
		
		.katb_widget_rotator_wrap,.katb_widget_box {
			background-color: <?php echo $katb_options['katb_widget_background_color']; ?>;
			color: <?php echo $katb_options['katb_widget_font_color']; ?>;
		}
		
		.katb_widget_meta {color: <?php echo $katb_options['katb_widget_author_location_color']; ?>;}
		.katb_widget_box a {color: <?php echo $katb_options['katb_widget_website_link_color']; ?>!important;}
		.katb_widget_box a:hover {color: <?php echo $katb_options['katb_widget_website_link_hover_color']; ?>!important;}

	</style>
<?php } else { ?>
	
	<style type="text/css" >
	
		<?php if ( $katb_options['katb_widget_use_italic_style'] == 1 ) { ?>
				.katb_widget_text {font-style: italic;}
		<?php } ?>
		
		.katb_widget_box_basic,
		.katb_widget_rotator_box_basic,
		.katb_popup_wrap.katb_widget
		{font-size: <?php echo $katb_options['katb_widget_font_size'];?>; }
		
	</style>
	
<?php } ?>

<!-- Other Custom Formats -->
<style type="text/css" >
	.katb_widget_form {
		font-size: <?php echo $katb_options['katb_widget_input_font_size']; ?>!important;
	}
</style>