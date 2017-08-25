<?php
/**
 * @author    WPStore.io <code@wpstore.io>
 * @copyright Copyright (c) 2015-2017, WPStore.io
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GPL-2.0+
 * @package   WPStore\CPT\Person
 */

namespace WPStore\Plugins\Person;

/**
 * Register UI for the Meta Fields via ACF
 *
 * @since 0.0.1
 */
class ACF4 {

	/**
	 * Constructor. Hooks all interactions to initialize the class.
	 *
	 * @since 0.0.1
	 *
	 * @return void
	 */
	public static function init() {

	} // END __construct()

	/**
	 * Define the metabox and field configurations.
	 */
	public static function generate_fields() {

		if ( ! function_exists( 'register_field_group' ) ) {
			return;
			// @todo ERROR
		}

		$prefix = 'person_'; // non-standard!!
		$fields = \WPStore\Plugins\Person\CPT::meta_fields();

		foreach ( $fields as $field_id => $values ) {

			$field_details[] = array(
				'key' => 'field_' . $prefix . $field_id,
				'label' => $values['name'],
				'name' => $prefix . $field_id,
				'type' => $values['type']['acf'],
				'instructions' => $values['desc'],
				'default_value' => '',
				'placeholder' => $values['placeholder'],
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			);

		} // END foreach

		register_field_group( array(
			'id'		 => 'person_personal_details',//'acf_personal-details',
			'title'		 => __( 'Personal Details', 'cpt-person' ),//'Personal Details',
			'fields'	 => $field_details,
			'location'	 => array(
				array(
					array(
						'param'		 => 'post_type',
						'operator'	 => '==',
						'value'		 => 'person',
						'order_no'	 => 0,
						'group_no'	 => 0,
					),
				),
			),
			'options'	 => array(
				'position'		 => 'acf_after_title',
				'layout'		 => 'default',
				'hide_on_screen' => array(
				),
			),
			'menu_order' => 0,
		) );

	} // END
	public static function generate_fields2() {

		

		foreach ( $fields as $field_id => $values ) {

			$field_details[] = array(
				'key' => 'field_' . $prefix . $field_id,
				'label' => $values['name'],
				'name' => $prefix . $field_id,
				'type' => $values['type']['acf'],
				'instructions' => $values['desc'],
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			);

		} // END foreach

		/**
		 * Initiate the metabox
		 */
		register_field_group( array(
			'id'		 => 'person_personal_details',
			'title'		 => __( 'Personal Details', 'cpt-person' ),
			'fields'	 => array(
				$field_details,
//				$fields_temp,
			),
			'location'	 => array(
				array(
					array(
						'param'		 => 'post_type',
						'operator'	 => '==',
						'value'		 => 'person',
					),
				),
			),
			'options'	 => array(
				'position' => 'acf_after_title',
				'layout'   => 'default',
				'hide_on_screen' => array (
				),
			),
			'menu_order' => 0,
		) );

	} // END generate_fields()

} // END class ACF4
