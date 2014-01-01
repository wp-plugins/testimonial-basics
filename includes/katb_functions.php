<?php
/**
 * This file holds many of the functions used in Testimonial Basics
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
/* ------------------------- General -------------------------------------- */
		'katb_admin_access_level' => array(
			'name' => 'katb_admin_access_level',
			'title' => __('User role to edit testimonials','testimonial-basics'),
			'type' => 'select',
			'valid_options' => array(
				"Administrator", 
				"Editor"
			),
			'description' => __('default: Administrator','testimonial-basics'),
			'section' => 'general',
			'tab' => 'general',
			'default' => 'Administrator',
			'class' => 'select'
		),
		'katb_contact_email' => array(
			'name' => 'katb_contact_email',
			'title' => __('Testimonial notify email address','testimonial-basics'),
			'type' => 'text',
			'description' => __('Leave blank to use admin email','testimonial-basics'),
			'section' => 'general',
			'tab' => 'general',
			'default' => '',
			'class' => 'email'
		),
		'katb_use_ratings' => array(
			'name' => 'katb_use_ratings',
			'title' => __('Use Ratings','testimonial-basics'),
			'type' => 'checkbox',
			'description' => __('Use 5 star rating system','testimonial-basics'),
			'section' => 'general',
			'tab' => 'general',
			'default' => 0,
			'class' => 'checkbox'
		),
		'katb_enable_rotator' => array(
			'name' => 'katb_enable_rotator',
			'title' => __('Enable the testimonial rotator script','testimonial-basics'),
			'type' => 'checkbox',
			'description' => __('Default: checked','testimonial-basics'),
			'section' => 'general',
			'tab' => 'general',
			'default' => 1,
			'class' => 'checkbox'
		),
		//Schema Markup
		'katb_use_schema' => array(
			'name' => 'katb_use_schema',
			'title' => __( 'Use schema markup' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => __('Schema markup is used for Google Snippets to help SEO','testimonial-basics'),
			'section' => 'schema',
			'tab' => 'general',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_schema_company_name' => array(
			'name' => 'katb_schema_company_name',
			'title' => __('Schema Company Name','testimonial-basics'),
			'type' => 'text',
			'description' => __('Name of Company the testimonials are about.','testimonial-basics'),
			'section' => 'schema',
			'tab' => 'general',
			'default' => '',
			'class' => 'nohtml'
		),
		'katb_schema_company_url' => array(
			'name' => 'katb_schema_company_url',
			'title' => __('Schema Company Website Reference','testimonial-basics'),
			'type' => 'text',
			'description' => __('Company website address ','testimonial-basics'),
			'section' => 'schema',
			'tab' => 'general',
			'default' => '',
			'class' => 'url'
		),
		'katb_schema_display_company' => array(
			'name' => 'katb_schema_display_company',
			'title' => __( 'Schema Display Company', 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => __('Display company name and website','testimonial-basics'),
			'section' => 'schema',
			'tab' => 'general',
			'default' =>1, // 0 for off
			'class' => 'checkbox'
		),
		'katb_schema_display_aggregate' => array(
			'name' => 'katb_schema_display_aggregate',
			'title' => __( 'Schema Display Aggregate', 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => __('Display a summary of reviews','testimonial-basics'),
			'section' => 'schema',
			'tab' => 'general',
			'default' =>1, // 0 for off
			'class' => 'checkbox'
		),
		'katb_schema_display_reviews' => array(
			'name' => 'katb_schema_display_reviews',
			'title' => __( 'Schema Display Reviews', 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => __('Select to display the individual reviews','testimonial-basics'),
			'section' => 'schema',
			'tab' => 'general',
			'default' =>1, // 0 for off
			'class' => 'checkbox'
		),
		'katb_use_group_name_for_aggregate' => array(
			'name' => 'katb_use_group_name_for_aggregate',
			'title' => __( 'Use Group Name for Aggregate Name', 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => __('Select to use the Group Name','testimonial-basics'),
			'section' => 'schema',
			'tab' => 'general',
			'default' =>1, // 0 for off
			'class' => 'checkbox'
		),
		'katb_custom_aggregate_review_name' => array(
			'name' => 'katb_custom_aggregate_review_name',
			'title' => __('Custom Aggregate Review Name','testimonial-basics'),
			'type' => 'text',
			'description' => __('Enter a name for the aggregate review','testimonial-basics'),
			'section' => 'schema',
			'tab' => 'general',
			'default' => '',
			'class' => 'nohtml'
		),
		'katb_individual_group_name' => array(
			'name' => 'katb_individual_group_name',
			'title' => __( 'Group Individual Review Name', 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => __('Use group name for individual review name','testimonial-basics'),
			'section' => 'schema',
			'tab' => 'general',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_individual_custom_name' => array(
			'name' => 'katb_individual_custom_name',
			'title' => __('Custom Individual Review Name','testimonial-basics'),
			'type' => 'text',
			'description' => __('If not using the Group Name, enter one here','testimonial-basics'),
			'section' => 'schema',
			'tab' => 'general',
			'default' => '',
			'class' => 'nohtml'
		),
/* ------------------------- Input Form Options -------------------------------------- */
		'katb_use_captcha' => array(
			'name' => 'katb_use_captcha',
			'title' => __( 'Use captcha on input forms' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => __('Check to include captcha.','testimonial-basics'),
			'section' => 'general',
			'tab' => 'input',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_use_color_captcha' => array(
			'name' => 'katb_use_color_captcha',
			'title' => __( 'Use color captcha option' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => __('Check to use the color captcha option','testimonial-basics'),
			'section' => 'general',
			'tab' => 'input',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_exclude_website_input' => array(
			'name' => 'katb_exclude_website_input',
			'title' => __('Exclude Website in input form','testimonial-basics'),
			'type' => 'checkbox',
			'description' => __('Default: unchecked','testimonial-basics'),
			'section' => 'general',
			'tab' => 'input',
			'default' => 0,
			'class' => 'checkbox'
		),
		'katb_exclude_location_input' => array(
			'name' => 'katb_exclude_location_input',
			'title' => __('Exclude Location in input form','testimonial-basics'),
			'type' => 'checkbox',
			'description' => __('Default: unchecked','testimonial-basics'),
			'section' => 'general',
			'tab' => 'input',
			'default' => 0,
			'class' => 'checkbox'
		),
		'katb_include_email_note' => array(
			'name' => 'katb_include_email_note',
			'title' => __( 'Include email note' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => __('Check to include','testimonial-basics'),
			'section' => 'general',
			'tab' => 'input',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_email_note' => array(
			'name' => 'katb_email_note',
			'title' => __('Email note','testimonial-basics'),
			'type' => 'text',
			'description' => __('Default:Email is not published','testimonial-basics'),
			'section' => 'general',
			'tab' => 'input',
			'default' => 'Email is not published',
			'class' => 'nohtml'
		),
		'katb_content_input_font_size' => array(
			'name' => 'katb_content_input_font_size',
			'title' => __('Base Font size','testimonial-basics'),
			'type' => 'select',
			'valid_options' => array(
				"0.625em",
				"0.75em", 
				"0.875em",
				"1em",
				"1.125em",
				"1.25em",
				"1.375em"
			),
			'description' => __('1em is equal to 16px','testimonial-basics'),
			'section' => 'content_input_form',
			'tab' => 'input',
			'default' => '1em',
			'class' => 'select'
		),
		'katb_include_input_title' => array(
			'name' => 'katb_include_input_title',
			'title' => __( 'Include title on input form' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => __('Check to include','testimonial-basics'),
			'section' => 'content_input_form',
			'tab' => 'input',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_input_title' => array(
			'name' => 'katb_input_title',
			'title' => __('Title for Input Form','testimonial-basics'),
			'type' => 'text',
			'description' => __('Default:Add a Testimonial','testimonial-basics'),
			'section' => 'content_input_form',
			'tab' => 'input',
			'default' => 'Add a Testimonial',
			'class' => 'nohtml'
		),			
		'katb_show_html_content' => array(
			'name' => 'katb_show_html_content',
			'title' => __('Show html allowed strip in input form','testimonial-basics'),
			'type' => 'checkbox',
			'description' => __('Default: checked','testimonial-basics'),
			'section' => 'content_input_form',
			'tab' => 'input',
			'default' => 1,
			'class' => 'checkbox'
		),
		'katb_author_label' => array(
			'name' => 'katb_author_label',
			'title' => __('Author Label','testimonial-basics'),
			'type' => 'text',
			'description' => __('Default: Author*','testimonial-basics'),
			'section' => 'content_input_form',
			'tab' => 'input',
			'default' => 'Author *',
			'class' => 'nohtml'
		),
		'katb_email_label' => array(
			'name' => 'katb_email_label',
			'title' => __('Email Label','testimonial-basics'),
			'type' => 'text',
			'description' => __('Default: Email*','testimonial-basics'),
			'section' => 'content_input_form',
			'tab' => 'input',
			'default' => 'Email *',
			'class' => 'nohtml'
		),
		'katb_website_label' => array(
			'name' => 'katb_website_label',
			'title' => __('Website Label','testimonial-basics'),
			'type' => 'text',
			'description' => __('Default: Website','testimonial-basics'),
			'section' => 'content_input_form',
			'tab' => 'input',
			'default' => 'Website',
			'class' => 'nohtml'
		),
		'katb_location_label' => array(
			'name' => 'katb_location_label',
			'title' => __('Location Label','testimonial-basics'),
			'type' => 'text',
			'description' => __('Default: Location','testimonial-basics'),
			'section' => 'content_input_form',
			'tab' => 'input',
			'default' => 'Location',
			'class' => 'nohtml'
		),
		'katb_rating_label' => array(
			'name' => 'katb_rating_label',
			'title' => __('Rating Label','testimonial-basics'),
			'type' => 'text',
			'description' => __('Default: Rating','testimonial-basics'),
			'section' => 'content_input_form',
			'tab' => 'input',
			'default' => 'Rating',
			'class' => 'nohtml'
		),
		'katb_testimonial_label' => array(
			'name' => 'katb_testimonial_label',
			'title' => __('Testimonial Label','testimonial-basics'),
			'type' => 'text',
			'description' => __('Default: Testimonial*','testimonial-basics'),
			'section' => 'content_input_form',
			'tab' => 'input',
			'default' => 'Testimonial *',
			'class' => 'nohtml'
		),
		'katb_submit_label' => array(
			'name' => 'katb_submit_label',
			'title' => __('Submit Label','testimonial-basics'),
			'type' => 'text',
			'description' => __('Default: Submit','testimonial-basics'),
			'section' => 'content_input_form',
			'tab' => 'input',
			'default' => 'Submit',
			'class' => 'nohtml'
		),
		'katb_reset_label' => array(
			'name' => 'katb_reset_label',
			'title' => __('Reset Label','testimonial-basics'),
			'type' => 'text',
			'description' => __('Default: Reset','testimonial-basics'),
			'section' => 'content_input_form',
			'tab' => 'input',
			'default' => 'Reset',
			'class' => 'nohtml'
		),
		'katb_required_label' => array(
			'name' => 'katb_required_label',
			'title' => __('Required Label','testimonial-basics'),
			'type' => 'text',
			'description' => __('Default: * Required','testimonial-basics'),
			'section' => 'content_input_form',
			'tab' => 'input',
			'default' => '* Required',
			'class' => 'nohtml'
		),
/* ------------------------- Widget Input Form -------------------------------------- */		
		'katb_widget_input_font_size' => array(
			'name' => 'katb_widget_input_font_size',
			'title' => __('Base Font size','testimonial-basics'),
			'type' => 'select',
			'valid_options' => array(
				"0.625em",
				"0.75em", 
				"0.875em",
				"1em",
				"1.125em",
				"1.25em",
				"1.375em"
			),
			'description' => __('1em is equal to 16px','testimonial-basics'),
			'section' => 'widget_input_form',
			'tab' => 'input',
			'default' => '1em',
			'class' => 'select'
		),
		'katb_show_html_widget' => array(
			'name' => 'katb_show_html_widget',
			'title' => __('Show html allowed strip in widget form','testimonial-basics'),
			'type' => 'checkbox',
			'description' => __('Default: not checked','testimonial-basics'),
			'section' => 'widget_input_form',
			'tab' => 'input',
			'default' => 0,
			'class' => 'checkbox'
		),
		'katb_widget_group_label' => array(
			'name' => 'katb_widget_group_label',
			'title' => __('Group Label','testimonial-basics'),
			'type' => 'text',
			'description' => __('Default: Group','testimonial-basics'),
			'section' => 'widget_input_form',
			'tab' => 'input',
			'default' => 'Group',
			'class' => 'nohtml'
		),
		'katb_widget_author_label' => array(
			'name' => 'katb_widget_author_label',
			'title' => __('Widget Author Label','testimonial-basics'),
			'type' => 'text',
			'description' => __('Default: Author-Required','testimonial-basics'),
			'section' => 'widget_input_form',
			'tab' => 'input',
			'default' => 'Author-Required',
			'class' => 'nohtml'
		),
		'katb_widget_email_label' => array(
			'name' => 'katb_widget_email_label',
			'title' => __('Widget Email Label','testimonial-basics'),
			'type' => 'text',
			'description' => __('Default: Email-Required','testimonial-basics'),
			'section' => 'widget_input_form',
			'tab' => 'input',
			'default' => 'Email-Required',
			'class' => 'nohtml'
		),
		'katb_widget_website_label' => array(
			'name' => 'katb_widget_website_label',
			'title' => __('Widget Website Label','testimonial-basics'),
			'type' => 'text',
			'description' => __('Default: Website-Optional','testimonial-basics'),
			'section' => 'widget_input_form',
			'tab' => 'input',
			'default' => 'Website-Optional',
			'class' => 'nohtml'
		),
		'katb_widget_location_label' => array(
			'name' => 'katb_widget_location_label',
			'title' => __('Widget Location Label','testimonial-basics'),
			'type' => 'text',
			'description' => __('Default: Location-Optional','testimonial-basics'),
			'section' => 'widget_input_form',
			'tab' => 'input',
			'default' => 'Location-Optional',
			'class' => 'nohtml'
		),
		'katb_widget_rating_label' => array(
			'name' => 'katb_widget_rating_label',
			'title' => __('Widget Rating Label','testimonial-basics'),
			'type' => 'text',
			'description' => __('Default: Rating-Optional','testimonial-basics'),
			'section' => 'widget_input_form',
			'tab' => 'input',
			'default' => 'Rating-Optional',
			'class' => 'nohtml'
		),
		'katb_widget_testimonial_label' => array(
			'name' => 'katb_widget_testimonial_label',
			'title' => __('Widget Testimonial Label','testimonial-basics'),
			'type' => 'text',
			'description' => __('Default: Testimonial-Required','testimonial-basics'),
			'section' => 'widget_input_form',
			'tab' => 'input',
			'default' => 'Testimonial-Required',
			'class' => 'nohtml'
		),
		'katb_widget_submit_label' => array(
			'name' => 'katb_widget_submit_label',
			'title' => __('Widget Submit Label','testimonial-basics'),
			'type' => 'text',
			'description' => __('Default: Submit','testimonial-basics'),
			'section' => 'widget_input_form',
			'tab' => 'input',
			'default' => 'Submit',
			'class' => 'nohtml'
		),
		'katb_widget_reset_label' => array(
			'name' => 'katb_widget_reset_label',
			'title' => __('Widget Reset Label','testimonial-basics'),
			'type' => 'text',
			'description' => __('Default: Reset','testimonial-basics'),
			'section' => 'widget_input_form',
			'tab' => 'input',
			'default' => 'Reset',
			'class' => 'nohtml'
		),
// Content Display
		'katb_layout_option' => array(
			'name' => 'katb_layout_option',
			'title' => __('Layout Option','testimonial-basics'),
			'type' => 'select',
			'valid_options' => array(
				"Bottom Meta",
				"Top Meta" 
			),
			'description' => __('Try them to see what you prefer','testimonial-basics'),
			'section' => 'content_general',
			'tab' => 'content_display',
			'default' => 'Bottom Meta',
			'class' => 'select'
		),
		'katb_content_font_size' => array(
			'name' => 'katb_content_font_size',
			'title' => __('Base Font size','testimonial-basics'),
			'type' => 'select',
			'valid_options' => array(
				"0.625em",
				"0.75em", 
				"0.875em",
				"1em",
				"1.125em",
				"1.25em",
				"1.375em"
			),
			'description' => __('1em is equal to 16px','testimonial-basics'),
			'section' => 'content_general',
			'tab' => 'content_display',
			'default' => '1em',
			'class' => 'select'
		),
		'katb_use_pagination' => array(
			'name' => 'katb_use_pagination',
			'title' => __( 'Use pagination' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => __('Check to include for ALL or ALL GROUP displays.','testimonial-basics'),
			'section' => 'content_general',
			'tab' => 'content_display',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_paginate_number' => array(
			'name' => 'katb_paginate_number',
			'title' => __('Testimonials per page','testimonial-basics'),
			'type' => 'select',
			'valid_options' => array(
				"3",
				"5", 
				"10"
			),
			'description' => __('select 3, 5 or 10 per page','testimonial-basics'),
			'section' => 'content_general',
			'tab' => 'content_display',
			'default' => '10',
			'class' => 'select'
		),
		'katb_use_excerpts' => array(
			'name' => 'katb_use_excerpts',
			'title' => __( 'Use excerpts in testimonial display' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => __('Check to include','testimonial-basics'),
			'section' => 'content_general',
			'tab' => 'content_display',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_excerpt_length' => array(
			'name' => 'katb_excerpt_length',
			'title' => __('Excerpt length in characters','testimonial-basics'),
			'type' => 'text',
			'description' => __('default: 400','testimonial-basics'),
			'section' => 'content_general',
			'tab' => 'content_display',
			'default' => '400',
			'class' => 'nohtml'
		),
		'katb_show_title' => array(
			'name' => 'katb_show_title',
			'title' => __( 'Show title in testimonial' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => __('Use schema name options without the schema','testimonial-basics'),
			'section' => 'content_general',
			'tab' => 'content_display',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_show_website' => array(
			'name' => 'katb_show_website',
			'title' => __( 'Show website in testimonial' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => __('Check to include website','testimonial-basics'),
			'section' => 'content_general',
			'tab' => 'content_display',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_show_date' => array(
			'name' => 'katb_show_date',
			'title' => __( 'Show date in testimonial' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => __('Check to include date','testimonial-basics'),
			'section' => 'content_general',
			'tab' => 'content_display',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_show_location' => array(
			'name' => 'katb_show_location',
			'title' => __( 'Show location in testimonial' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => __('Check to include location','testimonial-basics'),
			'section' => 'content_general',
			'tab' => 'content_display',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_use_gravatars' => array(
			'name' => 'katb_use_gravatars',
			'title' => __( 'Use gravatars' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => __('Check to include','testimonial-basics'),
			'section' => 'content_general',
			'tab' => 'content_display',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_use_gravatar_substitute' => array(
			'name' => 'katb_use_gravatar_substitute',
			'title' => __( 'Use gravatar substitute' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => __('Use substitute if gravatar unavailable','testimonial-basics'),
			'section' => 'content_general',
			'tab' => 'content_display',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_gravatar_size' => array(
			'name' => 'katb_gravatar_size',
			'title' => __('Gravatar size','testimonial-basics'),
			'type' => 'select',
			'valid_options' => array(
				"60",
				"70", 
				"80",
				"90",
				"100"
			),
			'description' => __('Select a size for the gravatar','testimonial-basics'),
			'section' => 'content_general',
			'tab' => 'content_display',
			'default' => '80',
			'class' => 'select'
		),
		'katb_use_italic_style' => array(
			'name' => 'katb_use_italic_style',
			'title' => __( 'Use italic font style' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => __('Check to include','testimonial-basics'),
			'section' => 'content_general',
			'tab' => 'content_display',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
//Rotator
		'katb_rotator_speed' => array(
			'name' => 'katb_rotator_speed',
			'title' => __('Time between slides','testimonial-basics'),
			'type' => 'select',
			'valid_options' => array(
				'4000',
				'5000',
				'6000',
				'7000',
				'8000',
				'9000',
				'10000',
				'11000',
				'12000',
				'13000',
				'14000'
			),
			'description' => __('default: 7000 ms','testimonial-basics'),
			'section' => 'content_rotator',
			'tab' => 'content_display',
			'default' => '7000',
			'class' => 'select'
		),
		'katb_rotator_height' => array(
			'name' => 'katb_rotator_height',
			'title' => __('Rotator height in pixels','testimonial-basics'),
			'type' => 'select',
			'valid_options' => array(
				'variable',
				'50',
				'100',
				'150',
				'200',
				'250',
				'300',
				'350'
			),
			'description' => __('default: variable','testimonial-basics'),
			'section' => 'content_rotator',
			'tab' => 'content_display',
			'default' => 'variable',
			'class' => 'select'
		),
		'katb_rotator_transition' => array(
			'name' => 'katb_rotator_transition',
			'title' => __('Rotator transition effect','testimonial-basics'),
			'type' => 'select',
			'valid_options' => array(
				'fade',
				'left to right',
				'right to left'
			),
			'description' => __('default: fade','testimonial-basics'),
			'section' => 'content_rotator',
			'tab' => 'content_display',
			'default' => 'fade',
			'class' => 'select'
		),	
		'katb_use_formatted_display' => array(
			'name' => 'katb_use_formatted_display',
			'title' => __( 'Use formatted display' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => __('Check to include','testimonial-basics'),
			'section' => 'content_custom_formats',
			'tab' => 'content_display',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),		
		'katb_content_font' => array(
			'name' => 'katb_content_font',
			'title' => __('Font for Content Display','testimonial-basics'),
			'type' => 'select',
			'valid_options' => array(
				"default font", 
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
			'section' => 'content_custom_formats',
			'tab' => 'content_display',
			'default' => 'default font',
			'class' => 'select'
		), 			
		'katb_background_wrap_color' => array(
			'name' => 'katb_background_wrap_color',
			'title' => __('Background Wrap Color','testimonial-basics'),
			'type' => 'text',
			'description' => __('default: #EDEDED','testimonial-basics'),
			'section' => 'content_custom_formats',
			'tab' => 'content_display',
			'default' => '#EDEDED',
			'class' => 'hexcolor'
		),
		'katb_testimonial_box_color' => array(
			'name' => 'katb_testimonial_box_color',
			'title' => __('Testimonial Box Color','testimonial-basics'),
			'type' => 'text',
			'description' => __('default: #DBDBDB','testimonial-basics'),
			'section' => 'content_custom_formats',
			'tab' => 'content_display',
			'default' => '#DBDBDB',
			'class' => 'hexcolor'
		),
		'katb_testimonial_box_font_color' => array(
			'name' => 'katb_testimonial_box_font_color',
			'title' => __('Testimonial Box Font Color','testimonial-basics'),
			'type' => 'text',
			'description' => __('default: #000000','testimonial-basics'),
			'section' => 'content_custom_formats',
			'tab' => 'content_display',
			'default' => '#000000',
			'class' => 'hexcolor'
		),		
		'katb_author_location_color' => array(
			'name' => 'katb_author_location_color',
			'title' => __('Author,Location, and Date Color','testimonial-basics'),
			'type' => 'text',
			'description' => __('default: #000000','testimonial-basics'),
			'section' => 'content_custom_formats',
			'tab' => 'content_display',
			'default' => '#000000',
			'class' => 'hexcolor'
		),		
		'katb_website_link_color' => array(
			'name' => 'katb_website_link_color',
			'title' => __('Website Link Color','testimonial-basics'),
			'type' => 'text',
			'description' => __('default: #3384E8','testimonial-basics'),
			'section' => 'content_custom_formats',
			'tab' => 'content_display',
			'default' => '#3384E8',
			'class' => 'hexcolor'
		),
		'katb_website_link_hover_color' => array(
			'name' => 'katb_website_link_hover_color',
			'title' => __('Website Link Hover Color','testimonial-basics'),
			'type' => 'text',
			'description' => __('default: #FFFFFF','testimonial-basics'),
			'section' => 'content_custom_formats',
			'tab' => 'content_display',
			'default' => '#FFFFFF',
			'class' => 'hexcolor'
		),
//Widget
		'katb_widget_layout_option' => array(
			'name' => 'katb_widget_layout_option',
			'title' => __('Widget Layout Option','testimonial-basics'),
			'type' => 'select',
			'valid_options' => array(
				"Bottom Meta",
				"Top Meta" 
			),
			'description' => __('Try them to see what you prefer','testimonial-basics'),
			'section' => 'widget_general',
			'tab' => 'widget_display',
			'default' => 'Bottom Meta',
			'class' => 'select'
		),
		'katb_widget_font_size' => array(
			'name' => 'katb_widget_font_size',
			'title' => __('Base Font size','testimonial-basics'),
			'type' => 'select',
			'valid_options' => array(
				"0.625em",
				"0.75em", 
				"0.875em",
				"1em",
				"1.125em",
				"1.25em",
				"1.375em"
			),
			'description' => __('1em is equal to 16px','testimonial-basics'),
			'section' => 'widget_general',
			'tab' => 'widget_display',
			'default' => '1em',
			'class' => 'select'
		),
		'katb_widget_use_excerpts' => array(
			'name' => 'katb_widget_use_excerpts',
			'title' => __( 'Use excerpts in widget testimonial display' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => __('Check to include','testimonial-basics'),
			'section' => 'widget_general',
			'tab' => 'widget_display',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_widget_excerpt_length' => array(
			'name' => 'katb_widget_excerpt_length',
			'title' => __('Widget excerpt length in characters','testimonial-basics'),
			'type' => 'text',
			'description' => __('default: 250','testimonial-basics'),
			'section' => 'widget_general',
			'tab' => 'widget_display',
			'default' => '250',
			'class' => 'nohtml'
		),
		'katb_widget_show_title' => array(
			'name' => 'katb_widget_show_title',
			'title' => __( 'Show title in testimonial' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => __('Use schema name options without the schema','testimonial-basics'),
			'section' => 'widget_general',
			'tab' => 'widget_display',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_widget_show_website' => array(
			'name' => 'katb_widget_show_website',
			'title' => __( 'Show website in widget' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => __('Check to include website','testimonial-basics'),
			'section' => 'widget_general',
			'tab' => 'widget_display',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_widget_show_date' => array(
			'name' => 'katb_widget_show_date',
			'title' => __( 'Show date in widget' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => __('Check to include date','testimonial-basics'),
			'section' => 'widget_general',
			'tab' => 'widget_display',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_widget_show_location' => array(
			'name' => 'katb_widget_show_location',
			'title' => __( 'Show location in widget' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => __('Check to include location','testimonial-basics'),
			'section' => 'widget_general',
			'tab' => 'widget_display',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_widget_use_gravatars' => array(
			'name' => 'katb_widget_use_gravatars',
			'title' => __( 'Use gravatars' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => __('Check to include','testimonial-basics'),
			'section' => 'widget_general',
			'tab' => 'widget_display',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_widget_use_gravatar_substitute' => array(
			'name' => 'katb_widget_use_gravatar_substitute',
			'title' => __( 'Use gravatar substitute' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => __('Use substitute if Gravatar unavailable','testimonial-basics'),
			'section' => 'widget_general',
			'tab' => 'widget_display',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_widget_gravatar_size' => array(
			'name' => 'katb_widget_gravatar_size',
			'title' => __('Gravatar size','testimonial-basics'),
			'type' => 'select',
			'valid_options' => array(
				"60",
				"70", 
				"80",
				"90",
				"100"
			),
			'description' => __('Select a size for the gravatar','testimonial-basics'),
			'section' => 'widget_general',
			'tab' => 'widget_display',
			'default' => '60',
			'class' => 'select'
		),
		'katb_widget_use_italic_style' => array(
			'name' => 'katb_widget_use_italic_style',
			'title' => __( 'Use italic font style' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => __('Check to include','testimonial-basics'),
			'section' => 'widget_general',
			'tab' => 'widget_display',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),
		'katb_widget_rotator_speed' => array(
			'name' => 'katb_widget_rotator_speed',
			'title' => __('Widget time between slides','testimonial-basics'),
			'type' => 'select',
			'valid_options' => array(
				'4000',
				'5000',
				'6000',
				'7000',
				'8000',
				'9000',
				'10000',
				'11000',
				'12000',
				'13000',
				'14000'
			),
			'description' => __('default: 7000 ms','testimonial-basics'),
			'section' => 'widget_rotator',
			'tab' => 'widget_display',
			'default' => '7000',
			'class' => 'select'
		),
		'katb_widget_rotator_height' => array(
			'name' => 'katb_widget_rotator_height',
			'title' => __('Widget rotator height in pixels','testimonial-basics'),
			'type' => 'select',
			'valid_options' => array(
				'variable',
				'50',
				'100',
				'150',
				'200',
				'250',
				'300',
				'350'
			),
			'description' => __('default: variable','testimonial-basics'),
			'section' => 'widget_rotator',
			'tab' => 'widget_display',
			'default' => 'variable',
			'class' => 'select'
		),
		'katb_widget_rotator_transition' => array(
			'name' => 'katb_widget_rotator_transition',
			'title' => __('Widget rotator transition effect','testimonial-basics'),
			'type' => 'select',
			'valid_options' => array(
				'fade',
				'left to right',
				'right to left'
			),
			'description' => __('default: fade','testimonial-basics'),
			'section' => 'widget_rotator',
			'tab' => 'widget_display',
			'default' => 'fade',
			'class' => 'select'
		),
		'katb_widget_use_formatted_display' => array(
			'name' => 'katb_widget_use_formatted_display',
			'title' => __( 'Use formatted display' , 'testimonial-basics' ),
			'type' => 'checkbox',
			'description' => __('Check to include','testimonial-basics'),
			'section' => 'widget_custom_formats',
			'tab' => 'widget_display',
			'default' =>0, // 0 for off
			'class' => 'checkbox'
		),		
		'katb_widget_font' => array(
			'name' => 'katb_widget_font',
			'title' => __('Font for Widget Display','testimonial-basics'),
			'type' => 'select',
			'valid_options' => array(
				"default font", 
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
			'section' => 'widget_custom_formats',
			'tab' => 'widget_display',
			'default' => 'default font',
			'class' => 'select'
		),
		'katb_widget_background_color' => array(
			'name' => 'katb_widget_background_color',
			'title' => __('Background Color','testimonial-basics'),
			'type' => 'text',
			'description' => __('default: #EDEDED','testimonial-basics'),
			'section' => 'widget_custom_formats',
			'tab' => 'widget_display',
			'default' => '#EDEDED',
			'class' => 'hexcolor'
		),
		'katb_widget_font_color' => array(
			'name' => 'katb_widget_font_color',
			'title' => __('Font Color','testimonial-basics'),
			'type' => 'text',
			'description' => __('default: #000000','testimonial-basics'),
			'section' => 'widget_custom_formats',
			'tab' => 'widget_display',
			'default' => '#000000',
			'class' => 'hexcolor'
		),
		'katb_widget_author_location_color' => array(
			'name' => 'katb_widget_author_location_color',
			'title' => __('Author,Location, and Date Color','testimonial-basics'),
			'type' => 'text',
			'description' => __('default: #000000','testimonial-basics'),
			'section' => 'widget_custom_formats',
			'tab' => 'widget_display',
			'default' => '#000000',
			'class' => 'hexcolor'
		),
		'katb_widget_website_link_color' => array(
			'name' => 'katb_widget_website_link_color',
			'title' => __('Website Link Color','testimonial-basics'),
			'type' => 'text',
			'description' => __('default: #3384E8','testimonial-basics'),
			'section' => 'widget_custom_formats',
			'tab' => 'widget_display',
			'default' => '#3384E8',
			'class' => 'hexcolor'
		),
		'katb_widget_website_link_hover_color' => array(
			'name' => 'katb_widget_website_link_hover_color',
			'title' => __('Website Link Hover Color','testimonial-basics'),
			'type' => 'text',
			'description' => __('default: #FFFFFF','testimonial-basics'),
			'section' => 'widget_custom_formats',
			'tab' => 'widget_display',
			'default' => '#FFFFFF',
			'class' => 'hexcolor'
		),																																				
	);
		
    return apply_filters( 'katb_get_option_parameters', $options );
}

/** katb_testimonial_basics_display_in_code()
 * 
 * This function allows you to use display testimonials in code
 * 
 * It accepts arguments just like in the shortcode and displays accordingly
 *
 * @param string $group group used in database
 * @param string $number: all or a number
 * @param string $by: order or date or random
 * @param string $id: blank or id's of the testimonial separated by a comma
 * @param string $rotate: 'yes' or 'no' used to rotate testimonials
 * 
 * @uses katb_list_testimonials ( $atts ) in katb_shortcodes.php
 * 
 */
 function katb_testimonial_basics_display_in_code( $group='all', $number='all', $by='random', $id='', $rotate='no' ){
	
	$group = sanitize_text_field( $group );
	$number = strtolower( sanitize_text_field( $number ));
	$by = strtolower( sanitize_text_field( $by ));
	$id = sanitize_text_field($id);
	$rotate = strtolower( sanitize_text_field( $rotate ));
	
	//whitelist rotate
	if( $rotate != 'yes' ) { $rotate = 'no'; }
	
	//white list group
	if( $group == '' || $group == 'All' ) { $group = 'all'; }
	
	//number validation/whitelist
	if( $number == '' || $number == 'All' ) { $number = 'all'; }
	if( $number != 'all' ) {
		if( intval( $number ) < 1 ) {
			$number = 1;
		} else {
			$number = intval( $number );
		}
	}
	
	//Validate $by
	if ( $by != 'date' && $by != 'order') { $by = 'random'; }

	$atts = array(
		'group' => $group,
		'number' => $number,
		'by' => $by,
		'id' => $id,
		'rotate' => $rotate
	);
	
	echo katb_list_testimonials ( $atts );

}

/**
 * Supplies array of filter parameters for wp_kses($text,$allowed_html)
 * Only this html will be allowed in testimonials submitted by visitors
 * used in katb_check_for_submitted_testimonial()
 * and in katb_input_testimonial_widget.php function widget
 * 
 * @return	array	$allowed_html 
 */
function katb_allowed_html() {
	
	$allowed_html = array (
		'p' => array(),
    	'br' => array(),
		'i' => array(),
		'h1' => array(),
		'h2' => array(),
		'h3' => array(),
		'h4' => array(),
		'h5' => array(),
		'h6' => array(),
		'em' => array(),
		'strong' => array(),
		'q' => array(),
		'a' => array(
					'href' => array(),
					'title' => array(),
					'target' => array()
					),
		//'img' => array(),
	);
		
    return apply_filters( 'katb_allowed_html', $allowed_html );
}

/**
 * Test if Gravatar Exists
 * 
 * source : http://codex.wordpress.org/Using_Gravatars
 *
 * @return	boolean	$has_valid_avatar
 */
function katb_validate_gravatar($email) {
	// Craft a potential url and test its headers
	$hash = md5( strtolower( trim( $email ) ) );
	$uri = 'http://www.gravatar.com/avatar/' . $hash . '?d=404';
	$headers = @get_headers( $uri );
	if ( !preg_match( "|200|" , $headers[0] ) ) {
		$has_valid_avatar = FALSE;
	} else {
		$has_valid_avatar = TRUE;
	}
	return $has_valid_avatar;
}

/**
 * Gets the current page url for use in a redirect after the testimonial has been submitted
 * Taken from the WordPress.org Forum / search: current url
 * 
 * @return string $pageURL
 */ 
function katb_current_page_url() {
	$pageURL = 'http';
	if( isset($_SERVER["HTTPS"]) ) {
		if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
	}
	$pageURL .= "://";
	if ($_SERVER["SERVER_PORT"] != "80") {
		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	} else {
		$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	}
	return $pageURL;
}

/**
 * Checks for submitted testimonial through $_POST, and proceeds with form validation and submission
 *
 * This function checks to see if the main input form has submitted a testimonial.
 * It uses the add_action('parse_request','katb_check_for_submitted_testimonial') hook.
 * I don't know why this hook works. I was looking for a different approach to the form 
 * submission and check within the same function as this method was causein duplicate 
 * submissions in some cases. So I took a look at the user-submitted-posts plugin and 
 * adopted their method whic separates the validation and data submission from the form re-load. 
 * I didn't really copy their method just adapted it to a shortcode form submission.
 * The parse_request action hook was used and the documentation in WordPress.org is not very good.
 * It simply says "This action hook is executed at the end of WordPress's built-in request parsing 
 * method in the main WP() class." Anyway it works. 
 * 
 * Once the $_POST is detected the program validates the data, updates the database and send an email for notification.
 * If the validation fails a session flag is set and an error message will be shown on the page after reload
 * 
 * @uses katb_get_options(); array of user options
 * @uses katb_allowed_html(); array of allowed html for validation
 * @uses katb_current_page_url(); gets cuurent page for redirect
 * 
 */
//check for submitted testimonial
function katb_check_for_submitted_testimonial() {
	global $wpdb,$tablename;
	global $katb_group,$katb_author,$katb_email,$katb_website,$katb_location,$katb_rating,$katb_testimonial,$katb_input_error,$katb_input_success;
	$tablename = $wpdb->prefix.'testimonial_basics';
	$katb_options = katb_get_options();
	$exclude_website = $katb_options[ 'katb_exclude_website_input' ];
	$exclude_location = $katb_options[ 'katb_exclude_location_input' ];
	$use_ratings = $katb_options[ 'katb_use_ratings' ];
	$katb_allowed_html = katb_allowed_html();
	
	if ( isset ( $_POST['katb_submitted'] ) && wp_verify_nonce( $_POST['katb_main_form_nonce'],'katb_nonce_1' ) ) {
	
		//Initialize error message
		$katb_input_error = '';
		//Initialize session variable used to check if testimonial was successfully submitted
		$_SESSION['katb_submitted'] = SHA1('false');
		//Validate-Sanitize Input
		//Set Defaults
		$katb_order = "";
		$katb_approved = 0;
		//$katb_group = "";
		$katb_group = sanitize_text_field($_POST['tb_group']);
		$katb_datetime = current_time('mysql');
		//Validate-Sanitize Author
		$katb_author = sanitize_text_field($_POST['tb_author']);
		$_POST['tb_author'] = '';
		if ($katb_author == "") {
			$katb_input_error .= '*'.__('Author is required','testimonial-basics').'*';
		}
		//Validate-Sanitize E-mail
		$katb_email = sanitize_email($_POST['tb_email']);
		if(!is_email($katb_email)) {
			$katb_input_error .= '*'.__('Valid email is required','testimonial-basics').'*';
		}
		//Validate-Sanitize Website
		if( $exclude_website != 1 ) {
			$katb_website = trim($_POST['tb_website']);
			if($katb_website != '')$katb_website = esc_url($katb_website);
		} else {
			$katb_website = '';
		}
		
		//Validate Location
		if( $exclude_location != 1 ) {
			$katb_location = sanitize_text_field($_POST['tb_location']);
		}else {
			$katb_location = '';
		}

		//validate rating
		if( $use_ratings == 1 ) {
			$katb_rating = sanitize_text_field($_POST['tb_rating']);
		} else {
			$katb_rating = '0.0';
		}
			
		//Validate-Sanitize Testimonial
		$katb_testimonial = wp_kses($_POST['tb_testimonial'],$katb_allowed_html);
		if ( $katb_testimonial == "" ) {
			$katb_input_error .= '*'.__('Testimonial is required','testimonial-basics').'*';
		}
		//Captcha Check
		if ( $katb_options['katb_use_captcha'] == TRUE || $katb_options['katb_use_captcha'] == 1 ) {
			$katb_captcha_entered = sanitize_text_field( $_POST['verify'] );
			if ( $_SESSION['katb_pass_phrase'] !== sha1( $katb_captcha_entered ) ) {
				$katb_input_error .= '*'.__('Captcha is invalid - please try again','testimonial-basics').'*';
			}
		}
		//Validation complete
		if($katb_input_error == "") {
			//OK $katb_input_error is empty so let's update the database
			$values = array(
				'tb_date' => $katb_datetime,
				'tb_order' => $katb_order,
				'tb_approved' => $katb_approved,
				'tb_group' => $katb_group,
				'tb_name' => $katb_author,
				'tb_email' => $katb_email,
				'tb_location' => $katb_location,
				'tb_url' => $katb_website,
				'tb_rating' => $katb_rating,
				'tb_testimonial' => $katb_testimonial
			);
			$formats_values = array('%s','%d','%d','%s','%s','%s','%s','%s','%s','%s');
			$wpdb->insert($tablename,$values,$formats_values);
			$_SESSION['katb_submitted'] = SHA1('true');
			//send email
			if ( $katb_options['katb_contact_email'] != '' ) {
				$emailTo = $katb_options['katb_contact_email'];
			} else {
				$emailTo = get_option('admin_email');
			}
			$subject = __('You have received a testimonial!','testimonial-basics');
			$body = __('Name: ','testimonial-basics').' '.stripcslashes($katb_author)."<br/><br/>"
					.__('Email: ','testimonial-basics').' '
					.stripcslashes($katb_email)."<br/><br/>"
					.__('Comments: ','testimonial-basics')."<br/><br/>"
					.stripcslashes($katb_testimonial)."<br/><br/>"
					.__('Log in to approve it:','testimonial-basics').'<a href="'.site_url("/wp-login.php").'" title="your site login">Log In</a>';;
			$headers = 'From: '.stripcslashes($katb_author).' <'.stripcslashes($katb_email).'>';
			add_filter('wp_mail_content_type',create_function('', 'return "text/html";'));
			wp_mail( $emailTo, $subject, $body, $headers );
			//Now empty the variables
			$katb_id = "";
			$katb_order = "";
			$katb_approved = "";
			$katb_date = "";
			$katb_time = "";
			$katb_author = "";
			$katb_website = "";
			$katb_location = "";
			$katb_testimonial = "";
			$katb_email = "";
			$katb_rating = "0.0";
			$redirect = katb_current_page_url();
			wp_redirect( $redirect );
			exit;
		}
	} else {
		$katb_id = "";
		$katb_order = "";
		$katb_approved = "";
		$katb_date = "";
		$katb_time = "";
		$katb_author = "";
		$katb_website = "";
		$katb_location = "";
		$katb_testimonial = "";
		$katb_email = "";
		$katb_rating = "";
	}
	/* ---------- Reset button is clicked ---------------- */
	if( isset($_POST['katb_reset'] ) ) {
		$katb_author = "";
		$katb_email = "";
		$katb_website = "";
		$katb_location = "";
		$katb_testimonial = "";
		$katb_rating = "";
	}
}
add_action ('parse_request', 'katb_check_for_submitted_testimonial');

/**
 * Dynamic Encerpt Function
 * 
 * modified from @link http://wordpress.org/support/topic/dynamic-the_excerpt?replies=22 
 * This function filters the content to the passed character length from where it was called.
 * It then returns the string with a post link so the user can click the link to go to the post
 * 
 * @param int $length length to filter to in characters, passed from function call
 * @param string $text - the unfiltered testimonial content
 * @param string $classID - the link data element picked up by the popup jQuery script
 * WordPress Functions - see Codex
 * @uses get_the_content() @uses apply_filters() @uses strip_shortcodes()
 * @uses get_permalink()
 * 
 * @return string $text filtered with the more link required to trigger the correct popup window.
 * 
 */
function katb_testimonial_excerpt_filter( $length , $text , $classID ) {

	$text = strip_shortcodes( $text );
	$text = strip_tags( $text, '<a><p><em><i><strong><img><br><ul><li><ol><h1><h2><h3><h4><h5><h6><q>');
	$text_first_length = substr( $text , 0 , $length );
	$text_no_html = strip_tags( $text_first_length );
	$add_length = $length - strlen( $text_no_html );
	$length = $length + $add_length;
	$output = strlen( $text );

	if( $output > $length ) {
		
		$break_pos = strpos( $text , ' ' , $length );//find next space after desired length

		if( $break_pos == '' ) { $break_pos = $length; }

		//<br /> check
		if( substr( $text,$break_pos - 4, 4 ) == '<br ' ) {
			$text = substr( $text , 0 , $break_pos ).'/>';
		} elseif ( substr( $text , $break_pos - 3 , 3 ) == '<br' ){
			$text = substr( $text , 0 , $break_pos ).'/>';
		} else {
			$text = substr( $text , 0 , $break_pos );
		}

		$text = force_balance_tags( $text );
		$text .= '...';

		$text .= '<a href="#" class="katb_excerpt_more" data-id="'.$classID.'" > ...'.__('more','testimonial-basics').'</a>';
		
	}
	return $text;
}
 
/*=====================================================================================================
 *                           Page Navigation Functions
 * ==================================================================================================== */
 
/**
 * This function sets up the array $setup for use by the katb_display_pagination() function
 * @param $offset_name : string, name of session variable that stores the offset
 * @param $span : int, number of entries to display on each page.
 * @param $total_entries : string, total number of testimonials
 * 
 * @return $setup : array, contains the setup variables passed to  katb_display_pagination()
 */
function katb_setup_pagination( $offset_name, $span, $total_entries ){
	
	$paginate_setup = array();

	//prevent divide by 0
	if( $span == '' || $span == 0 ) { $span = 10; }
	
	//Check for offset and set to 0 if not there
	if ( isset( $_SESSION[$offset_name] ) ) {
		$offset = $_SESSION[$offset_name];
	} else {
		$offset = 0;
	}
	
	//Calculate display pages required given the span
	$pages_decimal = $total_entries/$span;
	$pages = ceil( $pages_decimal );
	
	//calculate the page selected based on the offset
	$page_selected = intval( $offset/$span + 1 );
	
	//Safety Checks
	if ( $page_selected > $pages ) {
		$offset = 0;
		$_SESSION[$offset_name] = $offset;
		$page_selected = 1;
	}
	if ( $page_selected < 1 ) $page_selected = 1;
			
	//Figure out the pages to list
	$max_page_buttons = 5;
	//Figure out $page_a
	$j = $max_page_buttons;
	while( $page_selected > $j ){ $j = $j + $max_page_buttons; }
	$page_a = $j - $max_page_buttons + 1;
	
	//Set up display configuration
	//only display the first button if there are a lot of downloads
	$pages > ($max_page_buttons * 2)? $first = 'yes' : $first = 'no';
	
	//only display the previous button if more than 1 set
	$pages > $max_page_buttons?	$previous = 'yes': $previous = 'no';
	
	//set up remaining page buttons
	( $page_a + 1 ) < ( $pages + 1 )? $page_b = $page_a + 1: $page_b = 'no';
	( $page_a + 2 ) < ( $pages + 1 )? $page_c = $page_a + 2: $page_c = 'no';
	( $page_a + 3 ) < ( $pages + 1 )? $page_d = $page_a + 3: $page_d = 'no';
	( $page_a + 4 ) < ( $pages + 1 )? $page_e = $page_a + 4: $page_e = 'no';
	
	//only display middle button for large number of downloads
	$pages > ( $max_page_buttons * 2 )? $middle = 'yes': $middle = 'no';
	
	//only display the next button if more than 1 set
	$pages > $max_page_buttons? $next = 'yes': $next = 'no';
	
	//only display the last button if there are a lot of downloads
	$pages > ( $max_page_buttons * 2 )? $last = 'yes': $last = 'no';
	
	$setup = array(
		'offset' => $offset,
		'pages' => $pages,
		'page_selected' => $page_selected,
		'first' => $first,
		'previous' => $previous,
		'page_a' => $page_a,
		'page_b' => $page_b,
		'page_c' => $page_c,
		'page_d' => $page_d,
		'page_e' => $page_e,
		'middle' => $middle,
		'next' => $next,
		'last' => $last
	);
	
	return $setup;
}

/**
 * This function displays the pagination buttons.
 * It is used by katb_testimonial_basics_edit_page() in katb_testimonial_basics_admin.php, 
 * to provide pagination in the Edit Testimonials panel
 * 
 * @param $setup array : supplied by katb_setup_pagination()
 * 
 */
function katb_display_pagination ( $setup ) {
	echo '<form class="katb-pagination" method="POST" action="#">';
	if ( $setup['pages'] > 1 ) {
		echo '<input type="button" class="ka_pages" value="Page '.$setup['page_selected'].' / '.$setup['pages'].'">';
		if ( $setup['first'] != 'no' ) echo '<input type="submit" name="ka_paginate_post" value="<<" title="First" class="ka_paginate" />';
			if ( $setup['previous'] != 'no') echo '<input type="submit" name="ka_paginate_post" value="<" title="Previous" class="ka_paginate" />';
			if ( $setup['page_a'] == $setup['page_selected'] ) {
				echo '<input type="submit" name="ka_paginate_post" value="'.$setup['page_a'].'" class="ka_paginate_selected"  />';
			} else {
				echo '<input type="submit" name="ka_paginate_post" value="'.$setup['page_a'].'" class="ka_paginate"  />';
			}
			if ( $setup['page_b'] == $setup['page_selected'] ) {
				if ( $setup['page_b'] != "no" ) echo '<input type="submit" name="ka_paginate_post" value="'.$setup['page_b'].'" class="ka_paginate_selected" />';
			} else {
				if ( $setup['page_b'] != "no" ) echo '<input type="submit" name="ka_paginate_post" value="'.$setup['page_b'].'" class="ka_paginate" />';
			}
			if ( $setup['page_c'] == $setup['page_selected'] ) {
				if ( $setup['page_c'] != "no" ) echo '<input type="submit" name="ka_paginate_post" value="'.$setup['page_c'].'" class="ka_paginate_selected" />';
			} else {
				if ( $setup['page_c'] != "no" ) echo '<input type="submit" name="ka_paginate_post" value="'.$setup['page_c'].'" class="ka_paginate" />';
			}
			if ( $setup['page_d'] == $setup['page_selected'] ) {
				if ( $setup['page_d'] != "no" ) echo '<input type="submit" name="ka_paginate_post" value="'.$setup['page_d'].'" class="ka_paginate_selected" />';
			} else {
				if ( $setup['page_d'] != "no" ) echo '<input type="submit" name="ka_paginate_post" value="'.$setup['page_d'].'" class="ka_paginate" />';
			}
			if ( $setup['page_e'] == $setup['page_selected'] ) {
				if ( $setup['page_e'] != "no" ) echo '<input type="submit" name="ka_paginate_post" value="'.$setup['page_e'].'" class="ka_paginate_selected" />';
			} else {
				if ( $setup['page_e'] != "no" ) echo '<input type="submit" name="ka_paginate_post" value="'.$setup['page_e'].'" class="ka_paginate" />';
			}
			if ( $setup['middle'] != "no" ) echo '<input type="submit" name="ka_paginate_post" value="^" title="Middle" class="ka_paginate" />';
			if ( $setup['next'] != 'no' ) echo '<input type="submit" name="ka_paginate_post" value=">" title="Next" class="ka_paginate" />';
			if ( $setup['last'] != 'no' ) echo '<input type="submit" name="ka_paginate_post" value=">>" title="Last" class="ka_paginate" />';
		}
	echo '</form>';
}

/**
 * This function sets up the displays the pagination buttons html in a string.
 * It is called by katb_list_testimonials() in katb_shortcodes.php
 * 
 * @param $setup array : supplied by katb_setup_pagination()
 * 
 * @return $html_return - the return string to display the pagination
 * 
 */
function katb_get_display_pagination_string ($setup) {
	
	$html_return = '';
	$html_return .= '<form method="POST" action="#" class="katb_paginate">';
	if ( $setup['pages'] > 1 ) {
		$html_return .= '<input type="button" class="ka_display_paginate_summary" value="Page '.$setup['page_selected'].' / '.$setup['pages'].'">';
		if ( $setup['first'] != 'no' ) $html_return .= '<input type="submit" name="ka_paginate_post" value="<<" title="First" class="ka_display_paginate" />';
			if ( $setup['previous'] != 'no') $html_return .=  '<input type="submit" name="ka_paginate_post" value="<" title="Previous" class="ka_display_paginate" />';
			if ( $setup['page_a'] == $setup['page_selected'] ) {
				$html_return .=  '<input type="submit" name="ka_paginate_post" value="'.$setup['page_a'].'" class="ka_display_paginate_selected"  />';
			} else {
				$html_return .=  '<input type="submit" name="ka_paginate_post" value="'.$setup['page_a'].'" class="ka_display_paginate"  />';
			}
			if ( $setup['page_b'] == $setup['page_selected'] ) {
				if ( $setup['page_b'] != "no" ) $html_return .=  '<input type="submit" name="ka_paginate_post" value="'.$setup['page_b'].'" class="ka_display_paginate_selected" />';
			} else {
				if ( $setup['page_b'] != "no" ) $html_return .=  '<input type="submit" name="ka_paginate_post" value="'.$setup['page_b'].'" class="ka_display_paginate" />';
			}
			if ( $setup['page_c'] == $setup['page_selected'] ) {
				if ( $setup['page_c'] != "no" ) $html_return .=  '<input type="submit" name="ka_paginate_post" value="'.$setup['page_c'].'" class="ka_display_paginate_selected" />';
			} else {
				if ( $setup['page_c'] != "no" ) $html_return .=  '<input type="submit" name="ka_paginate_post" value="'.$setup['page_c'].'" class="ka_display_paginate" />';
			}
			if ( $setup['page_d'] == $setup['page_selected'] ) {
				if ( $setup['page_d'] != "no" ) $html_return .=  '<input type="submit" name="ka_paginate_post" value="'.$setup['page_d'].'" class="ka_display_paginate_selected" />';
			} else {
				if ( $setup['page_d'] != "no" ) $html_return .=  '<input type="submit" name="ka_paginate_post" value="'.$setup['page_d'].'" class="ka_display_paginate" />';
			}
			if ( $setup['page_e'] == $setup['page_selected'] ) {
				if ( $setup['page_e'] != "no" ) $html_return .=  '<input type="submit" name="ka_paginate_post" value="'.$setup['page_e'].'" class="ka_display_paginate_selected" />';
			} else {
				if ( $setup['page_e'] != "no" ) $html_return .=  '<input type="submit" name="ka_paginate_post" value="'.$setup['page_e'].'" class="ka_display_paginate" />';
			}
			if ( $setup['middle'] != "no" ) $html_return .=  '<input type="submit" name="ka_paginate_post" value="^" title="Middle" class="ka_display_paginate" />';
			if ( $setup['next'] != 'no' ) $html_return .=  '<input type="submit" name="ka_paginate_post" value=">" title="Next" class="ka_display_paginate" />';
			if ( $setup['last'] != 'no' ) $html_return .=  '<input type="submit" name="ka_paginate_post" value=">>" title="Last" class="ka_display_paginate" />';
		}
	$html_return .=  '</form>';
	return $html_return;
}

/**
 * This function sets up the offset depending which pagination button is clicked
 * Note : $offset is the last testimonial in the previous page and it is stored in
 * a session variable. It is the variable used to determine where the pagination is at.
 * 
 * @param $offset_name : string, name of session variable that stores the offset
 * @param $span : int, number of entries to display on each page.
 * @param $action : string, the value of the button that was clicked
 * @param $total_entries : string, total number of testimonials
 * 
 */
function katb_offset_setup ( $offset_name, $span, $action, $total_entries ) {
	
	//Start by getting offset
	if ( isset( $_SESSION[$offset_name] ) ) {
		$offset = $_SESSION[$offset_name];
	} else {
		$offset = 0;
	}
	
	//prevent divide by 0
	if( $span == '' || $span == 0 ) { $span = 10; }
	
	//Calculate total pages
	$pages_decimal = $total_entries/$span;
	$pages = ceil( $pages_decimal );
	$page_selected = ( $offset/$span + 1 );
	
	//Safety Checks
	if ( $page_selected > $pages ) {
		$offset = 0;
		$_SESSION[$offset_name] = $offset;
		$page_selected = 1;
	}
	if ( $page_selected < 1 ) { $page_selected = 1; }
	
	$max_page_buttons = 5;
	
	//Figure out $page_a
	$j = 5;
	while( $page_selected > $j ){ $j = $j + $max_page_buttons; }
	$page_a = $j - $max_page_buttons + 1;
	
	//Now that we know where we are at, figure out where we are going :)
	if ( $action == '<<' ) {
		$_SESSION[$offset_name] = 0;
	} elseif ( $action == '<' ) {
		if ( $page_a - $max_page_buttons < 1 ) {
			$_SESSION[$offset_name] = 0;
		} else {
			$offset = ( $page_a - $max_page_buttons - 1 ) * $span;
			$_SESSION[$offset_name] = $offset;
		}
	} elseif ( $action == '^' ) {
		$offset = (floor($pages/2) - 1) * $span;
		$_SESSION[$offset_name] = $offset;
	} elseif ( $action == '>' ) {
		if ( $page_a + $max_page_buttons <= $pages ) {
			$offset = ( $page_a + $max_page_buttons - 1 ) * $span;
			$_SESSION[$offset_name] = $offset;
		}
	} elseif ( $action == '>>' ) {
		$offset = ($pages - 1) * $span;
		$_SESSION[$offset_name] = $offset;
	} else {
		$page_no = intval($action);
		$offset = ( $page_no - 1 ) * $span;
		$_SESSION[$offset_name] = $offset;
	}
	
}

/**
 * Function to add unapproved testimonials count to admin menu
 */
add_action( 'admin_menu', 'katb_add_unapproved_count' );
function katb_add_unapproved_count() {
 	//setup database table
	global $wpdb , $tablename, $menu;
	$tablename = $wpdb->prefix.'testimonial_basics';
	
	$results = $wpdb->get_results( " SELECT COUNT(1) FROM `$tablename` WHERE `tb_approved` = '0' ",ARRAY_A);
	$total = $results[0]['COUNT(1)'];
	
	if( $total != 0 ) {
		foreach ( $menu as $key => $value ) {
			if ( $menu[$key][2] == 'katb_testimonial_basics_admin' ) {
				$menu[$key][0] .= " <span class='update-plugins count-$pend_count'><span class='plugin-count'>" . $total . '</span></span>';
				return;
			}
		}
	}
}