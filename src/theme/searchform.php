<?php
/**
 *
 *
 * @package WordPress
 * @since Mill 1.0.0
 */
?>
<form role="search" method="get" class="d-inline-flex" action="<?php echo esc_url(home_url( '/' ) ); ?>">
	<input type="search" class="form-control me-2" placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'mill' ); ?>" value="<?php echo get_search_query(); ?>" name="s" title="<?php echo esc_attr_x( 'Search for:', 'label', 'mill' ); ?>" aria-label="<?php echo esc_attr_x( 'Search for:', 'label', 'mill' ); ?>">
	<input type="submit" class="btn btn-primary" value="<?php echo esc_attr_x( 'Search', 'submit button', 'mill' ) ?>">
</form>