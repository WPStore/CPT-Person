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
class CMB2 {

	/**
	 * Constructor. Hooks all interactions to initialize the class.
	 *
	 * @since 0.0.1
	 *
	 * @return void
	 */
	public function __construct() {

		// Bail if other helpers are present
		if ( defined( 'PODS_VERSION' ) || class_exists( 'Acf' ) ) {
			return;
		}

		add_filter( 'cmb2_meta_boxes', array( $this, 'add_metabox' ) );

	} // END __construct()

	public function add_metabox( $meta_boxes ) {

		$meta_boxes['cpt-person-fields'] = array(
			'id'           => 'cpt-person-fields',
			'title'        => __( 'Personal Details', 'cpt-person' ),
			'object_types' => array( 'person', ),
			'context'      => 'normal',
			'priority'     => 'high',
			'show_names'   => true, // Show field names on the left
			'fields'       => $this->fields(),
		);

		return $meta_boxes;

	}

	private function fields() {

		$meta_fields = \CPT\Person\CPT::meta_fields();
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
