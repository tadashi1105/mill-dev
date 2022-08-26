<?php
/**
 * Template Name: Full width no sidebar
 *
 * @package WordPress
 * @since Mill 1.0.0
 */

get_header();
?>
<div id="content" class="site-l-content">
	<div class="site-c-container">
		<div class="site-c-row">
			<div class="site-c-col-xs-12">
				<main id="main" class="site-l-main" role="main">
					<?php if ( have_posts() ) :
						while ( have_posts() ) :
							the_post();
                            get_template_part( 'template-parts/content/content-page' );
						endwhile;
					endif; ?>
				</main><!-- .site-l-main -->
			</div>
		</div>
	</div>
</div><!-- .site-l-content -->
<?php get_footer();
