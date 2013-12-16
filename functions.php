<?php

/* ------------------------------------------------------------
   Theme Basics
   ------------------------------------------------------------ */

// Start the engine
require_once( get_template_directory() . '/lib/init.php' );
require_once( CHILD_DIR.'/lib/theme-js.php' );

// Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'Jennifer Mortgage Theme (v1.6) by Top Left Creative Inc.' );
define( 'CHILD_THEME_URL', 'http://topleftcreative.com/' );

/* ------------------------------------------------------------
   WordPress Customizations
   ------------------------------------------------------------ */

/*
 *
 * Add custom image sizes
 *
 */
add_image_size( 'one-third-2x1', 368, 184, TRUE );
add_image_size( 'one-third-1x1', 368, 368, TRUE );
add_image_size( 'two-thirds-2x1', 768, 384, TRUE );
add_image_size( 'one-half-2x1', 576, 288, TRUE );
add_image_size( 'one-half-1x1', 576, 576, TRUE );

/*
 *
 * Register new menu location(s)
 *
 */
register_nav_menus( array(
	'legal-menu' => 'Legal Menu',
) );

/*
 *
 * Register new sidebar(s)
 *
 */
genesis_register_sidebar( array(
	'id' => 'home-feature',
	'name' => 'Home Feature',
) );
genesis_register_sidebar( array(
	'id' => 'tab-one',
	'name' => 'Home Tab One',
) );
genesis_register_sidebar( array(
	'id' => 'tab-two',
	'name' => 'Home Tab Two',
) );
genesis_register_sidebar( array(
	'id' => 'tab-three',
	'name' => 'Home Tab Three',
) );
genesis_register_sidebar( array(
	'id' => 'entry-with-sidebar',
	'name' => 'Entry With Sidebar',
) );

/*
 *
 * Add support for css stylings in the wysiwyg editor
 *
 */
add_editor_style( 'editor-style.css' );

/*
 *
 * Add the 'excerpt' meta box on 'pages' post type
 *
 */
add_post_type_support('page', 'excerpt');

/*
 *
 * Remove the (edit) link from the front-end when logged in
 *
 */
add_filter ( 'genesis_edit_post_link' , '__return_false' );

/* ------------------------------------------------------------
   Genesis Customizations
   ------------------------------------------------------------ */

/*
 *
 * Add HTML5 Markup Structure
 *
 */
add_theme_support( 'html5' );

/*
 *
 * Add custom Viewport meta tag for mobile browsers
 *
 */
add_theme_support( 'genesis-responsive-viewport' );

/*
 *
 * Add structural .wrap to 'inner'
 *
 */
add_theme_support( 'genesis-structural-wraps', array( 'header', 'nav', 'subnav', 'inner', 'footer-widgets', 'footer' ) );

/*
 *
 * Add genesis support for footer widgets
 *
 */
add_theme_support( 'genesis-footer-widgets', 3 );

/* ------------------------------------------------------------
   Plugin Customizations
   ------------------------------------------------------------ */

/*
 *
 * Add placeholder text in GravityForms
 *
 */
