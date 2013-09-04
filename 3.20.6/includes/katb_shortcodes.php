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
 * useage : [katb_testimonial group="all" number="all" by="date" id="" rotate="no"] 
 * group : "all" or "group" where group is the identifier in the testimonial
 * by : "date" or "order" or "random"
 * number : "all" or input the number you want to display
 * id : "" or ids of testimonials
 * rotate : "no" do not rotate, "yes" rotate testimonials
 * ------------------------------------------------------------------------- */

function katb_list_testimonials ( $atts) {
	
	//setup database table
	global $wpdb,$tablename;
	$tablename = $wpdb->prefix.'testimonial_basics';
	
	//get user options
	$katb_options = katb_get_options();
	
	//set up pagination
	$katb_offset_name = home_url().'katb_offset';
	
	//$katb_items_per_page = 10;
	$katb_items_per_page = intval($katb_options['katb_paginate_number']);
	
	//Initialize Strings
	$katb_html = '';
	
	//get shortcode variables
	extract(shortcode_atts(array(
		'group' => 'all',
		'number' => 'all',
	    'by' => 'random',
	    'id' => '',
	    'rotate' => 'no'
    ), $atts));
	
	//Sanitize data

	$group = sanitize_text_field( $group );
	$number = strtolower( sanitize_text_field( $number ));
	$by = strtolower( sanitize_text_field( $by ));
	$id = sanitize_text_field($id);
	$rotate = strtolower( sanitize_text_field( $rotate ));
	
	//whitelist rotate
	if( $rotate != 'yes' ) $rotate = 'no';
	
	//white list group
	if( $group == '' ) $group = 'all';
	
	//number validation/whitelist
	if( $number == '' ) $number = 'all';
	if( $number != 'all' ) {
		if( intval( $number ) < 1 ) {
			$number = 1;
		} else {
			$number = intval( $number );
		}
	}
	
	//Validate $by
	if ($by != 'date' && $by != 'order') $by = 'random';
	
	//OK let's start by getting the testimonial data from the database
	if( $id != '' ) {
		$id_picks = array();
		$id_picks_processed = array();
		$id_picks = explode( ',', $id );
		
		$counter = 0;
		foreach( $id_picks as $pick ) {
			$id_picks_processed[$counter] = intval( $id_picks[$counter] );
			if( $id_picks_processed[$counter] < 1 ) $id_picks_processed[$counter] = 1;
			$counter++;
		}
		
		$count = 0;
		$count2 = 0;
		foreach( $id_picks_processed as $pick ) {
			$pick_id = $id_picks_processed[$count];
			$tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' AND `tb_id` = '$pick_id' ",ARRAY_A);
			$tnumber = $wpdb->num_rows;
			if( $tnumber == 1 ) {
				$katb_tdata[ $count2 ] = $tdata[0];
				$count2++;
			}
			$count++;					
		}
		
		$katb_tnumber = $count2;

	} else {
	
		if ( $group == 'all' && $number == 'all' && $by == 'date' ) {
			
			if ( isset($katb_options['katb_use_pagination']) && $katb_options['katb_use_pagination'] == 1 && $rotate == 'no' ) {
				
				//Get total entries
				$results = $wpdb->get_results( " SELECT COUNT(1) FROM `$tablename` WHERE `tb_approved` = '1' ",ARRAY_A);
				$total_entries = $results[0]['COUNT(1)'];
					
				//check for offset
				if( isset ( $_POST['ka_paginate_post'] ) ) {
					$ka_paginate_action = $_POST['ka_paginate_post'];
					katb_offset_setup ( $katb_offset_name, $katb_items_per_page, $ka_paginate_action, $total_entries );
				}
						
				//Pagination
				$katb_paginate_setup = katb_setup_pagination( $katb_offset_name, $katb_items_per_page, $total_entries );
				$katb_offset = $katb_paginate_setup['offset'];
				if ($katb_offset < 0 ) $katb_offset = 0;
				//get results
				$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' ORDER BY `tb_date` DESC LIMIT $katb_items_per_page OFFSET $katb_offset ",ARRAY_A);
			
			} else {
				$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' ORDER BY `tb_date` DESC ",ARRAY_A);
			}
			
			$katb_tnumber = $wpdb->num_rows;
				
		} elseif ( $group == 'all' && $number == 'all' && $by == 'order' ) {
			
			if ( isset($katb_options['katb_use_pagination']) && $katb_options['katb_use_pagination'] == 1 && $rotate == 'no' ) {
						
				//Get total entries
				$results = $wpdb->get_results( " SELECT COUNT(1) FROM `$tablename` WHERE `tb_approved` = '1' ",ARRAY_A);
				$total_entries = $results[0]['COUNT(1)'];
						
				//check for offset
				if( isset ( $_POST['ka_paginate_post'] ) ) {
					$ka_paginate_action = $_POST['ka_paginate_post'];
					katb_offset_setup ( $katb_offset_name, $katb_items_per_page, $ka_paginate_action, $total_entries );
				}
					
				//Pagination
				$katb_paginate_setup = katb_setup_pagination( $katb_offset_name, $katb_items_per_page, $total_entries );
				$katb_offset = $katb_paginate_setup['offset'];
				if ($katb_offset < 0 ) $katb_offset = 0;
				
				//get results
				$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' ORDER BY `tb_order` = '0', `tb_order` ASC,`tb_date` DESC LIMIT $katb_items_per_page OFFSET $katb_offset ",ARRAY_A);
			} else {
				$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' ORDER BY `tb_order` = '0', `tb_order` ASC,`tb_date` DESC ",ARRAY_A);
			}
			
			$katb_tnumber = $wpdb->num_rows;
			
		} elseif ( $group == 'all' && $number == 'all' && $by == 'random' ) {
			$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' ORDER BY RAND() ",ARRAY_A);
			$katb_tnumber = $wpdb->num_rows;
		} elseif ( $group == 'all' && $number != 'all' && $by == 'date' ) {
			$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' ORDER BY `tb_date` DESC LIMIT 0,$number ",ARRAY_A);
			$katb_tnumber = $wpdb->num_rows;
		} elseif ( $group == 'all' && $number != 'all' && $by == 'order' ) {
			$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' ORDER BY `tb_order` = '0',`tb_order` ASC LIMIT 0,$number ",ARRAY_A);
			$katb_tnumber = $wpdb->num_rows;
		} elseif ( $group == 'all' && $number != 'all' && $by == 'random' ) {
			$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' ORDER BY RAND() LIMIT 0,$number ",ARRAY_A);
			$katb_tnumber = $wpdb->num_rows;
		} elseif ( $group != 'all' && $number == 'all' && $by == 'date' ) {
			
			if ( isset($katb_options['katb_use_pagination']) && $katb_options['katb_use_pagination'] == 1 && $rotate == 'no' ) {
					
				//Get total entries
				$results = $wpdb->get_results( " SELECT COUNT(1) FROM `$tablename` WHERE `tb_approved` = '1' AND `tb_group` = '$group' ",ARRAY_A);
				$total_entries = $results[0]['COUNT(1)'];
					
				//check for offset
				if( isset ( $_POST['ka_paginate_post'] ) ) {
					$ka_paginate_action = $_POST['ka_paginate_post'];
					katb_offset_setup ( $katb_offset_name, $katb_items_per_page, $ka_paginate_action, $total_entries );
				}
					
				//Pagination
				$katb_paginate_setup = katb_setup_pagination( $katb_offset_name, $katb_items_per_page, $total_entries );
				$katb_offset = $katb_paginate_setup['offset'];
				//katb_display_pagination( $katb_paginate_setup );
				if ($katb_offset < 0 ) $katb_offset = 0;
				//get results
				$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' AND `tb_group` = '$group' ORDER BY `tb_date` DESC LIMIT $katb_items_per_page OFFSET $katb_offset ",ARRAY_A);
			} else {
				$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' AND `tb_group` = '$group' ORDER BY `tb_date` DESC ",ARRAY_A);
			}
			
			$katb_tnumber = $wpdb->num_rows;
			
		} elseif ( $group != 'all' && $number == 'all' && $by == 'order' ) {
			
			if ( isset($katb_options['katb_use_pagination']) && $katb_options['katb_use_pagination'] == 1 && $rotate == 'no' ) {
					
				//Get total entries
				$results = $wpdb->get_results( " SELECT COUNT(1) FROM `$tablename` WHERE `tb_approved` = '1' AND `tb_group` = '$group' ",ARRAY_A);
				$total_entries = $results[0]['COUNT(1)'];
					
				//check for offset
				if( isset ( $_POST['ka_paginate_post'] ) ) {
					$ka_paginate_action = $_POST['ka_paginate_post'];
					katb_offset_setup ( $katb_offset_name, $katb_items_per_page, $ka_paginate_action, $total_entries );
				}
				
				//Pagination
				$katb_paginate_setup = katb_setup_pagination( $katb_offset_name, $katb_items_per_page, $total_entries );
				$katb_offset = $katb_paginate_setup['offset'];
				if ($katb_offset < 0 ) $katb_offset = 0;
				
				//get results
				$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' AND `tb_group` = '$group' ORDER BY `tb_order` = '0',`tb_order` ASC,`tb_date` DESC LIMIT $katb_items_per_page OFFSET $katb_offset ",ARRAY_A);
			} else {
				$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' AND `tb_group` = '$group' ORDER BY `tb_order` = '0',`tb_order` ASC,`tb_date` DESC ",ARRAY_A);		
			}
			
			$katb_tnumber = $wpdb->num_rows;
			
		} elseif ( $group != 'all' && $number == 'all' && $by == 'random' ) {
			$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' AND `tb_group` = '$group' ORDER BY RAND() ",ARRAY_A);	
			$katb_tnumber = $wpdb->num_rows;	
		} elseif ( $group != 'all' && $number != 'all' && $by == 'date' ) {
			$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' AND `tb_group` = '$group' ORDER BY `tb_date` DESC LIMIT 0,$number ",ARRAY_A);
			$katb_tnumber = $wpdb->num_rows;
		} elseif ( $group != 'all' && $number != 'all' && $by == 'order' ) {
			$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' AND `tb_group` = '$group' ORDER BY `tb_order` = '0',`tb_order` ASC LIMIT 0,$number ",ARRAY_A);
			$katb_tnumber = $wpdb->num_rows;
		} elseif ( $group != 'all' && $number != 'all' && $by == 'random' ) {
			$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' AND `tb_group` = '$group' ORDER BY RAND() LIMIT 0,$number ",ARRAY_A);
			$katb_tnumber = $wpdb->num_rows;
		}
	}
	
		$katb_error = "";
				
		if ( $katb_tnumber < 2 && $rotate == 'yes' ) {
			$katb_error = __('You must have 2 approved testimonials to use a rotated display!','testimonial-basics');
		} elseif ( $katb_tnumber == 0 ) {
			$katb_error = __('There are no approved testimonials to display!','testimonial-basics');
		}

	$rotate == 'yes'? $katb_rotate = 1 : $katb_rotate = 0 ;
	
	// Database queried
	//Lets prepare the return string
	if( $katb_error != '') {
		$katb_html = '<div class="katb_error">'.$katb_error.'</div>';
	} else {
		if ( $katb_options['katb_use_formatted_display'] == 1 ) {
			$return_html = katb_display_testimonials_formated ( $katb_tnumber, $katb_tdata, $katb_rotate );	
			$katb_html .= $return_html;
		} else {
			$return_html = katb_display_testimonials_basic ( $katb_tnumber, $katb_tdata, $katb_rotate );	
			$katb_html .= $return_html;
		}
	}
	//Pagination
	if ( isset($katb_options['katb_use_pagination']) && $katb_options['katb_use_pagination'] == 1 ) {
		$katb_paginate = katb_get_display_pagination_string( $katb_paginate_setup );
		$katb_html .= $katb_paginate;
	}
	return $katb_html;
}
add_shortcode('katb_testimonial', 'katb_list_testimonials');

