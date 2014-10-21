<?php
/**
 * @author    WP-Store.io <code@wp-store.io>
 * @copyright Copyright (c) 2014, WP-Store.io
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GPL-2.0+
 * @package   CPT\Person
 */

namespace CPT\Person;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * @todo
 *
 * @since 0.0.1
 */
class ACF {

	/**
	 * Constructor. Hooks all interactions to initialize the class.
	 *
	 * @since 0.0.1
	 *
	 * @return void
	 */
	public function __construct() {

		if ( ! class_exists( 'Acf' ) ) {
			return;
		}

		if ( ! defined( 'PODS_VERSION' ) ) {

			add_action( 'admin_init', array( $this, 'register_fields' ) ); // @todo ACF-specific hook

		}

	} // END __construct()

	public function register_fields() {

		$acf = array(
			'id'	     => 'acf_cpt-person-fields',
			'title'	     => __( 'Personal Details', 'cpt-person' ),
			'fields'     => $this->fields(),
			'location'   => array (
				array (
					array (
						'param' => 'post_type',
						'operator' => '==',
						'value' => 'person',
						'order_no' => 0,
						'group_no' => 0,
					),
				),
			),
			'options'    => array (
				'position'       => 'normal',
				'layout'         => 'default',
				'hide_on_screen' => array(),
			),
			'menu_order' => 0,
		);

		register_field_group( $acf );

	} // END register_meta_via_acf()

	 private function fields() {

		 $meta_fields = \CPT\Person\CPT::meta_fields();

	 }

} // END class Pods
