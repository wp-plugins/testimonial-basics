<?php
/**
 * This is the admin file for Testimonial Basics
 *
 * @package		Testimonial Basics WordPress Plugin
 * @copyright	Copyright (c) 2012, Kevin Archibald
 * @license		http://www.gnu.org/licenses/quick-guide-gplv3.html  GNU Public License
 * @author		Kevin Archibald <www.kevinsspace.ca/contact/>
 */
/** -------- Admin Style  katb_testimonial_basics_admin.css	  --------------------------
 * This function loads the admin stylesheet and scripts for Testimonial 
 * Basics admin pages. The styles and scripts are only loaded if a 
 * Testimonial Basics admin page is loaded.
 * file:katb_testimonial_basics_admin.css is in /css and is usde to style the admin pages
 * file:katb_testimonial_basics_doc_ready.js is located in /js and contains scripts for 
 * display in the admin pages, and to display set up the color wheel useage
 * farbtastic/wp-color-picker :  are jquery scripts for selectig colors
 * --------------------------------------------------------------------------------------- */ 
function katb_testimonial_basic_admin_style($hook) {
	//wp_die($hook);
	//Only enqueue if the admin page is loaded  
	if( 'testimonials_page_katb-settings' != $hook  
		&& 'toplevel_page_katb_testimonial_basics_admin' != $hook 
		&& 'testimonials_page_katb_testimonial_basics_admin_edit'!= $hook) return;
	//Page is loaded so go ahead
	global $wp_version;

	wp_register_style( 'testimonial_basic_admin_style',plugins_url() . '/testimonial-basics/css/katb_testimonial_basics_admin.css',array(),'20120815','all' ); 
	wp_enqueue_style( 'testimonial_basic_admin_style' );

	//load the color picker
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'wp-color-picker' );
		
    //Load our custom javascript file
 	wp_enqueue_script( 'testimonial_basics_options_js', plugins_url() . '/testimonial-basics/js/katb_testimonial_basics_doc_ready.js', array('jquery'), '1', true );
	//setup for media uploader
	wp_enqueue_script('thickbox');  
    wp_enqueue_style('thickbox');  
    wp_enqueue_script('media-upload'); 
}
add_action('admin_enqueue_scripts', 'katb_testimonial_basic_admin_style');

function katb_testimonial_basics_create_menu() {
	
	/** add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
	 * $icon_url - (string) (optional) The url to the icon to be used for this menu. NOT USED
	 * $position - (integer) (optional) The position in the menu order this menu should appear. NOT USED
	 */
	add_menu_page( 
		'Testimonial Basics',					// $page_title - (string) (required) The text to be displayed in the title tags of the page when the menu is selected Default: None 	
		'Testimonials',							// $menu_title - string) (required) The on-screen name text for the menu Default: None
		'manage_options',						// $capability - (string) (required) The capability required for this menu to be displayed to the user. User levels are deprecated and should not be used here! Default: None
		'katb_testimonial_basics_admin',		// $menu_slug - (string) (required) The slug name to refer to this menu by (should be unique for this menu).
		'katb_testimonial_basics_introduction'	// The function that displays the page content for the menu page.
		);
		
	/**
	 * Get user options for the level that will be allowed to edit testimonials
	 */
	$katb_options = katb_get_options();
	if($katb_options['katb_admin_access_level'] == 'Editor') {
		$edit_testimonial_capability = 'moderate_comments';
	} else {
		$edit_testimonial_capability = 'manage_options';
	}
	
	global $katb_edit_testimonials_page, $katb_plugin_options_page;
	
	$katb_plugin_options_page = add_submenu_page(								// add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function );
										'katb_testimonial_basics_admin',		// $parent_slug - (string) (required) The slug name for the parent menu (or the file name of a 
																				// standard WordPress admin page).
										'Testimonial Basics Options',			// $page_title - (string) (required) The text to be displayed in the title tags of the page when 
																				// the menu is selected 
										'Options',								// $menu_title - (string) (required) The text to be used for the menu 
										'manage_options',						// $capability - (string) (required) The capability required for this menu to be displayed to the user.
										'katb-settings',						// $menu_slug - (string) (required) The slug name to refer to this menu by (should be unique for 
																				// this menu). If you want to NOT duplicate the parent menu item, you need to set the name of the 
																				// $menu_slug exactly the same as the parent slug.
										'katb_testimonial_basics_options_page'	// $function - (string / array) (optional) The function to be called to output the content for this page.
										);
	add_action( 'load-' . $katb_plugin_options_page , 'katb_plugin_options_contextual_help' );
	
	$katb_edit_testimonials_page = add_submenu_page(							// add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function );
										'katb_testimonial_basics_admin',		// $parent_slug - (string) (required) The slug name for the parent menu (or the file name of a 
																				// standard WordPress admin page).
										'Testimonial Basics Edit Testimonials',	// $page_title - (string) (required) The text to be displayed in the title tags of the page when 
																				// the menu is selected 
										'Edit Testimonials',					// $menu_title - (string) (required) The text to be used for the menu 
										$edit_testimonial_capability,			// $capability - (string) (required) The capability required for this menu to be displayed to the user.
										'katb_testimonial_basics_admin_edit',	// $menu_slug - (string) (required) The slug name to refer to this menu by (should be unique for 
																				// this menu). If you want to NOT duplicate the parent menu item, you need to set the name of the 
																				// $menu_slug exactly the same as the parent slug. 
										'katb_testimonial_basics_edit_page'		// $function - (string / array) (optional) The function to be called to output the content for this page.
										);
	add_action( 'load-' . $katb_edit_testimonials_page, 'katb_edit_testimonials_contextual_help' );	
}
add_action( 'admin_menu', 'katb_testimonial_basics_create_menu' );

/** ----------------- katb_testimonial_basics_introduction -------------------------
 * Called by add_menu_page. Sets up the Testimonial Basics Introduction Page
 * 
 * @uses katb_intro_html()
 * 
 * ---------------------------------------------------------------------------------- */
function katb_testimonial_basics_introduction (){ 
	screen_icon( 'plugins' ); 
	?><h1>Testimonial Basics Basic Instructions</h1><?php
	echo katb_intro_html(); ?>
	
	<h3><?php _e('Introduction','testimonial-basics'); ?></h3>

	<p><?php _e('Testimonial Basics facilitates easy management of customer testimonials.','testimonial-basics'); ?> <br/>
	   <?php _e('The user can set up an input form in a page or in a widget, and display all or selected testimonials in a page or a widget.','testimonial-basics'); ?></p>

	<p><?php _e('If you like the program show your appreciation, buy me a coffee, beer, or a bottle of wine (red please!).','testimonial-basics'); ?><br/>
		<?php _e('Or just head to the website link above and put in a testimonial, or send me an e-mail, pats on the back are pretty nice too!','testimonial-basics'); ?></p>

	<p><?php _e('I plan to do updates if required, so also contact me if you find any problems, or have suggestions for improvements.','testimonial-basics'); ?></p>

	<p><?php _e('I briefly discuss the use of the plugin below. For detailed documentation, visit the plugin site.','testimonial-basics'); ?></p>

	<p><?php _e('I hope you enjoy Testimonial Basics!','testimonial-basics'); ?></p>

	<h3><?php _e("Visitor Input Form",'testimonial-basics'); ?></h3>
	<p><?php _e('You can set up a visitor input form very easily.','testimonial-basics'); echo ' ';
			_e('Simply include in your page content:','testimonial-basics'); echo ' '; ?>
			<br/><code>[katb_input_testimonials group="All"]</code><br/>
			<ol>
				<li><?php _e('IMPORTANT : Make sure you set up the page using the "Text" editor and not the "Visual" editor.','testimonial-basics'); ?></li>
				<li><?php _e('Group - This will be the group name for the testimonial, default is "All"','testimonial-basics'); ?></li>
			</ol>
			
	</p>

	<h3><?php _e('Visitor Input Widget','testimonial-basics'); ?></h3>
	<p><?php _e('You can also use a widget as a user input form.','testimonial-basics'); echo ' ';
			_e('Go to "Appearance" => "Widgets" and drag the widget to the widgetized area.','testimonial-basics'); ?></p>

	<h3><?php _e('Displaying Testimonials','testimonial-basics'); ?></h3>
	<p><?php _e('You can display testimonials in the content of a page using shortcodes or you can use widgets to display testimonials.','testimonial-basics'); ?></p>
			
	<h4><?php _e('Using a Shortcode','testimonial-basics'); ?></h4>
	
	<p><?php _e('To display testimonials create a new page and enter the following shortcode :','testimonial-basics'); echo ' '; ?><br/>
		
	<code>[katb_testimonial group="all" number="all" by="random"  id="" rotate="no"]</code></p>

		<ol>
			<li><?php _e('Options for','testimonial-basics'); echo ' "group" : "all" - ';_e('ignores groups','testimonial-basics');echo ', "group_name"- ';_e('display only this grouping','testimonial-basics'); ?></li>
			<li><?php _e('Options for','testimonial-basics'); echo ' "number" : "all" - ';_e('displays all testimonials, or put in the number of testimonials you want to display','testimonial-basics'); ?></li>
			<li><?php _e('Options for','testimonial-basics'); echo ' "by" : "random" - ';_e('display randomly','testimonial-basics');echo ', "order" - ';_e('display by order number, lowest to highest','testimonial-basics');echo ', "date"- ';_e('display most recent first','testimonial-basics'); ?></li>
			<li><?php _e('Options for','testimonial-basics'); echo' "id" : "" - ';_e('leave blank for multiple testimonials','testimonial-basics');echo ', "ID" - ';_e('put in testimonial ID','testimonial-basics'); ?></li>
			<li><?php _e('Options for','testimonial-basics'); echo' "rotate" : "no" - ';_e('display all selected testimonials','testimonial-basics');echo ', "yes" - ';_e('rotate each testimonial','testimonial-basics'); ?></li>
		</ol>

	<p><strong>Tips</strong></p>
	
	<ul>
		<li><?php _e('* Note that if id is not blank ( id="" ), the "group", "by" and "number" attributes are ignored.','testimonial-basics'); ?></li>
		<li><?php _e('* You must have more then 2 testimonials to rotate them.','testimonial-basics'); ?></li>
		<li><?php _e('* Use pagination to display a lot of testimonials.','testimonial-basics'); ?></li>
		<li><?php _e('* Pagination can be used to display all testimonials or all testimonials in a group.','testimonial-basics') ?></li>
		<li><?php _e('* Do not select rotate="yes" more than 5 times in a page content area','testimonial-basics') ?></li>
		<li><?php _e('* IMPORTANT : Make sure you set up the page using the "Text" editor and not the "Visual" editor.','testimonial-basics'); ?></li>
	</ul>
	
	<h4><?php _e('Using a Widget','testimonial-basics'); ?></h4>
	
	<p><?php _e('You can also use a widget to display a testimonial.','testimonial-basics'); ?>
		
		<ol>
			<li><?php _e('Drag the widget to a widetized area and enter a title','testimonial-basics'); ?></li>
			<li><?php _e('The options for display are the same as in the shortcode explained above','testimonial-basics'); ?></li>
			<li><?php _e('Save the settings','testimonial-basics'); ?></li>			
		</ol>	
		
	<p><strong>Tips</strong></p>
	
	<ul>
		<li><?php _e('* The fewer the testimonials the lower the load time','testimonial-basics'); ?></li>
		<li><?php _e('* Rotate a maximum of 10 testimonials','testimonial-basics'); ?></li>
		<li><?php _e('* You can not use more than 5 rotating widgets on a page','testimonial-basics'); ?></li>
		<li><?php _e('* If you are not rotating testimonials keep the number below 3','testimonial-basics'); ?></li>
	</ul>
	
<?php }