/** ------------- display testimonial input form shortcode -------------------
 * displays the testimonial input form
 * useage : [katb_input_testimonials] 
 * ------------------------------------------------------------------------- */

function katb_display_input_form() {
	$katb_options = katb_get_options();
	$author_label = $katb_options[ 'katb_author_label' ];
	$email_label = $katb_options[ 'katb_email_label' ];
	$website_label = $katb_options[ 'katb_website_label' ];
	$location_label = $katb_options[ 'katb_location_label' ];
	$testimonial_label = $katb_options[ 'katb_testimonial_label' ];
	$required_label = $katb_options[ 'katb_required_label' ];
	$exclude_website = $katb_options[ 'katb_exclude_website_input' ];
	$exclude_location = $katb_options[ 'katb_exclude_location_input' ];
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
	$html_string .= '<label>'.$author_label.' : </label><input type="text"  maxlength="100" name="tb_author" value="'.esc_attr(stripcslashes($katb_author)).'" /><br/>';
	$html_string .= '<label>'.$email_label.' : </label><input type="text"  maxlength="100" name="tb_email" value="'.esc_attr(stripcslashes($katb_email)).'" /><br/>';
	if( $exclude_website != 1 ) $html_string .= '<label>'.$website_label.' : </label><input type="text"  maxlength="100" name="tb_website" value="'.esc_url(stripcslashes($katb_website)).'" /><br/>';
	if( $exclude_location != 1 ) $html_string .= '<label>'.$location_label.' : </label><input type="text"  maxlength="100" name="tb_location" value="'.esc_attr(stripcslashes($katb_location)).'" /><br/>';
	$html_string .= '<label>'.$testimonial_label.' : </label><br/><textarea rows="5" name="tb_testimonial" >'.wp_kses_post(stripcslashes($katb_testimonial)).'</textarea>';
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
	$html_string .= '<div class="katb_clearboth"></div><p>'.$required_label.'</p>';
	if ($katb_options['katb_use_gravatars'] == 1 || $katb_options['katb_widget_use_gravatars'] == 1 ) {
		$html_string .= '<p>'.__('Add a photo? ','testimonial-basics').'<a href="https://en.gravatar.com/" title="Gravatar Site" target="_blank" ><img class="gravatar_logo" src="'.plugin_dir_url(__FILE__).'Gravatar80x16.jpg" alt="Gravatar Website" title="Gravatar Website" /></a></p>';
	}
	return $html_string;
}
add_shortcode('katb_input_testimonials', 'katb_display_input_form');

