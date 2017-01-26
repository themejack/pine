<?php
/**
 * Pine Theme Customizer Controls
 *
 * @package Pine
 * @since 1.0
 */

/**
 * Customize Layout Control Class
 *
 * @package Pine
 * @since 1.0
 */
class Pine_Layout_Control extends WP_Customize_Control {
	/**
	 * Type variable
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'layout';

	/**
	 * Layouts variable
	 *
	 * @access public
	 * @var array
	 */
	public $layouts;

	/**
	 * Constructor.
	 *
	 * @since 1.0
	 * @uses WP_Customize_Control::__construct()
	 *
	 * @param WP_Customize_Manager $manager WP_Customize_Manager class.
	 * @param string               $id Control id.
	 * @param array                $args Control args.
	 */
	public function __construct( $manager, $id, $args = array() ) {
		$this->layouts = $args['layouts'];
		parent::__construct( $manager, $id, $args );
	}

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @since 1.0
	 */
	public function enqueue() {
		wp_enqueue_style( 'pine-customize-control-layout', get_template_directory_uri() . '/admin/css/pine-customize-control-layout.css', array( 'customize-controls' ), '20150610', 'all' );
		wp_enqueue_script( 'pine-customize-control-layout', get_template_directory_uri() . '/admin/js/pine-customize-control-layout.js', array( 'customize-controls', 'jquery' ), '20140806', true );
	}

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @since 1.0
	 * @uses WP_Customize_Control::to_json()
	 */
	public function to_json() {
		parent::to_json();
		$this->json['layouts'] = $this->layouts;
	}

	/**
	 * Render the control's content.
	 *
	 * @since 1.0
	 */
	public function render_content() {
		if ( empty( $this->layouts ) ) {
			return;
		}

		$name = '_customize-layout-' . $this->id;

		?>
		<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
		<div class="customize-control-content">
			<div class="radios">
			<?php
			foreach ( $this->layouts as $value => $layout ) :
				?>
				<label>
					<input type="radio" value="<?php echo esc_attr( $value ); ?>" name="<?php echo esc_attr( $name ); ?>" <?php $this->link(); ?> <?php checked( $this->value(), $value ); ?> />
					<?php echo esc_html( $layout['label'] ); ?><br/>
				</label>
				<?php
			endforeach;
			?>
			</div>
			<div class="selection"><!--
			<?php
			foreach ( $this->layouts as $value => $layout ) :
				?>
				--><div class="layout" data-value="<?php echo esc_attr( $value ); ?>">
					<div class="icon"><?php echo esc_html( $layout['label'] ); ?></div>
				</div><!--
				<?php
			endforeach;
			?>
			--></div>
		</div>
		<?php
	}
}

/**
 * Customize Color Scheme Control Class
 *
 * @package Pine
 * @since 1.0
 */
class Pine_Color_Scheme_Control extends WP_Customize_Control {
	/**
	 * Type variable
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'color-scheme';

	/**
	 * Schemes variable
	 *
	 * @access public
	 * @var array
	 */
	public $schemes;

	/**
	 * Constructor.
	 *
	 * @since 1.0
	 * @uses WP_Customize_Control::__construct()
	 *
	 * @param WP_Customize_Manager $manager WP_Customize_Manager class.
	 * @param string               $id Control id.
	 * @param array                $args Control args.
	 */
	public function __construct( $manager, $id, $args = array() ) {
		$this->schemes = $args['schemes'];
		parent::__construct( $manager, $id, $args );
	}

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @since 1.0
	 */
	public function enqueue() {
		wp_enqueue_style( 'pine-customize-control-color-scheme', get_template_directory_uri() . '/admin/css/pine-customize-control-color-scheme.css', array( 'customize-controls' ), '20150610', 'all' );
		wp_enqueue_script( 'pine-customize-control-color-scheme', get_template_directory_uri() . '/admin/js/pine-customize-control-color-scheme.js', array( 'customize-controls', 'jquery' ), '20150610', true );
	}

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @since 1.0
	 * @uses WP_Customize_Control::to_json()
	 */
	public function to_json() {
		parent::to_json();
		$this->json['schemes'] = $this->schemes;
	}

	/**
	 * Render the control's content.
	 *
	 * @since 1.0
	 */
	public function render_content() {
		if ( empty( $this->schemes ) ) {
			return;
		}

		$name = '_customize-schemes-' . $this->id;

		?>
		<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
		<div class="customize-control-content">
			<div class="radios">
			<?php
			foreach ( $this->schemes as $value => $scheme ) :
				?>
				<label>
					<input type="radio" value="<?php echo esc_attr( $value ); ?>" name="<?php echo esc_attr( $name ); ?>" <?php $this->link(); ?> <?php checked( $this->value(), $value ); ?> />
					<?php echo esc_html( $scheme['label'] ); ?><br/>
				</label>
				<?php
			endforeach;
			?>
			</div>
			<div class="selection"><!--
			<?php
			foreach ( $this->schemes as $value => $scheme ) :
				?>
				--><div class="scheme" data-value="<?php echo esc_attr( $value ); ?>">
					<div class="color" style="<?php echo esc_attr( 'background-color: ' . $scheme['color'] . ';' ); ?>"></div>
				</div><!--
				<?php
			endforeach;
			?>
			--></div>
		</div>
		<?php
	}
}