/** ----------------- katb_testimonial_basics_options_page -------------------------
 * Called by add_submenu_page. Sets up the Testimonial basics Option Page
 * 
 * @uses katb_get_current_tab()
 * @uses katb_get_page_tab_markup()
 * 
 * ---------------------------------------------------------------------------------- */
function katb_testimonial_basics_options_page (){
	
	//echo katb_intro_html();
	
	// Determine the current page tab
	$currenttab = katb_get_current_tab();
	// Define the page section accordingly
	$settings_section = 'katb_' . $currenttab . '_tab';
	?>
	
	<div class="wrap katb_options_<?php echo $currenttab; ?>">
		
		<?php katb_get_page_tab_markup(); ?>
		
		<form class="katb_options" action="options.php" method="post">
			
			<?php 
				
				//color picker div
				if( $currenttab == 'content_display' || $currenttab == 'widget_display' ) echo '<div id="katb_picker"></div>';
			 	
				// Implement settings field security, nonces, etc.
				settings_fields('katb_testimonial_basics_options'); 
				
				// Output each settings section, and each settings field in each section
				do_settings_sections($settings_section);
				
			?>
			
			<?php submit_button( __( 'Save Options', 'testimonial-basics' ), 'primary', 'katb_testimonial_basics_options[submit-' . $currenttab . ']', false ); ?>
			<?php submit_button( __( 'Reset Options', 'testimonial-basics' ), 'secondary', 'katb_testimonial_basics_options[reset-' . $currenttab . ']', false ); ?>
			
		</form>
	</div>
<?php }

/**
 * This function registers and defines settings for the Testimonial Basics admin panel
 * 
 * @uses katb_get_settings_page_tabs() found in this file
 * @uses katb_get_option_parameters() found in /includes/katb_functions.php
 */
function katb_testimonial_basics_admin_init (){//Register and define settings
	/**
	 * Register Plugin Settings
	 * 
	 * Register katb_testimonial_basics_options array to hold
	 * all Theme options.
	 * 
	 * @link	http://codex.wordpress.org/Function_Reference/register_setting	Codex Reference: register_setting()
	 * 
	 * @param	string		$option_group		Unique Settings API identifier; passed to settings_fields() call
	 * @param	string		$option_name		Name of the wp_options database table entry
	 * @param	callback	$sanitize_callback	Name of the callback function in which user input data are sanitized
	 * 
	 */
	register_setting('katb_testimonial_basics_options','katb_testimonial_basics_options','katb_validate_options');
	
	/**
	 * Globalize the variable that holds 
	 * the Settings Page tab definitions
	 * 
	 * @global	array	Settings Page Tab definitions
	 */
	global $katb_tabs;
	$katb_tabs = katb_get_settings_page_tabs();
	
	/**
	 * Call add_settings_section() for each Settings 
	 * 
	 * Loop through each Theme Settings page tab, and add 
	 * a new section to the Theme Settings page for each 
	 * section specified for each tab.
	 * 
	 * @link	http://codex.wordpress.org/Function_Reference/add_settings_section	Codex Reference: add_settings_section()
	 * 
	 * @param	string		$sectionid	Unique Settings API identifier; passed to add_settings_field() call
	 * @param	string		$title		Title of the Settings page section
	 * @param	callback	$callback	Name of the callback function in which section text is output
	 * @param	string		$pageid		Name of the Settings page to which to add the section; passed to do_settings_sections()
	 */
	foreach ( $katb_tabs as $tab ) {
		$tabname = $tab['name'];
		$tabsections = $tab['sections'];
		foreach ( $tabsections as $section ) {
			$sectionname = $section['name'];
			$sectiontitle = $section['title'];
			// Add settings section
			add_settings_section(
				// $sectionid
				'katb_' . $sectionname . '_section',
				// $title
				$sectiontitle,
				// $callback
				'katb_sections_callback',
				// $pageid
				'katb_' . $tabname . '_tab'
			);
		}
	}

	/**
	 * Globalize the variable that holds 
	 * all the Theme option parameters
	 * 
	 * @global	array	Theme options parameters
	 */
	global $katb_option_parameters;
	$katb_option_parameters = katb_get_option_parameters();
	
	/**
	 * Call add_settings_field() for each Setting Field
	 * 
	 * Loop through each Theme option, and add a new 
	 * setting field to the Theme Settings page for each 
	 * setting.
	 * 
	 * @link	http://codex.wordpress.org/Function_Reference/add_settings_field	Codex Reference: add_settings_field()
	 * 
	 * @param	string		$settingid	Unique Settings API identifier; passed to the callback function
	 * @param	string		$title		Title of the setting field
	 * @param	callback	$callback	Name of the callback function in which setting field markup is output
	 * @param	string		$pageid		Name of the Settings page to which to add the setting field; passed from add_settings_section()
	 * @param	string		$sectionid	ID of the Settings page section to which to add the setting field; passed from add_settings_section()
	 * @param	array		$args		Array of arguments to pass to the callback function
	 */
	foreach ( $katb_option_parameters as $option ) {
		
		$optionname = $option['name'];
		$optiontitle = $option['title'];
		$optiontab = $option['tab'];
		$optionsection = $option['section'];
		$optiontype = $option['type'];
	
		add_settings_field(
			// $settingid
			'katb_setting_' . $optionname,
			// $title
			$optiontitle,
			// $callback
			'katb_setting_callback',
			// $pageid
			'katb_' . $optiontab . '_tab',
			// $sectionid
			'katb_' . $optionsection . '_section',
			// $args
			$option
		);

	}

}

add_action('admin_init','katb_testimonial_basics_admin_init');

/**
 * Define katb Options Page Tab Markup
 * 
 * @uses	katb_get_current_tab()	defined in this file
 * @uses	katb_get_settings_page_tabs()	defined in this file
 * @uses	katb_intro_html() defined in this file
 * 
 * @link	http://www.onedesigns.com/tutorials/separate-multiple-theme-options-pages-using-tabs	Daniel Tara
 */
function katb_get_page_tab_markup() {
	
	$page = 'katb-settings';

    $current = katb_get_current_tab();
	
	$tabs = katb_get_settings_page_tabs();
    
    $links = array();
    
    foreach( $tabs as $tab ) {
		$tabname = $tab['name'];
		$tabtitle = $tab['title'];
        if ( $tabname == $current ) {
            $links[] = "<a class='nav-tab nav-tab-active' href='?page=$page&tab=$tabname'>$tabtitle</a>";
        } else {
            $links[] = "<a class='nav-tab' href='?page=$page&tab=$tabname'>$tabtitle</a>";
        }
    }
    screen_icon( 'plugins' );
	echo '<h1 style="float: left;margin: 20px 0 0 0;">Testimonial Basics Options </h1>';
	echo '<div style="clear: both;"></div>';
	katb_intro_html();

    echo '<h4 style="clear:both;float:left; margin: 10px 0 0 0;" class="nav-tab-wrapper">';
    foreach ( $links as $link )
        echo $link;
    echo '</h4>';
    echo '<div style="clear:both;"></div>';
}

/**
 * Callback for add_settings_section()
 * 
 * Generic callback to output the section text
 * for each Plugin settings section. 
 * 
 * @uses	katb_get_settings_page_tabs() found in this file
 * 
 * @param	array	$section_passed	Array passed from add_settings_section()
 */
function katb_sections_callback( $section_passed ) {
	global $katb_tabs;
	$katb_tabs = katb_get_settings_page_tabs();
	foreach ( $katb_tabs as $tabname => $tab ) {
		$tabsections = $tab['sections'];
		foreach ( $tabsections as $sectionname => $section ) {
			if ( 'katb_' . $sectionname . '_section' == $section_passed['id'] ) {
				?>
				<p><?php echo $section['description']; ?></p>
				<?php
			}
		}
	}
}

/**
 * Callback function is used to set up the html for the options page
 * 
 * @param $option is the array with the option names for that particular option
 * 
 * @uses katb_get_options()
 * @uses katb_get_option_parameters()
 * 
 */
