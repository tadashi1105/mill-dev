<?php
/**
 *
 *
 * @package WordPress
 * @since Mill 1.0.0
 */

get_header();
?>
<div id="content">
	<div class="container px-1 px-md-6">
		<div class="row">
			<div class="col-lg-8">
				<main id="main" class="d-flex flex-column gap-4 mb-8" role="main">
					<?php if ( have_posts() ) :
						while ( have_posts() ) :
							the_post();
							if ( is_page() ) :
								get_template_part( 'template-parts/content/content-page' );
							else :
								get_template_part( 'template-parts/content/content-single' );
								the_post_navigation( [
									'next_text' => '<p class="small">' . esc_html__( 'Next post', 'mill' ) . '</p><p class="text-truncate">%title</p>',
									'prev_text' => '<p class="small">' . esc_html__( 'Previous post', 'mill' ) . '</p><p class="text-truncate">%title</p>',
								] );
							endif;
						endwhile;

						if ( comments_open() || get_comments_number() ) :
							comments_template();
						endif;
					endif; ?>
				</main><!-- #main -->
			</div>
			<div class="col-lg-4">
				<div id="secondary" class="mb-8" role="complementary">
					<?php get_sidebar(); ?>
				</div><!-- #secondary -->
			</div>
		</div>
	</div>
</div><!-- #content -->
<?php get_footer();
