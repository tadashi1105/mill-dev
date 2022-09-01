<?php
/**
 *
 *
 * @package WordPress
 * @since Mill 1.0.0
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( [ 'd-flex', 'align-items-start', 'gap-2', 'gap-sm-6', 'p-2', 'p-sm-6', 'shadow', 'bg-surface-primary', 'rounded-4', 'position-relative' ] ); ?>>
	<?php if ( ! post_password_required() && has_post_thumbnail() ) : ?>
		<div class="flex-shrink-0">
			<a href="<?php the_permalink();?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
				<?php get_template_part( 'template-parts/post-thumbnail' ); ?>
			</a>
		</div>
	<?php endif; ?>
	<div class="flex-grow-1">
		<header class="header">
			<div class="d-none d-sm-block mb-2">
				<?php wp_list_categories( [
					'depth'              => 1,
					'separator'          => '',
					'show_option_none'   => __( 'No categories' ),
					'style'              => 'mill-badge',
					'taxonomy'           => 'category',
					'title_li'           => '',
					'number' => 1,
					'include' => (function () use ( $post ) {
						$post_terms = wp_get_object_terms( $post->ID, 'category', array( 'fields' => 'ids' ) );
						$term_ids = '';
						if ( !empty( $post_terms ) && !is_wp_error( $post_terms ) ) {
								$term_ids = implode( ',' , $post_terms );
						}
						return $term_ids;
					})(),
				] ); ?>
			</div>
			<h2 class="h5 text-break"><a class="h5" href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
		</header>
		<div class="d-none d-sm-block">
			<a class="text-body text-sm" href="<?php the_permalink(); ?>" rel="bookmark">
				<?php the_excerpt(); ?>
			</a>
			<?php
			// Author
			printf(
				'<p class="text-sm mt-2">%1$s<a class="link-dark opacity-60" href="%2$s" rel="author">%3$s</a>%4$s</p>',
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
		</div>
	</div>
</article>
