<?php
/*
Plugin Name: Testimonial Basics Rotator Display Widget
Plugin URI: http://kevinsspace.ca/testimonial-basics-wordpress-plugin/
Description: A plugin to display testimonials in a slider
Version: 4.0.3
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
        $instance['katb_display_widget_title'] = sanitize_text_field( $new_instance['katb_display_widget_title'] );
		$instance['katb_display_widget_group'] = sanitize_text_field( $new_instance['katb_display_widget_group'] );
		$instance['katb_display_widget_number'] = sanitize_text_field( $new_instance['katb_display_widget_number'] );
		$instance['katb_display_widget_by'] = strtolower(sanitize_text_field( $new_instance['katb_display_widget_by'] ));
		$instance['katb_display_widget_ids'] = sanitize_text_field( $new_instance['katb_display_widget_ids'] );
		$instance['katb_display_widget_rotate'] = strtolower(sanitize_text_field( $new_instance['katb_display_widget_rotate'] ));
		
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
	
	/**
	 * display the widget
	 * 
	 * 
	 * @param array $args
	 * @param $instance
	 * 
	 * @uses katb_get_options() user options from katb_functions.php
	 * @uses katb_widget_get_testimonials() from this file
	 * @uses katb_widget_schema_company_aggregate() from this file
	 * @uses katb_widget_display_testimonial () from this file
	 * 
	 */
    function widget($args, $instance) {
    	
    	//get user options
    	$katb_options = katb_get_options();
		$company_name = $katb_options['katb_schema_company_name'];
		$company_website = $katb_options['katb_schema_company_url'];
		$use_aggregate_group_name = $katb_options['katb_use_group_name_for_aggregate'];
		$custom_aggregate_name = $katb_options['katb_custom_aggregate_review_name'];
		$use_schema = $katb_options['katb_use_schema'];
		
		$katb_tdata_array = array();
    	extract ( $args);
		echo $before_widget;
		
		$title = apply_filters( 'widget_title', $instance['katb_display_widget_title'] );
		$group = esc_attr($instance['katb_display_widget_group']);
		$number = esc_attr($instance['katb_display_widget_number']);
		$by = esc_attr($instance['katb_display_widget_by']);
		$rotate = esc_attr($instance['katb_display_widget_rotate']);
		$ids = esc_attr($instance['katb_display_widget_ids']);
		
		if( $rotate == 'yes' ) { $rotate = 1; }
		
		//display the title
		if ( !empty( $title ) ) { echo $before_title.$title.$after_title; }
		
		//get the testimonials
		$katb_tdata_array = katb_widget_get_testimonials( $group, $number, $by, $ids );
		
		$katb_widget_tdata = $katb_tdata_array[0];
		
		$katb_widget_tnumber = $katb_tdata_array[1];

		$katb_widget_error = "";
				
		if ( $katb_widget_tnumber < 2 && $rotate == 1 ) {
			$katb_widget_error = __('You must have 2 approved testimonials to use a rotated display!','testimonial-basics');
		} elseif ( $katb_widget_tnumber == 0 ) {
			$katb_widget_error = __('There are no approved testimonials to display!','testimonial-basics');
		}

		// Database queried
		//Lets display the selected testimonial(s)

		if( $katb_widget_error != '') { ?>
			
			<div class="katb_display_widget_error"><?php echo esc_attr( $katb_widget_error ); ?></div>
			
		<?php } else {
			
			if( $use_schema == 1 ) {
				katb_widget_schema_company_aggregate( $company_name, $company_website, $group, $use_aggregate_group_name, $custom_aggregate_name  ); 
			}
			
			katb_widget_display_testimonial ( $katb_widget_tdata, $katb_widget_tnumber, $rotate, $group );
			
			if( $use_schema == 1 ) { ?>
				</div>
			<?php }
			 
		} ?>
		
		<br style="clear:both;" />
		
		<?php echo $after_widget; 

	}

}//close the class

