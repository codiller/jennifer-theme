<?php

/*
 *
 * Replace Primary Sidebar with Blog Sidebar on a Single Post
 *
 */
add_action( 'genesis_sidebar', 'tlc_blog_sidebar', 4 );
function tlc_blog_sidebar() {
	
	global $post;
	
	remove_action( 'genesis_sidebar', 'genesis_do_sidebar' ); ?>
	
	<aside class="sidebar-entry">
		<?php dynamic_sidebar( 'blog-sidebar' ); ?>
	</aside><!-- end .sidebar-entry-->
	
<?php }

genesis();

?>