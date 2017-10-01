<?php
/**
 * Pine admin page
 *
 * @package Pine
 */

// Load WordPress dashboard API.
require_once( ABSPATH . 'wp-admin/includes/dashboard.php' );

/**
 * Add async and defer to github buttons script tag
 *
 * @param  string $tag    Html tag.
 * @param  string $handle Script handle.
 * @return string
 */
function pine_github_buttons_script( $tag, $handle ) {
	if ( 'pine-github-buttons' !== $handle ) {
		return $tag;
	}

	return str_replace( ' src=', 'async defer id="github-bjs" src=', $tag );
}
add_filter( 'script_loader_tag', 'pine_github_buttons_script', 10, 2 );

/**
 * Admin page scripts and styles
 *
 * @param string $hook The current admin page.
 */
function pine_admin_page_scripts( $hook ) {
	if ( 'appearance_page_pine' === $hook ) {
		wp_enqueue_style( 'pine-admin-fonts', '//fonts.googleapis.com/css?family=Lato:400,700' );
		wp_enqueue_style( 'pine-admin-page', get_template_directory_uri() . '/admin/css/pine-admin-page.css', array(), '1.0.0', 'all' );
		wp_enqueue_script( 'pine-github-buttons', 'https://buttons.github.io/buttons.js', array(), null, true );

		wp_enqueue_script( 'dashboard' );
	}
}
add_action( 'admin_enqueue_scripts', 'pine_admin_page_scripts', 10, 1 );

/**
 * Welcome metabox
 */
function pine_welcome_metabox() {
	?>
	<p>
	<?php
	printf(
		// translators: %1$s is a blog post link and %2$s is a link to github repository.
		esc_html__( 'Glad to see you here. To start you can read our introduction blog post %1$s. If you are looking for documentation you can find it on %2$s, also our code is very well documented.', 'pine' ),
		'<a href="http://slicejack.com/pine-free-minimalist-wordpress-portfolio-theme" target="_blank">' . esc_html__( 'here', 'pine' ) . '</a>',
		'<a href="https://github.com/themejack/pine" target="_blank">' . esc_html__( 'GitHub', 'pine' ) . '</a>'
	);

	// translators: %s is a GitHub username.
	$follow_aria_label = sprintf( __( 'Follow %s on GitHub', 'pine' ), '@themejack' );
	// translators: %is is a number of GitHub followers.
	$follow_count_aria_label = sprintf( __( '%s followers on GitHub', 'pine' ), '#' );

	// translators: %s is a GitHub repo name.
	$star_aria_label = sprintf( __( 'Star %s on GitHub', 'pine' ), 'themejack/pine' );
	// translators: %is is a number of GitHub stargazers.
	$star_count_aria_label = sprintf( __( '%s stargazers on GitHub', 'pine' ), '#' );
	?>
	</p>
	<p class="github-buttons">
		<a
			class="github-button"
			href="https://github.com/themejack"
			data-count-href="/themejack/followers"
			data-count-api="/users/themejack#followers"
			data-count-aria-label="<?php echo esc_attr( $follow_count_aria_label ); ?>"
			aria-label="<?php echo esc_attr( $follow_aria_label ); ?>">
			<?php
			// translators: %s is a GitHub username.
			printf( esc_html__( 'Follow %s', 'pine' ), '@themejack' );
			?>
		</a>
		<a
			class="github-button"
			href="https://github.com/themejack/pine"
			data-icon="octicon-star"
			data-count-href="/themejack/pine/stargazers"
			data-count-api="/repos/themejack/pine#stargazers_count"
			data-count-aria-label="<?php echo esc_attr( $star_count_aria_label ); ?>"
			aria-label="<?php echo esc_attr( $star_aria_label ); ?>">
			<?php esc_html_e( 'Star', 'pine' ); ?>
		</a>
	</p>
	<?php
}

/**
 * Notifications metabox.
 *
 * @since  1.1.0
 * @return void
 */
function pine_notifications_metabox() {
	$notifications = Pine_Notifications::get_instance();

	$notifications->display_all();
}

/**
 * Customize metabox
 */
