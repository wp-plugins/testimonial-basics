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

/* ------------------ display testimonials shortcode ---------------------------------
 * useage : [katb_testimonial group="all" by="date" number="all" id=""] 
 * group : "all" or "group" where group is the identifier in the testimonial
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
			if ( isset($katb_options['katb_use_pagination']) && $katb_options['katb_use_pagination'] == 1 ) {
				$results = $wpdb->get_results( " SELECT COUNT(1) FROM `$tablename` WHERE `tb_approved` = '1' ORDER BY `tb_date` DESC ",ARRAY_A);
				$katb_total_test = $results[0]['COUNT(1)'];
				$katb_total_test = intval($katb_total_test);
				if( isset ( $_POST['katb_display_paginate_post'] ) ) {
					$katb_post_button = $_POST['katb_display_paginate_post'];
					katb_setup_pagination($katb_total_test,$katb_post_button);
				}
				if ( isset( $_SESSION['katb_paginate_offset'] ) ) {
					$katb_offset = $_SESSION['katb_paginate_offset'];
					if ( $katb_offset > $katb_total_test - 1 ) $katb_offset = 0;
					$_SESSION['katb_paginate_offset'] = $katb_offset;
				} else {
					$katb_offset = 0;
					$_SESSION['katb_paginate_offset'] = $katb_offset;
				}
				$katb_limit = intval($katb_options['katb_paginate_number']);
				$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' ORDER BY `tb_date` DESC LIMIT $katb_limit OFFSET $katb_offset ",ARRAY_A);	
			} else {
				$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' ORDER BY `tb_date` DESC ",ARRAY_A);
			}
		} else {
			if ( isset($katb_options['katb_use_pagination']) && $katb_options['katb_use_pagination'] == 1 ) {
				$results = $wpdb->get_results( " SELECT COUNT(1) FROM `$tablename` WHERE `tb_approved` = '1' AND `tb_group` = '$group' ORDER BY `tb_date` DESC ",ARRAY_A);
				$katb_total_test = $results[0]['COUNT(1)'];
				$katb_total_test = intval($katb_total_test);
				if( isset ( $_POST['katb_display_paginate_post'] ) ) {
					$katb_post_button = $_POST['katb_display_paginate_post'];
					katb_setup_pagination($katb_total_test,$katb_post_button);
				}
				if ( isset( $_SESSION['katb_paginate_offset'] ) ) {
					$katb_offset = $_SESSION['katb_paginate_offset'];
					if ( $katb_offset > $katb_total_test - 1 ) $katb_offset = 0;
					$_SESSION['katb_paginate_offset'] = $katb_offset;
				} else {
					$katb_offset = 0;
					$_SESSION['katb_paginate_offset'] = $katb_offset;
				}
				$katb_limit = intval($katb_options['katb_paginate_number']);
				$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' AND `tb_group` = '$group' ORDER BY `tb_date` DESC LIMIT $katb_limit OFFSET $katb_offset ",ARRAY_A);
			} else {
				$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' AND `tb_group` = '$group' ORDER BY `tb_date` DESC ",ARRAY_A);
			}
		}
		$katb_tnumber = $wpdb->num_rows;
		if ( $katb_tnumber == 0 ) $katb_error = __('There are no approved testimonials to display!','testimonial_basics');
	} elseif ( $number == 'all' && $id == '' && $by == 'order' ) {
		if ($group == 'all') {
			if ( isset($katb_options['katb_use_pagination']) && $katb_options['katb_use_pagination'] == 1 ) {
				$results = $wpdb->get_results( " SELECT COUNT(1) FROM `$tablename` WHERE `tb_approved` = '1' ORDER BY `tb_order` = '0', `tb_order` ASC,`tb_date` DESC ",ARRAY_A);
				$katb_total_test = $results[0]['COUNT(1)'];
				$katb_total_test = intval($katb_total_test);
				if( isset ( $_POST['katb_display_paginate_post'] ) ) {
					$katb_post_button = $_POST['katb_display_paginate_post'];
					katb_setup_pagination($katb_total_test,$katb_post_button);
				}
				if ( isset( $_SESSION['katb_paginate_offset'] ) ) {
					$katb_offset = $_SESSION['katb_paginate_offset'];
					if ( $katb_offset > $katb_total_test - 1 ) $katb_offset = 0;
					$_SESSION['katb_paginate_offset'] = $katb_offset;
				} else {
					$katb_offset = 0;
					$_SESSION['katb_paginate_offset'] = $katb_offset;
				}
				$katb_limit = intval($katb_options['katb_paginate_number']);
				$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' ORDER BY `tb_order` = '0', `tb_order` ASC,`tb_date` DESC LIMIT $katb_limit OFFSET $katb_offset ",ARRAY_A);
			} else {
				$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' ORDER BY `tb_order` = '0', `tb_order` ASC,`tb_date` DESC ",ARRAY_A);
			}
		} else {
			if ( isset($katb_options['katb_use_pagination']) && $katb_options['katb_use_pagination'] == 1 ) {
				$results = $wpdb->get_results( " SELECT COUNT(1) FROM `$tablename` WHERE `tb_approved` = '1' AND `tb_group` = '$group' ORDER BY `tb_order` = '0',`tb_order` ASC,`tb_date` DESC ",ARRAY_A);
				$katb_total_test = $results[0]['COUNT(1)'];
				$katb_total_test = intval($katb_total_test);
				if( isset ( $_POST['katb_display_paginate_post'] ) ) {
					$katb_post_button = $_POST['katb_display_paginate_post'];
					katb_setup_pagination($katb_total_test,$katb_post_button);
				}
				if ( isset( $_SESSION['katb_paginate_offset'] ) ) {
					$katb_offset = $_SESSION['katb_paginate_offset'];
					if ( $katb_offset > $katb_total_test - 1 ) $katb_offset = 0;
					$_SESSION['katb_paginate_offset'] = $katb_offset;
				} else {
					$katb_offset = 0;
					$_SESSION['katb_paginate_offset'] = $katb_offset;
				}
				$katb_limit = intval($katb_options['katb_paginate_number']);
				//echo $group." ". $katb_limit." ".$katb_offset." ".$katb_total_test;
				$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' AND `tb_group` = '$group' ORDER BY `tb_order` = '0',`tb_order` ASC,`tb_date` DESC LIMIT $katb_limit OFFSET $katb_offset ",ARRAY_A);
			} else {
				$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' AND `tb_group` = '$group' ORDER BY `tb_order` = '0',`tb_order` ASC,`tb_date` DESC ",ARRAY_A);		
			}
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
			$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' ORDER BY `tb_order` = '0',`tb_order` ASC,`tb_date` DESC LIMIT 0,$number ",ARRAY_A);
		} else {
			$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' AND `tb_group` = '$group' ORDER BY `tb_order` = '0',`tb_order` ASC,`tb_date` DESC LIMIT 0,$number ",ARRAY_A);
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
		} elseif (intval($id) != '') {
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
			//check for a valid avatar if enabled
			if ( $katb_options['katb_use_gravatars'] == 1 )$has_valid_avatar = katb_validate_gravatar($katb_tdata[$i]['tb_email']);
			//set up hidden popup if excerpt is used	
			if ( $katb_options['katb_use_excerpts'] == 1 ) {
				$katb_html .= '<div class="katb_topopup" id="katb_content_test_'.sanitize_text_field($katb_tdata[$i]['tb_id']).'">';
				$katb_html .= '<div class="katb_close"></div>';
				if ( $katb_options['katb_use_gravatars'] == 1 ){
					If ( $has_valid_avatar == 1 ) {
						$katb_html .= '<span class="katb_avatar">'.get_avatar( $katb_tdata[$i]['tb_email'], $size = '60' ).'</span>';
					}
				}
				$katb_html .= '<div class="katb_popup_text">'.wp_kses_post(stripcslashes($katb_tdata[$i]['tb_testimonial'])).'</div><br/>';
				$katb_html .= '<span class="katb_popup_meta">'.sanitize_text_field(stripcslashes($katb_tdata[$i]['tb_name']));
				if ($katb_options['katb_show_date'] == 1) {
					$katb_date = $katb_tdata[$i]['tb_date'];
					$katb_html .= ', <i>'.mysql2date( get_option( 'date_format' ), sanitize_text_field( $katb_date ) ).'</i>';
				}
				if ($katb_options['katb_show_location'] == 1) {
					if ( $katb_tdata[$i]['tb_location'] != "" ) $katb_html .= ', '.sanitize_text_field( stripcslashes($katb_tdata[$i]['tb_location'] ) );
				}
				if ($katb_options['katb_show_website'] == 1) {
					if ( $katb_tdata[$i]['tb_url'] != "" ) $katb_html .= ', <i><a href="'.esc_url($katb_tdata[$i]['tb_url']).'" title="Testimonial_author_site" target="_blank" >Website</a></i>';
				}
				$katb_html .= '</span></div>';
				$katb_html .= '<div class="katb_loader"></div>';
				$katb_html .= '<div class="katb_excerpt_popup_bg" id="katb_content_test_'.sanitize_text_field( $katb_tdata[$i]['tb_id'] ).'_bg"></div>';
			}			
			if ( $katb_options['katb_use_formatted_display'] == 1 ) {
				$katb_html .= '<div class="katb_test_box">';
				if ( $katb_options['katb_use_gravatars'] == 1 ){
					If ( $has_valid_avatar == 1 ) {
						$katb_html .= '<span class="katb_avatar">'.get_avatar( $katb_tdata[$i]['tb_email'], $size = '60' ).'</span>';
					}
				}
				if ( $katb_options['katb_use_excerpts'] == 1 ) {
					$text = wp_kses_post ( stripcslashes ( $katb_tdata[$i]['tb_testimonial'] ) );
					$length = intval( $katb_options['katb_excerpt_length'] );
					$classID = 'katb_content_test_'.sanitize_text_field( $katb_tdata[$i]['tb_id'] );
					$text = katb_testimonial_excerpt_filter( $length, $text, $classID );
					$katb_html .= '<div class="katb_test_text" >'.$text.'</div>';
				} else {
					$katb_html .= '<div class="katb_test_text" >'.wp_kses_post( stripcslashes( $katb_tdata[$i]['tb_testimonial'] ) ).'</div>';
				}		
				$katb_html .= '<span class="katb_test_meta"><br/>'.sanitize_text_field( stripcslashes( $katb_tdata[$i]['tb_name'] ) );
			} else {
				$katb_html .= '<div class="katb_test_box_basic">';
				if ( $katb_options['katb_use_gravatars'] == 1 ) {
					If ( $has_valid_avatar == 1 ) {
						$katb_html .= '<span class="katb_avatar">'.get_avatar( $katb_tdata[$i]['tb_email'], $size = '60' ).'</span>';
					}
				}
				if ( $katb_options['katb_use_excerpts'] == 1 ) {
					$text = wp_kses_post( stripcslashes( $katb_tdata[$i]['tb_testimonial'] ) );
					$length = intval( $katb_options['katb_excerpt_length'] );
					$classID = 'katb_content_test_'.sanitize_text_field( $katb_tdata[$i]['tb_id'] );
					$text = katb_testimonial_excerpt_filter($length,$text,$classID);
					$katb_html .= '<div class="katb_test_text_basic" >'.$text.'</div>';
				} else {
					$katb_html .= '<div class="katb_test_text_basic" >'.wp_kses_post( stripcslashes( $katb_tdata[$i]['tb_testimonial'] ) ).'</div>';
				}		
				$katb_html .= '<span class="katb_test_meta_basic"><strong>'.sanitize_text_field( stripcslashes($katb_tdata[$i]['tb_name'] ) ).'</strong>';
			}
			if ($katb_options['katb_show_date'] == 1) {
				$katb_date = sanitize_text_field( $katb_tdata[$i]['tb_date'] );
				$katb_html .= ', <i>'.mysql2date(get_option('date_format'), $katb_date).'</i>';
			}
			if ($katb_options['katb_show_location'] == 1) {
				if ( $katb_tdata[$i]['tb_location'] != "" ) $katb_html .= ', <i>'.sanitize_text_field( stripcslashes($katb_tdata[$i]['tb_location'] ) ).'</i>';
			}
			if ($katb_options['katb_show_website'] == 1) {
				if ( $katb_tdata[$i]['tb_url'] != "" ) $katb_html .= ', <i><a href="'.esc_url($katb_tdata[$i]['tb_url']).'" title="Testimonial_author_site" target="_blank" >Website</a></i>';
			}
			$katb_html .= '</span>';
			$katb_html .= '</div>';
		}
		$katb_html .= '</div>';
		//Pagination
		if ( isset($katb_options['katb_use_pagination']) && $katb_options['katb_use_pagination'] == 1 ) {
			$katb_paginate = katb_display_pagination($katb_total_test, $katb_offset, $katb_limit);
			$katb_html .= $katb_paginate;
		}
	}
	return $katb_html;
}
add_shortcode('katb_testimonial', 'katb_list_testimonials');

/** ----------- display random testimonials shortcode ------------------------
 * selects testimonials randomly and displays them
 * useage : [katb_random_testimonials group="all" number="all"] 
 * group : "all" or "group" where group is the identifier in the testimonial
 * number : "all" or input the number you want to display
 * ------------------------------------------------------------------------- */

