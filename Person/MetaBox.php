<?php
/**
 * @author    WPStore.io <code@wpstore.io>
 * @copyright Copyright (c) 2015-2017, WPStore.io
 * @license   https://www.gnu.org/licenses/gpl-2.0.html GPL-2.0+
 * @package   WPStore\Plugins\Person
 */

namespace WPStore\Plugins\Person;

/**
 * Register UI for the Meta Fields via CMB2
 *
 * @since 0.0.2
 */
class MetaBox {

	/**
	 * Constructor. Hooks all interactions to initialize the class.
	 *
	 * @since 0.0.1
	 *
	 * @return void
	 */
	public static function init() {

		// Bail if other helpers are present
//		if ( class_exists( 'Acf' ) ) {
//			return;
//		}


	} // END init()

	/**
	 * Define the metabox and field configurations.
	 */
	public static function generate_fields( $meta_boxes ) {

		$prefix = '_person_';
		$fields = \WPStore\Plugins\Person\CPT::meta_fields();

		foreach ( $fields as $field_id => $values ) {

			$field_details[] = array(
				'name'	 => $values['name'],
				'desc'	 => $values['desc'],
				'id'	 => $prefix . $field_id,
				'type'	 => $values['type']['metabox'],
			);

		} // END foreach

		$meta_boxes[] = array(
			'id'		 => 'person_personal_details',
			'title'		 => __( 'Personal Details', 'cpt-person' ),
			'post_types' => array( 'person' ),
			'context'	 => 'normal',
			'priority'	 => 'high',
			'fields'	 => array(
				$field_details,
			),
		);

		return $meta_boxes;

	} // END processor_cmb2()

} // END class
