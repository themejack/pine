<?php
/**
 * Notifications.
 *
 * @package Pine
 * @since   1.1.0
 */

/**
 * Notifications class.
 *
 * @since 1.1.0
 */
class Pine_Notifications {
	/**
	 * Link to the theme.
	 *
	 * @var   string
	 * @since 1.1.0
	 */
	const THEME_LINK = 'https://themeforest.net/item/pine-pro-responsive-portfolio-wordpress-theme/19814218';

	/**
	 * Theme name.
	 *
	 * @var   string
	 * @since 1.1.0
	 */
	const THEME_NAME = 'Pine PRO';

	/**
	 * List of notifications to show.
	 *
	 * @var   array
	 * @since 1.1.0
	 */
	private $notifications;

	/**
	 * Returns the instance of Pine_Notications class.
	 *
	 * @since 1.1.0
	 */
	public static function get_instance() {
		static $instance = null;

		if ( null === $instance ) {
			$instance = new Pine_Notifications();
		}

		return $instance;
	}

	/**
	 * Pine_Notifications constructor.
	 *
	 * @since 1.1.0
	 */
	private function __construct() {
		$this->notifications = array(
			sprintf(
				// translators: %s is a link to the theme.
				esc_html__( 'We are happy to inform you that Pine PRO theme is available for purchase. %s', 'pine' ),
				$this->get_theme_link( esc_html__( 'Get it!', 'pine' ) )
			),
			sprintf(
				// translators: %s is a link to the theme.
				esc_html__( '460+ Customizable Design Options, Drag and Drop Page Builder, 800+ Google Fonts and more. %s', 'pine' ),
				$this->get_theme_link()
			),
			sprintf(
				// translators: %s is a link to the theme.
				esc_html( 'We’ve got great news! Pine PRO is now available for download. %s', 'pine' ),
				$this->get_theme_link( esc_html__( 'Get it!', 'pine' ) )
			),
		);

		add_action( 'admin_notices', array( $this, 'admin_notice' ) );
		add_action( 'wp_ajax_pine_notification_dismiss', array( $this, 'handle_ajax_dismiss' ) );
		add_action( 'wp_ajax_pine_reset_notification_dismiss', array( $this, 'handle_ajax_reset_dismiss' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue' ) );
	}

	/**
	 * Admin notices
	 *
	 * @since  1.1.0
	 * @return void
	 */
	public function admin_notice() {
		if ( ! $this->should_display_notification() ) {
			return;
		}

		$notification = $this->get_next_notification();

		if ( empty( $notification ) ) {
			return;
		}

		?>
		<div class="notice notice-info is-dismissible pine-notice">
			<p>
			<?php
			echo $notification; // WPCS: xss ok.
			?>
			</p>
		</div>
		<?php
	}

	/**
	 * Display all notifications
	 *
	 * @return void
	 */
	public function display_all() {
		if ( empty( $this->notifications ) ) {
			return;
		}

		$notification = $this->get_next_notification();

		if ( empty( $notification ) ) {
			return;
		}

		?>
		<div class="notice notice-info inline pine-notice">
			<p>
			<?php
			echo $notification; // WPCS: xss ok.
			?>
			</p>
		</div>
		<?php
	}

	/**
	 * Handle ajax notification dismiss
	 *
	 * @return void
	 */
	public function handle_ajax_dismiss() {
		if ( empty( $_REQUEST['action'] ) || 'pine_notification_dismiss' !== $_REQUEST['action'] ) {
			return;
		}

		update_option( 'pine_pine-pro_dismissed_timestamp_' . get_current_user_id(), current_time( 'timestamp', true ) );

		echo wp_json_encode( array(
			'success' => true,
		) );
		die();
	}

	/**
	 * Handle ajax reset notification dismiss
	 *
	 * @return void
	 */
	public function handle_ajax_reset_dismiss() {
		if ( empty( $_REQUEST['action'] ) || 'pine_reset_notification_dismiss' !== $_REQUEST['action'] ) {
			return;
		}

		update_option( 'pine_pine-pro_dismissed_timestamp_' . get_current_user_id(), 0 );

		echo wp_json_encode( array(
			'success' => true,
		) );
		die();
	}

	/**
	 * Enqueue admin scripts and styles.
	 *
	 * @return void
	 */
	public function admin_enqueue() {
		wp_enqueue_script( 'pine-notifications', get_template_directory_uri() . '/admin/js/pine-notifications.js', array( 'jquery' ), true );
	}

	/**
	 * Should display notification
	 *
	 * @since  1.1.0
	 * @return boolean
	 */
	private function should_display_notification() {
		$wp_themes = wp_get_themes();

		// Bail out early if Pine PRO is already installed.
		if ( array_key_exists( 'pine-pro', $wp_themes ) ) {
			return false;
		}

		$timezone = new DateTimeZone( 'UTC' );
		$dismissed_timestamp = get_option( 'pine_pine-pro_dismissed_timestamp_' . get_current_user_id(), 0 );
		$dismissed = new DateTime();
		$dismissed->setTimezone( $timezone );
		$dismissed->setTimestamp( $dismissed_timestamp );

		$reset_datetime = new DateTime( '-30day', $timezone );

		if ( $reset_datetime > $dismissed ) {
			return true;
		}

		return false;
	}

	/**
	 * Returns next notification
	 *
	 * @since  1.1.0
	 * @return string
	 */
	private function get_next_notification() {
		$last_notification = (int) get_option( 'pine_pine-pro_last_notification_index_' . get_current_user_id(), -1 );

		if (
			! is_int( $last_notification ) ||
			$last_notification < 0 ||
			$last_notification >= ( count( $this->notifications ) - 1 )
		) {
			$notification_index = 0;
		} else {
			$notification_index = $last_notification + 1;
		}

		update_option( 'pine_pine-pro_last_notification_index_' . get_current_user_id(), $notification_index );

		return $this->notifications[ $notification_index ];
	}

	/**
	 * Returns theme link html anchor.
	 *
	 * @since  1.1.0
	 * @param  string $label Label of the anchor.
	 * @return string
	 */
	private function get_theme_link( $label = '' ) {
		if ( empty( $label ) ) {
			$label = esc_html__( 'Download Pine PRO', 'pine' );
		}

		return '<a class="button button-primary" href="' . self::THEME_LINK . '" target="_blank">' . $label . '</a>';
	}
}
