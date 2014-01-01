<?php
/*
Plugin Name: Testimonial Basics Input Widget
Plugin URI: http://kevinsspace.ca/testimonial-basics-wordpress-plugin/
Description: A plugin to input a testimonial
Version: 3.0.0
Author: Kevin Archibald
Author URI: http://kevinsspace.ca/
License: GPLv3
*/
/** ----------- Session Start ----------------------------------------------
 * Start session if not already started. The session is required
 * for passing the password from katb_captcha.php to the input
 * form data validation
 * ------------------------------------------------------------------------- */
if(!isset($_SESSION)) session_start();
 
/** ------------- Register Widget ---------------------------------------
 *
 * The widget is registered using the widgets_init action hook that fires 
 * after all default widgets have been registered.
 * katb_input_testimonial_widget is the Class for the widget, all widgets 
 * must be created using the WP_Widget Class
 * 
 * ------------------------------------------------------------------------ */ 
function katb_input_register_register_widget() {
 	register_widget ( 'katb_input_testimonial_widget' );
 }
add_action ( 'widgets_init','katb_input_register_register_widget' );

/** -------------- katb_input_testimonial_widget Class -------------------------
 * 
 * Define Testimonial Basics Input Widget  
 * 
 * ------------------------------------------------------------------------------ */
class katb_input_testimonial_widget extends WP_Widget {

    /** The first function is required to process the widget
	 * It sets up an array to store widget options
	 * 'classname' - added to <li class="classnamne"> of the widget html
	 * 'description' - displays under Appearance => Widgets ...your widget 
	 * WP_Widget(widget list item ID,Widget Name to be shown on grag bar, options array)
	 */ 
    function katb_input_testimonial_widget() {
        $widget_ops = array( 
			'classname' => 'katb_input_widget_class', 
			'description' => __('Allow a user to input a testimonial.','testimonial-basics') 
			); 
        $this->WP_Widget( 'katb_input_testimonial_widget', __('Testimonial Input Widget','testimonial-basics'), $widget_ops );
    }
 	
	/** The second function creates the widget setting form.
	 * Each widget has a table in the Options database for it's options
	 * The array of options is $instance. The first thing we do is check to see
	 * if the title instance exists, if so use it otherwise load the default.
	 * The second part displays the title in the widget.
	 */
 	function form ( $instance ) {
 		
 		$katb_input_defaults = array(
			'katb_input_widget_title' => 'Add a Testimonial',
			'katb_input_widget_group' => 'All'
		);
		
		$instance = wp_parse_args( (array) $instance, $katb_input_defaults );
		$title = $instance['katb_input_widget_title'];
		$group = $instance['katb_input_widget_group'];
		?>
		
		<p>Title : <input class="widefat" id="<?php echo $this->get_field_id('katb_input_widget_title'); ?>" name="<?php echo $this->get_field_name('katb_input_widget_title'); ?>" type="text" value="<?php echo $title; ?>" /></p>
		<p>Group : <input class="widefat" id="<?php echo $this->get_field_id('katb_input_widget_group'); ?>" name="<?php echo $this->get_field_name('katb_input_widget_group'); ?>" type="text" value="<?php echo $group; ?>" /></p>
		<?php	
	}

	/** The third function saves the widget settings. */	
	function update ( $new_instance, $old_instance ) {
		$instance = $old_instance;
        $instance['katb_input_widget_title'] = sanitize_text_field( $new_instance['katb_input_widget_title'] );
		$instance['katb_input_widget_group'] = sanitize_text_field( $new_instance['katb_input_widget_group'] );
		
		// group validation/whitelist
		if( $instance['katb_input_widget_group'] == '' ) $instance['katb_input_widget_group'] = 'All';
		
		return $instance;
	}
	