add_action("gform_field_standard_settings", "jtd_gform_placeholders", 10, 2);
function jtd_gform_placeholders($position, $form_id){
	// Create settings on position 25 (right after Field Label)
	if ( $position == 25 ) {
	?>
	<li class="admin_label_setting field_setting" style="display: list-item; ">
		<label for="field_placeholder">Placeholder Text
		<!-- Tooltip to help users understand what this field does -->
		<a href="javascript:void(0);" class="tooltip tooltip_form_field_placeholder" tooltip="<h6>Placeholder</h6>Enter the placeholder/default text for this field.">(?)</a>
		</label>
		<input type="text" id="field_placeholder" class="fieldwidth-3" size="35" onkeyup="SetFieldProperty('placeholder', this.value);">
	</li>
	<?php
	}
}
/* Now we execute some javascript technicalities for the field to load correctly */
add_action("gform_editor_js", "jtd_gform_editor_js");
function jtd_gform_editor_js(){
?>
	<script>
	//binding to the load field settings event to initialize the checkbox
	jQuery(document).bind("gform_load_field_settings", function(event, field, form){
		jQuery("#field_placeholder").val(field["placeholder"]);
	});
	</script>
<?php
}
/* We use jQuery to read the placeholder value and inject it to its field */
add_action('gform_pre_render',"jtd_gform_init_scripts", 10, 2);
function jtd_gform_init_scripts( $form ) {
	$script = "";
	/* Go through each one of the form fields */
	foreach($form['fields'] as $i=>$field) {
		/* Check if the field has an assigned placeholder */
		if(isset($field['placeholder']) && !empty($field['placeholder'])){
			/* If a placeholder text exists, inject it as a new property to the field using jQuery */
			$script .= "jQuery('#input_{$form['id']}_{$field['id']}').attr('placeholder','{$field['placeholder']}');";
		}
	}
	GFFormDisplay::add_init_script($form["id"], 'jtd_placeholder', GFFormDisplay::ON_PAGE_RENDER, $script);
	return $form;
}

/* ------------------------------------------------------------
   Layout Customizations
   ------------------------------------------------------------ */

/*
 *
 * Add the script to change the stylesheet using the theme chooser (NOTE: REMOVE THIS WHEN YOU INSTALL ON A CLIENT SITE)
 *
 */
function tlc_add_theme_switcher() {
	wp_register_style( 'style_prmi', get_stylesheet_directory_uri() . '/style-prmi.css' );
	wp_register_style( 'style_nwmg', get_stylesheet_directory_uri() . '/style-nwmg.css' );
	wp_register_style( 'style_chl', get_stylesheet_directory_uri() . '/style-chl.css' );
	wp_register_script( 'alternate_stylesheet', get_stylesheet_directory_uri() . '/lib/js/styleswitcher.js' );
	wp_enqueue_style( 'style_prmi' );
	wp_enqueue_style( 'style_nwmg' );
	wp_enqueue_style( 'style_chl' );
	wp_enqueue_script( 'alternate_stylesheet' );
	global $wp_styles;
	$wp_styles->add_data( 'style_prmi', 'title', 'style_prmi' );
	$wp_styles->add_data( 'style_nwmg', 'title', 'style_nwmg' );
	$wp_styles->add_data( 'style_chl', 'title', 'style_chl' );
	$handle  = defined( 'CHILD_THEME_NAME' ) && CHILD_THEME_NAME ? sanitize_title_with_dashes( CHILD_THEME_NAME ) : 'child-theme';
	$wp_styles->add_data( $handle, 'title', 'default_child_theme' );
}
add_action( 'wp_enqueue_scripts', 'tlc_add_theme_switcher' );

/*
 *
 * Add the alternate theme chooser (NOTE: REMOVE THIS WHEN YOU INSTALL ON A CLIENT SITE)
 *
 */
add_action( 'genesis_before_header', 'tlc_theme_chooser' );
function tlc_theme_chooser() { ?>
	<div class="theme-chooser">
		<p>Choose Your Company:</p>
		<form>
			<select name="choose-company" id="choose-company" onchange="getval(this);">
				<option value="">Choose Your Company...</option>
				<option value="default_child_theme">Top Left Creative</option>
				<option value="style_prmi">Primary Residential Mortgage, Inc.</option>
				<option value="style_nwmg">Northwest Mortgage Group</option>
				<option value="style_chl">CityWide Home Loans</option>
			</select>
			<script>
				function getval( sel ) {
					setActiveStyleSheet( sel.value );
					setCookie( 'choose-company', this.value );
					return false;
				}
			</script>
		</form>
	</div>
<?php }

/*
 *
 * Add the mobile menu button for mobile dropdown menu
 *
 */
