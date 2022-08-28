<?php
/**
 *
 *
 * @package WordPress
 * @since Mill 1.0.0
 */

if ( ! post_password_required() && ! is_attachment() && has_post_thumbnail() ) : ?>
	<figure id="post-thumbnail">
		<?php the_post_thumbnail( 'post-thumbnail', [
			'alt' => the_title_attribute( [ 'echo' => false ] ),
			'class' => 'rounded-4',
		] ); ?>
		<?php if ( is_singular() ) : ?>
			<?php $mill_caption = get_post( get_post_thumbnail_id() )->post_excerpt; ?>
			<?php if ( $mill_caption ) : ?>
				<figcaption><?php echo $mill_caption; ?></figcaption>
			<?php endif; ?>
		<?php endif; ?>
	</figure><!-- #post-thumbnail -->
<?php endif;
