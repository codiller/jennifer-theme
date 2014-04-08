<?php

/*
 *
 * Force Genesis Full-Width Layout
 *
 */
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

/*
 *
 * Remove Genesis Sidebar
 *
 */
remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );
remove_action( 'genesis_after_content', 'genesis_get_sidebar' );

/*
 *
 * Add Home Feature Widget Area
 *
 */
add_action( 'genesis_after_header', 'tlc_home_feature');
function tlc_home_feature() {
	
	echo '<div class="home-feature">';
	
	dynamic_sidebar( 'home-feature' );

	echo '</div><!-- end .home-feature-->';

}

/*
 *
 * Add Home Tabs Area
 *
 */
add_action( 'genesis_after_header', 'tlc_home_tabs' );
function tlc_home_tabs() { ?>

	<section class="home-tabs">
		<div class="wrap">
			<div id="tabs">
				<ul class="resp-tabs-list">
					<li>
						<h2>Purchase</h2>
						<p>Buying a home? Learn more about the process here.</p>
					</li>
					<li>
						<h2>Refinance</h2>
						<p>Interested in lowering your monthly payment? Learn about refinancing.</p>
					</li>
					<li>
						<h2>Apply Now</h2>
						<p>Ready to get started? Begin the home loan process online right now.</p>
					</li>
				</ul> 
				<div class="resp-tabs-container">
					<div class="tab-content">
						<?php dynamic_sidebar( 'tab-one' ); ?>
					</div><!-- end .content-->
					<div class="tab-content">
						<?php dynamic_sidebar( 'tab-two' ); ?>
					</div><!-- end .content-->
					<div class="tab-content">
						<?php dynamic_sidebar( 'tab-three' ); ?>
					</div><!-- end .content-->
				</div><!-- end .tab-->
			</div><!-- end .tabs-->
		</div><!-- end .wrap-->
	</section><!-- end .home-tabs-->
<?php }

/*
 *
 * Remove Standard Genesis Loop
 *
 */
remove_action( 'genesis_loop', 'genesis_do_loop' );

/*
 *
 * Add Home Loop Area
 *
 */
add_action( 'genesis_before_loop', 'tlc_home_loop' );
function tlc_home_loop() {

	// Only show this section if the checkbox to include the blogroll on the homepage is checked.
	if( genesis_get_option( 'include_homepage_blog', 'tlc_options' ) ) {

		remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
		remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

		// Adds section
		echo '<section class="home-loop">';
		
		// Adds section title
		echo '<h1 class="section-title">From The Blog</h1>';

		// Adds article container (needed for :nth-child)
		echo '<div class="entries">';
		
		// If altering the main wp_query, use this so WordPress knows which page it's on. Read here: https://codex.wordpress.org/Pagination
		$paged = get_query_var( paged );

		// Loop arguments
		$args=array(
			'posts_per_page' => 3,
			'paged' => $paged
		);
		genesis_custom_loop( $args );

		// Closes article container
		echo '</div><!-- end .entries-->';

		// Closes section
		echo '</section><!-- end .home-loop-->';

	}

}

genesis();

?>