add_action( 'genesis_header_right', 'prefix_mobile_menu_toggle', 5 );
function prefix_mobile_menu_toggle() { ?>
	<div class="menu-toggle">
		<span><a href="#"><img src="<?php echo bloginfo( 'stylesheet_directory' ); ?>/images/icon_menu_icon.png" /></a></span>
	</div>
<?php }

/*
 *
 * Make the posts_per_page match what we query below so pagination works. Found here: http://wordpress.org/support/topic/plugin-genesis-featured-widget-amplified-older-posts-not-working?replies=12
 *
 */
add_action( 'pre_get_posts', 'tlc_change_query' );
function tlc_change_query( $query ) {
	
	if( $query->is_main_query() && $query->is_home() ) {
		$query->set( 'posts_per_page', '3' );
	}

}

/*
 *
 * Move the featured image above the title
 *
 */
remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
add_action( 'genesis_entry_header', 'genesis_do_post_image', 5 );

/*
 *
 * Add the featured image to the top of every page, with exception
 *
 */
add_action( 'genesis_entry_header', 'tlc_featured_image', 5 );
function tlc_featured_image() {
	if( is_page() || is_single() && has_post_thumbnail() ) {
		echo '<div class="featured-image">' . the_post_thumbnail( 'two-thirds-2x1' ) . '</div><!-- end .featured-image-->';
	}
}

/*
 *
 * Add the read more link to the entry footer of homepage entries & archive entries
 *
 */
add_action( 'genesis_entry_footer', 'tlc_read_more' );
function tlc_read_more() {
	if( is_home() || is_archive() ) {
		echo '<a href="' . get_permalink() . '">Read more...</a>';
	}
}

/*
 *
 * Replace the_excerpt() .more-link
 *
 */
add_action( 'gfwa_after_post_content', 'tlc_gwfa_read_more' );
function tlc_gwfa_read_more() {
	echo '<a href="' . get_permalink() . '" class="more-link">Learn More</a>';
}

/*
 *
 * Replace default genesis_sidebar if "entry sidebar content" custom field is present
 *
 */
add_action( 'genesis_sidebar', 'tlc_sidebar_entry', 4 );
function tlc_sidebar_entry() {
	global $post;
	if( get_post_meta( $post->ID, 'wpcf-entry-sidebar-content', true ) ) {
	remove_action( 'genesis_sidebar', 'genesis_do_sidebar' ); ?>
	<aside class="sidebar-entry">
		<section class="widget">
			<?php echo get_post_meta( $post->ID, 'wpcf-entry-sidebar-content', true ); ?>
		</section><!-- end .widget-->
	</aside><!-- end .sidebar-entry-->
	<aside class="sidebar-entry">
		<?php dynamic_sidebar( 'entry-with-sidebar' ); ?>
	</aside><!-- end .sidebar-entry-->
	
	<?php }
}

/*
 *
 * Customize the footer credits
 *
 */
add_filter( 'genesis_footer_creds_text', 'custom_footer_creds_text' );
function custom_footer_creds_text() { ?>
	<img src="<?php echo bloginfo( 'stylesheet_directory' ); ?>/images/logo_eho.png" class="icon-eho" />
	<div class="creds">
		<p>Copyright &copy; 2008-<?php echo date('Y') ?> &middot; <a href="<?php echo bloginfo( 'url' ); ?>"><?php echo bloginfo( 'name' ) ?></a> &middot; Corporate NMLS# 12345</p>
		<?php wp_nav_menu( array( 'theme_location' => 'legal-menu', 'menu_class' => 'legal-menu', 'container_class' => 'legal-menu-container' ) ); ?>
	</div><!-- end .creds-->
	<div class="plug">
		<p>Fully-Managed <a href="http://topleftcreative.com" target="_blank">Mortgage Websites</a> by Top Left Creative</p>
	</div>
<?php } ?>