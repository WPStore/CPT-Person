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

		$fields = \WPStore\Plugins\Person\CPT::meta_fields();

		// Start with an underscore to hide fields from custom fields list
		$prefix = 'person_';

		/**
		 * Initiate the metabox
		 */
		$cmb = new_cmb2_box( array(
			'id'			 => 'personal_details',
			'title'			 => __( 'Personal Details', 'cpt-person' ),
			'object_types'	 => array( 'person' ), // Post type
			'context'		 => 'after_title',
			'priority'		 => 'high',
			'show_names'	 => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // Keep the metabox closed by default
		) );

		// Regular text field
		$cmb->add_field( array(
			'name'		 => __( 'Test Text', 'cpt-person' ),
			'desc'		 => __( 'field description (optional)', 'cpt-person' ),
			'id'		 => $prefix . 'text',
			'type'		 => 'text',
			'show_on_cb' => 'cmb2_hide_if_no_cats', // function should return a bool value
		// 'sanitization_cb' => 'my_custom_sanitization', // custom sanitization callback parameter
		// 'escape_cb'       => 'my_custom_escaping',  // custom escaping callback parameter
		// 'on_front'        => false, // Optionally designate a field to wp-admin only
		// 'repeatable'      => true,
		) );

		// URL text field
		$cmb->add_field( array(
			'name'	 => __( 'Website URL', 'cpt-person' ),
			'desc'	 => __( 'field description (optional)', 'cpt-person' ),
			'id'	 => $prefix . 'url',
			'type'	 => 'text_url',
		// 'protocols' => array('http', 'https', 'ftp', 'ftps', 'mailto', 'news', 'irc', 'gopher', 'nntp', 'feed', 'telnet'), // Array of allowed protocols
		// 'repeatable' => true,
		) );

		// Email text field
		$cmb->add_field( array(
			'name'	 => __( 'Test Text Email', 'cpt-person' ),
			'desc'	 => __( 'field description (optional)', 'cpt-person' ),
			'id'	 => $prefix . 'email',
			'type'	 => 'text_email',
		// 'repeatable' => true,
		) );

		// Add other metaboxes as needed
	}

} // END class