function pine_customize_metabox() {
	?>
	<p>
	<?php
	printf(
		// translators: %s is a link to Customizer page.
		esc_html__( 'Theme customization never been easier. Try %s.', 'pine' ),
		'<a href="' .
			esc_url( add_query_arg( array(
				'return' => rawurlencode( 'themes.php/?page=pine' ),
			), admin_url( '/customize.php' ) ) ) .
		'">' . esc_html__( 'customizer', 'pine' ) . '</a>'
	);
	?>
	</p>
<?php
}

/**
 * Child theme metabox
 */
function pine_child_theme_metabox() {
	?>
	<p>
	<?php
	printf(
		// translators: %s is a link to GitHub repository.
		esc_html__( 'Want to make more customizations? We prepared child theme for you. Fork it on %s and create custom child theme.', 'pine' ),
		'<a href="https://github.com/themejack/pine-child" target="_blank">' . esc_html__( 'GitHub', 'pine' ) . '</a>'
	);
	?>
	</p>
	<?php
	// translators: %s is a name of GitHub repository.
	$fork_aria_label = sprintf( __( 'Fork %s on GitHub', 'pine' ), 'themejack/pine-child' );
	// translators: %s is a number of GitHub forks.
	$fork_count_aria_label = sprintf( __( '%s forks on GitHub', 'pine' ), '#' );
	// translators: %s is a name of GitHub repository.
	$download_aria_label = sprintf( __( 'Download %s on GitHub', 'pine' ), 'themejack/pine-child' )
	?>
	<p class="github-buttons">
		<a
			class="github-button"
			href="https://github.com/themejack/pine-child/fork"
			data-icon="octicon-repo-forked"
			data-count-href="/themejack/pine-child/network"
			data-count-api="/repos/themejack/pine-child#forks_count"
			data-count-aria-label="<?php echo esc_attr( $fork_count_aria_label ); ?>"
			aria-label="<?php echo esc_attr( $fork_aria_label ); ?>">
			<?php esc_html_e( 'Fork', 'pine' ); ?>
		</a>
		<a
			class="github-button"
			href="https://github.com/themejack/pine-child/archive/master.zip"
			data-icon="octicon-cloud-download"
			aria-label="<?php echo esc_attr( $download_aria_label ); ?>">
			<?php esc_html_e( 'Download child theme', 'pine' ); ?>
		</a>
	</p>
<?php
}

/**
 * Delete dashboard cached rss widget
 *
 * @param  string $widget_id Widget ID.
 */
function pine_delete_dashboard_cached_rss_widget( $widget_id ) {
	$locale = get_locale();
	$cache_key = 'dash_' . md5( $widget_id . '_' . $locale );

	delete_transient( $cache_key );
}

/**
 * SliceJack News dashboard widget.
 *
 * @since 1.0
 */
function pine_sj_dashboard_widget() {
?>
	<div class="news-actions">
		<a href="<?php echo esc_url( admin_url( 'themes.php?page=pine&reload_news=1' ) ); ?>" title="<?php esc_attr_e( 'Reload cache', 'pine' ); ?>" class="reload-cache"><span class="dashicons dashicons-update"></span></a>
	</div>
<?php
	$feed = array(
		'type'         => '',
		'link'         => 'http://slicejack.com',
		'url'          => 'http://slicejack.com/?feed=rss2',
		'title'        => __( 'SliceJack Blog', 'pine' ),
		'items'        => 5,
		'show_summary' => 1,
		'show_author'  => 0,
		'show_date'    => 1,
	);

	define( 'DOING_AJAX', true );

	wp_dashboard_cached_rss_widget( 'dashboard_slicejack', 'pine_sj_dashboard_widget_output', $feed );
}

/**
 * Display the SliceJack news feed.
 *
 * @since 1.0
 *
 * @param string $widget_id Widget ID.
 * @param array  $feed     Array of informations about RSS feed.
 */
