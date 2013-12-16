<?php
/*
 *
 * Template for Single Employees
 *
 */

/*
 *
 * Remove Post and Meta Info
 *
 */
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
remove_action( 'genesis_entry_header', 'tlc_featured_image', 5 );

/*
 *
 * Add Custom Fields Below Entry Header
 *
 */
add_action( 'genesis_entry_header', 'tlc_employee_header' );
function tlc_employee_header() {

	// Add employee name ?>
	<h2 class="entry-subtitle"><?php echo get_post_meta( get_the_ID(), 'wpcf-title', true ); ?></h2><!-- end .entry-subtitle-->
	
	<?php 
	// Add employee actions, if licensed
	if( get_post_meta( get_the_ID(), 'wpcf-licensed-to-originate', true) ) { ?>
		<ul class="employee-actions">
			<li class="emp-nmls">NMLS #: <?php echo get_post_meta( get_the_ID(), 'wpcf-nmls', true ); ?></li>
			<li class="apply"><a href="<?php echo get_post_meta( get_the_ID(), 'wpcf-online-application-link', true ); ?>" target="_blank">Apply Now</a></li>
			<li class="emp-callbox">Call Me: <?php echo get_post_meta( get_the_ID(), 'wpcf-mobile-phone', true ); ?></li>
		</ul><!-- end .employee-actions-->
	<?php }
	
	}

/*
 *
 * Remove Genesis Sidebar and Adds Sidebar with Custom Fields
 *
 */
remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );
add_action( 'genesis_sidebar', 'tlc_employee_sidebar' );
function tlc_employee_sidebar() {

	// Add employee photo if there is one
	if( has_post_thumbnail() ) {

		echo '<div class="employee-photo">';
		the_post_thumbnail( 'employee' );
		echo '</div><!-- end .employee-photo-->';
	}

	// Otherwise, add a default photo
	else { ?>

		<div class="employee-photo">
			<a href="<?php echo the_permalink(); ?>"><img src="<?php echo bloginfo( 'stylesheet_directory' ); ?>/images/img_employee_default.png" /></a>
		</div>

	<?php } ?>

	<ul class="employee-info">

		<?php if( get_post_meta( get_the_ID(), 'wpcf-main-phone', true ) ) { ?>
			<li class="emp-main-phone">Main Phone: <?php echo get_post_meta( get_the_ID(), 'wpcf-main-phone', true ); ?></li>
		<?php }

		if( get_post_meta( get_the_ID(), 'wpcf-mobile-phone', true ) ) { ?>
			<li class="emp-mobile-phone">Mobile Phone: <?php echo get_post_meta( get_the_ID(), 'wpcf-mobile-phone', true ); ?></li>
		<?php }

		if( get_post_meta( get_the_ID(), 'wpcf-fax', true ) ) { ?>
			<li class="emp-fax">Fax: <?php echo get_post_meta( get_the_ID(), 'wpcf-fax', true ); ?></li>
		<?php }

		if( get_post_meta( get_the_ID(), 'wpcf-website', true ) ) { ?>
			<li class="emp-website">Website: <a href="<?php echo get_post_meta( get_the_ID(), 'wpcf-website', true ); ?>" target="_blank">Visit Website</a></li>
		<?php } ?>
	</ul><!-- end .employee-info-->
	
<?php }

genesis();

?>