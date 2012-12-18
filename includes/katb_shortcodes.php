<?php
/**
 * This file contains the shortcodes for displaying the testimonial in a content area.
 *
 *
 * @package		Testimonial Basics WordPress Plugin
 * @copyright	Copyright (c) 2012, Kevin Archibald
 * @license		http://www.gnu.org/licenses/quick-guide-gplv3.html  GNU Public License
 * @author		Kevin Archibald <www.kevinsspace.ca/contact/>
 */

/* ------------------ messagebox shortcode ---------------------------------
 * useage : [katb_testimonial by="date" number="all" id=""] 
 * by : "date" or "order"
 * number : "all" or input the number you want to display
 * id : "" or "random" or "id" where id is the id number of the testimonial
 * ------------------------------------------------------------------------- */

function katb_list_testimonials ( $atts) {
	//set up database table name for later use
	global $wpdb,$tablename;
	$tablename = $wpdb->prefix.'testimonial_basics';
	//get user options
	$katb_options = katb_get_options();
	//Initialize Strings
	$katb_html = '';
	$katb_error = "";
	//get shortcode variables
	extract(shortcode_atts(array(
		'group' => 'all',
	    'by' => 'date',
	    'number' => 'all',
	    'id' => '',
    ), $atts));
	//Sanitize data
	$group = sanitize_text_field($group);
	$by = sanitize_text_field($by);
	$number = sanitize_text_field($number);
	$id = sanitize_text_field($id);
	//Validate $by
	if ($by != 'date' && $by != 'order') $by = 'date';
	//OK let's start by getting the testimonial data from the database
	if ( $number == 'all' && $id == '' && $by == 'date' ) {
		if ($group == 'all') {
			$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' ORDER BY `tb_date` DESC ",ARRAY_A);
		} else {
			$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' AND `tb_group` = '$group' ORDER BY `tb_date` DESC ",ARRAY_A);
		}
		$katb_tnumber = $wpdb->num_rows;
		if ( $katb_tnumber == 0 ) $katb_error = __('There are no approved testimonials to display!','testimonial_basics');
	} elseif ( $number == 'all' && $id == '' && $by == 'order' ) {
		if ($group == 'all') {
			$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' ORDER BY `tb_order` DESC,`tb_date` DESC ",ARRAY_A);
		} else {
			$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' AND `tb_group` = '$group' ORDER BY `tb_order` DESC,`tb_date` DESC ",ARRAY_A);
		}
		$katb_tnumber = $wpdb->num_rows;
		if ( $katb_tnumber == 0 ) $katb_error = __('There are no approved testimonials to display!','testimonial_basics');
	} elseif ( intval($number) > 0 && $id == '' && $by == 'date' ) {
		$number = intval( $number );
		if ($group == 'all') {
			$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' ORDER BY `tb_date` DESC LIMIT 0,$number ",ARRAY_A);
		} else {
			$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' AND `tb_group` = '$group' ORDER BY `tb_date` DESC LIMIT 0,$number ",ARRAY_A);
		}
		$katb_tnumber = $wpdb->num_rows;
		if ( $katb_tnumber == 0 ) $katb_error = __('There are no approved testimonials to display!','testimonial_basics');
	} elseif ( intval($number) > 0 && $id == '' && $by == 'order' ) {
		$number = intval( $number );
		if ($group == 'all') {
			$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' ORDER BY `tb_order` DESC,`tb_date` DESC LIMIT 0,$number ",ARRAY_A);
		} else {
			$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' AND `tb_group` = '$group' ORDER BY `tb_order` DESC,`tb_date` DESC LIMIT 0,$number ",ARRAY_A);
		}
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
			if ( $katb_tnumber == 0 ) $katb_error = __('Testimonial not found or approved. Please check your shortcode.','testimonial_basics');
		} else {
			//$id is an unknown
			$katb_error = __('Testimonial not found or approved. Please check your shortcode.','testimonial_basics');
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
		if ( $katb_options['katb_use_formatted_display'] == 1 ) {	
			$katb_html .= '<div class="katb_test_wrap">';
		} else {
			$katb_html .= '<div class="katb_test_wrap_basic">';
		}
		for ( $i = 0 ; $i < $katb_tnumber; $i++ ) {
			
			if ( $katb_options['katb_use_formatted_display'] == 1 ) {
				$katb_html .= '<div class="katb_test_box">';
				if ( $katb_options['katb_use_gravatars'] == 1 ){
					$has_valid_avatar = katb_validate_gravatar($katb_tdata[$i]['tb_email']);
					If ( $has_valid_avatar == 1 ) {
						$katb_html .= '<span class="katb_avatar">'. get_avatar( $katb_tdata[$i]['tb_email'], $size = '60' ).'</span>';
					}
				}	
				$katb_html .= '<div class="katb_test_text">'.stripcslashes($katb_tdata[$i]['tb_testimonial']).'</div>';
				$katb_html .= '<span class="katb_test_meta"><br/>'.stripcslashes($katb_tdata[$i]['tb_name']);
			} else {
				$katb_html .= '<div class="katb_test_box_basic">';
				if ( $katb_options['katb_use_gravatars'] == 1 ) {
					$has_valid_avatar = katb_validate_gravatar($katb_tdata[$i]['tb_email']);
					If ( $has_valid_avatar == 1 ) {
						$katb_html .= '<span class="katb_avatar">'.get_avatar( $katb_tdata[$i]['tb_email'], $size = '60' ).'</span>';
					}
				}
				$katb_html .= '<div class="katb_test_text_basic">'.stripcslashes($katb_tdata[$i]['tb_testimonial']).'</div>';
				$katb_html .= '<span class="katb_test_meta_basic"><strong>'.stripcslashes($katb_tdata[$i]['tb_name']).'</strong>';
			}
			if ($katb_options['katb_show_date'] == 1) {
				$katb_date = $katb_tdata[$i]['tb_date'];
				$year = intval(substr($katb_date,0,4));
				$month = intval(substr($katb_date,5,2));
				$monthname = date("M", mktime(0, 0, 0, $month, 10));
				$day = intval(substr($katb_date,8,2));
				$katb_html .= ', <i>'.$monthname.' '.$day.'\''.$year.'</i>';
			}
			if ($katb_options['katb_show_location'] == 1) {
				if ( $katb_tdata[$i]['tb_location'] != "" ) $katb_html .= ', <i>'.stripcslashes($katb_tdata[$i]['tb_location']).'</i>';
			}
			if ($katb_options['katb_show_website'] == 1) {
				if ( $katb_tdata[$i]['tb_url'] != "" ) $katb_html .= ', <i><a href="'.esc_url($katb_tdata[$i]['tb_url']).'" title="Testimonial_author_site" target="_blank" >Website</a></i>';
			}
			$katb_html .= '</span>';
			$katb_html .= '</div>';
		}
		$katb_html .= '</div>';
	}
	return $katb_html;
}
add_shortcode('katb_testimonial', 'katb_list_testimonials');

?>