function katb_setting_callback( $option ) { //Callback for get_settings_field()
	$katb_options = katb_get_options();
	$option_parameters = katb_get_option_parameters();
	$optionname = $option['name'];
	$optiontitle = $option['title'];
	$optiondescription = $option['description'];
	$fieldtype = $option['type'];
	$fieldname = 'katb_testimonial_basics_options[' . $optionname . ']';
	$katb_input_class = $option['class'];
	
	// Output checkbox form field markup
	if ( 'checkbox' == $fieldtype ) {
		?>
		<input class="katb_options <?php echo $katb_input_class ?>"  type="checkbox" name="<?php echo $fieldname; ?>" <?php checked( $katb_options[$optionname] ); ?> />
		<?php
	}
	// Output radio button form field markup
	else if ( 'radio' == $fieldtype ) {
		$valid_options = array();
		$valid_options = $option['valid_options'];
		foreach ( $valid_options as $valid_option ) {
			?>
			<input class="katb_options <?php echo $katb_input_class ?>" type="radio" name="<?php echo $fieldname; ?>" <?php checked( $valid_option['name'] == $katb_options[$optionname] ); ?> value="<?php echo $valid_option['name']; ?>" />
			<span>
			<?php echo $valid_option['title']; ?>
			<?php if ( $valid_option['description'] ) { ?>
				<span style="padding-left:5px;"><em><?php echo $valid_option['description']; ?></em></span>
			<?php } ?>
			</span>
			<br />
			<?php
		}
	}
	// Output select form field markup
	else if ( 'select' == $fieldtype ) {
		$valid_options = array();
		$valid_options = $option['valid_options'];
		?>
		<select class="katb_options <?php echo $katb_input_class ?>" name="<?php echo $fieldname; ?>">
		<?php 
		foreach ( $valid_options as $valid_option ) {
			?>
			<option <?php selected( $valid_option == $katb_options[$optionname] ); ?> value="<?php echo $valid_option; ?>"><?php echo $valid_option; ?></option>
			<?php
		}
		?>
		</select>
		<?php 
	} 
	// Output text input form field markup
	else if ( 'text' == $fieldtype ) {
		if ($katb_input_class == 'html') { ?>
			<input id="<?php echo $optionname; ?>" class="katb_options <?php echo $katb_input_class ?>" type="text" name="<?php echo $fieldname; ?>" value="<?php echo stripcslashes( esc_html( $katb_options[$optionname] ) ); ?>" />
		<?php } else { ?>	
			<input id="<?php echo $optionname; ?>" class="katb_options <?php echo $katb_input_class ?>" type="text" name="<?php echo $fieldname; ?>" value="<?php echo stripcslashes( wp_filter_nohtml_kses( $katb_options[$optionname] ) ); ?>" />
		<?php }
	}
	// Output textarea input form field markup
	else if ( 'textarea' == $fieldtype ) { ?>
		<textarea class="katb_options <?php echo $katb_input_class ?>" type='textarea' name="<?php echo $fieldname; ?>" rows='5' cols='41'><?php echo stripcslashes( wp_kses_post( $katb_options[$optionname] ) ); ?></textarea>
	<?php } ?>
	 
		<span class="description"><?php echo esc_attr( stripcslashes( $optiondescription ) ); ?></span>
		
	<?php }
	

/** ---------------- katb_testimonial_basics_edit_page -----------------------------
 * called from the add_submenu_page
 * This is the edit testimonials section that displays all the testimonials and 
 * allows the user to add, edit,delete, and approve testimonials
 * 
 * @uses katb_get_options() found in /includes/katb_functions.php
 * @uses katb_intro_html(); found in this file
 * @uses katb_offset_setup found in /includes/katb_functions.php
 * @uses katb_setup_pagination() found in /includes/katb_functions.php
 * @uses katb_display_pagination() found in /includes/katb_functions.php
 * @uses 
 * 
 * 
 */
function katb_testimonial_basics_edit_page(){
	global $wpdb,$tablename;
	$tablename = $wpdb->prefix.'testimonial_basics';
	
	//get user options
	$katb_options = katb_get_options();
	$use_ratings = $katb_options[ 'katb_use_ratings' ];
	
	//setup pagination
	$katb_admin_offset_name = home_url().'katb_admin_offset';
	$katb_items_per_page = 10;

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
		
		//group validation
		$katb_group = sanitize_text_field(trim($_POST['tb_group']));
		
		//author validation
		$katb_author = sanitize_text_field(trim($_POST['tb_author']));
		if ($katb_author == "") {
			$error .= '*'.__('Author is required','testimonial-basics').'*';
		}

		//website validation
		$katb_website = trim($_POST['tb_website']);
		if ( $katb_website != '' ) $katb_website = esc_url($_POST['tb_website']);
		if ( $katb_website == 'http://' ) $katb_website = '';
		
		//location validation
		$katb_location = sanitize_text_field(trim($_POST['tb_location']));
		
		//email validation
		$katb_email = sanitize_email(trim($_POST['tb_email']));
		if(!is_email($katb_email) && $katb_email != '') {
			$error .= '*'.__('Valid email is required','testimonial-basics').'*';
		}
		//Date Validation
		$katb_date = trim($_POST['tb_date']);
		if ($katb_date != "") {
			$year = intval(substr($katb_date,0,4));
			$month = intval(substr($katb_date,5,2));
			$day = intval(substr($katb_date,8,2));
			if( !checkdate( $month, $day, $year ) ){
				$error .= '*'.__('Date must be','testimonial-basics').' YYYY-MM-DD*';
			}
		}
		
		//time validation
		$katb_time = trim($_POST['tb_time']);
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
		
		//Rating Validation
		$katb_rating = sanitize_text_field( trim( $_POST[ 'tb_rating' ] ) );
		
		//photo validation
		$katb_picture_url = trim($_POST['tb_upload_image']);
		if ( $katb_picture_url != '' ) $katb_picture_url = esc_url($katb_picture_url);
		if ( $katb_picture_url == 'http://' ) $katb_picture_url = '';
		
		//Sanitize testimonial - same html allowed as allowed in posts
		$katb_testimonial = wp_kses_post( $_POST['tb_testimonial'] );
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
				'tb_group' => $katb_group,
				'tb_name' => $katb_author,
				'tb_email' => $katb_email,
				'tb_location' => $katb_location,
				'tb_url' => $katb_website,
				'tb_pic_url' => $katb_picture_url,
				'tb_rating' => $katb_rating,
				'tb_testimonial' => $katb_testimonial
			);
			$formats_values = array('%s','%d','%d','%s','%s','%s','%s','%s','%s','%s','%s');
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
	} else {
		$katb_id = "";
		$katb_order = "";
		$katb_approved = "";
		$katb_group = "";
		$katb_date = "";
		$katb_time = "";
		$katb_author = "";
		$katb_email = "";
		$katb_website = "";
		$katb_location = "";
		$katb_rating = "";
		$katb_picture_url = "";
		$katb_testimonial = "";
	}
	
	/* ---------- Reset button is clicked ---------------- */
	if(isset($_POST['reset'])) {
		$katb_id = "";
		$katb_order = "";
		$katb_approved = "";
		$katb_group = "";
		$katb_date = "";
		$katb_time = "";
		$katb_author = "";
		$katb_email = "";
		$katb_website = "";
		$katb_location = "";
		$katb_rating = "";
		$katb_picture_url = "";
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
		$katb_group = "";
		$katb_date = "";
		$katb_time = "";
		$katb_author = "";
		$katb_email = "";
		$katb_website = "";
		$katb_location = "";
		$katb_rating = "";
		$katb_picture_url = "";
		$katb_testimonial = "";
		echo '<div id="message" class="updated">'.__('Testimonial was deleted.','testimonial-basics').'</div>';
	}
	
	/* ----------- select an id to edit ----------------- */
	if(isset($_POST['edit'])){
		$katb_id = $_POST['edit'];
		$edit_data = $wpdb->get_row("SELECT * FROM `$tablename` WHERE `tb_id` = $katb_id ",ARRAY_A );
		$katb_order = $edit_data['tb_order'];
		$katb_group = $edit_data['tb_group'];
		$katb_author = $edit_data['tb_name'];
		$katb_email = $edit_data['tb_email'];
		$katb_website = $edit_data['tb_url'];
		$katb_location = $edit_data['tb_location'];
		$katb_testimonial = $edit_data['tb_testimonial'];
		$katb_approved = $edit_data['tb_approved'];
		$katb_date = substr($edit_data['tb_date'],0,10);
		$katb_time = substr($edit_data['tb_date'],11,8);
		$katb_rating = $edit_data['tb_rating'];
		$katb_picture_url = $edit_data['tb_pic_url'];
	}
	
	/* ------- set up pagination ----------- */
	if( isset ( $_POST['ka_paginate_post'] ) ) {
		//Get total entries
		$results = $wpdb->get_results( " SELECT COUNT(1) FROM `$tablename` ",ARRAY_A);
		$total_entries = $results[0]['COUNT(1)'];
		
		$ka_paginate_action = $_POST['ka_paginate_post'];
		katb_offset_setup ( $katb_admin_offset_name, $katb_items_per_page, $ka_paginate_action, $total_entries );
	}
