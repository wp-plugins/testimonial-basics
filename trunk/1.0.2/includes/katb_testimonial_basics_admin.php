<?php
/*
 * Testimonial Basics Plugin admim php script
 * */
//admin functions
add_action( 'admin_menu', 'katb_testimomial_basics_create_menu' );

function katb_testimomial_basics_create_menu() {
	//create custom top-level menu
	global $katb_testimonial_basics_admin_help;
	$katb_testimonial_basics_admin_help = add_plugins_page( 'Testimonial Basics', 'Testimonial Basics', 'manage_options', 'katb_testimonial_basics_admin','katb_testimomial_basics_edit_page' );
}

/**
 *  Admin Style  katb_testimonial_basics_admin.css	 */
function katb_testimonial_basic_admin_style() {
	wp_register_style( 'testimonial_basic_admin_style',plugins_url() . '/testimonial-basics/css/katb_testimonial_basics_admin.css',array(),'20120815','all' ); 
 	// enqueing:
	wp_enqueue_style( 'testimonial_basic_admin_style' );
}
add_action('admin_enqueue_scripts', 'katb_testimonial_basic_admin_style');


function katb_testimomial_basics_edit_page(){
	global $wpdb,$tablename;
	$tablename = $wpdb->prefix.'testimonial_basics';
	//check user options
	if( get_option( 'katb_use_captcha' ) === FALSE ) {
		$katb_use_captcha = 1;
	} else {
		$katb_use_captcha = get_option( 'katb_use_captcha' );
	}
	if ( isset ( $_POST['save_options'] )) {
		$katb_use_captcha = $_POST['katb_input_use_captcha'] == 1 ? 1 : 0 ;
		update_option( 'katb_use_captcha' , $katb_use_captcha );
	}
	//submit testimonial
	if ( isset($_POST['submitted']) && check_admin_referer('katb_nonce_3','katb_admin_form_nonce')) {
		//Validate Input
		$error = "";
		$katb_id = $_POST['tb_id'];
		// Order must be an integer
		$katb_order = trim($_POST['tb_order']);
		if ($katb_order != "") {
			if(is_numeric($katb_order) == FALSE) {
				$katb_order = "";
				$error .= '*'.__('Order must be a integer','testimonial-basics').'*';
			}
		}
		//Approved is either checked (1) or not checked (0)
		if (!isset($_POST['tb_approved'])){
			$katb_approved = 0;
		} else {
			$katb_approved = 1;
		}
		$katb_author = sanitize_text_field(trim($_POST['tb_author']));
		if ($katb_author == "") {
			$error .= '*'.__('Author is required','testimonial-basics').'*';
		}
		$katb_website = esc_url(trim($_POST['tb_website']));
		$katb_location = sanitize_text_field(trim($_POST['tb_location']));
		$katb_date = trim($_POST['tb_date']);
		//Date Validation
		if ($katb_date != "") {
			$year = intval(substr($katb_date,0,4));
			$month = intval(substr($katb_date,5,2));
			$day = intval(substr($katb_date,8,2));
			if( !checkdate( $month, $day, $year ) ){
				$error .= '*'.__('Date must be','testimonial-basics').' YYYY-MM-DD*';
			}
		}
		$katb_time = trim($_POST['tb_time']);
		//Time Validadtion
		if($katb_time != ""){
			$hour = intval(substr($katb_time,0,2));
			$min = intval(substr($katb_time,3,2));
			$sec = intval(substr($katb_time,6,2));
			if ( $hour < 0 || $hour > 23 || $min < 0 || $min > 59 || $sec < 0 || $sec > 59 || substr($katb_time,2,1) != ":" || substr($katb_time,5,1) != ":" ){
				$error .= '*'.__('Time must be','testimonial-basics').' HH:MM:SS*';
			}
		}
		if($katb_date == "" && $katb_time == "") {
			$katb_datetime = current_time('mysql');
		}elseif($katb_date != "" && $katb_time == ""){
			$katb_datetime = $katb_date.' 00:00:00';
		}elseif($katb_date == "" && $katb_time != ""){
			$katb_datetime = current_time('mysql');
		}else{
			$katb_datetime = $katb_date.' '.$katb_time;
		}
		$katb_date = substr($katb_datetime,0,10);
		$katb_time = substr($katb_datetime,11,8);
		$katb_testimonial = sanitize_text_field(trim($_POST['tb_testimonial']));
		if ($katb_testimonial == "" ) {
			$error .= '*'.__('Testimonial is required','testimonial-basics').'*';
		}
		//Validation complete
		if($error == "") {
			//OK $error is empty so let's update the database
			$values = array(
				'tb_date' => $katb_datetime,
				'tb_order' => $katb_order,
				'tb_approved' => $katb_approved,
				'tb_name' => $katb_author,
				'tb_location' => $katb_location,
				'tb_url' => $katb_website,
				'tb_testimonial' => $katb_testimonial
			);
			$formats_values = array('%s','%d','%d','%s','%s','%s','%s');
			if($katb_id == ""){
				$wpdb->insert($tablename,$values,$formats_values);
				$katb_id = $wpdb->insert_id;

			}else{
				$where = array('tb_id' => $katb_id);
				$wpdb->update($tablename,$values,$where,$formats_values);
			}
			echo '<div id="message" class="updated">'.__('Testimonial added successfuly.','testimonial-basics').'</div>';
		} else {
			echo '<div id="message" class="error">'.__('Error,testimonial was not added','testimonial-basics').': '.$error.'</div>';
		}
	}
	/* ---------- Reset button is clicked ---------------- */
	if(isset($_POST['reset'])) {
		$katb_id = "";
		$katb_order = "";
		$katb_approved = "";
		$katb_date = "";
		$katb_time = "";
		$katb_author = "";
		$katb_website = "";
		$katb_location = "";
		$katb_testimonial = "";
	}
	/* ---------------- Delete Button is clicked ------------- */
	if(isset($_POST['delete'])) {
		$katb_id = $_POST['tb_id'];
		if($katb_id == ""){
			echo '<div id="message" class="error">'.__('Error, no ID','testimonial-basics').'</div>';
		}else{}
		$wpdb->query(" DELETE FROM `$tablename` WHERE `tb_id`=$katb_id " );
		$katb_id = "";
		$katb_order = "";
		$katb_approved = "";
		$katb_date = "";
		$katb_time = "";
		$katb_author = "";
		$katb_website = "";
		$katb_location = "";
		$katb_testimonial = "";
		echo '<div id="message" class="updated">'.__('Testimonial was deleted.','testimonial-basics').'</div>';
	}
	if(isset($_POST['edit'])){
		$katb_id = $_POST['edit'];
		$edit_data = $wpdb->get_row("SELECT * FROM `$tablename` WHERE `tb_id` = $katb_id ",ARRAY_A );
		$katb_order=$edit_data['tb_order'];
		$katb_author=$edit_data['tb_name'];
		$katb_website=$edit_data['tb_url'];
		$katb_location=$edit_data['tb_location'];
		$katb_testimonial=$edit_data['tb_testimonial'];
		$katb_approved=$edit_data['tb_approved'];
		$katb_date = substr($edit_data['tb_date'],0,10);
		$katb_time = substr($edit_data['tb_date'],11,8);
	}
?>
	<div class="wrap">
		<?php screen_icon( 'plugins' ); ?>
		<h2>Testimonial Basics</h2>
		<span class="katb_paypal"><?php _e('Show your appreciation!','testimonial-basics') ?>
			<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
			<input type="hidden" name="cmd" value="_s-xclick">
			<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----
			">
			<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_paynow_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
			<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
			</form>
		</span>
		<p><?php _e('Author Site : ','testimonial-basics'); ?><a href="http://www.kevinsspace.ca" target="_blank" >www.kevinsspace.ca</a>&nbsp;&nbsp;&nbsp; 
			<?php _e('Plugin Site : ','testimonial-basics'); ?><a href="http://demo1.kevinsspace.ca/testimonial-basics-wordpress-plugin/" target="_blank" >demo1.kevinsspace.ca/testimonial-basics/</a></p>
		<p><?php _e('Click the Help button for instructions or see the testimonial_basics_docs.html file included in the plugin docs folder.','testimonial-basics'); ?></p>
		<h3><?php _e('Options','testimonial-basics'); ?></h3>
		<form method="POST" action="#">
			<label><?php _e('Use Captcha on Input Forms:','testimonial-basics'); ?></label>
			<input type="checkbox" name="katb_input_use_captcha" value="1" <?php if($katb_use_captcha == 1) echo 'checked="checked"'; ?> />
			<input type="submit" name="save_options" value="<?php _e('Save','testimonial-basics') ?>" class="button-highlighted" />
		</form>
		<h3><?php _e('Enter or update a testimonial (*Required)','testimonial-basics'); ?></h3>
		<form class="katb_admin_form" method="POST" action="">
			<?php wp_nonce_field("katb_nonce_3","katb_admin_form_nonce"); ?>
			<label class="katb_admin_id"><?php _e('ID : ','testimonial-basics'); ?></label><input size="5" maxlength="5" readonly="readonly" name="tb_id" value="<?php echo $katb_id; ?>" />
			<label><?php _e('Order : ','testimonial-basics'); ?></label><input size="5" maxlength="5" name="tb_order" value="<?php echo $katb_order ?>" />
			<label><?php _e('Approved : ','testimonial-basics'); ?></label><input type="checkbox" name="tb_approved" value="1"<?php if($katb_approved == 1) {echo ' checked="checked"';} ?> />
			<br/>
			<label class="katb_admin_author"><?php _e('Author *: ','testimonial-basics'); ?></label><input  maxlength="50" size="40" name="tb_author" value="<?php echo stripcslashes($katb_author); ?>" />
			<label class="katb_admin_url"><?php _e('Website : ','testimonial-basics'); ?></label><input  maxlength="50" size="40" name="tb_website" value="<?php echo $katb_website; ?>" />
			<br/>
			<label class="katb_admin_location"><?php _e('Location : ','testimonial-basics'); ?></label><input  maxlength="50" size="40" name="tb_location" value="<?php echo stripcslashes($katb_location); ?>" />
			<label class="katb_admin_date"><?php _e('Date (YYYY-MM-DD): ','testimonial-basics'); ?></label><input  maxlength="12" size="10" name="tb_date" value="<?php echo $katb_date; ?>" />
			<label class="katb_admin_time"><?php _e('Time (HH:MM:SS): ','testimonial-basics'); ?></label><input  maxlength="10" size="10" name="tb_time" value="<?php echo $katb_time; ?>" />
			<br/>
			<label class="katb_admin_test"><?php _e('Testimonial *: ','testimonial-basics'); ?></label>

			<textarea cols="125" rows="5" name="tb_testimonial" /><?php echo stripcslashes($katb_testimonial); ?></textarea>
			<br/>
			<input type="submit" name="submitted" value="<?php _e('Save Testimonial','testimonial-basics') ?>" class="button-primary" />
			<input type="submit" name="reset" value="<?php _e('Reset','testimonial-basics') ?>" class="button-secondary" />
			<input type="submit" name="delete" value="<?php _e('Delete','testimonial-basics') ?>" class="button-highlighted" />
		</form>
		<h3>Testimonials</h3>
		<?php
			$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` WHERE `tb_id` ",ARRAY_A);
			$katb_tnumber = $wpdb->num_rows;
		?>
		<table class="widefat">
			<thead>
				<tr>
					<th><?php _e('ID','testimonial-basics'); ?></th>
					<th><?php _e('Order','testimonial-basics'); ?></th>
					<th><?php _e('Appr','testimonial-basics'); ?></th>
					<th><?php _e('Timestamp','testimonial-basics'); ?></th>
					<th><?php _e('Author','testimonial-basics'); ?></th>
					<th><?php _e('Location','testimonial-basics'); ?></th>
					<th><?php _e('Website','testimonial-basics'); ?></th>
					<th><?php _e('Testimonial','testimonial-basics'); ?></th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th><?php _e('ID','testimonial-basics'); ?></th>
					<th><?php _e('Order','testimonial-basics'); ?></th>
					<th><?php _e('Appr','testimonial-basics'); ?></th>
					<th><?php _e('Timestamp','testimonial-basics'); ?></th>
					<th><?php _e('Author','testimonial-basics'); ?></th>
					<th><?php _e('Location','testimonial-basics'); ?></th>
					<th><?php _e('Website','testimonial-basics'); ?></th>
					<th><?php _e('Testimonial','testimonial-basics'); ?></th>
				</tr>
			</tfoot>
			<tbody>
				<?php
					for ( $i = 0 ; $i < $katb_tnumber; $i++ ) {
						echo '<tr>';
						echo '<td>';echo '<form method="POST" action="#"><input type="submit" name="edit" value="'.$katb_tdata[$i]['tb_id'].'" class="button-secondary" /></form>';echo'</td>';
						echo '<td>';if( $katb_tdata[$i]['tb_order'] == 0 ){ echo ""; }else{ echo $katb_tdata[$i]['tb_order']; };echo'</td>';
						echo '<td>';if($katb_tdata[$i]['tb_approved']==1){echo "Y";}else{echo "N";};echo'</td>';
						echo '<td>';echo $katb_tdata[$i]['tb_date'];echo'</td>';
						echo '<td>';echo stripcslashes($katb_tdata[$i]['tb_name']);echo'</td>';
						echo '<td>';echo stripcslashes($katb_tdata[$i]['tb_location']);echo'</td>';
						echo '<td>';echo $katb_tdata[$i]['tb_url'];echo'</td>';
						echo '<td>';echo stripcslashes($katb_tdata[$i]['tb_testimonial']);echo'</td>';
						echo '</tr>';
					}
				?>
			</tbody>
		</table>
	</div>
<?php } 
//add context sensitive help
function katb_testimonial_basics_admin_page_help( $contextual_help, $screen_id, $screen ){
	global $katb_testimonial_basics_admin_help;
	$contextual_help = '';	
	if ( $screen_id == $katb_testimonial_basics_admin_help ) {
		
		$contextual_help .= '<h4>Testimonial Basics - '.__('Adding And Editing Testimonials','testimonial-basics').'</h4>';
		$contextual_help .= '<ul><li>'.__('Include a captcha in the input by selecting the "Use Captcha on Input Form" checkbox','testimonial-basics').'</li>';
		$contextual_help .= '<li>'.__('To add a testimonial simply enter the data and click the "Save Testimonial" button','testimonial-basics').'</li>';
		$contextual_help .= '<li>'.__('To edit a testimonial click the ID button for the testimonial you want to edit, make your changes and "Save Testimonial"','testimonial-basics').'</li></ul>';
		$contextual_help .= '<h4>Testimonial Basics - '.__('How to Display Testimonials','testimonial-basics').'</h4>';
		$contextual_help .= '<ul><li>'.__('To display testimonials, add','testimonial-basics').'<code>[katb_testimonial by="date" number="5" id=""]</code>'.__(' to your page content : ','testimonial-basics').'</li>';
		$contextual_help .= '<li>'.__('Options for ','testimonial-basics').' "by" : "order" - '.__('display highest to lowest','testimonial-basics').',"date"- '.__('display most recent first','testimonial-basics').'</li>';
		$contextual_help .= '<li>'.__('Options for ','testimonial-basics').' "number" : "all" - '.__('displays all testimonials, or put in the number of testimonials you want to display','testimonial-basics').'</li>';
		$contextual_help .= '<li>'.__('Options for ','testimonial-basics').' "id" : "" - '.__('leave blank for multiple testimonials','testimonial-basics').', "ID" - '.__('put in testimonial','testimonial-basics').' ID, "random" - '.__('picks a random testimonial','testimonial-basics').'</li>';
		$contextual_help .= '<li>'.__('Only approved testimonials are displayed','testimonial-basics').'</li></ul>';
		$contextual_help .= '<h4>Testimonial Basics - '.__('Display Widget','testimonial-basics').'</h4>';
		$contextual_help .= '<ul><li>'.__('Drag the widget to a widgetized area and input ','testimonial-basics').'"random" - '.__('displays a random testimonial or','testimonial-basics').' "id" - '.__('number to display a selected testimonial','testimonial-basics').'</li></ul>';
		$contextual_help .= '<h4>Testimonial Basics - '.__('Input Form','testimonial-basics').'</h4>';
		$contextual_help .= '<ul><li>'.__('To display an input form, add ','testimonial-basics').'<code>&#60;!-- katb_input_form --&#62;</code>'.__('to your page content','testimonial-basics').'</li>';
		$contextual_help .= '<li>'.__('An email is sent to all admin users that a testimonial has been submitted. The user can then log in, edit and/or approve the testimonial.','testimonial-basics').'</li></ul>';
		$contextual_help .= '<h4>Testimonial Basics - '.__('Input Form Widget','testimonial-basics').'</h4>';
		$contextual_help .= '<ul><li>'.__('Drag the widget to a widgetized area and the user can enter testimonial through this widgetized form.','testimonial-basics').'</li></ul>';
		$contextual_help .= '<h4>Testimonial Basics - '.__('Detailed User Documentation','testimonial-basics').'</h4>';
		$contextual_help .= '<ul><li>'.__('Detailed user documentation including changing background colors are included in the html file located in','testimonial-basics').' <em>testimonial-basics/docs</em>.</li></ul>';
	}
	return $contextual_help;
}

add_filter ('contextual_help','katb_testimonial_basics_admin_page_help',10,3);