/**
 * This function displays the testimonials in the formatted styles
 */
function katb_display_testimonials_formated ( $katb_tnumber , $katb_tdata, $katb_rotate ) {
	//get user options
	$katb_options = katb_get_options();
	//Initialize Strings
	$katb_formatted_html = '';
	
	if( $katb_rotate == 1 ) {
		$katb_formatted_html .= '<div class="katb_test_wrap katb_rotate">';
	} else {
		$katb_formatted_html .= '<div class="katb_test_wrap">';
	}
	

	for ( $i = 0 ; $i < $katb_tnumber; $i++ ) {
		
		//if gravatars are enabled, check for valid avatar
		if ( $katb_options['katb_use_gravatars'] == 1 ) $has_valid_avatar = katb_validate_gravatar( $katb_tdata[$i]['tb_email'] );
		
		//set up hidden popup if excerpt is used	
		if ( $katb_options['katb_use_excerpts'] == 1 ) {
			$popup_html = katb_setup_popup( $i, $katb_tdata, $has_valid_avatar  );
			$katb_formatted_html .= $popup_html;
		}
		
		if( $katb_rotate == 1 ) {
			$katb_formatted_html .= '<div class="katb_test_box ';
			if( $i == 0 ) {
				$katb_formatted_html .= 'katb_rotate_show">';
			} else {
				$katb_formatted_html .= 'katb_rotate_noshow">';
			}
		} else {
			$katb_formatted_html .= '<div class="katb_test_box">';
		}
		
		if ( $katb_options['katb_use_gravatars'] == 1 ){
			If ( $has_valid_avatar == 1 ) {
				$katb_formatted_html .= '<span class="katb_avatar">'. get_avatar( $katb_tdata[$i]['tb_email'], $size = '60' ).'</span>';
			}
		}

		if ( $katb_options['katb_use_excerpts'] == 1 ) {
			$text = wp_kses_post( stripcslashes($katb_tdata[$i]['tb_testimonial'] ) );
			$length = intval( $katb_options['katb_excerpt_length'] );
			$classID = 'katb_content_test_'.sanitize_text_field( $katb_tdata[$i]['tb_id'] );
			$text = katb_testimonial_excerpt_filter($length,$text,$classID);
			$katb_formatted_html .= '<div class="katb_test_text" >'.$text.'</div>';
		} else {
			$katb_formatted_html .= '<div class="katb_test_text" >'.wp_kses_post( stripcslashes($katb_tdata[$i]['tb_testimonial'] ) ).'</div>';
		}
				
		$katb_formatted_html .= '<span class="katb_test_meta"><br/>'.sanitize_text_field( stripcslashes($katb_tdata[$i]['tb_name'] ) );

		if ($katb_options['katb_show_date'] == 1) {
			$katb_date = sanitize_text_field( $katb_tdata[$i]['tb_date'] );
			$katb_formatted_html .= ', <i>'.mysql2date(get_option('date_format'), $katb_date).'</i>';
		}
		
		if ($katb_options['katb_show_location'] == 1) {
			if ( $katb_tdata[$i]['tb_location'] != "" ) $katb_formatted_html .= ', <i>'.sanitize_text_field( stripcslashes($katb_tdata[$i]['tb_location'] ) ).'</i>';
		}
		
		if ($katb_options['katb_show_website'] == 1) {
			if ( $katb_tdata[$i]['tb_url'] != "" ) $katb_formatted_html .= ', <i><a href="'.esc_url($katb_tdata[$i]['tb_url']).'" title="Testimonial_author_site" target="_blank" >Website</a></i>';
		}
		
		$katb_formatted_html .= '</span>';
		$katb_formatted_html .= '</div>';
	}
	
	$katb_formatted_html .= '</div>';
		
	return $katb_formatted_html;
}