function pine_sj_dashboard_widget_output( $widget_id, $feed ) {
?>
	<div class="rss-widget">
		<?php pine_sj_widget_rss_output( $feed['url'], $feed ); ?>
		<div style="display: block; text-align: center; margin-top: 30px;">
			<a href="<?php echo esc_url( 'http://slicejack.com/blog/' ); ?>" style="display: inline-block; width: 150px; height: 32px; line-height: 32px; color: #777; border: solid 1px #777; border-radius: 2px; text-align: center; text-decoration: none; font-size: 13px;"><?php esc_html_e( 'Read more posts', 'pine' ); ?></a>
		</div>
	</div>
	<?php
}

/**
 * Display the RSS entries in a list.
 *
 * @since 2.5.0
 *
 * @param string|array|object $rss RSS url.
 * @param array               $args Widget arguments.
 */
function pine_sj_widget_rss_output( $rss, $args = array() ) {
	if ( is_string( $rss ) ) {
		$rss = fetch_feed( $rss );
	} elseif ( is_array( $rss ) && isset( $rss['url'] ) ) {
		$args = $rss;
		$rss = fetch_feed( $rss['url'] );
	} elseif ( ! is_object( $rss ) ) {
		return;
	}

	if ( is_wp_error( $rss ) ) {
		if ( is_admin() || current_user_can( 'manage_options' ) ) {
			echo '<p>' .
				wp_kses(
					sprintf(
						// translators: %s is an error message.
						__( '<strong>RSS Error</strong>: %s', 'pine' ),
						$rss->get_error_message()
					),
					array(
						'strong' => array(),
					)
				) .
			'</p>';
		}
		return;
	}

	$default_args = array(
		'show_author'  => 0,
		'show_date'    => 0,
		'show_summary' => 0,
		'items'        => 0,
	);
	$args = wp_parse_args( $args, $default_args );

	$items = (int) $args['items'];
	if ( $items < 1 || 20 < $items ) {
		$items = 10;
	}
	$show_summary  = (int) $args['show_summary'];
	$show_author   = (int) $args['show_author'];
	$show_date     = (int) $args['show_date'];

	if ( ! $rss->get_item_quantity() ) {
		echo '<ul><li>' . esc_html__( 'An error has occurred, which probably means the feed is down. Try again later.', 'pine' ) . '</li></ul>';
		$rss->__destruct();
		unset( $rss );
		return;
	}

	echo '<ul>';
	foreach ( $rss->get_items( 0, $items ) as $item ) {
		$link = $item->get_link();
		while ( stristr( $link, 'http' ) != $link ) {
			$link = substr( $link, 1 );
		}
		$link = esc_url( strip_tags( $link ) );

		$title = esc_html( trim( strip_tags( $item->get_title() ) ) );
		if ( empty( $title ) ) {
			$title = __( 'Untitled', 'pine' );
		}

		$desc = @html_entity_decode( $item->get_description(), ENT_QUOTES, get_option( 'blog_charset' ) );
		$desc = esc_attr( wp_trim_words( $desc, 55, ' [&hellip;]' ) );

		$summary = '';
		if ( $show_summary ) {
			$summary = $desc;

			// Change existing [...] to [&hellip;].
			if ( '[...]' == substr( $summary, -5 ) ) {
				$summary = substr( $summary, 0, -5 ) . '[&hellip;]';
			}

			$summary = '<div class="rssSummary">' . esc_html( $summary ) . '</div>';
		}

		$date = '';
		if ( $show_date ) {
			$date = $item->get_date( 'U' );

			if ( $date ) {
				$date = ' <span class="rss-date">' . date_i18n( get_option( 'date_format' ), $date ) . '</span>';
			}
		}

		$author = '';
		if ( $show_author ) {
			$author = $item->get_author();
			if ( is_object( $author ) ) {
				$author = $author->get_name();
				$author = ' <cite>' . esc_html( strip_tags( $author ) ) . '</cite>';
			}
		}

		$read_more = '';
		if ( '' !== $link ) {
			$read_more = '<a href="' . $link . '" style="display: inline-block; width: 105px; height: 22px; line-height: 22px; color: #777; border: solid 1px #777; border-radius: 2px; text-align: center; text-decoration: none; margin-top: 10px; font-size: 11px;">' . __( 'Read more', 'pine' ) . '</a>';
		}

		if ( '' === $link ) {
			echo "<li>$title{$date}{$summary}{$author}</li>"; // WPCS: xss ok.
		} elseif ( $show_summary ) {
			echo "<li><a class='rsswidget' href='$link'>$title</a>{$date}{$summary}{$author}{$read_more}</li>"; // WPCS: xss ok.
		} else {
			echo "<li><a class='rsswidget' href='$link'>$title</a>{$date}{$author}{$read_more}</li>"; // WPCS: xss ok.
		}
	}
	echo '</ul>';
	$rss->__destruct();
	unset( $rss );
}

