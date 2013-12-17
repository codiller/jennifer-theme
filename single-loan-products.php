<?php
/*
 *
 * Template for Single Loan Products
 *
 */

/*
 *
 * Add Previous & Next Post Links
 *
 */
add_action( 'genesis_entry_header', 'tlc_post_links' );
function tlc_post_links() {
	
	echo '<nav class="entry-links">';

	// Add previous post link
	if( get_previous_post() ) :
    	echo previous_post_link('<div class="link-prev">%link : Previous</div>');
	endif;

	// Add next post link
	if( get_next_post() ) :
    	echo next_post_link('<div class="link-next">Next : %link</div>');
	endif;

	echo '</nav><!-- end .entry-links-->';
	
}

/*
 *
 * Remove Post and Meta Info
 *
 */
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

/*
 *
 * Remove Genesis Sidebar
 *
 */
remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );

/*
 *
 * Add loan comparison table
 *
 */
add_action( 'genesis_sidebar', 'tlc_products_sidebar_entry', 4 );
function tlc_products_sidebar_entry() {
	
	// Grab the $post global variable in case we're outside the loop
	global $post; 

	// Save a bunch of Types plugin custom fields as variables to use in our code below
	$down_payment = types_render_field( "down-payment", array( "id" => "$post->ID" ) );
	$down_payment_description = types_render_field( "down-payment-description", array( "id" => "$post->ID" ) );
	$terms = types_render_field( "terms", array( "id" => "$post->ID", "separator" => ", " ) );
	$terms_description = types_render_field( "terms-description", array( "id" => "$post->ID", "separator" => " and " ) );
	$credit_score = types_render_field( "credit-score", array( "id" => "$post->ID" ) );
	$credit_score_description = types_render_field( "credit-score-description", array( "id" => "$post->ID" ) );
	$mortgage_insurance = types_render_field( "mortgage-insurance", array( "id" => "$post->ID" ) );
	$mortgage_insurance_description = types_render_field( "mortgage-insurance-description", array( "id" => "$post->ID" ) );
	$maximum_loan_amount = types_render_field( "maximum-loan-amount", array( "id" => "$post->ID" ) );
	$maximum_loan_amount_description = types_render_field( "maximum-loan-amount-description", array( "id" => "$post->ID" ) );
	
	?>


	<aside class="sidebar-entry">
		<section class="widget">
			
			<p><a class="btn-sm" href="<?php echo site_url(); ?>/apply-now">Apply Now!</a></p>
			
			<div class="loan-comp-table">
				
				<div class="loan-comp-item">
					<h4>DOWN PAYMENT</h4>
					<p class="large"><?php echo $down_payment; ?>%</p>
					<p><?php echo $down_payment_description; ?></p>
				</div>
				
				<div class="loan-comp-item">
					<h4>TERMS</h4>
					<p class="large"><?php echo $terms; ?></p>
					<p>years, <?php echo $terms_description; ?></p>
				</div>
				
				<div class="loan-comp-item">
					<h4>CREDIT SCORE</h4>
					<p class="large"><?php echo $credit_score; ?></p>
					<p><?php echo $credit_score_description; ?></p>
				</div>
				
				<div class="loan-comp-item">
					<h4>MORTGAGE INSURANCE</h4>
					<p class="large"><?php echo $mortgage_insurance; ?></p>
					<p><?php echo $mortgage_insurance_description; ?></p>
				</div>
				
				<div class="loan-comp-item">
					<h4>MAXIMUM LOAN AMOUNT</h4>
					<p class="large"><?php echo $maximum_loan_amount; ?></p>
					<p><?php echo $maximum_loan_amount_description; ?></p>
				</div>
			
			</div><!-- end .loan-comp-table-->
		
		</section><!-- end .widget-->
	</aside><!-- end .sidebar-entry-->
	
<?php }

genesis();

?>