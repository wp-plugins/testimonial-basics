<?php
/* This file contains all the shortcodes for use in the Testimonial Basics Plugin
 * ---------------------------------------------------------------------------------- */
 
  // Allows shortcodes to be displayed in sidebar widgets
add_filter('widget_text', 'do_shortcode');

/* ------------------ messagebox shortcode ---------------------------------
 * useage : [katb_testimonial by="date" number="all" id=""] 
 * ------------------------------------------------------------------------- */

function katb_list_testimonials ( $atts) {
	global $wpdb,$tablename;
	$tablename = $wpdb->prefix.'testimonial_basics';
	$katb_html = '';
	$katb_error = "";
	extract(shortcode_atts(array(
	    'by' => 'date',
	    'number' => 'all',
	    'id' => '',
    ), $atts));
	//Validate data
	$by = sanitize_text_field($by);
	$number = sanitize_text_field($number);
	$id = sanitize_text_field($id);
	if ($by != 'date' && $by != 'order') $by = 'date';
	//OK let's start by getting the testimonial data from the database
	if ( $number == 'all' && $id == '' && $by == 'date' ) {
		$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' ORDER BY `tb_date` DESC ",ARRAY_A);
		$katb_tnumber = $wpdb->num_rows;
	} elseif ( $number == 'all' && $id == '' && $by == 'order' ) {
		$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' ORDER BY `tb_order` DESC,`tb_date` DESC ",ARRAY_A);
		$katb_tnumber = $wpdb->num_rows;
	} elseif ( intval($number) > 0 && $id == '' && $by == 'date' ) {
		$number = intval( $number );
		$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' ORDER BY `tb_date` DESC LIMIT 0,$number ",ARRAY_A);
		$katb_tnumber = $wpdb->num_rows;
	} elseif ( intval($number) > 0 && $id == '' && $by == 'order' ) {
		$number = intval( $number );
		$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_approved` = '1' ORDER BY `tb_order` DESC,`tb_date` DESC LIMIT 0,$number ",ARRAY_A);
		$katb_tnumber = $wpdb->num_rows;
	} elseif ($id != '' ) {
		if ( $id == 'random' ) {
			$katb_tdata2 = $wpdb->get_results( " SELECT `tb_id` FROM `$tablename` WHERE `tb_approved` = '1' ",ARRAY_A);
			$katb_tnumber = $wpdb->num_rows;
			$rand = rand(0, $katb_tnumber-1);
			$random_id = $katb_tdata2[$rand]['tb_id'];
			$katb_tdata = $wpdb->get_results("SELECT * FROM `$tablename` WHERE `tb_approved` = '1' AND `tb_id` = $random_id ",ARRAY_A );
			$katb_tnumber = $wpdb->num_rows;
			if ( $katb_tnumber == 0 ) $katb_error = __('Could not select a random testimonial. Please check your shortcode.','testimonial_basics');
		} elseif (intval($id != '')) {
			$id = intval($id);
			$katb_tdata = $wpdb->get_results("SELECT * FROM `$tablename` WHERE `tb_approved` = '1' AND `tb_id` = $id ",ARRAY_A );
			$katb_tnumber = $wpdb->num_rows;
			if ( $katb_tnumber == 0 ) $katb_error = __('Testimonial not found. Please check your shortcode.','testimonial_basics');
		} else {
			//$id is an unknown
			$katb_error = __('Testimonial not found. Please check your shortcode.','testimonial_basics');
		}
		
	} else {
		// something didnot work
		$katb_error =  __('Testimonial not found. Please check your shortcode.','testimonial_basics');
	}
	// Database queried
	//Lets prepare the return string
	if( $katb_error != '') {
		$katb_html = '<div class="katb_error">'.$katb_error.'</div>';
	} else {
		$katb_html .= '<div class="katb_test_wrap">';
		for ( $i = 0 ; $i < $katb_tnumber; $i++ ) {
			$katb_html .= '<div class="katb_test_box">';
			$katb_html .= '<span class="katb_test_text">'.stripcslashes($katb_tdata[$i]['tb_testimonial']).'</span><br/>';
			$katb_html .= '<span class="katb_test_meta">'.stripcslashes($katb_tdata[$i]['tb_name']);
			if ( $katb_tdata[$i]['tb_location'] != "" ) $katb_html .= ', '.stripcslashes($katb_tdata[$i]['tb_location']);
			if ( $katb_tdata[$i]['tb_url'] != "" ) $katb_html .= ', <a href="'.esc_url($katb_tdata[$i]['tb_url']).'" title="Testimonial_author_site" >'.$katb_tdata[$i]['tb_url'].'</a>';
			$katb_html .= '</span>';
			$katb_html .= '</div>';
		}
		$katb_html .= '</div>';
	}
	return $katb_html;
}
add_shortcode('katb_testimonial', 'katb_list_testimonials');

?>