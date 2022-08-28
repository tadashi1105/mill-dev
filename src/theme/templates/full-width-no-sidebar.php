<?php
/**
 * Template Name: Full width no sidebar
 *
 * @package WordPress
 * @since Mill 1.0.0
 */

get_header();
?>
<div id="content">
	<div class="container">
		<div class="row">
			<div class="col">
				<main id="main" class="d-flex flex-column gap-4 mb-8" role="main">
					<?php if ( have_posts() ) :
						while ( have_posts() ) :
							the_post();
                            get_template_part( 'template-parts/content/content-page' );
						endwhile;
					endif; ?>
				</main><!-- #main -->
			</div>
		</div>
	</div>
</div><!-- #content -->
<?php get_footer();
