<?php
/**
 * Custom testimonial display styles in widget area
 *
 * This file is called by katb_functions.php and loads the user selections for background and text colors
 *
 * @package		Testimonial Basics WordPress Plugin
 * @copyright	Copyright (c) 2012, Kevin Archibald
 * @license		http://www.gnu.org/licenses/quick-guide-gplv3.html  GNU Public License
 * @author		Kevin Archibald <www.kevinsspace.ca/contact/>
 */

/* Get the user choices for the plugin options */
$katb_options = katb_get_options();
?>
<style type="text/css" >
	.katb_widget_test_wrap {
		font-family: <?php echo $katb_options['katb_widget_font']; ?>;
		background-color: <?php echo $katb_options['katb_widget_background_color']; ?>;
		color: <?php echo $katb_options['katb_widget_font_color']; ?>;
	}
	.katb_widget_test_meta {color: <?php echo $katb_options['katb_widget_author_location_color']; ?>;}
	.katb_widget_test_meta a {color: <?php echo $katb_options['katb_widget_website_link_color']; ?>!important;}
	.katb_widget_test_wrap a:hover {color: <?php echo $katb_options['katb_widget_website_link_hover_color']; ?>!important;}
</style>