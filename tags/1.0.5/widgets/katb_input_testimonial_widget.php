<?php
/*
Plugin Name: Testimonial Basics Input Widget
Plugin URI: http://demo1.kevinsspace.ca/
Description: A plugin to input a testimonial
Version: 1.0
Author: Kevin Archibald
Author URI: http://www.kevinsspace.ca/
License: GPLv3
 */
if(!isset($_SESSION)) session_start();
 // use widgets_init action hook to execute custom function
 add_action ( 'widgets_init','katb_input_register_register_widget' );

//register our widget 
 function katb_input_register_register_widget() {
 	register_widget ( 'katb_input_testimonial_widget' );
 }
 
 //widget class
class katb_input_testimonial_widget extends WP_Widget {

    //process the new widget
    function katb_input_testimonial_widget() {
        $widget_ops = array( 
			'classname' => 'katb_input_widget_class', 
			'description' => __('Allow a user to input a testimonial.','testimonial-basics') 
			); 
        $this->WP_Widget( 'katb_input_testimonial_widget', __('Testimonial Input Widget','testimonial-basics'), $widget_ops );
    }
 	
 	// Form for widget setup
 	function form ( $instance ) {
		$title = isset($instance['title']) ? esc_attr($instance['title']) : __('Add a Testimonial','testimonial-basics');
		?>
		<p><?php _e('Title :','testimonial-basics'); ?>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>
		<?php	
	}
	
	//save the widget settings
	function update ( $new_instance, $old_instance ) {
		$instance = $old_instance;
        $instance['title'] = strip_tags( $new_instance['title'] );
		
		return $instance;
	}
	