?>
	<div class="wrap">
		
		<?php 
			screen_icon( 'plugins' ); 
			?><h2>Testimonial Basics Edit and Approve Testimonials</h2><?php
			katb_intro_html(); 
		?>
		
		<p><?php _e('Click the Help button for instructions or see the testimonial_basics_docs.html file included in the plugin docs folder.','testimonial-basics'); ?></p>
		<h3><?php _e('Enter or update a testimonial (*Required)','testimonial-basics'); ?></h3>
		<form class="katb_admin_form" method="POST" action="#">
			
			<?php wp_nonce_field("katb_nonce_3","katb_admin_form_nonce"); ?>
			
			<span class="ka_edit_column_1">
				
				<label class="katb_edit_id_label"><?php _e('ID : ','testimonial-basics'); ?></label>
				<input class="katb_edit_id_input" size="5" maxlength="5" readonly="readonly" name="tb_id" value="<?php echo $katb_id; ?>" />
				
				<label class="katb_edit_approved_label"><?php _e('Approved : ','testimonial-basics'); ?></label>
				<input class="katb_edit_approved_input" type="checkbox" name="tb_approved" value="1"<?php if($katb_approved == 1) {echo ' checked="checked"';} ?> />
				
				<label class="katb_edit_date_label"><?php _e('Date (YYYY-MM-DD): ','testimonial-basics'); ?></label>
				<input class="katb_edit_date_input" maxlength="12" size="30" name="tb_date" value="<?php echo $katb_date; ?>" />
				
				<label class="katb_edit_time_label"><?php _e('Time (HH:MM:SS): ','testimonial-basics'); ?></label>
				<input class="katb_edit_time_input" maxlength="10" size="30" name="tb_time" value="<?php echo $katb_time; ?>" />
				
				<label class="katb_edit_group_label"><?php _e('Group : ','testimonial-basics'); ?></label>
				<input class="katb_edit_group_input" maxlength="100" size="24" name="tb_group" value="<?php echo stripcslashes($katb_group); ?>" />
	
				<label class="katb_edit_order_label"><?php _e('Order : ','testimonial-basics'); ?></label>
				<input class="katb_edit_order_input" size="5" maxlength="5" name="tb_order" value="<?php echo $katb_order ?>" />
				
				<label class="katb_edit_rating_label"><?php _e('Review Rating : ','testimonial-basics'); ?></label>
				<select class="katb_edit_rating_input" name="tb_rating">
					<option <?php selected( $katb_rating ); ?> value="<?php echo $katb_rating; ?>"><?php echo $katb_rating; ?></option>
					<option value="0.0">0.0</option>
					<option value="0.5">0.5</option>
					<option value="1.0">1.0</option>
					<option value="1.5">1.5</option>
					<option value="2.0">2.0</option>
					<option value="2.5">2.5</option>
					<option value="3.0">3.0</option>
					<option value="3.5">3.5</option>
					<option value="4.0">4.0</option>
					<option value="4.5">4.5</option>
					<option value="5.0">5.0</option>
				</select>
			
			</span>
			
			<span class="ka_edit_column_2">
				
				<label class="katb_edit_pic_label"><?php _e('Gravatar/Photo : ','testimonial-basics'); ?></label>
				<?php if( $katb_picture_url == '' ) { ?>
					<span class="katb_edit_avatar"><?php echo get_avatar( $katb_email, $size = '60' ) ?></span>
				<?php } else { ?>
					<span class="katb_edit_pic"><img src="<?php echo $katb_picture_url; ?>" title="Uploaded_Author_Image" alt="Uploaded_Author_Image" /></span>
				<?php } ?>
				
				<input id="katb_upload_image" class="katb_picture_url" type="text" name="tb_upload_image" maxlength="100" value="<?php echo stripcslashes($katb_picture_url); ?>" />
				<br/><br/><br/>
				<input id="katb_upload_button" class="katb_upload_button" type="button" name="tb_photo_add" value="Upload Image" />		

				<label class="katb_edit_author_label"><?php _e('Author *: ','testimonial-basics'); ?></label>
				<input class="katb_edit_author_input" type="text" maxlength="100" name="tb_author" value="<?php echo stripcslashes($katb_author); ?>" />
				
				<label class="katb_edit_email_label"><?php _e('Email : ','testimonial-basics'); ?></label>
				<input class="katb_edit_email_input" type="text" maxlength="100" name="tb_email" value="<?php echo stripcslashes($katb_email); ?>" />
				
	
				<label class="katb_edit_url_label"><?php _e('Website : ','testimonial-basics'); ?></label>
				<input class="katb_edit_url_input" type="text" maxlength="100" name="tb_website" value="<?php echo $katb_website; ?>" />
				
				<label class="katb_edit_location_label"><?php _e('Location : ','testimonial-basics'); ?></label>
				<input class="katb_edit_location_input" type="text" maxlength="100" name="tb_location" value="<?php echo stripcslashes($katb_location); ?>" />
			
			</span>
			
			<label class="katb_edit_testimonial_label"><?php _e('Testimonial *: ','testimonial-basics'); ?></label>
			<textarea class="katb_edit_testimonial_input" cols="102" rows="5" name="tb_testimonial" ><?php echo stripcslashes($katb_testimonial); ?></textarea>
			<span class="html_allowed">HTML Allowed</span>
			<br/><br/><br/>
			<input type="submit" name="submitted" value="<?php _e('Save Testimonial','testimonial-basics') ?>" class="katb-primary button-primary" />
			<input type="submit" name="reset" value="<?php _e('Reset','testimonial-basics') ?>" class="katb-secondary button-secondary" />
			<input type="submit" name="delete" value="<?php _e('Delete','testimonial-basics') ?>" class="katb-highlighted button-highlighted" />
		</form>
		<h3 class="katb_admin_title">Testimonials</h3>
		<?php
		
			//Get total entries
			$results = $wpdb->get_results( " SELECT COUNT(1) FROM `$tablename` ",ARRAY_A);
			$total_entries = $results[0]['COUNT(1)'];
			
			//Pagination
			$katb_paginate_setup = katb_setup_pagination( $katb_admin_offset_name, $katb_items_per_page, $total_entries );
			$katb_admin_offset = $katb_paginate_setup['offset'];
			katb_display_pagination( $katb_paginate_setup );
			
			if ($katb_admin_offset < 0 ) $katb_admin_offset = 0;
			$katb_tdata = $wpdb->get_results( " SELECT * FROM `$tablename` ORDER BY `tb_date` DESC LIMIT $katb_items_per_page OFFSET $katb_admin_offset ",ARRAY_A);
			$katb_tnumber = $wpdb->num_rows;
		?>
		<table class="widefat">
			<thead>
				<tr>
					<th><?php _e('ID','testimonial-basics'); ?></th>
					<th><?php _e('General','testimonial-basics'); ?></th>
					<th><?php _e('Photo','testimonial-basics'); ?></th>
					<th><?php _e('Author Information','testimonial-basics'); ?></th>
					<th><?php _e('Testimonial','testimonial-basics'); ?></th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th><?php _e('ID','testimonial-basics'); ?></th>
					<th><?php _e('General','testimonial-basics'); ?></th>
					<th><?php _e('Photo','testimonial-basics'); ?></th>
					<th><?php _e('Author Information','testimonial-basics'); ?></th>
					<th><?php _e('Testimonial','testimonial-basics'); ?></th>
				</tr>
			</tfoot>
			<tbody>
				<?php
					for ( $i = 0 ; $i < $katb_tnumber; $i++ ) { ?>
						<tr>
							
							<td class="ka_table_id"><form method="POST" action="#"><input type="submit" name="edit" value="<?php echo $katb_tdata[$i]['tb_id']; ?>" class="button-secondary" /></form></td>
							
							<td class="ka_table_admin_column">
								<span class="ka_table_date"><strong><?php _e('Date: ','testimonial-basics'); ?></strong><?php echo substr( $katb_tdata[$i]['tb_date'] , 0 , 10 ); ?></span><br/>
								<span class="ka_table_time"><strong><?php _e('Time: ','testimonial-basics'); ?></strong><?php echo substr( $katb_tdata[$i]['tb_date'] , 11 , 8 ); ?></span><br/>
								<span class="ka_table_approved">
									<strong><?php _e('Approved: ','testimonial-basics'); ?>
									<?php if($katb_tdata[$i]['tb_approved'] == 1) :
										?><span style="color: green;">Y</span><?php
									else :
										?><span style="color: red;">N</span><?php
									endif ; ?>
								</strong></span><br/>
								<span class="ka_table_group"><strong><?php _e('Group: ','testimonial-basics'); ?></strong><?php echo stripcslashes($katb_tdata[$i]['tb_group']); ?></span><br/>
								<span class="ka_table_order"><strong><?php _e('Order: ','testimonial-basics'); ?></strong><?php if( $katb_tdata[$i]['tb_order'] == 0 ){ echo ""; }else{ echo $katb_tdata[$i]['tb_order']; }; ?></span><br/>
								<span class=="ka_table_rating"><strong><?php _e('Rating: ','testimonial-basics'); ?></strong><?php echo stripcslashes($katb_tdata[$i]['tb_rating']); ?></span>
							</td>
						
							<?php if( $katb_tdata[$i]['tb_pic_url'] == '' ) {
								?><td class="ka_table_pic"><?php echo get_avatar( $katb_tdata[$i]['tb_email'], $size = '60' ) ?></td><?php
							} else {
								?><td class="ka_table_pic"><img src="<?php echo $katb_tdata[$i]['tb_pic_url'] ?>" title="Uploaded_Author_Image" alt="Uploaded_Author_Image" /></td><?php
							} ?>
						
							<td class="ka_table_author_column">
								<span class="ka_table_name"><strong><?php _e('Name: ','testimonial-basics'); ?></strong><?php echo stripcslashes($katb_tdata[$i]['tb_name']); ?></span><br/>
								<span class="ka_table_email"><strong><?php _e('E-mail: ','testimonial-basics'); ?></strong><?php echo $katb_tdata[$i]['tb_email']; ?></span><br/>
								<span class="ka_table_location"><strong><?php _e('Location: ','testimonial-basics'); ?></strong><?php echo stripcslashes($katb_tdata[$i]['tb_location']); ?></span><br/>
								<span class="ka_table_website"><strong><?php _e('Website: ','testimonial-basics'); ?></strong><?php echo $katb_tdata[$i]['tb_url']; ?></span><br/>	
							</td>
							
							<td class="ka_table_testimonial"><?php echo wpautop(stripcslashes($katb_tdata[$i]['tb_testimonial'])); ?></td>
							
						</tr>
					<?php }	?>
			</tbody>
		</table>
		<?php katb_display_pagination( $katb_paginate_setup ); ?>
	</div>
<?php } 

/** ---------------- katb_testimonial_basics_admin_page_help callback ----------------
 * This function sets up the help file for the Edit Testimonials panel
 * 
 * -------------------------------------------------------------------------------- */
