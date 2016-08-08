<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Pine
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function pine_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	$layout = pine_get_layout();
	if ( 'left' === $layout || 'right' === $layout ) {
		$classes[] = 'sidebar-' . $layout;
	}

	return $classes;
}
add_filter( 'body_class', 'pine_body_classes' );

/**
 * Returns sidebar position
 *
 * @since 1.0
 *
 * @return string 'none', 'left' or 'right'
 */
function pine_get_layout() {
	$global_layout = get_theme_mod( 'pine_global_layout', 'left' );
	$blog_layout = get_theme_mod( 'pine_blog_layout', 'disabled' );
	$single_layout = get_theme_mod( 'pine_single_layout', 'disabled' );
	$archive_layout = get_theme_mod( 'pine_archive_layout', 'disabled' );
	$category_archive_layout = get_theme_mod( 'pine_category_archive_layout', 'disabled' );
	$search_layout = get_theme_mod( 'pine_search_layout', 'disabled' );
	$page_404_layout = get_theme_mod( 'pine_404_layout', 'disabled' );
	$page_layout = get_theme_mod( 'pine_page_layout', 'disabled' );

	$accepted_layouts = array( 'none', 'left', 'right' );

	$layout = '';

	if ( is_front_page() && 'page' === get_option( 'show_on_front' ) ) {
		$layout = 'none';
	}

	if ( is_home() ) {
		$layout = $blog_layout;
	}

	if ( is_archive() ) {
		$layout = $archive_layout;
	}

	if ( is_category() ) {
		$layout = $category_archive_layout;
	}

	if ( is_search() ) {
		$layout = $search_layout;
	}

	if ( is_404() ) {
		$layout = $page_404_layout;
	}

	if ( is_single() ) {
		$layout = $single_layout;
	}

	if ( is_page() ) {
		$layout = $page_layout;
	}

	if ( ! in_array( $layout, $accepted_layouts ) ) {
		$layout = $global_layout;
	}

	return $layout;
}

/**
 * Main classes
 *
 * @param  array   $classes Array of classes that will be extended.
 * @param  boolean $echo    Echo or not.
 * @return array|null       If $echo is true than nothing will be returned else if $classes variable is empty array null will be returned else array of classes will be returned.
 */
function pine_main_classes( $classes = array(), $echo = true ) {
	$layout = pine_get_layout();

	if ( is_customize_preview() ) {
		$classes[] = 'col-md-12';
		$classes[] = 'pine-main-class';
	} else {
		if ( 'none' === $layout ) {
			$classes[] = 'col-md-12';
		} else {
			$classes[] = 'col-md-8';

			if ( 'left' === $layout ) {
				$classes[] = 'col-md-push-4';
			}
		}
	}

	if ( true === $echo ) {
		echo esc_attr( join( ' ', $classes ) );
	} else {
		if ( empty( $classes ) ) {
			return null;
		} else {
			return $classes;
		}
	}
}

/**
 * Sidebar classes
 *
 * @param  array   $classes Array of classes that will be extended.
 * @param  boolean $echo    Echo or not.
 * @return array|null       If $echo is true than nothing will be returned else if $classes variable is empty array null will be returned else array of classes will be returned.
 */
function pine_sidebar_classes( $classes = array(), $echo = true ) {
	$layout = pine_get_layout();

	if ( is_customize_preview() ) {
		$classes[] = 'col-md-4';
		$classes[] = 'pine-sidebar-class';
	} else {
		if ( 'none' !== $layout ) {
			$classes[] = 'col-md-4';

			if ( 'left' === $layout ) {
				$classes[] = 'col-md-pull-8';
			}
		}
	}

	if ( true === $echo ) {
		echo esc_attr( join( ' ', $classes ) );
	} else {
		if ( empty( $classes ) ) {
			return null;
		} else {
			return $classes;
		}
	}
}

/**
 * Post navigation filter
 *
 * @param  string $output Navigation html.
 * @return string
 */
