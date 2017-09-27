<?php
/**
 * LifeBegan functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package LifeBegan
 */

if ( ! function_exists( 'lifebegan_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function lifebegan_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on LifeBegan, use a find and replace
		 * to change 'lifebegan' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'lifebegan', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in two locations.
		register_nav_menus( array(
			'header' => esc_html__( 'Header', 'lifebegan' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'lifebegan_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'lifebegan_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function lifebegan_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'lifebegan_content_width', 640 );
}
add_action( 'after_setup_theme', 'lifebegan_content_width', 0 );

/**
 * Add preconnect for Google Fonts.
 *
 * @since LifeBegan 1.0
 *
 * @param array  $urls           URLs to print for resource hints.
 * @param string $relation_type  The relation type the URLs are printed.
 * @return array $urls           URLs to print for resource hints.
 */
function lifebegan_resource_hints( $urls, $relation_type ) {
	if ( wp_style_is( 'lifebegan-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'lifebegan_resource_hints', 10, 2 );

/**
 * Register Google Fonts
**/
function lifebegan_fonts_url() {
	$fonts_url = '';

	/*
	 * Translators: If there are characters in your language that are not
	 * supported by Lato, Roboto, or Oswald, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$lato = _x( 'on', 'Lato font: on or off', 'lifebegan' );
 	$roboto = _x( 'on', 'Roboto font: on or off', 'lifebegan' );
 	$oswald = _x( 'on', 'Oswald font: on or off', 'lifebegan' );

	$font_families = array();

	if ( 'off' !== $lato ) {
		$font_families[] = 'Lato:300,400,700';
	}

	if ( 'off' !== $roboto ) {
		$font_families[] = 'Roboto:400,700';
	}

	if ( 'off' !== $oswald ) {
		$font_families[] = 'Oswald:400,700';
	}

	if ( in_array( 'on', array( $lato, $roboto, $oswald ) ) ) {
		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);

		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}

	return esc_url_raw( $fonts_url );
}

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function lifebegan_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'lifebegan' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'lifebegan' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'lifebegan_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function lifebegan_scripts() {
	if ( is_page( 'blog' ) ) {
		wp_enqueue_style( 'lifebegan-blog-fonts', lifebegan_fonts_url( 'true' ), array(), null );
	}

	wp_enqueue_style( 'lifebegan-fonts', lifebegan_fonts_url(), array(), null  );

	wp_enqueue_style( 'lifebegan-style', get_stylesheet_uri() );

	wp_enqueue_script( 'lifebegan-navigation', get_template_directory_uri() . '/js/navigation.js', array( 'jquery' ), '20151215', true );

	// pass PHP vars to JavaScript by localizing the navigation script
	wp_localize_script( 'lifebegan-navigation', 'lifebeganScreenReaderText', array(
		'expand'			=> __( 'Expand child menu', 'lifebegan' ),
		'collapse'		=> __( 'Collapse child menu', 'lifebegan' ),
	) );

	wp_enqueue_script( 'lifebegan-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'lifebegan_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}
