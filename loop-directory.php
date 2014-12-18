<?php

/*
 *
 * Loop for Employee Directory
 *
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(  ); ?>>
	
	<?php

	// Add employee photo if there is one
	if( has_post_thumbnail() ) { ?>

		<div class="employee-photo">
			<a href="<?php echo the_permalink(); ?>"><?php the_post_thumbnail( 'one-third-1x1' ); ?></a>
		</div>
	
	<?php }

	// Otherwise, add a default photo
	else { ?>

		<div class="employee-photo">
			<a href="<?php echo the_permalink(); ?>"><img src="<?php echo bloginfo( 'stylesheet_directory' ); ?>/images/img_employee_default.png" /></a>
		</div>

	<?php }

	// Loop entry header ?>
	<header class="entry-header">
		<h2 class="entry-title"><a href="<?php echo the_permalink(); ?>"><?php echo the_title(); ?></a></h2>
	</header><!-- end .entry-header-->

	<?php

	// Add employee info ?>
	<ul class="employee-info">
		<?php if( has_term( '', 'title' ) ) {
			$terms = get_the_terms( $post->ID, 'title' );
			$count = count( $terms );
			if ( $count > 0 ) {
				foreach ( $terms as $term ) {
					echo '<li class="emp-title">' . $term->name . '</li>';
			    }
			}
		}
		if( get_post_meta( get_the_ID(), 'wpcf-mobile-phone', true ) ) { ?>
			<li class="emp-mobile-phone"><?php echo get_post_meta( get_the_ID(), 'wpcf-mobile-phone', true ); ?></li>
		<?php }

		// Add employee buttons ?>
		<ul class="employee-actions">
			<li class="emp-bio"><a href="<?php echo the_permalink(); ?>" class="learn-more">More info...</a></li>
			<?php if( get_post_meta( get_the_ID(), 'wpcf-online-application-link', true ) ) { ?>
				<li class="emp-apply"><a href="<?php echo get_post_meta( get_the_ID(), 'wpcf-online-application-link', true ); ?>" class="btn" target="_blank">Apply Now</a></li>
			<?php } ?>
		</ul><!-- end .employee-actions-->

	</ul><!-- end .employee-info-->

</article><!-- end .loop-entry-bg-->