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
class CPT {

	/**
	 * Constructor. Hooks all interactions to initialize the class.
	 *
	 * @since 0.0.1
	 *
	 * @return void
	 */
	public function __construct() {

		add_action( 'init', array( $this, 'register_cpt' ) );

	} // END __construct()

	/**
	 * @todo add hooks
	 */
	public static function register_cpt() {

		$labels = array(
			'name'               => _x( 'Persons', 'post type general name', 'cpt-person' ),
			'singular_name'      => _x( 'Person', 'post type singular name', 'cpt-person' ),
//			'add_new'            => __( 'Add New Person', 'cpt-person' ),
			'add_new_item'       => __( 'Add New Person', 'cpt-person' ),
			'edit_item'          => __( 'Edit Person', 'cpt-person' ),
			'new_item'           => __( 'New Person', 'cpt-person' ),
			'view_item'          => __( 'View Person', 'cpt-person' ),
			'search_items'       => __( 'Search Persons', 'cpt-person' ),
			'not_found'          => __( 'No Persons found', 'cpt-person' ),
			'not_found_in_trash' => __( 'No Persons found in the trash', 'cpt-person' ),
		);

		$supports = array( 'title', 'editor', 'thumbnail', 'excerpt', 'revisions', 'page-attributes' );

		$cpt_args = array(
			'labels' 			  => apply_filters( 'cpt_person_cpt_labels', $labels ),
			'public' 			  => true,
			'show_ui' 			  => true,
			'publicly_queryable'  => true,
			'query_var'			  => true,
			'exclude_from_search' => true,
			'show_in_nav_menus'	  => false,
			'capability_type' 	  => 'post',
			'has_archive' 		  => true,
			'hierarchical' 		  => true,
			'rewrite' 			  => array(
				'slug'       => get_option( 'cpt_person_base', 'person' ),
				'with_front' => false
			),
			'supports' 			  => apply_filters( 'cpt_person_cpt_supports', $supports ),
			'menu_icon' 		  => 'dashicons-groups',
		 );

		 register_post_type( 'person', $cpt_args );

	} // END register_cpt()

	static function meta_fields() {

		$meta_fields = array(
//			'given_name'  => array( '_person_given_name', 'text' ),
//			'family_name' => array( '_person_family_name', 'text' ),
			'address'     => array(
				'title' => __( 'Address', 'cpt-person' ),
				'type' => array(
					'acf'  => 'text',
					'cmb2' => 'text',
					'pods' => 'text',
				),
			),
			'telephone'     => array(
				'title' => __( 'Telephone', 'cpt-person' ),
				'type' => array(
					'acf'  => 'text',
					'cmb2' => 'text',
					'pods' => 'text',
				),
			),
			'email'     => array(
				'title' => __( 'Email', 'cpt-person' ),
				'type' => array(
					'acf'  => 'text',
					'cmb2' => 'text_email',
					'pods' => 'text',
				),
			),
			'website'     => array(
				'title' => __( 'Website', 'cpt-person' ),
				'type' => array(
					'acf'  => 'text',
					'cmb2' => 'text_url',
					'pods' => 'text',
				),
			),
//			'social'      => array( '_person_social', 'text' ), // repeater
//			'email'       => array( '_person_email', 'email' ), // repeater
		);

		return apply_filters( 'cpt_person_meta_fields', $meta_fields );

	}

	function register_meta() {

		if ( class_exists( 'Acf' ) || defined( 'PODS_VERSION' ) ) {
			return;
		}

		$meta_fields = self::meta_fields();

		foreach ( $meta_fields as $id => $value ) {

			// register_meta( $meta_type, $meta_key, $sanitize_callback, $auth_callback);
			register_meta( 'post', $value[0], 'esc_url_raw', '__return_true' );

		}

	}



} // END class CPT
