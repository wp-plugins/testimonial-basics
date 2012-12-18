<?php
/*
Plugin Name: Testimonial Basics
Plugin URI: http://www.kevinsspace.ca/testimonial-basics-wordpress-plugin/
Description: This plugin facilitates easy management of customer testimonials. The user can set up an input form in a page or in a widget, and display all or selected testimonials in a page or a widget. The plug in is very easy to use and modify.
Version: 2.8.4
Author: Kevin Archibald
Author URI: http://www.kevinsspace.ca
License: GPLv3
===================================================================================================
                       LICENSE
===================================================================================================

License: GNU General Public License V3
License URI: see the license.txt file for license details.

	testimonial-basics is a plugin for WordPress
    Copyright (C) 2012 Kevin Archibald

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

/** ----------- Session Start ----------------------------------------------
 * Start session if not already started. The session is required
 * for passing the password from katb_captcha.php to the input
 * form data validation
 * ------------------------------------------------------------------------- */
if(!isset($_SESSION)) session_start();

/** ------------- Prevent Direct Access ---------------------------------------
* prevent file from being accessed directly
* ---------------------------------------------------------------------------- */
if ('testimonial-basics.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('Please do not access this file directly. Thanks!');

/** ------------- Plugin Activation ---------------------------------------
 *
 * When the plugin is activated this function is executed
 * It initially checks for a minimum version of WordPress and won't load if
 * the WordPress Version is below that.
 * 
 * Checks for database table and creates one if not there
 * table name : database prefix + testimonial_basics
 * 
 *-------------------------------------------------------------------------- */
 global $katb_db_new_version;
 $katb_db_new_version = '1.1';
 
function katb_testimomial_basics_activate() {
	//Check version compatibilities
    if ( version_compare( get_bloginfo( 'version' ), '3.1', '<' ) ) {
        deactivate_plugins( basename( __FILE__ ) ); // Deactivate our plugin
        die ('Please Upgrade your WprdPress to use this plugin.');
    }
	//Check for database table and create if not there
	global $wpdb;
	global $katb_db_new_version;
	$katb_tb_installed_version = get_option( 'katb_database_version' );
	$tablename = $wpdb->prefix.'testimonial_basics';
	$tableprefix = strtolower($wpdb->prefix);
	if( $wpdb->get_var("SHOW TABLES LIKE '$tablename'") != $tablename && $wpdb->get_var("SHOW TABLES LIKE '$tablename'") != $tableprefix.'testimonial_basics' ) {
		//table does not exist or requires upgrading
		$sql = "CREATE TABLE `$tablename` (
				`tb_id` int(4) UNSIGNED NOT NULL AUTO_INCREMENT,
  				`tb_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  				`tb_group` char(20) NOT NULL,
  				`tb_order` int(4) UNSIGNED NOT NULL,
  				`tb_approved` int(1) UNSIGNED NOT NULL,
  				`tb_name` char(100) NOT NULL,
  				`tb_location` char(100) NOT NULL,
  				`tb_email` char(100) NOT NULL,
 				`tb_url` char(100) NOT NULL,
  				`tb_testimonial` text NOT NULL,
  				PRIMARY KEY (`tb_id`)
			);";
		require_once ( ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
		update_option('katb_database_version',$katb_db_new_version);
	} elseif ( $katb_tb_installed_version !== $katb_db_new_version ) {
		//table requires upgrading
		$sql = "CREATE TABLE `$tablename` (
				`tb_group` char(20) NOT NULL,
  				`tb_email` char(100) NOT NULL
 			);";
		require_once ( ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
		update_option('katb_database_version',$katb_db_new_version);
	}
}
register_activation_hook( __FILE__, 'katb_testimomial_basics_activate' );

function katb_update_db_check() {
    global $katb_db_new_version;
    if (get_option('katb_database_version') != $katb_db_new_version) {
        katb_testimomial_basics_activate();
    }
}
add_action('plugins_loaded', 'katb_update_db_check');

/** ------------- Plugin Deactivation ---------------------------------------
 *
 * When the plugin is deactivated this function is executed
 * 
 * Nothing is required to be done with tis plugin but I left the function here
 * as a reminder
 * 
 * --------------------------------------------------------------------------- */
function katb_testimomial_basics_deactivate() {
	//Do these things when deactvated
}
register_deactivation_hook(__FILE__,'katb_testimomial_basics_deactivate');

/** ------------- Load Admin Functions ---------------------------------------
 *
 * The admin functions are loaded if in admin mode
 * 
 * --------------------------------------------------------------------------- */
if( is_admin() ) {
	//load admin functions
	require_once( dirname(__FILE__).'/includes/katb_testimonial_basics_admin.php' );
}

/** ------------- Plugin Setup ---------------------------------------
 *
 * When the plugin is loaded this function is executed
 * 
 * Loads these files on setup
 * Activates the translation on setup
 * 
 * ---------------------------------------------------------------------- */
function katb_testimonial_basics_plugin_setup () {
	require_once( dirname(__FILE__).'/includes/katb_shortcodes.php' );
	require_once( dirname(__FILE__).'/widgets/katb_input_testimonial_widget.php' );
	require_once( dirname(__FILE__).'/widgets/katb_testimonial_widget.php' );
	require_once( dirname(__FILE__).'/includes/katb_functions.php' );
	//enable translation
	load_plugin_textdomain('testimonial-basics', false, 'testimonial-basics/languages');
}
add_action( 'plugins_loaded','katb_testimonial_basics_plugin_setup');

/** ------------- Enqueue Styles ---------------------------------------
 *
 * When the plugin is activated this function is executed
 * 
 * Loads these files on setup
 * Activates the translation on setup
 * 
 * ----------------------------------------------------------------------- */
function katb_add_user_style(){
	wp_register_style( 'katb_user_styles',plugin_dir_url(__FILE__).'css/katb_user_styles.css' );
	wp_enqueue_style( 'katb_user_styles' );
}
add_action('wp_enqueue_scripts','katb_add_user_style');

/** ------------- Custom Styles ---------------------------------------
 *
 * This function loads custom user styles if required
 * 
 * Initially it loads the user options from the database.
 * If the user has selected custom testimonial display for the content
 * or for the widget displa it loads the respective files
 * 
 * uses katb_get_options() located in \includes\katb_functions.php
 * 
 * ---------------------------------------------------------------------- */
function katb_add_custom_styles(){
	require_once( dirname(__FILE__).'/css/katb_display_custom_style.php' );
	require_once( dirname(__FILE__).'/css/katb_widget_custom_style.php' );
 }
add_action( 'wp_print_styles', 'katb_add_custom_styles' );

/** ------------- Content Area Input Form ---------------------------------------
 *
 * This function is called by katb_insert_input_form() defined in this file
 * 
 * The input form for the testimonial is loaded. The visitor inputs a testimonial
 * and clicks the submit button and the testimonial is submitted to the database 
 * and the admin user is notified by email that they have a testimonial to review
 * and approve. If admin user can specify if a captcha is used to help in validation.
 * 
 * uses katb_get_options located in \includes\katb_functions.php
 * uses various WordPress functions
 * returns string $html_string contains the form for testimonial input
 * 
 *-------------------------------------------------------------------------------- */
function katb_input_form(){
	global $wpdb,$tablename;
	$tablename = $wpdb->prefix.'testimonial_basics';
	$katb_options = katb_get_options();
	$katb_allowed_html = katb_allowed_html();
	if ( isset ( $_POST['submitted'] ) && wp_verify_nonce( $_POST['katb_main_form_nonce'],'katb_nonce_1')) {
	
		//Validate-Sanitize Input
		$error = "";
		$html_string = '';
		//Set Defaults
		$katb_order = "";
		$katb_approved = 0;
		$katb_datetime = current_time('mysql');
		//Validate-Sanitize Author
		$katb_author = sanitize_text_field($_POST['tb_author']);
		if ($katb_author == "") {
			$error .= '*'.__('Author is required','testimonial-basics').'*';
		}
		//Validate-Sanitize E-mail
		$katb_email = sanitize_email($_POST['tb_email']);
		if(!is_email($katb_email)) {
			$error .= '*'.__('Valid email is required','testimonial-basics').'*';
		}
		//Validate-Sanitize Website
		$katb_website = trim($_POST['tb_website']);
		if ($katb_website != '')$katb_website = esc_url($katb_website);
		//Validate Location
		$katb_location = sanitize_text_field($_POST['tb_location']);
		//Validate-Sanitize Testimonial
		$katb_testimonial = wp_kses($_POST['tb_testimonial'],$katb_allowed_html);
		if ($katb_testimonial == "" ) {
			$error .= '*'.__('Testimonial is required','testimonial-basics').'*';
		}
		//Captcha Check
		if ($katb_options['katb_use_captcha'] == TRUE || $katb_options['katb_use_captcha'] == 1 ) {
			if ($_SESSION['pass_phrase'] !== sha1($_POST['verify'])){
				$error .= '*'.__('Captcha is invalid - please try again','testimonial-basics').'*';
			}
		}
		//Validation complete
		if($error == "") {
			//OK $error is empty so let's update the database
			$values = array(
				'tb_date' => $katb_datetime,
				'tb_order' => $katb_order,
				'tb_approved' => $katb_approved,
				'tb_name' => $katb_author,
				'tb_location' => $katb_location,
				'tb_url' => $katb_website,
				'tb_testimonial' => $katb_testimonial,
				'tb_email' => $katb_email				
			);
			$formats_values = array('%s','%d','%d','%s','%s','%s','%s');
			$wpdb->insert($tablename,$values,$formats_values);
			$html_string .= '<span class="katb_test_sent">'.__('Submitted - Thankyou!','testimonial-basics').'</span>';
			//email to administrators
			$emailto = get_option('admin_email');
			$subject = __('You have received a testimonial from ','testimonial-basics').' '.$katb_author;
			$body = __('Name: ','testimonial-basics').' '.$katb_author."<br/><br/>".__('Email: ','testimonial-basics').' '.$katb_email."<br/><br/>".__('Comments: ','testimonial-basics')."<br/><br/>".stripslashes($katb_testimonial);
			$headers = 'From: '.$katb_author.' <'.$katb_email.'>';
			add_filter('wp_mail_content_type',create_function('', 'return "text/html";'));
			wp_mail( $emailto, $subject, $body, $headers );
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
		} else {
			$html_string .= '<span class="katb_error">'.__('There were errors so the testimonial was not added: ','testimonial-basics').$error.'</span>';
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
		$html_string = "";
	}
	/* ---------- Reset button is clicked ---------------- */
	if(isset($_POST['reset'])) {
		$katb_author = "";
		$katb_email = "";
		$katb_website = "";
		$katb_location = "";
		$katb_testimonial = "";
	}
	//Now lets prepare the return string
	//$html_string = '';
	if ($katb_options['katb_include_input_title'] == 1){
		$html_string .= "<h4>".stripslashes($katb_options['katb_input_title'])."</h4>";
	}
	if ($katb_options['katb_include_email_note'] == 1) {
		$html_string .= '<p>'.stripslashes($katb_options['katb_email_note']).'</p>';
	}
	$html_string .= '<div class="katb_input_style">';
	$html_string .= '<form method="POST" action="#">';
	$html_string .= '<label>*'.__('Author','testimonial-basics').' : </label><input type="text"  maxlength="100" name="tb_author" value="'.stripcslashes($katb_author).'" /><br/>';
	$html_string .= '<label>*'.__('Email','testimonial-basics').'  : </label><input type="text"  maxlength="100" name="tb_email" value="'.$katb_email.'" /><br/>';
	$html_string .= '<label>'.__('Website','testimonial-basics').'  : </label><input type="text"  maxlength="100" name="tb_website" value="'.$katb_website.'" /><br/>';
	$html_string .= '<label>'.__('Location','testimonial-basics').' : </label><input type="text"  maxlength="100" name="tb_location" value="'.stripcslashes($katb_location).'" /><br/>';
	$html_string .= '<label>*'.__('Testimonial','testimonial-basics').' : </label><br/><textarea rows="5" name="tb_testimonial" >'.stripcslashes($katb_testimonial).'</textarea>';
	$html_string .= '<p>HTML '.__('Allowed','testimonial-basics').': <code>&#60;p&#62;&#60;/p&#62;&#60;br/&#62;</code></p><br/>';
	if ($katb_options['katb_use_captcha'] == TRUE || $katb_options['katb_use_captcha'] == 1 ) {
		$html_string .= '<div class="katb_captcha">';
		$html_string .=	'<label for="verify_main">'.__('Verification','testimonial-basics').' : </label>';
		$html_string .=	'<input type="text" size="30" id="verify_main" name="verify" value="'.__('Enter the Captcha letters','testimonial-basics').'" />';
		$html_string .= '<img src="'.plugin_dir_url(__FILE__).'includes/katb_captcha.php" alt="Verification Captcha" />';
		$html_string .= '</div>';
	}
	$html_string .= '<input class="katb_submit" type="submit" name="submitted" value="'.__('Submit','testimonial-basics').'" />';
	$html_string .= '<input class="katb_reset" type="submit" name="reset" value="'.__('Reset','testimonial-basics').'" />';
	$html_string .= wp_nonce_field("katb_nonce_1","katb_main_form_nonce",false,false);
	$html_string .= '</form>';
	$html_string .= '</div>';
	$html_string .= '<div class="katb_clearboth"></div><p>* '.__('Required','testimonial-basics').'</p>';
	if ($katb_options['katb_use_gravatars'] == 1 || $katb_options['katb_widget_use_gravatars'] == 1 ) {
		$html_string .= '<p>'.__('Add a photo? ','testimonial-basics').'<a href="https://en.gravatar.com/" title="Gravatar Site" target="_blank" ><img class="gravatar_logo" src="'.plugin_dir_url(__FILE__).'includes/Gravatar80x16.JPG" alt="Gravatar Website" title="Gravatar Website" /></a></p>';
	}
	return $html_string;
}

/** ------------- Filter for Content Area Input Form ---------------------------------------
 *
 * This function is the filter used to load the testimonial form in a content area
 * The user enters <p><!-- katb_input_form --></p> or <!-- katb_input_form --> 
 * in the content area. When the filter picks this up katb_input_form is called
 * and the filtered string is replaced by the input form ($html_string)
 * 
 * 
 * uses katb_input_form() defined above
 * accepts string $content
 * rerurns string $content
 * 
 * ------------------------------------------------------------------------------------------ */
function katb_insert_input_form($content){
	if (strpos($content, "<p><!-- katb_input_form --></p>") !== false){
		$content = str_replace("<p><!-- katb_input_form --></p>", katb_input_form(), $content);
	}elseif (strpos($content, "<!-- katb_input_form -->") !== false){
			$content = str_replace("<!-- katb_input_form -->", katb_input_form(), $content);
		}
	return $content;
}
add_filter('the_content', 'katb_insert_input_form');

?>