<?php
/*
Plugin Name: Testimonial Basics Display Widget
Plugin URI: http://demo1.kevinsspace.ca/
Description: A plugin to input a testimonial
Version: 1.0
Author: Kevin Archibald
Author URI: http://www.kevinsspace.ca/
License: GPLv3
 */
 
 // use widgets_init action hook to execute custom function
 add_action ( 'widgets_init','katb_display_register_register_widget' );

//register our widget 
 function katb_display_register_register_widget() {
 	register_widget ( 'katb_display_testimonial_widget' );
 }
 
 //widget class
class katb_display_testimonial_widget extends WP_Widget {

    //process the new widget
    function katb_display_testimonial_widget() {
        $widget_ops = array( 
			'classname' => 'katb_display_widget_class', 
			'description' => __('Display a random or selected testimonial.','testimonial-basics') 
			); 
        $this->WP_Widget( 'katb_display_testimonial_widget', __('Testimonial Display Widget','testimonial-basics'), $widget_ops );
    }
 	
 	// Form for widget setup
 	function form ( $instance ) {
		$title = isset($instance['title']) ? esc_attr($instance['title']) : __('Testimonial','testimonial-basics');
		$type = isset($instance['type']) ? esc_attr($instance['type']) : 'random';
		?>
		<p>Title :
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>
		<p>Random or ID :
		<input class="widefat" id="<?php echo $this->get_field_id('type'); ?>" name="<?php echo $this->get_field_name('type'); ?>" type="text" value="<?php echo $type; ?>" /></p>
		<?php	
	}
	
	//save the widget settings
	function update ( $new_instance, $old_instance ) {
		$instance = $old_instance;
        $instance['title'] = strip_tags( $new_instance['title'] );
		$instance['type'] = strip_tags( $new_instance['type'] );
		
		return $instance;
	}
	
	//display the widget
    function widget($args, $instance) {
    	extract ( $args);
		echo $before_widget;
		$title = apply_filters( 'widget_title', $instance['title'] );
		$id = esc_attr($instance['type']);
		if ( $id != 'random' && is_numeric($id) == false );
		if ( !empty( $title )) { echo $before_title.$title.$after_title;}
		global $wpdb,$tablename;
		$tablename = $wpdb->prefix.'testimonial_basics';
		$katb_display_widget_error = "";
		
		if ( $id == 'random' ) {
			$katb_tdata2 = $wpdb->get_results( " SELECT `tb_id` FROM `$tablename` WHERE `tb_approved` = '1' ",ARRAY_A);
			$katb_tnumber = $wpdb->num_rows;
			$rand = rand(0, $katb_tnumber-1);
			$random_id = $katb_tdata2[$rand]['tb_id'];
			$katb_tdata = $wpdb->get_results("SELECT * FROM `$tablename` WHERE `tb_approved` = '1' AND `tb_id` = $random_id ",ARRAY_A );
			$katb_tnumber = $wpdb->num_rows;
			if ( $katb_tnumber == 0 ) $katb_display_widget_error = __('Could not select a random testimonial','testimonial-basics');
		} elseif (intval($id != '')) {
			//$id = intval($id);
			$katb_tdata = $wpdb->get_results("SELECT * FROM `$tablename` WHERE `tb_approved` = '1' AND `tb_id` = $id ",ARRAY_A );
			$katb_tnumber = $wpdb->num_rows;
			if ( $katb_tnumber == 0 ) $katb_display_widget_error = __('Could not find testimonial','testimonial-basics');
		} else {
			//$id is an unknown
			$katb_display_widget_error = __('Could not find testimonial','testimonial-basics');
		}
		// Database queried
		//Lets display the selected testimonial
		if( $katb_display_widget_error != '') {
			$katb_html .= '<div class="katb_display_widget_error">'.$katb_display_widget_error.'</div>';
		} else {
			$katb_html .= '<div class="katb_widget_test_wrap">';
			$katb_html .= '<div class="katb_widget_test_box">';
			$katb_html .= '<span class="katb_widget_text" >'.stripcslashes($katb_tdata[0]['tb_testimonial']).'</span><br/>';
			$katb_html .= '</div>';
			$katb_html .= '<span class="katb_widget_test_meta">'.stripcslashes($katb_tdata[0]['tb_name']);
			if ( $katb_tdata[0]['tb_location'] != "" ) $katb_html .= ', '.stripcslashes($katb_tdata[0]['tb_location']);
			if ( $katb_tdata[0]['tb_url'] != "" ) $katb_html .= ', <a href="'.esc_url($katb_tdata[0]['tb_url']).'" title="Testimonial_author_site" >'.$katb_tdata[0]['tb_url'].'</a>';
			$katb_html .= '</span>';
			$katb_html .= '</div>';
		}
		echo $katb_html;
		echo $after_widget; 
    }
 
}
?>