/**
 * Contribute metabox
 */
function pine_contribute_metabox() {
	?>
	<p>
	<?php
	printf(
		// translators: %s is a link to GitHub create an issue form.
		esc_html__( 'Found a bug? Create a %s.', 'pine' ),
		'<a href="https://github.com/themejack/pine/issues" target="_blank">' . esc_html__( 'new issue', 'pine' ) . '</a>'
	);
	?>
	<br />
	<?php
	printf(
		// translators: %s is a link to GitHub create a pull request form.
		esc_html__( 'Want to resolve an issue or create a new feature? Make a %s.', 'pine' ),
		'<a href="https://github.com/themejack/pine/pulls" target="_blank">' . esc_html__( 'pull request', 'pine' ) . '</a>'
	);
	?>
	<br />
	<?php
	printf(
		// translators: %s is a link to GitHub repository.
		esc_html__( 'For everything else %s.', 'pine' ),
		'<a href="https://github.com/themejack/pine" target="_blank">' . esc_html__( 'Github', 'pine' ) . '</a>'
	);
	?>
	</p>
	<?php
	// translators: %s is a name of GitHub repository.
	$watch_aria_label = sprintf( __( 'Watch %s on GitHub', 'pine' ), 'themejack/pine' );
	// translators: %s is a number of GitHub watchers.
	$watch_count_aria_label = sprintf( __( '%s watchers on GitHub', 'pine' ), '#' );

	// translators: %s is a name of GitHub repository.
	$issue_aria_label = sprintf( __( 'Issue %s on GitHub', 'pine' ), 'themejack/pine' );
	// translators: %s is a number of GitHub issues.
	$issue_count_aria_label = sprintf( __( '%s issues on GitHub', 'pine' ), '#' );

	// translators: %s is a name of GitHub repository.
	$fork_aria_label = sprintf( __( 'Fork %s on GitHub', 'pine' ), 'themejack/pine' );
	// translators: %s is a number of GitHub forks.
	$fork_count_aria_label = sprintf( __( '%s forks on GitHub', 'pine' ), '#' );
	?>
	<p class="github-buttons">
		<a
			class="github-button"
			href="https://github.com/themejack/pine"
			data-icon="octicon-eye"
			data-count-href="/themejack/pine/watchers"
			data-count-api="/repos/themejack/pine#subscribers_count"
			data-count-aria-label="<?php echo esc_attr( $watch_count_aria_label ); ?>"
			aria-label="<?php echo esc_attr( $watch_aria_label ); ?>">
			<?php esc_html_e( 'Watch', 'pine' ); ?>
		</a>
		<a
			class="github-button"
			href="https://github.com/themejack/pine/issues"
			data-icon="octicon-issue-opened"
			data-count-api="/repos/themejack/pine#open_issues_count"
			data-count-aria-label="<?php echo esc_attr( $issue_count_aria_label ); ?>"
			aria-label="<?php echo esc_attr( $issue_aria_label ); ?>">
			<?php esc_html_e( 'Issue', 'pine' ); ?>
		</a>
		<a
			class="github-button"
			href="https://github.com/themejack/pine/fork"
			data-icon="octicon-repo-forked"
			data-count-href="/themejack/pine/network"
			data-count-api="/repos/themejack/pine#forks_count"
			data-count-aria-label="<?php echo esc_attr( $fork_count_aria_label ); ?>"
			aria-label="<?php echo esc_attr( $fork_aria_label ); ?>">
			<?php esc_html_e( 'Fork', 'pine' ); ?>
		</a>
	</p>
	<?php
}

