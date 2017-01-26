<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Pine
 */

if ( ! function_exists( 'pine_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
	function pine_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() )
		);

		$date_link = is_singular() ? get_day_link( get_the_date( 'Y' ), get_the_date( 'm' ), get_the_date( 'd' ) ) : get_permalink();

		$posted_on = sprintf(
			esc_html_x( ' / On %s', 'post date', 'pine' ),
			'<a href="' . esc_url( $date_link ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		$byline = sprintf(
			esc_html_x( 'By %s', 'post author', 'pine' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		$categoryline = '';

		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'pine' ) );
			if ( $categories_list && pine_categorized_blog() ) {
				$categoryline = sprintf( esc_html__( ' / In %1$s', 'pine' ), $categories_list ); // WPCS: XSS OK.
			}
		}

		echo '<div class="post-item__info">';
			echo '<p>' . $byline . $posted_on . $categoryline . '</p>'; // WPCS: XSS OK.
		echo '</div><!-- /.info -->';
	}
endif;

if ( ! function_exists( 'pine_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function pine_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'pine' ) );
			if ( $categories_list && pine_categorized_blog() ) {
				printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'pine' ) . '</span>', $categories_list ); // WPCS: XSS OK.
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html__( ', ', 'pine' ) );
			if ( $tags_list ) {
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'pine' ) . '</span>', $tags_list ); // WPCS: XSS OK.
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link( esc_html__( 'Leave a comment', 'pine' ), esc_html__( '1 Comment', 'pine' ), esc_html__( '% Comments', 'pine' ) );
			echo '</span>';
		}

		edit_post_link( esc_html__( 'Edit', 'pine' ), '<span class="edit-link">', '</span>' );
	}
endif;

if ( ! function_exists( 'pine_thumbnail_src' ) ) :
	/**
	 * Echo hero element inline style
	 *
	 * @param  string $size Size of thumbnail image.
	 */
	function pine_thumbnail_src( $size = 'pine-full' ) {
		if ( ! has_post_thumbnail() ) {
			return;
		}

		if ( 'pine-column-full' === $size ) {
			$layout = pine_get_layout();

			if ( ! is_customize_preview() && ( 'left' === $layout || 'right' === $layout ) ) {
				$size = 'pine-column';
			}
		}

		$thumbnail_id = get_post_thumbnail_id();
		$thumbnail_image = wp_get_attachment_image_src( $thumbnail_id, $size );

		if ( empty( $thumbnail_image ) || ! isset( $thumbnail_image[0] ) ) {
			return;
		}

		echo ' style="background-image: url(' . esc_url( $thumbnail_image[0] ) . ')"';
	}
endif;

/**
 * Display custom logo
 */
function pine_custom_logo() {
	$custom_logo_id = get_theme_mod( 'custom_logo', get_template_directory_uri() . '/img/content/portfolio.jpg' );

	if ( $custom_logo_id ) : ?>
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="custom-logo-link" rel="home" itemprop="url">
		<?php if ( is_numeric( $custom_logo_id ) ) :
			echo wp_get_attachment_image( $custom_logo_id, 'full', false, array(
				'class'    => 'custom-logo',
				'itemprop' => 'logo',
			) );
		else : ?>
		<img src="<?php echo esc_url( $custom_logo_id ); ?>" class="custom-logo" itemprop="logo" />
		<?php endif; ?>
	</a>
	<?php elseif ( is_customize_preview() ) : ?>
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="custom-logo-link" style="display:none;"><img class="custom-logo"/></a>
	<?php endif;
}

if ( ! function_exists( 'pine_logo' ) ) :
	/**
	 * Display pine logo
	 */
	function pine_logo() {
		if ( function_exists( 'the_custom_logo' ) ) :
			pine_logo_upgrade();

			$header_text = get_theme_mod( 'header_text', 1 );

			if ( 0 === $header_text ) : ?>
				<h1 class="logo site-logo"><?php pine_custom_logo(); ?></h1>
			<?php endif;

			if ( 1 === $header_text ) : ?>
				<h1 class="logo site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1><!-- /.logo -->
			<?php endif;
		else :
			$pine_header = get_theme_mod( 'pine_header', 'title' );

			$pine_header_logo_default = get_template_directory_uri() . '/img/content/portfolio.jpg';
			$pine_header_logo = get_theme_mod( 'pine_header_logo' );
			if ( empty( $pine_header_logo ) ) {
				$pine_header_logo = $pine_header_logo_default;
			}

			if ( 'title' === $pine_header || is_customize_preview() ) : ?>
				<h1 class="logo site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1><!-- /.logo -->
			<?php endif;

			if ( 'logo' === $pine_header || is_customize_preview() ) : ?>
				<h1 class="logo site-logo"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					<img class="site-logo__image" src="<?php echo esc_url( $pine_header_logo ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" />
					<?php if ( is_customize_preview() ) : ?>
					<img class="site-logo__image default" src="<?php echo esc_url( $pine_header_logo_default ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" style="display: none" />
					<?php endif; ?>
				</a></h1><!-- /.logo -->
			<?php
			endif;
		endif;
	}