/**
 * Customize Social Buttons Control Class
 *
 * @package Pine
 * @since 1.0
 */
class Pine_Social_Buttons_Control extends WP_Customize_Control {
	/**
	 * Type variable
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'social-buttons';

	/**
	 * Socials variable
	 *
	 * @access public
	 * @var array
	 */
	public $socials;

	/**
	 * Constructor.
	 *
	 * @since 1.0
	 * @uses WP_Customize_Control::__construct()
	 *
	 * @param WP_Customize_Manager $manager WP_Customize_Manager class.
	 * @param string               $id Control id.
	 * @param array                $args Control args.
	 */
	public function __construct( $manager, $id, $args = array() ) {
		$this->socials = $args['socials'];
		parent::__construct( $manager, $id, $args );
	}

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @since 1.0
	 */
	public function enqueue() {
		wp_enqueue_style( 'pine-customize-control-social-buttons', get_template_directory_uri() . '/admin/css/pine-customize-control-social-buttons.css', array( 'customize-controls' ), '20150610', 'all' );
		wp_enqueue_script( 'pine-customize-control-social-buttons', get_template_directory_uri() . '/admin/js/pine-customize-control-social-buttons.js', array( 'customize-controls', 'jquery' ), '20150610', true );
	}

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @since 1.0
	 * @uses WP_Customize_Control::to_json()
	 */
	public function to_json() {
		parent::to_json();
		$this->json['socials'] = $this->socials;
	}

	/**
	 * Render the control's content.
	 *
	 * @since 1.0
	 */
	public function render_content() {
		if ( empty( $this->socials ) ) {
			return;
		}

		$name = '_customize-social-buttons-' . $this->id;

		?>
		<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
		<div class="customize-control-content">
			<script type="text/html" id="tmpl-social-button">
				<div class="social-button">
				<# var socialValue = data.social == 'custom' ? data.socialValue : data.social; #>
					<div class="preview">
						<div class="social-button-preview"><div class="social-icon<# if ( data.cssClass ) { #> social-icons--{{ data.cssClass }}<# } #>"></div><div class="social-value">{{ socialValue }}</div></div>
						<div class="reorder-button move-down"><?php esc_html_e( 'Move down', 'pine' ); ?></div>
						<div class="reorder-button move-up"><?php esc_html_e( 'Move up', 'pine' ); ?></div>
						<div class="remove-button"><?php esc_html_e( 'Remove', 'pine' ); ?></div>
					</div>
					<div class="fields"<# if ( !data.editing ) { #> style="display: none"<# } #>>
						<input type="hidden" class="css-class"<# if ( data.cssClass ) { #> value="{{ data.cssClass }}"<# } #>>
						<select class="social">
						<?php foreach ( $this->socials as $value => $social ) : ?>
							<option value="<?php echo esc_attr( $value ); ?>"<# if ( data.social == '<?php echo esc_attr( $value ); ?>' ) { #> selected="selected"<# } #>><?php echo esc_html( $social['label'] ); ?></option>
							<?php
						endforeach;
						?>
							<option value="custom"<# if ( data.social == 'custom' ) { #> selected="selected"<# } #>><?php esc_html_e( 'Custom', 'pine' ); ?></option>
						</select>
						<br /><br />
						<div class="custom-social"<# if ( data.social != 'custom' ) { #>  style="display: none"<# } #>>
							<input type="text" placeholder="<?php echo esc_attr( __( 'Social Network Name', 'pine' ) ); ?>"<# if ( data.cssClass ) { #> value="{{ data.cssClass }}"<# } #> />
							<br /><br />
						</div>
						<input type="text" placeholder="<?php echo esc_attr( __( 'URL', 'pine' ) ); ?>" class="url"<# if ( data.url ) { #> value="{{ data.url }}"<# } #> />
					</div>
				</div>
			</script>
			<div class="actions">
				<a href="javascript:void(null)" class="button add-social-button"><?php esc_html_e( 'New Social Button', 'pine' ); ?></a>
			</div>
			<br />
			<div class="social-buttons"></div>
			<br />
			<div class="actions">
				<a href="javascript:void(null)" class="button add-social-button"><?php esc_html_e( 'New Social Button', 'pine' ); ?></a>
			</div>
		</div>
		<?php
	}
}
