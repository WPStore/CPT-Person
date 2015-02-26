<?php
/**
 * @author    WPStore.io <code@wpstore.io>
 * @copyright Copyright (c) 2014-2015, WPStore.io
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GPL-2.0+
 * @package   WPStore\CPT\Person
 */

namespace WPStore\CPT\Person;

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
		if ( class_exists( 'Acf' ) ) {
			return;
		}

		add_filter( 'cmb2_meta_boxes', array( __CLASS__, 'add_metabox' ) );

	} // END init()

	public static function add_metabox( $meta_boxes ) {

		$meta_boxes['cpt-person-fields'] = array(
			'id'           => 'cpt-person-fields',
			'title'        => __( 'Personal Details', 'cpt-person' ),
			'object_types' => array( 'person', ),
			'context'      => 'normal',
			'priority'     => 'high',
			'show_names'   => true, // Show field names on the left
			'fields'       => self::fields(),
		);

		return $meta_boxes;

	} // END add_metabox()

	private static function fields() {

		$meta_fields = \WPStore\CPT\Person\CPT::meta_fields();
		$fields      = array();

		foreach ( $meta_fields as $key => $value ) {

			$fields[] = array(
				'name' => $value['title'],
				'id'   => '_person_'.$key,
				'type' => $value['type']['cmb2'],
			);

		} // END foreach

		return $fields;

	 } // END fields()

} // END class CMB2
