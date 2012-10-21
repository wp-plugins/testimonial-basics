<?php
/**
 * This is the admin file for Testimonial Basics
 *
 * @package		Testimonial Basics WordPress Plugin
 * @copyright	Copyright (c) 2012, Kevin Archibald
 * @license		http://www.gnu.org/licenses/quick-guide-gplv3.html  GNU Public License
 * @author		Kevin Archibald <www.kevinsspace.ca/contact/>
 */
/**
 * Get Testimonial Basics Plugin Options
 * 
 * Array that holds all of the defined values
 * for Testimonial Basics Plugin Options. If the user 
 * has not specified a value for a given Theme 
 * option, then the option's default value is
 * used instead.
 *
 * @uses	katb_get_option_defaults()	defined below
 * 
 * @uses	get_option()
 * @uses	wp_parse_args()
 * 
 * @return	array	$katb_options	current values for all Theme options
 */
function katb_get_options() {

	// Get the option defaults
	$katb_option_defaults = katb_get_option_defaults();
	// Globalize the variable that holds the Theme options
	global $katb_options;
	// Parse the stored options with the defaults
	$katb_options = wp_parse_args( get_option( 'katb_testimonial_basics_options', array() ), $katb_option_defaults );
	// Return the parsed array
	return $katb_options;
}

/**
 * Get Testimonial Basics Plugin Option Defaults
 * 
 * Array that holds all of the deault values
 * for Testimonial Basics Plugin Options. 
 *
 * @uses	katb_get_option_parameters()	defined below
 * 
 * 
 * @return	array	$katb_option_defaults	current default values for all Theme options
 */
function katb_get_option_defaults() {
	// Get the array that holds all
	// Theme option parameters
	$katb_option_parameters = katb_get_option_parameters();
	// Initialize the array to hold
	// the default values for all
	// Theme options
	$katb_option_defaults = array();
	// Loop through the option
	// parameters array
	foreach ( $katb_option_parameters as $katb_option_parameter ) {
		$name = $katb_option_parameter['name'];
		// Add an associative array key
		// to the defaults array for each
		// option in the parameters array
		$katb_option_defaults[$name] = $katb_option_parameter['default'];
	}
	// Return the defaults array
	return $katb_option_defaults;
}

/**
 * Get Testimonial Basics Plugin Option Parameters
 * 
 * Array that holds all of the parameters
 * for Testimonial Basics Plugin Options. 
 *
 * @return	array	$options	all elements for each option
 */