endif;

if ( ! function_exists( 'pine_get_social_icons' ) ) :
	/**
	 * Get social icons.
	 *
	 * @since 1.0
	 */
	function pine_get_social_icons() {
		return get_theme_mod(
			'pine_footer_social_buttons',
			array(
				array( 'social' => 'facebook', 'url' => '#', 'css_class' => 'facebook' ),
				array( 'social' => 'twitter', 'url' => '#', 'css_class' => 'twitter' ),
				array( 'social' => 'dribbble', 'url' => '#', 'css_class' => 'dribbble' ),
				array( 'social' => 'github', 'url' => '#', 'css_class' => 'github' ),
			)
		);
	}
endif;

if ( ! function_exists( 'pine_social_icons' ) ) :
	/**
	 * Display social icons.
	 *
	 * @param boolean $pine_footer_social_buttons Provide pine_get_social_icons output.
	 * @since 1.0
	 */
	function pine_social_icons( $pine_footer_social_buttons = false ) {
		if ( false === $pine_footer_social_buttons ) {
			$pine_footer_social_buttons = pine_get_social_icons();
		}

		if ( ! empty( $pine_footer_social_buttons ) ) :
			$social_buttons_default_titles = array(
				'facebook' => __( 'Facebook', 'pine' ),
				'twitter' => __( 'Twitter', 'pine' ),
				'linkedin' => __( 'LinkedIn', 'pine' ),
				'dribbble' => __( 'Dribbble', 'pine' ),
				'flickr' => __( 'Flickr', 'pine' ),
				'github' => __( 'GitHub', 'pine' ),
				'google-plus' => __( 'Google+', 'pine' ),
				'instagram' => __( 'Instagram', 'pine' ),
				'pinterest' => __( 'Pinterest', 'pine' ),
				'stumbleupon' => __( 'StumbleUpon', 'pine' ),
				'skype' => __( 'Skype', 'pine' ),
				'tumblr' => __( 'Tumblr', 'pine' ),
				'vimeo' => __( 'Vimeo', 'pine' ),
				'behance' => __( 'Behance', 'pine' ),
			);
		?>
		<ul class="social-nav clearfix">
		<?php
		foreach ( $pine_footer_social_buttons as $social_button ) :
			if ( isset( $social_button['cssClass'] ) && isset( $social_button['url'] ) && isset( $social_button['social'] ) ) : ?>
			<li class="<?php echo esc_attr( $social_button['cssClass'] . '-ico social-nav__item btn--transition' ); ?>">
				<a class="social-nav__link" href="<?php echo esc_url( $social_button['url'] ); ?>" title="<?php echo esc_attr( isset( $social_buttons_default_titles[ $social_button['social'] ] ) ? $social_buttons_default_titles[ $social_button['social'] ] : $social_button['social'] ); ?>" target="_blank">
					<i class="<?php echo esc_attr( 'fa fa-' . strtolower( $social_button['social'] ) ); ?>"></i>
				</a>
			</li>
			<?php
				endif;
			endforeach;
		?>
		</ul>
		<?php
		endif;
	}
endif;

if ( ! function_exists( 'pine_posts_navigation' ) ) :
	/**
	 * Do not display posts navigation if jetpack infinite scroll module is active
	 */
	function pine_posts_navigation() {
		if ( ! ( class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'infinite-scroll' ) ) ) {
			the_posts_navigation();
		}
	}
endif;

if ( ! function_exists( 'pine_parse_chat_content' ) ) :
	/**
	 * Parse chat content
	 *
	 * @param string $content Post content.
	 * @since 1.0
	 */
	function pine_parse_chat_content( $content ) {
		return preg_replace( '/\n?(.*)(\:)/mi', "\n<span class=\"username\">$1:</span>", $content );
	}
endif;
