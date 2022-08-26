<?php
/**
 *
 *
 * @package WordPress
 * @since Mill 1.0.0
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>	
<body <?php body_class( 'bg-surface-light' ); ?>>
<?php wp_body_open(); ?>
<a class="visually-hidden-focusable" href="#content"><?php esc_html_e( 'Skip to content', 'mill' ); ?></a>
<div id="page">
<header id="header" class="mb-8" role="banner">
	<?php get_template_part( 'template-parts/header/navbar' ); ?>
	<?php get_template_part( 'template-parts/header/page-header' ); ?>
</header><!-- #header -->
