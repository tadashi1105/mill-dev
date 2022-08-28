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
		<?php the_title( '<h1 class="h2 text-break">', '</h1>' ); ?>
		<?php
			// Author
			printf(
				'<p class="small mt-2">%1$s<a class="link-dark opacity-60" href="%2$s" rel="author">%3$s</a>%4$s</p>',
				esc_html__( 'By ', 'mill' ),
				esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
				esc_html( get_the_author() ),
				// Posted on
				sprintf(
					'<span class="mx-2">·</span><time class="entry-date published %2$s" datetime="%3$s" aria-label="%1$s">%4$s</time>%5$s',
					esc_html__( 'Published', 'mill' ),
					(get_the_time( 'U' ) === get_the_modified_time( 'U' )) ? 'updated' : '', 
					esc_attr( get_the_date( 'c' ) ),
					esc_html( get_the_date() ),
					(function () {
						$updated = '';
						if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
							$updated = sprintf(
								'<span class="mx-1">/</span><time class="entry-date updated" datetime="%2$s" aria-label="%1$s">%3$s</time>',
								esc_html__( 'Updated', 'mill' ),
								esc_attr( get_the_modified_date( 'c' ) ),
								esc_html( get_the_modified_date() ),
							);
						}
						return $updated;
					})(),
				),
			);
			?>
	</header>
	<div class="mb-4">
		<?php get_template_part( 'template-parts/post-thumbnail' ); ?>
	</div>
	<div class="entry-content mill-typography mb-4">
		<?php the_content();
		wp_link_pages( [
			'before' => '<nav class="d-flex flex-row justify-content-center gap-2" aria-label="' . esc_attr__( __( 'Pages:' ) ) . '">',
			'after'  => '</nav>',
		] ); ?>
	</div>
	<footer class="d-flex flex-column gap-2">
		<div class="d-flex flex-row">
			<div class="flex-shrink-0 me-1">
				<span class="text-dark opacity-60"><?php _e( 'Categories' ) ?>:</span>
			</div>
			<div class="flex-grow-1">
				<?php the_category( '<span class="text-dark opacity-60">, </span>' ); ?>
			</div>
		</div>
		<div class="d-flex flex-row flex-wrap gap-1">
			<?php the_tags( '', '' ); ?>
		</div>
	</footer>
</article>
<?php
get_template_part( 'template-parts/primary/widgets' );
