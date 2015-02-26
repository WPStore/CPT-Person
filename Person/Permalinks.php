<?php
/**
 * @author    WPStore.io <code@wpstore.io>
 * @copyright Copyright (c) 2014-2015, WPStore.io
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GPL-2.0+
 * @package   WPStore\CPT\Person
 */

namespace WPStore\CPT\Person;

/**
 * @todo
 *
 * @since 0.0.1
 */
class Permalinks {

	/**
	 * Constructor. Hooks all interactions to initialize the class.
	 *
	 * @since 0.0.1
	 *
	 * @return void
	 */
	public static function init() {

		add_action( 'load-options-permalink.php', array( __CLASS__, 'permalink_base' ) );

	} // END __construct()

	 public static function permalink_base() {

		// @todo nonce
		// wp_verify_nonce('update-permalink') does not work!?
		if ( isset( $_POST['cpt_person_base'] ) ) {
			update_option( 'cpt_person_base', sanitize_title_with_dashes( $_POST['cpt_person_base'] ) );
		}

		// check if section already exists
		add_settings_section(
			'cpt-rewrites',
			__( 'Custom Post Type Rewrites', 'cpt-person' ),
			'__return_empty_string', //array( $this, 'show_description' ),
			'permalink'
		);

		add_settings_field(
			'cpt_person_base',
			'<label for="cpt_person_base">' . __( 'Person base', 'cpt-person' ) . '</label>',
			array( __CLASS__, 'permalink_base_callback' ),
			'permalink',
			'cpt-rewrites'
		);

	}

	public static function permalink_base_callback( $args ) {

		$value = get_option(
			'cpt_person_base',
			apply_filters( 'cpt_person_option_base', 'person' )
		);

//		wp_nonce_field('update-cpt-permalink');

		echo '<input id="cpt_person_base" class="regular-text code" type="text" value="' . esc_attr( $value ) . '" name="cpt_person_base" />';

	} // END permalink_base_callback()

} // END class