function katb_get_option_parameters() {
	
	$options = array (
/* -------------------------Input Form -------------------------------------- */
		'katb_use_captcha' => array(
			'name' => 'katb_use_captcha',
			'title' => __( 'Use captcha on input forms' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => __('Check to include captcha.','testimonial-basics'),
			'section' => 'input',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),				
		'katb_include_input_title' => array(
			'name' => 'katb_include_input_title',
			'title' => __( 'Include title on input form' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => __('Check to include','testimonial-basics'),
			'section' => 'input',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_input_title' => array(
			'name' => 'katb_input_title',
			'title' => __('Title for Input Form','testimonial-basics'),
			'type' => 'text',
			'description' => __('Default:Add a Testimonial','testimonial-basics'),
			'section' => 'input',
			'default' => 'Add a Testimonial',
			'class' => 'nohtml'
		),			
		'katb_include_email_note' => array(
			'name' => 'katb_include_email_note',
			'title' => __( 'Include email not kept note' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => __('Check to include','testimonial-basics'),
			'section' => 'input',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_email_note' => array(
			'name' => 'katb_email_note',
			'title' => __('Email note','testimonial-basics'),
			'type' => 'text',
			'description' => __('Default:Email is not kept','testimonial-basics'),
			'section' => 'input',
			'default' => 'Email is not kept',
			'class' => 'nohtml'
		),			
// Content Display
		'katb_show_website' => array(
			'name' => 'katb_show_website',
			'title' => __( 'Show website in testimonial' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => __('Check to include website','testimonial-basics'),
			'section' => 'content',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_show_date' => array(
			'name' => 'katb_show_date',
			'title' => __( 'Show date in testimonial' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => __('Check to include date','testimonial-basics'),
			'section' => 'content',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_show_location' => array(
			'name' => 'katb_show_location',
			'title' => __( 'Show location in testimonial' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => __('Check to include location','testimonial-basics'),
			'section' => 'content',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_use_formatted_display' => array(
			'name' => 'katb_use_formatted_display',
			'title' => __( 'Use formatted display' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => __('Check to include','testimonial-basics'),
			'section' => 'content',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),		
		'katb_content_font' => array(
			'name' => 'katb_content_font',
			'title' => __('Font for Content Display','testimonial-basics'),
			'type' => 'select',
			'valid_options' => array( 
				"Georgia, serif",
				"Verdana, Geneva, sans-serif", 
				"Arial, Helvetica, sans-serif",
				"'Book Antiqua', 'Palatino Linotype', Palatino, serif",
				"Cambria, Georgia, serif",
				"'Comic Sans MS', sans-serif",
				"Tahoma, Geneva, sans-serif",
				"'Times New Roman', Times, serif",
				"'Trebuchet MS', Helvetica, sans-serif"									
			),
			'description' => __('default: Verdana','testimonial-basics'),
			'section' => 'content',
			'default' => 'Georgia, serif',
			'class' => 'select'
		), 			
		'katb_background_wrap_color' => array(
			'name' => 'katb_background_wrap_color',
			'title' => __('Background Wrap Color','testimonial-basics'),
			'type' => 'text',
			'description' => __('default: #EDEDED','testimonial-basics'),
			'section' => 'content',
			'default' => '#EDEDED',
			'class' => 'hexcolor'
		),
		'katb_testimonial_box_color' => array(
			'name' => 'katb_testimonial_box_color',
			'title' => __('Testimonial Box Color','testimonial-basics'),
			'type' => 'text',
			'description' => __('default: #DBDBDB','testimonial-basics'),
			'section' => 'content',
			'default' => '#DBDBDB',
			'class' => 'hexcolor'
		),
		'katb_testimonial_box_font_color' => array(
			'name' => 'katb_testimonial_box_font_color',
			'title' => __('Testimonial Box Font Color','testimonial-basics'),
			'type' => 'text',
			'description' => __('default: #000000','testimonial-basics'),
			'section' => 'content',
			'default' => '#000000',
			'class' => 'hexcolor'
		),		
		'katb_author_location_color' => array(
			'name' => 'katb_author_location_color',
			'title' => __('Author,Location, and Date Color','testimonial-basics'),
			'type' => 'text',
			'description' => __('default: #000000','testimonial-basics'),
			'section' => 'content',
			'default' => '#000000',
			'class' => 'hexcolor'
		),		
		'katb_website_link_color' => array(
			'name' => 'katb_website_link_color',
			'title' => __('Website Link Color','testimonial-basics'),
			'type' => 'text',
			'description' => __('default: #3384E8','testimonial-basics'),
			'section' => 'content',
			'default' => '#3384E8',
			'class' => 'hexcolor'
		),
		'katb_website_link_hover_color' => array(
			'name' => 'katb_website_link_hover_color',
			'title' => __('Website Link Hover Color','testimonial-basics'),
			'type' => 'text',
			'description' => __('default: #FFFFFF','testimonial-basics'),
			'section' => 'content',
			'default' => '#FFFFFF',
			'class' => 'hexcolor'
		),
//Widget
		'katb_widget_show_website' => array(
			'name' => 'katb_widget_show_website',
			'title' => __( 'Show website in widget' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => __('Check to include website','testimonial-basics'),
			'section' => 'widget',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_widget_show_date' => array(
			'name' => 'katb_widget_show_date',
			'title' => __( 'Show date in widget' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => __('Check to include date','testimonial-basics'),
			'section' => 'widget',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_widget_show_location' => array(
			'name' => 'katb_widget_show_location',
			'title' => __( 'Show location in widget' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => __('Check to include location','testimonial-basics'),
			'section' => 'widget',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_widget_use_formatted_display' => array(
			'name' => 'katb_widget_use_formatted_display',
			'title' => __( 'Use formatted display' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => __('Check to include','testimonial-basics'),
			'section' => 'widget',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),		
		'katb_widget_font' => array(
			'name' => 'katb_widget_font',
			'title' => __('Font for Widget Display','testimonial-basics'),
			'type' => 'select',
			'valid_options' => array( 
				"Georgia, serif",				
				"Verdana, Geneva, sans-serif", 
				"Arial, Helvetica, sans-serif",
				"'Book Antiqua', 'Palatino Linotype', Palatino, serif",
				"Cambria, Georgia, serif",
				"'Comic Sans MS', sans-serif",
				"Tahoma, Geneva, sans-serif",
				"'Times New Roman', Times, serif",
				"'Trebuchet MS', Helvetica, sans-serif"									
			),
			'description' => __('default: Verdana','testimonial-basics'),
			'section' => 'widget',
			'default' => 'Georgia, serif',
			'class' => 'select'
		),
		'katb_widget_background_color' => array(
			'name' => 'katb_widget_background_color',
			'title' => __('Background Color','testimonial-basics'),
			'type' => 'text',
			'description' => __('default: #EDEDED','testimonial-basics'),
			'section' => 'widget',
			'default' => '#EDEDED',
			'class' => 'hexcolor'
		),
		'katb_widget_font_color' => array(
			'name' => 'katb_widget_font_color',
			'title' => __('Font Color','testimonial-basics'),
			'type' => 'text',
			'description' => __('default: #000000','testimonial-basics'),
			'section' => 'widget',
			'default' => '#000000',
			'class' => 'hexcolor'
		),
		'katb_widget_author_location_color' => array(
			'name' => 'katb_widget_author_location_color',
			'title' => __('Author,Location, and Date Color','testimonial-basics'),
			'type' => 'text',
			'description' => __('default: #000000','testimonial-basics'),
			'section' => 'widget',
			'default' => '#000000',
			'class' => 'hexcolor'
		),
		'katb_widget_website_link_color' => array(
			'name' => 'katb_widget_website_link_color',
			'title' => __('Website Link Color','testimonial-basics'),
			'type' => 'text',
			'description' => __('default: #3384E8','testimonial-basics'),
			'section' => 'widget',
			'default' => '#3384E8',
			'class' => 'hexcolor'
		),
		'katb_widget_website_link_hover_color' => array(
			'name' => 'katb_widget_website_link_hover_color',
			'title' => __('Website Link Hover Color','testimonial-basics'),
			'type' => 'text',
			'description' => __('default: #FFFFFF','testimonial-basics'),
			'section' => 'widget',
			'default' => '#FFFFFF',
			'class' => 'hexcolor'
		),																																				
	);
		
    return apply_filters( 'blogBox_get_option_parameters', $options );
}

/**katb_testimonial_basics_display_in_code()
 * 
 * This function allows you to use display testinonials in code
 * 
 * It accepts arguments just like in the shortcode and displays accordingly
 *
 * by: order or date
 * number: all or a number
 * id: random or id of the testimonial
 * 
 * 
 * @return	html_string
 */
 function katb_testimonial_basics_display_in_code($by,$number,$id){
 	//set up database table name for later use
	global $wpdb,$tablename;
	$tablename = $wpdb->prefix.'testimonial_basics';
	//get user options
	$katb_options = katb_get_options();
	//Initialize Strings
	$katb_html = '';
	$katb_error = "";
	//validate
	if($by != 'date' && $by != 'order') $by = 'date';
	if($number != 'all' && is_numeric($number) == false ) $number = 'all';
	if($id != 'random' && is_numeric($id) == false) $id = '';
	//Validate $by
	if ( $number == 'all' && $id == '' && $by == 'date' ) {
		$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' ORDER BY `tb_date` DESC ",ARRAY_A);
		$katb_tnumber = $wpdb->num_rows;
		if ( $katb_tnumber == 0 ) $katb_error = __('There are no approved testimonials to display!','testimonial_basics');
	} elseif ( $number == 'all' && $id == '' && $by == 'order' ) {
		$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' ORDER BY `tb_order` DESC,`tb_date` DESC ",ARRAY_A);
		$katb_tnumber = $wpdb->num_rows;
		if ( $katb_tnumber == 0 ) $katb_error = __('There are no approved testimonials to display!','testimonial_basics');
	} elseif ( intval($number) > 0 && $id == '' && $by == 'date' ) {
		$number = intval( $number );
		$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' ORDER BY `tb_date` DESC LIMIT 0,$number ",ARRAY_A);
		$katb_tnumber = $wpdb->num_rows;
		if ( $katb_tnumber == 0 ) $katb_error = __('There are no approved testimonials to display!','testimonial_basics');
	} elseif ( intval($number) > 0 && $id == '' && $by == 'order' ) {
		$number = intval( $number );
		$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' ORDER BY `tb_order` DESC,`tb_date` DESC LIMIT 0,$number ",ARRAY_A);
		$katb_tnumber = $wpdb->num_rows;
		if ( $katb_tnumber == 0 ) $katb_error = __('There are no approved testimonials to display!','testimonial_basics');
	} elseif ($id != '' ) {
		if ( $id == 'random' ) {
			$katb_tdata2 = $wpdb->get_results( " SELECT `tb_id` FROM `$tablename` WHERE `tb_approved` = '1' ",ARRAY_A);
			$katb_tnumber = $wpdb->num_rows;				
			if ( $katb_tnumber == 0 ) {
				$katb_error = __('There are no approved testimonials to display!','testimonial_basics');
			} else {	

				$rand = rand(0, $katb_tnumber-1);
				$random_id = $katb_tdata2[$rand]['tb_id'];
				$katb_tdata = $wpdb->get_results("SELECT * FROM `$tablename` WHERE `tb_approved` = '1' AND `tb_id` = $random_id ",ARRAY_A );
				$katb_tnumber = $wpdb->num_rows;
			}
		} elseif (intval($id != '')) {
			$id = intval($id);
			$katb_tdata = $wpdb->get_results("SELECT * FROM `$tablename` WHERE `tb_approved` = '1' AND `tb_id` = $id ",ARRAY_A );
			$katb_tnumber = $wpdb->num_rows;
			if ( $katb_tnumber == 0 ) $katb_error = __('Testimonial not found. Please check your shortcode.','testimonial_basics');
		} else {
			//$id is an unknown
			$katb_error = __('Testimonial not found. Please check your shortcode.','testimonial_basics');
		}
		
	} else {
		// something did not work
		$katb_error =  __('Testimonial not found. Please check your shortcode.','testimonial_basics');
	}
	// Database queried
	//Lets prepare the return string
	if( $katb_error != '') {
		$katb_html = '<div class="katb_error">'.$katb_error.'</div>';
	} else {
		for ( $i = 0 ; $i < $katb_tnumber; $i++ ) {
				$katb_html .= '<p class="katb_p_test">'.stripcslashes($katb_tdata[$i]['tb_testimonial']).'</p>';
				$katb_html .= '<p class="katb_p_authorstrip"><b>'.stripcslashes($katb_tdata[$i]['tb_name']).'</b>';
			if ($katb_options['katb_show_date'] == 1) {
				$katb_date = $katb_tdata[$i]['tb_date'];
				$year = intval(substr($katb_date,0,4));
				$month = intval(substr($katb_date,5,2));
				$monthname = date("M", mktime(0, 0, 0, $month, 10));
				$day = intval(substr($katb_date,8,2));
				$katb_html .= ', '.$monthname.' '.$day.'\''.$year;
			}
			if ($katb_options['katb_show_location'] == 1) {
				if ( $katb_tdata[$i]['tb_location'] != "" ) $katb_html .= ', '.stripcslashes($katb_tdata[$i]['tb_location']);
			}
			if ($katb_options['katb_show_website'] == 1) {
				if ( $katb_tdata[$i]['tb_url'] != "" ) $katb_html .= ', <a href="'.esc_url($katb_tdata[$i]['tb_url']).'" title="Testimonial_author_site" >'.$katb_tdata[$i]['tb_url'].'</a>';
			}
			$katb_html .= '</p>';
		}
		
	}	
	return $katb_html;
}