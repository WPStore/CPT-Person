<?php
/**
 * @author    WPStore.io <code@wpstore.io>
 * @copyright Copyright (c) 2014-2015, WPStore.io
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GPL-2.0+
 * @package   WPStore\CPT\Person
 */

namespace WPStore\CPT\Person;

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
	public static function init() {

		// Bail if other helpers are present
		if ( ! class_exists( 'Acf' ) || class_exists( 'CMB2' ) ) {
			return;
		}

		add_action( 'admin_init', array( __CLASS__, 'add_fields' ) ); // @todo ACF-specific hook?

	} // END __construct()

	public static function add_fields() {

		$acf = array(
			'id'	     => 'cpt-person-fields',
			'title'	     => __( 'Personal Details', 'cpt-person' ),
			'fields'     => self::fields(),
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

	} // END add_fields()

	private static function fields() {

		$meta_fields = \WPStore\CPT\Person\CPT::meta_fields();
		$fields      = array();

		$fields[] = array(
			'label' => __( 'Main Details', 'cpt-person' ),
			'name'  => '_person_tab_main',
			'key'   => '_person_tab_main',
			'type' => 'tab',
		);

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