function katb_edit_testimonials_contextual_help(){
	
	// Globalize settings page	
	global $katb_edit_testimonials_page;
	
	// Get the current screen object
	$screen = get_current_screen();
	
	// Ensure current page is the edit testimonials page
	if ( $screen->id != $katb_edit_testimonials_page ) {
		return;
	}
	
	$contextual_help = '';	
	
	$contextual_help .= '<h2>Testimonial Basics - '.__('Adding And Editing Testimonials','testimonial-basics').'</h2>';
	$contextual_help .= '<ul>';
	$contextual_help .= '<li>'.__('To add a testimonial simply enter the data and click the Save Testimonial button','testimonial-basics').'</li>';
	$contextual_help .= '<li>'.__('To edit a testimonial click the ID button for the testimonial you want to edit, make your changes and Save Testimonial','testimonial-basics').'</li>';
	$contextual_help .= '<li>'.__('If the Approved checkbox is not selected, the testimonial will not be displayed.','testimonial-basics').'</li>';
	$contextual_help .= '<li>'.__('Enter a Order number, and you can optionally display lowest order number first.','testimonial-basics').'</li>';
	$contextual_help .= '<li>'.__('Enter a Group name and you can optionally display only the grouped testimonials.','testimonial-basics').'</li>';
	$contextual_help .= '<li>'.__('A Gravatar will be shown if the e-mail was set up for a gravatar, and the photo url input is empty.','testimonial-basics').'</li>';
	$contextual_help .= '<li>'.__('If you are using gravatars but do not want to display a particular author gravatar, delete the author email.','testimonial-basics').'</li>';
	$contextual_help .= '<li>'.__('If you want to upload a photo instead of using a gravatar, click the Upload Image button','testimonial-basics').'</li>';
	$contextual_help .= '<li>'.__('If you want add or change a rating, select the Review Rating dropdon list.','testimonial-basics').'</li>';
	$contextual_help .= '<li>'.__('In the admin panel estimonials are displayed by most recent date first.','testimonial-basics').'</li>';
	$contextual_help .= '<li>'.__('Each testimonial is assigned an ID number which can not be changed.','testimonial-basics').'</li>';
	$contextual_help .= '</ul>';
	$contextual_help .= '<h4>Testimonial Basics - '.__('Detailed User Documentation','testimonial-basics').'</h4>';
	$contextual_help .= '<ul><li>'.__('Detailed user documentation is available at the plugin site.','testimonial-basics').'</li></ul>';

	$screen->add_help_tab( array(
		// HTML ID attribute
		'id'      => 'katb_edit_testimonials',
		// Tab Title
		'title'   => __( 'Edit Testimonials Help', 'testimonial-basics' ),
		// Tab content
		'content' => $contextual_help ,
	) );
}

/**
 * This function sets up the help tabs for the Options panel
 * 
 * @uses katb_general_tab_help() found in this file
 * @uses katb_input_tab_help() found in this file
 * @uses katb_content_tab_help() found in this file
 * @uses katb_widget_tab_help() found in this file
 * @uses katb_faq_tab_help() found in this file
 * 
 */
function katb_plugin_options_contextual_help(){
	
	// Globalize settings page	
	global $katb_plugin_options_page;
	
	// Get the current screen object
	$screen = get_current_screen();
	
	// Ensure current page is the edit testimonials page
	if ( $screen->id != $katb_plugin_options_page ) {
		return;
	}
	
	$screen->add_help_tab( array(
		// HTML ID attribute
		'id'      => 'katb_plugin_options_general_help',
		// Tab Title
		'title'   => __( 'General', 'testimonial-basics' ),
		// Tab content
		'content' => katb_general_tab_help()
	) );
	
	$screen->add_help_tab( array(
		// HTML ID attribute
		'id'      => 'katb_plugin_options_input_help',
		// Tab Title
		'title'   => __( 'Input Forms', 'testimonial-basics' ),
		// Tab content
		'content' => katb_input_tab_help()
	) );
	
	$screen->add_help_tab( array(
		// HTML ID attribute
		'id'      => 'katb_plugin_options_content_help',
		// Tab Title
		'title'   => __( 'Content Display', 'testimonial-basics' ),
		// Tab content
		'content' => katb_content_tab_help()
	) );
	
	$screen->add_help_tab( array(
		// HTML ID attribute
		'id'      => 'katb_plugin_options_widget_help',
		// Tab Title
		'title'   => __( 'Widget Display', 'testimonial-basics' ),
		// Tab content
		'content' => katb_widget_tab_help()
	) );
	
	$screen->add_help_tab( array(
		// HTML ID attribute
		'id'      => 'katb_plugin_options_faq_help',
		// Tab Title
		'title'   => __( 'FAQ', 'testimonial-basics' ),
		// Tab content
		'content' => katb_faq_tab_help()
	) );
	
}

/**
 * General Help string
 * 
 * called by katb_plugin_options_contextual_help
 * 
 * @return string $html
 */
function katb_general_tab_help() {
	
	$html = '';
	$html .= '<h2>'.__('General Options','testimonial-basics').'</h2>';
	
	$html .= '<p><strong>'.__('User role to edit testimonials','testimonial-basics').' - </strong>';
	$html .= __('Administrator : only logged in administrators can edit testimonials.','testimonial-basics');
	$html .= ' '.__('Editor : logged in Administrators or Editors can edit testimonials.','testimonial-basics').'</p>';
	
	$html .= '<p><strong>'.__('Testimonial notify email address','testimonial-basics').' - </strong>';
	$html .= __('An email is sent to this address (or admin email if left blank) to notify that a testimonial has been submitted.','testimonial-basics').'</p>';
	
	$html .= '<p><strong>'.__('Use Ratings','testimonial-basics').' - </strong>';
	$html .= __('Select this and the user will have the option of submitting a rating using a five star rating system.','testimonial-basics').'</p>';
	
	$html .= '<p><strong>'.__('Enable the testimonial rotator script','testimonial-basics').' - </strong>';
	$html .= __('Uncheck this box to disable the script, if you are not using rotating testimonials.','testimonial-basics');
	$html .= ' '.__('This option may come in handy if you are troubleshooting jQuery problems.','testimonial-basics').'</p>';
	
	$html .= '<h2>'.__('Schema Options','testimonial-basics').'</h2>';
	
	$html .= '<p><strong>'.__('Use schema markup','testimonial-basics').' - </strong>';
	$html .= __('If you choose to use schema markup fill out the information below even if you choose not to display some items.','testimonial-basics');
	$html .= ' '.__('The reason is that the information is still included in meta tags to help Google.','testimonial-basics').'</p>';
	
	$html .= '<p><strong>'.__('Schema Company Name','testimonial-basics').' - </strong>';
	$html .= __('Your company name will appear at the top of the page if you choose to display it.','testimonial-basics').'</p>';
	
	$html .= '<p><strong>'.__('Schema Company Website Reference','testimonial-basics').' - </strong>';
	$html .= __('Your company website address will appear at the top of the page if you choose to display it.','testimonial-basics').'</p>';
	
	$html .= '<p><strong>'.__('Schema Display Company','testimonial-basics').' - </strong>';
	$html .= __('Display your company name and website at the top of the page.','testimonial-basics').'</p>';
	
	$html .= '<p><strong>'.__('Schema Display Aggregate','testimonial-basics').' - </strong>';
	$html .= __('If you choose to display a group of testimonials then that group is summarized.','testimonial-basics');
	$html .= ' '.__('Otherwise the summary is for all the testimonials on your site.','testimonial-basics').'</p>';
	
	$html .= '<p><strong>'.__('Schema Display Reviews','testimonial-basics').' - </strong>';
	$html .= __('You can choose to only display the summary if you want.','testimonial-basics').'</p>';
	
	$html .= '<p><strong>'.__('Group Aggregate Review Name','testimonial-basics').' - </strong>';
	$html .= __('If you have grouped the testimonials you can use the Group name you have set up for a summary title.','testimonial-basics').'</p>';
	
	$html .= '<p><strong>'.__('Custom Aggregate Review Name','testimonial-basics').' - </strong>';
	$html .= __('You can specify a custom name if you do not want to use the Group name.','testimonial-basics');
	$html .= ' '.__('If you want to use the Group name then leave this blank.','testimonial-basics');
	$html .= ' '.__('If you do not want to use a name at all then leave the checkbox unchecked and this section blank.','testimonial-basics').'</p>';
	
	$html .= '<p><strong>'.__('Group Individual Review Name','testimonial-basics').' - </strong>';
	$html .= __('Check this to use the Group name you have set up for the testimonial title.','testimonial-basics');
	
	$html .= '<p><strong>'.__('Custom Individual Review Name','testimonial-basics').' - </strong>';
	$html .= __('You can specify a custom name if you do not want to use the Group name.','testimonial-basics');
	$html .= ' '.__('If you want to use the Group name then leave this blank.','testimonial-basics');
	$html .= ' '.__('If you do not want to use a name at all then leave the checkbox unchecked and this section blank.','testimonial-basics').'</p>';
	
	return $html;
}

/**
 * Input Form Help string
 * 
 * called by katb_plugin_options_contextual_help()
 * 
 * @return string $html
 */