	//display the widget
    function widget($args, $instance) {

    	extract ( $args);
		echo $before_widget;
		$title = apply_filters( 'widget_title', $instance['title'] );
		if ( !empty( $title )) { echo $before_title.$title.$after_title;}
		global $wpdb,$tablename;
		$tablename = $wpdb->prefix.'testimonial_basics';
		$katb_widget_author = __('Author - Required','testimonial-basics');
		$katb_widget_email = __('Email - Required','testimonial-basics');
		$katb_widget_website = __('Website - Optional','testimonial-basics');
		$katb_widget_location = __('Location - Optional','testimonial-basics');
		$katb_widget_testimonial = __('Testimonial - Required','testimonial-basics');
		//if(isset($_POST['widget_submitted'])) {
		if ( isset($_POST['widget_submitted']) && wp_verify_nonce( $_POST['katb_widget_form_nonce'],'katb_nonce_2')) {
			//Validate Input
			//initialize error string
			$katb_widget_input_error = "";
			//Set default variables
			$katb_widget_order = "";
			$katb_widget_approved = 0;
			$katb_datetime = current_time('mysql');
			//validate author
			$katb_widget_author = sanitize_text_field($_POST['tb_author']);
			if ($katb_widget_author == __('Author - Required','testimonial-basics') || $katb_widget_author == "") {
				$katb_widget_input_error .= ':'.__('Author','testimonial-basics');
				$katb_widget_author = __('Author - Required','testimonial-basics');
			}
			//validate email
			$katb_widget_email = $_POST['tb_email'];
			if (!is_email($katb_widget_email)) {
				$katb_widget_input_error .= ':'.__('Email','testimonial-basics');
				$katb_widget_email = __('Email - Required','testimonial-basics');
			}
			//validate website
			$katb_widget_website = esc_url($_POST['tb_website']);
			if ( $katb_widget_website == 'http://'.__('Website-Optional','testimonial-basics') ) $katb_widget_website = '';
			//validate location
			$katb_widget_location = sanitize_text_field($_POST['tb_location']);
			if ( $katb_widget_location == __('Location - Optional','testimonial-basics') ) $katb_widget_location = '';
			//validate testimonial
			$katb_widget_testimonial = sanitize_text_field($_POST['tb_testimonial']);
			if ( $katb_widget_testimonial == __('Testimonial - Required','testimonial-basics') || $katb_widget_testimonial == "" ) {
				$katb_widget_input_error .= ':'.__('Testimonial','testimonial-basics');
				$katb_widget_testimonial = __('Testimonial - Required','testimonial-basics');
			}
			//Captcha Validation
			if (get_option('katb_use_captcha') === FALSE || get_option('katb_use_captcha') == 1 ) {
				if ($_SESSION['pass_phrase'] !== sha1($_POST['verify'])){
					$katb_widget_input_error .= ':'.__('Captcha','testimonial-basics');
				}
			}	
			//Validation complete
			if($katb_widget_input_error == "") {
				//OK $error is empty so let's update the database
				$values = array(
					'tb_date' => $katb_datetime,
					'tb_order' => $katb_widget_order,
					'tb_approved' => $katb_widget_approved,
					'tb_name' => $katb_widget_author,
					'tb_location' => $katb_widget_location,
					'tb_url' => $katb_widget_website,
					'tb_testimonial' => $katb_widget_testimonial
				);
				$formats_values = array('%s','%d','%d','%s','%s','%s','%s');
				$wpdb->insert($tablename,$values,$formats_values);
				echo '<div class="katb_widget_sent">'.__('Submitted-Thank you!','testimonial-basics').'</div>';
				//email to administrators
				$emailTo = get_option('admin_email');
				$subject = __('You have received a testimonial from ','testimonial-basics').' '.$katb_widget_author;
				$body = __('Name:','testimonial-basics').' '.$katb_widget_author." \n\n".__('Email: ','testimonial-basics').' '.$katb_widget_email." \n\n".__('Comments: ','testimonial-basics').' '.$katb_widget_testimonial;
				$headers = 'From: '.$katb_widget_email.' <'.$emailTo.'>' . "\r\n" .'Reply-To: ' . $katb_widget_email;
				wp_mail($emailTo, $subject, $body, $headers);
				//Now empty the variables
				$katb_widget_id = "";
				$katb_widget_order = "";
				$katb_widget_approved = "";
				$katb_widget_author = __('Author - Required','testimonial-basics');
				$katb_widget_website = __('Website - Optional','testimonial-basics');
				$katb_widget_location = __('Location - Optional','testimonial-basics');
				$katb_widget_testimonial = __('Testimonial - Required','testimonial-basics');
				$katb_widget_email = __('Email - Required','testimonial-basics');
			} else {
				echo '<div class="katb_widget_error">Error'.$katb_widget_input_error.'</div>';
				if ( $katb_widget_website == '' ) $katb_widget_website = __('Website - Optional','testimonial-basics');
				if ( $katb_widget_location == '' ) $katb_widget_location = __('Location - Optional','testimonial-basics');
			}
		}
	/* ---------- Reset button is clicked ---------------- */
	if(isset($_POST['widget_reset'])) {
		$katb_widget_author =  __('Author - Required','testimonial-basics');
		$katb_widget_email = __('Email - Required','testimonial-basics');
		$katb_widget_website = __('Website - Optional','testimonial-basics');
		$katb_widget_location = __('Location - Optional','testimonial-basics');
		$katb_widget_testimonial = __('Testimonial - Required','testimonial-basics');
	}
		?>
		<div class="katb_widget_form">
		<p><?php _e('Email address is not kept','testimonial-basics') ?></p>
		<form method="POST" action="#">
		<?php wp_nonce_field("katb_nonce_2","katb_widget_form_nonce"); ?>
		<input  class="katb_input" type="text" name="tb_author" value="<?php echo esc_attr( $katb_widget_author ); ?>" />
		<input  class="katb_input" type="text" name="tb_email" value="<?php echo esc_attr( $katb_widget_email ); ?>" />
		<input  class="katb_input" type="text" name="tb_website" value="<?php echo esc_attr( $katb_widget_website ); ?>" />
		<input  class="katb_input" type="text" name="tb_location" value="<?php echo esc_attr( $katb_widget_location ); ?>" />
		<textarea name="tb_testimonial" rows="5" ><?php echo esc_attr($katb_widget_testimonial); ?></textarea>
		<?php if (get_option('katb_use_captcha') === FALSE || get_option('katb_use_captcha') == 1 ) { ?>
			<img width="85" src="<?php echo site_url() ?>/wp-content/plugins/testimonial-basics/includes/katb_captcha.php" alt="Verification Captcha" />
			<input type="text" size="15" id="verify" name="verify" value="<?php _e('Enter Captcha','testimonial-basics') ?>" /><br/>
		<?php } ?>
		<input class="katb_widget_submit" type="submit" name="widget_submitted" value="<?php _e('Submit','testimonial-basics') ?>" />
		<input class="katb_widget_reset" type="submit" name="widget_reset" value="<?php _e('Reset','testimonial-basics') ?>" />
		</form>
		</div>
		<?php
		echo $after_widget; 
    }
 
}
?>