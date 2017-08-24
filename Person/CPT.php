<?php
/**
 * @author    WPStore.io <code@wpstore.io>
 * @copyright Copyright (c) 2014-2017, WPStore.io
 * @license   https://www.gnu.org/licenses/gpl-2.0.html GPL-2.0+
 * @package   WPStore\Plugins\Person
 */

namespace WPStore\Plugins\Person;

/**
 * @todo
 *
 * @since 0.1.0
 */
class CPT {

	public function __construct() {

		add_action( 'init', array( '\WPStore\Plugins\Person\CPT', 'register_cpt' ) );
		add_action( 'init', array( '\WPStore\Plugins\Person\CPT', 'register_meta' ) );

	}

	/**
	 * @todo add hooks
	 */
	public static function register_cpt() {

		$labels = array(
			'name'                  => _x( 'Persons', 'post type general/plural name', 'cpt-person' ),
			'singular_name'         => _x( 'Person', 'post type singular name',        'cpt-person' ),
//			'add_new'               => __( 'Add New Person', 'cpt-person' ),
			'add_new_item'          => __( 'Add New Person',                           'cpt-person' ),
			'edit_item'             => __( 'Edit Person',                              'cpt-person' ),
			'new_item'              => __( 'New Person',                               'cpt-person' ),
			'view_item'             => __( 'View Person',                              'cpt-person' ),
			'search_items'          => __( 'Search Persons',                           'cpt-person' ),
			'not_found'             => __( 'No Persons found',                         'cpt-person' ),
			'not_found_in_trash'    => __( 'No Persons found in the trash',            'cpt-person' ),
			'featured_image'        => __( 'Photo',                                    'cpt-person' ),
			'set_featured_image'    => __( 'Set Photo',                                'cpt-person' ),
			'remove_featured_image' => __( 'Remove Photo',                             'cpt-person' ),
		);

		$supports = array( 'title', 'editor', 'thumbnail', 'revisions' ); // 'excerpt',

		$cpt_args = array(
//			'description'         => '',
			'labels'              => apply_filters( "cpt-person/cpt/labels", $labels ),
			'public'              => true,
			'show_ui'             => true,
			'publicly_queryable'  => true,
			'query_var'           => true,
			'exclude_from_search' => true,
			'show_in_nav_menus'   => false,
			'capability_type'     => 'post',
			'has_archive'         => false,
			'hierarchical'        => false,
			'rewrite'             => array(
				'slug'       => get_option( 'cpt_person_base', 'person' ),
				'with_front' => false,
				'pages'      => true,
				'feeds'      => false,
				'ep_mask'    => EP_PERMALINK
			),
			'supports'            => apply_filters( "cpt-person/cpt/supports", $supports ),
			'menu_icon'           => 'dashicons-admin-users',
			'can_export'          => true,
		 );

		 register_post_type( 'person', $cpt_args );

	} // END register_cpt()

	public static function register_meta() {

		/**
		 * Set the library to process the meta field definitions
		 *
		 * @todo detect processors
		 * @todo Compat ACF, ACF Pro (5), Meta Box (metabox.io), Pods
		 */

		$processor_active = 'cmb2';
		$processor = apply_filters( "cpt-person/cpt/meta_processor", $processor_active );
		$base = \WPStore\Plugins\wpstore_cpt_person()->path;

		if ( $processor == 'cmb2' ) {

			require_once( $base . '/Person/CMB2.php' );
			add_action( 'cmb2_admin_init', array( '\WPStore\Plugins\Person\CMB2', 'processor_cmb2' ) );

		} else if ( $processor == 'acf' ) {

			// https://wordpress.org/plugins/advanced-custom-fields/
			// require_once( $base . '/Person/ACF.php' );

//		} else if ( $processor == 'meta-box' ) {
//			// https://wordpress.org/plugins/meta-box/
//		} else if ( $processor == 'pods' ) {
//			// https://wordpress.org/plugins/pods/
		} else {
			// @todo ERROR vs plugin-less registration (complex!)
			return;
		}

	} // END

	public static function meta_fields() {

		$meta_fields = array(
//			'given_name'  => array( '_person_given_name', 'text' ),
//			'family_name' => array( '_person_family_name', 'text' ),
			'address'     => array(
				'title' => __( 'Address', 'cpt-person' ),
				'type'  => array(
					'cmb2' => 'text',
					'acf'  => 'text',
				),
			),
			'telephone'   => array(
				'title' => __( 'Telephone', 'cpt-person' ),
				'type'  => array(
					'cmb2' => 'text',
					'acf'  => 'text',
				),
			),
			'email'       => array(
				'title' => __( 'Email', 'cpt-person' ),
				'type'  => array(
					'cmb2' => 'text_email',
					'acf'  => 'text',
				),
			),
			'website'     => array(
				'title' => __( 'Website', 'cpt-person' ),
				'type'  => array(
					'cmb2' => 'text_url',
					'acf'  => 'text',
				),
			),
//			'social'      => array( '_person_social', 'text' ), // repeater
//			'email'       => array( '_person_email', 'email' ), // repeater
		);

		return apply_filters( "cpt-person/meta/fields", $meta_fields );

	} // END meta_fields()

} // END class CPT