/**
 * Go into the database and get the testimonials to display in the widget
 * 
 * @param string $group All or group name for search
 * @param string $number All or number to search
 * @param string $by date, order, random
 * @param string $ids contains ids of testimonials
 * 
 * @return $katb_tdata_array of testimonial data
 * 
 */
function katb_widget_get_testimonials( $group , $number , $by , $ids ) {
	
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

/**
 * This function is called if the widget requires a schema aggregate set up.
 * It sets up the company name and website in meta tags, and does a aggregate 
 * average rating.
 * 
 * @param string $company_name user option
 * @param string $company_website user option
 * @param string $group_name user option
 * @param boolean $use_aggregate_group_name user option
 * @param string $custom_aggregate_name user option
 * 
 * 
 */
function katb_widget_schema_company_aggregate ( $company_name, $company_website, $group_name, $use_aggregate_group_name, $custom_aggregate_name ) {
	
	global $wpdb,$tablename;
	$tablename = $wpdb->prefix.'testimonial_basics';
	//query database 
	if( $group_name != 'all' ) {
	
		$aggregate_data = $wpdb->get_results( " SELECT `tb_rating` FROM `$tablename` WHERE `tb_approved` = '1' AND `tb_group` = '$group_name' ",ARRAY_A);
		$aggregate_total_approved = $wpdb->num_rows;
			
	} else {
		
		$aggregate_data = $wpdb->get_results( " SELECT `tb_rating` FROM `$tablename` WHERE `tb_approved` = '1' ",ARRAY_A);
		$aggregate_total_approved = $wpdb->num_rows;
						
	}
	
	//Get the average of the ratings				
	$count = 0;
	$sum = 0;
	for ( $j = 0 ; $j < $aggregate_total_approved; $j++ ) {

		$rating = (float) $aggregate_data[$j]['tb_rating'];
		if( $rating != '' && $rating > 0 ) {
			$count = $count + 1;
			$sum = $sum + (float)$aggregate_data[$j]['tb_rating'] ;
		}			
	}

	if( $count == 0 ) $count = 1;
	$avg_rating = round( $sum / $count, 1 );			
					
	?>
	
	<div itemscope itemtype="http://schema.org/Organization">
		
		<meta content="<?php echo stripcslashes( esc_attr( $company_name ) ); ?>" itemprop="name" />
		<meta content="<?php echo esc_url( $company_website ); ?>" itemprop="url" />
		
		<?php if( $count > 1 && $avg_rating > 0 ) { ?>
		
			<div itemscope itemtype="http://data-vocabulary.org/Review-aggregate">
			
				<?php if( $custom_aggregate_name != '' ) { ?>
					<meta content="<?php echo stripcslashes( esc_attr( $custom_aggregate_name ) ); ?>" itemprop="itemreviewed" />
				<?php } else { ?>
					<meta content="<?php echo stripcslashes( esc_attr( $group_name ) ); ?>" itemprop="itemreviewed" />
				<?php }	?>
				
				<div itemprop="rating" itemscope itemtype="http://data-vocabulary.org/Rating">
					<meta content="<?php echo $avg_rating; ?>" itemprop="average"/>
					<meta content="0" itemprop="worst" />
					<meta content="5" itemprop="best" />
				</div>
				<meta content="<?php echo $count; ?>" itemprop="votes" />
				<meta content="<?php echo $aggregate_total_approved; ?>" itemprop="count" />
				
			</div>
		
		<?php }
}

/**
 * This function displays the testimonial.
 * 
 * @param array $katb_widget_tdata testimonial data
 * @param string $katb_widget_tnumber total number of testimonials
 * @param boolean $rotate 
 * @param string $group_name group name from widget data
 * 
 * @uses katb_get_options() user options from katb_functions.php
 * @uses katb_validate_gravatar() check for gravatar from this file
 * @uses katb_widget_popup() set up popup  from this file
 * @uses katb_widget_testimonial_wrap_div() sets up main formatting div wrap from this file
 * @uses katb_meta_widget_top() html for top meta from this file
 * @uses katb_testimonial_excerpt_filter()  from this file
 * @uses katb_widget_insert_gravatar()  from this file
 * @uses katb_meta_widget_bottom() html for bottom meta from this file
 */
 
function katb_widget_display_testimonial ( $katb_widget_tdata, $katb_widget_tnumber, $rotate, $group_name ) {
	
	//get user options
	$katb_options = katb_get_options();
	$use_ratings = $katb_options['katb_use_ratings'];
	$use_excerpts = $katb_options['katb_widget_use_excerpts'];
	$use_gravatars = $katb_options['katb_widget_use_gravatars'];
	$use_gravatar_substitute = $katb_options['katb_widget_use_gravatar_substitute'];
	$gravatar_size = $katb_options['katb_widget_gravatar_size'];
	$layout = $katb_options['katb_widget_layout_option'];
	$use_individual_group_name = $katb_options['katb_individual_group_name'];
	$custom_individual_name = $katb_options['katb_individual_custom_name'];
	$use_title_non_schema =  $katb_options['katb_widget_show_title'];
	$use_schema = $katb_options['katb_use_schema'];
	$use_formatted_display = $katb_options['katb_widget_use_formatted_display'];
	$katb_widget_height = $katb_options['katb_widget_rotator_height'];

	if( $rotate == 1 ) {
				
		$katb_widget_speed = $katb_options['katb_widget_rotator_speed'];
		$katb_widget_transition = $katb_options['katb_widget_rotator_transition'];
		if( $use_formatted_display == 1 ) { ?>
			<div class="katb_widget_rotate katb_widget_rotator_wrap"
				data-katb_speed="<?php echo esc_attr( $katb_widget_speed ); ?>" 
				data-katb_transition="<?php echo esc_attr( $katb_widget_transition ); ?>">
		<?php } else { ?>
			<div class="katb_widget_rotate katb_widget_rotator_wrap_basic"
				data-katb_speed="<?php echo esc_attr( $katb_widget_speed ); ?>" 
				data-katb_transition="<?php echo esc_attr( $katb_widget_transition ); ?>">
		<?php }
			
	} else {
		if( $use_formatted_display == 1 ) { ?>
			<div class="katb_widget_wrap">
		<?php } else { ?>
			<div class="katb_widget_wrap_basic">
		<?php }
	}
			
			for ( $i = 0 ; $i < $katb_widget_tnumber; $i++ ) {
				
				//if gravatars are enabled, check for valid avatar
				if ( $use_gravatars == 1 && $use_gravatar_substitute != 1 ) {
					$has_valid_avatar = katb_validate_gravatar( $katb_widget_tdata[$i]['tb_email'] ); 
				} else {
					$has_valid_avatar = 0;
				}
					
				//set up hidden popup if excerpt is used
				if ( $use_excerpts == 1 ) katb_widget_popup( $has_valid_avatar, $katb_widget_tdata, $i );
				
				//set up widget height restriction if any
				if( $katb_widget_height != 'variable') {
					$katb_widget_height_option = 'style="min-height:'.$katb_widget_height.'px;overflow:hidden;"';
				} else {
					$katb_widget_height_option = '';
				}
				
				$individual_group_name = $katb_widget_tdata[$i]['tb_group'];
					
					//<div class=.... > wrap
					$div_prop = katb_widget_testimonial_wrap_div( $use_formatted_display , $use_schema , $rotate, $katb_widget_height_option, $i );
					
					?><div <?php echo $div_prop; ?> ><?php
					
						if( $use_schema == 1 || $use_title_non_schema == 1 || $use_ratings == 1 ) { ?>
					
							<div class="katb_widget_title_bar">
						
								<?php // use a testimonial title
								if( $use_schema != 1 ) {
									
									if( $use_title_non_schema == 1 ) {
										//non schema name of review item
										if( $use_individual_group_name == 1 && $individual_group_name != '' ) { ?>
											
											<span class="individual_itemreviewed"><?php echo stripcslashes( esc_attr( $individual_group_name ) ); ?></span>
											<?php if( $use_ratings != 1 ) { ?>
												<br/>
											<?php } else { ?>
												<span class="comma_sep">&nbsp;-&nbsp;</span>
											<?php }
											
										} elseif( $custom_individual_name != '' ) { ?>
											<span class="individual_itemreviewed"><?php echo stripcslashes( esc_attr( $custom_individual_name ) ); ?></span>
											<?php if( $use_ratings != 1 ) { ?>
												<br/>
											<?php } else { ?>
												<span class="comma_sep">&nbsp;-&nbsp;</span>
											<?php }
											
										}
									}
									
								} else {
									
									//schema name of review item
									if( $use_individual_group_name == 1 && $individual_group_name != '' ) { ?>
										<span class="individual_itemreviewed" itemprop="itemreviewed"><?php echo stripcslashes( esc_attr( $individual_group_name ) ); ?></span>
										<?php if( $use_ratings != 1 ) { ?>
											<br/>
										<?php } else { ?>
											<span class="comma_sep">&nbsp;-&nbsp;</span>
										<?php }
									} elseif( $custom_individual_name != '' ) { ?>
										<span class="individual_itemreviewed" itemprop="itemreviewed"><?php echo stripcslashes( esc_attr( $custom_individual_name ) ); ?></span>
										<?php if( $use_ratings != 1 ) { ?>
											<br/>
										<?php } else { ?>
											<span class="comma_sep">&nbsp;-&nbsp;</span>
										<?php }
									 }
								
								}
								
								//Display the rating if selected
								if ( $use_ratings == 1 ) { 
							
									$rating = $katb_widget_tdata[$i]['tb_rating'];
									if( $rating == '' ) $rating = 0; ?>
									
									<span class="rateit smallstars katb_widget_display_rating" 
											data-rateit-starwidth="12" 
											data-rateit-starheight="12" 
											data-rateit-value="<?php echo esc_attr( $rating ); ?>" 
											data-rateit-ispreset="true" 
											data-rateit-readonly="true">
									</span><br/>
									<?php if( $use_schema == 1 ) { ?>
										<meta itemprop="worst" content="0" />
										<meta itemprop="rating" content="<?php echo esc_attr( $rating ); ?>" />
										<meta itemprop="best" content="5" />
									<?php }
									
								} ?>
								
							</div><!-- close katb_widget_title_bar -->
							
						<?php }
							
						if( $layout == 'Top Meta' ) { katb_meta_widget_top( $i , $katb_widget_tdata, $use_schema ); }
						
						//get gravatar info
						$photo_or_gravatar = katb_widget_insert_gravatar( $katb_widget_tdata[$i]['tb_pic_url'] , $gravatar_size , $use_gravatars , $use_gravatar_substitute , $has_valid_avatar , $katb_widget_tdata[$i]['tb_email'] );
						
						//display the content
						if ( $use_excerpts == 1 ) {
							
							$text = wpautop( wp_kses_post( stripcslashes($katb_widget_tdata[$i]['tb_testimonial'] ) ) );
							$length = intval( $katb_options['katb_widget_excerpt_length'] );
							$classID = 'katb_widget_'.sanitize_text_field( $katb_widget_tdata[$i]['tb_id'] );
							$text2 = katb_testimonial_excerpt_filter( $length, $text, $classID );
							
							
							if( $use_schema != 1 ) {
								
								if( $use_formatted_display == 1 ) {
									echo '<div class="katb_widget_text">'.$photo_or_gravatar.$text2.'</div>';
								} else {
									echo '<div class="katb_widget_text_basic">'.$photo_or_gravatar.$text2.'</div>';
								}
								
							} else {
								
								if( $use_formatted_display == 1 ) {
									echo '<div class="katb_widget_text" itemprop="reviewBody">'.$photo_or_gravatar.$text2.'</div>';
								} else {
									echo '<div class="katb_widget_text_basic" itemprop="reviewBody">'.$photo_or_gravatar.$text2.'</div>';
								}
								
							}
							
						} else {
							
							if( $use_schema != 1 ) {
								
								if( $use_formatted_display == 1 ) {
									echo '<div class="katb_widget_text" >'.$photo_or_gravatar.wp_kses_post( wpautop( stripcslashes( $katb_widget_tdata[$i]['tb_testimonial'] ) ) ).'</div>';
								} else {
									echo '<div class="katb_widget_text_basic" >'.$photo_or_gravatar.wp_kses_post( wpautop( stripcslashes( $katb_widget_tdata[$i]['tb_testimonial'] ) ) ).'</div>';
								}
								
							} else {
								
								if( $use_formatted_display == 1 ) {
									echo '<div class="katb_widget_text" itemprop="reviewBody">'.$photo_or_gravatar.wp_kses_post( wpautop( stripcslashes( $katb_widget_tdata[$i]['tb_testimonial'] ) ) ).'</div>';
								} else {
									echo '<div class="katb_widget_text_basic" itemprop="reviewBody">'.$photo_or_gravatar.wp_kses_post( wpautop( stripcslashes( $katb_widget_tdata[$i]['tb_testimonial'] ) ) ).'</div>';
								}
								
							}
							
						}
						
						if( $layout == 'Bottom Meta' ) katb_meta_widget_bottom( $i , $katb_widget_tdata, $use_schema ); ?>
						
				</div> <!-- close katb_widget_box/katb_widget_box_basic -->
			
		<?php } ?>
				
			</div>
			
<?php }

/**
 * Set up and display the pop p html
 * 
 * @param boolean $has_valid_avatar
 * @param array $katb_widget_tdata testimonial data
 * @param $i counter for testimonial loop
 * 
 * @uses katb_get_options() user options from katb_functions.php
 * @uses katb_meta_top() html meta strip from this file
 * @uses katb_widget_insert_gravatar() html for gravatar from this file
 * @uses katb_meta_bottom() from this file
 * 
 */
function katb_widget_popup( $has_valid_avatar, $katb_widget_tdata, $i ) {
	
	//get user options
	$katb_options = katb_get_options();
	$use_ratings = $katb_options['katb_use_ratings'];
	$use_gravatars = $katb_options['katb_widget_use_gravatars'];
	$use_gravatar_substitute = $katb_options['katb_widget_use_gravatar_substitute'];
	$gravatar_size = $katb_options['katb_widget_gravatar_size']; //note this is size for content and not the widget
	$layout = $katb_options['katb_widget_layout_option'];
	$use_individual_group_name = $katb_options['katb_individual_group_name'];
	$custom_individual_name = $katb_options['katb_individual_custom_name'];
	$use_title =  $katb_options['katb_widget_show_title'];
	$use_schema = 0;//used to ensure no schema matkup in meta
	$schema_on_for_title = $katb_options['katb_use_schema'];//used to decide on title display

	?><div class="katb_topopup" id="katb_widget_<?php echo sanitize_text_field( $katb_widget_tdata[$i]['tb_id'] ); ?>">
		
		<div class="katb_close"></div>
		
		<div class="katb_popup_wrap katb_widget"><?php
					
			if( $use_title == 1 || $use_ratings == 1 ) { ?>
				
				<div class="katb_title_bar">
					
					<?php
					//title for testimonial
					if( $schema_on_for_title == 1 || $use_title == 1 ) {
							
						//get group name for testimonial
						$individual_group_name = $katb_widget_tdata[$i]['tb_group'];
							
						if( $use_individual_group_name == 1 && $individual_group_name != '' ) {
							echo '<span class="individual_itemreviewed" >'.stripcslashes( esc_attr( $individual_group_name ) ).'</span>';
							if( $use_ratings == 1 ) { 
								echo '&nbsp;-&nbsp;'; 
							} else {
								echo '<br/>';
							}
						} elseif( $custom_individual_name != '' ) {
							echo '<span class="individual_itemreviewed" >'.stripcslashes( esc_attr( $custom_individual_name ) ).'</span>';
							if( $use_ratings == 1 ) { 
								echo '&nbsp;-&nbsp;'; 
							} else {
								echo '<br/>';
							}
						}
							
					} //close use title
						
					//Display the rating if selected
					if ( $use_ratings == 1 ) { 
				
						$rating = $katb_widget_tdata[$i]['tb_rating'];
						if( $rating == '' ) { $rating = 0; }
						echo '<span class="rateit katb_display_rating" data-rateit-value="'.esc_attr( $rating ).'" data-rateit-ispreset="true" data-rateit-readonly="true"></span><br/>';
						
					} ?>
						
				</div>
						
			<?php }
					
			if( $layout == 'Top Meta' ) { echo katb_meta_top( $i, $katb_widget_tdata, $use_schema ); }
			
			$gravatar_or_photo = katb_widget_insert_gravatar( $katb_widget_tdata[$i]['tb_pic_url'] , $gravatar_size , $use_gravatars , $use_gravatar_substitute, $has_valid_avatar , $katb_widget_tdata[$i]['tb_email'] );
			
			echo '<div class="katb_test_text_basic" >'.$gravatar_or_photo.wp_kses_post( wpautop( stripcslashes( $katb_widget_tdata[$i]['tb_testimonial'] ) ) ).'</div>';
			
			if( $layout == 'Bottom Meta' )  { echo  katb_meta_bottom( $i, $katb_widget_tdata, $use_schema ); } ?>
	
		</div>
		
	</div>	
		
	<div class="katb_loader"></div>
		
	<div class="katb_excerpt_popup_bg" id="katb_widget_<?php echo sanitize_text_field( $katb_widget_tdata[$i]['tb_id'] ); ?>_bg"></div>
		
	<?php return;
		
}

/**
 * Testimonial content wrap helper - sets up the div
 * 
 * @param boolean 
 * @param boolean 
 * @param boolean 
 * @param string either variable or a height in pixels
 * @param $i counter for testimonial loop
 * 
 * @return $div_prop 
 */
function katb_widget_testimonial_wrap_div( $use_formatted_display , $use_schema , $katb_rotate, $katb_widget_height_option, $i ) {
	
	$div_prop = '';

	if( $katb_rotate == 1 && $use_formatted_display == 1 && $use_schema == 1 ) {
		
		if( $i == 0 ) {
			$div_prop .= 'class="katb_widget_rotator_box katb_widget_rotate_show" itemscope itemtype="http://data-vocabulary.org/Review" '.$katb_widget_height_option;
		} else {
			$div_prop .= 'class="katb_widget_rotator_box katb_widget_rotate_noshow" itemscope itemtype="http://data-vocabulary.org/Review" '.$katb_widget_height_option;
		}
		
	} elseif( $katb_rotate == 1 && $use_formatted_display != 1 && $use_schema == 1 ) {
		
		if( $i == 0 ) {
			$div_prop .= 'class="katb_widget_rotator_box_basic katb_widget_rotate_show" itemscope itemtype="http://data-vocabulary.org/Review" '.$katb_widget_height_option;
		} else {
			$div_prop .= 'class="katb_widget_rotator_box_basic katb_widget_rotate_noshow" itemscope itemtype="http://data-vocabulary.org/Review" '.$katb_widget_height_option;
		}
		
	} elseif( $katb_rotate == 1 && $use_formatted_display != 1 && $use_schema != 1 ) {
		
		if( $i == 0 ) {
			$div_prop .= 'class="katb_widget_rotator_box_basic katb_widget_rotate_show" '.$katb_widget_height_option;
		} else {
			$div_prop .= 'class="katb_widget_rotator_box_basic katb_widget_rotate_noshow" '.$katb_widget_height_option;
		}
	
	} elseif( $katb_rotate == 1 && $use_formatted_display == 1 && $use_schema != 1 ) {
		
		if( $i == 0 ) {
			$div_prop .= 'class="katb_widget_rotator_box katb_widget_rotate_show" '.$katb_widget_height_option;
		} else {
			$div_prop .= 'class="katb_widget_rotator_box katb_widget_rotate_noshow" '.$katb_widget_height_option;
		}
			
	} elseif( $katb_rotate != 1 && $use_formatted_display == 1 && $use_schema == 1 ) {
		
		$div_prop .= 'class="katb_widget_box" itemscope itemtype="http://data-vocabulary.org/Review"';
		
	} elseif( $katb_rotate != 1 && $use_formatted_display != 1 && $use_schema == 1 ) {
		
		$div_prop .= 'class="katb_widget_box_basic" itemscope itemtype="http://data-vocabulary.org/Review"';
		
	} elseif( $katb_rotate != 1 && $use_formatted_display != 1 && $use_schema != 1 ) {
		
		$div_prop .= 'class="katb_widget_box_basic"';
		
	} elseif( $katb_rotate != 1 && $use_formatted_display == 1 && $use_schema != 1 ) {
		
		$div_prop .= 'class="katb_widget_box"';
			
	}
	
	return $div_prop;
	
}

/**
 * This function is a helper to insert a gravatar or image
 * 
 * @param string $image_url if uploaded image, this is the url
 * @param string $gravatar_size user option
 * @param boolean $use_gravatars user option 
 * @param boolean $use_gravatar_substitute user option
 * @param boolean $has_valid_avatar result of avatar check 
 * @param string $email address of author
 * 
 */
 
function katb_widget_insert_gravatar( $image_url , $gravatar_size , $use_gravatars , $use_gravatar_substitute , $has_valid_avatar , $email ){
	
	//If uploaded photo use that, else use gravatar if selected and available
	$html = '';
	if ( $image_url != '' )  {
		$html = '<span class="katb_widget_avatar"><img class="avatar" src="'.esc_url( $image_url ).
				'" alt="Author Picture" style="width:'.esc_attr( $gravatar_size ).'px; height:auto;" /></span>';
	} elseif ( $use_gravatars == 1 && $has_valid_avatar == 1 ) {
		$html = '<span class="katb_widget_avatar" >'.get_avatar( $email , $size = $gravatar_size ).'</span>';
	} elseif ( $use_gravatars == 1 && $use_gravatar_substitute == 1 ) {
		$html = '<span class="katb_widget_avatar" >'.get_avatar( $email , $size = $gravatar_size ).'</span>';
	}
	
	return $html;
	
}
 
/**
 * This function provides the meta for the bottom of the testimonial
 * 
 * @param string $i is the testimonial count in the loop
 * @param array $katb_tdata is the testimonial data
 * @param boolean $use_schema
 * 
 * @uses katb_get_options() user options from katb_functions.php
 * 
 */
function katb_meta_widget_bottom( $i, $katb_tdata, $use_schema ){
	
	//get user options
	$katb_options = katb_get_options();
	$show_date = $katb_options['katb_widget_show_date'];
	$show_location = $katb_options['katb_widget_show_location'];
	$show_website = $katb_options['katb_widget_show_website'];
	
	
	?><div class="katb_widget_meta_bottom"><?php
				
		//author		
		if( $use_schema != 1 ) { ?>
			<span class="katb_widget_author"><?php echo sanitize_text_field( stripcslashes($katb_tdata[$i]['tb_name'] ) ); ?></span>
		<?php } else { ?>
			<span class="katb_widget_author" itemprop="reviewer"><?php echo sanitize_text_field( stripcslashes($katb_tdata[$i]['tb_name'] ) ); ?></span>
		<?php }
		
		//date
		if ( $show_date == 1 ) {
			
			$katb_date = sanitize_text_field( $katb_tdata[$i]['tb_date'] );
			if( $use_schema != 1 ) { ?>
				<span class="katb_widget_date">,&nbsp;<?php echo mysql2date(get_option( 'date_format' ), $katb_date ); ?></span>
			<?php } else { ?>
				<span class="katb_widget_date" itemprop="dtreviewed">,&nbsp;<?php echo mysql2date(get_option( 'date_format' ), $katb_date ); ?></span>
			<?php }
			
		}
		
		//location
		if ( $show_location == 1 && $katb_tdata[$i]['tb_location'] != '') { ?>
			
			<span class="katb_widget_location">,&nbsp;<?php echo sanitize_text_field( stripcslashes($katb_tdata[$i]['tb_location'] ) ); ?></span>
		
		<?php }
		
		//website		
		if ( $show_website == 1 && $katb_tdata[$i]['tb_url'] != '' ) { ?>
			
			<span class="katb_widget_website">,&nbsp;<a href="<?php echo esc_url( $katb_tdata[$i]['tb_url'] ); ?>" title="<?php echo esc_url( $katb_tdata[$i]['tb_url'] ); ?>" target="_blank" >Website</a></span>
			
		<?php } ?>
	
	</div>
	
	<?php return;
}

/**
 * This function provides the meta for the top of the testimonial
 * 
 * @param string $i is the testimonial count in the loop
 * @param array $katb_tdata is the testimonial data
 * @param boolean $use_schema
 * 
 * @uses katb_get_options() user options from katb_functions.php
 * 
 */
function katb_meta_widget_top( $i, $katb_tdata, $use_schema ){
	
	//get user options
	$katb_options = katb_get_options();
	$show_date = $katb_options['katb_widget_show_date'];
	$show_location = $katb_options['katb_widget_show_location'];
	$show_website = $katb_options['katb_widget_show_website'];
	
	?><div class="katb_widget_meta_top"><?php
		
		//author		
		if( $use_schema != 1 ) { ?>
			<span class="katb_widget_author"><?php echo sanitize_text_field( stripcslashes($katb_tdata[$i]['tb_name'] ) ); ?></span>
		<?php } else { ?>
			<span class="katb_widget_author" itemprop="reviewer"><?php echo sanitize_text_field( stripcslashes($katb_tdata[$i]['tb_name'] ) ); ?></span>
		<?php }
		
		//date
		if ( $show_date == 1 ) {
			
			$katb_date = sanitize_text_field( $katb_tdata[$i]['tb_date'] );
			if( $use_schema != 1 ) { ?>
				<span class="katb_widget_date">,&nbsp;<?php echo mysql2date(get_option( 'date_format' ), $katb_date ); ?></span>
			<?php } else { ?> 
				<span class="katb_widget_date" itemprop="dtreviewed">,&nbsp;<?php echo mysql2date(get_option( 'date_format' ), $katb_date ); ?></span>
		<?php }
			
		}
		
		//location
		if ( $show_location == 1 && $katb_tdata[$i]['tb_location'] != '') { ?>
			
			<span class="katb_widget_location">,&nbsp;<?php echo sanitize_text_field( stripcslashes($katb_tdata[$i]['tb_location'] ) ); ?></span>
		
		<?php }
		
		//website		
		if ( $show_website == 1 && $katb_tdata[$i]['tb_url'] != '' ) { ?>
			
			<span class="katb_widget_website">,&nbsp;<a href="<?php echo esc_url( $katb_tdata[$i]['tb_url'] ); ?>" title="<?php echo esc_url( $katb_tdata[$i]['tb_url'] ); ?>" target="_blank" >Website</a></span>
		
		<?php } ?>

	</div>
	
	<?php return;
}