function katb_input_tab_help() {
	
	$html = '';
	$html .= '<h2>'.__('General Input Options','testimonial-basics').'</h2>';
	
	$html .= '<p><strong>'.__('Auto Approve Testimonials','testimonial-basics').' - </strong>';
	$html .= __('You can check this box to have testimonials automatically approved.','testimonial-basics');
	$html .= ' '.__('CAUTION: Not recommended so use at your own risk.','testimonial-basics').'</p>';
	
	$html .= '<p><strong>'.__('Use captcha on input forms','testimonial-basics').' - </strong>';
	$html .= __('You can include a black and white captcha on the input forms.','testimonial-basics');
	$html .= ' '.__('If for any reason the Captcha is not working, disable it here.','testimonial-basics').'</p>';
	
	$html .= '<p><strong>'.__('Use color captcha option','testimonial-basics').' - </strong>';
	$html .= __('Select this to use a color captcha option.','testimonial-basics');
	$html .= ' '.__('If the black and white captcha is not working, try this one.','testimonial-basics').'</p>';
	
	$html .= '<p><strong>'.__('Exclude Website in input form','testimonial-basics').' - </strong>';
	$html .= __('Select and the website input will not be used.','testimonial-basics').'</p>';
	
	$html .= '<p><strong>'.__('Exclude Location in input form','testimonial-basics').' - </strong>';
	$html .= __('Select and the location input will not be used.','testimonial-basics').'</p>';
	
	$html .= '<p><strong>'.__('Include email note','testimonial-basics').' - </strong>';
	$html .= __('Check this if you want to add a note.','testimonial-basics').'</p>';
	
	$html .= '<p><strong>'.__('Email note','testimonial-basics').' - </strong>';
	$html .= __('Add the note here if you do not want to use the default.','testimonial-basics');
	$html .= ' '. __('Keep the text you enter to a reasonable length or it may look funny.','testimonial-basics').'</p>';

	$html .= '<h2>'.__('Content and Widget Form Input Options','testimonial-basics').'</h2>';
	
	$html .= '<p><strong>'.__('Base Font Size','testimonial-basics').' - </strong>';
	$html .= __('This option allows you to change the font size.','testimonial-basics').' ';
	$html .= __('It should work for most themes but CSS Specifity can cause problems.','testimonial-basics').' ';
	$html .= __('Do not worry about what an em is just try one and see what happens.','testimonial-basics');'</p>';
	
	$html .= '<p><strong>'.__('Include title on input form','testimonial-basics').' - </strong>';
	$html .= __('Select this to display a title above the input form.','testimonial-basics').'</p>';
	
	$html .= '<p><strong>'.__('Title for Input Form','testimonial-basics').' - </strong>';
	$html .= __('Put the title you want to use here.','testimonial-basics');
	$html .= ' '. __('Note that for widgets the title is entered when you place the widget.','testimonial-basics').'</p>';
	
	$html .= '<p><strong>'.__('Show html allowed strip in input form','testimonial-basics').' - </strong>';
	$html .= __('Optionally include an html allowed strip on input forms.','testimonial-basics');
	$html .= ' '. __('This strip shows the user what html tags will be allowed in the testimonial.','testimonial-basics').'</p>';
	
	$html .= '<p><strong>'.__('Labels','testimonial-basics').' - </strong>';
	$html .= __('You can change any of the labels in the input forms.','testimonial-basics');
	$html .= ' '. __('This feature will come in handy for users that want to use a different language.','testimonial-basics').'</p>';
		
	return $html;
}

/**
 * Content Display Help string
 * 
 * called by katb_plugin_options_contextual_help()
 * 
 * @return string $html
 */
function katb_content_tab_help() {
	
	$html = '';
	$html .= '<h2>'.__('Content Display General Options','testimonial-basics').'</h2>';
	
	$html .= '<p><strong>'.__('Layout Option','testimonial-basics').' - </strong>';
	$html .= __('The Meta referred to is the rating, author, date, location, and website.','testimonial-basics');
	$html .= ' '.__('You can place it at the top or bottom.','testimonial-basics').'</p>';
	
	$html .= '<p><strong>'.__('Base Font Size','testimonial-basics').' - </strong>';
	$html .= __('This option allows you to change the font size.','testimonial-basics').' ';
	$html .= __('It should work for most themes but CSS Specifity can cause problems.','testimonial-basics').' ';
	$html .= __('Do not worry about what an em is just try one and see what happens.','testimonial-basics');'</p>';
	
	$html .= '<p><strong>'.__('Pagination','testimonial-basics').' - </strong>';
	$html .= __('You can use pagination when you display all testimonials or all testimonials in a Group.','testimonial-basics');
	$html .= ' '.__('In any other display there is really no reason to use pagination.','testimonial-basics');
	$html .= ' '.__('You can choose to display 3, 5 or 10 per page.','testimonial-basics').'</p>';
	
	$html .= '<p><strong>'.__('Excerpts','testimonial-basics').' - </strong>';
	$html .= __('You can use excerpts with the specified character length to display your testimonials.','testimonial-basics');
	$html .= ' '.__('When excerpts are selected, the testimonial is limited to the characters input.','testimonial-basics');
	$html .= ' '.__('A user can then click a ...more link to display a pop-up of the entire testimonial.','testimonial-basics').'</p>';
	
	$html .= '<p><strong>'.__('Show title in testimonial','testimonial-basics').' - </strong>';
	$html .= __('If you wish to show the Group name or a Custom name for your testimonial, select this option.','testimonial-basics');
	$html .= ' '.__('Then make sure the Custom Individual Review Name is filled out or Group Individual Review Name is selected - in the General Tab.','testimonial-basics').'</p>';
	
	$html .= '<p><strong>'.__('Meta Display Options','testimonial-basics').' - </strong>';
	$html .= __('The author is displayed as a minimum.','testimonial-basics');
	$html .= ' '.__('You can then optionally display website, location, and date.','testimonial-basics').'</p>';
	
	$html .= '<p><strong>'.__('Gravatars','testimonial-basics').' - </strong>';
	$html .= __('Select this to display Gravatars.','testimonial-basics');
	$html .= ' '. __('Uploaded photos are displayed first.','testimonial-basics');
	$html .= ' '. __('If an uploaded photo does not exist, the plugin will display a gravatar, if one exists.','testimonial-basics');
	$html .= ' '. __('If gravatar does not exist, you can optionally display a substitute character.','testimonial-basics').'</p>';
	
	$html .= '<p><strong>'.__('Use italic font style','testimonial-basics').' - </strong>';
	$html .= __('Click this and italics will be used for the testimonial.','testimonial-basics').'</p>';
	
	$html .= '<h2>'.__('Content Display Rotator Options','testimonial-basics').'</h2>';
	
	$html .= '<p><strong>'.__('Time between slides','testimonial-basics').' - </strong>';
	$html .= __('Select the time in mili-seconds 1000 ms = 1 sec.','testimonial-basics').'</p>';
	
	$html .= '<p><strong>'.__('Rotator height in pixels','testimonial-basics').' - </strong>';
	$html .= __('Selects a minimum height for all testimonials.','testimonial-basics');
	$html .= ' '. __('Use this option to prevent the screen from growing or shrinking to accomodate each testimonials.','testimonial-basics');
	$html .= ' '. __('Tip: use excerpts and make sure the length keeps testimonials within the minimum height prescribed.','testimonial-basics').'</p>';
	
	$html .= '<p><strong>'.__('Rotator transition effect','testimonial-basics').' - </strong>';
	$html .= __('Select the transition effect for the slider.','testimonial-basics').'</p>';
	
	$html .= '<h2>'.__('Content Display Custom Options','testimonial-basics').'</h2>';
	
	$html .= '<p><strong>'.__('Use formatted display','testimonial-basics').' - </strong>';
	$html .= __('To use formatted display select this box.','testimonial-basics');
	$html .= ' '. __('If the Formatted Display box is checked a 3D style is applied to the testimonials, which can be customized.','testimonial-basics').'</p>';
	
	$html .= '<p><strong>'.__('Font for Content Display','testimonial-basics').' - </strong>';
	$html .= __('You can choose a font from the dropdown list.','testimonial-basics').'</p>';
	
	$html .= '<p><strong>'.__('Colors','testimonial-basics').' - </strong>';
	$html .= __('Enter any hexdec color number preceded by a # mark or use the color picker','testimonial-basics');
	$html .= ' '. __('Select the color input cell you want to change.','testimonial-basics');
	$html .= ' '. __('A color box appears with a saturation bar on the right.','testimonial-basics');
	$html .= ' '. __('Drag the dot on the color box to select the color.','testimonial-basics');
	$html .= ' '. __('Change the saturation with the sliding bar on the right.','testimonial-basics');
	$html .= ' '. __('Click the Current Color Button when you are done.','testimonial-basics').'</p>';

	return $html;
}


/**
 * Widget Display Help string
 * 
 * called by katb_plugin_options_contextual_help()
 * 
 * @return string $html
 */
function katb_widget_tab_help() {
	
	$html = '';
	$html .= '<h2>'.__('Widget Display Options','testimonial-basics').'</h2>';
	
	$html .= '<p>'.__('There are very few differences between the Content Display Options and the Widget Display Options.','testimonial-basics');
	$html .= ' '.__('Pagination does not apply for widgets, and there is no testimonial wrap for formatting.','testimonial-basics');
	$html .= ' '.__('The user is referred to the Content Display section for help.','testimonial-basics').'</p>';
	
	return $html;
}

/**
 * Widget Display Help string
 * 
 * called by katb_plugin_options_contextual_help()
 * 
 * @return string $html
 */
function katb_faq_tab_help() {
	
	$html = '';
	$html .= '<h2>'.__('FAQ','testimonial-basics').'</h2>';
	
	$html .= '<p><strong>'.__('Why are users not allowed to upload photos?','testimonial-basics').' - </strong>';
	$html .= __('Users are not allowed to upload photos for security reasons.','testimonial-basics');
	$html .= ' '.__('Allowing anyone who is not logged in to upload files to your WordPress site is a very risky practice.','testimonial-basics');
	$html .= ' '.__('The Gravatar system is very simple to register and the safe way to get user photos in their testimonials.','testimonial-basics');
	$html .= ' '.__('The Admin or Editor can log in and upload photos from the Edit Testimonials Panel.','testimonial-basics').'</p>';
	
	$html .= '<p><strong>'.__('Why are testimonials not automatically approved?','testimonial-basics').' - </strong>';
	$html .= ' '.__('If you want testimonials on your site then you are concerned about what clients think of your business.','testimonial-basics');
	$html .= ' '.__('So it is probably a good idea to check the testimonial first and then approve it.','testimonial-basics').'</p>';
	
	$html .= '<p><strong>'.__('My testimonial is not displaying.','testimonial-basics').' - </strong>';
	$html .= ' '.__('Go in to the edit testimonials panel and make sure it is approved.','testimonial-basics').'</p>';
	
	$html .= '<p><strong>'.__('The widget labels do not disappear when selected.','testimonial-basics').' - </strong>';
	$html .= ' '.__('They must be deleted.','testimonial-basics');
	$html .= ' '.__('It is set up this way to keep the entry for editing in the event of a submission error.','testimonial-basics').'</p>';
	
	return $html;
}

