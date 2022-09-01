<?php
/**
 *
 *
 * @package WordPress
 * @since Mill 1.0.0
 */

if ( is_archive() ) : ?>
	<div id="page-header">
		<div class="container py-12 gx-2 gx-sm-6 overflow-hidden">
			<?php the_archive_title( '<h1 class="display-5">', '</h1>' ); ?>
		</div>
	</div><!-- #page-header -->
<?php endif;
