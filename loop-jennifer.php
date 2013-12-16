<?php

/*
 *
 * Standard Theme Loop
 *
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'loop-entry' ); ?>>
	
	<header class="entry-header">
		<div class="featured-image">
			<a href="<?php echo the_permalink(); ?>"><?php echo the_post_thumbnail(); ?></a>
		</div><!-- end .featured-image-->
		<h2 class="entry-title"><a href="<?php echo the_permalink(); ?>"><?php echo the_title(); ?></a></h2>
	</header><!-- end .entry-header-->
	
	<?php do_action( 'genesis_before_entry_content' ); ?>
	
	<div class="entry-content"><?php echo the_excerpt(); ?></div><!-- end .entry-content-->
	
	<div class="more-link"><a href="<?php echo the_permalink(); ?>">Read more...</a></div><!-- end .more-link-->
	
</article>