function pine_post_navigation( $output ) {
	if ( ! empty( $output ) ) {
		return preg_replace( '/<a([^>]*)>(.*)<\/a>/i', '<a$1><span>$2</span></a>', $output );
	}
}

add_filter( 'previous_post_link', 'pine_post_navigation', 10, 1 );
add_filter( 'next_post_link', 'pine_post_navigation', 10, 1 );

/**
 * Posts pagination
 */
function pine_posts_pagination() {
	$output = get_the_posts_pagination( array(
		'type' => 'plain', // We are not able to get a array type.
	) );

	echo wp_kses(
		preg_replace( '/>\s+</', '><', $output ),
		array(
			'nav' => array(
				'class' => true,
				'role' => true,
			),
			'h2' => array(
				'class' => true,
			),
			'div' => array(
				'class' => true,
			),
			'span' => array(
				'class' => true,
			),
			'a' => array(
				'class' => true,
				'href' => true,
			),
		)
	);
}

/**
 * Pine excerpt length
 *
 * @param  int $length Current excerpt length.
 * @return int         New excerpt length.
 */
function pine_excerpt_length( $length ) {
	if ( is_home() ) {
		return 35;
	}

	return $length;
}

/**
 * Pine excerpt more
 *
 * @param string $more Default WordPress excerpt more string.
 * @return string Remove [ and ] from default
 */
function pine_excerpt_more( $more ) {
	return ' &hellip;';
}
add_filter( 'excerpt_more', 'pine_excerpt_more', 999 );

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function pine_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'pine_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'pine_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so pine_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so pine_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in pine_categorized_blog.
 */
function pine_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'pine_categories' );
}
add_action( 'edit_category', 'pine_category_transient_flusher' );
add_action( 'save_post', 'pine_category_transient_flusher' );

/**
 * Portfolio post type
 *
 * @return array
 */
function pine_get_portfolio_post_type() {
	$pine_portfolio_post_type = array( 'jetpack-portfolio' );

	/**
	 * Filter portfolio post type
	 *
	 * @param array $pine_portfolio_post_type Default post types.
	 */
	return (array) apply_filters( 'pine_portfolio_post_type', $pine_portfolio_post_type );
}

/**
 * Portfolio posts per page
 *
 * @return integer
 */
function pine_get_portfolio_posts_per_page() {
	$pine_portfolio_posts_per_page = (int) get_option( 'jetpack_portfolio_posts_per_page', get_option( 'posts_per_page', 9 ) );

	/**
	 * Filter portfolio number of posts per page
	 *
	 * @param integer $pine_portfolio_posts_per_page Default number of posts per page.
	 */
	return (int) apply_filters( 'pine_portfolio_posts_per_page', $pine_portfolio_posts_per_page );
}

/**
 * Portfolio taxonomy
 *
 * @return array
 */
function pine_get_portfolio_taxonomy() {
	$pine_portfolio_taxonomy = array( 'jetpack-portfolio-type' );

	/**
	 * Filter portfolio taxonomy
	 *
	 * @param array $pine_portfolio_taxonomy Default taxonomies.
	 */
	return (array) apply_filters( 'pine_portfolio_taxonomy', $pine_portfolio_taxonomy );
}

/**
 * Upgrade theme logo
 */
function pine_logo_upgrade() {
	$upgraded = absint( get_theme_mod( 'pine_logo_upgraded', 0 ) );

	// Check is site logo already upgraded.
	if ( 1 === $upgraded ) {
		return;
	}

	$pine_header = get_theme_mod( 'pine_header' );
	$pine_header_logo = get_theme_mod( 'pine_header_logo' );

	/* Update header_text value. */
	if ( 'title' === $pine_header ) {
		set_theme_mod( 'header_text', 1 );
	}
	if ( 'logo' === $pine_header ) {
		set_theme_mod( 'header_text', 0 );
	}

	/* Update custom_logo value. */
	if ( ! empty( $pine_header_logo ) ) {
		set_theme_mod( 'custom_logo', $pine_header_logo );
	}

	set_theme_mod( 'pine_logo_upgraded', 1 );
}
add_action( 'admin_init', 'pine_logo_upgrade' );
