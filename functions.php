<?php

/* ------------------------------------------------------------
   Theme Basics
   ------------------------------------------------------------ */

// Start the engine
require_once( get_template_directory() . '/lib/init.php' );
require_once( CHILD_DIR . '/lib/theme-js.php' );
require_once( CHILD_DIR . '/lib/options.php' );
require_once( CHILD_DIR . '/lib/shortcodes.php' );

// Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'Jennifer Mortgage Theme by Top Left Creative' );
define( 'CHILD_THEME_URL', 'http://topleftcreative.com/' );


/* ------------------------------------------------------------
   WordPress Customizations
   ------------------------------------------------------------ */

/*
 *
 * Add custom image sizes
 *
 */
add_image_size( 'one-third', 384, 256, TRUE );
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
	'legal_menu' => 'Legal Menu',
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

/*
 *
 * Add custom post types
 *
 */
require_once( get_stylesheet_directory() . '/lib/cpt/tlc_cpt_testimonials.php' );

/*
 *
 * Initialize the Metaboxes Class
 *
 */
add_action( 'init', 'tlc_initialize_cmb_meta_boxes', 9999 );
function tlc_initialize_cmb_meta_boxes() {
	if ( !class_exists( 'cmb_Meta_Box' ) ) {
		require_once( 'lib/metaboxes/init.php' );
		require_once( 'lib/tlc_metaboxes.php' );
	}
}

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

/*
 *
 * Display favicon at the root
 *
 */
add_filter( 'genesis_pre_load_favicon', 'tlc_favicon_filter' );
function tlc_favicon_filter( $favicon_url ) {
	return site_url() . '/favicon.ico';
}

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

/*
 *
 * New RoyalSlider Custom Skin
 *
 */
add_filter( 'new_royalslider_skins', 'new_royalslider_add_custom_skin', 10, 2 );
function new_royalslider_add_custom_skin( $skins ) {
      $skins['rsNaked'] = array(
           'label' => 'Custom Naked Skin',
           'path' => get_stylesheet_directory_uri() . '/lib/royalslider/skins/rs-naked.css'  // get_stylesheet_directory_uri returns path to your theme folder
      );
      return $skins;
}

/* ------------------------------------------------------------
   Layout Customizations
   ------------------------------------------------------------ */

/*
 *
 * Enqueues the correct stylesheet based on the company selected in TLC Options
 *
 */
function tlc_company_stylesheet_selector() {
	
	$company = genesis_get_option( 'company_selector', 'tlc_options' );

	wp_register_style( 'style_' . $company, get_stylesheet_directory_uri() . '/style-' . $company . '.css', '', '', 'screen' );
	wp_enqueue_style( 'style_' . $company );

}
add_action( 'wp_enqueue_scripts', 'tlc_company_stylesheet_selector' );

/*
 *
 * Add the pre-header area
 *
 */
