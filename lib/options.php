<?php
/**
 * Child Theme Settings
 * Requires Genesis 1.8 or later
 *
 * This file registers all of this child theme's specific Theme Settings, accessible from
 * Genesis > Child Theme Settings.
 *
 * @package     BE Genesis Child
 * @author      Bill Erickson <bill@billerickson.net>
 * @copyright   Copyright (c) 2011, Bill Erickson
 * @license     http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link        https://github.com/billerickson/BE-Genesis-Child
 */ 
 
/**
 * Registers a new admin page, providing content and corresponding menu item
 * for the Child Theme Settings page.
 *
 * @package BE Genesis Child
 * @subpackage Admin
 *
 * @since 1.0.0
 */
class Child_Theme_Settings extends Genesis_Admin_Boxes {
	
	/**
	 * Create an admin menu item and settings page.
	 * 
	 * @since 1.0.0
	 */
	function __construct() {
		
		// Specify a unique page ID. 
		$page_id = 'top-left-creative';
		
		// Set it as a child to genesis, and define the menu and page titles
		$menu_ops = array(
			'submenu' => array(
				'parent_slug' => 'genesis',
				'page_title'  => 'Top Left Creative Theme Settings',
				'menu_title'  => 'TLC Options',
				'capability' => 'edit_theme_options',
			)
		);
		
		// Set up page options. These are optional, so only uncomment if you want to change the defaults
		$page_ops = array(
		//	'screen_icon'       => 'options-general',
		//	'save_button_text'  => 'Save Settings',
		//	'reset_button_text' => 'Reset Settings',
		//	'save_notice_text'  => 'Settings saved.',
		//	'reset_notice_text' => 'Settings reset.',
		);		
		
		// Give it a unique settings field. 
		// You'll access them from genesis_get_option( 'option_name', 'tlc-options' );
		$settings_field = 'tlc-options';
		
		// Set the default values
		$default_settings = array(
			'application-url' => '',
			'company-nmls'   => '12345',
			'individual-nmls' => '12345',
			'address' => '1200 NW Marshall St Ste 910, Portland, OR 97209',
			'phone' => '(801) 923-8220',
		);
		
		// Create the Admin Page
		$this->create( $page_id, $menu_ops, $page_ops, $settings_field, $default_settings );
 
		// Initialize the Sanitization Filter
		add_action( 'genesis_settings_sanitizer_init', array( $this, 'sanitization_filters' ) );
			
	}
 
	/** 
	 * Set up Sanitization Filters
	 *
	 * See /lib/classes/sanitization.php for all available filters.
	 *
	 * @since 1.0.0
	 */	
	function sanitization_filters() {
		
		genesis_add_option_filter( 'no_html', $this->settings_field,
			array(
				'application-url',
				'company-nmls',
				'individual-nmls',
				'address',
				'phone',
				'company-selector',
				'website-type',
				'facebook-url',
				'twitter-url',
				'linkedin-url',
				'googleplus-url',
			) );
	}
	
	/**
	 * Set up Help Tab
	 * Genesis automatically looks for a help() function, and if provided uses it for the help tabs
	 * @link http://wpdevel.wordpress.com/2011/12/06/help-and-screen-api-changes-in-3-3/
	 *
	 * @since 1.0.0
	 */
	 function help() {
	 	$screen = get_current_screen();
 
		$screen->add_help_tab( array(
			'id'      => 'sample-help', 
			'title'   => 'Sample Help',
			'content' => '<p>Help content goes here.</p>',
		) );
	 }
	
	/**
	 * Register metaboxes on Child Theme Settings page
	 *
	 * @since 1.0.0
	 *
	 * @see Child_Theme_Settings::contact_information() Callback for contact information
	 */
	function metaboxes() {
		
		add_meta_box('contact-information', 'Contact Information', array( $this, 'contact_information' ), $this->pagehook, 'main', 'high');

		add_meta_box( 'website-options', 'Website Options', array( $this, 'website_options' ), $this->pagehook, 'main' );

		add_meta_box( 'social-media-accounts', 'Social Media Accounts', array( $this, 'social_media_accounts' ), $this->pagehook, 'main' );
		
	}
	
