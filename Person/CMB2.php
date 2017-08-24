<?php
/**
 * @author    WPStore.io <code@wpstore.io>
 * @copyright Copyright (c) 2014-2015, WPStore.io
 * @license   https://www.gnu.org/licenses/gpl-2.0.html GPL-2.0+
 * @package   WPStore\Plugins\Person
 */

namespace WPStore\Plugins\Person;

/**
 * Register UI for the Meta Fields via CMB2
 *
 * @since 0.0.2
 */
class CMB2 {

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
	public static function processor_cmb2() {

		$prefix = '_person_';
		$fields = \WPStore\Plugins\Person\CPT::meta_fields();

		/**
		 * Initiate the metabox
		 */
		$cmb = new_cmb2_box(
			array(
				'id'			 => 'person_personal_details',
				'title'			 => __( 'Personal Details', 'cpt-person' ),
				'object_types'	 => array( 'person' ), // Post type
				'context'		 => 'after_title',
				'priority'		 => 'high',
				'show_names'	 => true,
			)
		);

		foreach ( $fields as $field_id => $values ) {
			$cmb->add_field(
				array(
					'name'	 => $values['name'],
					'desc'	 => $values['desc'],
					'id'	 => $prefix . $field_id,
					'type'	 => $values['type']['cmb2'],
				)
			);
		}

	} // END processor_cmb2()

} // END class