/**
 * Newsletter metabox
 */
function pine_newsletter_metabox() {
	?>
	<form action="//themejack.us3.list-manage.com/subscribe/post?u=4cb93458932f8621f1d708c6b&amp;id=747bf242f3" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
		<input type="email" value="" name="EMAIL" class="regular-text ltr" id="mce-EMAIL" placeholder="put your email address here" required>

		<div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_4cb93458932f8621f1d708c6b_747bf242f3" tabindex="-1" value=""></div>

		<br>
		<input type="submit" value="Subscribe" name="subscribe" id="mc-subscribe-button" class="button button-secondary">
	</form>
	<?php
}

/**
 * Pine admin page
 */
function pine_admin_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'pine' ) );
	}

	if ( isset( $_GET['reload_news'] ) && 1 === (int) $_GET['reload_news'] ) {
		pine_delete_dashboard_cached_rss_widget( 'dashboard_slicejack' );
		?>
		<script type="text/javascript">
			/* jshint ignore:start */
			window.location = '<?php echo esc_url( admin_url( 'themes.php?page=pine' ) ); ?>';
			/* jshint ignore:end */
		</script>
		<?php
		// Add anchor for users with javascript disabled in browser.
		?>
		<div class="wrap">
			<a href="<?php echo esc_url( admin_url( 'themes.php?page=pine' ) ); ?>"><?php esc_html_e( 'Click here', 'pine' ); ?></a>
		</div>
		<?php
		die();
	}

	$screen = get_current_screen();

	add_meta_box( 'pine_welcome', __( 'Welcome', 'pine' ), 'pine_welcome_metabox', $screen->id, 'normal' );
	add_meta_box( 'pine_notifications', __( 'Notifications', 'pine' ), 'pine_notifications_metabox', $screen->id, 'normal' );
	add_meta_box( 'pine_customize', __( 'Customize', 'pine' ), 'pine_customize_metabox', $screen->id, 'normal' );
	add_meta_box( 'pine_child_theme', __( 'Child theme', 'pine' ), 'pine_child_theme_metabox', $screen->id, 'normal' );
	add_meta_box( 'pine_contribute', __( 'Contribute to Pine', 'pine' ), 'pine_contribute_metabox', $screen->id, 'normal' );
	add_meta_box( 'pine_newsletter', __( 'Subscribe to our mailing list', 'pine' ), 'pine_newsletter_metabox', $screen->id, 'side', 'high' );
	add_meta_box( 'dashboard_slicejack', __( 'Slicejack News', 'pine' ), 'pine_sj_dashboard_widget', $screen->id, 'side', 'high' );
	?>
	<div class="wrap" id="pine-wrap">
		<h1 class="page-title"><?php esc_html_e( 'Pine', 'pine' ); ?> <sup class="version">1.1.0</sup></h1>
		<div id="dashboard-widgets-wrap">
			<div id="dashboard-widgets" class="metabox-holder columns-2">
				<div id="postbox-container-1" class="postbox-container">
				<?php do_meta_boxes( $screen->id, 'normal', '' ); ?>
				</div>
				<div id="postbox-container-2" class="postbox-container">
				<?php do_meta_boxes( $screen->id, 'side', '' ); ?>
				</div>
			</div>
		</div>
		<?php
		wp_nonce_field( 'closedpostboxes', 'closedpostboxesnonce', false );
		wp_nonce_field( 'meta-box-order', 'meta-box-order-nonce', false );
		?>
		<div class="page-footer">
			<div class="developer">
				<a href="<?php echo esc_url( 'http://slicejack.com' ); ?>" target="_blank"><img src="data:image/png;base64,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" /></a>
			</div>
		</div>
	</div>
	<?php
}

/**
 * Add menu page
 */
function pine_admin_page_menu() {
	add_theme_page( 'Pine', 'Pine', 'manage_options', 'pine', 'pine_admin_page' );
}
add_action( 'admin_menu', 'pine_admin_page_menu' );