	/**
	 * Callback for Contact Information metabox
	 *
	 * @since 1.0.0
	 *
	 * @see Child_Theme_Settings::metaboxes()
	 */
	function contact_information() {
		
		echo '<p>Online Application URL:<br />';
		echo '<input type="text" name="' . $this->get_field_name( 'application-url' ) . '" id="' . $this->get_field_id( 'application-url' ) . '" value="' . esc_attr( $this->get_field_value( 'application-url' ) ) . '" size="50" />';
		echo '<p>Company NMLS:<br />';
		echo '<input type="text" name="' . $this->get_field_name( 'company-nmls' ) . '" id="' . $this->get_field_id( 'company-nmls' ) . '" value="' . esc_attr( $this->get_field_value( 'company-nmls' ) ) . '" size="50" />';
		echo '</p>';
		echo '<p>Individual NMLS:<br />';
		echo '<input type="text" name="' . $this->get_field_name( 'individual-nmls' ) . '" id="' . $this->get_field_id( 'individual-nmls' ) . '" value="' . esc_attr( $this->get_field_value( 'individual-nmls' ) ) . '" size="50" />';
		echo '</p>';
		echo '<p>Address:</p>';
		echo '<p><textarea name="' . $this->get_field_name( 'address' ) . '" cols="78" rows="8">' . esc_textarea( $this->get_field_value( 'address' ) ) . '</textarea></p>';
		echo '<p>Phone Number:<br />';
		echo '<input type="text" name="' . $this->get_field_name( 'phone' ) . '" id="' . $this->get_field_id( 'phone' ) . '" value="' . esc_attr( $this->get_field_value( 'phone' ) ) . '" size="50" />';
	}

	function website_options() {

		$current_company = $this->get_field_value( 'company_selector' ); ?>

		<p>Select your Company:<br />
			<label for="<?php echo $this->get_field_id( 'company_selector' ); ?>">Company:</label>
			<select name="<?php echo $this->get_field_name( 'company_selector' ); ?>" id="<?php echo $this->get_field_id( 'company_selector' ); ?>">
				<option value="tlc"<?php selected( $current_company, 'tlc' ); ?>>*Top Left Creative*</option>
				<option value="chl"<?php selected( $current_company, 'chl' ); ?>>Citywide Home Loans</option>
				<option value="nwmg"<?php selected( $current_company, 'nwmg' ); ?>>Northwest Mortgage Group</option>
				<option value="prmi"<?php selected( $current_company, 'prmi' ); ?>>Primary Residential Mortgage, Inc.</option>
				<option value="rhm"<?php selected( $current_company, 'rhm' ); ?>>Red Hills Mortgage</option>
			</select>
		</p>

	<?php $current_website_type = $this->get_field_value( 'website_type' ); ?>

		<p>Select the Website Type:<br />
			<label for="<?php echo $this->get_field_id( 'website_type' ); ?>">Website Type:</label>
			<select name="<?php echo $this->get_field_name( 'website_type' ); ?>" id="<?php echo $this->get_field_id( 'website_type' ); ?>">
				<option value="individual"<?php selected( $current_website_type, 'individual' ); ?>>Individual</option>
				<option value="company"<?php selected( $current_website_type, 'company' ); ?>>Company</option>
			</select>
		</p>

	<?php }

	function social_media_accounts() {
		
		echo '<p>Facebook URL:<br />';
		echo '<input type="text" name="' . $this->get_field_name( 'facebook-url' ) . '" id="' . $this->get_field_id( 'facebook-url' ) . '" value="' . esc_attr( $this->get_field_value( 'facebook-url' ) ) . '" size="50" />';
		echo '<p>Twitter URL:<br />';
		echo '<input type="text" name="' . $this->get_field_name( 'twitter-url' ) . '" id="' . $this->get_field_id( 'twitter-url' ) . '" value="' . esc_attr( $this->get_field_value( 'twitter-url' ) ) . '" size="50" />';
		echo '</p>';
		echo '<p>LinkedIn URL:<br />';
		echo '<input type="text" name="' . $this->get_field_name( 'linkedin-url' ) . '" id="' . $this->get_field_id( 'linkedin-url' ) . '" value="' . esc_attr( $this->get_field_value( 'linkedin-url' ) ) . '" size="50" />';
		echo '</p>';
		echo '<p>Google Plus URL:<br />';
		echo '<input type="text" name="' . $this->get_field_name( 'googleplus-url' ) . '" id="' . $this->get_field_id( 'googleplus-url' ) . '" value="' . esc_attr( $this->get_field_value( 'googleplus-url' ) ) . '" size="50" />';
		echo '</p>';
	}
	
}
 
 
add_action( 'genesis_admin_menu', 'be_add_child_theme_settings' );
/**
 * Add the Theme Settings Page
 *
 * @since 1.0.0
 */
function be_add_child_theme_settings() {
	global $_child_theme_settings;
	$_child_theme_settings = new Child_Theme_Settings;	 	
}