<?php
/**
 *
 *
 * @since Mill 1.0.0
 */

/**
 * Set up
 *
 * @since Mill 1.0.0
 */
function mill_parent_theme_setup() {
	$mill = new Mill_Configuration();
}
add_action( 'after_setup_theme', 'mill_parent_theme_setup', 99999 );

/**
 *
 *
 * @since Mill 1.0.0
 */
class Mill_Configuration {

	/**
	 * __construct
	 *
	 * @since Mill 1.0.0
	 */
	public function __construct() {
		global $content_width;
		if ( ! isset( $content_width ) ) {
			$content_width = apply_filters( 'mill_content_width', 1360 );
		}

		load_theme_textdomain( 'mill', get_template_directory() . '/languages' );

		add_editor_style();
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );

		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 1360, 9999 );

		add_theme_support( 'html5', [
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption'
		] );

		add_theme_support( 'menu' );
		register_nav_menus( [
			'footer-nav' => __( 'Footer Navigation', 'mill' ),
		] );

		add_action( 'widgets_init', [ $this, 'register_sidebar' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'wp_enqueue_scripts' ] );
	}

	/**
	 * Register widget area
	 *
	 * @since Mill 1.0.0
	 */
	public function register_sidebar() {

		register_sidebar( [
			'name'          => esc_html__( 'Sidebar Widgets', 'mill' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Main sidebar that appears on the right.', 'mill' ),
			'before_sidebar' => '<div id="%1$s" class="d-flex flex-column gap-4 %2$s">',
			'after_sidebar'  => '</div>',
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		] );
			
		register_sidebar( [
			'name'          => esc_html__( 'Main Bottom Widgets', 'mill' ),
			'id'            => 'sidebar-2',
			'description'   => esc_html__( 'Main bottom sidebar that appears on the bottom.', 'mill' ),
			'before_sidebar' => '<div id="%1$s" class="d-flex flex-column gap-4 %2$s">',
			'after_sidebar'  => '</div>',
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		] );

	}

	/**
	 * Enqueue CSS and JavaScript
	 *
	 * @since Mill 1.0.0
	 */
	public function wp_enqueue_scripts() {
		if ( is_admin() ) {
			return;
		}

		$version = wp_get_theme()->get( 'Version' );

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		wp_enqueue_style( 'style', get_stylesheet_uri() );

		// wp_enqueue_script('header-js', get_template_directory_uri() . '/js/header-bundle.js', null, $version, false);
		// wp_enqueue_script('footer-js', get_template_directory_uri() . '/js/footer-bundle.js', null, $version, true);
	}
}
