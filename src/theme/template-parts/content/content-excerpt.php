<?php
/**
 *
 *
 * @package WordPress
 * @since Mill 1.0.0
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( [ 'd-flex', 'align-items-start', 'gap-6', 'p-6', 'shadow', 'bg-surface-primary', 'rounded-4' ] ); ?>>
	<div class="flex-grow-1">
		<header class="header">
			<h2 class="h6"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
		</header>
		<div class="d-none d-md-block">
			<?php the_excerpt(); ?>
		</div>
	</div>
	<?php if ( ! post_password_required() && has_post_thumbnail() ) : ?>
		<div class="flex-shrink-0">
			<a href="<?php the_permalink();?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
				<?php the_post_thumbnail( 'post-thumbnail', [
					'alt' => the_title_attribute( [ 'echo' => false ] ),
					'class' => 'rounded-4',
				] ); ?>
			</a>
		</div>
	<?php endif; ?>
</article>