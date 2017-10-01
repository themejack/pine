<?php
/**
 * Pine functions and definitions.
 *
 * @link https://codex.wordpress.org/Functions_File_Explained
 *
 * @package Pine
 */

if ( ! function_exists( 'pine_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function pine_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Pine, use a find and replace
		 * to change 'pine' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'pine', get_template_directory() . '/languages' );

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

		/*
		 * Register new image sizes
		 */
		add_image_size( 'pine-full', 1600, 500, true );
		add_image_size( 'pine-project-list', 1140, 500, true );
		add_image_size( 'pine-column-full', 1140, 400, true );
		add_image_size( 'pine-column', 750, 400, true );

		/**
		 * Enable support for Theme Logo
		 *
		 * @link http://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 500,
			'width'       => 500,
			'flex-height' => true,
			'flex-width'  => true,
			'header-text' => array( 'site-title', 'site-description' ),
		) );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary' => esc_html__( 'Primary Menu', 'pine' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		/*
		 * Enable support for Post Formats.
		 * See https://developer.wordpress.org/themes/functionality/post-formats/
		 */
		add_theme_support( 'post-formats', array(
			'aside',
			'image',
			'video',
			'quote',
			'link',
		) );

		// Add editor style.
		add_editor_style( get_template_directory_uri() . '/admin/css/pine-editor.css' );
	}
endif; // End pine_setup.
add_action( 'after_setup_theme', 'pine_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function pine_content_width() {
	$pine_content_width = 1140;
	/**
	 * Filter content width
	 *
	 * @param integer $pine_content_width Default content width.
	 */
	$GLOBALS['content_width'] = (int) apply_filters( 'pine_content_width', $pine_content_width );
}
add_action( 'after_setup_theme', 'pine_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function pine_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'pine' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'pine_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function pine_scripts() {
	// Fonts.
	wp_enqueue_style( 'pine-fonts', '//fonts.googleapis.com/css?family=Lato:400,300,300italic,400italic,700,700italic,900,900italic' );

	// Default style.
	wp_enqueue_style( 'pine-style', get_template_directory_uri() . '/css/style.css', array( 'pine-fonts' ), '20160303' );

	// Enqueue choosen color scheme.
	$colors = array( 'blue', 'green', 'orange', 'purple', 'yellow' );
	$scheme = get_theme_mod( 'pine_scheme', 'red' );
	if ( in_array( $scheme, $colors ) ) {
		wp_enqueue_style( 'pine-style-color-' . $scheme, get_template_directory_uri() . '/css/color-' . $scheme . '.css', array( 'pine-style' ), '20160411' );
	}

	// Scripts.
	wp_enqueue_script( 'pine-vendors', get_template_directory_uri() . '/js/vendors.js', array(), '20150903', true );
	wp_enqueue_script( 'pine-scripts', get_template_directory_uri() . '/js/scripts.js', array( 'pine-vendors', 'jquery' ), '20150903', true );

	// Comments script.
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'pine_scripts' );

/**
 * Add custom style
 */
function pine_custom_style() {
	if ( is_customize_preview() ) : ?>
	<style type="text/css" id="customize-preview-style"></style>
	<?php
	endif;
}
add_action( 'wp_head', 'pine_custom_style', 9999 );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Pine Notifications
 */
require get_template_directory() . '/inc/notifications.php';

/**
 * Pine Admin Page
 */
require get_template_directory() . '/inc/admin-page.php';