	/** ------------------- Display Widget -------------------------------------------
	 * The input form for the testimonial widget is loaded. The visitor inputs a testimonial
	 * and clicks the submit button and the testimonial is submitted to the database 
	 * and the admin user is notified by email that they have a testimonial to review
	 * and approve. If admin user can specify if a captcha is used to help in validation.
	 * 
	 * @param array $arg array of global theme values
	 * @param array $instance array of widget form values
	 * 
	 * @uses katb_get_options user options from /includes/katb_functions.php
	 * @uses katb_allowed_html() for allowed tags from /includes/katb_functions.php
	 * 
	 *-------------------------------------------------------------------------------- */
    function widget($args, $instance) {
    	
    	//Get user options
		$katb_options = katb_get_options();
		$group_label_widget = $katb_options[ 'katb_widget_group_label' ];
		$author_label_widget = $katb_options[ 'katb_widget_author_label' ];
		$email_label_widget = $katb_options[ 'katb_widget_email_label' ];
		$website_label_widget = $katb_options[ 'katb_widget_website_label' ];
		$location_label_widget = $katb_options[ 'katb_widget_location_label' ];
		$rating_label_widget =  $katb_options[ 'katb_widget_rating_label' ];
		$testimonial_label_widget = $katb_options[ 'katb_widget_testimonial_label' ];
		$submit_label_widget = $katb_options[ 'katb_widget_submit_label' ];
		$reset_label_widget = $katb_options[ 'katb_widget_reset_label' ];
		$exclude_website = $katb_options[ 'katb_exclude_website_input' ];
		$exclude_location = $katb_options[ 'katb_exclude_location_input' ];
		$use_ratings = $katb_options[ 'katb_use_ratings' ];
		//Get the widget title and display
    	extract ( $args);
		echo $before_widget;
		$title = apply_filters( 'widget_title', $instance['katb_input_widget_title'] );
		if ( !empty( $title )) { echo $before_title.esc_html($title).$after_title;}
		//Set up database table name for use later
		global $wpdb,$tablename;
		$tablename = $wpdb->prefix.'testimonial_basics';
		//Initialize Variables
		$katb_widget_group = $group_label_widget;
		$katb_widget_author = $author_label_widget;
		$katb_widget_email = $email_label_widget;
		$katb_widget_website = $website_label_widget;
		$katb_widget_location = $location_label_widget;
		$katb_widget_testimonial = $testimonial_label_widget;
		$katb_allowed_html = katb_allowed_html();
		$katb_widget_group = esc_attr($instance['katb_input_widget_group']);
		if( $katb_widget_group == '' ) {
			$katb_widget_group = 'All';
		}
		
		//Process input form
		if ( isset($_POST['widget_submitted']) && wp_verify_nonce( $_POST['katb_widget_form_nonce'],'katb_nonce_2')) {
			//Validate Input
			//initialize error string
			$katb_widget_input_error = "";
			//Set default variables
			$katb_widget_order = "";
			//$katb_widget_group = "All";
			$katb_widget_approved = 0;
			$katb_widget_datetime = current_time('mysql');
			
			//validate author
			$katb_widget_author = sanitize_text_field($_POST['tb_author']);
			if ($katb_widget_author == $author_label_widget || $katb_widget_author == "") {
				$katb_widget_input_error .= ':'.__('Author','testimonial-basics');
				$katb_widget_author = __('Author - Required','testimonial-basics');
			}
			
			//validate email
			$katb_widget_email = sanitize_email($_POST['tb_email']);
			if (!is_email($katb_widget_email)) {
				$katb_widget_input_error .= ':'.__('Email','testimonial-basics');
				$katb_widget_email = $email_label_widget;
			}
			
			//validate website
			if( $exclude_website != 1 ){
				$katb_widget_website = trim($_POST['tb_website']);
				if ($katb_widget_website != '')$katb_widget_website = esc_url($_POST['tb_website']);
				if ( $katb_widget_website == 'http://'.$website_label_widget ) $katb_widget_website = '';
			} else {
				$katb_widget_website = '';
			}
			
			//validate location
			if( $exclude_location != 1 ) {
				$katb_widget_location = sanitize_text_field($_POST['tb_location']);
				if ( $katb_widget_location == $location_label_widget ) $katb_widget_location = '';
			} else {
				$katb_widget_location = '';
			}
			
			//validate rating
			if( $use_ratings == 1 ) {
				$katb_widget_rating = sanitize_text_field($_POST['tb_rating']);
			} else {
				$katb_widget_rating = '0.0';
			}
			
			//validate testimonial
			$katb_widget_testimonial = wp_kses($_POST['tb_testimonial'],$katb_allowed_html);
			//$katb_widget_testimonial = wp_kses_post( $_POST['tb_testimonial'] );
			if ( $katb_widget_testimonial == $testimonial_label_widget || $katb_widget_testimonial == "" ) {
				$katb_widget_input_error .= ':'.__('Testimonial','testimonial-basics');
				$katb_widget_testimonial = $testimonial_label_widget;
			}
			
			//Captcha Validation
			if ($katb_options['katb_use_captcha'] == TRUE || $katb_options['katb_use_captcha'] == 1 ) {
				$katb_captcha_entered = sanitize_text_field($_POST['verify']);
				if ($_SESSION['katb_pass_phrase'] !== sha1($katb_captcha_entered)){
					$katb_widget_input_error .= ':'.__('Captcha','testimonial-basics');
				}
			}	
			//Validation complete
			if($katb_widget_input_error == "") {
				//OK $error is empty so let's update the database
				$values = array(
				'tb_date' => $katb_widget_datetime,
				'tb_order' => $katb_widget_order,
				'tb_approved' => $katb_widget_approved,
				'tb_group' => $katb_widget_group,
				'tb_name' => $katb_widget_author,
				'tb_email' => $katb_widget_email,
				'tb_location' => $katb_widget_location,
				'tb_url' => $katb_widget_website,
				'tb_rating' => $katb_widget_rating,
				'tb_testimonial' => $katb_widget_testimonial
				);
				$formats_values = array('%s','%d','%d','%s','%s','%s','%s','%s','%s','%s');
				$wpdb->insert($tablename,$values,$formats_values);
				echo '<div class="katb_widget_sent">'.__('Submitted-Thankyou!','testimonial-basics').'</div>';
				//send email
				if ( $katb_options['katb_contact_email'] != '' ) {
					$emailTo = $katb_options['katb_contact_email'];
				} else {
					$emailTo = get_option('admin_email');
				}
				$subject = __('You have received a testimonial!','testimonial-basics');
				$body = __('Name: ','testimonial-basics').' '
						.stripcslashes($katb_widget_author)."<br/><br/>"
						.__('Email: ','testimonial-basics').' '
						.stripcslashes($katb_widget_email)."<br/><br/>"
						.__('Comments: ','testimonial-basics')."<br/><br/>"
						.stripcslashes($katb_widget_testimonial)."<br/><br/>"
						.__('Log in to approve it:','testimonial-basics').'<a href="'.site_url("/wp-login.php").'" title="your site login">Log In</a>';
				
				$headers = 'From: '.stripcslashes($katb_widget_author).' <'.stripcslashes($katb_widget_email).'>';
				add_filter('wp_mail_content_type',create_function('', 'return "text/html";'));
				wp_mail($emailTo, $subject, $body, $headers);
				
				//Now empty the variables
				$katb_widget_id = "";
				$katb_widget_order = "";
				$katb_widget_approved = "";
				$katb_widget_author = $author_label_widget;
				$katb_widget_website = $website_label_widget;
				$katb_widget_location = $location_label_widget;
				$katb_widget_testimonial = $testimonial_label_widget;
				$katb_widget_email = $email_label_widget;
				$katb_widget_rating = '0.0';
				
			} else {
				echo '<div class="katb_widget_error">'.__('Error','testimonial-basics').$katb_widget_input_error.'</div>';
				if ( $katb_widget_website == '' ) $katb_widget_website = $website_label_widget;
				if ( $katb_widget_location == '' ) $katb_widget_location = $location_label_widget;
			}
		}
	/* ---------- Reset button is clicked ---------------- */
	if(isset($_POST['widget_reset'])) {
		$katb_widget_author =  $author_label_widget;
		$katb_widget_email = $email_label_widget;
		$katb_widget_website = $website_label_widget;
		$katb_widget_location = $location_label_widget;
		$katb_widget_testimonial = $testimonial_label_widget;
		$katb_widget_rating = '0.0';
	}
		?>
		<div class="katb_widget_form">
			
			<?php if($katb_options['katb_include_email_note'] == 1) { ?>
				<p><?php echo stripslashes($katb_options['katb_email_note']); ?></p>
			<?php } ?>
			
			<form method="POST" action="#">
				
				<?php wp_nonce_field("katb_nonce_2","katb_widget_form_nonce"); ?>
				
				<input  class="katb_input" type="text" name="tb_author" value="<?php echo esc_attr( $katb_widget_author ); ?>" />
				
				<input  class="katb_input" type="text" name="tb_email" value="<?php echo esc_attr( $katb_widget_email ); ?>" />
				
				<?php if( $exclude_website != 1 ) { ?>
					<input  class="katb_input" type="text" name="tb_website" value="<?php echo esc_attr( $katb_widget_website ); ?>" />
				<?php }
				
				if ( $exclude_location != 1 ) { ?>
					<input  class="katb_input" type="text" name="tb_location" value="<?php echo esc_attr( $katb_widget_location ); ?>" />
				<?php }
				
				if( $use_ratings == 1 ) { ?>
					
					<label><?php echo esc_attr( $rating_label_widget ); ?></label>
					
					<select id="katb_widget_rateit_input" class="katb_rating_input" name="tb_rating">
						<option <?php selected($katb_widget_rating,'0.0'); ?> value="0.0">0.0</option>
						<option <?php selected($katb_widget_rating,'0.5'); ?> value="0.5">0.5</option>
						<option <?php selected($katb_widget_rating,'1.0'); ?> value="1.0">1.0</option>
						<option <?php selected($katb_widget_rating,'1.5'); ?> value="1.5">1.5</option>
						<option <?php selected($katb_widget_rating,'2.0'); ?> value="2.0">2.0</option>
						<option <?php selected($katb_widget_rating,'2.5'); ?> value="2.5">2.5</option>
						<option <?php selected($katb_widget_rating,'3.0'); ?> value="3.0">3.0</option>
						<option <?php selected($katb_widget_rating,'3.5'); ?> value="3.5">3.5</option>
						<option <?php selected($katb_widget_rating,'4.0'); ?> value="4.0">4.0</option>
						<option <?php selected($katb_widget_rating,'4.5'); ?> value="4.5">4.5</option>
						<option <?php selected($katb_widget_rating,'5.0'); ?> value="5.0">5.0</option>
					</select>
					
					<div class="rateit katb_widget_input_rating" data-rateit-backingfld="#katb_widget_rateit_input"></div>
					
				<?php } ?>
				
				<textarea name="tb_testimonial" rows="5" ><?php echo esc_attr($katb_widget_testimonial); ?></textarea>
				
				<?php 
					if ( $katb_options['katb_show_html_widget'] == TRUE || $katb_options['katb_show_html_widget'] == 1 ) { 
						echo '<p>HTML: <code>a p br i em strong q h1-h6</code></p>';
					}
				if ( $katb_options['katb_use_captcha'] == TRUE || $katb_options['katb_use_captcha'] == 1 ) {
					if ( $katb_options['katb_use_color_captcha'] == TRUE || $katb_options['katb_use_color_captcha'] == 1 ) { ?>
						<img src="<?php echo site_url() ?>/wp-content/plugins/testimonial-basics/includes/katb_captcha_color.php" alt="Verification Captcha" />
					<?php } else { ?>
						<img src="<?php echo site_url() ?>/wp-content/plugins/testimonial-basics/includes/katb_captcha_bw.php" alt="Verification Captcha" />
					<?php } ?>
					<input class="katb_captcha_widget_input" type="text" id="verify" name="verify" value="<?php _e('Enter Captcha','testimonial-basics') ?>" onclick="this.select();" /><br/>
				<?php } ?>
				
				<input class="katb_widget_submit" type="submit" name="widget_submitted" value="<?php echo esc_attr( $submit_label_widget ); ?>" />
				
				<input class="katb_widget_reset" type="submit" name="widget_reset" value="<?php echo esc_attr( $reset_label_widget ); ?>" />
			
			</form>
			
			<div class="katb_clear_fix"></div>
			
			<?php if ($katb_options['katb_use_gravatars'] == 1 || $katb_options['katb_widget_use_gravatars'] == 1 ) { ?>
				<span class="katb_use_gravatar_wrap">
					<span class="use_gravatar"><?php _e('Add a Photo? ','testimonial-basics'); ?></span>
					<a href="https://en.gravatar.com/" title="Gravatar Site" target="_blank" >
						<img class="gravatar_logo" src="<?php echo plugins_url(); ?>/testimonial-basics/includes/Gravatar80x16.jpg" alt="Gravatar Website" title="Gravatar Website" />
					</a>
				</span>
				
			<?php } ?>
			
		</div>
		
		<?php
		
		echo '<br style="clear:both;" />';
		
		echo $after_widget;
		
    }
}