/**
 * This function displays the testimonials in basic formatting, native to the theme
 */
function katb_display_testimonials_basic ( $katb_tnumber, $katb_tdata, $katb_rotate ) {
	//get user options
	$katb_options = katb_get_options();
	//Initialize Strings
	$katb_basic_html = '';

	if( $katb_rotate == 1 ) {
		$katb_basic_html .= '<div class="katb_test_wrap_basic katb_rotate">';
	} else {
		$katb_basic_html .= '<div class="katb_test_wrap_basic">';
	}

	for ( $i = 0 ; $i < $katb_tnumber; $i++ ) {
		
		//if gravatars are enabled, check for valid avatar
		if ( $katb_options['katb_use_gravatars'] == 1 ) $has_valid_avatar = katb_validate_gravatar( $katb_tdata[$i]['tb_email'] );
			
		//set up hidden popup if excerpt is used	
		if ( $katb_options['katb_use_excerpts'] == 1 ) {
			$popup_html = katb_setup_popup( $i, $katb_tdata, $has_valid_avatar  );
			$katb_basic_html .= $popup_html;
		}
		
		if( $katb_rotate == 1 ) {
			$katb_basic_html .= '<div class="katb_test_box_basic ';
			if( $i == 0 ) {
				$katb_basic_html .= 'katb_rotate_show">';
			} else {
				$katb_basic_html .= 'katb_rotate_noshow">';
			}
		} else {
			$katb_basic_html .= '<div class="katb_test_box_basic">';
		}		
		
		if ( $katb_options['katb_use_gravatars'] == 1 ) {
			If ( $has_valid_avatar == 1 ) {
				$katb_basic_html .= '<span class="katb_avatar">'.get_avatar( $katb_tdata[$i]['tb_email'], $size = '60' ).'</span>';
			}
		}
		
		if ( $katb_options['katb_use_excerpts'] == 1 ) {
			$text = wp_kses_post( stripcslashes($katb_tdata[$i]['tb_testimonial'] ) );
			$length = intval( $katb_options['katb_excerpt_length'] );
			$classID = 'katb_content_test_'.sanitize_text_field( $katb_tdata[$i]['tb_id'] );
			$text = katb_testimonial_excerpt_filter($length,$text,$classID);
			$katb_basic_html .= '<div class="katb_test_text_basic" >'.$text.'</div>';
		} else {
			$katb_basic_html .= '<div class="katb_test_text_basic" >'.wp_kses_post( stripcslashes($katb_tdata[$i]['tb_testimonial'] ) ).'</div>';
		}
	
		$katb_basic_html .= '<span class="katb_test_meta_basic"><strong>'.sanitize_text_field( stripcslashes($katb_tdata[$i]['tb_name'] ) ).'</strong>';

		if ($katb_options['katb_show_date'] == 1) {
			$katb_date = sanitize_text_field( $katb_tdata[$i]['tb_date'] );
			$katb_basic_html .= ', <i>'.mysql2date(get_option('date_format'), $katb_date).'</i>';
		}
		
		if ($katb_options['katb_show_location'] == 1) {
			if ( $katb_tdata[$i]['tb_location'] != "" ) $katb_basic_html .= ', <i>'.sanitize_text_field( stripcslashes($katb_tdata[$i]['tb_location'] ) ).'</i>';
		}
		
		if ($katb_options['katb_show_website'] == 1) {
			if ( $katb_tdata[$i]['tb_url'] != "" ) $katb_basic_html .= ', <i><a href="'.esc_url($katb_tdata[$i]['tb_url']).'" title="Testimonial_author_site" target="_blank" >Website</a></i>';
		}
		
		$katb_basic_html .= '</span>';
		$katb_basic_html .= '</div>';
	}

	$katb_basic_html .= '</div>';
	return $katb_basic_html;
}

