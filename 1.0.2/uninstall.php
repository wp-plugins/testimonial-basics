<?php
   /* This is uninstall.php for the plugin testimonial-basics */
   echo 'This is working';
   // If uninstall not called from WordPress exit this function
   if( !defined( 'WP_UNINSTALL_PLUGIN' ) ) exit();
   // Delete Options
   delete_option( 'katb_use_captcha' );
   delete_option( 'widget_katb_display_testimonial_widget');
   delete_option('widget_katb_input_testimonial_widget');
   // remove any additionsl options and dadabase tables not removed above
 	global $wpdb;
	$tablename = $wpdb->prefix.'testimonial_basics';
	$wpdb->query("DROP TABLE IF EXISTS $tablename");
?>