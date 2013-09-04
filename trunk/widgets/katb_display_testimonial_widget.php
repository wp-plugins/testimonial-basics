<?php
/*
Plugin Name: Testimonial Basics Rotator Display Widget
Plugin URI: http://kevinsspace.ca/testimonial-basics-wordpress-plugin/
Description: A plugin to display testimonials in a slider
Version: 3.0.0
Author: Kevin Archibald
Author URI: http://kevinsspace.ca/
License: GPLv3
 */
 
 // use widgets_init action hook to execute custom function
 add_action ( 'widgets_init','katb_display_register_widget' );

//register our widget 
 function katb_display_register_widget() {
 	register_widget ( 'katb_display_testimonial_widget' );
 }
 
 //widget class
class katb_display_testimonial_widget extends WP_Widget {

    //process the new widget
    function katb_display_testimonial_widget() {
        $widget_ops = array( 
			'classname' => 'katb_display_widget_class', 
			'description' => __('Display Testimonials.','testimonial-basics') 
			); 
        $this->WP_Widget( 'katb_display_testimonial_widget', __('Testimonial Display Widget','testimonial-basics'), $widget_ops );
    }
 	
 	// Form for widget setup
 	function form ( $instance ) {
 		$katb_display_defaults = array(
			'katb_display_widget_title' => 'Testimonials',
			'katb_display_widget_group' => 'all',
			'katb_display_widget_number' => 'all',
			'katb_display_widget_by' => 'date',
			'katb_display_widget_ids' => '',
			'katb_display_widget_rotate' => 'no'
		);
		$instance = wp_parse_args( (array) $instance, $katb_display_defaults );
		$title = $instance['katb_display_widget_title'];
		$group = $instance['katb_display_widget_group'];
		$number = $instance['katb_display_widget_number'];
		$by = $instance['katb_display_widget_by'];
		$ids = $instance['katb_display_widget_ids'];
		$rotate = $instance['katb_display_widget_rotate'];
		?>
		<p>Title : <input class="widefat" id="<?php echo $this->get_field_id('katb_display_widget_title'); ?>" name="<?php echo $this->get_field_name('katb_display_widget_title'); ?>" type="text" value="<?php echo $title; ?>" /></p>
		<p>Group : <input class="widefat" id="<?php echo $this->get_field_id('katb_display_widget_group'); ?>" name="<?php echo $this->get_field_name('katb_display_widget_group'); ?>" type="text" value="<?php echo $group; ?>" /></p>
		<p>Number : <input class="widefat" id="<?php echo $this->get_field_id('katb_display_widget_number'); ?>" name="<?php echo $this->get_field_name('katb_display_widget_number'); ?>" type="text" value="<?php echo $number; ?>" /></p>
		<p>By : <input class="widefat" id="<?php echo $this->get_field_id('katb_display_widget_by'); ?>" name="<?php echo $this->get_field_name('katb_display_widget_by'); ?>" type="text" value="<?php echo $by; ?>" /></p>
		<p>IDs : <input class="widefat" id="<?php echo $this->get_field_id('katb_display_widget_ids'); ?>" name="<?php echo $this->get_field_name('katb_display_widget_ids'); ?>" type="text" value="<?php echo $ids; ?>" /></p>
		<p>Rotate : <input class="widefat" id="<?php echo $this->get_field_id('katb_display_widget_rotate'); ?>" name="<?php echo $this->get_field_name('katb_display_widget_rotate'); ?>" type="text" value="<?php echo $rotate; ?>" /></p>
		<?php	
	}
	