/**
 * This function setsup the html string for the popup testimonial if called
 */
function katb_setup_popup ( $i, $katb_tdata, $has_valid_avatar ) {

	//get user options
	$katb_options = katb_get_options();	
	$katb_popup_html = '';
	
	$katb_popup_html .= '<div class="katb_topopup" id="katb_content_test_'.sanitize_text_field( $katb_tdata[$i]['tb_id'] ).'">';
	$katb_popup_html .= '<div class="katb_close"></div>';
	if ( $katb_options['katb_use_gravatars'] == 1 ){
		If ( $has_valid_avatar == 1 ) {
			$katb_popup_html .= '<span class="katb_avatar">'. get_avatar( $katb_tdata[$i]['tb_email'], $size = '60' ).'</span>';
		}
	}
	$katb_popup_html .= '<div class="katb_popup_text">'.wp_kses_post( stripcslashes($katb_tdata[$i]['tb_testimonial'] ) ).'</div><br/>';
	$katb_popup_html .= '<span class="katb_popup_meta">'.sanitize_text_field( stripcslashes($katb_tdata[$i]['tb_name'] ) );
	if ($katb_options['katb_show_date'] == 1) {
		$katb_date = sanitize_text_field( $katb_tdata[$i]['tb_date'] );
		$katb_popup_html .= ', <i>'.mysql2date(get_option('date_format'), $katb_date).'</i>';
	}
	if ($katb_options['katb_show_location'] == 1) {
		if ( $katb_tdata[$i]['tb_location'] != "" ) $katb_popup_html .= ', '.sanitize_text_field( stripcslashes($katb_tdata[$i]['tb_location'] ) );
	}
	if ($katb_options['katb_show_website'] == 1) {
		if ( $katb_tdata[$i]['tb_url'] != "" ) $katb_popup_html .= ', <i><a href="'.esc_url($katb_tdata[$i]['tb_url']).'" title="Testimonial_author_site" target="_blank" >Website</a></i>';
	}
	$katb_popup_html .= '</span></div>';
	$katb_popup_html .= '<div class="katb_loader"></div>';
	$katb_popup_html .= '<div class="katb_excerpt_popup_bg" id="katb_content_test_'.sanitize_text_field( $katb_tdata[$i]['tb_id'] ).'_bg"></div>';
	
	return $katb_popup_html;	
}