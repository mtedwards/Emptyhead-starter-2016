<?php
/**
 * Emptyhead_Starter functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Emptyhead_Starter
 */

if ( ! function_exists( 'emptyheadstarter_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function emptyheadstarter_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on components, use a find and replace
	 * to change 'emptyheadstarter' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'emptyheadstarter', get_template_directory() . '/languages' );

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

	add_image_size( 'emptyheadstarter-featured-image', 640, 9999 );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'menu-1' => esc_html__( 'Top', 'emptyheadstarter' ),
		) );

	/**
	 * Add support for core custom logo.
	 */
	// add_theme_support( 'custom-logo', array(
	// 	'height'      => 200,
	// 	'width'       => 200,
	// 	'flex-width'  => true,
	// 	'flex-height' => true,
	// ) );

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
	// add_theme_support( 'custom-background', apply_filters( 'emptyheadstarter_custom_background_args', array(
	// 	'default-color' => 'ffffff',
	// 	'default-image' => '',
	// ) ) );
}
endif;
add_action( 'after_setup_theme', 'emptyheadstarter_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function emptyheadstarter_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'emptyheadstarter_content_width', 640 );
}
add_action( 'after_setup_theme', 'emptyheadstarter_content_width', 0 );

/**
 * Return early if Custom Logos are not available.
 *
 * @todo Remove after WP 4.7
 */
// function emptyheadstarter_the_custom_logo() {
// 	if ( ! function_exists( 'the_custom_logo' ) ) {
// 		return;
// 	} else {
// 		the_custom_logo();
// 	}
// }

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
// function emptyheadstarter_widgets_init() {
// 	register_sidebar( array(
// 		'name'          => esc_html__( 'Sidebar', 'emptyheadstarter' ),
// 		'id'            => 'sidebar-1',
// 		'description'   => '',
// 		'before_widget' => '<section id="%1$s" class="widget %2$s">',
// 		'after_widget'  => '</section>',
// 		'before_title'  => '<h2 class="widget-title">',
// 		'after_title'   => '</h2>',
// 	) );
// }
// add_action( 'widgets_init', 'emptyheadstarter_widgets_init' );


/**********************
Enqueue CSS and Scripts
**********************/

// loading modernizr and jquery, and reply script
function emptyheadstarter_scripts() {
  if (!is_admin()) {

    // modernizr (without media query polyfill)
		wp_register_script( 'starter-modernizr', get_template_directory_uri() . '/build/modernizr-custom.js', array(), '3.3.1', false );

    // If the server include .dev then load unminifeid css, else load minified and prefixed.
    // Allows us to use Sourcemaps in chrome to see which .scss file is creating rules
    if (strpos($_SERVER['SERVER_NAME'],'.dev') !== false) {
      wp_register_style( 'emptyheadstarter-style', get_template_directory_uri() . '/build/style.css' );
      wp_register_script( 'production-js', get_template_directory_uri() . '/build/production.js', array('jquery'), '20161110', true );
    } else {
			wp_register_style( 'emptyheadstarter-style', get_template_directory_uri() . '/build/style.min.css' );
			wp_register_script( 'production-js', get_template_directory_uri() . '/build/production.min.js', array('jquery'), '20161110', true );

    }
    // enqueue styles and scripts
    wp_enqueue_script( 'starter-modernizr' );
    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'production-js' );
    wp_enqueue_script( 'html5shiv' );
    wp_enqueue_style( 'emptyheadstarter-style' );
  }
}
add_action( 'wp_enqueue_scripts', 'emptyheadstarter_scripts' );


require get_template_directory() . '/lib/theme-functions.php';
