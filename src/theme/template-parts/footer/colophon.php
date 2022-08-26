<?php
/**
 *
 *
 * @package WordPress
 * @since Mill 1.0.0
 */
?>
<div id="colophon" class="pb-6">
	<div class="container px-1 px-md-6">
		<?php if ( has_nav_menu( 'footer-nav' ) ) :
			wp_nav_menu( [
				'theme_location' => 'footer-nav',
				'container'      => 'nav',
				'container_id'   => 'footer-nav',
				'menu_class'     => 'nav justify-content-center',
				'link_before'    => '',
				'link_after'     => '',
				'depth'          => -1,
				'mill_li_class'  => 'nav-item',
				'mill_a_class'   => 'nav-link link-light',
			] );
		endif; ?>
		<div id="copyright">
			<p class="text-light text-center"><small>&copy; 2013-<?php echo date( 'Y' ); ?> <a class="link-light" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>. All rights reserved.</small></p>
		</div><!-- #copyright -->
	</div>
</div><!-- #colophon -->