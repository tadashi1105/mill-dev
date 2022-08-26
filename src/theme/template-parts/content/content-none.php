<?php
/**
 *
 *
 * @package WordPress
 * @since Mill 1.0.0
 */
?>
<section class="no-results not-found">
	<h1><?php esc_html_e( 'Nothing Found', 'mill' ); ?></h1>
	<p class="mb-4">
	<?php if ( is_home() && current_user_can( 'publish_posts' ) ) :
		printf(
			wp_kses(
				__( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'mill' ),
				[ 'a' => [ 'href' => [] ] ]
			),
			esc_url( admin_url( 'post-new.php' ) )
		);
	elseif ( is_search() ) :
		esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'mill' );
	else :
		esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'mill' );
	endif; ?>
	</p>
	<?php get_search_form(); ?>
</section>
