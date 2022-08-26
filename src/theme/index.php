<?php
/**
 *
 *
 * @package WordPress
 * @since Mill 1.0.0
 */

get_header(); ?>
<div id="content">
	<div class="container px-1 px-md-6">
		<div class="row">
			<div class="col-lg-8">
                <main id="main" class="d-flex flex-column gap-4 mb-8" role="main">
					<?php if ( have_posts() ) : ?>
						<?php while ( have_posts() ) :
							the_post();
							get_template_part( 'template-parts/content/content-excerpt' );
						endwhile;
						the_posts_pagination();
					else :
						get_template_part( 'template-parts/content/content-none' );
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