add_action( 'genesis_before_header', 'tlc_pre_header' );
function tlc_pre_header() { ?>

	<section class="pre-header">
		<div class="wrap">
			
			<div class="pre-header-left"></div>

			<div class="pre-header-right">

				<?php

				if( genesis_get_option( 'phone', 'tlc_options' ) && genesis_get_option( 'phone_checkbox', 'tlc_options' ) ) { ?>
					
					<p class="call"><?php echo genesis_get_option( 'phone', 'tlc_options' ); ?></p>

				<?php }

				if( genesis_get_option( 'locations_page', 'tlc_options' ) ) { ?>

					<p class="locations"><a href="<?php echo genesis_get_option( 'locations_page', 'tlc_options' ); ?>">Find A Branch</a></p>

				<?php }

				if( genesis_get_option( 'facebook_url', 'tlc_options' ) || genesis_get_option( 'twitter_url', 'tlc_options' ) || genesis_get_option( 'linkedin_url', 'tlc_options' ) || genesis_get_option( 'googleplus_url', 'tlc_options' ) ) {

					echo '<div class="social-media-icons">';

					if( genesis_get_option( 'facebook_url', 'tlc_options' ) ) { ?>
						<a href="<?php echo genesis_get_option( 'facebook_url', 'tlc_options' ); ?>" target="_blank"><img src="<?php echo bloginfo( 'stylesheet_directory' ); ?>/images/logo_facebook.jpg" class="social-media-icon" /></a>
					<?php }

					if( genesis_get_option( 'twitter_url', 'tlc_options' ) ) { ?>
						<a href="<?php echo genesis_get_option( 'twitter_url', 'tlc_options' ); ?>" target="_blank"><img src="<?php echo bloginfo( 'stylesheet_directory' ); ?>/images/logo_twitter.jpg" class="social-media-icon" /></a>
					<?php }

					if( genesis_get_option( 'linkedin_url', 'tlc_options' ) ) { ?>
						<a href="<?php echo genesis_get_option( 'linkedin_url', 'tlc_options' ); ?>" target="_blank"><img src="<?php echo bloginfo( 'stylesheet_directory' ); ?>/images/logo_linkedin.jpg" class="social-media-icon" /></a>
					<?php }

					if( genesis_get_option( 'googleplus_url', 'tlc_options' ) ) { ?>
						<a href="<?php echo genesis_get_option( 'googleplus_url', 'tlc_options' ); ?>" target="_blank"><img src="<?php echo bloginfo( 'stylesheet_directory' ); ?>/images/logo_googleplus.jpg" class="social-media-icon" /></a>
					<?php }

					echo '</div><!-- end .social-media-icons-->';

				} ?>

			</div>
		</div><!-- end .wrap-->
	</section><!-- end .pre-header-->

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
	if( is_single() || is_page() ) {
		if( has_post_thumbnail() ) {
			echo '<div class="featured-image">';
			the_post_thumbnail( 'two-thirds-2x1' );
			echo '</div><!-- end .featured-image-->';
		}
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
			<?php echo do_shortcode( get_post_meta( $post->ID, 'wpcf-entry-sidebar-content', true ) ); ?>
		</section><!-- end .widget-->
	</aside><!-- end .sidebar-entry-->
	<aside class="sidebar-entry">
		<?php dynamic_sidebar( 'entry-with-sidebar' ); ?>
	</aside><!-- end .sidebar-entry-->
	
	<?php }
}

/*
 *
 * Automatically select the Legal Menu for the legal_menu location
 *
 */
$locations = get_theme_mod( 'nav_menu_locations' );
$things = wp_get_nav_menus();
if( $things ) {
	foreach( $things as $thing ) {
		if( $thing->name == 'Legal Menu' ) {
			$locations['legal_menu'] = $thing->term_id;
		}
	}
}
set_theme_mod( 'nav_menu_locations', $locations ); // set menus to locations

/*
 *
 * Customize the footer credits
 *
 */
add_filter( 'genesis_footer_creds_text', 'custom_footer_creds_text' );
function custom_footer_creds_text() { ?>
	<img src="<?php echo bloginfo( 'stylesheet_directory' ); ?>/images/logo_eho.png" class="icon-eho" alt="Equal Housing Opportunity" />
	<div class="creds">
		<p>Copyright &copy; <?php echo date('Y') ?> &middot; <a href="<?php echo bloginfo( 'url' ); ?>"><?php echo bloginfo( 'name' ) ?></a> &middot; Corporate NMLS #<?php echo genesis_get_option( 'company_nmls', 'tlc_options' ); ?>
			<?php if( genesis_get_option( 'website_type', 'tlc_options') == 'individual' ) {
				echo ' &middot; Individual NMLS #' . genesis_get_option( 'individual_nmls', 'tlc_options' );
			} ?>
		</p>
		<?php if( genesis_get_option( 'disclaimer', 'tlc_options' ) ) {
			echo '<p class="disclaimer">' . genesis_get_option( 'disclaimer', 'tlc_options' ) . '</p>';
		}
		wp_nav_menu( array( 'theme_location' => 'legal-menu', 'menu_class' => 'legal-menu', 'container_class' => 'legal-menu-container' ) ); ?>
	</div><!-- end .creds-->
	<div class="plug">
		<p>Fully-Managed <a href="http://topleftcreative.com" target="_blank">Mortgage Websites</a> by Top Left Creative</p>
	</div>
<?php } ?>