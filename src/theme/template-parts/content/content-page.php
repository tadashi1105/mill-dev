<?php
/**
 *
 *
 * @package WordPress
 * @since Mill 1.0.0
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( [ 'p-2', 'p-sm-6', 'shadow', 'bg-surface-primary', 'rounded-4' ] ); ?>>
	<header class="mb-4">
		<?php the_title( '<h1 class="h2 text-break>', '</h1>' ); ?>
	</header>
	<div class="mb-4">
		<?php get_template_part( 'template-parts/post-thumbnail' ); ?>
	</div>
	<div class="entry-content mill-typography">
		<?php the_content();
		wp_link_pages( [
			'before' => '<nav class="d-flex flex-row justify-content-center gap-2" aria-label="' . esc_attr__( __( 'Pages:' ) ) . '">',
			'after'  => '</nav>',
		] ); ?>
	</div>
</article>