	//save the widget settings
	function update ( $new_instance, $old_instance ) {
		$instance = $old_instance;
        $instance['katb_display_widget_title'] = strip_tags( $new_instance['katb_display_widget_title'] );
		$instance['katb_display_widget_group'] = strip_tags( $new_instance['katb_display_widget_group'] );
		$instance['katb_display_widget_number'] = strtolower(strip_tags( $new_instance['katb_display_widget_number'] ));
		$instance['katb_display_widget_by'] = strtolower(strip_tags( $new_instance['katb_display_widget_by'] ));
		$instance['katb_display_widget_ids'] = strip_tags( $new_instance['katb_display_widget_ids'] );
		$instance['katb_display_widget_rotate'] = strtolower(strip_tags( $new_instance['katb_display_widget_rotate'] ));
		
		//rotate flag whitelist
		if( $instance['katb_display_widget_rotate'] != 'yes' ) $instance['katb_display_widget_rotate'] = 'no';
		
		// group validation/whitelist
		if( $instance['katb_display_widget_group'] == '' ) $instance['katb_display_widget_group'] = 'all';
		
		//number validation/whitelist
		if( $instance['katb_display_widget_number'] == '' ) $instance['katb_display_widget_number'] = 'all';
		if( $instance['katb_display_widget_number'] != 'all' ) {
			if( intval($instance['katb_display_widget_number']) < 1 ) {
				$instance['katb_display_widget_number'] = 1;
			} else {
				$instance['katb_display_widget_number'] = intval($instance['katb_display_widget_number']);
			}
		}
		
		//by whitelist
		if( $instance['katb_display_widget_by'] != 'date' && $instance['katb_display_widget_by'] != 'order') $instance['katb_display_widget_by'] = 'random';
		
		return $instance;
	}
	
