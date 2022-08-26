<?php
/**
 *
 *
 * @package WordPress
 * @since Mill 1.0.0
 */

if ( ! post_password_required() && ! is_attachment() && has_post_thumbnail() ) : ?>
	<figure id="post-thumbnail" class="mb-4">
		<?php the_post_thumbnail( 'post-thumbnail', [ 'alt' => the_title_attribute( [ 'echo' => false ] ), ] ); ?>
		<?php $mill_caption = get_post( get_post_thumbnail_id() )->post_excerpt; ?>
		<?php if ( $mill_caption ) : ?>
			<figcaption><?php echo $mill_caption; ?></figcaption>
		<?php endif; ?>
	</figure><!-- #post-thumbnail -->
<?php endif;
