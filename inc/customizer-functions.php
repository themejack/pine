<?php
/**
 * Pine Theme Customizer extra functions
 *
 * @package Pine
 * @since 1.0
 */

/**
 * Sanitize text trim
 *
 * @param  string $value String.
 * @return string        Sanitized string.
 */
function sanitize_text_trim( $value ) {
	if ( empty( $value ) ) {
		return '';
	}
	return trim( $value );
}

/**
 * Sanitize social buttons value
 *
 * @param  array $value Social buttons value.
 * @return array        Sanitized array
 */
function sanitize_social_buttons( $value ) {
	if ( ! is_array( $value ) ) {
		return array();
	}

	return $value;
}

/**
 * Sanitize select
 */
class Sanitize_Select {
	/**
	 * Select keys
	 * @var array
	 */
	public $keys;

	/**
	 * Default value
	 * @var array|string
	 */
	public $default_value;

	/**
	 * Sanitize Select constructor
	 * @param array  $keys          Keys that will be sanitized.
	 * @param string $default_value Default value.
	 */
	public function Sanitize_Select( $keys, $default_value = '' ) {
		$this->keys = $keys;
		$this->default_value = $default_value;
	}

	/**
	 * Sanitize callback
	 * @param  string $value Selected value.
	 * @return string
	 */
	public function callback( $value ) {
		if ( ! in_array( $value, $this->keys ) ) {
			return $this->default_value;
		}

		return $value;
	}
}