	//display the widget
    function widget($args, $instance) {
    	$katb_options = katb_get_options();
		$katb_tdata_array = array();
    	extract ( $args);
		echo $before_widget;
		
		$title = apply_filters( 'widget_title', $instance['katb_display_widget_title'] );
		$group = esc_attr($instance['katb_display_widget_group']);
		$number = esc_attr($instance['katb_display_widget_number']);
		$by = esc_attr($instance['katb_display_widget_by']);
		$rotate = esc_attr($instance['katb_display_widget_rotate']);
		$ids = esc_attr($instance['katb_display_widget_ids']);

		//display the title
		if ( !empty( $title )) { echo $before_title.$title.$after_title; }
		
		//get the testimonials
		$katb_tdata_array = katb_widget_get_testimonials( $group, $number, $by, $ids );
		
		$katb_tdata = $katb_tdata_array[0];
		
		$katb_tnumber = $katb_tdata_array[1];

		$katb_widget_error = "";
				
		if ( $katb_tnumber < 2 && $rotate == 'yes' ) {
			$katb_widget_error = __('You must have 2 approved testimonials to use a rotated display!','testimonial-basics');
		} elseif ( $katb_tnumber == 0 ) {
			$katb_widget_error = __('There are no approved testimonials to display!','testimonial-basics');
		}

		// Database queried
		//Lets display the selected testimonial
		$katb_html = '';
		if( $katb_widget_error != '') {
			$katb_html .= '<div class="katb_display_widget_error">'.$katb_widget_error.'</div>';
		} else {
			for ( $i = 0 ; $i < $katb_tnumber; $i++ ) {
					
				//check for gravatar
				if ( $katb_options['katb_widget_use_gravatars'] == 1 )$has_valid_avatar = katb_validate_gravatar($katb_tdata[$i]['tb_email']);
				
				//set up hidden popup if excerpt is used	
				if ( $katb_options['katb_use_widget_excerpts'] == 1 ) {
					$katb_html .= '<div class="katb_topopup" id="katb_widget_'.sanitize_text_field( $katb_tdata[$i]['tb_id'] ).'">';
					$katb_html .= '<div class="katb_close"></div>';
					if ( $katb_options['katb_widget_use_gravatars'] == 1 ) {
						If ( $has_valid_avatar == 1 ) {
							$katb_html .= '<span class="katb_widget_avatar">'.get_avatar( $katb_tdata[$i]['tb_email'], $size = '60' ).'</span>';
						}
					}
					$katb_html .= '<div class="katb_popup_text">'.wp_kses_post( stripcslashes($katb_tdata[$i]['tb_testimonial'] ) ).'</div><br/>';
					$katb_html .= '<span class="katb_popup_meta">'.sanitize_text_field( stripcslashes($katb_tdata[$i]['tb_name'] ) );
					if ($katb_options['katb_widget_show_date'] == 1) {
						$katb_date = sanitize_text_field( $katb_tdata[$i]['tb_date'] );
						$katb_html .= ', <i>'.mysql2date(get_option('date_format'), $katb_date).'</i>';
					}
					if ($katb_options['katb_widget_show_location'] == 1) {
						if ( $katb_tdata[$i]['tb_location'] != "" ) $katb_html .= ', '.sanitize_text_field( stripcslashes($katb_tdata[$i]['tb_location'] ) );
					}
					if ($katb_options['katb_widget_show_website'] == 1) {
						if ( $katb_tdata[$i]['tb_url'] != "" ) $katb_html .= ', <i><a href="'.esc_url($katb_tdata[$i]['tb_url']).'" title="Testimonial_author_site" target="_blank" >Website</a></i>';
					}
					$katb_html .= '</span></div>';
					$katb_html .= '<div class="katb_loader"></div>';
					$katb_html .= '<div class="katb_excerpt_popup_bg" id="katb_widget_excerpt_'.sanitize_text_field( $katb_tdata[$i]['tb_id'] ).'_bg"></div>';
				}
				//wp_die($katb_options['katb_widget_use_formatted_display']);
				//formatted display
				if ( $katb_options['katb_widget_use_formatted_display'] == 1 ) {
					if( $rotate == 'yes' ) {
						if( $i == 0 ) {
							$katb_html .= '<div class="katb_widget_box katb_widget_rotate katb_widget_rotate_show">';
						} else {
							$katb_html .= '<div class="katb_widget_box katb_widget_rotate katb_widget_rotate_noshow">';
						}
					} else {
						$katb_html .= '<div class="katb_widget_box">';
					}
					
					
					if ( $katb_options['katb_widget_use_gravatars'] == 1 ){
						If ( $has_valid_avatar == 1 ) {
							$katb_html .= '<span class="katb_widget_avatar">'. get_avatar( $katb_tdata[$i]['tb_email'], $size = '60' ).'</span>';
						}
					}
					if ( $katb_options['katb_use_widget_excerpts'] == 1 ) {
						$text = wp_kses_post( stripcslashes($katb_tdata[$i]['tb_testimonial'] ) );
						$length = intval( $katb_options['katb_widget_excerpt_length'] );
						$classID = 'katb_widget_'.sanitize_text_field( $katb_tdata[$i]['tb_id'] );
						$text = katb_testimonial_excerpt_filter( $length, $text, $classID );
						$katb_html .= '<div class="katb_widget_text" >'.$text.'</div>';
					} else {
						$katb_html .= '<div class="katb_widget_text" >'.wp_kses_post( stripcslashes($katb_tdata[$i]['tb_testimonial'] ) ).'</div>';
					}	
					$katb_html .= '<span class="katb_widget_meta">'.sanitize_text_field( stripcslashes($katb_tdata[$i]['tb_name'] ) );
				//basic display
				} else {
					if( $rotate == 'yes' ) {
						if( $i == 0 ) {
							$katb_html .= '<div class="katb_widget_box_basic katb_widget_rotate katb_widget_rotate_show">';
						} else {
							$katb_html .= '<div class="katb_widget_box_basic katb_widget_rotate katb_widget_rotate_noshow">';
						}
					} else {
						$katb_html .= '<div class="katb_widget_box_basic">';
					}
					
					if ( $katb_options['katb_widget_use_gravatars'] == 1 ) {
						If ( $has_valid_avatar == 1 ) {
							$katb_html .= '<span class="katb_widget_avatar">'.get_avatar( $katb_tdata[$i]['tb_email'], $size = '60' ).'</span>';
						}
					}
					if ( $katb_options['katb_use_widget_excerpts'] == 1 ) {
						$text = wp_kses_post( stripcslashes($katb_tdata[$i]['tb_testimonial'] ) );
						$length = intval( $katb_options['katb_widget_excerpt_length'] );
						$classID = 'katb_widget_'.sanitize_text_field( $katb_tdata[$i]['tb_id'] );
						$text = katb_testimonial_excerpt_filter( $length, $text, $classID);
						$katb_html .= '<div class="katb_widget_text_basic" >'.$text.'</div>';
					} else {
						$katb_html .= '<div class="katb_widget_text_basic" >'.wp_kses_post(stripcslashes($katb_tdata[$i]['tb_testimonial'] ) ).'</div>';
					}
					$katb_html .= '<span class="katb_widget_meta_basic"><strong>'.sanitize_text_field( stripcslashes($katb_tdata[$i]['tb_name'] ) ).'</strong>';
				}
				if ($katb_options['katb_widget_show_date'] == 1) {
					$katb_date = sanitize_text_field( $katb_tdata[$i]['tb_date'] );
					$katb_html .= ', <i>'.mysql2date(get_option('date_format'), $katb_date).'</i>';
				}
				if ($katb_options['katb_widget_show_location'] == 1) {
					if ( $katb_tdata[$i]['tb_location'] != "" ) $katb_html .= ', <i>'.sanitize_text_field( stripcslashes($katb_tdata[$i]['tb_location'] ) ).'</i>';
				}
				if ($katb_options['katb_widget_show_website'] == 1) {
					if ( $katb_tdata[$i]['tb_url'] != "" ) $katb_html .= ', <i><a href="'.esc_url($katb_tdata[$i]['tb_url']).'" title="Testimonial_author_site" target="_blank" >Website</a></i>';
				}
				$katb_html .= '</span>';
				$katb_html .= '</div>';
			}
		}
		echo $katb_html;
		echo '<br style="clear:both;" />';
		echo $after_widget; 
    }
}