function katb_display_random_testimonials( $atts ) {
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
	    'number' => 'all',
    ), $atts));
	//Sanitize data
	$group = sanitize_text_field($group);
	$number = sanitize_text_field($number);
	//Lets get the testimonials
	$number = intval($number);
	//start by checking that there are testimonials there
	if ( $group == 'all' ) {
		if ( $number != 0 ) {
			$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' ORDER BY RAND() LIMIT 0,$number ",ARRAY_A );
		} else {
			$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' ORDER BY RAND() ",ARRAY_A );
		}
		$katb_tnumber = $wpdb->num_rows;				
		if ( $katb_tnumber == 0 ) {
			$katb_error = __('There are no approved testimonials to display!','testimonial_basics');
		}
	} else {
		if ( $number > 0 ) {
			$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' AND `tb_group` = '$group' ORDER BY RAND() LIMIT 0,$number ",ARRAY_A );
		} else {
			$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' AND `tb_group` = '$group' ORDER BY RAND() ",ARRAY_A );
		}
		$katb_tnumber = $wpdb->num_rows;				
		if ( $katb_tnumber == 0 ) {
			$katb_error = __('There are no approved testimonials in that group to display!','testimonial_basics');
		}
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
			//if gravatars are enabled, check for valid avatar
			if ( $katb_options['katb_use_gravatars'] == 1 )$has_valid_avatar = katb_validate_gravatar($katb_tdata[$i]['tb_email']);
			//set up hidden popup if excerpt is used	
			if ( $katb_options['katb_use_excerpts'] == 1 ) {
				$katb_html .= '<div class="katb_topopup" id="katb_content_test_'.sanitize_text_field( $katb_tdata[$i]['tb_id'] ).'">';
				$katb_html .= '<div class="katb_close"></div>';
				if ( $katb_options['katb_use_gravatars'] == 1 ){
					If ( $has_valid_avatar == 1 ) {
						$katb_html .= '<span class="katb_avatar">'. get_avatar( $katb_tdata[$i]['tb_email'], $size = '60' ).'</span>';
					}
				}
				$katb_html .= '<div class="katb_popup_text">'.wp_kses_post( stripcslashes($katb_tdata[$i]['tb_testimonial'] ) ).'</div><br/>';
				$katb_html .= '<span class="katb_popup_meta">'.sanitize_text_field( stripcslashes($katb_tdata[$i]['tb_name'] ) );
				if ($katb_options['katb_show_date'] == 1) {
					$katb_date = sanitize_text_field( $katb_tdata[$i]['tb_date'] );
					$katb_html .= ', <i>'.mysql2date(get_option('date_format'), $katb_date).'</i>';
				}
				if ($katb_options['katb_show_location'] == 1) {
					if ( $katb_tdata[$i]['tb_location'] != "" ) $katb_html .= ', '.sanitize_text_field( stripcslashes($katb_tdata[$i]['tb_location'] ) );
				}
				if ($katb_options['katb_show_website'] == 1) {
					if ( $katb_tdata[$i]['tb_url'] != "" ) $katb_html .= ', <i><a href="'.esc_url($katb_tdata[$i]['tb_url']).'" title="Testimonial_author_site" target="_blank" >Website</a></i>';
				}
				$katb_html .= '</span></div>';
				$katb_html .= '<div class="katb_loader"></div>';
				$katb_html .= '<div class="katb_excerpt_popup_bg" id="katb_content_test_'.sanitize_text_field( $katb_tdata[$i]['tb_id'] ).'_bg"></div>';
			}			
			if ( $katb_options['katb_use_formatted_display'] == 1 ) {
				$katb_html .= '<div class="katb_test_box">';
				if ( $katb_options['katb_use_gravatars'] == 1 ){
					If ( $has_valid_avatar == 1 ) {
						$katb_html .= '<span class="katb_avatar">'. get_avatar( $katb_tdata[$i]['tb_email'], $size = '60' ).'</span>';
					}
				}
				if ( $katb_options['katb_use_excerpts'] == 1 ) {
					$text = wp_kses_post( stripcslashes($katb_tdata[$i]['tb_testimonial'] ) );
					$length = intval( $katb_options['katb_excerpt_length'] );
					$classID = 'katb_content_test_'.sanitize_text_field( $katb_tdata[$i]['tb_id'] );
					$text = katb_testimonial_excerpt_filter($length,$text,$classID);
					$katb_html .= '<div class="katb_test_text" >'.$text.'</div>';
				} else {
					$katb_html .= '<div class="katb_test_text" >'.wp_kses_post( stripcslashes($katb_tdata[$i]['tb_testimonial'] ) ).'</div>';
				}			
				$katb_html .= '<span class="katb_test_meta"><br/>'.sanitize_text_field( stripcslashes($katb_tdata[$i]['tb_name'] ) );
			} else {
				$katb_html .= '<div class="katb_test_box_basic">';
				if ( $katb_options['katb_use_gravatars'] == 1 ) {
					If ( $has_valid_avatar == 1 ) {
						$katb_html .= '<span class="katb_avatar">'.get_avatar( $katb_tdata[$i]['tb_email'], $size = '60' ).'</span>';
					}
				}
				if ( $katb_options['katb_use_excerpts'] == 1 ) {
					$text = wp_kses_post( stripcslashes($katb_tdata[$i]['tb_testimonial'] ) );
					$length = intval( $katb_options['katb_excerpt_length'] );
					$classID = 'katb_content_test_'.sanitize_text_field( $katb_tdata[$i]['tb_id'] );
					$text = katb_testimonial_excerpt_filter($length,$text,$classID);
					$katb_html .= '<div class="katb_test_text_basic" >'.$text.'</div>';
				} else {
					$katb_html .= '<div class="katb_test_text_basic" >'.wp_kses_post( stripcslashes($katb_tdata[$i]['tb_testimonial'] ) ).'</div>';
				}		
				$katb_html .= '<span class="katb_test_meta_basic"><strong>'.sanitize_text_field( stripcslashes($katb_tdata[$i]['tb_name'] ) ).'</strong>';
			}
			if ($katb_options['katb_show_date'] == 1) {
				$katb_date = sanitize_text_field( $katb_tdata[$i]['tb_date'] );
				$katb_html .= ', <i>'.mysql2date(get_option('date_format'), $katb_date).'</i>';
			}
			if ($katb_options['katb_show_location'] == 1) {
				if ( $katb_tdata[$i]['tb_location'] != "" ) $katb_html .= ', <i>'.sanitize_text_field( stripcslashes($katb_tdata[$i]['tb_location'] ) ).'</i>';
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
add_shortcode('katb_random_testimonials', 'katb_display_random_testimonials');

/** ------------- display testimonial input form shortcode -------------------
 * displays the testimonial input form
 * useage : [katb_input_testimonials] 
 * ------------------------------------------------------------------------- */

function katb_display_input_form() {
	$katb_options = katb_get_options();
	global $katb_author,$katb_email,$katb_website,$katb_location,$katb_testimonial,$katb_input_error,$katb_input_success;
	if( $katb_input_error != '') echo '<span class="katb_error">'.__('There were errors so the testimonial was not added: ','testimonial-basics').$katb_input_error.'</span>';
	if( isset($_SESSION['katb_submitted']) && $_SESSION['katb_submitted'] == SHA1('true')) {
		echo '<span class="katb_test_sent">'.__('Submitted - Thankyou!','testimonial-basics').'</span>';
		$_SESSION['katb_submitted'] = SHA1('false');
	}
	$html_string = '';	
	if ($katb_options['katb_include_input_title'] == 1){
		$html_string .= "<h1>".esc_attr(stripcslashes($katb_options['katb_input_title']))."</h1>";
	}
	if ($katb_options['katb_include_email_note'] == 1) {
		$html_string .= '<p>'.esc_attr(stripcslashes($katb_options['katb_email_note'])).'</p>';
	}
	$html_string .= '<div class="katb_input_style">';
	$html_string .= '<form method="POST" action="#">';
	$html_string .= '<label>*'.__('Author','testimonial-basics').' : </label><input type="text"  maxlength="100" name="tb_author" value="'.esc_attr(stripcslashes($katb_author)).'" /><br/>';
	$html_string .= '<label>*'.__('Email','testimonial-basics').'  : </label><input type="text"  maxlength="100" name="tb_email" value="'.esc_attr(stripcslashes($katb_email)).'" /><br/>';
	$html_string .= '<label>'.__('Website','testimonial-basics').'  : </label><input type="text"  maxlength="100" name="tb_website" value="'.esc_url(stripcslashes($katb_website)).'" /><br/>';
	$html_string .= '<label>'.__('Location','testimonial-basics').' : </label><input type="text"  maxlength="100" name="tb_location" value="'.esc_attr(stripcslashes($katb_location)).'" /><br/>';
	$html_string .= '<label>*'.__('Testimonial','testimonial-basics').' : </label><br/><textarea rows="5" name="tb_testimonial" >'.wp_kses_post(stripcslashes($katb_testimonial)).'</textarea>';
	if ( $katb_options['katb_show_html_content'] == TRUE || $katb_options['katb_show_html_content'] == 1 ) {
		$html_string .= '<p>HTML '.__('Allowed','testimonial-basics').': <code>a p br i em strong q h1-h6</code></p><br/>';
	}
	if ( $katb_options['katb_use_captcha'] == TRUE || $katb_options['katb_use_captcha'] == 1 ) {
		$html_string .= '<div class="katb_captcha">';
		$html_string .=	'<label for="verify_main">'.__('Verification','testimonial-basics').': </label>';
		$html_string .=	'<input type="text" id="verify_main" name="verify" value="'.__('Enter Captcha Letters','testimonial-basics').'" onclick="this.select();" />';
		if ( $katb_options['katb_use_color_captcha'] == TRUE || $katb_options['katb_use_color_captcha'] == 1 ) {
			$html_string .= '<img src="'.plugin_dir_url(__FILE__).'katb_captcha_color.php" alt="Verification Captcha" />';
		} else {
			$html_string .= '<img src="'.plugin_dir_url(__FILE__).'katb_captcha_bw.php" alt="Verification Captcha" />';
		}
		$html_string .= '</div>';
	}
	$html_string .= '<input class="katb_submit" type="submit" name="katb_submitted" value="'.__('Submit','testimonial-basics').'" />';
	$html_string .= '<input class="katb_reset" type="submit" name="katb_reset" value="'.__('Reset','testimonial-basics').'" />';
	$html_string .= wp_nonce_field("katb_nonce_1","katb_main_form_nonce",false,false);
	$html_string .= '</form>';
	$html_string .= '</div>';
	$html_string .= '<div class="katb_clearboth"></div><p>* '.__('Required','testimonial-basics').'</p>';
	if ($katb_options['katb_use_gravatars'] == 1 || $katb_options['katb_widget_use_gravatars'] == 1 ) {
		$html_string .= '<p>'.__('Add a photo? ','testimonial-basics').'<a href="https://en.gravatar.com/" title="Gravatar Site" target="_blank" ><img class="gravatar_logo" src="'.plugin_dir_url(__FILE__).'Gravatar80x16.jpg" alt="Gravatar Website" title="Gravatar Website" /></a></p>';
	}
	return $html_string;
}
add_shortcode('katb_input_testimonials', 'katb_display_input_form');

/**
 * 
 */
function katb_setup_pagination($katb_total_test,$katb_post_button){
		$katb_options = katb_get_options();
		if ( isset( $_SESSION['katb_paginate_offset'] ) ) {
			$katb_paginate_offset = $_SESSION['katb_paginate_offset'];
		} else {
			$katb_paginate_offset = 0;
		}
		$katb_paginate_span = intval($katb_options['katb_paginate_number']);
		$pages_dec = $katb_total_test/$katb_paginate_span;
		$pages = ceil( $pages_dec );
		$page_selected = ( $katb_paginate_offset/$katb_paginate_span + 1 );
		if ( $page_selected < 1 ) $page_selected = 1;
		$max_page_buttons = 5;
		//Figure out $page_a
		$j = 5;
		while( $page_selected >= $j ){ $j = $j + $max_page_buttons; }
		$page_a = $j - $max_page_buttons + 1;
		if ( $katb_post_button == '<<' ) {
			$_SESSION['katb_paginate_offset'] = 0;
		} elseif ( $katb_post_button == '<' ) {
			if ( $page_a - $max_page_buttons < 1 ) {
				$_SESSION['katb_paginate_offset'] = 0;
			} else {
				$offset = ( $page_a - $max_page_buttons - 1 ) * $katb_paginate_span;
				$_SESSION['katb_paginate_offset'] = $offset;
			}
		} elseif ( $katb_post_button == '^' ) {
			$offset = (floor($pages/2) - 1) * $katb_paginate_span;
			$_SESSION['katb_paginate_offset'] = $offset;
		} elseif ( $katb_post_button == '>' ) {
			if ( $page_a + $max_page_buttons <= $pages ) {
				$offset = ( $page_a + $max_page_buttons - 1 ) * $katb_paginate_span;
				$_SESSION['katb_paginate_offset'] = $offset;
			}
		} elseif ( $katb_post_button == '>>' ) {
			$offset = ($pages - 1) * $katb_paginate_span;
			$_SESSION['katb_paginate_offset'] = $offset;
		} else {
			$page_no = intval($katb_post_button);
			$offset = ( $page_no - 1 ) * $katb_paginate_span;
			$_SESSION['katb_paginate_offset'] = $offset;
		}	
}
 
 /**
  * 
  */
function katb_display_pagination($katb_total_test, $katb_paginate_offset, $katb_paginate_span){
	//Check for offset and set to 0 if not there
	if ( isset( $_SESSION['katb_paginate_offset'] ) ) {
		$katb_paginate_offset = $_SESSION['katb_paginate_offset'];
	} else {
		$katb_paginate_offset = 0;
	}
	//Calculate display pages required given the span
	$pages_dec = $katb_total_test/$katb_paginate_span;
	$pages = ceil( $pages_dec );
	//calculate the page selected based on the offset
	$page_selected = ( $katb_paginate_offset/$katb_paginate_span + 1 );
	if ( $page_selected < 1 ) $page_selected = 1;
	//Figure our the pages to list
	$max_page_buttons = 5;
	//Figure out $page_a
	$j = $max_page_buttons;
	while( $page_selected > $j ){ $j = $j + $max_page_buttons; }
	$page_a = $j - $max_page_buttons + 1;
	//Set up display configuration
	//only display the first button if there are a lot of testimonials
	if ( $pages > ( $max_page_buttons * 2 ) ) {
		$first = 'yes';
	} else {
		$first = 'no';
	}
	//only display the previous button if more than 1 set
	if ( $pages > $max_page_buttons ) {
		$previous = 'yes';
	} else {
		$previous = 'no';
	}
	//set up remaining page buttons
	if ( ($page_a + 1) < ($pages + 1) ) {
		$page_b = $page_a + 1;
	} else {
		$page_b = 'no';
	}
	if ( ($page_a + 2) < ($pages + 1) ) {
		$page_c = $page_a + 2;
	} else {
		$page_c = 'no';
	}
	if ( ($page_a + 3) < ($pages + 1) ) {
		$page_d = $page_a + 3;
	} else {
		$page_d = 'no';
	}
	if ( ($page_a + 4) < ($pages + 1) ) {
		$page_e = $page_a + 4;
	} else {
		$page_e = 'no';
	}
	//only display middle button for large number of testimonials
	if ( $pages > ( $max_page_buttons * 2 ) ) {
		$middle = 'yes';
	} else {
		$middle = 'no';
	}
	//only display the next button if more than 1 set
	if ( $pages > $max_page_buttons ) {
		$next = 'yes';
	} else {
		$next = 'no';
	}
	//only display the last button if there are a lot of testimonials
	if ( $pages > ( $max_page_buttons * 2 ) ) {
		$last = 'yes';
	} else {
		$last = 'no';
	}
	//if ($katb_paginate_offset < 0 ) $katb_paginate_offset = 0;
	//$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` ORDER BY `tb_date` LIMIT $katb_paginate_span OFFSET $katb_paginate_offset ",ARRAY_A);
	//$katb_tnumber = $wpdb->num_rows;
	$html_return = '';
			
	$html_return .= '<form method="POST" action="#">';
		if ( $pages > 1 ) {
			$html_return .= '<span class="katb_display_paginate_summary">'.__('Page','testimonial-basics').' '.$page_selected.' '.__('of','testimonial-basics').' '.$pages.'</span>';
			if ( $first != 'no' ) $html_return .= '<input type="submit" name="katb_display_paginate_post" value="<<" title="First" class="katb_display_paginate" />';
			if ( $previous != 'no') $html_return .= '<input type="submit" name="katb_display_paginate_post" value="<" title="Previous" class="katb_display_paginate" />';
			if ( $page_a == $page_selected ) {
				$html_return .= '<input type="submit" name="katb_display_paginate_post" value="'.$page_a.'" class="katb_display_paginate_selected"  />';
			} else {
				$html_return .= '<input type="submit" name="katb_display_paginate_post" value="'.$page_a.'" class="katb_display_paginate"  />';
			}
			if ( $page_b == $page_selected ) {
				if ( $page_b != "no" ) $html_return .= '<input type="submit" name="katb_display_paginate_post" value="'.$page_b.'" class="katb_display_paginate_selected" />';
			} else {
				if ( $page_b != "no" ) $html_return .= '<input type="submit" name="katb_display_paginate_post" value="'.$page_b.'" class="katb_display_paginate" />';
			}
			if ( $page_c == $page_selected ) {
				if ( $page_c != "no" ) $html_return .= '<input type="submit" name="katb_display_paginate_post" value="'.$page_c.'" class="katb_display_paginate_selected" />';
			} else {
				if ( $page_c != "no" ) $html_return .= '<input type="submit" name="katb_display_paginate_post" value="'.$page_c.'" class="katb_display_paginate" />';
			}
			if ( $page_d == $page_selected ) {
				if ( $page_d != "no" ) $html_return .= '<input type="submit" name="katb_display_paginate_post" value="'.$page_d.'" class="katb_display_paginate_selected" />';
			} else {
				if ( $page_d != "no" ) $html_return .= '<input type="submit" name="katb_display_paginate_post" value="'.$page_d.'" class="katb_display_paginate" />';
			}
			if ( $page_e == $page_selected ) {
				if ( $page_e != "no" ) $html_return .= '<input type="submit" name="katb_display_paginate_post" value="'.$page_e.'" class="katb_display_paginate_selected" />';
			} else {
				if ( $page_e != "no" ) $html_return .= '<input type="submit" name="katb_display_paginate_post" value="'.$page_e.'" class="katb_display_paginate" />';
			}
			if ( $middle != "no" ) $html_return .= '<input type="submit" name="katb_display_paginate_post" value="^" title="Middle" class="katb_display_paginate" />';
			if ( $next != 'no' ) $html_return .= '<input type="submit" name="katb_display_paginate_post" value=">" title="Next" class="katb_display_paginate" />';
			if ( $last != 'no' ) $html_return .= '<input type="submit" name="katb_display_paginate_post" value=">>" title="Last" class="katb_display_paginate" />';
		}
	$html_return .= '</form>';
	return $html_return;
}

?>