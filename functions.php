<?php
/**
 * Pine functions and definitions.
 *
 * @link https://codex.wordpress.org/Functions_File_Explained
 *
 * @package Pine
 */

$slicejack_url = 'http://slicejack.com';

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
		add_image_size( 'project-list', 1140, 500, true );
		add_image_size( 'pine-column-full', 1140, 400, true );
		add_image_size( 'pine-column', 750, 400, true );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary' => esc_html__( 'Primary Menu', 'pine' ),
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

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'pine_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );
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
	$GLOBALS['content_width'] = apply_filters( 'pine_content_width', 1140 );
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
 * Enqueue admin scripts and styles.
 *
 * @since 1.0
 */
function pine_admin_scripts() {
	wp_register_style( 'customize-control-color-scheme', get_template_directory_uri() . '/admin/css/pine-customize-control-color-scheme.min.css', array( 'customize-controls' ), '20150610', 'all' );
	wp_register_script( 'customize-control-color-scheme', get_template_directory_uri() . '/admin/js/pine-customize-control-color-scheme.min.js', array( 'customize-controls', 'jquery' ), '20150610', true );
	wp_register_style( 'customize-control-social-buttons', get_template_directory_uri() . '/admin/css/pine-customize-control-social-buttons.min.css', array( 'customize-controls' ), '20150610', 'all' );
	wp_register_script( 'customize-control-social-buttons', get_template_directory_uri() . '/admin/js/pine-customize-control-social-buttons.min.js', array( 'customize-controls', 'jquery' ), '20150610', true );
	wp_register_style( 'customize-control-layout', get_template_directory_uri() . '/admin/css/pine-customize-control-layout.min.css', array( 'customize-controls' ), '20150610', 'all' );
	wp_register_script( 'customize-control-layout', get_template_directory_uri() . '/admin/js/pine-customize-control-layout.min.js', array( 'customize-controls', 'jquery' ), '20140806', true );
	wp_register_style( 'customize-control-sharrre-social-buttons', get_template_directory_uri() . '/admin/css/pine-customize-control-sharrre-social-buttons.min.css', array( 'customize-controls' ), '20150610', 'all' );
	wp_register_script( 'customize-control-sharrre-social-buttons', get_template_directory_uri() . '/admin/js/pine-customize-control-sharrre-social-buttons.min.js', array( 'customize-controls', 'jquery' ), '20150610', true );
}
add_action( 'admin_enqueue_scripts', 'pine_admin_scripts' );

/**
 * Add editor styles
 */
function pine_add_editor_styles() {
	add_editor_style( get_template_directory_uri() . '/admin/css/pine-editor.min.css' );
}
add_action( 'admin_init', 'pine_add_editor_styles' );

/**
 * Add TinyMCE google fonts plugin
 *
 * @param array $plugins TinyMCE plugins.
 * @return array $plugins
 */
function pine_add_tinymce_googlefonts( $plugins ) {
	$plugins['pine_googlefonts'] = get_template_directory_uri() . '/admin/js/pine-tinymce.plugins.googlefonts.min.js';
	return $plugins;

}
add_filter( 'mce_external_plugins', 'pine_add_tinymce_googlefonts' );

/**
 * Enqueue scripts and styles.
 */
function pine_scripts() {
	$styles = array(
		'red' => '',
		'blue' => '-blue',
		'green' => '-green',
		'orange' => '-orange',
		'purple' => '-purple',
		'yellow' => '-yellow',
	);

	$theme_style = get_theme_mod( 'pine_scheme', 'red' );
	if ( ! array_key_exists( $theme_style, $styles ) ) {
		$theme_style = 'red';
	}

	wp_enqueue_style( 'pine-style', get_template_directory_uri() . '/css/style' . $styles[ $theme_style ] . '.min.css' );

	wp_enqueue_script( 'pine-vendors', get_template_directory_uri() . '/js/vendors.min.js', array(), '20150903', true );
	wp_enqueue_script( 'pine-scripts', get_template_directory_uri() . '/js/scripts.min.js', array( 'pine-vendors', 'jquery' ), '20150903', true );

	wp_enqueue_script( 'pine-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

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
 * Print into footer
 */
function pine_footer() {
	?>
	<script type="text/javascript">
		WebFontConfig = {
			google: {
				families: [ 'Lato:400,300,300italic,400italic,700,700italic,900,900italic:latin' ]
			},
			custom: {
				families: [ 'FontAwesome' ],
				urls: [ '<?php echo esc_url( get_template_directory_uri() . '/css/font-awesome.min.css' ); ?>' ],
				testStrings: {
					'FontAwesome': '\uf083\uf015'
				}
			}
		};
		( function() {
			var wf = document.createElement('script');
			wf.src = ('https:' == document.location.protocol ? 'https' : 'http') + '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
			wf.type = 'text/javascript';
			wf.async = 'true';
			var s = document.getElementsByTagName('script')[0];
			s.parentNode.insertBefore(wf, s);
		} () );
	</script>
	<?php
}
add_action( 'wp_footer', 'pine_footer' );

/**
 * Print into customizer footer
 */
function pine_customizer_footer() {
	?>
	<script type="text/javascript">
		WebFontConfig = {
			custom: {
				families: [ 'FontAwesome' ],
				urls: [ '<?php echo esc_url( get_template_directory_uri() . '/css/font-awesome.min.css' ); ?>' ],
				testStrings: {
					'FontAwesome': '\uf083\uf015'
				}
			}
		};
		( function() {
			var wf = document.createElement('script');
			wf.src = ('https:' == document.location.protocol ? 'https' : 'http') + '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
			wf.type = 'text/javascript';
			wf.async = 'true';
			var s = document.getElementsByTagName('script')[0];
			s.parentNode.insertBefore(wf, s);
		} () );
	</script>
	<?php
}
add_action( 'customize_controls_print_footer_scripts', 'pine_customizer_footer' );

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
 * Load dashboard widgets.
 */
require get_template_directory() . '/inc/dashboard.php';
