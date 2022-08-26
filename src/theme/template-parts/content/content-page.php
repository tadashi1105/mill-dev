<?php
/**
 *
 *
 * @package WordPress
 * @since Mill 1.0.0
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( [ 'py-6', 'px-1', 'px-sm-6', 'shadow', 'bg-surface-primary', 'rounded-4' ] ); ?>>
	<header class="mb-4">
		<?php the_title( '<h1>', '</h1>' ); ?>
	</header>
	<?php get_template_part( 'template-parts/post-thumbnail' ); ?>
	<div class="entry-content mill-typography">
		<?php the_content();
		wp_link_pages( [
			'before' => '<nav class="d-flex flex-row justify-content-center gap-2" aria-label="' . esc_attr__( 'Page', 'mill' ) . '">',
			'after'  => '</nav>',
		] ); ?>
	</div>
</article>