/**
 * Go into the database and get the testimonials to display in the widget
 */
function katb_widget_get_testimonials( $group, $number, $by, $ids ) {
	
	global $wpdb,$tablename;
	$tablename = $wpdb->prefix.'testimonial_basics';
	$katb_tdata_array = array();
	
	if( $ids != '' ) {
		
		$id_picks_widget = array();
		$id_picks_processed = array();
		$id_picks = explode( ',', $ids );
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
		
		$katb_tdata_array[0] = $katb_tdata;
		$katb_tdata_array[1] = $count2;
		return $katb_tdata_array;
		
	} else {
		//get the testimonials from the database
		if ( $group == 'all' && $number == 'all' && $by == 'date' ) {
			$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' ORDER BY `tb_date` DESC ",ARRAY_A);
		} elseif ( $group == 'all' && $number == 'all' && $by == 'order' ) {
			$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' ORDER BY `tb_order` = '0',`tb_order` ASC ",ARRAY_A);
		} elseif ( $group == 'all' && $number == 'all' && $by == 'random' ) {
			$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' ORDER BY RAND() DESC ",ARRAY_A);
		} elseif ( $group == 'all' && $number != 'all' && $by == 'date' ) {
			$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' ORDER BY `tb_date` DESC LIMIT 0,$number ",ARRAY_A);
		} elseif ( $group == 'all' && $number != 'all' && $by == 'order' ) {
			$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' ORDER BY `tb_order` = '0',`tb_order` ASC LIMIT 0,$number ",ARRAY_A);
		} elseif ( $group == 'all' && $number != 'all' && $by == 'random' ) {
			$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' ORDER BY RAND() DESC LIMIT 0,$number ",ARRAY_A);
		} elseif ( $group != 'all' && $number == 'all' && $by == 'date' ) {
			$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' AND `tb_group` = '$group' ORDER BY `tb_date` DESC ",ARRAY_A);
		} elseif ( $group != 'all' && $number == 'all' && $by == 'order' ) {
			$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' AND `tb_group` = '$group' ORDER BY `tb_order` = '0',`tb_order` ASC ",ARRAY_A);	
		} elseif ( $group != 'all' && $number == 'all' && $by == 'random' ) {	
			$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' AND `tb_group` = '$group' ORDER BY RAND() ",ARRAY_A);
		} elseif ( $group != 'all' && $number != 'all' && $by == 'date' ) {
			$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' AND `tb_group` = '$group' ORDER BY `tb_date` DESC LIMIT 0,$number ",ARRAY_A);
		} elseif ( $group != 'all' && $number != 'all' && $by == 'order' ) {
			$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' AND `tb_group` = '$group' ORDER BY `tb_order` = '0',`tb_order` ASC LIMIT 0,$number ",ARRAY_A);
		} elseif ( $group != 'all' && $number != 'all' && $by == 'random' ) {
			$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' AND `tb_group` = '$group' ORDER BY RAND() LIMIT 0,$number ",ARRAY_A);
		}
				
		$katb_tdata_array[0] = $katb_tdata;
		$katb_tdata_array[1] = $wpdb->num_rows;
		return $katb_tdata_array; 

	}

}