/**
 * Plugin register_setting() sanitize callback
 * 
 * Validate and whitelist user-input data before updating Theme 
 * Options in the database. Only whitelisted options are passed
 * back to the database, and user-input data for all whitelisted
 * options are sanitized.
 * 
 * @link	http://codex.wordpress.org/Data_Validation	Codex Reference: Data Validation
 * 
 * @param	array	$input	Raw user-input data submitted via the Theme Settings page
 * 
 * @uses katb_get_options(); found in /includes/katb_functions.php
 * @uses katb_get_settings_by_tab() found in this file
 * @uses katb_get_option_parameters() found in this file
 * @uses katb_get_option_defaults() found in this file
 * @uses katb_get_settings_page_tabs() found in this file
 * 
 * @return $valid_input	Sanitized user-input data passed to the database
 */
function katb_validate_options( $input ) {

	// This is the "whitelist": current settings
	$valid_input = katb_get_options();
	// Get the array of Theme settings, by Settings Page tab
	$settingsbytab = katb_get_settings_by_tab();
	// Get the array of option parameters
	$option_parameters = katb_get_option_parameters();
	// Get the array of option defaults
	$option_defaults = katb_get_option_defaults();
	// Get list of tabs
	$tabs = katb_get_settings_page_tabs();
	//array for possible errors
	$katb_input_error = array();
	
	// Determine what type of submit was input
	$submittype = 'submit';	
	foreach ( $tabs as $tab ) {
		$resetname = 'reset-' . $tab['name'];
		if ( ! empty( $input[$resetname] ) ) {
			$submittype = 'reset';
		}
	}
	
	// Determine what tab was input
	$submittab = 'general';	
	foreach ( $tabs as $tab ) {
		$submitname = 'submit-' . $tab['name'];
		$resetname = 'reset-' . $tab['name'];
		if ( ! empty( $input[$submitname] ) || ! empty($input[$resetname] ) ) {
			$submittab = $tab['name'];
		}
	}
	// Get settings by tab
	$tabsettings = $settingsbytab[$submittab] ;
	// Loop through each tab setting
	foreach ( $tabsettings as $setting ) {
		// If no option is selected, set the default
		$valid_input[$setting] = ( ! isset( $input[$setting] ) ? $option_defaults[$setting] : $input[$setting] );
		
		// If submit, validate/sanitize $input
		if ( 'submit' == $submittype ) {
			// Get the setting details from the defaults array
			$optiondetails = $option_parameters[$setting];
			// Get the array of valid options, if applicable
			$valid_options = ( isset( $optiondetails['valid_options'] ) ? $optiondetails['valid_options'] : false );
			
			// Validate checkbox fields
			if ( 'checkbox' == $optiondetails['type'] ) {
				// If input value is set and is true, return true; otherwise return false
				$valid_input[$setting] = ( ( isset( $input[$setting] ) && true == $input[$setting] ) ? true : false );
			}
			// Validate radio button fields
			else if ( 'radio' == $optiondetails['type'] ) {
				// Only update setting if input value is in the list of valid options
				$valid_input[$setting] = ( array_key_exists( $input[$setting], $valid_options ) ? $input[$setting] : $valid_input[$setting] );
			}
			// Validate select fields
			else if ( 'select' == $optiondetails['type'] ) {
				// Only update setting if input value is in the list of valid options
				$valid_input[$setting] = ( array_key_exists( $input[$setting], $valid_options ) ? $input[$setting] : $valid_input[$setting] );
			}
			// Validate text input and textarea fields
			else if ( ( 'text' == $optiondetails['type'] || 'textarea' == $optiondetails['type'] ) ) {
				// Validate no-HTML content
				if ( 'nohtml' == $optiondetails['class'] ) {
					// Pass input data through the wp_filter_nohtml_kses filter
					$valid_input[$setting] = wp_filter_nohtml_kses( $input[$setting] );
				}
				// Validate HTML content
				else if ( 'html' == $optiondetails['class'] ) {
					// Pass input data through the wp_filter_kses filter
					$valid_input[$setting] = wp_filter_post_kses( $input[$setting] );
				}
				else if ( 'url' == $optiondetails['class'] || 'img' == $optiondetails['class'] ) {
					//eliminate invalid and dangerous characters
					$valid_input[$setting] = esc_url($valid_input[$setting]);
				}
				else if ( 'email' == $optiondetails['class'] ) {
					if ( $valid_input[$setting] !== '' ){
						$valid_input[$setting] = sanitize_email( $valid_input[$setting] );
						If ( $valid_input[$setting] == '' ){
							add_settings_error(
								$setting, // setting title
								'katb_email_error', // error ID
								'Please enter a valid e-mail - blank returned', // error message
								'error' // type of message
							);
						}
					}
					if ( $valid_input[$setting] !== '' && ! is_email($valid_input[$setting]) ) {
						$valid_input[$setting] = '';
						add_settings_error(
							$setting, // setting title
							'katb_email_error', // error ID
							'Please enter a valid e-mail - blank returned', // error message
							'error' // type of message
						);						
					}
				}
				else if ( 'hexcolor' == $optiondetails['class'] ) {
					$valid_input[$setting] = trim($valid_input[$setting]); // trim whitespace
					if ($valid_input[$setting] == "") $valid_input[$setting] = $option_defaults[$setting];
					if(substr($valid_input[$setting],0,1) !== '#'){$valid_input[$setting] = '#' . $valid_input[$setting];}
					if(! preg_match('/^#[a-f0-9]{6}$/i', $valid_input[$setting])) {//hex color is valid
						$valid_input[$setting] = $option_defaults[$setting];
						add_settings_error(
							$setting, // setting title
							'katb_hex_color_error', // error ID
							'Please enter a valid Hex Color Number-default returned.', // error message
							'error' // type of message
						);
					} 
				}
				else {
					// Catch all
					//Pass input data through the wp_filter_kses filter
					$valid_input[$setting] = wp_filter_kses( $input[$setting] );
				}
			}
		} 
		// If reset, reset defaults
		elseif ( 'reset' == $submittype ) {
			// Set $setting to the default value
			$valid_input[$setting] = $option_defaults[$setting];
		}
	}
	return $valid_input;		
}


/**
 * Helper function for creating admin messages
 * src: http://www.wprecipes.com/how-to-show-an-urgent-message-in-the-wordpress-admin-area
 *
 * @param (string) $message The message to echo
 * @param (string) $msgclass The message class
 * @return echoes the message
 */	
function katb_show_msg($message, $msgclass = 'info') {
	echo "<div id='message' class='$msgclass'>$message</div>";
}


/**
 * Callback function for displaying admin messages
 *
* @return calls katb_show_msg()
*/
function katb_admin_msgs() {
	// check for our settings page - need this in conditional further down
	if(isset($_GET['page'])){
		$katb_settings_pg = strpos($_GET['page'], 'katb-settings');
	} else {
		$katb_settings_pg = FALSE;
	}
	// collect setting errors/notices: //http://codex.wordpress.org/Function_Reference/get_settings_errors
	$set_errors = get_settings_errors(); 
	
	//display admin message only for the admin to see, only on our settings page and only when setting errors/notices are returned!	
	if(current_user_can ('manage_options') && $katb_settings_pg !== FALSE && !empty($set_errors)){

		// have our settings succesfully been updated? 
		if($set_errors[0]['code'] == 'settings_updated' && isset($_GET['settings-updated'])){
			katb_show_msg("<p>" . $set_errors[0]['message'] . "</p>", 'updated');
		
		// have errors been found?
		}else{
			// there maybe more than one so run a foreach loop.
			foreach($set_errors as $set_error){
				// set the title attribute to match the error "setting title" - need this in js file
				katb_show_msg("<p class='setting-error-message' title='" . $set_error['setting'] . "'>" . $set_error['message'] . "</p>", 'error');
			}
		}
	}
}
add_action('admin_notices', 'katb_admin_msgs');


/**
 * This function contains the html for the intro section to the admin pages
 */
