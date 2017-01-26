<?php
/**
 * Pine Theme Customizer.
 *
 * @package Pine
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function pine_customize_register( $wp_customize ) {
	/**
	 * Customizer additions.
	 */
	require get_template_directory() . '/inc/customizer-functions.php'; // Extra functions.
	require get_template_directory() . '/inc/customizer-controls.php'; // Extra controls.

	// Change site title and tagline controls transport to postMessage.
	$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

	if ( ! function_exists( 'the_custom_logo' ) ) {
		$sanitize_header_choice = new Pine_Sanitize_Select( array( 'logo', 'title' ), 'title' );

		$wp_customize->add_setting( 'pine_header', array(
			'default' => 'title',
			'transport' => 'postMessage',
			'sanitize_callback' => array( $sanitize_header_choice, 'callback' ),
		) );

		$wp_customize->add_control( 'pine_header', array(
			'label' => __( 'Display', 'pine' ),
			'section' => 'title_tagline',
			'type' => 'select',
			'choices' => array(
				'logo' => __( 'Logo', 'pine' ),
				'title' => __( 'Site Title', 'pine' ),
			),
		) );

		$wp_customize->add_setting( 'pine_header_logo', array(
			'default' => get_template_directory_uri() . '/img/content/portfolio.jpg',
			'transport' => 'postMessage',
			'sanitize_callback' => 'esc_url_raw',
		) );

		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'pine_header_logo', array(
			'label' => __( 'Upload a logo', 'pine' ),
			'section' => 'title_tagline',
		) ) );
	} else {
		$wp_customize->get_setting( 'custom_logo' )->default = get_template_directory_uri() . '/img/content/portfolio.jpg';
		$wp_customize->selective_refresh->get_partial( 'custom_logo' )->render_callback = 'pine_custom_logo';
	}

	$sections = $wp_customize->sections();

	/* -------		Colors 			------- */
	if ( ! isset( $sections['colors'] ) ) {
		$wp_customize->add_section( 'colors', array(
			'title'          => __( 'Colors', 'pine' ),
			'priority'       => 40,
		) );
	}

	$wp_customize->add_setting( 'pine_custom_style', array(
		'default' => '',
		'transport' => 'postMessage',
		'sanitize_callback' => 'pine_sanitize_text_trim',
	) );

	$sanitize_scheme = new Pine_Sanitize_Select( array( 'red', 'blue', 'green', 'orange', 'purple', 'yellow' ), 'red' );

	$wp_customize->add_setting( 'pine_scheme', array(
		'default' => 'red',
		'transport' => 'postMessage',
		'sanitize_callback' => array( $sanitize_scheme, 'callback' ),
	) );

	$wp_customize->add_control( new Pine_Color_Scheme_Control( $wp_customize, 'pine_scheme', array(
		'label' => __( 'Color Scheme', 'pine' ),
		'schemes' => array(
			'red' => array(
				'label' => __( 'Red', 'pine' ),
				'color' => '#e74c3c',
				'colors' => array(),
			),
			'blue' => array(
				'label' => __( 'Blue', 'pine' ),
				'color' => '#2980b9',
				'colors' => array(),
			),
			'green' => array(
				'label' => __( 'Green', 'pine' ),
				'color' => '#27ae60',
				'colors' => array(),
			),
			'orange' => array(
				'label' => __( 'Orange', 'pine' ),
				'color' => '#e67e22',
				'colors' => array(),
			),
			'purple' => array(
				'label' => __( 'Purple', 'pine' ),
				'color' => '#9b59b6',
				'colors' => array(),
			),
			'yellow' => array(
				'label' => __( 'Yellow', 'pine' ),
				'color' => '#f1c40f',
				'colors' => array(),
			),
		),
		'section' => 'colors',
	) ) );

	/* -------		Layouts 		------- */
	$wp_customize->add_section( 'layouts', array(
		'title' => __( 'Layouts', 'pine' ),
		'priority' => 40,
	) );

	$sanitize_global_layouts = new Pine_Sanitize_Select( array( 'none', 'left', 'right' ), 'left' );
	$sanitize_layouts = new Pine_Sanitize_Select( array( 'disabled', 'none', 'left', 'right' ), 'disabled' );

	$wp_customize->add_setting( 'pine_global_layout', array(
		'default' => 'left',
		'transport' => 'postMessage',
		'sanitize_callback' => array( $sanitize_global_layouts, 'callback' ),
	) );

	$wp_customize->add_control( new Pine_Layout_Control( $wp_customize, 'pine_global_layout', array(
		'label' => __( 'Global', 'pine' ),
		'section' => 'layouts',
		'layouts' => array(
			'none' => array(
				'label' => __( 'None', 'pine' ),
			),
			'left' => array(
				'label' => __( 'Left', 'pine' ),
			),
			'right' => array(
				'label' => __( 'Right', 'pine' ),
			),
		),
		'priority' => 1,
	) ) );

	$wp_customize->add_setting( 'pine_blog_layout', array(
		'default' => 'disabled',
		'transport' => 'postMessage',
		'sanitize_callback' => array( $sanitize_layouts, 'callback' ),
	) );

	$wp_customize->add_control( new Pine_Layout_Control( $wp_customize, 'pine_blog_layout', array(
		'label' => __( 'Blog', 'pine' ),
		'section' => 'layouts',
		'layouts' => array(
			'disabled' => array(
				'label' => __( 'Disabled', 'pine' ),
			),
			'none' => array(
				'label' => __( 'None', 'pine' ),
			),
			'left' => array(
				'label' => __( 'Left', 'pine' ),
			),
			'right' => array(
				'label' => __( 'Right', 'pine' ),
			),
		),
		'priority' => 3,
	) ) );

	$wp_customize->add_setting( 'pine_single_layout', array(
		'default' => 'disabled',
		'transport' => 'postMessage',
		'sanitize_callback' => array( $sanitize_layouts, 'callback' ),
	) );

	$wp_customize->add_control( new Pine_Layout_Control( $wp_customize, 'pine_single_layout', array(
		'label' => __( 'Single', 'pine' ),
		'section' => 'layouts',
		'layouts' => array(
			'disabled' => array(
				'label' => __( 'Disabled', 'pine' ),
			),
			'none' => array(
				'label' => __( 'None', 'pine' ),
			),
			'left' => array(
				'label' => __( 'Left', 'pine' ),
			),
			'right' => array(
				'label' => __( 'Right', 'pine' ),
			),
		),
		'priority' => 4,
	) ) );

	$wp_customize->add_setting( 'pine_archive_layout', array(
		'default' => 'disabled',
		'transport' => 'postMessage',
		'sanitize_callback' => array( $sanitize_layouts, 'callback' ),
	) );

	$wp_customize->add_control( new Pine_Layout_Control( $wp_customize, 'pine_archive_layout', array(
		'label' => __( 'Archive', 'pine' ),
		'section' => 'layouts',
		'layouts' => array(
			'disabled' => array(
				'label' => __( 'Disabled', 'pine' ),
			),
			'none' => array(
				'label' => __( 'None', 'pine' ),
			),
			'left' => array(
				'label' => __( 'Left', 'pine' ),
			),
			'right' => array(
				'label' => __( 'Right', 'pine' ),
			),
		),
		'priority' => 5,
	) ) );

	$wp_customize->add_setting( 'pine_category_archive_layout', array(
		'default' => 'disabled',
		'transport' => 'postMessage',
		'sanitize_callback' => array( $sanitize_layouts, 'callback' ),
	) );

	$wp_customize->add_control( new Pine_Layout_Control( $wp_customize, 'pine_category_archive_layout', array(
		'label' => __( 'Category archive', 'pine' ),
		'section' => 'layouts',
		'layouts' => array(
			'disabled' => array(
				'label' => __( 'Disabled', 'pine' ),
			),
			'none' => array(
				'label' => __( 'None', 'pine' ),
			),
			'left' => array(
				'label' => __( 'Left', 'pine' ),
			),
			'right' => array(
				'label' => __( 'Right', 'pine' ),
			),
		),
		'priority' => 6,
	) ) );

	$wp_customize->add_setting( 'pine_search_layout', array(
		'default' => 'disabled',
		'transport' => 'postMessage',
		'sanitize_callback' => array( $sanitize_layouts, 'callback' ),
	) );

	$wp_customize->add_control( new Pine_Layout_Control( $wp_customize, 'pine_search_layout', array(
		'label' => __( 'Search', 'pine' ),
		'section' => 'layouts',
		'layouts' => array(
			'disabled' => array(
				'label' => __( 'Disabled', 'pine' ),
			),
			'none' => array(
				'label' => __( 'None', 'pine' ),
			),
			'left' => array(
				'label' => __( 'Left', 'pine' ),
			),
			'right' => array(
				'label' => __( 'Right', 'pine' ),
			),
		),
		'priority' => 7,
	) ) );

	$wp_customize->add_setting( 'pine_404_layout', array(
		'default' => 'disabled',
		'transport' => 'postMessage',
		'sanitize_callback' => array( $sanitize_layouts, 'callback' ),
	) );

	$wp_customize->add_control( new Pine_Layout_Control( $wp_customize, 'pine_404_layout', array(
		'label' => __( '404', 'pine' ),
		'section' => 'layouts',
		'layouts' => array(
			'disabled' => array(
				'label' => __( 'Disabled', 'pine' ),
			),
			'none' => array(
				'label' => __( 'None', 'pine' ),
			),
			'left' => array(
				'label' => __( 'Left', 'pine' ),
			),
			'right' => array(
				'label' => __( 'Right', 'pine' ),
			),
		),
		'priority' => 8,
	) ) );

	$wp_customize->add_setting( 'pine_page_layout', array(
		'default' => 'disabled',
		'transport' => 'postMessage',
		'sanitize_callback' => array( $sanitize_layouts, 'callback' ),
	) );

	$wp_customize->add_control( new Pine_Layout_Control( $wp_customize, 'pine_page_layout', array(
		'label' => __( 'Default Page', 'pine' ),
		'section' => 'layouts',
		'layouts' => array(
			'disabled' => array(
				'label' => __( 'Disabled', 'pine' ),
			),
			'none' => array(
				'label' => __( 'None', 'pine' ),
			),
			'left' => array(
				'label' => __( 'Left', 'pine' ),
			),
			'right' => array(
				'label' => __( 'Right', 'pine' ),
			),
		),
		'priority' => 9,
	) ) );

	/* -------		Background 		------- */
	$wp_customize->get_control( 'background_color' )->section = 'background_image';
	$wp_customize->get_section( 'background_image' )->title = __( 'Background', 'pine' );

	/* -------		Header 		------- */
	$wp_customize->add_section( 'footer', array(
		'title' => __( 'Footer', 'pine' ),
		'priority' => 29,
	) );

	$wp_customize->add_setting( 'pine_footer_social_buttons', array(
		'default' => array(
			array(
				'social' => 'facebook',
				'cssClass' => 'facebook',
				'url' => '#',
			),
			array(
				'social' => 'twitter',
				'cssClass' => 'twitter',
				'url' => '#',
			),
			array(
				'social' => 'dribbble',
				'cssClass' => 'dribbble',
				'url' => '#',
			),
			array(
				'social' => 'github',
				'cssClass' => 'github',
				'url' => '#',
			),
		),
		'transport' => 'postMessage',
		'sanitize_callback' => 'pine_sanitize_social_buttons',
	) );

	$wp_customize->add_control( new Pine_Social_Buttons_Control( $wp_customize, 'pine_footer_social_buttons', array(
		'label' => __( 'Social buttons', 'pine' ),
		'socials' => array(
			'facebook' => array(
				'label' => __( 'Facebook', 'pine' ),
			),
			'twitter' => array(
				'label' => __( 'Twitter', 'pine' ),
			),
			'linkedin' => array(
				'label' => __( 'LinkedIn', 'pine' ),
			),
			'dribbble' => array(
				'label' => __( 'Dribbble', 'pine' ),
			),
			'flickr' => array(
				'label' => __( 'Flickr', 'pine' ),
			),
			'github' => array(
				'label' => __( 'GitHub', 'pine' ),
			),
			'google-plus' => array(
				'label' => __( 'Google+', 'pine' ),
			),
			'instagram' => array(
				'label' => __( 'Instagram', 'pine' ),
			),
			'pinterest' => array(
				'label' => __( 'Pinterest', 'pine' ),
			),
			'stumbleupon' => array(
				'label' => __( 'StumbleUpon', 'pine' ),
			),
			'skype' => array(
				'label' => __( 'Skype', 'pine' ),
			),
			'tumblr' => array(
				'label' => __( 'Tumblr', 'pine' ),
			),
			'vimeo' => array(
				'label' => __( 'Vimeo', 'pine' ),
			),
			'behance' => array(
				'label' => __( 'Behance', 'pine' ),
			),
		),
		'section' => 'footer',
	) ) );
}
add_action( 'customize_register', 'pine_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function pine_customize_preview_js() {
	wp_enqueue_script( 'pine_lessjs', get_template_directory_uri() . '/admin/js/pine-less.js', array(), '2.5.1', true );
	wp_enqueue_script( 'pine_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview', 'pine_lessjs' ), '20170126', true );
}
add_action( 'customize_preview_init', 'pine_customize_preview_js' );
