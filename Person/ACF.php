<?php
/**
 * @author    Christian Foellmann <foellmann@foe-services.de>
 * @copyright Copyright (c) 2014, Christian Foellmann
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GPL-2.0+
 * @package   CPT\Person
 */

namespace CPT\Person;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Register UI for the Meta Fields via ACF
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

		// Bail if other helpers are present
		if ( ! class_exists( 'Acf' ) || defined( 'PODS_VERSION' ) || class_exists( 'CMB2' ) ) {
			return;
		}

		add_action( 'admin_init', array( $this, 'add_fields' ) ); // @todo ACF-specific hook?

	} // END __construct()

	public function add_fields() {

		$acf = array(
			'id'	     => 'cpt-person-fields',
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
		$fields      = array();

		foreach ( $meta_fields as $key => $value ) {

			$fields[] = array(
				'label' => $value['title'],
				'name'  => '_person_'.$key,
				'key'   => '_person_'.$key,
				'type'  => $value['type']['acf'],
			);

		} // END foreach

		return $fields;

	 } // END fields()

} // END class ACF