function katb_intro_html(){ ?>

	<div class="katb_paypal"><?php _e('Show your appreciation!','testimonial-basics') ?>
		<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
		<input type="hidden" name="cmd" value="_s-xclick">
		<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----MIIHJwYJKoZIhvcNAQcEoIIHGDCCBxQCAQExggEwMIIBLAIBADCBlDCBjjELMAkGA1UEBhMCVVMxCzAJBgNVBAgTAkNBMRYwFAYDVQQHEw1Nb3VudGFpbiBWaWV3MRQwEgYDVQQKEwtQYXlQYWwgSW5jLjETMBEGA1UECxQKbGl2ZV9jZXJ0czERMA8GA1UEAxQIbGl2ZV9hcGkxHDAaBgkqhkiG9w0BCQEWDXJlQHBheXBhbC5jb20CAQAwDQYJKoZIhvcNAQEBBQAEgYAWda3nDR6MPrYTNTF0myOSYBmAmhQyMnyUVOkTAjWO3eCwNGi24P18E83Sb7+G92BelPnIm6gsqC1URCPLzv0PabLm795Lm4nLRBmLjkxQSsR+5PpWudEe/trI4LhQPWJ579hdO1Beh7hAeGmIOfjY2GnOied+YbpUK/t7RsW4MDELMAkGBSsOAwIaBQAwgaQGCSqGSIb3DQEHATAUBggqhkiG9w0DBwQIpiX2fVsGTBaAgYDF1xsr6CAYlqIAwLMeG5GgRL52oCyVw2cP9CSCh3pQW5n/3WSG01MhsOa2ewGlZs6rIdYhWVQhk74TbW1UOgEFX7ROddWRPMHBk5t59oJMugA1KjqnG7XMqY2lWFCYT/yQ73QZHzkna+ZValvJnR0dtdIDBTPvEdZ1z7sQjf8T7aCCA4cwggODMIIC7KADAgECAgEAMA0GCSqGSIb3DQEBBQUAMIGOMQswCQYDVQQGEwJVUzELMAkGA1UECBMCQ0ExFjAUBgNVBAcTDU1vdW50YWluIFZpZXcxFDASBgNVBAoTC1BheVBhbCBJbmMuMRMwEQYDVQQLFApsaXZlX2NlcnRzMREwDwYDVQQDFAhsaXZlX2FwaTEcMBoGCSqGSIb3DQEJARYNcmVAcGF5cGFsLmNvbTAeFw0wNDAyMTMxMDEzMTVaFw0zNTAyMTMxMDEzMTVaMIGOMQswCQYDVQQGEwJVUzELMAkGA1UECBMCQ0ExFjAUBgNVBAcTDU1vdW50YWluIFZpZXcxFDASBgNVBAoTC1BheVBhbCBJbmMuMRMwEQYDVQQLFApsaXZlX2NlcnRzMREwDwYDVQQDFAhsaXZlX2FwaTEcMBoGCSqGSIb3DQEJARYNcmVAcGF5cGFsLmNvbTCBnzANBgkqhkiG9w0BAQEFAAOBjQAwgYkCgYEAwUdO3fxEzEtcnI7ZKZL412XvZPugoni7i7D7prCe0AtaHTc97CYgm7NsAtJyxNLixmhLV8pyIEaiHXWAh8fPKW+R017+EmXrr9EaquPmsVvTywAAE1PMNOKqo2kl4Gxiz9zZqIajOm1fZGWcGS0f5JQ2kBqNbvbg2/Za+GJ/qwUCAwEAAaOB7jCB6zAdBgNVHQ4EFgQUlp98u8ZvF71ZP1LXChvsENZklGswgbsGA1UdIwSBszCBsIAUlp98u8ZvF71ZP1LXChvsENZklGuhgZSkgZEwgY4xCzAJBgNVBAYTAlVTMQswCQYDVQQIEwJDQTEWMBQGA1UEBxMNTW91bnRhaW4gVmlldzEUMBIGA1UEChMLUGF5UGFsIEluYy4xEzARBgNVBAsUCmxpdmVfY2VydHMxETAPBgNVBAMUCGxpdmVfYXBpMRwwGgYJKoZIhvcNAQkBFg1yZUBwYXlwYWwuY29tggEAMAwGA1UdEwQFMAMBAf8wDQYJKoZIhvcNAQEFBQADgYEAgV86VpqAWuXvX6Oro4qJ1tYVIT5DgWpE692Ag422H7yRIr/9j/iKG4Thia/Oflx4TdL+IFJBAyPK9v6zZNZtBgPBynXb048hsP16l2vi0k5Q2JKiPDsEfBhGI+HnxLXEaUWAcVfCsQFvd2A1sxRr67ip5y2wwBelUecP3AjJ+YcxggGaMIIBlgIBATCBlDCBjjELMAkGA1UEBhMCVVMxCzAJBgNVBAgTAkNBMRYwFAYDVQQHEw1Nb3VudGFpbiBWaWV3MRQwEgYDVQQKEwtQYXlQYWwgSW5jLjETMBEGA1UECxQKbGl2ZV9jZXJ0czERMA8GA1UEAxQIbGl2ZV9hcGkxHDAaBgkqhkiG9w0BCQEWDXJlQHBheXBhbC5jb20CAQAwCQYFKw4DAhoFAKBdMBgGCSqGSIb3DQEJAzELBgkqhkiG9w0BBwEwHAYJKoZIhvcNAQkFMQ8XDTEyMDkwNTE3MjU0OFowIwYJKoZIhvcNAQkEMRYEFOyC27zUKcgyqrKRNRLcOqZ97R6dMA0GCSqGSIb3DQEBAQUABIGAG3Nciv27vHA0sdyoIYl8h0Ghj9DBAXeF2M8ua0GdW4QYRszQr/YXjA4cS9RdqjAOgm9bRgLOFMskUrDI5iXFpybj4DYRN2RLRaPP6ZypSetKW66JpmLiUaUF1sxoq+KBhOgxH0GJw0/nLiJSVQ3002Yy1qTy3LwZtWdR0IBzjIg=-----END PKCS7-----
		">
		<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_paynow_SM.gif" name="submit" alt="PayPal - The safer, easier way to pay online!">
		<img alt="" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
		</form>
	</div>
	<p><?php _e('Author Site : ','testimonial-basics'); ?><a href="http://www.kevinsspace.ca" target="_blank" >www.kevinsspace.ca</a>&nbsp;&nbsp;&nbsp; 
		<?php _e('Plugin Site : ','testimonial-basics'); ?><a href="http://www.kevinsspace.ca/testimonial-basics-wordpress-plugin/" target="_blank" >www.kevinsspace.ca/testimonial-basics-wordpress-plugin/</a></p>
<?php }

/**
 * Separate settings by tab
 * 
 * Returns an array of tabs, each of
 * which is an indexed array of settings
 * included with the specified tab.
 *
 * @uses	katb_get_option_parameters()	
 * @uses	katb_get_settings_page_tabs()
 * 
 * @return	array	$settingsbytab	array of arrays of settings by tab
 */
function katb_get_settings_by_tab() {
	// Get the list of settings page tabs
	$tabs = katb_get_settings_page_tabs();
	// Initialize an array to hold
	// an indexed array of tabnames
	$settingsbytab = array();
	// Loop through the array of tabs
	foreach ( $tabs as $tab ) {
		$tabname = $tab['name'];
		// Add an indexed array key
		// to the settings-by-tab 
		// array for each tab name
		$settingsbytab[] = $tabname;
	}
	// Get the array of option parameters
	$option_parameters = katb_get_option_parameters();
	// Loop through the option parameters
	// array
	foreach ( $option_parameters as $option_parameter ) {
		$optiontab = $option_parameter['tab'];
		$optionname = $option_parameter['name'];
		// Add an indexed array key to the 
		// settings-by-tab array for each
		// setting associated with each tab
		$settingsbytab[$optiontab][] = $optionname;
		$settingsbytab['all'][] = $optionname;
	}
	// Return the settings-by-tab
	// array
	return $settingsbytab;
}

/**
 * Testimonial Basics Admin Settings Page Tabs
 * 
 * Array that holds all of the tabs for the
 * Testimonial Basics Settings Page. Each tab
 * key holds an array that defines the 
 * sections for each tab, including the
 * description text.
 * 
 * @return	array	$tabs	array of arrays of tab parameters
 */	
function katb_get_settings_page_tabs() {
	
	$tabs = array( 
        'general' => array(
			'name' => 'general',
			'title' => __( 'General', 'testimonial-basics' ),
			'sections' => array(
				'general' => array(
					'name' => 'general',
					'title' => __( 'General Options', 'testimonial-basics' ),
					'description' => ''
				),
				'schema' => array(
					'name' => 'schema',
					'title' => __( 'Schema Options', 'testimonial-basics' ),
					'description' => '<p>'.
										__('I use the term Schema a bit loosley.','testimonial-basics' ).' '.
										__('It refers to','testimonial-basics' ).' <a href="http://schema.org" title="schema" target="_blank">schema.org</a>'.' '.
										__('which is a','testimonial-basics' ).' <br/><br/> "'.
										__('collaboration by Google, Microsoft and Yahoo to improve the web by creating a structured data markup schema supported by major search engines.','testimonial-basics' ).' '.
										__('On-page markup helps search engines understand the information on web pages and provide richer results.','testimonial-basics' ).' '.
										__('A shared markup vocabulary makes it easier for webmasters to decide on a markup schema and get maximum benefit for their efforts.','testimonial-basics' ).'"</p><p>'.
										__('You can now choose to display testimonials in a structured data format, which should help search results for your site.','testimonial-basics' ).'</p>'
				)
			)
		),
        'input' => array(
			'name' => 'input',
			'title' => __( 'Input Forms', 'blogBox' ),
			'sections' => array(
				'general' => array(
					'name' => 'general',
					'title' => __( 'General Input Options', 'testimonial-basics' ),
					'description' => ''
				),
				'content_input_form' => array(
					'name' => 'content_input_form',
					'title' => __( 'Content Form Input Options', 'testimonial-basics' ),
					'description' => ''
				),
				'widget_input_form' => array(
					'name' => 'widget_input_form',
					'title' => __( 'Widget Form Input Options', 'testimonial-basics' ),
					'description' => ''
				)
			)
		),
        'content_display' => array(
			'name' => 'content_display',
			'title' => __( 'Content Display', 'testimonial-basics' ),
			'sections' => array(
				'content_general' => array(
					'name' => 'content_general',
					'title' => __( 'Content Display General Options', 'testimonial-basics' ),
					'description' => '<p>'.__('Content display refers to displaying your testimonials in the content area of your pages and posts.','testimonial-basics').'</p>'
				),
				'content_rotator' => array(
					'name' => 'content_rotator',
					'title' => __( 'Content Display Rotator Options', 'testimonial-basics' ),
					'description' => '<p>'.__('You can display up to 5 content rotators on one page.','testimonial-basics').'</p>'
				),
				'content_custom_formats' => array(
					'name' => 'content_custom_formats',
					'title' => __( 'Content Display Custom Options', 'testimonial-basics' ),
					'description' => ''
				)
			)
		),
		'widget_display' => array(
			'name' => 'widget_display',
			'title' => __( 'Widget Display', 'blogBox' ),
			'sections' => array(
				'widget_general' => array(
					'name' => 'widget_general',
					'title' => __( 'Widget Display General Options', 'testimonial-basics' ),
					'description' => ''
				),
				'widget_rotator' => array(
					'name' => 'widget_rotator',
					'title' => __( 'Widget Display Rotator Options', 'testimonial-basics' ),
					'description' => '<p>'.__('You can display up to 5 widget rotators on one page.','testimonial-basics').'</p>'
				),
				'widget_custom_formats' => array(
					'name' => 'widget_custom_formats',
					'title' => __( 'Widget Display Custom Options', 'testimonial-basics' ),
					'description' => ''
				)
			)
		)
    );
	return apply_filters( 'katb_get_settings_page_tabs', $tabs );
}

/**
 * Get current settings page tab
 */
function katb_get_current_tab() {
	
	$page = 'katb-settings';
    if ( isset( $_GET['tab'] ) ) {
        $current = $_GET['tab'];
    } else {
		$current = 'general';
    }
	return $current;
}